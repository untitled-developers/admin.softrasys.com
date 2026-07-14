<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsScreenshot extends BaseModel
{
    public function blob(): BelongsTo
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }
}
