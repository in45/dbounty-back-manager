<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Badge extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

    }

    public function achieves()
    {
        return $this->hasMany('App\Models\UserBadge','user_id','id');
    }
    public function done()
    {
        return $this->hasMany('App\Models\UserBadge','badge_id','id');
    }
}
