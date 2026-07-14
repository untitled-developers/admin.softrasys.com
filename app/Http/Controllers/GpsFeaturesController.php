<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GpsFeature;
use App\Models\GpsFeatureLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpsFeaturesController extends CrudController
{
    protected string $table = 'gps_features';
    protected string $modelClass = GpsFeature::class;
    protected string $languageModelClass = GpsFeatureLanguage::class;
    protected string $filesDirectory = 'gps-features';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'gps_features.id',
        'gps_features.sort_number',
        'gps_features.is_hidden',
        'gps_features.created_at',
        'gps_features.updated_at',
        'gps_feature_languages.title',
        'gps_feature_languages.description',
        'blobs.url as blob_url',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('gps_features.id', SearchTypes::$EXACT),
            SearchableField::create('gps_feature_languages.title', SearchTypes::$CONTAINS),
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
            ->leftJoin('gps_feature_languages', 'gps_feature_languages.gps_feature_id', '=', 'gps_features.id')
            ->leftJoin('languages', 'gps_feature_languages.language_id', '=', 'languages.id')
            ->leftJoin('blobs', 'gps_features.blob_id', '=', 'blobs.id')
            ->where('gps_feature_languages.language_id', '=', 1);
    }

    public function getRecord(GpsFeature $gpsFeature)
    {
        $languages = $gpsFeature->languages->toArray();
        $gpsFeature = $gpsFeature->toArray();

        $gpsFeature['languages'] = [];
        foreach ($languages as $language) {
            $gpsFeature['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($gpsFeature);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
