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

    private function parseBilingual($key, $default)
    {
        $value = Setting::getValue($key);
        if (empty($value)) {
            return ['en' => $default, 'km' => $default];
        }
        
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return [
                'en' => $decoded['en'] ?? $default,
                'km' => $decoded['km'] ?? $default,
            ];
        }
        
        // Fallback for legacy plain strings
        return [
            'en' => $value,
            'km' => $value,
        ];
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
                'address' => $this->parseBilingual('address', 'Kompong Spue, Cambodia'),
                'phone' => Setting::getValue('phone', '012 4444 12'),
                'email' => Setting::getValue('email', 'duc2024@gmail.com'),
                'copyright' => $this->parseBilingual('copyright', 'Copyright © 2024 Digital University of Cambodia. All rights reserved.'),
                'direct_lines' => json_decode(Setting::getValue('direct_lines', '[]'), true),
                'social_links' => json_decode(Setting::getValue('social_links', '[]'), true),
                'header_bg_color' => Setting::getValue('header_bg_color', '#ffffff'),
                'header_text_color' => Setting::getValue('header_text_color', '#104652'),
                'header_subtitle_color' => Setting::getValue('header_subtitle_color', '#AF8319'),
                'footer_bg_color' => Setting::getValue('footer_bg_color', '#0d184a'),
                'footer_border_color' => Setting::getValue('footer_border_color', '#04a8f5'),
                'footer_text_color' => Setting::getValue('footer_text_color', '#ffffff'),
                'sub_footer_bg_color' => Setting::getValue('sub_footer_bg_color', '#081033'),
                'sub_footer_text_color' => Setting::getValue('sub_footer_text_color', '#94a3b8'),
                'sub_footer_border_color' => Setting::getValue('sub_footer_border_color', '#1e293b'),
                'nav_bg_color' => Setting::getValue('nav_bg_color', '#3852a4'),
                'nav_text_color' => Setting::getValue('nav_text_color', '#ffffff'),
                'nav_active_color' => Setting::getValue('nav_active_color', '#ffb800'),
                'global_bg_color' => Setting::getValue('global_bg_color', '#c9e0e4'),
                'card_bg_color' => Setting::getValue('card_bg_color', '#ffffff'),
                'primary_button_color' => Setting::getValue('primary_button_color', '#104652'),
                'primary_button_hover' => Setting::getValue('primary_button_hover', '#316d7a'),
                'contact_image' => Setting::getValue('contact_image', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80'),
                'privacy_policy_label' => Setting::getValue('privacy_policy_label', 'Privacy Policy'),
                'privacy_policy_url' => Setting::getValue('privacy_policy_url', '#'),
                'footer_credits' => Setting::getValue('footer_credits', 'Made with ♥ by IT Department Students'),
                'about_tabs_content' => json_decode(Setting::getValue('about_tabs_content', '{}'), true),
                'contact_hero_title' => $this->parseBilingual('contact_hero_title', 'Contact Us'),
                'contact_hero_description' => $this->parseBilingual('contact_hero_description', 'Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.'),
                'contact_map_link' => Setting::getValue('contact_map_link', ''),
                'contact_form_title' => $this->parseBilingual('contact_form_title', 'Send Us a Message'),
                'contact_form_name_label' => $this->parseBilingual('contact_form_name_label', 'Full Name *'),
                'contact_form_email_label' => $this->parseBilingual('contact_form_email_label', 'Email Address *'),
                'contact_form_subject_label' => $this->parseBilingual('contact_form_subject_label', 'Subject *'),
                'contact_form_message_label' => $this->parseBilingual('contact_form_message_label', 'Message *'),
                'contact_form_submit_label' => $this->parseBilingual('contact_form_submit_label', 'Send Message'),
                'footer_label_quick_links' => $this->parseBilingual('footer_label_quick_links', 'Our Details'),
                'footer_label_working_hours' => $this->parseBilingual('footer_label_working_hours', 'Working Hours'),
                'footer_label_social_media' => $this->parseBilingual('footer_label_social_media', 'Social Media'),
                'footer_label_contact_info' => $this->parseBilingual('footer_label_contact_info', 'Contact Information'),
                'footer_label_direct_lines' => $this->parseBilingual('footer_label_direct_lines', 'Direct Lines'),
                
                'footer_map_url' => Setting::getValue('footer_map_url', 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1518.5686343584584!2d104.76673604474675!3d11.416249673060195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2skh!4v1783649287380!5m2!1sen!2skh'),
                'footer_map_label' => $this->parseBilingual('footer_map_label', 'Phnom Penh Campus'),
                'footer_working_hours_weekday_label' => $this->parseBilingual('footer_working_hours_weekday_label', 'Mon - Sat'),
                'footer_working_hours_weekday_time' => $this->parseBilingual('footer_working_hours_weekday_time', '8:00 AM - 5:00 PM'),
                'footer_working_hours_weekend_label' => $this->parseBilingual('footer_working_hours_weekend_label', 'Weekend'),
                'footer_working_hours_weekend_time' => $this->parseBilingual('footer_working_hours_weekend_time', '8:00 AM - 4:00 PM'),
                'footer_quick_links' => json_decode(Setting::getValue('footer_quick_links', '[{"label":"About","href":"/about"},{"label":"Office","href":"/personnel_and_human_resources"},{"label":"Faculties","href":"/faculties"}]'), true),
            ]
        ];
    }
}
