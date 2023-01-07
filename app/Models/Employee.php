<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'gender' => 'boolean',
        'is_marital' => 'boolean',
        'is_working' => 'boolean',
    ];

    public function getIdAttribute($value)
    {
        return str_pad($value, 4, '0', STR_PAD_LEFT);
    }

    public function getSeniorityYearsAttribute()
    {
        return today()->diffInYears($this->date_of_employment);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function advances()
    {
        return $this->hasMany(Advance::class);
    }

    public function payoffs()
    {
        return $this->hasMany(Payoff::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function payrolls()
    {
        return $this->hasManyThrough(Payroll::class, Timesheet::class);
    }

    public function labor_contracts()
    {
        return $this->hasMany(LaborContract::class);
    }

    public function insurance_pays()
    {
        return $this->hasMany(InsurancePay::class);
    }

    public function basic_pays()
    {
        return $this->hasMany(BasicPay::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
