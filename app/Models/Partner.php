<?php

namespace App\Models;

use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Partner extends BaseModel
{
    public function blob()
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }

        public function languages()
    {
        return $this->belongsToMany(Language::class, 'partner_languages', 'partner_id', 'language_id')
            ->withPivot(['name', 'short_description'])
            ->withTimestamps();
    }
}
