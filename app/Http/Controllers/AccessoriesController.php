<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Accessory;
use App\Models\AccessoryLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Str;

class AccessoriesController extends CrudController
{
    protected string $table = 'accessories';
    protected string $modelClass = Accessory::class;
    protected string $languageModelClass = AccessoryLanguage::class;
    protected string $filesDirectory = 'accessories';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'accessories.id',
        'accessories.sort_number',
        'accessories.is_hidden',
        'accessories.slug',
        'accessories.btn_href',
        'accessories.created_at',
        'accessories.updated_at',
        'accessory_languages.name',
        'accessory_languages.short_description',
        'accessory_languages.long_description',
        'accessory_languages.btn_text',
        'accessory_languages.meta_description',
        'accessory_languages.promotion_text',
        'blobs.url as blob_url',
        'promotion_blobs.url as promotion_blob_url',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('accessories.id', SearchTypes::$EXACT),
            SearchableField::create('accessory_languages.name', SearchTypes::$CONTAINS),
            SearchableField::create('accessory_languages.short_description', SearchTypes::$CONTAINS),
            SearchableField::create('accessories.slug', SearchTypes::$CONTAINS),
            SearchableField::create('accessories.is_hidden', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->is_hidden = $data->is_hidden ?? false;
            $model->sort_number = $data->sort_number ?? 0;
            $model->btn_href = $data->btn_href ?? null;
            $slug = Str::slug($data->languages->en->name);
            $model->slug = $slug . '-' . $model->id;

            if ($request->file('promotion_image') != null)
                $this->updateBlob($request, $model, 'promotion_blob_id', 'promotion_image');


            $model->save();

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['name', 'short_description', 'long_description', 'btn_text', 'meta_description'],
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
            ->leftJoin('accessory_languages', 'accessory_languages.accessory_id', '=', 'accessories.id')
            ->leftJoin('languages', 'accessory_languages.language_id', '=', 'languages.id')
            ->leftJoin('blobs', 'accessories.blob_id', '=', 'blobs.id')
            ->leftJoin('blobs as promotion_blobs', 'accessories.promotion_blob_id', '=', 'promotion_blobs.id')
            ->where('accessory_languages.language_id', '=', 1);
    }

    public function getRecord(Accessory $accessory)
    {
        $languages = $accessory->languages->toArray();
        $accessory = $accessory->toArray();

        $accessory['languages'] = [];
        foreach ($languages as $language) {
            $accessory['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($accessory);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
