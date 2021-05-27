<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyManager extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function manager()
    {
        return $this->hasOne('App\Models\Manager','id','manager_id');
    }
    public function company()
    {
        return $this->hasOne('App\Models\Company','id','company_id');
    }
}
