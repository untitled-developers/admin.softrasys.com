<?php

namespace App\Http\Controllers;

use App\Enums\ContactFormStatuses;
use App\Models\ContactForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
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
        'contact_forms.utm_source',
        'contact_forms.utm_campaign',
        'contact_forms.utm_medium',
        'contact_forms.utm_content',
        'contact_forms.referrer',
        'contact_forms.is_read',
        'contact_forms.admin_id',
        'contact_forms.status',
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
            SearchableField::create('contact_forms.utm_source', SearchTypes::$CONTAINS),
            SearchableField::create('contact_forms.utm_campaign', SearchTypes::$CONTAINS),
            SearchableField::create('contact_forms.status', SearchTypes::$EXACT),
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
        $model->utm_source = $data->utm_source ?? null;
        $model->utm_campaign = $data->utm_campaign ?? null;
        $model->utm_medium = $data->utm_medium ?? null;
        $model->utm_content = $data->utm_content ?? null;
        $model->referrer = $data->referrer ?? null;
        $model->admin_id = $data->admin_id ?? null;
        $model->save();

        return $model;
    }

    protected function builder(): Builder
    {
        return parent::builder();
    }

    public function getRecord(ContactForm $contactForm)
    {
        $contactForm->load('admin');
        return response()->json($contactForm->toArray());
    }

    public function toggleRead($id): JsonResponse
    {
        $model = $this->getModel($id);
        $model->is_read = !$model->is_read;
        $model->save();
        return response()->json($model);
    }

    public function toggleStatus(Request $request, $id): JsonResponse
    {
        $validStatuses = [
            ContactFormStatuses::INTAKE,
            ContactFormStatuses::QUALIFIED,
            ContactFormStatuses::CONVERTED,
            ContactFormStatuses::UNQUALIFIED,
        ];

        $status = $request->input('value');
        $field = $request->input('field');

        if ($field !== 'status') {
            return response()->json(['error' => 'Invalid field'], 422);
        }

        if (!in_array($status, $validStatuses)) {
            return response()->json(['error' => 'Invalid status'], 422);
        }

        $model = $this->getModel($id);
        $model->status = $status;
        $model->save();

        return response()->json($model);
    }
}
