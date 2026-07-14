<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsIndustry extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'gps_industry_languages')
            ->withPivot(['title', 'description', 'gps_industry_id', 'language_id']);
    }

    public function blob(): BelongsTo
    {
        return $this->belongsTo(Blob::class, 'blob_id');
    }
}
