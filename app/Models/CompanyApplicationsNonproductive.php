<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyApplicationsNonproductive extends Model
{
    use HasFactory;
    protected $table = 'company_applications_nonproductive';
    protected $fillable = ['company_id', 'app_name', 'description', 'category_id', 'status'];
}
