<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyApplicationsCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'category_id',
        'category_name',
        'created_at',
        'updated_at',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function masterCategory()
    {
        return $this->belongsTo(MasterApplicationsCategory::class, 'category_id');
    }
}
