<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['company_name', 'company_website', 'about_company', 'company_address', 'contact_name', 'contact_email', 'contact_phone', 'timezone', 'date_time_format', 'company_logo', 'active'];

    // Company.php

    public function applicationsNonproductive()
    {
        return $this->hasOne(Application::class, 'company_id')->where('category_id', null);
    }

    // You might have another relationship for productive applications if needed
    public function applicationsProductive()
    {
        return $this->hasOne(Application::class, 'company_id')->where('category_id', '!=', null);
    }
}
