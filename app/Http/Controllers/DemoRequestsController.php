<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\DemoRequest;
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

        $model->save();
        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder();
    }
}
