<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\NavigationItem;
use App\Models\PageContent;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables before seeding to prevent duplicates on re-seeding/re-uploading
        Schema::disableForeignKeyConstraints();
        NavigationItem::truncate();
        Department::truncate();
        Faculty::truncate();
        PageContent::truncate();
        Event::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@duc.edu.kh'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Navigation Items (Bilingual Tree structure with SVG Icons)
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

        $eventsMenu = NavigationItem::create([
            'label' => ['en' => 'EVENTS', 'km' => 'ព័ត៌មាន និងព្រឹត្តិការណ៍'],
            'href' => '/events',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
            'order' => 4
        ]);

        $contactMenu = NavigationItem::create([
            'label' => ['en' => 'CONTACT', 'km' => 'ទំនាក់ទំនង'],
            'href' => '/contact',
            'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>',
            'order' => 5
        ]);
        
        // 3. Bilingual Faculties & Departments seeding
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

        $fOrder = 1;
        foreach ($facultiesData as $id => $fData) {
            $faculty = Faculty::create([
                'id' => $id,
                'name' => $fData['name'],
                'org_chart_image' => $fData['org_chart_image'],
                'mission' => $fData['mission'],
                'vision' => $fData['vision'],
                'goals' => $fData['goals'],
            ]);

            // Add navigation item for this faculty
            $facMenu = NavigationItem::create([
                'label' => $fData['name'],
                'href' => '/department/' . $faculty->id,
                'parent_id' => $facultiesMenu->id,
                'order' => $fOrder++,
            ]);

            $dOrder = 1;
            foreach ($fData['departments'] as $dData) {
                Department::create([
                    'faculty_id' => $faculty->id,
                    'name' => $dData['name'],
                    'slug' => $dData['slug'],
                    'description' => $dData['description'],
                    'mission' => ['en' => 'Mission details for ' . $dData['name']['en'], 'km' => 'ព័ត៌មានលម្អិតអំពីបេសកកម្មសម្រាប់ ' . $dData['name']['km']],
                    'vision' => ['en' => 'Vision details for ' . $dData['name']['en'], 'km' => 'ព័ត៌មានលម្អិតអំពីចក្ខុវិស័យសម្រាប់ ' . $dData['name']['km']],
                    'goals' => ['en' => 'Goals details for ' . $dData['name']['en'], 'km' => 'ព័ត៌មានលម្អិតអំពីគោលដៅសម្រាប់ ' . $dData['name']['km']],
                ]);

                // Add sub-navigation item under the faculty menu
                NavigationItem::create([
                    'label' => $dData['name'],
                    'href' => '/faculty/' . $faculty->id . '/department/' . $dData['slug'],
                    'parent_id' => $facMenu->id,
                    'order' => $dOrder++,
                ]);
            }
        }

        // 4. Page Contents seeding
        // 4.1 Rector Page
        PageContent::create([
            'slug' => 'rector',
            'title' => "Rector's Message",
            'content' => json_encode([
                'rector_name' => ['en' => 'H.E. Dr. KHEM Phearun', 'km' => 'ឯកឧត្តម បណ្ឌិត ខឹម ភារុណ'],
                'rector_title' => ['en' => 'the Rector of the Digital University of Cambodia', 'km' => 'សាកលវិទ្យាធិការនៃសាកលវិទ្យាល័យឌីជីថលកម្ពុជា'],
                'rector_image' => 'https://assets.monica.im/tools-web/_next/static/media/mobile_upscale.e93d7497.webp',
                'paragraphs_en' => [
                    "As the Rector of the Digital University of Cambodia, I am thrilled and honored to lead an institution at the forefront of innovation in this rapidly evolving technology sector. In this fast-paced field, the need for continuous learning and adaptation is truly essential, requiring us to design and develop new curricula to keep pace with the latest advancements in the AI era, cybersecurity, supply chains, data science, and many other areas. We believe that the future of technology lies in the hands of those who possess not only technical expertise but also the vision to apply these tools in innovative and effective ways.",
                    "Today, digital technology is no longer just an academic field; it is the foundation of modern society, driving progress across all institutions, sectors, and industries—from agriculture, healthcare, and education to entertainment, digital marketing, and finance.",
                    "At our university, we recognize that while our digital technology is in its foundational stages, we are actively training students to help solve some of the world's most complex challenges. Whether it is developing advanced artificial intelligence, improving cybersecurity, building sustainable smart cities, or driving next-generation digital experiences, our faculty, students, and researchers are at the heart of this global social transformation. Our mission is to provide a comprehensive education that goes beyond theory and equips our students with the practical skills and visionary mindset needed for excellence in this dynamic field, accompanied by a spirit of nationalism.",
                    "Our university emphasizes hands-on learning, internships, cutting-edge research, and close collaboration with the Ministry of Education, Youth and Sport to ensure that our graduates are not only well-versed in the latest technologies but also fully prepared to lead the way in shaping precise digital skills for the future.",
                    "The future of digital technology is bright, but it is only through learning, curiosity, and innovation that we can dispel ignorance and fully unlock its potential. Whether you are just beginning your journey or are a digital industry professional seeking advanced knowledge, our university offers an environment where digital curiosity meets real-world application.",
                    "I encourage all of you to join us in exploring the limitless possibilities of digital technology. Together, we can drive forward-thinking solutions that will positively impact our nation and our world."
                ],
                'paragraphs_km' => [
                    "ក្នុងនាមជាសាកលវិទ្យាធិការនៃសាកលវិទ្យាល័យឌីជីថលកម្ពុជា ខ្ញុំមានសេចក្តីរំភើប និងកិត្តិយសជាខ្លាំងក្នុងការដឹកនាំគ្រឹះស្ថានសិក្សាមួយដែលស្ថិតនៅជួរមុខនៃការច្នៃប្រឌិតថ្មីក្នុងវិស័យបច្ចេកវិទ្យាដែលកំពុងរីកចម្រើនយ៉ាងឆាប់រហ័សនេះ។ នៅក្នុងវិស័យដែលផ្លាស់ប្តូរលឿននេះ តម្រូវការសម្រាប់ការរៀនសូត្រឥតឈប់ឈរ និងការបត់បែនគឺពិតជាចាំបាច់បំផុត ដែលតម្រូវឱ្យយើងរចនា និងបង្កើតកម្មវិធីសិក្សាថ្មីៗដើម្បីដើរឱ្យទាន់ការរីកចម្រើនចុងក្រោយបង្អស់ក្នុងយុគសម័យ AI សន្តិសុខអុិនធឺណិត ខ្សែសង្វាក់ផ្គត់ផ្គង់ វិទ្យាសាស្ត្រទិន្នន័យ និងវិស័យជាច្រើនទៀត។ យើងជឿជាក់ថាអនាគតនៃបច្ចេកវិទ្យាស្ថិតនៅក្នុងដៃរបស់អ្នកដែលមានមិនត្រឹមតែជំនាញបច្ចេកទេសប៉ុណ្ណោះទេ ប៉ុន្តែក៏មានចក្ខុវិស័យក្នុងការប្រើប្រាស់ឧបករណ៍ទាំងនេះតាមរបៀបច្នៃប្រឌិត និងមានប្រសិទ្ធភាពផងដែរ។",
                    "សព្វថ្ងៃនេះ បច្ចេកវិទ្យាឌីជីថលលែងគ្រាន់តែជាមុខជំនាញសិក្សាប៉ុណ្ណោះទេ វាគឺជាគ្រឹះនៃសង្គមសម័យទំនើប ដែលជំរុញវឌ្ឍនភាពនៅគ្រប់ស្ថាប័ន គ្រប់វិស័យ និងគ្រប់ឧស្សាហកម្ម—ចាប់ពីកសិកម្ម សុខាភិបាល និងការអប់រំ រហូតដល់ការកម្សាន្ត ទីផ្សារឌីជីថល និងហិរញ្ញវត្ថុ។",
                    "នៅសាកលវិទ្យាល័យរបស់យើង យើងទទួលស្គាល់ថា ខណៈពេលដែលបច្ចេកវិទ្យាឌីជីថលរបស់យើងស្ថិតក្នុងដំណាក់កាលបង្កើតគ្រឹះ យើងកំពុងបណ្តុះបណ្តាលនិស្សិតយ៉ាងសកម្ម ដើម្បីជួយដោះស្រាយបញ្ហាប្រឈមដ៏ស្មុគស្មាញបំផុតមួយចំនួនរបស់ពិភពលោក។ មិនថាតាមរយៈការអភិវឌ្ឍន៍បញ្ញាសិប្បនិម្មិតកម្រិតខ្ពស់ ការកែលម្អសន្តិសុខអុិនធឺណិត ការកសាងទីក្រុងឆ្លាតវៃប្រកបដោយនិរន្តរភាព ឬការជំរុញបទពិសោធន៍ឌីជីថលជំនាន់ក្រោយនោះទេ មហាវិទ្យាល័យ និស្សិត និងអ្នកស្រាវជ្រាវរបស់យើង គឺជាបេះដូងនៃការផ្លាស់ប្តូរសង្គមសកលលោកនេះ។ បេសកកម្មរបស់យើងគឺផ្តល់នូវការអប់រំគ្រប់ជ្រុងជ្រោយដែលលើសពីទ្រឹស្តី និងបំពាក់បំប៉ននិស្សិតរបស់យើងនូវជំនាញជាក់ស្តែង និងផ្នត់គំនិតចក្ខុវិស័យដែលចាំបាច់សម្រាប់ឧត្តមភាពនៅក្នុងវិស័យដ៏រស់រវើកនេះ រួមជាមួយស្មារតីស្នេហាជាតិ។",
                    "សាកលវិទ្យាល័យរបស់យើងសង្កត់ធ្ងន់លើការរៀនសូត្រតាមរយៈការអនុវត្តផ្ទាល់ កម្មសិក្សា ការស្រាវជ្រាវឈានមុខគេ និងកិច្ហសហការយ៉ាងជិតស្និទ្ធជាមួយក្រសួងអប់រំ យុវជន និងកីឡា ដើម្បីធានាថានិស្សិតបញ្ចប់ការសិក្សារបស់យើងមិនត្រឹមតែយល់ដឹងច្បាស់អំពីបច្ចេកវិទ្យាចុងក្រោយបំផុតប៉ុណ្ណោះទេ ប៉ុន្តែក៏ត្រៀមខ្លួនរួចជាស្រេចក្នុងការដឹកនាំក្នុងការបង្កើតជំនាញឌីជីថលច្បាស់លាស់សម្រាប់អនាគត។",
                    "អនាគតនៃបច្ចេកវិទ្យាឌីជីថលគឺភ្លឺស្វាង ប៉ុន្តែមានតែតាមរយៈការរៀនសូត្រ ការចង់ដឹងចង់ឃើញ និងការច្នៃប្រឌិតប៉ុណ្ណោះដែលយើងអាចបំបាត់ភាពល្ងង់ខ្លៅ និងបញ្ចេញសក្តានុពលរបស់វាបានពេញលេញ។ មិនថាអ្នកទើបតែចាប់ផ្តើមដំណើររបស់អ្នក ឬជាអ្នកជំនាញក្នុងឧស្សាហកម្មឌីជីថលដែលស្វែងរកចំណេះដឹងកម្រិតខ្ពស់នោះទេ សាកលវិទ្យាល័យរបស់យើងផ្តល់នូវបរិយាកាសដែលការចង់ដឹងចង់ឃើញឌីជីថលជួបនឹងការអនុវត្តជាក់ស្តែងក្នុងពិភពពិត។",
                    "ខ្ញុំសូមលើកទឹកចិត្តអ្នកទាំងអស់គ្នាឱ្យចូលរួមជាមួយយើងក្នុងការស្វែងរកលទ្ធភាពគ្មានដែនកំណត់នៃបច្ចេកវិទ្យាឌីជីថល។ រួមគ្នា យើងអាចជំរុញដំណោះស្រាយគិតទៅមុខដែលនឹងជះឥទ្ធិពលវិជ្ជមានដល់ប្រទេសជាតិ និងពិភពលោករបស់យើង។"
                ]
            ]),
        ]);

        // 4.2 About Us Page
        PageContent::create([
            'slug' => 'about',
            'title' => 'About Us',
            'content' => json_encode([
                'history' => [
                    'en' => "The Digital University of Cambodia (DUC) is the first digital university in the Kingdom of Cambodia to focus on technology in line with the Royal Government of Cambodia's strategy of one corner: technology.\n\nThe DUC was recognized by a Royal Decree dated March 22, 2024. After operating for the past four months, DUC has been operating normally, with activities in the Faculty of Digital Industry, Faculty of Foreign Languages Education, Faculty of Agriculture and Rural Development, and Faculty of Engineering and Architecture, Faculty of Law and Political Science, Faculty of Economics and Finance.\n\nAt the same time, the university does not yet have a platform such as the official website of the university. Comprehensive and convenient for International course for use in DUC.",
                    'km' => "សាកលវិទ្យាល័យឌីជីថលកម្ពុជា (DUC) គឺជាសាកលវិទ្យាល័យឌីជីថលដំបូងគេបង្អស់នៅក្នុងព្រះរាជាណាចក្រកម្ពុជា ដែលផ្តោតលើបច្ចេកវិទ្យា ស្របតាមយុទ្ធសាស្ត្របញ្ចកោណរបស់រាជរដ្ឋាភិបាលកម្ពុជា។\n\nDUC ត្រូវបានទទួលស្គាល់ដោយព្រះរាជក្រឹត្យចុះថ្ងៃទី២២ ខែមីនា ឆ្នាំ២០២៤។ បន្ទាប់ពីដំណើរការអស់រយៈពេលបួនខែកន្លងមកនេះ DUC បាននិងកំពុងដំណើរការជាធម្មតា ជាមួយនឹងសកម្មភាពនានានៅក្នុងមហាវិទ្យាល័យឧស្សាហកម្មឌីជីថល មហាវិទ្យាល័យអប់រំភាសាបរទេស មហាវិទ្យាល័យកសិកម្ម និងអភិវឌ្ឍន៍ជនបទ មហាវិទ្យាល័យវិស្វកម្ម និងស្ថាបត្យកម្ម មហាវិទ្យាល័យច្បាប់ និងវិទ្យាសាស្ត្រនយោបាយ និងមហាវិទ្យាល័យសេដ្ឋកិច្ច និងហិរញ្ញវត្ថុ។"
                ],
                'goals' => [
                    ['en' => "The Department of Graphic Design,", 'km' => "ដេប៉ាតឺម៉ង់រចនាក្រាហ្វិក,"],
                    ['en' => "the Department of Digital Marketing,", 'km' => "ដេប៉ាតឺម៉ង់ទីផ្សារឌីជីថល,"],
                    ['en' => "the Department of Social Media,", 'km' => "ដេប៉ាតឺម៉ង់បណ្តាញសង្គម,"],
                    ['en' => "the Department of English Education,", 'km' => "ដេប៉ាតឺម៉ង់អប់រំភាសាអង់គ្លេស,"],
                    ['en' => "the Department of Agriculture and Horticulture,", 'km' => "ដេប៉ាតឺម៉ង់ក្សេត្រសាស្ត្រ និងវប្បកម្ម,"],
                    ['en' => "the Department of Architecture and", 'km' => "ដេប៉ាតឺម៉ង់ស្ថាបត្យកម្ម និង"],
                    ['en' => "the Department of Public Administration,", 'km' => "ដេប៉ាតឺម៉ង់រដ្ឋបាលសាធារណៈ,"],
                    ['en' => "the Department of Economics and", 'km' => "ដេប៉ាតឺម៉ង់សេដ្ឋកិច្ច និង"],
                    ['en' => "the Department of Public Administration.", 'km' => "ដេប៉ាតឺម៉ង់រដ្ឋបាលសាធារណៈ។"]
                ],
                'mission' => [
                    'en' => "The DUC was recognized by a Royal Decree dated March 22, 2024. After operating for the past four months, DUC has been operating normally, with activities in the Faculty of Digital Industry, Faculty of Foreign Languages Education, Faculty of Agriculture and Rural Development, and Faculty of Engineering and Architecture, Faculty of Law and Political Science, Faculty Economics and Finance. These include the Department of Information Technology.",
                    'km' => "DUC ត្រូវបានទទួលស្គាល់ដោយព្រះរាជក្រឹត្យចុះថ្ងៃទី២២ ខែមីនា ឆ្នាំ២០២៤។ បន្ទាប់ពីដំណើរការអស់រយៈពេលបួនខែកន្លងមកនេះ DUC បាននិងកំពុងដំណើរការជាធម្មតា ជាមួយនឹងសកម្មភាពនានានៅក្នុងមហាវិទ្យាល័យឧស្សាហកម្មឌីជីថល មហាវិទ្យាល័យអប់រំភាសាបរទេស មហាវិទ្យាល័យកសិកម្ម និងអភិវឌ្ឍន៍ជនបទ មហាវិទ្យាល័យវិស្វកម្ម និងស្ថាបត្យកម្ម មហាវិទ្យាល័យច្បាប់ និងវិទ្យាសាស្ត្រនយោបាយ និងមហាវិទ្យាល័យវិទ្យាសាស្ត្រសេដ្ឋកិច្ចឌីជីថល រួមទាំងដេប៉ាតឺម៉ង់បច្ចេកវិទ្យាព័ត៌មានផងដែរ។"
                ],
                'vision' => [
                    'en' => "Vision content coming soon...",
                    'km' => "ខ្លឹមសារចក្ខុវិស័យនឹងមកដល់ឆាប់ៗនេះ..."
                ]
            ]),
        ]);

        // 4.3 Exam and Evaluation Page
        PageContent::create([
            'slug' => 'exam-evaluation',
            'title' => 'Exam and Evaluation',
            'content' => json_encode([
                'intro' => [
                    'en' => "The academic evaluation for students studying at the Associate, Bachelor's, or Master's degree levels for each subject shall be implemented as follows:\n\n1. General attendance includes class attendance, line gatherings (assemblies), morality, discipline, and all activities organized by the university.\n\n2. Student assignments and practical learning include participation in learning activities and the Global English Test.\n\n3. Research assignments refer to tasks assigned by instructors to individual students or groups to research any topic related to the respective subject. The scoring by the instructor or professor for research assignments must be based on the formatting, document content, and the student's presentation skills. Instructors or professors may break down the research assignment by combining it with class participation, practical exercises, and/or homework, but the total percentage of points must remain unchanged. For major subjects...",
                    'km' => "ការវាយតម្លៃលទ្ធផលសិក្សារបស់និស្សិតសម្រាប់កម្រិតបរិញ្ញាបត្ររង បរិញ្ញាបត្រ ឬបរិញ្ញាបត្រជាន់ខ្ពស់ លើមុខវិជ្ជានីមួយៗ ត្រូវអនុវត្តដូចខាងក្រោម៖\n\n១. វត្តមានទូទៅរួមមាន វត្តមានក្នុងថ្នាក់ ការប្រមូលផ្តុំទិសដៅ សីលធម៌ វិន័យ និងសកម្មភាពទាំងអស់ដែលរៀបចំដោយសាកលវិទ្យាល័យ។\n\n២. កិច្ចការនិស្សិត និងការអនុវត្តជាក់ស្តែងរួមមាន ការចូលរួមក្នុងសកម្មភាពសិក្សា និងការធ្វើតេស្តភាសាអង់គ្លេសសកល។\n\n៣. កិច្ចការស្រាវជ្រាវ សំដៅលើភារកិច្ចដែលដាក់ឱ្យដោយសាស្ត្រាចារ្យដល់និស្សិតម្នាក់ៗ ឬជាក្រុមដើម្បីស្រាវជ្រាវលើប្រធានបទណាមួយដែលទាក់ទងនឹងមុខវិជ្ជា។ ការផ្តល់ពិន្ទុដោយសាស្ត្រាចារ្យត្រូវផ្អែកលើទម្រង់ ខ្លឹមសារឯកសារ និងជំនាញធ្វើបទបង្ហាញរបស់និស្សិត។"
                ],
                'breakdown' => [
                    ['criteria' => ['en' => 'Punctuality', 'km' => 'ការគោរពពេលវេលា'], 'percentage' => '10%'],
                    ['criteria' => ['en' => 'Student Assignments and Practical Work', 'km' => 'កិច្ចការនិស្សិត និងការអនុវត្តជាក់ស្តែង'], 'percentage' => '15%'],
                    ['criteria' => ['en' => 'Attendance Score', 'km' => 'ពិន្ទុវត្តមាន'], 'percentage' => '5%'],
                    ['criteria' => ['en' => 'Research Assignments and Midterm Exam', 'km' => 'កិច្ចការស្រាវជ្រាវ និងការប្រឡងពាក់កណ្តាលឆមាស'], 'percentage' => '15%'],
                    ['criteria' => ['en' => 'Final Exam', 'km' => 'ការប្រឡងបញ្ចប់ឆមាស'], 'percentage' => '55%']
                ],
                'grades' => [
                    ['score' => '85 to 100', 'letter' => 'A', 'points' => '4.00', 'description' => ['en' => 'Excellent', 'km' => 'ល្អប្រសើរ']],
                    ['score' => '80 to 84', 'letter' => 'B+', 'points' => '3.50', 'description' => ['en' => 'Very Good', 'km' => 'ល្អណាស់']],
                    ['score' => '70 to 79', 'letter' => 'B', 'points' => '3.00', 'description' => ['en' => 'Good', 'km' => 'ល្អ']],
                    ['score' => '65 to 69', 'letter' => 'C+', 'points' => '2.50', 'description' => ['en' => 'Fairly Good', 'km' => 'ល្អបង្គួរ']],
                    ['score' => '50 to 64', 'letter' => 'C', 'points' => '2.00', 'description' => ['en' => 'Fair', 'km' => 'មធ្យម']],
                    ['score' => '45 to 49', 'letter' => 'D', 'points' => '1.50', 'description' => ['en' => 'Poor', 'km' => 'ខ្សោយ']],
                    ['score' => '40 to 44', 'letter' => 'E', 'points' => '1.00', 'description' => ['en' => 'Very Poor', 'km' => 'ខ្សោយណាស់']],
                    ['score' => 'Below 40', 'letter' => 'F', 'points' => '0.00', 'description' => ['en' => 'Fail', 'km' => 'ធ្លាក់']]
                ]
            ]),
        ]);

        // 4.4 Office Pages content
        $officesConfig = [
            'academic_affairs_office' => [
                'title' => "Academic Affairs Office",
                'image' => "https://assets.monica.im/tools-web/_next/static/media/mobile_upscale.e93d7497.webp",
                'about' => [
                    'en' => "The Academic Affairs Office is the central hub for all educational programs, ensuring the quality and integrity of our curriculum. We support faculty in delivering world-class education and assist students in navigating their academic journeys from enrollment to graduation.",
                    'km' => "ការិយាល័យសិក្សាធិការ គឺជាមជ្ឈមណ្ឌលស្នូលសម្រាប់កម្មវិធីសិក្សាអប់រំទាំងអស់ ដោយធានាបាននូវគុណភាព និងសុចរិតភាពនៃកម្មវិធីសិក្សារបស់យើង។ យើងគាំទ្រសាស្ត្រាចារ្យក្នុងការផ្តល់ការអប់រំកម្រិតពិភពលោក និងជួយសម្រួលដល់ដំណើរការសិក្សារបស់និស្សិតតាំងពីការចុះឈ្មោះរហូតដល់បញ្ចប់ការសិក្សា។"
                ],
                'mission' => [
                    'en' => "To foster an innovative and rigorous academic environment that promotes intellectual growth, critical thinking, and lifelong learning among our students.",
                    'km' => "ដើម្បីលើកកម្ពស់បរិយាកាសសិក្សាប្រកបដោយភាពច្នៃប្រឌិត និងម៉ត់ចត់ ដែលជំរុញការលូតលាស់បញ្ញា ការគិតពិចារណា និងការរៀនសូត្រអស់មួយជីវិតក្នុងចំណោមនិស្សិតរបស់យើង។"
                ],
                'vision' => [
                    'en' => "To be recognized globally as a leader in academic excellence, driving educational advancement and student success through cutting-edge curricula and dedicated faculty support.",
                    'km' => "ដើម្បីក្លាយជាអ្នកដឹកនាំដែលត្រូវបានទទួលស្គាល់ជាសកលក្នុងឧត្តមភាពនៃការសិក្សា ជំរុញវឌ្ឍនភាពនៃការអប់រំ និងភាពជោគជ័យរបស់និស្សិត តាមរយៈកម្មវិធីសិក្សាឈានមុខគេ និងការគាំទ្រពីសាស្ត្រាចារ្យ។"
                ],
            ],
            'student_affairs_office' => [
                'title' => "Student Affairs Office",
                'image' => "https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&q=80&w=1200",
                'about' => [
                    'en' => "The Student Affairs Office is dedicated to supporting the holistic development of our students. We manage campus life, student organizations, counseling services, and extracurricular programs to ensure a vibrant, inclusive, and supportive campus community.",
                    'km' => "ការិយាល័យកិច្ចការនិស្សិត គឺឧទ្ទិសដល់ការគាំទ្រការអភិវឌ្ឍន៍គ្រប់ជ្រុងជ្រោយរបស់និស្សិតរបស់យើង។ យើងគ្រប់គ្រងជីវិតក្នុងបរិវេណសាលា អង្គការនិស្សិត សេវាកម្មប្រឹក្សា និងកម្មវិធីក្រៅកម្មវិធីសិក្សា ដើម្បីធានាបាននូវសហគមន៍សាលារៀនដ៏រស់រវើក បរិយាបន្ន និងគាំទ្រគ្នាទៅវិញទៅមក។"
                ],
                'mission' => [
                    'en' => "To enhance the educational experience by providing comprehensive support services, fostering personal growth, and cultivating a diverse and inclusive campus environment.",
                    'km' => "ដើម្បីលើកកម្ពស់បទពិសោធន៍អប់រំដោយផ្តល់នូវសេវាកម្មគាំទ្រគ្រប់ជ្រុងជ្រោយ ជំរុញការលូតលាស់ផ្ទាល់ខ្លួន និងការបណ្ដុះបណ្ដាលបរិយាកាសបរិវេណសាលាដែលមានភាពចម្រុះ និងបរិយាបន្ន។"
                ],
                'vision' => [
                    'en' => "To create a dynamic campus culture where every student is empowered to thrive personally, socially, and academically, preparing them for active global citizenship.",
                    'km' => "ដើម្បីបង្កើតវប្បធម៌បរិវេណសាលាដ៏រស់រវើក ដែលនិស្សិតគ្រប់រូបត្រូវបានផ្តល់អំណាចឱ្យរីកចម្រើនទាំងផ្ទាល់ខ្លួន សង្គម និងការសិក្សា ដោយរៀបចំពួកគេឱ្យក្លាយជាពលរដ្ឋសកលដ៏សកម្ម។"
                ],
            ],
            'personnel_and_human_resources' => [
                'title' => "Human Resources Office",
                'image' => "https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&q=80&w=1200",
                'about' => [
                    'en' => "The Personnel and Human Resources Office manages all aspects of employment for faculty and staff. From recruitment and onboarding to professional development and benefits administration, we are committed to building a supportive and dynamic workplace.",
                    'km' => "ការិយាល័យបុគ្គលិក និងអភិវឌ្ឍន៍ធនធានមនុស្ស គ្រប់គ្រងគ្រប់ទិដ្ឋភាពទាំងអស់នៃការងារសម្រាប់សាស្ត្រាចារ្យ និងបុគ្គលិក។ ចាប់ពីការជ្រើសរើស និងការចូលបម្រើការងារ រហូតដល់ការអភិវឌ្ឍន៍វិជ្ជាជីវៈ និងការគ្រប់គ្រងអត្ថប្រយោជន៍ យើងប្តេជ្ញាកសាងកន្លែងធ្វើការដែលគាំទ្រ និងរស់រវើក។"
                ],
                'mission' => [
                    'en' => "To attract, retain, and develop a diverse and highly skilled workforce by providing equitable, transparent, and supportive human resource services.",
                    'km' => "ដើម្បីទាក់ទាញ រក្សាទុក និងអភិវឌ្ឍកម្លាំងពលកម្មចម្រុះ និងមានជំនាញខ្ពស់ ដោយផ្តល់នូវសេវាកម្មធនធានមនុស្សប្រកបដោយសមធម៌ តម្លាភាព និងការគាំទ្រ។"
                ],
                'vision' => [
                    'en' => "To be an employer of choice in the higher education sector, fostering a culture of excellence, collaboration, and continuous professional growth.",
                    'km' => "ដើម្បីក្លាយជានិយោជកនៃជម្រើសដំបូងក្នុងវិស័យឧត្តមសិក្សា ជំរុញវប្បធម៌នៃឧត្តមភាព កិច្ចសហការ និងការរីកចម្រើនវិជ្ជាជីវៈជាបន្តបន្ទាប់។"
                ],
            ],
            'administration_and_accounting_office' => [
                'title' => "Administration & Accounting Office",
                'image' => "https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=1200",
                'about' => [
                    'en' => "This office oversees the university's financial health and administrative operations. We handle budgeting, accounting, procurement, and financial reporting to ensure resources are utilized efficiently to support the institution's strategic goals.",
                    'km' => "ការិយាល័យនេះត្រួតពិនិត្យសុខភាពហិរញ្ញវត្ថុរបស់សាកលវិទ្យាល័យ និងប្រតិបត្តិការរដ្ឋបាល។ យើងចាត់ចែងការរៀបចំថវិកា គណនេយ្យ លទ្ធកម្ម និងរបាយការណ៍ហិរញ្ញវត្ថុ ដើម្បីធានាថាធនធានត្រូវបានប្រើប្រាស់ប្រកបដោយប្រសិទ្ធភាព ដើម្បីគាំទ្រដល់គោលដៅយុទ្ធសាស្ត្ររបស់ស្ថាប័ន។"
                ],
                'mission' => [
                    'en' => "To provide transparent, accurate, and strategic financial management and administrative services that sustain and advance the university's mission.",
                    'km' => "ដើម្បីផ្តល់នូវការគ្រប់គ្រងហិរញ្ញវត្ថុ និងសេវាកម្មរដ្ឋបាលប្រកបដោយតម្លាភាព ត្រឹមត្រូវ និងជាយុទ្ធសាស្ត្រ ដែលទ្រទ្រង់ និងជំរុញបេសកកម្មរបស់សាកលវិទ្យាល័យ។"
                ],
                'vision' => [
                    'en' => "To achieve financial sustainability and operational excellence through innovative practices, rigorous accountability, and strategic resource allocation.",
                    'km' => "ដើម្បីសម្រេចបាននូវនិរន្តរភាពហិរញ្ញវត្ថុ និងឧត្តមភាពប្រតិបត្តិការតាមរយៈការអនុវត្តប្រកបដោយនវានុវត្តន៍ គណនេយ្យភាពម៉ត់ចត់ និងការបែងចែកធនធានជាយុទ្ធសាស្ត្រ។"
                ],
            ],
            'dormitory_office' => [
                'title' => "Dormitory Office",
                'image' => "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&q=80&w=1200",
                'about' => [
                    'en' => "The Dormitory Office manages all on-campus housing facilities, ensuring a safe, comfortable, and welcoming living environment for students. We handle room assignments, facility maintenance, and residential life programming.",
                    'km' => "ការិយាល័យអន្តេវាសិកដ្ឋាន គ្រប់គ្រងកន្លែងស្នាក់នៅក្នុងបរិវេណសាលាទាំងអស់ ដោយធានាបាននូវបរិយាកាសរស់នៅប្រកបដោយសុវត្ថិភាព ផាសុកភាព និងការស្វាគមន៍សម្រាប់និស្សិត។ យើងចាត់ចែងការបែងចែកបន្ទប់ ការថែទាំកន្លែងស្នាក់នៅ និងកម្មវិធីជីវិតរស់នៅ។"
                ],
                'mission' => [
                    'en' => "To provide secure, well-maintained, and inclusive residential communities that support the academic and personal success of our students.",
                    'km' => "ដើម្បីផ្តល់នូវសហគមន៍លំនៅដ្ឋានដែលមានសុវត្ថិភាព ថែទាំបានល្អ និងបរិយាបន្ន ដែលគាំទ្រដល់ភាពជោគជ័យក្នុងការសិក្សា និងផ្ទាល់ខ្លួនរបស់និស្សិតរបស់យើង។"
                ],
                'vision' => [
                    'en' => "To offer premier campus housing experiences that foster lifelong friendships, personal responsibility, and a strong sense of community belonging.",
                    'km' => "ដើម្បីផ្តល់នូវបទពិសោធន៍ស្នាក់នៅបរិវេណសាលាដ៏ល្អដំបូងបង្អស់ ដែលជំរុញមិត្តភាពអស់មួយជីវិត ការទទួលខុសត្រូវផ្ទាល់ខ្លួន និងស្មារតីរឹងមាំនៃសហគមន៍។"
                ],
            ],
            'planning_and_research_office' => [
                'title' => "Planning & Research Office",
                'image' => "https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=1200",
                'about' => [
                    'en' => "The Planning and Research Office is responsible for guiding the university's long-term strategic direction. We conduct institutional research, analyze performance metrics, and coordinate strategic planning initiatives to support evidence-based decision-making.",
                    'km' => "ការិយាល័យផែនការ និងស្រាវជ្រាវ មានភារកិច្ចណែនាំទិសដៅយុទ្ធសាស្ត្ររយៈពេលវែងរបស់សាកលវិទ្យាល័យ។ យើងធ្វើការស្រាវជ្រាវស្ថាប័ន វិភាគរង្វាស់នៃការអនុវត្ត និងសម្របសម្រួលគំនិតផ្តួចផ្តើមផែនការយុទ្ធសាស្ត្រ ដើម្បីគាំទ្រដល់ការសម្រេចចិត្តផ្អែកលើភស្តុតាង។"
                ],
                'mission' => [
                    'en' => "To empower university leadership with actionable data, comprehensive research, and strategic frameworks that promote continuous institutional improvement.",
                    'km' => "ដើម្បីផ្តល់អំណាចដល់ថ្នាក់ដឹកនាំសាកលវិទ្យាល័យជាមួយនឹងទិន្នន័យដែលអាចអនុវត្តបាន ការស្រាវជ្រាវគ្រប់ជ្រុងជ្រោយ និងក្របខ័ណ្ឌយុទ្ធសាស្ត្រដែលជំរុញការកែលម្អស្ថាប័នជាបន្តបន្ទាប់។"
                ],
                'vision' => [
                    'en' => "To be the catalyst for transformative institutional growth, ensuring the university remains adaptable, forward-thinking, and globally competitive.",
                    'km' => "ដើម្បីក្លាយជាកាតាលីករសម្រាប់ការរីកចម្រើនស្ថាប័នប្រកបដោយការផ្លាស់ប្តូរ ដោយធានាថាសាកលវិទ្យាល័យនៅតែអាចសម្របខ្លួនបាន គិតទៅមុខ និងមានសមត្ថភាពប្រកួតប្រជែងជាសកល។"
                ],
            ],
            'internal_quality_assurance_office' => [
                'title' => "Internal Quality Assurance Office",
                'image' => "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=1200",
                'about' => [
                    'en' => "The Internal Quality Assurance Office monitors and evaluates the university's programs and processes. We conduct regular audits, facilitate accreditation procedures, and promote a culture of continuous quality enhancement across all departments.",
                    'km' => "ការិយាល័យធានាគុណភាពផ្ទៃក្នុង ត្រួតពិនិត្យ និងវាយតម្លៃកម្មវិធី និងដំណើរការរបស់សាកលវិទ្យាល័យ។ យើងធ្វើសវនកម្មជាប្រចាំ សម្របសម្រួលនីតិវិធីទទួលស្គាល់គុណភាព និងលើកកម្ពស់វប្បធម៌នៃការលើកកម្ពស់គុណភាពជាបន្តបន្ទាប់នៅគ្រប់ដេប៉ាតឺម៉ង់ទាំងអស់។"
                ],
                'mission' => [
                    'en' => "To safeguard and enhance the quality of education and administrative services through rigorous assessment, compliance tracking, and continuous improvement protocols.",
                    'km' => "ដើម្បីការពារ និងលើកកម្ពស់គុណភាពនៃការអប់រំ និងសេវាកម្មរដ្ឋបាល តាមរយៈការវាយតម្លៃម៉ត់ចត់ ការតាមដានអនុលោមភាព និងពិធីសារកែលម្អជាបន្តបន្ទាប់។"
                ],
                'vision' => [
                    'en' => "To establish the university as a benchmark for quality and excellence in higher education, recognized for uncompromising standards and continuous innovation.",
                    'km' => "ដើម្បីបង្កើតសាកលវិទ្យាល័យជាស្តង់ដារសម្រាប់គុណភាព និងឧត្តមភាពក្នុងឧត្តមសិក្សា ដែលត្រូវបានទទួលស្គាល់សម្រាប់ស្តង់ដារម៉ឺងម៉ាត់ និងការច្នៃប្រឌិតជាបន្តបន្ទាប់។"
                ],
            ],
        ];

        foreach ($officesConfig as $slug => $config) {
            PageContent::create([
                'slug' => $slug,
                'title' => $config['title'],
                'is_office' => true,
                'office_type' => $slug,
                'content' => json_encode($config),
            ]);
        }

        // 5. Bilingual Events seeding
        $eventsData = [
            [
                'id' => 1,
                'image' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&w=1400&q=85',
                'type' => 'campus',
                'title' => ['en' => 'DUC Campus Orientation 2024', 'km' => 'ទិវាណែនាំនិស្សិតថ្មីរបស់សាកលវិទ្យាល័យឌីជីថលកម្ពុជា ២០២៤'],
                'date' => ['en' => '3 /June /2024', 'km' => '៣ /មិថុនា /២០២៤'],
                'description' => ['en' => 'Welcoming new students to the Digital University of Cambodia with dynamic tours and introduction sessions.', 'km' => 'ការស្វាគមន៍និស្សិតថ្មីមកកាន់សាកលវិទ្យាល័យឌីជីថលកម្ពុជា ជាមួយនឹងដំណើរទស្សនកិច្ច និងវគ្គណែនាំដ៏រស់រវើក។'],
                'content' => ['en' => 'Campus Orientation is our annual event to introduce students to digital learning strategies, campus guidelines, and the university leadership team.', 'km' => 'ទិវាណែនាំនិស្សិតថ្មី គឺជាព្រឹត្តិការណ៍ប្រចាំឆ្នាំរបស់យើង ដើម្បីណែនាំសិស្សឱ្យស្គាល់យុទ្ធសាស្ត្រសិក្សាឌីជីថល គោលការណ៍ណែនាំក្នុងបរិវេណសាលា និងក្រុមថ្នាក់ដឹកនាំសាកលវិទ្យាល័យ។']
            ],
            [
                'id' => 2,
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1400&q=85',
                'type' => 'digital',
                'title' => ['en' => 'Fintech and Blockchain Conference', 'km' => 'សន្និសីទបច្ចេកវិទ្យាហិរញ្ញវត្ថុ និងបច្ចេកវិទ្យា Blockchain'],
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
            ],
            [
                'id' => 4,
                'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1400&q=85',
                'type' => 'campus',
                'title' => ['en' => 'IT Department Hackathon competition', 'km' => 'ការប្រកួតប្រជែង Hackathon របស់ដេប៉ាតឺម៉ង់បច្ចេកវិទ្យាព័ត៌មាន'],
                'date' => ['en' => '5 /September /2024', 'km' => '៥ /កញ្ញា /២០២៤'],
                'description' => ['en' => 'A 48-hour student coding competition to build responsive web applications resolving local issues.', 'km' => 'ការប្រកួតប្រជែងសរសេរកូដរបស់និស្សិតរយៈពេល ៤៨ ម៉ោង ដើម្បីបង្កើតគេហទំព័រដោះស្រាយបញ្ហាក្នុងតំបន់។'],
                'content' => ['en' => 'The Hackathon provides students a chance to collaborate with peers, solve real-world community challenges, and win cash prizes from sponsors.', 'km' => 'Hackathon ផ្តល់ឱកាសឱ្យនិស្សិតសហការគ្នា ដោះស្រាយបញ្ហាប្រឈមក្នុងសហគមន៍ជាក់ស្តែង និងឈ្នះរង្វាន់ជាសាច់ប្រាក់ពីអ្នកឧបត្ថម្ភ។']
            ],
            [
                'id' => 5,
                'image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1400&q=85',
                'type' => 'digital',
                'title' => ['en' => 'Cybersecurity Awareness seminar', 'km' => 'សិក្ខាសាលាយកចិត្តទុកដាក់អំពីសុវត្ថិភាពតាមប្រព័ន្ធអ៊ីនធឺណិត (Cybersecurity)'],
                'date' => ['en' => '18 /October /2024', 'km' => '១៨ /តុលា /២០២៤'],
                'description' => ['en' => 'Learn vital strategies to defend critical infrastructure and personal databases from online threats.', 'km' => 'ស្វែងយល់ពីយុទ្ធសាស្ត្រសំខាន់ៗដើម្បីការពារហេដ្ឋារចនាសម្ព័ន្ធសំខាន់ៗ និងមូលដ្ឋានទិន្នន័យផ្ទាល់ខ្លួនពីការគំរាមកំហែងតាមអ៊ីនធឺណិត។'],
                'content' => ['en' => 'This seminar presents details on phishing prevention, multi-factor authentication, network firewalls, and secure digital architectures.', 'km' => 'សិក្ខាសាលានេះបង្ហាញព័ត៌មានលម្អិតអំពីការការពារការបន្លំ (phishing) ការផ្ទៀងផ្ទាត់ភាពត្រឹមត្រូវច្រើនកត្តា (MFA) ជញ្ជាំងការពារបណ្តាញ និងស្ថាបត្យកម្មឌីជីថលដែលមានសុវត្ថិភាព។']
            ],
            [
                'id' => 6,
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=900&q=80',
                'detail_image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1400&q=85',
                'type' => 'announcement',
                'title' => ['en' => 'DUC Convocation Ceremony 2024', 'km' => 'ពិធីប្រគល់សញ្ញាបត្ររបស់សាកលវិទ្យាធិការឌីជីថលកម្ពុជា ២០២៤'],
                'date' => ['en' => '30 /November /2024', 'km' => '៣០ /វិច្ឆិកា /២០២៤'],
                'description' => ['en' => 'Celebrating the success and graduation of the pioneer batch of Digital University of Cambodia.', 'km' => 'អបអរសាទរភាពជោគជ័យ និងការបញ្ចប់ការសិក្សារបស់និស្សិតជំនាន់ដំបូងនៃសាកលវិទ្យាល័យឌីជីថលកម្ពុជា។'],
                'content' => ['en' => 'Join us in recognizing the academic excellence of our graduating students as they embark on professional careers in technology and management.', 'km' => 'ចូលរួមជាមួយយើងក្នុងការទទួលស្គាល់ឧត្តមភាពសិក្សារបស់និស្សិតដែលបញ្ចប់ការសិក្សារបស់យើង នៅពេលពួកគេចាប់ផ្តើមអាជីពវិជ្ជាជីវៈក្នុងផ្នែកបច្ចេកវិទ្យា និងការគ្រប់គ្រង។']
            ],
        ];

        foreach ($eventsData as $eData) {
            Event::create($eData);
        }

        // 6. Settings seeding
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

        // 7. Base Static UI Translations
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
            'Custom Sections' => 'ផ្នែកផ្សេងៗ',
            'Academic Curricula' => 'កម្មវិធីសិក្សាអប់រំ',
            'No.' => 'ល.រ',
            'Subjects' => 'មុខវិជ្ជា',
            'Credits' => 'ក្រេឌីត',
            'Hours' => 'ម៉ោង',
            'Total Credits' => 'ក្រេឌីតសរុប',
            'Career Opportunities' => 'ឱកាសការងារ',
            'Terms of Admission' => 'លក្ខខណ្ឌនៃការចុះឈ្មោះចូលរៀន',
            'Syllabus & Course Structure' => 'គ្រោងកម្មវិធីសិក្សា និងរចនាសម្ព័ន្ធវគ្គសិក្សា',
            'Search events...' => 'ស្វែងរកព្រឹត្តិការណ៍...',
            'No events found matching your criteria.' => 'រកមិនឃើញព្រឹត្តិការណ៍ដែលត្រូវនឹងលក្ខណៈវិនិច្ឆ័យរបស់អ្នកទេ។',
            'Rector Message' => 'សាររបស់សាកលវិទ្យាធិការ',
            'Rector\'s Message' => 'សាររបស់សាកលវិទ្យាធិការ',
            'Foundation year' => 'ឆ្នាំសិក្សាមូលដ្ឋាន',
            'Second year' => 'ឆ្នាំទី២',
            'Third year' => 'ឆ្នាំទី៣',
            'Last year' => 'ឆ្នាំបញ្ចប់',
            'Read Full Article' => 'អានអត្ថបទពេញ',
            'Back to Events' => 'ត្រឡប់ទៅព្រឹត្តិការណ៍វិញ',
            'Administration and Accounting Office' => 'ការិយាល័យរដ្ឋបាល និងហិរញ្ញវត្ថុ',
            'Academic Affairs Office' => 'ការិយាល័យសិក្សាធិការ',
            'Student Affairs Office' => 'ការិយាល័យកិច្ចការនិស្សិត',
            'Personnel and Human Resources Office' => 'ការិយាល័យបុគ្គលិក និងអភិវឌ្ឍន៍ធនធានមនុស្ស',
            'Dormitory Office' => 'ការិយាល័យអន្តេវាសិកដ្ឋាន',
            'Planning and Research Office' => 'ការិយាល័យផែនការ និងស្រាវជ្រាវ',
            'Internal Quality Assurance Office' => 'ការិយាល័យធានាគុណភាពផ្ទៃក្នុង',
            'Exam and Evaluation' => 'ការវាយតម្លៃ និងការប្រឡង',
            'Departments' => 'ដេប៉ាតឺម៉ង់',
            'Search programs...' => 'ស្វែងរកកម្មវិធីសិក្សា...',
            'No programs found.' => 'រកមិនឃើញកម្មវិធីសិក្សាទេ។',
            'Close' => 'បិទ',
            'Submit' => 'បញ្ជូន',
            'Save Changes' => 'រក្សាទុកការផ្លាស់ប្តូរ'
        ];

        foreach ($translations as $key => $km) {
            \App\Models\Translation::updateOrCreate(
                ['key' => $key],
                [
                    'en' => $key,
                    'km' => $km
                ]
            );
        }
    }
}
