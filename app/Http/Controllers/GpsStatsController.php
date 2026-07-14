<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GpsStat;
use App\Models\GpsStatLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpsStatsController extends CrudController
{
    protected string $table = 'gps_stats';
    protected string $modelClass = GpsStat::class;
    protected string $languageModelClass = GpsStatLanguage::class;
    protected string $filesDirectory = 'gps-stats';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'gps_stats.id',
        'gps_stats.value',
        'gps_stats.suffix',
        'gps_stats.sort_number',
        'gps_stats.is_hidden',
        'gps_stats.created_at',
        'gps_stats.updated_at',
        'gps_stat_languages.title',
        'gps_stat_languages.subtitle',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('gps_stats.id', SearchTypes::$EXACT),
            SearchableField::create('gps_stat_languages.title', SearchTypes::$CONTAINS),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->value = $data->value ?? 0;
            $model->suffix = $data->suffix ?? null;
            $model->is_hidden = $data->is_hidden ?? false;
            $model->sort_number = $data->sort_number ?? 0;
            $model->save();

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['title', 'subtitle'],
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
            ->leftJoin('gps_stat_languages', 'gps_stat_languages.gps_stat_id', '=', 'gps_stats.id')
            ->leftJoin('languages', 'gps_stat_languages.language_id', '=', 'languages.id')
            ->where('gps_stat_languages.language_id', '=', 1);
    }

    public function getRecord(GpsStat $gpsStat)
    {
        $languages = $gpsStat->languages->toArray();
        $gpsStat = $gpsStat->toArray();

        $gpsStat['languages'] = [];
        foreach ($languages as $language) {
            $gpsStat['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($gpsStat);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
