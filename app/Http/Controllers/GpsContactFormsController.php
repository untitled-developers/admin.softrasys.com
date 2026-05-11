<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GpsContactForm;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsContactFormsController extends CrudController
{
    protected string $table = 'gps_contact_forms';
    protected string $modelClass = GpsContactForm::class;
    protected string $filesDirectory = 'gps-contact-forms';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'gps_contact_forms.id',
        'gps_contact_forms.name',
        'gps_contact_forms.email',
        'gps_contact_forms.industry',
        'gps_contact_forms.phone_number',
        'gps_contact_forms.number_of_vehicles',
        'gps_contact_forms.country',
        'gps_contact_forms.message',
        'gps_contact_forms.created_at',
        'gps_contact_forms.updated_at',
        'gps_contact_forms.source',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('gps_contact_forms.id', SearchTypes::$EXACT),
            SearchableField::create('gps_contact_forms.name', SearchTypes::$CONTAINS),
            SearchableField::create('gps_contact_forms.email', SearchTypes::$CONTAINS),
            SearchableField::create('gps_contact_forms.phone_number', SearchTypes::$CONTAINS),
            SearchableField::create('gps_contact_forms.industry', SearchTypes::$CONTAINS),
            SearchableField::create('gps_contact_forms.country', SearchTypes::$CONTAINS),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        $data = $this->initSaveModel($request, $model);

        $model->name = $data->name;
        $model->email = $data->email;
        $model->industry = $data->industry ?? null;
        $model->phone_number = $data->phone_number;
        $model->number_of_vehicles = $data->number_of_vehicles ?? 0;
        $model->country = $data->country ?? null;
        $model->message = $data->message ?? null;
        $model->source = $data->source ?? null;

        $model->save();
        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder();
    }
}