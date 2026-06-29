<?php

namespace App\Http\Controllers;

use App\Enums\DemoRequestStatuses;
use App\Models\DemoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class DemoRequestsController extends CrudController
{
    protected string $table = 'demo_requests';
    protected string $modelClass = DemoRequest::class;
    protected string $filesDirectory = 'demo_requests';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'demo_requests.id',
        'demo_requests.name',
        'demo_requests.email',
        'demo_requests.phone',
        'demo_requests.company_name',
        'demo_requests.industry',
        'demo_requests.message',
        'demo_requests.utm_source',
        'demo_requests.utm_campaign',
        'demo_requests.utm_medium',
        'demo_requests.utm_content',
        'demo_requests.referrer',
        'demo_requests.is_read',
        'demo_requests.admin_id',
        'demo_requests.status',
        'demo_requests.created_at',
        'demo_requests.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('demo_requests.id', SearchTypes::$EXACT),
            SearchableField::create('demo_requests.name', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.email', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.phone', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.company_name', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.industry', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.message', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.utm_source', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.utm_campaign', SearchTypes::$CONTAINS),
            SearchableField::create('demo_requests.status', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->name = $data->name;
        $model->email = $data->email;
        $model->phone = $data->phone;
        $model->company_name = $data->company_name;
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

    public function getRecord(DemoRequest $demoRequest): JsonResponse
    {
        $demoRequest->load('admin');
        return response()->json($demoRequest->toArray());
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
            DemoRequestStatuses::INTAKE,
            DemoRequestStatuses::QUALIFIED,
            DemoRequestStatuses::CONVERTED,
            DemoRequestStatuses::UNQUALIFIED,
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
