<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWiseProductiveApp extends Model
{
    use HasFactory;

    protected $table = 'employee_wise_productive_apps';

    protected $fillable = [
        'employee_id',
        'company_id',
        'app_id', // or 'category_id',
        // Add more fields as needed
        'created_at',
        'updated_at',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function app()
    {
        return $this->belongsTo(CompanyApplicationsNonProductive::class, 'app_id');
    }
    public function category()
    {
        return $this->belongsTo(CompanyApplicationsCategory::class, 'category_id');
    }
}
