<?php

use App\Models\Setting;

function store_status()
{
    $setting = Setting::first();
    return $setting ? $setting->store_status : 'open';
}