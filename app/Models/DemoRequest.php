<?php

namespace App\Models;

use UntitledDevelopers\KockatoosAdminCore\Models\Admin;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class DemoRequest extends BaseModel
{
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
