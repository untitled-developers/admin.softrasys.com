<?php

namespace App\Http\Controllers;


use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class LanguagesController extends CrudController
{
    protected string $table = 'languages';
    protected string $modelClass = Language::class;
    protected string $filesDirectory = 'languages';
    protected array $searchFields;
    protected bool $safeDelete = false;
    protected array $selectColumns = [
        'languages.id',
        'languages.name',
        'languages.code',
        'languages.created_at',
        'languages.updated_at',
    ];

    #[Pure]
    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('languages.name', SearchTypes::$CONTAINS),
            SearchableField::create('languages.code', SearchTypes::$CONTAINS),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);
        $model->name = $data->name;
        $model->code = $data->code;
        $model->save();
        return $model;
    }

    protected function builder(): Builder
    {
        return
            parent::builder()
    }


}
