<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GpsTestimonial;
use App\Models\GpsTestimonialLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpsTestimonialsController extends CrudController
{
    protected string $table = 'gps_testimonials';
    protected string $modelClass = GpsTestimonial::class;
    protected string $languageModelClass = GpsTestimonialLanguage::class;
    protected string $filesDirectory = 'gps-testimonials';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'gps_testimonials.id',
        'gps_testimonials.sort_number',
        'gps_testimonials.is_hidden',
        'gps_testimonials.created_at',
        'gps_testimonials.updated_at',
        'gps_testimonial_languages.name',
        'gps_testimonial_languages.text',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('gps_testimonials.id', SearchTypes::$EXACT),
            SearchableField::create('gps_testimonial_languages.name', SearchTypes::$CONTAINS),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->is_hidden = $data->is_hidden ?? false;
            $model->sort_number = $data->sort_number ?? 0;
            $model->save();

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['name', 'text'],
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
            ->leftJoin('gps_testimonial_languages', 'gps_testimonial_languages.gps_testimonial_id', '=', 'gps_testimonials.id')
            ->leftJoin('languages', 'gps_testimonial_languages.language_id', '=', 'languages.id')
            ->where('gps_testimonial_languages.language_id', '=', 1);
    }

    public function getRecord(GpsTestimonial $gpsTestimonial)
    {
        $languages = $gpsTestimonial->languages->toArray();
        $gpsTestimonial = $gpsTestimonial->toArray();

        $gpsTestimonial['languages'] = [];
        foreach ($languages as $language) {
            $gpsTestimonial['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($gpsTestimonial);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
