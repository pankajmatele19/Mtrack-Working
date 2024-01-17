<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApplicationsCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
    ];
}
