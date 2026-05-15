<?php

namespace App\Models;

use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Partner extends BaseModel
{
    public function blob()
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }
}
