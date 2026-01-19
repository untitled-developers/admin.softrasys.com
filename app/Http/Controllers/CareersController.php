<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Career;
use App\Models\CareerLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CareersController extends CrudController
{
    protected string $table = 'careers';
    protected string $modelClass = Career::class;
    protected string $languageModelClass = CareerLanguage::class;
    protected string $filesDirectory = 'careers';
    protected array $searchFields;
    protected bool $safeDelete = false;
    protected bool $validateLanguages = true;

    protected array $selectColumns = [
        'careers.id',
        'careers.type',
        'careers.is_hidden',
        'careers.sort_number',
        'careers.created_at',
        'careers.updated_at',
        'career_languages.job_title',
        'career_languages.short_description',
        'career_languages.job_description',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('careers.id', SearchTypes::$EXACT),
            SearchableField::create('career_languages.job_title', SearchTypes::$CONTAINS),
            SearchableField::create('careers.type', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            // Save main career fields
            $model->type = $data->type ?? "";
            $model->sort_number = $data->sort_number ?? 0;

            $model->save();

            // Handle language-specific fields
            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['job_title', 'short_description', 'job_description'],  // Changed field names
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
            ->leftJoin('career_languages', 'career_languages.career_id', '=', 'careers.id')
            ->leftJoin('languages', 'career_languages.language_id', '=', 'languages.id')
            ->where('career_languages.language_id', '=', 1); // Default to first language
    }

    public function getRecord(Career $career)
    {
        $languages = $career->languages->toArray();
        $career = $career->toArray();

        $career['languages'] = [];
        foreach ($languages as $language) {
            $career['languages'][$language['code']] = $language['pivot'];
        }
        return response()->json($career);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
