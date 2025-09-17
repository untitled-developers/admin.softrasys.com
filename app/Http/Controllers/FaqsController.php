<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Faq;
use App\Models\FaqLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class FaqsController extends CrudController
{
    protected string $table = 'faqs';
    protected string $modelClass = Faq::class;
    protected string $languageModelClass = FaqLanguage::class;
    protected string $filesDirectory = 'faqs';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'faqs.id',
        'faqs.sort_number',
        'faqs.is_hidden',
        'faqs.created_at',
        'faqs.updated_at',
        'faq_languages.question',
        'faq_languages.answer',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('faqs.id', SearchTypes::$EXACT),
            SearchableField::create('faq_languages.question', SearchTypes::$CONTAINS),
            SearchableField::create('faq_languages.answer', SearchTypes::$CONTAINS),
            SearchableField::create('faqs.sort_number', SearchTypes::$EXACT),
            SearchableField::create('faqs.is_hidden', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->sort_number = $data->sort_number ?? 0;
            $model->save();

            // Handle language-specific fields
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
            ->leftJoin('faq_languages', 'faq_languages.faq_id', '=', 'faqs.id')
            ->leftJoin('languages', 'faq_languages.language_id', '=', 'languages.id')
            ->where('faq_languages.language_id', '=', 1); // Default language
    }

    public function getRecord(Faq $faq)
    {
        $languages = $faq->languages->toArray();
        $faq = $faq->toArray();

        $faq['languages'] = [];
        foreach ($languages as $language) {
            $faq['languages'][$language['code']] = $language['pivot'];
        }
        return response()->json($faq);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
