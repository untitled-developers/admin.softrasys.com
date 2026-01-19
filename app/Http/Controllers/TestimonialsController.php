<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Testimonial;
use App\Models\TestimonialLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestimonialsController extends CrudController
{
    protected string $table = 'testimonials';
    protected string $modelClass = Testimonial::class;
    protected string $languageModelClass = TestimonialLanguage::class;
    protected string $filesDirectory = 'testimonials';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'testimonials.id',
        'testimonials.sort_number',
        'testimonials.is_hidden',
        'testimonials.created_at',
        'testimonials.updated_at',
        'testimonial_languages.name',
        'testimonial_languages.description',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('testimonials.id', SearchTypes::$EXACT),
            SearchableField::create('testimonial_languages.name', SearchTypes::$CONTAINS),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->sort_number = $data->sort_number ?? 0;
            $model->save();

            // Handle language-specific fields
            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['name', 'description'],
                    json_decode(json_encode($data->languages), true),
                    $model->id,
                );
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            Log::error($exception);
            throw $exception;
        }

        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder()
            ->leftJoin('testimonial_languages', 'testimonial_languages.testimonial_id', '=', 'testimonials.id')
            ->leftJoin('languages', 'testimonial_languages.language_id', '=', 'languages.id')
            ->where('testimonial_languages.language_id', '=', 1); // Default language
    }

    public function getRecord(Testimonial $testimonial)
    {
        $languages = $testimonial->languages->toArray();
        $testimonial = $testimonial->toArray();

        $testimonial['languages'] = [];
        foreach ($languages as $language) {
            $testimonial['languages'][$language['code']] = $language['pivot'];
        }
        return response()->json($testimonial);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
