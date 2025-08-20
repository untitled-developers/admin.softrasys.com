<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Career;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class CareersController extends CrudController
{
    protected string $table = 'careers';
    protected string $modelClass = Career::class;
    protected string $filesDirectory = 'careers';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'careers.id',
        'careers.title',
        'careers.short_description',
        'careers.type',
        'careers.description',
        'careers.is_hidden',
        'careers.sort_number',
        'careers.created_at',
        'careers.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('careers.id', SearchTypes::$EXACT),
            SearchableField::create('careers.title', SearchTypes::$CONTAINS),
            SearchableField::create('careers.short_description', SearchTypes::$CONTAINS),
            SearchableField::create('careers.type', SearchTypes::$EXACT),
            SearchableField::create('careers.is_hidden', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->title = $data->title ?? "";
        $model->short_description = $data->short_description ?? "";
        $model->type = $data->type ?? "";
        $model->description = $data->description ?? null;
        $model->sort_number = $data->sort_number ?? 0;

        $model->save();
        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder();
    }
    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
