<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use UntitledDevelopers\KockatoosAdminCore\Models\BaseModel;

class CareerLanguage extends BaseModel
{
    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
