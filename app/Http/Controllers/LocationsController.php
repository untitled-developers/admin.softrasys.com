<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class LocationsController extends CrudController
{
    protected string $table = 'locations';
    protected string $modelClass = Location::class;
    protected string $filesDirectory = 'locations';
    protected array  $searchFields;
    protected bool   $safeDelete = false;

    protected array $selectColumns = [
        'locations.id',
        'locations.name',
        'locations.sort_number',
        'locations.address',
        'locations.email',
        'locations.phone_number',
        'locations.fax_number',
        'locations.support_number',
        'locations.is_hidden',
        'locations.location_link',
        'locations.created_at',
        'locations.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('locations.id',SearchTypes::$EXACT),
            SearchableField::create('locations.name', SearchTypes::$CONTAINS),
            SearchableField::create('locations.email', SearchTypes::$CONTAINS),
            SearchableField::create('locations.phone_number', SearchTypes::$CONTAINS),
            SearchableField::create('locations.address', SearchTypes::$CONTAINS),
        ];
    }

    /**
     * Create/Update handler
     */
    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->name = $data->name;
        $model->sort_number  = $data->sort_number ?? 0;
        $model->address = $data->address  ?? null;;
        $model->email = $data->email ?? null;
        $model->phone_number = $data->phone_number ?? null;;
        $model->fax_number = $data->fax_number ?? null;;
        $model->support_number= $data->support_number ?? null;;
        $model->location_link = $data->location_link ?? null;;

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
