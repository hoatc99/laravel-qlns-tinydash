<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborContract extends Model
{
    use HasFactory;

    protected $table = 'labor_contracts';
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActiveByEmployeeId($employee_id)
    {
        return $this->whereIsActive(1)->where('start_date', '<=', today())->where('actual_end_date', '>=', today())->whereEmployeeId($employee_id)->first();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
