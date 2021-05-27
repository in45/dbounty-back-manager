<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;
         use SoftDeletes;
          protected $appends = ['time_diff'];
        protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

    }
      public function getTimeDiffAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
     public function program()
    {
        return $this->hasOne('App\Models\Program','id','prog_id');
    }
     public function vuln()
    {
        return $this->hasOne('App\Models\Vulnerability','id','vuln_id');
    }
}
