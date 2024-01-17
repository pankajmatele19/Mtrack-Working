<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApplicationsNonproductive extends Model
{
    use HasFactory;
    protected $table = 'master_applications_nonproductive';
    protected $fillable = ['app_name', 'description', 'category_id'];
}
