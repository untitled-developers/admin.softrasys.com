<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Faq extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'faq_languages')
            ->withPivot(['question', 'answer', 'faq_id', 'language_id']);
    }
}
