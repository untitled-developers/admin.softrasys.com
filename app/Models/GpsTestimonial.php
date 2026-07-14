<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsTestimonial extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'gps_testimonial_languages')
            ->withPivot(['name', 'text', 'gps_testimonial_id', 'language_id']);
    }
}
