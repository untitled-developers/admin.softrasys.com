<?php

namespace App\Models;

use UntitledDevelopers\KockatoosAdminCore\Models\Admin;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class GpsContactForm extends BaseModel
{
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
