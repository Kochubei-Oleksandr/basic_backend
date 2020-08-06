<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;

class SetLanguage
{
    public function handle($request, Closure $next)
    {
        $language = $request->header('Language');

        if (!$language) {
            $language = Language::first()->name;
        }

        app()->setLocale($language);
        $request->merge(["language" => $language]);

        return $next($request);
    }
}
