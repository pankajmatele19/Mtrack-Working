<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getCountry()
    {
        return DB::table('countries')->get();
    }

    public function getState($country_id)
    {
        return DB::table('states')->where('country_id', $country_id)->get();
    }

    public function getCity($state_id)
    {
        return DB::table('cities')->where('state_id', $state_id)->get();
    }

    public function getLanguages()
    {
        return DB::table('list')->get();
    }

    public function getTimeZones()
    {
        return DB::table('timezones as tz')
            ->select('tz.*', 'co.name')
            ->join('countries as co', 'tz.country_code', 'co.shortname')
            ->get();
    }
}
