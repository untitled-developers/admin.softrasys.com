<?php

namespace App\Http\Controllers;

use App\Enums\CareerFormStatuses;
use App\Models\CareerForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class CareerFormsController extends CrudController
{
    protected string $table = 'career_forms';
    protected string $modelClass = CareerForm::class;
    protected string $filesDirectory = 'career-forms';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'career_forms.id',
        'career_forms.name',
        'career_forms.email',
        'career_forms.phone_number',
        'career_forms.blob_id',
        'blobs.url as blob_url',
        'career_forms.utm_source',
        'career_forms.utm_campaign',
        'career_forms.utm_medium',
        'career_forms.utm_content',
        'career_forms.referrer',
        'career_forms.is_read',
        'career_forms.admin_id',
        'career_forms.status',
        'career_forms.created_at',
        'career_forms.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('career_forms.id', SearchTypes::$EXACT),
            SearchableField::create('career_forms.name', SearchTypes::$CONTAINS),
            SearchableField::create('career_forms.email', SearchTypes::$CONTAINS),
            SearchableField::create('career_forms.phone_number', SearchTypes::$CONTAINS),
            SearchableField::create('career_forms.utm_source', SearchTypes::$CONTAINS),
            SearchableField::create('career_forms.utm_campaign', SearchTypes::$CONTAINS),
            SearchableField::create('career_forms.status', SearchTypes::$EXACT),
        ];
    }

    protected function builder(): Builder
    {
        return parent::builder()
            ->leftJoin('blobs', 'career_forms.blob_id', '=', 'blobs.id');
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->name = $data->name;
        $model->email = $data->email;
        $model->phone_number = $data->phone_number;
        $model->utm_source = $data->utm_source ?? null;
        $model->utm_campaign = $data->utm_campaign ?? null;
        $model->utm_medium = $data->utm_medium ?? null;
        $model->utm_content = $data->utm_content ?? null;
        $model->referrer = $data->referrer ?? null;
        $model->admin_id = $data->admin_id ?? null;
        $model->save();

        if ($request->file('file') != null) {
            $this->updateBlob($request, $model, 'blob_id', 'file', isImage: false, keepName: true);
            $model->save();
        }

        return $model;
    }

    public function getRecord(CareerForm $careerForm)
    {
        $careerForm->load('blob');
        $careerForm->load('admin');
        return response()->json($careerForm->toArray());
    }

    public function toggleRead($id): JsonResponse
    {
        $model = $this->getModel($id);
        $model->is_read = !$model->is_read;
        $model->save();
        return response()->json($model);
    }

    public function toggleStatus(Request $request, $id): JsonResponse
    {
        $validStatuses = [
            CareerFormStatuses::INTAKE,
            CareerFormStatuses::QUALIFIED,
            CareerFormStatuses::CONVERTED,
            CareerFormStatuses::UNQUALIFIED,
        ];

        $status = $request->input('value');
        $field = $request->input('field');

        if ($field !== 'status') {
            return response()->json(['error' => 'Invalid field'], 422);
        }

        if (!in_array($status, $validStatuses)) {
            return response()->json(['error' => 'Invalid status'], 422);
        }

        $model = $this->getModel($id);
        $model->status = $status;
        $model->save();

        return response()->json($model);
    }
}
