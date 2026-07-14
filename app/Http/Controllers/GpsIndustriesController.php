<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GpsIndustry;
use App\Models\GpsIndustryLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpsIndustriesController extends CrudController
{
    protected string $table = 'gps_industries';
    protected string $modelClass = GpsIndustry::class;
    protected string $languageModelClass = GpsIndustryLanguage::class;
    protected string $filesDirectory = 'gps-industries';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'gps_industries.id',
        'gps_industries.sort_number',
        'gps_industries.is_hidden',
        'gps_industries.created_at',
        'gps_industries.updated_at',
        'gps_industry_languages.title',
        'gps_industry_languages.description',
        'blobs.url as blob_url',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('gps_industries.id', SearchTypes::$EXACT),
            SearchableField::create('gps_industry_languages.title', SearchTypes::$CONTAINS),
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
                    ['title', 'description'],
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
            ->leftJoin('gps_industry_languages', 'gps_industry_languages.gps_industry_id', '=', 'gps_industries.id')
            ->leftJoin('languages', 'gps_industry_languages.language_id', '=', 'languages.id')
            ->leftJoin('blobs', 'gps_industries.blob_id', '=', 'blobs.id')
            ->where('gps_industry_languages.language_id', '=', 1);
    }

    public function getRecord(GpsIndustry $gpsIndustry)
    {
        $languages = $gpsIndustry->languages->toArray();
        $gpsIndustry = $gpsIndustry->toArray();

        $gpsIndustry['languages'] = [];
        foreach ($languages as $language) {
            $gpsIndustry['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($gpsIndustry);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
