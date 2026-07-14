<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GpsScreenshot;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpsScreenshotsController extends CrudController
{
    protected string $table = 'gps_screenshots';
    protected string $modelClass = GpsScreenshot::class;
    protected string $filesDirectory = 'gps-screenshots';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'gps_screenshots.id',
        'gps_screenshots.sort_number',
        'gps_screenshots.is_hidden',
        'gps_screenshots.created_at',
        'gps_screenshots.updated_at',
        'blobs.url as blob_url',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('gps_screenshots.id', SearchTypes::$EXACT),
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
            ->leftJoin('blobs', 'gps_screenshots.blob_id', '=', 'blobs.id');
    }

    public function getRecord(GpsScreenshot $gpsScreenshot)
    {
        $gpsScreenshot->load('blob');
        $data = $gpsScreenshot->toArray();
        $data['blob_url'] = $gpsScreenshot->blob->url ?? null;

        return response()->json($data);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
