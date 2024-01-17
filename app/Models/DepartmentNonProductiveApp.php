<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentNonProductiveApp extends Model
{
    use HasFactory;
    protected $table = 'department_non_productive_apps';

    protected $fillable = [
        'department_id',
        'company_id',
        'app_id',
        'category_id',
        'status',
        // Add other fillable fields as needed
    ];
}
