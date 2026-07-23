<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use UntitledDevelopers\KockatoosAdminCore\Models\Admin;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class CareerForm extends BaseModel
{
    public function blob(): BelongsTo
    {
        return $this->belongsTo(Blob::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
