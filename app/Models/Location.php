<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Location extends BaseModel
{
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'location_languages', 'location_id', 'language_id')
            ->withPivot(['name', 'address'])
            ->withTimestamps();
    }
}
