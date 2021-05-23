<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'public_address';
    protected $appends = ['company_id'];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderScope('created_at', 'desc'));

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
        return $this->hasOne('App\Models\CompanyManager','manager_address');
    }
    public function getCompanyIdAttribute()
    {

        $company = $this->company()->first('company_id');
        return $company->company_id;
    }
}
