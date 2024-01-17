<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = 'company_applications_nonproductive';

    protected $fillable = ['company_id', 'app_name', 'description', 'category_id', 'created_at', 'updated_at'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
