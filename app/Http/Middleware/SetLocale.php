<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['en', 'ru', 'uz','qr']; // Ruxsat berilgan tillar
        $lang = explode(',', $request->header('Accept-Language', 'ru'))[0]; // Birinchi tilni olish

        if (!in_array($lang, $supportedLocales)) {
            $lang = 'ru'; // Default til
        }

        app()->setLocale($lang);

        return $next($request);
    }
}
