<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Testimonial;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class TestimonialsController extends CrudController
{
    protected string $table = 'testimonials';
    protected string $modelClass = Testimonial::class;
    protected string $filesDirectory = 'testimonials';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'testimonials.id',
        'testimonials.name',
        'testimonials.description',
        'testimonials.sort_number',
        'testimonials.is_hidden',
        'testimonials.created_at',
        'testimonials.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('testimonials.id', SearchTypes::$EXACT),
            SearchableField::create('testimonials.name', SearchTypes::$CONTAINS),
            SearchableField::create('testimonials.description',SearchTypes::$CONTAINS),
            SearchableField::create('testimonials.sort_number',SearchTypes::$EXACT),
            SearchableField::create('testimonials.is_hidden', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->name = $data->name;
        $model->description = $data->description ?? null;
        $model->sort_number = $data->sort_number ?? 0;
        $model->is_hidden = $data->is_hidden ?? false;

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
