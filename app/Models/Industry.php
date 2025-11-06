<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Industry extends BaseModel
{
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'industry_languages', 'industry_id', 'language_id')
            ->withPivot(['name', 'short_description', 'long_description', 'btn_text', 'meta_description'])
            ->withTimestamps();
    }

    public function blob()
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }
}
