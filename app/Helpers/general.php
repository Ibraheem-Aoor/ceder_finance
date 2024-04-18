<?php



/**
 * @return string
 */

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

if (!function_exists('getSystemCurrency')) {
    function getSystemCurrency()
    {
        return 'EUR';
    }
}

/**
 * Format Price
 * @param double $price
 */

if (!function_exists('formatPrice')) {
    function formatPrice($price, $with_currency = true)
    {
        $format_price = number_format($price, 2, '.', ','); // 2 decimal places, decimal point is '.', thousands separator is ','

        return $with_currency ? ($format_price . ' ' . getSystemCurrency()) : ($format_price); // You can change the currency symbol as needed
    }
}




//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route)
                return $output;
        }
    }
}


//get Specific key valeu from env
if (!function_exists('getFromEnv')) {
    function getFromEnv($key, $default = null)
    {
        return env($key, $default);
    }
}


/**
 * get avilable locales
 * @return array
 */
if (!function_exists('getAvilableLocales')) {
    function getAvilableLocales()
    {
        return config('translatable.locales') ?? [];
    }
}
/**
 * Hash the given value
 * @param mixed $value
 * @return mixed
 */
if (!function_exists('makeHash')) {
    function makeHash($value)
    {
        return Hash::make($value);
    }
}


/**
 * get the auth user of a given guard
 * @param mixed $guard
 * @return mixed
 */
if (!function_exists('getAuthUser')) {
    function getAuthUser($guard = 'web')
    {
        return Auth::guard($guard)->user();
    }
}


/**
 * return the session current locale
 */

if (!function_exists('getCurrentLocale')) {
    function getCurrentLocale()
    {
        return app()->getLocale();
    }
}

/**
 * check pagination
 */

if (!function_exists('checkPagiantion')) {
    function checkPagiantion($paginate)
    {

        if ($paginate > config('database.pagination.max_pagination'))
            return config('database.pagination.max_pagination');
        if ($paginate < config('database.pagination.min_pagiantion'))
            return config('database.pagination.min_pagiantion');

        return $paginate;
    }
}


/**
 * return app logo
 */

if (!function_exists('getAppLogo')) {
    function getAppLogo($type = 'dark')
    {
        return Cache::remember('logo_' . $type, now()->addDay(), function () use ($type) {
            $logo = "logo_{$type}.webp";
            return asset("assets/common/{$logo}");
        });
    }
}


/**
 * Cache&Get
 *
 */
if (!function_exists('cacheAndGet')) {
    function cacheAndGet($key, $duration, $value)
    {
        return Cache::remember($key, $duration, function () use ($value) {
            return $value;
        });
    }
}



if (!function_exists('isAdmin')) {
    function isAdmin($guard)
    {
        return getAuthUser($guard)?->hasRole('super admin');
    }
}



