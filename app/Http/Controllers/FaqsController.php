<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Faq;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class FaqsController extends CrudController
{
    protected string $table = 'faqs';
    protected string $modelClass = Faq::class;
    protected string $filesDirectory = 'faqs';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'faqs.id',
        'faqs.question',
        'faqs.answer',
        'faqs.sort_number',
        'faqs.is_hidden',
        'faqs.created_at',
        'faqs.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('faqs.id', SearchTypes::$EXACT),
            SearchableField::create('faqs.question', SearchTypes::$CONTAINS),
            SearchableField::create('faqs.answer', SearchTypes::$CONTAINS),
            SearchableField::create('faqs.sort_number', SearchTypes::$EXACT),
            SearchableField::create('faqs.is_hidden', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->question = $data->question ?? null;
        $model->answer = $data->answer ?? null;
        $model->sort_number = $data->sort_number;;

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
