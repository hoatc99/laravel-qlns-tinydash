<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessResult extends Model
{
    use HasFactory;

    protected $table = 'business_results';
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
