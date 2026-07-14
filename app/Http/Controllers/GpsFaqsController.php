<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\GpsFaq;
use App\Models\GpsFaqLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpsFaqsController extends CrudController
{
    protected string $table = 'gps_faqs';
    protected string $modelClass = GpsFaq::class;
    protected string $languageModelClass = GpsFaqLanguage::class;
    protected string $filesDirectory = 'gps-faqs';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'gps_faqs.id',
        'gps_faqs.sort_number',
        'gps_faqs.is_hidden',
        'gps_faqs.created_at',
        'gps_faqs.updated_at',
        'gps_faq_languages.question',
        'gps_faq_languages.answer',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('gps_faqs.id', SearchTypes::$EXACT),
            SearchableField::create('gps_faq_languages.question', SearchTypes::$CONTAINS),
            SearchableField::create('gps_faq_languages.answer', SearchTypes::$CONTAINS),
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

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['question', 'answer'],
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
            ->leftJoin('gps_faq_languages', 'gps_faq_languages.gps_faq_id', '=', 'gps_faqs.id')
            ->leftJoin('languages', 'gps_faq_languages.language_id', '=', 'languages.id')
            ->where('gps_faq_languages.language_id', '=', 1);
    }

    public function getRecord(GpsFaq $gpsFaq)
    {
        $languages = $gpsFaq->languages->toArray();
        $gpsFaq = $gpsFaq->toArray();

        $gpsFaq['languages'] = [];
        foreach ($languages as $language) {
            $gpsFaq['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($gpsFaq);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
