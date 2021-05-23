<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use SoftDeletes;
    protected $primaryKey = 'public_address';
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password','reports','programs' ];
    protected $appends = ['count_reports','count_programs','thanks'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
      public function reports()
    {
        return $this->hasMany('App\Models\Report','user_address','public_address');
    }
    public function programs()
    {
        return $this->hasMany('App\Models\ProgramUser','user_address','public_address');
    }
     public function getCountReportsAttribute()
    {
       
        return count($this->reports);
    }
      public function getCountProgramsAttribute()
    {
       
        return count($this->programs);
    }
       public function getThanksAttribute()
    {
     
        return count($this->programs()->where('thanks',1)->get());
    }
}
