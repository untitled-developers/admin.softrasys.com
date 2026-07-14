<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsFeature extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'gps_feature_languages')
            ->withPivot(['title', 'description', 'gps_feature_id', 'language_id']);
    }

    public function blob(): BelongsTo
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }
}
