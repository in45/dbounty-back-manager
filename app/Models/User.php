<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    use SoftDeletes;
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });

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
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report','user_id','id');
    }
    public function programs()
    {
        return $this->hasMany('App\Models\ProgramUser','user_id','id');
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

    public function getJWTIdentifier()
    {
       return  $this->getKey();
    }
}
