<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale') ?? $request->cookie('locale') ?? config('app.locale', 'en');
        if (!in_array($locale, ['en', 'km'])) {
            $locale = 'en';
        }

        App::setLocale($locale);

        if (Session::get('locale') !== $locale) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
