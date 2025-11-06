<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Solution;
use App\Models\SolutionLanguage;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SolutionsController extends CrudController
{
    protected string $table = 'solutions';
    protected string $modelClass = Solution::class;
    protected string $languageModelClass = SolutionLanguage::class;
    protected string $filesDirectory = 'solutions';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'solutions.id',
        'solutions.sort_number',
        'solutions.is_hidden',
        'solutions.slug',
        'solutions.btn_href',
        'solutions.meta_description',
        'solutions.created_at',
        'solutions.updated_at',
        'solution_languages.name',
        'solution_languages.short_description',
        'solution_languages.long_description',
        'solution_languages.btn_text',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('solutions.id', SearchTypes::$EXACT),
            SearchableField::create('solution_languages.name', SearchTypes::$CONTAINS),
            SearchableField::create('solution_languages.short_description', SearchTypes::$CONTAINS),
            SearchableField::create('solutions.slug', SearchTypes::$CONTAINS),
            SearchableField::create('solutions.is_hidden', SearchTypes::$EXACT),
        ];
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->blob_id = $data->blob_id ?? null;
            $model->is_hidden = $data->is_hidden ?? false;
            $model->sort_number = $data->sort_number ?? 0;
            $model->slug = $data->slug ?? 'any';
            $model->btn_href = $data->btn_href ?? null;
            $model->meta_description = $data->meta_description ?? null;

            $model->save();

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['name', 'short_description', 'long_description', 'btn_text'],
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
            ->leftJoin('solution_languages', 'solution_languages.solution_id', '=', 'solutions.id')
            ->leftJoin('languages', 'solution_languages.language_id', '=', 'languages.id')
            ->where('solution_languages.language_id', '=', 1);
    }

    public function getRecord(Solution $solution)
    {
        $languages = $solution->languages->toArray();
        $solution = $solution->toArray();

        $solution['languages'] = [];
        foreach ($languages as $language) {
            $solution['languages'][$language['code']] = $language['pivot'];
        }

        return response()->json($solution);
    }

    public function toggleHidden($id)
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();

        return response()->json($this->getModel($id));
    }
}
