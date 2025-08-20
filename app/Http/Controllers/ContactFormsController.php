<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ContactForm;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class ContactFormsController extends CrudController
{
    protected string $table = 'contact_forms';
    protected string $modelClass = ContactForm::class;
    protected string $filesDirectory = 'contact-forms';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'contact_forms.id',
        'contact_forms.name',
        'contact_forms.email',
        'contact_forms.industry',
        'contact_forms.phone_number',
        'contact_forms.number_of_vehicles',
        'contact_forms.country',
        'contact_forms.message',
        'contact_forms.created_at',
        'contact_forms.updated_at',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('contact_forms.id', SearchTypes::$EXACT),
            SearchableField::create('contact_forms.name', SearchTypes::$CONTAINS),
            SearchableField::create('contact_forms.email', SearchTypes::$CONTAINS),
            SearchableField::create('contact_forms.phone_number', SearchTypes::$CONTAINS),
            SearchableField::create('contact_forms.industry', SearchTypes::$CONTAINS),
            SearchableField::create('contact_forms.country', SearchTypes::$CONTAINS),
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

        $model->save();
        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder();
    }
}

