<?php

namespace App\Http\Controllers;

use App\Models\SolutionCategory;
use App\Models\SolutionCategoryLanguage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\CrudController;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchableField;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\CRUD\SearchTypes;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class SolutionCategoriesController extends CrudController
{
    protected string $table = 'solution_categories';
    protected string $modelClass = SolutionCategory::class;
    protected string $languageModelClass = SolutionCategoryLanguage::class;
    protected string $filesDirectory = 'solution-categories';
    protected array $searchFields;
    protected bool $safeDelete = false;

    protected array $selectColumns = [
        'solution_categories.id',
        'solution_categories.slug',
        'solution_categories.sort_number',
        'solution_categories.is_hidden',
        'solution_categories.is_header_menu',
        'solution_categories.is_featured',
        'solution_categories.created_at',
        'solution_categories.updated_at',
        'solution_category_languages.name',
        'solution_category_languages.description',
    ];

    public function __construct()
    {
        $this->searchFields = [
            SearchableField::create('solution_categories.id', SearchTypes::$EXACT),
            SearchableField::create('solution_category_languages.name', SearchTypes::$CONTAINS),
            SearchableField::create('solution_category_languages.description', SearchTypes::$CONTAINS),
        ];
    }

    protected function builder(): Builder
    {
        return parent::builder()
            ->leftJoin('solution_category_languages', 'solution_category_languages.solution_category_id', '=', 'solution_categories.id')
            ->leftJoin('languages', 'solution_category_languages.language_id', '=', 'languages.id')
            ->where('solution_category_languages.language_id', '=', 1);
    }

    protected function saveModel(Request $request, BaseModel $model, bool $isNew): BaseModel
    {
        try {
            DB::beginTransaction();

            $data = $this->initSaveModel($request, $model);

            $model->slug = Str::slug($data->languages->en->name);
            $model->sort_number = $data->sort_number ?? 0;
            $model->is_header_menu = $data->is_header_menu ?? true;
            $model->save();

            $model->slug = Str::slug($data->languages->en->name) . '-' . $model->id;
            $model->save();

            if (property_exists($data, 'languages')) {
                $this->updateLanguages(
                    ['name', 'description'],
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

    public function getRecord(SolutionCategory $solutionCategory)
    {
        $languages = $solutionCategory->languages->toArray();
        $solutionCategory = $solutionCategory->toArray();

        $solutionCategory['languages'] = [];
        foreach ($languages as $language) {
            if (isset($language['code'])) {
                $solutionCategory['languages'][$language['code']] = $language['pivot'];
            }
        }

        return response()->json($solutionCategory);
    }

    public function toggleHidden($id): JsonResponse
    {
        $model = $this->getModel($id);
        $model->is_hidden = !$model->is_hidden;
        $model->save();
        return response()->json($model);
    }

    public function toggleHeaderMenu($id): JsonResponse
    {
        $model = $this->getModel($id);
        $model->is_header_menu = !$model->is_header_menu;
        $model->save();
        return response()->json($model);
    }

    public function toggleFeatured($id): JsonResponse
    {
        $model = $this->getModel($id);
        $model->is_featured = !$model->is_featured;
        $model->save();
        return response()->json($model);
    }
}
