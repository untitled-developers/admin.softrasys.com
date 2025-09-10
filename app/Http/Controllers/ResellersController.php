<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Reseller;
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

        $model->save();
        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder();
    }
}
