<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

class HelperService
{
    protected static $titleMap = [
        'dashboard' => 'Dashboard',
        'student.index' => 'Student List',
        'student.create' => 'Create Student',
        'student.edit' => 'Edit Student',
        // Add more route-specific titles here
    ];

    public static function generateBreadcrumbs()
    {
        $breadcrumbs = collect();
        $currentRouteName = Route::currentRouteName();
        $routes = explode('.', $currentRouteName);

        foreach ($routes as $key => $route) {
            $routeName = implode('.', array_slice($routes, 0, $key + 1));
            $url = '#';

            // Handle routes with parameters
            if (Route::has($routeName)) {
                try {
                    // Assuming the parameter is the ID from the request
                    $parameters = Request::route()->parameters();
                    $url = route($routeName, $parameters);
                } catch (\Exception $e) {
                    // If there's an exception, do not generate the URL
                }
            }

            $breadcrumbs->push([
                'name' => ucfirst($route),
                'url' => $url
            ]);
        }

        return $breadcrumbs;
    }

    public static function generateTitle()
    {
        $breadcrumbs = self::generateBreadcrumbs();
        $routeName = Route::currentRouteName();
        if (array_key_exists($routeName, self::$titleMap)) {
            return self::$titleMap[$routeName];
        }

        // If no specific title is found, generate a generic one
        $titleParts = $breadcrumbs->pluck('name')->toArray();

        return implode(' ', $titleParts);
    }
}
