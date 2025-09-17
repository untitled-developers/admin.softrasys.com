<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class TestimonialLanguage extends Pivot
{
    protected $table = 'testimonial_languages';

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
