<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeService extends Model
{
    use HasFactory;

    public $table = 'employee_service';

    protected $fillable = [
        'employee_id',
        'service_id'
    ];
}
