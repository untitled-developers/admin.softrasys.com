<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Industry;
use App\Models\IndustryLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Str;

class IndustriesController extends CrudController
{
    protected string $table = 'industries';
    protected string $modelClass = Industry::class;
    protected string $languageModelClass = IndustryLanguage::class;
    protected string $filesDirectory = 'industries';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'industries.id',
        'industries.sort_number',
        'industries.is_hidden',
        'industries.slug',
        'industries.btn_href',
        'industries.created_at',
        'industries.updated_at',
        'industry_languages.name',
        'industry_languages.short_description',
        'industry_languages.long_description',
        'industry_languages.btn_text',
        'industry_languages.meta_description',
        'blobs.url as blob_url',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('industries.id', SearchTypes::$EXACT),
            SearchableField::create('industry_languages.name', SearchTypes::$CONTAINS),
            SearchableField::create('industry_languages.short_description', SearchTypes::$CONTAINS),
            SearchableField::create('industries.slug', SearchTypes::$CONTAINS),
            SearchableField::create('industries.is_hidden', SearchTypes::$EXACT),
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
            $slug = \Str::slug($data->languages->en->name);
            $model->slug = $slug . '-' . $model->id;

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
            ->leftJoin('industry_languages', 'industry_languages.industry_id', '=', 'industries.id')
            ->leftJoin('languages', 'industry_languages.language_id', '=', 'languages.id')
            ->leftJoin('blobs', 'industries.blob_id', '=', 'blobs.id')
            ->where('industry_languages.language_id', '=', 1);
    }

    public function getRecord(Industry $industry)
    {
        $languages = $industry->languages->toArray();
        $industry = $industry->toArray();

        $industry['languages'] = [];
        foreach ($languages as $language) {
            $industry['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($industry);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
