<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory;
    use SoftDeletes;
     protected $hidden = ['reports','users'];
     protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

    }
     public function reports()
    {
        return $this->hasMany('App\Models\Report','prog_id','id');
    }
      public function users()
    {
        return $this->hasMany('App\Models\ProgramUser','prog_id','id');
    }
     public function company()
    {
        return $this->hasOne('App\Models\Company','id','company_id');
    }
}
