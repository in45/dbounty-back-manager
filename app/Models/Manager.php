<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Manager extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use SoftDeletes;
    protected $appends = ['company_id'];
    protected  $table = 'managers';

    protected  $hidden = [
        'password'
    ];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });

    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->role
        ];
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
    public function company()
    {
        return $this->hasOne('App\Models\CompanyManager','manager_id');
    }
    public function getCompanyIdAttribute()
    {

        $company = $this->company()->first('company_id');
        return $company->company_id;
    }
 
}
