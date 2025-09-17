<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends BaseModel
{
    protected $guarded = [];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'testimonial_languages');
    }
}
