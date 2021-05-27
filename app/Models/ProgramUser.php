<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramUser extends Model
{
    use HasFactory;
      use SoftDeletes;
        protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

    }

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
     public function program()
    {
        return $this->hasOne('App\Models\Program','id','prog_id');
    }
}
