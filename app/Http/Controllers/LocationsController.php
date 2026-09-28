<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\LocationLanguage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class LocationsController extends CrudController
{
    protected string $table = 'locations';
    protected string $modelClass = Location::class;
    protected string $languageModelClass = LocationLanguage::class;
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'locations.id',
        'locations.sort_number',
        'locations.email',
        'locations.phone_number',
        'locations.fax_number',
        'locations.support_number',
        'locations.latitude',
        'locations.longitude',
        'locations.location_link',
        'locations.is_hidden',
        'locations.created_at',
        'locations.updated_at',
        'location_languages.name',
        'location_languages.address',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('locations.id', SearchTypes::$EXACT),
            SearchableField::create('location_languages.name', SearchTypes::$CONTAINS),
            SearchableField::create('location_languages.address', SearchTypes::$CONTAINS),
            SearchableField::create('locations.email', SearchTypes::$CONTAINS),
            SearchableField::create('locations.phone_number', SearchTypes::$CONTAINS),
            SearchableField::create('locations.longitude', SearchTypes::$CONTAINS),
            SearchableField::create('locations.latitude', SearchTypes::$CONTAINS),
        ];
    }

    protected function builder(): Builder
    {
        return parent::builder()
            ->leftJoin('location_languages', 'location_languages.location_id', '=', 'locations.id')
            ->leftJoin('languages', 'location_languages.language_id', '=', 'languages.id')
            ->where('location_languages.language_id', '=', 1);
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->sort_number = $data->sort_number ?? 0;
            $model->email = $data->email ?? null;
            $model->phone_number = $data->phone_number ?? null;
            $model->fax_number = $data->fax_number ?? null;
            $model->support_number = $data->support_number ?? null;
            $model->latitude = $data->latitude ?? null;
            $model->longitude = $data->longitude ?? null;
            $model->location_link = $data->location_link ?? null;
            $model->save();

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['name', 'address'],
                    json_decode(json_encode($data->languages), true),
                    $model->id
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

    public function getRecord(Location $location)
    {
        $languages = $location->languages->toArray();

        $location = $location->toArray();

        $location['languages'] = [];
        foreach ($languages as $language) {
            if (isset($language['code'])) {
                $location['languages'][$language['code']] = $language['pivot'];
            }
        }

        return response()->json($location);
    }

    public function toggleHidden($id): JsonResponse
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();
        return response()->json($model);
    }
}
