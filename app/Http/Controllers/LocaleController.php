<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch the user's active locale.
     */
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, ['en', 'km'])) {
            Session::put('locale', $locale);
            session()->save();
            cookie()->queue(cookie()->forever('locale', $locale));
        }

        return redirect()->back()->withCookie(cookie()->forever('locale', $locale));
    }
}
