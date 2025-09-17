<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Language extends BaseModel
{
    protected $guarded = [];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'testimonial_languages');
    }
}
