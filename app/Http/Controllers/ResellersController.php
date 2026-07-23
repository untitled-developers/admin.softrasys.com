<?php

namespace App\Http\Controllers;

use App\Enums\ResellerFormStatuses;
use App\Models\Reseller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class ResellersController extends CrudController
{
    protected string $table = 'resellers';
    protected string $modelClass = Reseller::class;
    protected string $filesDirectory = 'resellers';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'resellers.id',
        'resellers.name',
        'resellers.email',
        'resellers.phone',
        'resellers.company_name',
        'resellers.website',
        'resellers.industry',
        'resellers.message',
        'resellers.utm_source',
        'resellers.utm_campaign',
        'resellers.utm_medium',
        'resellers.utm_content',
        'resellers.referrer',
        'resellers.is_read',
        'resellers.admin_id',
        'resellers.status',
        'resellers.created_at',
        'resellers.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('resellers.id', SearchTypes::$EXACT),
            SearchableField::create('resellers.name', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.email', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.phone', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.company_name', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.website', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.industry', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.message', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.utm_source', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.utm_campaign', SearchTypes::$CONTAINS),
            SearchableField::create('resellers.status', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->name = $data->name;
        $model->email = $data->email;
        $model->phone = $data->phone;
        $model->company_name = $data->company_name;
        $model->website = $data->website ?? null;
        $model->industry = $data->industry ?? null;
        $model->message = $data->message ?? null;
        $model->utm_source = $data->utm_source ?? null;
        $model->utm_campaign = $data->utm_campaign ?? null;
        $model->utm_medium = $data->utm_medium ?? null;
        $model->utm_content = $data->utm_content ?? null;
        $model->referrer = $data->referrer ?? null;
        $model->admin_id = $data->admin_id ?? null;

        $model->save();
        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder();
    }

    public function getRecord(Reseller $reseller): JsonResponse
    {
        $reseller->load('admin');
        return response()->json($reseller->toArray());
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
            ResellerFormStatuses::INTAKE,
            ResellerFormStatuses::QUALIFIED,
            ResellerFormStatuses::CONVERTED,
            ResellerFormStatuses::UNQUALIFIED,
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
