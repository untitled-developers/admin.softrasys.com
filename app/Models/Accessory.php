<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Accessory extends BaseModel
{
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'accessory_languages', 'accessory_id', 'language_id')
            ->withPivot(['name', 'short_description', 'long_description', 'btn_text', 'meta_description'])
            ->withTimestamps();
    }

    public function blob()
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }
}
