<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ManageStoreController extends Controller
{
    public static function getCurrentUrl()
    {
        $url = request()->url();
        $path = parse_url($url, PHP_URL_PATH);
        $segments = explode('/', $path);

        if (count($segments) >= 3) {
            $value = $segments[2];
            return $value;
        }

        Log::error('Url not setted correctly');
        return null;
    }

}
