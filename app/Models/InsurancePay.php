<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePay extends Model
{
    use HasFactory;

    protected $table = 'insurance_pays';
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
