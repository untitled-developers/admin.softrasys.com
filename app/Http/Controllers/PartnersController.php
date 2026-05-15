<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerLanguage;
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

class PartnersController extends CrudController
{
    protected string $table = 'partners';
    protected string $modelClass = Partner::class;
    protected string $languageModelClass = PartnerLanguage::class;
    protected string $filesDirectory = 'partners';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'partners.id',
        'partners.blob_id',
        'blobs.url as blob_url',
        'partners.sort_number',
        'partners.is_hidden',
        'partners.created_at',
        'partners.updated_at',
        'partner_languages.name',
        'partner_languages.short_description',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('partners.id', SearchTypes::$EXACT),
            SearchableField::create('partner_languages.name', SearchTypes::$CONTAINS),
            SearchableField::create('partner_languages.short_description', SearchTypes::$CONTAINS),
        ];
    }

    protected function builder(): Builder
    {
        return parent::builder()
            ->leftJoin('partner_languages', 'partner_languages.partner_id', '=', 'partners.id')
            ->leftJoin('languages', 'partner_languages.language_id', '=', 'languages.id')
            ->leftJoin('blobs', 'partners.blob_id', '=', 'blobs.id')
            ->where('partner_languages.language_id', '=', 1);
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->sort_number = $data->sort_number ?? 0;
            $model->save();

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['name', 'short_description'],
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

    public function getRecord(Partner $partner)
    {
        $languages = $partner->languages->toArray();
        $partner->load('blob');

        $partner = $partner->toArray();

        $partner['languages'] = [];
        foreach ($languages as $language) {
            if (isset($language['code'])) {
                $partner['languages'][$language['code']] = $language['pivot'];
            }
        }

        return response()->json($partner);
    }

    public function toggleHidden($id): JsonResponse
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();
        return response()->json($model);
    }
}
