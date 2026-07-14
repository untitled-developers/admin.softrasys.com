<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsFaq extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'gps_faq_languages')
            ->withPivot(['question', 'answer', 'gps_faq_id', 'language_id']);
    }
}
