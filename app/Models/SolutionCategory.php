<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class SolutionCategory extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'solution_category_languages')
            ->withPivot('name', 'description')
            ->withTimestamps();
    }

    public function solutions(): HasMany
    {
        return $this->hasMany(Solution::class, 'solution_category_id');
    }
}
