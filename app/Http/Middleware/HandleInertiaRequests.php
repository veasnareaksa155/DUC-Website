<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\NavigationItem;
use App\Models\Setting;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'locale' => app()->getLocale(),
            'translations' => \App\Models\Translation::getTranslationsForLocale(app()->getLocale()),
            'auth' => [
                'user' => $request->user(),
            ],
            'navigation' => NavigationItem::getTree(),
            'settings' => [
                'address' => Setting::getValue('address', 'Kompong Spue, Cambodia'),
                'phone' => Setting::getValue('phone', '012 4444 12'),
                'email' => Setting::getValue('email', 'duc2024@gmail.com'),
                'copyright' => Setting::getValue('copyright', 'Copyright © 2024 Digital University of Cambodia. All rights reserved.'),
                'direct_lines' => json_decode(Setting::getValue('direct_lines', '[]'), true),
                'social_links' => json_decode(Setting::getValue('social_links', '[]'), true),
                'header_bg_color' => Setting::getValue('header_bg_color', '#ffffff'),
                'header_text_color' => Setting::getValue('header_text_color', '#000000'),
                'footer_bg_color' => Setting::getValue('footer_bg_color', '#0d184a'),
                'footer_border_color' => Setting::getValue('footer_border_color', '#04a8f5'),
                'footer_text_color' => Setting::getValue('footer_text_color', '#ffffff'),
                'sub_footer_bg_color' => Setting::getValue('sub_footer_bg_color', '#081033'),
                'sub_footer_text_color' => Setting::getValue('sub_footer_text_color', '#94a3b8'),
                'sub_footer_border_color' => Setting::getValue('sub_footer_border_color', '#1e293b'),
                'nav_bg_color' => Setting::getValue('nav_bg_color', '#3852a4'),
                'nav_text_color' => Setting::getValue('nav_text_color', '#ffffff'),
                'nav_active_color' => Setting::getValue('nav_active_color', '#ffb800'),
                'contact_image' => Setting::getValue('contact_image', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80'),
                'privacy_policy_label' => Setting::getValue('privacy_policy_label', 'Privacy Policy'),
                'privacy_policy_url' => Setting::getValue('privacy_policy_url', '#'),
                'footer_credits' => Setting::getValue('footer_credits', 'Made with ♥ by IT Department Students'),
            ]
        ];
    }
}
