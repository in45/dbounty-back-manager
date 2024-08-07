<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

    }
    public function managers()
    {
        return $this->hasMany('App\Models\CompanyManager','company_id','id');
    }

    protected $appends = ['is_manager'];
    protected $hidden = ['managers', 'alpha_code','beta_code'];




    public function getIsManagerAttribute()
    {
        $user = Auth::user();
        $managers = $this->managers->pluck('manager_id')->toArray();
        return in_array($user->id, $managers);
    }
}
