<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Solution extends BaseModel
{
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'solution_languages', 'solution_id', 'language_id')
            ->withPivot(['name', 'short_description', 'long_description', 'btn_text','meta_description','promotion_text'])
            ->withTimestamps();
    }

    public function blob()
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }

    public function solutionCategory(): BelongsTo
    {
        return $this->belongsTo(SolutionCategory::class, 'solution_category_id');
    }
}
