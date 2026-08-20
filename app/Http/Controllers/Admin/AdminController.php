<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use App\Models\PageContent;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'navigationItems' => NavigationItem::orderBy('order')->get(),
            'pageContents' => PageContent::all(),
            'events' => Event::orderBy('id', 'desc')->get(),
            'faculties' => Faculty::with('departments')->get(),
            'translationsData' => \App\Models\Translation::orderBy('key')->get(),
            'activityLogs' => ActivityLog::latest()->take(30)->get()->map(function($log) {
                return [
                    'id' => $log->id,
                    'title' => $log->action,
                    'user' => $log->user_name ?? 'Admin',
                    'time' => $log->created_at->diffForHumans(),
                    'date_full' => $log->created_at->format('M d, Y h:i A'),
                    'module' => $log->module,
                    'iconClass' => $log->icon_class ?: 'bg-blue-500/10 text-blue-500',
                ];
            }),
            'settings' => [
                'address' => Setting::getValue('address', ''),
                'phone' => Setting::getValue('phone', ''),
                'email' => Setting::getValue('email', ''),
                'copyright' => Setting::getValue('copyright', ''),
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
                'footer_map_url' => Setting::getValue('footer_map_url', 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1518.5686343584584!2d104.76673604474675!3d11.416249673060195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2skh!4v1783649287380!5m2!1sen!2skh'),
                'footer_map_label' => Setting::getValue('footer_map_label', 'Phnom Penh Campus'),
                'footer_working_hours_weekday_label' => Setting::getValue('footer_working_hours_weekday_label', 'Mon - Sat'),
                'footer_working_hours_weekday_time' => Setting::getValue('footer_working_hours_weekday_time', '8:00 AM - 5:00 PM'),
                'footer_working_hours_weekend_label' => Setting::getValue('footer_working_hours_weekend_label', 'Weekend'),
                'footer_working_hours_weekend_time' => Setting::getValue('footer_working_hours_weekend_time', '8:00 AM - 4:00 PM'),
                'footer_quick_links' => json_decode(Setting::getValue('footer_quick_links', '[{"label":"About","href":"/about"},{"label":"Office","href":"/personnel_and_human_resources"},{"label":"Faculties","href":"/faculties"}]'), true),
            ],
            'homeSettings' => [
                'home_hero_slides' => json_decode(Setting::getValue('home_hero_slides', '[]'), true),
                'home_scholarship' => json_decode(Setting::getValue('home_scholarship', '{}'), true),
                'home_four_years' => json_decode(Setting::getValue('home_four_years', '[]'), true),
                'home_video_url' => Setting::getValue('home_video_url', ''),
                'home_video_bg_image' => Setting::getValue('home_video_bg_image', ''),
                'home_video_bg_color' => Setting::getValue('home_video_bg_color', '#0f2154'),
                'home_activities_slides' => json_decode(Setting::getValue('home_activities_slides', '[]'), true),
                'home_graduate_attributes' => json_decode(Setting::getValue('home_graduate_attributes', '{}'), true),
                'home_stats' => json_decode(Setting::getValue('home_stats', '[]'), true),
            ],
            'contactSettings' => [
                'contact_hero_title' => Setting::getValue('contact_hero_title', 'Contact Us'),
                'contact_hero_description' => Setting::getValue('contact_hero_description', 'Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.'),
                'contact_image' => Setting::getValue('contact_image', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80'),
            ]
        ]);
    }

    // --- NAVIGATION CRUD ---
    public function saveNavigationItem(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'label' => 'required|array',
            'label.en' => 'required|string|max:255',
            'label.km' => 'nullable|string|max:255',
            'href' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'order' => 'nullable|integer',
        ]);

        $item = NavigationItem::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'label' => $validated['label'],
                'href' => $validated['href'],
                'icon' => $validated['icon'],
                'parent_id' => $validated['parent_id'],
                'order' => $validated['order'] ?? 0,
            ]
        );

        $actionText = ($validated['id'] ?? null) ? "Updated navigation node '" . ($validated['label']['en'] ?? '') . "'" : "Created navigation node '" . ($validated['label']['en'] ?? '') . "'";
        ActivityLog::log($actionText, 'navigation');

        return redirect()->back()->with('success', 'Navigation item saved successfully.');
    }

    public function deleteNavigationItem(NavigationItem $item)
    {
        $labelEn = is_array($item->label) ? ($item->label['en'] ?? 'Node') : $item->label;
        $item->delete();
        ActivityLog::log("Deleted navigation node '" . $labelEn . "'", 'navigation', 'bg-red-500/10 text-red-500');
        return redirect()->back()->with('success', 'Navigation item deleted successfully.');
    }

    // --- PAGES CRUD ---
    public function savePageContent(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'slug' => 'required|string|max:255',
            'title' => 'required',
            'content' => 'required|array',
            'is_office' => 'nullable|boolean',
            'office_type' => 'nullable|string',
            'apply_to_all_offices' => 'nullable|boolean',
        ]);

        $content = $validated['content'];
        
        // Handle potential file uploads inside the 'content' array
        foreach ($content as $key => $value) {
            if ($request->hasFile("content.{$key}")) {
                $path = $request->file("content.{$key}")->store('pages', 'public');
                $content[$key] = '/storage/' . $path;
            }
        }

        PageContent::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'slug' => ltrim(trim($validated['slug']), '/'),
                'title' => $validated['title'],
                'content' => json_encode($content),
                'is_office' => $validated['is_office'] ?? false,
                'office_type' => $validated['office_type'] ?? null,
            ]
        );

        // Bulk apply title_font_size to ALL offices if requested
        if (!empty($validated['apply_to_all_offices']) && isset($content['title_font_size'])) {
            $officePages = PageContent::where('is_office', true)->get();
            foreach ($officePages as $offPage) {
                $offContent = json_decode($offPage->content, true) ?? [];
                $offContent['title_font_size'] = $content['title_font_size'];
                $offPage->update(['content' => json_encode($offContent)]);
            }
        }

        $titleLog = is_array($validated['title']) ? ($validated['title']['en'] ?? reset($validated['title'])) : $validated['title'];
        ActivityLog::log("Updated page content for '" . $titleLog . "'", 'pages');

        return redirect()->back()->with('success', 'Page content saved successfully.');
    }

    public function deletePageContent(PageContent $page)
    {
        $pageTitle = $page->title;
        $page->delete();
        ActivityLog::log("Deleted page '" . $pageTitle . "'", 'pages', 'bg-red-500/10 text-red-500');
        return redirect()->back()->with('success', 'Page content deleted.');
    }

    // --- EVENTS CRUD ---
    public function saveEvent(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'title.km' => 'nullable|string|max:255',
            'type' => 'required|string|in:campus,digital,announcement',
            'date' => 'required|array',
            'date.en' => 'required|string|max:255',
            'date.km' => 'nullable|string|max:255',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'description.km' => 'nullable|string',
            'content' => 'nullable|array',
            'content.en' => 'nullable|string',
            'content.km' => 'nullable|string',
            'image' => 'nullable',
            'detail_image' => 'nullable',
            'is_published' => 'nullable|boolean',
        ]);

        $image = $validated['image'] ?? null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $image = '/storage/' . $path;
        }

        $detail_image = $validated['detail_image'] ?? null;
        if ($request->hasFile('detail_image')) {
            $path = $request->file('detail_image')->store('events', 'public');
            $detail_image = '/storage/' . $path;
        }

        Event::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'title' => $validated['title'],
                'type' => $validated['type'],
                'date' => $validated['date'],
                'description' => $validated['description'],
                'content' => $validated['content'],
                'image' => $image ?: 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&w=900&q=80',
                'detail_image' => $detail_image ?: 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&w=1400&q=85',
                'is_published' => $validated['is_published'] ?? true,
            ]
        );

        $eventTitle = $validated['title']['en'] ?? 'Article';
        $actionText = ($validated['id'] ?? null) ? "Updated event article '" . $eventTitle . "'" : "Published new event: " . $eventTitle;
        ActivityLog::log($actionText, 'events');

        return redirect()->back()->with('success', 'Event saved successfully.');
    }

    public function deleteEvent(Event $event)
    {
        $eventTitle = is_array($event->title) ? ($event->title['en'] ?? '') : $event->title;
        $event->delete();
        ActivityLog::log("Deleted event article '" . $eventTitle . "'", 'events', 'bg-red-500/10 text-red-500');
        return redirect()->back()->with('success', 'Event deleted.');
    }

    // --- FACULTY & DEPARTMENT CRUD ---
    public function saveFaculty(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.km' => 'nullable|string|max:255',
            'cover_image' => 'nullable',
            'org_chart_image' => 'nullable',
            'mission' => 'nullable|array',
            'mission.en' => 'nullable|string',
            'mission.km' => 'nullable|string',
            'vision' => 'nullable|array',
            'vision.en' => 'nullable|string',
            'vision.km' => 'nullable|string',
            'goals' => 'nullable|array',
            'goals.en' => 'nullable|string',
            'goals.km' => 'nullable|string',
            'custom_sections' => 'nullable|array',
        ]);

        $cover_image = $validated['cover_image'] ?? null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('faculties', 'public');
            $cover_image = '/storage/' . $path;
        }

        $org_chart_image = $validated['org_chart_image'] ?? null;
        if ($request->hasFile('org_chart_image')) {
            $path = $request->file('org_chart_image')->store('faculties', 'public');
            $org_chart_image = '/storage/' . $path;
        }

        $faculty = Faculty::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'name' => $validated['name'],
                'cover_image' => $cover_image,
                'org_chart_image' => $org_chart_image,
                'mission' => $validated['mission'],
                'vision' => $validated['vision'],
                'goals' => $validated['goals'],
                'custom_sections' => isset($validated['custom_sections']) ? json_encode($validated['custom_sections']) : null,
            ]
        );

        // Sync with NavigationItem
        $facultiesMenu = NavigationItem::where('label', 'like', '%FACULTIES%')->first();
        if ($facultiesMenu) {
            $href = '/department/' . $faculty->id;
            $navItem = NavigationItem::where('href', $href)->first();
            if ($navItem) {
                $navItem->update([
                    'label' => $faculty->name,
                ]);
            } else {
                $maxOrder = NavigationItem::where('parent_id', $facultiesMenu->id)->max('order') ?? 0;
                NavigationItem::create([
                    'label' => $faculty->name,
                    'href' => $href,
                    'parent_id' => $facultiesMenu->id,
                    'order' => $maxOrder + 1,
                ]);
            }
        }

        $facultyName = $validated['name']['en'] ?? 'Faculty';
        $actionText = ($validated['id'] ?? null) ? "Updated faculty '" . $facultyName . "'" : "Created new faculty '" . $facultyName . "'";
        ActivityLog::log($actionText, 'faculties');

        return redirect()->back()->with('success', 'Faculty saved successfully.');
    }

    public function restoreDefaultFaculties()
    {
        $facultiesData = [
            1 => [
                'name' => ['en' => 'Faculty of Digital Industry', 'km' => 'មហាវិទ្យាល័យឧស្សាហកម្មឌីជីថល'],
                'org_chart_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzu2oR8YVBZ4GuJXJQzKq5HT5odxP0plf-s269P_B_ZGhmtORzwojlKhg&s=10',
                'mission' => ['en' => 'To cultivate creative technology innovators through hands-on education in digital design, social media, and digital marketing.', 'km' => 'ដើម្បីបណ្តុះបណ្តាលអ្នកបង្កើតបច្ចេកវិទ្យាប្រកបដោយការច្នៃប្រឌិត តាមរយៈការអប់រំផ្ទាល់ផ្នែករចនាឌីជីថល បណ្តាញសង្គម និងទីផ្សារឌីជីថល។'],
                'vision' => ['en' => 'To be the leading hub for digital industry preparation in the ASEAN region.', 'km' => 'ដើម្បីក្លាយជាមជ្ឈមណ្ឌលឈានមុខគេសម្រាប់ការរៀបចំឧស្សាហកម្មឌីជីថលនៅក្នុងតំបន់អាស៊ាន។'],
                'goals' => ['en' => "1. Maintain a 95% post-graduation employment rate.\n2. Partner with 50+ digital design and marketing firms for student internships.", 'km' => "១. រក្សាអត្រាការងារ ៩៥% ក្រោយពេលបញ្ចប់ការសិក្សា។\n២. ចុះកិច្ចសហការជាមួយក្រុមហ៊ុនរចនាឌីជីថល និងទីផ្សារជាង ៥០ សម្រាប់កម្មសិក្សារបស់និស្សិត។"],
                'departments' => [
                    [
                        'name' => ['en' => 'Department of Graphic Design', 'km' => 'ដេប៉ាតឺម៉ង់រចនាក្រាហ្វិក'], 
                        'slug' => 'graphic-design', 
                        'description' => ['en' => 'Provides students with creative skills in branding, illustration, typography, UI/UX, and digital media design.', 'km' => 'ផ្តល់ជូននិស្សិតនូវជំនាញច្នៃប្រឌិតក្នុងការបង្កើតម៉ាកយីហោ គំនូរ រចនាអក្សរ UI/UX និងការរចនាប្រព័ន្ធផ្សព្វផ្សាយឌីជីថល។']
                    ],
                    [
                        'name' => ['en' => 'Department of Digital Marketing', 'km' => 'ដេប៉ាតឺម៉ង់ទីផ្សារឌីជីថល'], 
                        'slug' => 'digital-marketing', 
                        'description' => ['en' => 'Focuses on SEO, social media marketing, online advertising, branding, and digital analytics.', 'km' => 'ផ្តោតលើ SEO ទីផ្សារបណ្តាញសង្គម ការផ្សាយពាណិជ្ជកម្មតាមអ៊ីនធឺណិត ការបង្កើតម៉ាកយីហោ និងការវិភាគឌីជីថល។']
                    ],
                    [
                        'name' => ['en' => 'Department of Social Media', 'km' => 'ដេប៉ាតឺម៉ង់បណ្តាញសង្គម'], 
                        'slug' => 'social-media', 
                        'description' => ['en' => 'Prepares experts in content strategy, digital communication, brand management, and social media platforms.', 'km' => 'រៀបចំអ្នកជំនាញផ្នែកយុទ្ធសាស្ត្រមាតិកា ទំនាក់ទំនងឌីជីថល ការគ្រប់គ្រងម៉ាកយីហោ និងវេទិកាបណ្តាញសង្គម។']
                    ],
                    [
                        'name' => ['en' => 'Department of Information Technology', 'km' => 'ដេប៉ាតឺម៉ង់បច្ចេកវិទ្យាព័ត៌មាន'], 
                        'slug' => 'information-technology', 
                        'description' => ['en' => 'Covers web development, databases, programming, networking, and software engineering.', 'km' => 'គ្របដណ្តប់លើការអភិវឌ្ឍន៍គេហទំព័រ មូលដ្ឋានទិន្នន័យ ការសរសេរកម្មវិធី បណ្តាញ និងវិស្វកម្មកម្មវិធីកុំព្យូទ័រ។']
                    ]
                ],
            ],
            2 => [
                'name' => ['en' => 'Faculty of English Language', 'km' => 'មហាវិទ្យាល័យភាសាអង់គ្លេស'],
                'org_chart_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzu2oR8YVBZ4GuJXJQzKq5HT5odxP0plf-s269P_B_ZGhmtORzwojlKhg&s=10',
                'mission' => ['en' => 'Providing premium instruction in English communication, translation, and academic teaching methodologies.', 'km' => 'ការផ្តល់ការបង្រៀនដ៏ល្អឥតខ្ចោះក្នុងការទំនាក់ទំនងភាសាអង់គ្លេស ការបកប្រែ និងវិធីសាស្ត្របង្រៀនសិក្សា។'],
                'vision' => ['en' => 'Developing linguists capable of elevating Cambodia\'s presence on the international stage.', 'km' => 'ការអភិវឌ្ឍអ្នកភាសាវិទ្យាដែលអាចលើកកម្ពស់វត្តមានរបស់កម្ពុជានៅលើឆាកអន្តរជាតិ។'],
                'goals' => ['en' => "1. Improve interpretation accuracy and research output.\n2. Conduct regular community outreach programs.", 'km' => "១. កែលម្អភាពត្រឹមត្រូវនៃការបកប្រែផ្ទាល់មាត់ និងលទ្ធផលស្រាវជ្រាវ។\n២. ធ្វើកម្មវិធីចុះជួយសហគមន៍ឱ្យបានទៀងទាត់។"],
                'departments' => [
                    [
                        'name' => ['en' => 'Department of English for Specific Purposes', 'km' => 'ដេប៉ាតឺម៉ង់ភាសាអង់គ្លេសសម្រាប់គោលបំណងជាក់លាក់'], 
                        'slug' => 'english-for-specific-purposes', 
                        'description' => ['en' => 'English training tailored for business, tourism, diplomacy, and aviation.', 'km' => 'ការបណ្តុះបណ្តាលភាសាអង់គ្លេសដែលរៀបចំឡើងសម្រាប់ធុរកិច្ច ទេសចរណ៍ ការទូត និងអាកាសចរណ៍។']
                    ],
                    [
                        'name' => ['en' => 'Department of English Education', 'km' => 'ដេប៉ាតឺម៉ង់អប់រំភាសាអង់គ្លេស'], 
                        'slug' => 'english-education', 
                        'description' => ['en' => 'Prepares future high school and university teachers with modern pedagogical models.', 'km' => 'រៀបចំគ្រូបង្រៀនវិទ្យាល័យ និងសាកលវិទ្យាល័យនាពេលអនាគត ជាមួយនឹងគំរគរុកោសល្យទំនើប។']
                    ],
                    [
                        'name' => ['en' => 'Department of English for Translation and Interpretation', 'km' => 'ដេប៉ាតឺម៉ង់ភាសាអង់គ្លេសសម្រាប់ការបកប្រែ'], 
                        'slug' => 'english-for-translation-and-interpretation', 
                        'description' => ['en' => 'Focuses on professional translation skills between Khmer and English.', 'km' => 'ផ្តោតលើជំនាញបកប្រែវិជ្ជាជីវៈរវាងភាសាខ្មែរ និងអង់គ្លេស។']
                    ]
                ],
            ],
            3 => [
                'name' => ['en' => 'Faculty of Engineering and Architecture', 'km' => 'មហាវិទ្យាល័យវិស្វកម្ម និងស្ថាបត្យកម្ម'],
                'org_chart_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzu2oR8YVBZ4GuJXJQzKq5HT5odxP0plf-s269P_B_ZGhmtORzwojlKhg&s=10',
                'mission' => ['en' => 'Training structural, management, and spatial design experts prepared to construct sustainable environments.', 'km' => 'បណ្តុះបណ្តាលអ្នកជំនាញផ្នែករចនាសម្ព័ន្ធ ការគ្រប់គ្រង និងការរចនាទីធ្លាដែលត្រៀមរួចជាស្រេចដើម្បីសាងសង់បរិស្ថានប្រកបដោយនិរន្តរភាព។'],
                'vision' => ['en' => 'Building smart communities through innovative engineering solutions.', 'km' => 'កសាងសហគមន៍ឆ្លាតវៃតាមរយៈដំណោះស្រាយវិស្វកម្មប្រកបដោយភាពច្នៃប្រឌិត។'],
                'goals' => ['en' => "1. Embed green architecture principles into all studio courses.\n2. Develop student portfolios that win national awards.", 'km' => "១. បញ្ចូលគោលការណ៍ស្ថាបត្យកម្មបៃតងទៅក្នុងគ្រប់វគ្គសិក្សាស្ទូឌីយ៉ូ។\n២. អភិវឌ្ឍផលប័ត្រស្នាដៃរបស់និស្សិតដើម្បីឈ្នះពានរង្វាន់ថ្នាក់ជាតិ។"],
                'departments' => [
                    [
                        'name' => ['en' => 'Department of Engineering', 'km' => 'ដេប៉ាតឺម៉ង់វិស្វកម្ម'], 
                        'slug' => 'engineering', 
                        'description' => ['en' => 'Covers civil, mechanical, and electronic systems for engineering applications.', 'km' => 'គ្របដណ្តប់លើប្រព័ន្ធសំណង់ស៊ីវិល មេកានិច និងប្រព័ន្ធអេឡិចត្រូនិចសម្រាប់កម្មវិធីវិស្វកម្ម។']
                    ],
                    [
                        'name' => ['en' => 'Department of Engineering Management', 'km' => 'ដេប៉ាតឺម៉ង់គ្រប់គ្រងវិស្វកម្ម'], 
                        'slug' => 'engineering-management', 
                        'description' => ['en' => 'Bridges technical engineering expertise with business leadership capabilities.', 'km' => 'ភ្ជាប់ទំនាក់ទំនងរវាងជំនាញបច្ចេកទេសវិស្វកម្ម ជាមួយនឹងសមត្ថភាពដឹកនាំអាជីវកម្ម។']
                    ],
                    [
                        'name' => ['en' => 'Department of Interior Design', 'km' => 'ដេប៉ាតឺម៉ង់រចនាផ្ទៃក្នុង'], 
                        'slug' => 'interior-design', 
                        'description' => ['en' => 'Focuses on spatial planning, aesthetics, and material design for interior spaces.', 'km' => 'ផ្តោតលើការរៀបចំលំហ សោភ័ណភាព និងការរចនាសម្ភារៈសម្រាប់លំហខាងក្នុង។']
                    ]
                ],
            ],
            4 => [
                'name' => ['en' => 'Faculty of Agriculture and Rural Development', 'km' => 'មហាវិទ្យាល័យកសិកម្ម និងអភិវឌ្ឍន៍ជនបទ'],
                'org_chart_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzu2oR8YVBZ4GuJXJQzKq5HT5odxP0plf-s269P_B_ZGhmtORzwojlKhg&s=10',
                'mission' => ['en' => 'To modernize Cambodia\'s agricultural systems and implement rural community development projects.', 'km' => 'ដើម្បីធ្វើទំនើបកម្មប្រព័ន្ធកសិកម្មរបស់កម្ពុជា និងអនុវត្តគម្រោងអភិវឌ្ឍន៍សហគមន៍ជនបទ។'],
                'vision' => ['en' => 'A sustainable, high-yield agricultural sector that enhances food security and rural living standards.', 'km' => 'វិស័យកសិកម្មប្រកបដោយនិរន្តរភាព និងទិន្នផលខ្ពស់ ដែលលើកកម្ពស់សន្តិសុខស្បៀង និងកម្រិតជីវភាពរស់នៅជនបទ។'],
                'goals' => ['en' => "1. Setup experimental smart farming facilities.\n2. Establish rural development pilot studies.", 'km' => "១. បង្កើតកសិដ្ឋានវៃឆ្លាតពិសោធន៍។\n២. បង្កើតការសិក្សាសាកល្បងអភិវឌ្ឍន៍ជនបទ។"],
                'departments' => [
                    [
                        'name' => ['en' => 'Department of Agronomy and Horticulture', 'km' => 'ដេប៉ាតឺម៉ង់ក្សេត្រសាស្ត្រ និងវប្បកម្ម'], 
                        'slug' => 'agronomy-and-horticulture', 
                        'description' => ['en' => 'Focuses on crop production, soil science, plant protection, and nursery management.', 'km' => 'ផ្តោតលើផលិតកម្មដំណាំ វិទ្យាសាស្ត្រដី ការការពាររុក្ខជាតិ និងការគ្រប់គ្រងថ្នាលបណ្តុះ។']
                    ],
                    [
                        'name' => ['en' => 'Department of Agricultural Economics', 'km' => 'ដេប៉ាតឺម៉ង់សេដ្ឋកិច្ចកសិកម្ម'], 
                        'slug' => 'agricultural-economics', 
                        'description' => ['en' => 'Evaluates agri-business strategies, marketing networks, and microfinance in farming.', 'km' => 'វាយតម្លៃយុទ្ធសាស្ត្រធុរកិច្ចកសិកម្ម បណ្តាញទីផ្សារ និងមីក្រូហិរញ្ញវត្ថុក្នុងវិស័យកសិកម្ម។']
                    ],
                    [
                        'name' => ['en' => 'Department of Rural Development', 'km' => 'ដេប៉ាតឺម៉ង់អភិវឌ្ឍន៍ជនបទ'], 
                        'slug' => 'rural-development', 
                        'description' => ['en' => 'Focuses on project design, sustainable resources, and community leadership models.', 'km' => 'ផ្តោតលើការរចនាគម្រោង ធនធានប្រកបដោយនិរន្តរភាព និងគំរូអ្នកដឹកនាំសហគមន៍។']
                    ]
                ],
            ],
            5 => [
                'name' => ['en' => 'Faculty of Law and Political Science', 'km' => 'មហាវិទ្យាល័យច្បាប់ និងវិទ្យាសាស្ត្រនយោបាយ'],
                'org_chart_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzu2oR8YVBZ4GuJXJQzKq5HT5odxP0plf-s269P_B_ZGhmtORzwojlKhg&s=10',
                'mission' => ['en' => 'Cultivating ethical legal practitioners and administrators committed to justice and national policy enhancement.', 'km' => 'បណ្តុះបណ្តាលអ្នកច្បាប់ប្រកបដោយក្រមសីលធម៌ និងអ្នករដ្ឋបាលដែលប្តេជ្ញាចិត្តចំពោះយុត្តិធម៌ និងការលើកកម្ពស់គោលនយោបាយជាតិ។'],
                'vision' => ['en' => 'A just society driven by the rule of law and public service excellence.', 'km' => 'សង្គមប្រកបដោយយុត្តិធម៌ដែលដឹកនាំដោយនីតិរដ្ឋ និងឧត្តមភាពសេវាកម្មសាធារណៈ។'],
                'goals' => ['en' => "1. Establish legal aid clinics for low-income communities.\n2. Partner with ministries for policy research projects.", 'km' => "១. បង្កើតគ្លីនិកជំនួយផ្នែកច្បាប់សម្រាប់សហគមន៍ដែលមានចំណូលទាប។\n២. សហការជាមួយក្រសួងសម្រាប់គម្រោងស្រាវជ្រាវគោលនយោបាយ។"],
                'departments' => [
                    [
                        'name' => ['en' => 'Department of Law', 'km' => 'ដេប៉ាតឺម៉ង់ច្បាប់'], 
                        'slug' => 'law', 
                        'description' => ['en' => 'Comprehensive studies in civil law, penal code, business contracts, and international agreements.', 'km' => 'ការសិក្សាគ្រប់ជ្រុងជ្រោយលើច្បាប់រដ្ឋប្បវេណី ក្រមព្រហ្មទណ្ឌ កិច្ចសន្យាអាជីវកម្ម និងកិច្ចព្រមព្រៀងអន្តរជាតិ។']
                    ],
                    [
                        'name' => ['en' => 'Department of Public Administration', 'km' => 'ដេប៉ាតឺម៉ង់រដ្ឋបាលសាធារណៈ'], 
                        'slug' => 'public-administration', 
                        'description' => ['en' => 'Prepares leaders for government ministries, policy design, and municipality management.', 'km' => 'រៀបចំអ្នកដឹកនាំសម្រាប់ក្រសួងរដ្ឋាភិបាល ការរចនាគោលនយោបាយ និងការគ្រប់គ្រងក្រុង។']
                    ],
                    [
                        'name' => ['en' => 'Department of Political Science', 'km' => 'ដេប៉ាតឺម៉ង់វិទ្យាសាស្ត្រនយោបាយ'], 
                        'slug' => 'political-science', 
                        'description' => ['en' => 'Analyzes international relations, government systems, and policy trends.', 'km' => 'វិភាគទំនាក់ទំនងអន្តរជាតិ ប្រព័ន្ធរដ្ឋាភិបាល និងនិន្នាការគោលនយោបាយ។']
                    ]
                ],
            ],
            6 => [
                'name' => ['en' => 'Faculty of Digital Economic Sciences', 'km' => 'មហាវិទ្យាល័យវិទ្យាសាស្ត្រសេដ្ឋកិច្ចឌីជីថល'],
                'org_chart_image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzu2oR8YVBZ4GuJXJQzKq5HT5odxP0plf-s269P_B_ZGhmtORzwojlKhg&s=10',
                'mission' => ['en' => 'To guide students into the future of global digital trade and fintech innovations.', 'km' => 'ដើម្បីណែនាំសិស្សឱ្យចូលទៅក្នុងអនាគតនៃពាណិជ្ជកម្មឌីជីថលសកល និងការច្នៃប្រឌិតបច្ចេកវិទ្យាហិរញ្ញវត្ថុ (Fintech)។'],
                'vision' => ['en' => 'Creating the financial digital leaders of tomorrow.', 'km' => 'បង្កើតអ្នកដឹកនាំហិរញ្ញវត្ថុឌីជីថលនាពេលអនាគត។'],
                'goals' => ['en' => "1. Implement blockchain and cryptocurrency modules.\n2. Incubate 5 fintech startups annually.", 'km' => "១. ដាក់បញ្ចូលម៉ូឌុលបច្ចេកវិទ្យា Blockchain និងរូបិយប័ណ្ណឌីជីថល។\n២. បណ្តុះបណ្តាលសហគ្រាស Fintech សាកល្បងចំនួន ៥ ជារៀងរាល់ឆ្នាំ។"],
                'departments' => [
                    [
                        'name' => ['en' => 'Department of Digital Economy', 'km' => 'ដេប៉ាតឺម៉ង់សេដ្ឋកិច្ចឌីជីថល'], 
                        'slug' => 'digital-economy', 
                        'description' => ['en' => 'Studies digital transaction economics, finance, and cryptocurrency frameworks.', 'km' => 'សិក្សាអំពីសេដ្ឋកិច្ចប្រតិបត្តិការឌីជីថល ហិរញ្ញវត្ថុ និងក្របខ័ណ្ឌរូបិយប័ណ្ណគ្រីបតូ។']
                    ],
                    [
                        'name' => ['en' => 'Department of E-Commerce', 'km' => 'ដេប៉ាតឺម៉ង់ពាណិជ្ជកម្មអេឡិចត្រូនិក'], 
                        'slug' => 'e-commerce', 
                        'description' => ['en' => 'Covers dropshipping, digital stores, logistics, online payment, and analytics.', 'km' => 'គ្របដណ្តប់លើការលក់បន្តដោយគ្មានស្តុក (Dropshipping) ហាងឌីជីថល ភស្តុភារ ការទូទាត់ប្រាក់តាមអ៊ីនធឺណិត និងការវិភាគទិន្នន័យ។']
                    ]
                ],
            ],
        ];

        $facultiesMenu = NavigationItem::where('label', 'like', '%FACULTIES%')->first();
        
        foreach ($facultiesData as $id => $fData) {
            $faculty = Faculty::updateOrCreate(
                ['id' => $id],
                [
                    'name' => $fData['name'],
                    'org_chart_image' => $fData['org_chart_image'],
                    'mission' => $fData['mission'],
                    'vision' => $fData['vision'],
                    'goals' => $fData['goals'],
                ]
            );

            if ($facultiesMenu) {
                NavigationItem::updateOrCreate(
                    ['href' => '/department/' . $faculty->id],
                    [
                        'label' => $fData['name'],
                        'parent_id' => $facultiesMenu->id,
                        'order' => $id,
                    ]
                );
            }

            foreach ($fData['departments'] as $dData) {
                Department::updateOrCreate(
                    [
                        'faculty_id' => $faculty->id,
                        'slug' => $dData['slug']
                    ],
                    [
                        'name' => $dData['name'],
                        'description' => $dData['description'],
                        'mission' => ['en' => 'Mission details for ' . $dData['name']['en'], 'km' => 'ព័ត៌មានលម្អិតអំពីបេសកកម្មសម្រាប់ ' . $dData['name']['km']],
                        'vision' => ['en' => 'Vision details for ' . $dData['name']['en'], 'km' => 'ព័ត៌មានលម្អិតអំពីចក្ខុវិស័យសម្រាប់ ' . $dData['name']['km']],
                        'goals' => ['en' => 'Goals details for ' . $dData['name']['en'], 'km' => 'ព័ត៌មានលម្អិតអំពីគោលដៅសម្រាប់ ' . $dData['name']['km']],
                    ]
                );
            }
        }

        ActivityLog::log("Restored default faculties & departments structure", 'faculties', 'bg-amber-500/10 text-amber-500');

        return redirect()->back()->with('success', 'Default faculties restored successfully.');
    }

    public function restoreDefaultPageContent($id = 'all')
    {
        $rectorContent = [
            'rector_name' => ['en' => 'H.E. Dr. KHEM Phearun', 'km' => 'ឯកឧត្តម បណ្ឌិត ខឹម ភារុណ'],
            'rector_title' => ['en' => 'Rector of the Digital University of Cambodia', 'km' => 'សាកលវិទ្យាធិការ នៃសាកលវិទ្យាល័យឌីជីថលកម្ពុជា'],
            'paragraphs_en' => "<p>The Digital University of Cambodia (DUC) was established to spearhead technological innovation, offering higher education aligned with modern digital economic transformation.</p><p>Our academic programs foster creative problem-solving, digital literacy, and leadership in emerging industries.</p>",
            'paragraphs_km' => "<p>សាកលវិទ្យាល័យឌីជីថលកម្ពុជា (DUC) ត្រូវបានបង្កើតឡើងដើម្បីដឹកនាំនវានុវត្តន៍បច្ចេកវិទ្យា ដោយផ្តល់ជូននូវការអប់រំឧត្តមសិក្សាស្របតាមការផ្លាស់ប្តូរសេដ្ឋកិច្ចឌីជីថលទំនើប។</p><p>កម្មវិធីសិក្សារបស់យើងបណ្តុះបណ្តាលការដោះស្រាយបញ្ហាប្រកបដោយភាពច្នៃប្រឌិត ចំណេះដឹងឌីជីថល និងភាពជាអ្នកដឹកនាំក្នុងឧស្សាហកម្មដែលកំពុងលេចធ្លោ។</p>"
        ];

        $aboutContent = [
            'history' => [
                'en' => "The Digital University of Cambodia (DUC) is the first digital university in the Kingdom of Cambodia to focus on technology in line with the Royal Government of Cambodia's strategy of one corner: technology.\n\nThe DUC was recognized by a Royal Decree dated March 22, 2024. After operating for the past four months, DUC has been operating normally, with activities in the Faculty of Digital Industry, Faculty of Foreign Languages Education, Faculty of Agriculture and Rural Development, and Faculty of Engineering and Architecture, Faculty of Law and Political Science, Faculty of Economics and Finance.\n\nAt the same time, the university does not yet have a platform such as the official website of the university. Comprehensive and convenient for International course for use in DUC.",
                'km' => "សាកលវិទ្យាល័យឌីជីថលកម្ពុជា (DUC) គឺជាសាកលវិទ្យាល័យឌីជីថលដំបូងគេបង្អស់នៅក្នុងព្រះរាជាណាចក្រកម្ពុជា ដែលផ្តោតលើបច្ចេកវិទ្យា ស្របតាមយុទ្ធសាស្ត្របញ្ចកោណរបស់រាជរដ្ឋាភិបាលកម្ពុជា។\n\nDUC ត្រូវបានទទួលស្គាល់ដោយព្រះរាជក្រឹត្យចុះថ្ងៃទី២២ ខែមីនា ឆ្នាំ២០២៤។ បន្ទាប់ពីដំណើរការអស់រយៈពេលបួនខែកន្លងមកនេះ DUC បាននិងកំពុងដំណើរការជាធម្មតា ជាមួយនឹងសកម្មភាពនានានៅក្នុងមហាវិទ្យាល័យឧស្សាហកម្មឌីជីថល មហាវិទ្យាល័យអប់រំភាសាបរទេស មហាវិទ្យាល័យកសិកម្ម និងអភិវឌ្ឍន៍ជនបទ មហាវិទ្យាល័យវិស្វកម្ម និងស្ថាបត្យកម្ម មហាវិទ្យាល័យច្បាប់ និងវិទ្យាសាស្ត្រនយោបាយ និងមហាវិទ្យាល័យសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ។"
            ],
            'goals' => [
                ['en' => "The Department of Graphic Design,", 'km' => "ដេប៉ាតឺម៉ង់រចនាក្រាហ្វិក,"],
                ['en' => "the Department of Digital Marketing,", 'km' => "ដេប៉ាតឺម៉ង់ទីផ្សារឌីជីថល,"],
                ['en' => "the Department of Social Media,", 'km' => "ដេប៉ាតឺម៉ង់បណ្តាញសង្គម,"],
                ['en' => "the Department of English Education,", 'km' => "ដេប៉ាតឺម៉ង់អប់រំភាសាអង់គឡេស,"],
                ['en' => "the Department of Agriculture and Horticulture,", 'km' => "ដេប៉ាតឺម៉ង់ក្សេត្រសាស្ត្រ និងវប្បកម្ម,"],
                ['en' => "the Department of Architecture and", 'km' => "ដេប៉ាតឺម៉ង់ស្ថាបត្យកម្ម និង"],
                ['en' => "the Department of Public Administration,", 'km' => "ដេប៉ាតឺម៉ង់រដ្ឋបាលសាធារណៈ,"],
                ['en' => "the Department of Economics and", 'km' => "ដេប៉ាតឺម៉ង់សេដ្ឋកិច្ច និង"],
                ['en' => "the Department of Public Administration.", 'km' => "ដេប៉ាតឺម៉ង់រដ្ឋបាលសាធារណៈ។"]
            ],
            'mission' => [
                'en' => "The DUC was recognized by a Royal Decree dated March 22, 2024. After operating for the past four months, DUC has been operating normally, with activities in the Faculty of Digital Industry, Faculty of Foreign Languages Education, Faculty of Agriculture and Rural Development, and Faculty of Engineering and Architecture, Faculty of Law and Political Science, Faculty Economics and Finance. These include the Department of Information Technology.",
                'km' => "DUC ត្រូវបានទទួលស្គាល់ដោយព្រះរាជក្រឹត្យចុះថ្ងៃទី២២ ខែមីនា ឆ្នាំ២០២៤។ បន្ទាប់ពីដំណើរការអស់រយៈពេលបួនខែកន្លងមកនេះ DUC បាននិងកំពុងដំណើរការជាធម្មតា ជាមួយនឹងសកម្មភាពនានានៅក្នុងមហាវិទ្យាល័យឧស្សាហកម្មឌីជីថល មហាវិទ្យាល័យអប់រំភាសាបរទេស មហាវិទ្យាល័យកសិកម្ម និងអភិវឌ្ឍន៍ជនបទ និងមហាវិទ្យាល័យវិស្វកម្ម និងស្ថាបត្យកម្ម មហាវិទ្យាល័យច្បាប់ និងវិទ្យាសាស្ត្រនយោបាយ មហាវិទ្យាល័យសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ។ ទាំងនេះរួមមាន ដេប៉ាតឺម៉ង់បច្ចេកវិទ្យាព័ត៌មាន។"
            ],
            'vision' => [
                'en' => "Vision content coming soon...",
                'km' => "ព័ត៌មានចក្ខុវិស័យនឹងមកដល់ឆាប់ៗនេះ..."
            ]
        ];

        $examContent = [
            'intro' => [
                'en' => 'Official examination policy guidelines and grading evaluation criteria at Digital University of Cambodia.',
                'km' => 'គោលការណ៍ណែនាំស្តីពីការប្រឡង និងលក្ខណៈវិនិច្ឆ័យវាយតម្លៃពិន្ទុផ្លូវការនៅសាកលវិទ្យាល័យឌីជីថលកម្ពុជា។'
            ],
            'breakdown' => [
                ['criteria' => ['en' => 'Midterm Examination', 'km' => 'ការប្រឡងឆមាសទី១'], 'percentage' => '30%'],
                ['criteria' => ['en' => 'Final Examination', 'km' => 'ការប្រឡងបញ្ចប់ឆមាស'], 'percentage' => '40%'],
                ['criteria' => ['en' => 'Class Attendance & Participation', 'km' => 'វត្តមាន និងការចូលរួមក្នុងថ្នាក់'], 'percentage' => '10%'],
                ['criteria' => ['en' => 'Assignments & Quizzes', 'km' => 'កិច្ចការផ្ទះ និងការធ្វើតេស្តសាកល្បង'], 'percentage' => '20%']
            ],
            'grades' => [
                ['score' => '85 - 100', 'letter' => 'A', 'points' => '4.0', 'description' => ['en' => 'Excellent', 'km' => 'ល្អប្រសើរ']],
                ['score' => '80 - 84', 'letter' => 'B+', 'points' => '3.5', 'description' => ['en' => 'Very Good', 'km' => 'ល្អណាស់']],
                ['score' => '70 - 79', 'letter' => 'B', 'points' => '3.0', 'description' => ['en' => 'Good', 'km' => 'ល្អ']],
                ['score' => '65 - 69', 'letter' => 'C+', 'points' => '2.5', 'description' => ['en' => 'Fairly Good', 'km' => 'ល្អបង្គួរ']],
                ['score' => '50 - 64', 'letter' => 'C', 'points' => '2.0', 'description' => ['en' => 'Fair', 'km' => 'មធ្យម']],
                ['score' => '< 50', 'letter' => 'F', 'points' => '0.0', 'description' => ['en' => 'Fail', 'km' => 'ធ្លាក់']]
            ]
        ];

        $defaultOffices = [
            [
                'title' => 'Personnel and Human Resources Office',
                'slug' => 'personnel_and_human_resources',
                'image' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&q=80&w=1200',
                'about' => ['en' => 'Responsible for human resource planning, staff recruitment, and staff welfare.', 'km' => 'ទទួលខុសត្រូវលើការរៀបចំផែនការធនធានមនុស្ស ការជ្រើសរើសបុគ្គលិក និងសុខុមាលភាពបុគ្គលិក។'],
                'mission' => ['en' => 'To support administrative staff and faculty members.', 'km' => 'ដើម្បីគាំទ្របុគ្គលិករដ្ឋបាល និងសាស្ត្រាចារ្យ។'],
                'vision' => ['en' => 'A professional and motivated university workforce.', 'km' => 'កម្លាំងពលកម្មសាកលវិទ្យាល័យប្រកបដោយវិជ្ជាជីវៈ និងការលើកទឹកចិត្ត។']
            ],
            [
                'title' => 'Student Affairs Office',
                'slug' => 'student_affairs_office',
                'image' => 'https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&q=80&w=1200',
                'about' => ['en' => 'Manages student welfare, extracurricular activities, and guidance.', 'km' => 'គ្រប់គ្រងសុខុមាលភាពនិស្សិត សកម្មភាពក្រៅផ្លូវការ និងការណែនាំ។'],
                'mission' => ['en' => 'Promote vibrant student life and campus engagement.', 'km' => 'លើកកម្ពស់ជីវិតនិស្សិតដ៏រស់រវើក និងការចូលរួមក្នុងបរិវេណសាលា។'],
                'vision' => ['en' => 'Comprehensive development for all students.', 'km' => 'ការអភិវឌ្ឍគ្រប់ជ្រុងជ្រោយសម្រាប់និស្សិតទាំងអស់។']
            ],
            [
                'title' => 'Academic Affairs Office',
                'slug' => 'academic_affairs_office',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=1200',
                'about' => ['en' => 'Oversees curriculum development, course schedules, and degree validation.', 'km' => 'មើលការខុសត្រូវលើការអភិវឌ្ឍកម្មវិធីសិក្សា កាលវិភាគវគ្គសិក្សា និងការបញ្ជាក់សញ្ញាបត្រ។'],
                'mission' => ['en' => 'Maintain academic excellence and quality standards.', 'km' => 'រក្សាឧត្តមភាពសិក្សា និងស្តង់ដារគុណភាព។'],
                'vision' => ['en' => 'Top-tier digital education standards.', 'km' => 'ស្តង់ដារអប់រំឌីជីថលលំដាប់កំពូល។']
            ],
            [
                'title' => 'Administration and Accounting Office',
                'slug' => 'administration_and_accounting_office',
                'image' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=1200',
                'about' => ['en' => 'Handles financial management, tuition billing, and procurement.', 'km' => 'ដោះស្រាយការគ្រប់គ្រងហិរញ្ញវត្ថុ ការចេញវិក្កយបត្រថ្លៃសិក្សា និងការទិញផ្គត់ផ្គង់។'],
                'mission' => ['en' => 'Transparent and efficient financial operations.', 'km' => 'ប្រតិបត្តិការហិរញ្ញវត្ថុប្រកបដោយតម្លាភាព និងប្រសិទ្ធភាព។'],
                'vision' => ['en' => 'Sustainable financial framework.', 'km' => 'ក្របខ័ណ្ឌហិរញ្ញវត្ថុប្រកបដោយនិរន្តរភាព។']
            ],
            [
                'title' => 'Dormitory Office',
                'slug' => 'dormitory_office',
                'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&q=80&w=1200',
                'about' => ['en' => 'Manages student housing, safety, and residential services.', 'km' => 'គ្រប់គ្រងអន្តេវាសិកដ្ឋាននិស្សិត សុវត្ថិភាព និងសេវាកម្មស្នាក់នៅ។'],
                'mission' => ['en' => 'Safe and comfortable living space for students.', 'km' => 'កន្លែងរស់នៅដែលមានសុវត្ថិភាព និងផាសុកភាពសម្រាប់និស្សិត។'],
                'vision' => ['en' => 'Home away from home for DUC students.', 'km' => 'ផ្ទះទីពីរសម្រាប់និស្សិត DUC។']
            ],
            [
                'title' => 'Internal Quality Assurance Office',
                'slug' => 'internal_quality_assurance_office',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=1200',
                'about' => ['en' => 'Ensures educational quality standards and institutional accreditation.', 'km' => 'ធានាស្តង់ដារគុណភាពអប់រំ និងការទទួលស្គាល់គុណភាពអប់រំ។'],
                'mission' => ['en' => 'Continuous quality improvement in education.', 'km' => 'ការកែលម្អគុណភាពអប់រំជាបន្តបន្ទាប់។'],
                'vision' => ['en' => 'Internationally recognized quality assurance.', 'km' => 'ការធានាគុណភាពដែលទទួលស្គាល់ជាអន្តរជាតិ។']
            ],
            [
                'title' => 'Planning and Research Office',
                'slug' => 'planning_and_research_office',
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=1200',
                'about' => ['en' => 'Drives institutional research projects, grants, and strategic planning.', 'km' => 'រុញច្រានគម្រោងស្រាវជ្រាវ ការផ្តល់អាហារូបករណ៍ និងការរៀបចំផែនការយុទ្ធសាស្ត្រ។'],
                'mission' => ['en' => 'Foster research innovation and institutional development.', 'km' => 'បណ្តុះបណ្តាលនវានុវត្តន៍ស្រាវជ្រាវ និងការអភិវឌ្ឍស្ថាប័ន។'],
                'vision' => ['en' => 'Hub for cutting-edge research in Cambodia.', 'km' => 'មជ្ឈមណ្ឌលសម្រាប់ការស្រាវជ្រាវឈានមុខគេនៅកម្ពុជា។']
            ]
        ];

        if ($id === 'all' || $id === '0' || !$id) {
            // Restore any soft-deleted pages back to active
            PageContent::onlyTrashed()->restore();

            // Re-create / Restore Rector's Message
            PageContent::updateOrCreate(
                ['slug' => 'rector'],
                [
                    'title' => "Rector's Message",
                    'is_office' => false,
                    'content' => json_encode($rectorContent)
                ]
            );

            // Re-create / Restore About Us
            PageContent::updateOrCreate(
                ['slug' => 'about'],
                [
                    'title' => 'About Us',
                    'is_office' => false,
                    'content' => json_encode($aboutContent)
                ]
            );

            // Re-create / Restore Exam & Evaluation
            PageContent::updateOrCreate(
                ['slug' => 'exam-evaluation'],
                [
                    'title' => 'Exam and Evaluation',
                    'is_office' => false,
                    'content' => json_encode($examContent)
                ]
            );

            // Re-create / Restore all Offices
            foreach ($defaultOffices as $off) {
                PageContent::updateOrCreate(
                    ['slug' => $off['slug']],
                    [
                        'title' => $off['title'],
                        'is_office' => true,
                        'content' => json_encode([
                            'about' => $off['about'],
                            'mission' => $off['mission'],
                            'vision' => $off['vision'],
                            'image' => $off['image'] ?? ''
                        ])
                    ]
                );
            }

            ActivityLog::log("Restored default content for all system pages", 'pages', 'bg-amber-500/10 text-amber-500');
            return redirect()->back()->with('success', 'Default page contents restored successfully.');
        }

        // Single page restoration (by ID or slug)
        $page = PageContent::withTrashed()->find($id);
        if (!$page) {
            $page = PageContent::withTrashed()->where('slug', $id)->first();
        }

        if ($page) {
            if ($page->trashed()) {
                $page->restore();
            }

            if ($page->slug === 'rector' || $page->id == 1) {
                $page->update(['title' => "Rector's Message", 'content' => json_encode($rectorContent)]);
            } else if ($page->slug === 'about' || $page->id == 2) {
                $page->update(['title' => 'About Us', 'content' => json_encode($aboutContent)]);
            } else if ($page->slug === 'exam-evaluation' || $page->id == 3) {
                $page->update(['title' => 'Exam and Evaluation', 'content' => json_encode($examContent)]);
            } else if ($page->is_office) {
                $matchedOffice = collect($defaultOffices)->firstWhere('slug', $page->slug);
                if ($matchedOffice) {
                    $page->update([
                        'title' => $matchedOffice['title'],
                        'content' => json_encode([
                            'about' => $matchedOffice['about'],
                            'mission' => $matchedOffice['mission'],
                            'vision' => $matchedOffice['vision'],
                            'image' => ''
                        ])
                    ]);
                }
            }
        } else {
            // If page was completely absent, recreate based on known default slugs
            if ($id == 1 || $id === 'rector') {
                PageContent::updateOrCreate(['slug' => 'rector'], ['title' => "Rector's Message", 'is_office' => false, 'content' => json_encode($rectorContent)]);
            } else if ($id == 2 || $id === 'about') {
                PageContent::updateOrCreate(['slug' => 'about'], ['title' => 'About Us', 'is_office' => false, 'content' => json_encode($aboutContent)]);
            } else if ($id == 3 || $id === 'exam-evaluation') {
                PageContent::updateOrCreate(['slug' => 'exam-evaluation'], ['title' => 'Exam and Evaluation', 'is_office' => false, 'content' => json_encode($examContent)]);
            } else {
                $matchedOffice = collect($defaultOffices)->firstWhere('slug', $id);
                if ($matchedOffice) {
                    PageContent::updateOrCreate(
                        ['slug' => $matchedOffice['slug']],
                        [
                            'title' => $matchedOffice['title'],
                            'is_office' => true,
                            'content' => json_encode([
                                'about' => $matchedOffice['about'],
                                'mission' => $matchedOffice['mission'],
                                'vision' => $matchedOffice['vision'],
                                'image' => ''
                            ])
                        ]
                    );
                }
            }
        }

        ActivityLog::log("Restored default content for page #{$id}", 'pages', 'bg-amber-500/10 text-amber-500');
        return redirect()->back()->with('success', 'Default page content restored successfully.');
    }

    public function restoreDefaultNavigation()
    {
        NavigationItem::truncate();
        
        $home = NavigationItem::create([
            'label' => ['en' => 'HOME', 'km' => 'ទំព័រដើម'],
            'href' => '/',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 012 0v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>',
            'order' => 1
        ]);
        
        $about = NavigationItem::create([
            'label' => ['en' => 'ABOUT', 'km' => 'អំពីយើង'],
            'href' => '/about',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
            'order' => 2
        ]);
        NavigationItem::create(['label' => ['en' => "Rector's Message", 'km' => 'សាររបស់សាកលវិទ្យាធិការ'], 'href' => '/rector', 'parent_id' => $about->id, 'order' => 1]);
        
        $officesMenu = NavigationItem::create(['label' => ['en' => 'Offices', 'km' => 'ការិយាល័យ'], 'href' => '#', 'parent_id' => $about->id, 'order' => 2]);
        NavigationItem::create(['label' => ['en' => 'Personnel and Human Resources Office', 'km' => 'ការិយាល័យបុគ្គលិក និងអភិវឌ្ឍន៍ធនធានមនុស្ស'], 'href' => '/personnel_and_human_resources', 'parent_id' => $officesMenu->id, 'order' => 1]);
        NavigationItem::create(['label' => ['en' => 'Student Affairs Office', 'km' => 'ការិយាល័យកិច្ចការនិស្សិត'], 'href' => '/student_affairs_office', 'parent_id' => $officesMenu->id, 'order' => 2]);
        NavigationItem::create(['label' => ['en' => 'Academic Affairs Office', 'km' => 'ការិយាល័យសិក្សាធិការ'], 'href' => '/academic_affairs_office', 'parent_id' => $officesMenu->id, 'order' => 3]);
        NavigationItem::create(['label' => ['en' => 'Administration and Accounting Office', 'km' => 'ការិយាល័យរដ្ឋបាល និងហិរញ្ញវត្ថុ'], 'href' => '/administration_and_accounting_office', 'parent_id' => $officesMenu->id, 'order' => 4]);
        NavigationItem::create(['label' => ['en' => 'Dormitory Office', 'km' => 'ការិយាល័យអន្តេវាសិកដ្ឋាន'], 'href' => '/dormitory_office', 'parent_id' => $officesMenu->id, 'order' => 5]);
        NavigationItem::create(['label' => ['en' => 'Internal Quality Assurance Office', 'km' => 'ការិយាល័យធានាគុណភាពផ្ទៃក្នុង'], 'href' => '/internal_quality_assurance_office', 'parent_id' => $officesMenu->id, 'order' => 6]);
        NavigationItem::create(['label' => ['en' => 'Planning and Research Office', 'km' => 'ការិយាល័យផែនការ និងស្រាវជ្រាវ'], 'href' => '/planning_and_research_office', 'parent_id' => $officesMenu->id, 'order' => 7]);
        
        NavigationItem::create(['label' => ['en' => 'Exam and Evaluation', 'km' => 'ការវាយតម្លៃ និងការប្រឡង'], 'href' => '/exam-evaluation', 'parent_id' => $about->id, 'order' => 3]);

        $facultiesMenu = NavigationItem::create([
            'label' => ['en' => 'FACULTIES', 'km' => 'មហាវិទ្យាល័យ'],
            'href' => '/faculties',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/></svg>',
            'order' => 3
        ]);

        $faculties = Faculty::all();
        $fOrder = 1;
        foreach ($faculties as $fac) {
            $facMenu = NavigationItem::create([
                'label' => $fac->name,
                'href' => '/department/' . $fac->id,
                'parent_id' => $facultiesMenu->id,
                'order' => $fOrder++,
            ]);

            $dOrder = 1;
            foreach ($fac->departments as $dept) {
                NavigationItem::create([
                    'label' => $dept->name,
                    'href' => '/faculty/' . $fac->id . '/department/' . $dept->slug,
                    'parent_id' => $facMenu->id,
                    'order' => $dOrder++,
                ]);
            }
        }

        NavigationItem::create([
            'label' => ['en' => 'EVENTS', 'km' => 'ព័ត៌មាន និងព្រឹត្តិការណ៍'],
            'href' => '/events',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
            'order' => 4
        ]);

        NavigationItem::create([
            'label' => ['en' => 'CONTACT', 'km' => 'ទំនាក់ទំនង'],
            'href' => '/contact',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>',
            'order' => 5
        ]);

        ActivityLog::log("Restored default navigation menu structure", 'navigation', 'bg-amber-500/10 text-amber-500');

        return redirect()->back()->with('success', 'Default navigation restored successfully.');
    }

    public function restoreDefaultEvents()
    {
        Event::truncate();
        $eventsData = [
            [
                'id' => 1,
                'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1400&q=85',
                'type' => 'campus',
                'title' => ['en' => 'Annual International Tech Innovation Summit 2024', 'km' => 'កិច្ចប្រជុំកំពូលនវានុវត្តន៍បច្ចេកវិទ្យាអន្តរជាតិប្រចាំឆ្នាំ ២០២៤'],
                'date' => ['en' => '15 /June /2024', 'km' => '១៥ /មិថុនា /២០២៤'],
                'description' => ['en' => 'Join global technology leaders and academicians exploring advancements in AI, software engineering, and digital economies.', 'km' => 'ចូលរួមជាមួយអ្នកដឹកនាំបច្ចេកវិទ្យាសកល និងអ្នកសិក្សាស្រាវជ្រាវក្នុងការស្វែងយល់ពីការរីកចម្រើននៃ AI វិស្វកម្មសូហ្វវែរ និងសេដ្ឋកិច្ចឌីជីថល។'],
                'content' => ['en' => 'The summit will feature keynote sessions from international experts, panel discussions on emerging technologies, and workshops for students and industry practitioners.', 'km' => 'កិច្ចប្រជុំកំពូលនេះនឹងមានវគ្គបទបង្ហាញសំខាន់ៗពីអ្នកជំនាញអន្តរជាតិ ការពិភាក្សាពិគ្រោះយោបល់លើបច្ចេកវិទ្យាដែលកំពុងលេចធ្លោ និងសិក្ខាសាលាសម្រាប់និស្សិត និងអ្នកអនុវត្តក្នុងឧស្សាហកម្ម។']
            ],
            [
                'id' => 2,
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1400&q=85',
                'type' => 'digital',
                'title' => ['en' => 'National E-Commerce & Digital Economy Forum', 'km' => 'វេទិកាសេដ្ឋកិច្ចឌីជីថល និងពាណិជ្ជកម្មអេឡិចត្រូនិកថ្នាក់ជាតិ'],
                'date' => ['en' => '12 /July /2024', 'km' => '១២ /កក្កដា /២០២៤'],
                'description' => ['en' => 'Leading industry speakers present on the future of decentralised finance and electronic trade in Cambodia.', 'km' => 'វាគ្មិនឈានមុខគេក្នុងឧស្សាហកម្មធ្វើបទបង្ហាញអំពីអនាគតនៃហិរញ្ញវត្ថុវិមជ្ឈការ និងពាណិជ្ជកម្មអេឡិចត្រូនិកនៅក្នុងប្រទេសកម្ពុជា។'],
                'content' => ['en' => 'This conference covers Web3, e-commerce integrations, digital wallets, and blockchain security protocols in cooperation with regional banks.', 'km' => 'សន្និសីទនេះគ្របដណ្តប់លើ Web3 ការធ្វើសមាហរណកម្មពាណិជ្ជកម្មអេឡិចត្រូនិក កាបូបលុយឌីជីថល និងពិធីសារសុវត្ថិភាពប្លុកឆេន សហការជាមួយធនាគារក្នុងតំបន់។']
            ],
            [
                'id' => 3,
                'image' => 'https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1400&q=85',
                'type' => 'announcement',
                'title' => ['en' => 'Admission Scholarship Program open', 'km' => 'ការបើកទទួលពាក្យកម្មវិធីអាហារូបករណ៍ថ្នាក់បរិញ្ញាបត្រ'],
                'date' => ['en' => '20 /August /2024', 'km' => '២០ /សីហា /២០២៤'],
                'description' => ['en' => 'Apply for full and partial scholarship slots in technology, architecture, and language majors.', 'km' => 'ដាក់ពាក្យស្នើសុំអាហារូបករណ៍ពេញ និងមួយផ្នែក លើជំនាញបច្ចេកវិទ្យា ស្ថាបត្យកម្ម និងភាសាអង់គ្លេស។'],
                'content' => ['en' => 'Scholarship applications are open to local high school graduates showing excellent performance in mathematics, language, and technology fields.', 'km' => 'ការដាក់ពាក្យសុំអាហារូបករណ៍ត្រូវបានបើកចំហសម្រាប់សិស្សវិទ្យាល័យក្នុងស្រុកដែលមានលទ្ធផលឆ្នើមលើមុខវិជ្ជាគណិតវិទ្យា ភាសា និងបច្ចេកវិទ្យា។']
            ]
        ];
        foreach ($eventsData as $e) Event::create($e);
        ActivityLog::log("Restored default event articles", 'events', 'bg-amber-500/10 text-amber-500');
        return redirect()->back()->with('success', 'Default events restored successfully.');
    }

    public function restoreDefaultTranslations()
    {
        $translations = [
            'Welcome to the Digital University of Cambodia' => 'សូមស្វាគមន៍មកកាន់សាកលវិទ្យាល័យឌីជីថលកម្ពុជា',
            'Empowering the next generation of digital leaders and creative innovators.' => 'ការផ្តល់អំណាចដល់អ្នកដឹកនាំឌីជីថល និងអ្នកច្នៃប្រឌិតជំនាន់ក្រោយ។',
            'Explore Programs' => 'ស្វែងយល់ពីកម្មវិធីសិក្សា',
            'Learn More' => 'ស្វែងយល់បន្ថែម',
            'Contact Us' => 'ទាក់ទងមកយើង',
            'Get in Touch' => 'ទាក់ទងមកយើងខ្ញុំ',
            'News/Event' => 'ព័ត៌មាន និងព្រឹត្តិការណ៍',
            'Scholarship for Students' => 'អាហារូបករណ៍សម្រាប់និស្សិត',
            'Graduate Attributes' => 'គុណវុឌ្ឍិរបស់និស្សិតបញ្ចប់ការសិក្សា',
            'Four Years Study' => 'ការសិក្សារយៈពេលបួនឆ្នាំ',
            'Students Activities' => 'សកម្មភាពនិស្សិត',
            'First Name' => 'នាមខ្លួន',
            'Last Name' => 'នាមត្រកូល',
            'Email Address' => 'អាសយដ្ឋានអ៊ីមែល',
            'Phone Number' => 'លេខទូរស័ព្ទ',
            'Subject' => 'ប្រធានបទ',
            'Your Message' => 'សាររបស់អ្នក',
            'Send Message' => 'ផ្ញើសារ',
            'Direct lines' => 'លេខទូរស័ព្ទផ្ទាល់',
            'Social Network' => 'បណ្តាញសង្គម',
            'Overview' => 'ទិដ្ឋភាពទូទៅ',
            'Mission' => 'បេសកកម្ម',
            'Vision' => 'ចក្ខុវិស័យ',
            'Goals' => 'គោលដៅ',
            'Custom Sections' => 'ផ្នែកផ្សេងៗ'
        ];
        foreach ($translations as $key => $km) {
            \App\Models\Translation::updateOrCreate(['key' => $key], ['en' => $key, 'km' => $km]);
        }
        ActivityLog::log("Restored default translation keys", 'translations', 'bg-amber-500/10 text-amber-500');
        return redirect()->back()->with('success', 'Default translations restored successfully.');
    }

    public function restoreDefaultHomeSettings()
    {
        $homePage = PageContent::where('slug', 'home')->first();
        if ($homePage) {
            $homePage->update([
                'title' => 'Home Page',
                'content' => json_encode([
                    'home_hero_slides' => [
                        ['imgUrl' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1600&q=80', 'altText' => ['en' => 'Digital University Campus', 'km' => 'បរិវេណសាកលវិទ្យាល័យឌីជីថល']],
                        ['imgUrl' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1600&q=80', 'altText' => ['en' => 'Modern Technology Classroom', 'km' => 'បន្ទប់សិក្សាបច្ចេកវិទ្យាទំនើប']]
                    ],
                    'home_activities_slides' => [
                        ['img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80', 'alt' => ['en' => 'Student Workshops', 'km' => 'សិក្ខាសាលានិស្សិត']],
                        ['img' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80', 'alt' => ['en' => 'Tech Conference', 'km' => 'សន្និសីទបច្ចេកវិទ្យា']]
                    ]
                ])
            ]);
        }
        Setting::setValue('home_stats', json_encode([
            ['value' => '1', 'label' => ['en' => 'University Campus', 'km' => 'ទីតាំងសាកលវិទ្យាល័យ'], 'icon' => 'building'],
            ['value' => '1000+', 'label' => ['en' => 'Active Students', 'km' => 'និស្សិតសរុប'], 'icon' => 'student'],
            ['value' => '1200+', 'label' => ['en' => 'Computers & IT Devices', 'km' => 'កុំព្យូទ័រ & ឧបករណ៍'], 'icon' => 'computer'],
            ['value' => '50+', 'label' => ['en' => 'Professors & Lecturers', 'km' => 'សាស្ត្រាចារ្យ & បុគ្គលិក'], 'icon' => 'user']
        ]));
        return redirect()->back()->with('success', 'Default home settings restored.');
    }

    public function restoreDefaultSettings()
    {
        Setting::setValue('address', 'Kompong Spue, Cambodia');
        Setting::setValue('phone', '012 4444 12');
        Setting::setValue('email', 'duc2024@gmail.com');
        Setting::setValue('direct_lines', json_encode([
            '099 111 111 / 096 353 526',
            '012 444 412 / 016 826 7362'
        ]));
        Setting::setValue('copyright', 'Copyright © 2024 Digital University of Cambodia. All rights reserved.');
        Setting::setValue('social_links', json_encode([
            ['label' => 'Facebook', 'href' => 'https://www.facebook.com/DUCambodia/', 'svg' => '<svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>', 'class' => 'hover:bg-[#1877f2] bg-white/10'],
            ['label' => 'Telegram', 'href' => 'https://t.me/digitaluniversityofcambodia', 'svg' => '<svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>', 'class' => 'hover:bg-[#2aabee] bg-white/10'],
            ['label' => 'YouTube', 'href' => 'https://www.youtube.com/@DUCambodia', 'svg' => '<svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>', 'class' => 'hover:bg-[#ff0000] bg-white/10'],
            ['label' => 'Tiktok', 'href' => 'https://www.tiktok.com/@ducambodia', 'svg' => '<svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M16.6 5.82s.51.5 0 0A4.278 4.278 0 0 1 15.54 3h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6 0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64 0 3.33 2.76 5.7 5.69 5.7 3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48z"/></svg>', 'class' => 'hover:bg-black bg-white/10']
        ]));
        Setting::setValue('header_bg_color', '#ffffff');
        Setting::setValue('header_text_color', '#000000');
        Setting::setValue('footer_bg_color', '#0d184a');
        Setting::setValue('footer_border_color', '#04a8f5');
        Setting::setValue('footer_text_color', '#ffffff');
        Setting::setValue('sub_footer_bg_color', '#081033');
        Setting::setValue('sub_footer_text_color', '#94a3b8');
        Setting::setValue('sub_footer_border_color', '#1e293b');
        Setting::setValue('nav_bg_color', '#3852a4');
        Setting::setValue('nav_text_color', '#ffffff');
        Setting::setValue('nav_active_color', '#ffb800');
        Setting::setValue('contact_image', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80');
        Setting::setValue('privacy_policy_label', 'Privacy Policy');
        Setting::setValue('privacy_policy_url', '#');
        Setting::setValue('footer_credits', 'Made with ♥ by IT Department Students');
        ActivityLog::log("Restored default footer & contact settings", 'settings', 'bg-amber-500/10 text-amber-500');
        return redirect()->back()->with('success', 'Default footer settings restored successfully.');
    }

    public function deleteFaculty(Faculty $faculty)
    {
        $facName = is_array($faculty->name) ? ($faculty->name['en'] ?? '') : $faculty->name;
        // Delete child department navigation items first
        $departments = $faculty->departments;
        foreach ($departments as $dept) {
            $deptHref = '/faculty/' . $faculty->id . '/department/' . $dept->slug;
            NavigationItem::where('href', $deptHref)->delete();
        }

        // Delete faculty navigation item
        $facHref = '/department/' . $faculty->id;
        NavigationItem::where('href', $facHref)->delete();

        // Delete the departments and the faculty itself
        $faculty->departments()->delete();
        $faculty->delete();
        ActivityLog::log("Deleted faculty '" . $facName . "'", 'faculties', 'bg-red-500/10 text-red-500');
        return redirect()->back()->with('success', 'Faculty deleted.');
    }

    public function saveDepartment(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.km' => 'nullable|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|array',
            'description.en' => 'nullable|string',
            'description.km' => 'nullable|string',
            'mission' => 'nullable|array',
            'mission.en' => 'nullable|string',
            'mission.km' => 'nullable|string',
            'vision' => 'nullable|array',
            'vision.en' => 'nullable|string',
            'vision.km' => 'nullable|string',
            'goals' => 'nullable|array',
            'goals.en' => 'nullable|string',
            'goals.km' => 'nullable|string',
            'custom_sections' => 'nullable|array',
            'programs' => 'nullable|array',
            'majors' => 'nullable|array',
        ]);

        $oldDept = isset($validated['id']) ? Department::find($validated['id']) : null;
        $oldHref = null;
        if ($oldDept) {
            $oldHref = '/faculty/' . $oldDept->faculty_id . '/department/' . $oldDept->slug;
        }

        $dept = Department::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'faculty_id' => $validated['faculty_id'],
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'mission' => $validated['mission'],
                'vision' => $validated['vision'],
                'goals' => $validated['goals'],
                'custom_sections' => isset($validated['custom_sections']) ? json_encode($validated['custom_sections']) : null,
                'programs' => isset($validated['programs']) ? json_encode($validated['programs']) : null,
                'majors' => $validated['majors'] ?? null,
            ]
        );

        // Sync with NavigationItem
        $facultyHref = '/department/' . $dept->faculty_id;
        $parentMenu = NavigationItem::where('href', $facultyHref)->first();
        if ($parentMenu) {
            $newHref = '/faculty/' . $dept->faculty_id . '/department/' . $dept->slug;
            $navItem = null;
            if ($oldHref) {
                $navItem = NavigationItem::where('href', $oldHref)->first();
            }
            if ($navItem) {
                $navItem->update([
                    'label' => $dept->name,
                    'href' => $newHref,
                    'parent_id' => $parentMenu->id,
                ]);
            } else {
                $maxOrder = NavigationItem::where('parent_id', $parentMenu->id)->max('order') ?? 0;
                NavigationItem::create([
                    'label' => $dept->name,
                    'href' => $newHref,
                    'parent_id' => $parentMenu->id,
                    'order' => $maxOrder + 1,
                ]);
            }
        }

        $deptName = $validated['name']['en'] ?? 'Department';
        $actionText = ($validated['id'] ?? null) ? "Updated department '" . $deptName . "'" : "Created new department '" . $deptName . "'";
        ActivityLog::log($actionText, 'departments');

        return redirect()->back()->with('success', 'Department saved successfully.');
    }

    public function deleteDepartment(Department $department)
    {
        $deptName = is_array($department->name) ? ($department->name['en'] ?? '') : $department->name;
        $href = '/faculty/' . $department->faculty_id . '/department/' . $department->slug;
        NavigationItem::where('href', $href)->delete();

        $department->delete();
        ActivityLog::log("Deleted department '" . $deptName . "'", 'departments', 'bg-red-500/10 text-red-500');
        return redirect()->back()->with('success', 'Department deleted.');
    }

    // --- SETTINGS CRUD ---
    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'address' => 'nullable|array',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'copyright' => 'required|array',
            'direct_lines' => 'nullable|array',
            'social_links' => 'required|array',
            'header_bg_color' => 'nullable|string|max:50',
            'header_text_color' => 'nullable|string|max:50',
            'footer_bg_color' => 'nullable|string|max:50',
            'footer_border_color' => 'nullable|string|max:50',
            'footer_text_color' => 'nullable|string|max:50',
            'sub_footer_bg_color' => 'nullable|string|max:50',
            'sub_footer_text_color' => 'nullable|string|max:50',
            'sub_footer_border_color' => 'nullable|string|max:50',
            'nav_bg_color' => 'nullable|string|max:50',
            'nav_text_color' => 'nullable|string|max:50',
            'nav_active_color' => 'nullable|string|max:50',
            'contact_image' => 'nullable',
            'privacy_policy_label' => 'nullable|string|max:255',
            'privacy_policy_url' => 'nullable|string|max:255',
            'footer_credits' => 'nullable|string|max:255',
            'footer_label_quick_links' => 'nullable|array',
            'footer_label_working_hours' => 'nullable|array',
            'footer_label_social_media' => 'nullable|array',
            'footer_label_contact_info' => 'nullable|array',
            'footer_label_direct_lines' => 'nullable|array',
            'footer_map_url' => 'nullable|string',
            'footer_map_label' => 'nullable|array',
            'footer_working_hours_weekday_label' => 'nullable|array',
            'footer_working_hours_weekday_time' => 'nullable|array',
            'footer_working_hours_weekend_label' => 'nullable|array',
            'footer_working_hours_weekend_time' => 'nullable|array',
            'footer_quick_links' => 'nullable|array',
        ]);

    if (array_key_exists('address', $validated)) Setting::setValue('address', json_encode($validated['address']));
    if (array_key_exists('phone', $validated)) Setting::setValue('phone', $validated['phone']);
    if (array_key_exists('email', $validated)) Setting::setValue('email', $validated['email']);
    Setting::setValue('copyright', json_encode($validated['copyright'] ?? ['en' => 'Copyright © 2024 Digital University of Cambodia. All rights reserved.', 'km' => 'Copyright © 2024 Digital University of Cambodia. All rights reserved.']));
    if (array_key_exists('direct_lines', $validated)) Setting::setValue('direct_lines', json_encode($validated['direct_lines']));
        Setting::setValue('social_links', json_encode($validated['social_links']));
        Setting::setValue('header_bg_color', $validated['header_bg_color'] ?? '#ffffff');
        Setting::setValue('header_text_color', $validated['header_text_color'] ?? '#000000');
        Setting::setValue('footer_bg_color', $validated['footer_bg_color'] ?? '#0d184a');
        Setting::setValue('footer_border_color', $validated['footer_border_color'] ?? '#04a8f5');
        Setting::setValue('footer_text_color', $validated['footer_text_color'] ?? '#ffffff');
        Setting::setValue('sub_footer_bg_color', $validated['sub_footer_bg_color'] ?? '#081033');
        Setting::setValue('sub_footer_text_color', $validated['sub_footer_text_color'] ?? '#94a3b8');
        Setting::setValue('sub_footer_border_color', $validated['sub_footer_border_color'] ?? '#1e293b');
        Setting::setValue('nav_bg_color', $validated['nav_bg_color'] ?? '#3852a4');
        Setting::setValue('nav_text_color', $validated['nav_text_color'] ?? '#ffffff');
        Setting::setValue('nav_active_color', $validated['nav_active_color'] ?? '#ffb800');

        $contact_image = Setting::getValue('contact_image', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80');
        if ($request->hasFile('contact_image')) {
            $path = $request->file('contact_image')->store('settings', 'public');
            $contact_image = '/storage/' . $path;
        } else if ($request->filled('contact_image') && is_string($request->input('contact_image'))) {
            $contact_image = $request->input('contact_image');
        }
        Setting::setValue('contact_image', $contact_image);
        Setting::setValue('privacy_policy_label', $request->has('privacy_policy_label') ? ($request->input('privacy_policy_label') ?? '') : 'Privacy Policy');
        Setting::setValue('privacy_policy_url', $request->has('privacy_policy_url') ? ($request->input('privacy_policy_url') ?? '') : '#');
        Setting::setValue('footer_credits', $request->has('footer_credits') ? ($request->input('footer_credits') ?? '') : 'Made with ♥ by IT Department Students');

        Setting::setValue('footer_label_quick_links', json_encode($validated['footer_label_quick_links'] ?? ['en' => 'Our Details', 'km' => 'Our Details']));
        Setting::setValue('footer_label_working_hours', json_encode($validated['footer_label_working_hours'] ?? ['en' => 'Working Hours', 'km' => 'Working Hours']));
        Setting::setValue('footer_label_social_media', json_encode($validated['footer_label_social_media'] ?? ['en' => 'Social Media', 'km' => 'Social Media']));
        Setting::setValue('footer_label_contact_info', json_encode($validated['footer_label_contact_info'] ?? ['en' => 'Contact Information', 'km' => 'Contact Information']));
        Setting::setValue('footer_label_direct_lines', json_encode($validated['footer_label_direct_lines'] ?? ['en' => 'Direct Lines', 'km' => 'Direct Lines']));
        
        Setting::setValue('footer_map_url', $validated['footer_map_url'] ?? 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1518.5686343584584!2d104.76673604474675!3d11.416249673060195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2skh!4v1783649287380!5m2!1sen!2skh');
        Setting::setValue('footer_map_label', json_encode($validated['footer_map_label'] ?? ['en' => 'Phnom Penh Campus', 'km' => 'Phnom Penh Campus']));
        Setting::setValue('footer_working_hours_weekday_label', json_encode($validated['footer_working_hours_weekday_label'] ?? ['en' => 'Mon - Sat', 'km' => 'Mon - Sat']));
        Setting::setValue('footer_working_hours_weekday_time', json_encode($validated['footer_working_hours_weekday_time'] ?? ['en' => '8:00 AM - 5:00 PM', 'km' => '8:00 AM - 5:00 PM']));
        Setting::setValue('footer_working_hours_weekend_label', json_encode($validated['footer_working_hours_weekend_label'] ?? ['en' => 'Weekend', 'km' => 'Weekend']));
        Setting::setValue('footer_working_hours_weekend_time', json_encode($validated['footer_working_hours_weekend_time'] ?? ['en' => '8:00 AM - 4:00 PM', 'km' => '8:00 AM - 4:00 PM']));
        Setting::setValue('footer_quick_links', json_encode($validated['footer_quick_links'] ?? []));

        ActivityLog::log("Updated campus contact & social accounts settings", 'settings');

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    // --- CONTACT PAGE SETTINGS CRUD ---
    public function saveContactSettings(Request $request)
    {
        $validated = $request->validate([
            'contact_hero_title' => 'nullable|string|max:255',
            'contact_hero_description' => 'nullable|string',
            'contact_image' => 'nullable',
            'address' => 'nullable|array',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'direct_lines' => 'nullable|array',
            'social_links' => 'nullable|array',
        ]);

        Setting::setValue('contact_hero_title', $validated['contact_hero_title'] ?? 'Contact Us');
        Setting::setValue('contact_hero_description', $validated['contact_hero_description'] ?? 'Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.');

        if (array_key_exists('address', $validated)) Setting::setValue('address', json_encode($validated['address']));
        if (array_key_exists('phone', $validated)) Setting::setValue('phone', $validated['phone']);
        if (array_key_exists('email', $validated)) Setting::setValue('email', $validated['email']);
        if (array_key_exists('direct_lines', $validated)) Setting::setValue('direct_lines', json_encode($validated['direct_lines']));
        if (array_key_exists('social_links', $validated)) Setting::setValue('social_links', json_encode($validated['social_links']));

        $contact_image = Setting::getValue('contact_image', 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80');
        if ($request->hasFile('contact_image')) {
            $path = $request->file('contact_image')->store('settings', 'public');
            $contact_image = '/storage/' . $path;
        } else if ($request->filled('contact_image') && is_string($request->input('contact_image'))) {
            $contact_image = $request->input('contact_image');
        }
        Setting::setValue('contact_image', $contact_image);

        ActivityLog::log("Updated contact page settings", 'settings');

        return redirect()->back()->with('success', 'Contact settings updated successfully.');
    }

    // --- HOME PAGE SETTINGS CRUD ---
    public function saveHomeSettings(Request $request)
    {
        $validated = $request->validate([
            'home_hero_slides' => 'nullable|array',
            'home_scholarship' => 'nullable|array',
            'home_four_years' => 'nullable|array',
            'home_video_url' => 'nullable|string',
            'home_video_bg_color' => 'nullable|string',
            'home_video_bg_image' => 'nullable',
            'home_activities_slides' => 'nullable|array',
            'home_graduate_attributes' => 'nullable|array',
            'home_stats' => 'nullable|array',
        ]);

        $home_hero_slides = $validated['home_hero_slides'] ?? [];
        foreach ($home_hero_slides as $index => &$slide) {
            if ($request->hasFile("home_hero_slides.{$index}.imgUrl")) {
                $path = $request->file("home_hero_slides.{$index}.imgUrl")->store('home', 'public');
                $slide['imgUrl'] = '/storage/' . $path;
            }
        }

        $home_scholarship = $validated['home_scholarship'] ?? [];
        if ($request->hasFile('home_scholarship.bg_image')) {
            $path = $request->file('home_scholarship.bg_image')->store('home', 'public');
            $home_scholarship['bg_image'] = '/storage/' . $path;
        }

        $home_activities_slides = $validated['home_activities_slides'] ?? [];
        foreach ($home_activities_slides as $index => &$slide) {
            if ($request->hasFile("home_activities_slides.{$index}.img")) {
                $path = $request->file("home_activities_slides.{$index}.img")->store('home', 'public');
                $slide['img'] = '/storage/' . $path;
            }
        }

        $home_video_bg_image = $request->input('home_video_bg_image');
        if ($request->hasFile('home_video_bg_image')) {
            $path = $request->file('home_video_bg_image')->store('home', 'public');
            $home_video_bg_image = '/storage/' . $path;
        }

        $home_graduate_attributes = $validated['home_graduate_attributes'] ?? [];
        if (isset($home_graduate_attributes['cards']) && is_array($home_graduate_attributes['cards'])) {
            foreach ($home_graduate_attributes['cards'] as $index => &$card) {
                if ($request->hasFile("home_graduate_attributes.cards.{$index}.image")) {
                    $path = $request->file("home_graduate_attributes.cards.{$index}.image")->store('home', 'public');
                    $card['image'] = '/storage/' . $path;
                }
            }
        }
        
        // Fallback for older image uploads
        if ($request->hasFile('home_graduate_attributes.card_3.image')) {
            $path = $request->file('home_graduate_attributes.card_3.image')->store('home', 'public');
            if (!isset($home_graduate_attributes['card_3']) || !is_array($home_graduate_attributes['card_3'])) {
                $home_graduate_attributes['card_3'] = [];
            }
            $home_graduate_attributes['card_3']['image'] = '/storage/' . $path;
        }

        Setting::setValue('home_hero_slides', json_encode($home_hero_slides));
        Setting::setValue('home_scholarship', json_encode($home_scholarship));
        Setting::setValue('home_four_years', json_encode($validated['home_four_years'] ?? []));
        Setting::setValue('home_video_url', $validated['home_video_url'] ?? '');
        Setting::setValue('home_video_bg_image', $home_video_bg_image ?: '');
        Setting::setValue('home_video_bg_color', $validated['home_video_bg_color'] ?? '#0f2154');
        Setting::setValue('home_activities_slides', json_encode($home_activities_slides));
        Setting::setValue('home_graduate_attributes', json_encode($home_graduate_attributes));
        Setting::setValue('home_stats', json_encode($validated['home_stats'] ?? []));

        ActivityLog::log("Updated landing page builder settings", 'home');

        return redirect()->back()->with('success', 'Home page settings updated successfully.');
    }

    // --- TRANSLATIONS CRUD ---
    public function saveTranslation(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer',
            'key' => 'required|string',
            'en' => 'nullable|string',
            'km' => 'nullable|string',
        ]);

        $existing = \App\Models\Translation::where('key', $validated['key'])->first();
        if ($existing && (!isset($validated['id']) || $existing->id != $validated['id'])) {
            return redirect()->back()->withErrors(['key' => 'This translation key already exists.']);
        }

        \App\Models\Translation::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'key' => $validated['key'],
                'en' => $validated['en'] ?? $validated['key'],
                'km' => $validated['km'] ?? '',
            ]
        );

        $actionText = ($validated['id'] ?? null) ? "Updated translation key '" . $validated['key'] . "'" : "Registered new translation key '" . $validated['key'] . "'";
        ActivityLog::log($actionText, 'translations');

        return redirect()->back()->with('success', 'Translation saved successfully.');
    }

    public function deleteTranslation(\App\Models\Translation $translation)
    {
        $tKey = $translation->key;
        $translation->delete();
        ActivityLog::log("Deleted translation key '" . $tKey . "'", 'translations', 'bg-red-500/10 text-red-500');
        return redirect()->back()->with('success', 'Translation key deleted.');
    }
}
