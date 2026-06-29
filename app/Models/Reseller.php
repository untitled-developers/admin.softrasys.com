<?php

namespace App\Models;

use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class Reseller extends BaseModel
{
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
