<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsStat extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'gps_stat_languages')
            ->withPivot(['title', 'subtitle', 'gps_stat_id', 'language_id']);
    }
}
