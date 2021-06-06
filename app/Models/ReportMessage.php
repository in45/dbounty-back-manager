<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportMessage extends Model
{
    use HasFactory;
     use SoftDeletes;
    protected $appends = ['type_user','time_diff'];
            protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

    }
      public function getTimeDiffAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

      public function from()
    {

       if($this->type == 'am' || $this->type == 'au') return  $this->hasOne('App\Models\Admin','id','from');
       if($this->type == 'ma' || $this->type == 'mu') return  $this->hasOne('App\Models\Manager','id','from');
       if($this->type == 'ua' || $this->type == 'um') return  $this->hasOne('App\Models\User','id','from');
    }
       public function to()
    {

       if($this->type == 'ma' || $this->type == 'ua') return  $this->hasOne('App\Models\Admin','id','to');
       if($this->type == 'am' || $this->type == 'um') return  $this->hasOne('App\Models\Manager','id','to');
       if($this->type == 'au' || $this->type == 'mu') return  $this->hasOne('App\Models\User','id','to');
    }
           public function report()
    {
 return  $this->hasOne('App\Models\Report','id','report_id');
    }
    public function getTypeUserAttribute()
    {
        $user = Auth::user();
       if($user->id == $this->from) return 'from';
       else return 'to';
    }
}
