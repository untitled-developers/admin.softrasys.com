<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Career extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'career_languages')
            ->withPivot([
                'job_title',
                'job_description',
                'career_id',
                'language_id',
            ])
            ->using(CareerLanguage::class);
    }
}
