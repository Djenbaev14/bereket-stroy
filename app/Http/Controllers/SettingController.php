<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $setting = Setting::firstOrFail();
        return $this->responsePagination($setting, new SettingResource($setting));
    }
}
