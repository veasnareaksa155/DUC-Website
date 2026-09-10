<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('translations')->delete();
        
        \DB::table('translations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'Welcome to the Digital University of Cambodia',
                'en' => 'Welcome to the Digital University of Cambodia',
                'km' => 'សូមស្វាគមន៍មកកាន់សាកលវិទ្យាល័យឌីជីថលកម្ពុជា',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'Empowering the next generation of digital leaders and creative innovators.',
                'en' => 'Empowering the next generation of digital leaders and creative innovators.',
                'km' => 'ការផ្តល់អំណាចដល់អ្នកដឹកនាំឌីជីថល និងអ្នកច្នៃប្រឌិតជំនាន់ក្រោយ។',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'Explore Programs',
                'en' => 'Explore Programs',
                'km' => 'ស្វែងយល់ពីកម្មវិធីសិក្សា',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'Learn More',
                'en' => 'Learn More',
                'km' => 'ស្វែងយល់បន្ថែម',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'Contact Us',
                'en' => 'Contact Us',
                'km' => 'ទាក់ទងមកយើង',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'Get in Touch',
                'en' => 'Get in Touch',
                'km' => 'ទាក់ទងមកយើងខ្ញុំ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'News/Event',
                'en' => 'News/Event',
                'km' => 'ព័ត៌មាន និងព្រឹត្តិការណ៍',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'Scholarship for Students',
                'en' => 'Scholarship for Students',
                'km' => 'អាហារូបករណ៍សម្រាប់និស្សិត',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'Graduate Attributes',
                'en' => 'Graduate Attributes',
                'km' => 'គុណវុឌ្ឍិរបស់និស្សិតបញ្ចប់ការសិក្សា',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'Four Years Study',
                'en' => 'Four Years Study',
                'km' => 'ការសិក្សារយៈពេលបួនឆ្នាំ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'Students Activities',
                'en' => 'Students Activities',
                'km' => 'សកម្មភាពនិស្សិត',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'First Name',
                'en' => 'First Name',
                'km' => 'នាមខ្លួន',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'Last Name',
                'en' => 'Last Name',
                'km' => 'នាមត្រកូល',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'Email Address',
                'en' => 'Email Address',
                'km' => 'អាសយដ្ឋានអ៊ីមែល',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'Phone Number',
                'en' => 'Phone Number',
                'km' => 'លេខទូរស័ព្ទ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'Subject',
                'en' => 'Subject',
                'km' => 'ប្រធានបទ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'Your Message',
                'en' => 'Your Message',
                'km' => 'សាររបស់អ្នក',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'Send Message',
                'en' => 'Send Message',
                'km' => 'ផ្ញើសារ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            18 => 
            array (
                'id' => 20,
                'key' => 'Social Network',
                'en' => 'Social Network',
                'km' => 'បណ្តាញសង្គម',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            19 => 
            array (
                'id' => 21,
                'key' => 'Overview',
                'en' => 'Overview',
                'km' => 'ទិដ្ឋភាពទូទៅ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            20 => 
            array (
                'id' => 22,
                'key' => 'Mission',
                'en' => 'Mission',
                'km' => 'បេសកកម្ម',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            21 => 
            array (
                'id' => 23,
                'key' => 'Vision',
                'en' => 'Vision',
                'km' => 'ចក្ខុវិស័យ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            22 => 
            array (
                'id' => 24,
                'key' => 'Goals',
                'en' => 'Goals',
                'km' => 'គោលដៅ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            23 => 
            array (
                'id' => 25,
                'key' => 'Custom Sections',
                'en' => 'Custom Sections',
                'km' => 'ផ្នែកផ្សេងៗ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            24 => 
            array (
                'id' => 26,
                'key' => 'Academic Curricula',
                'en' => 'Academic Curricula',
                'km' => 'កម្មវិធីសិក្សាអប់រំ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            25 => 
            array (
                'id' => 27,
                'key' => 'No.',
                'en' => 'No.',
                'km' => 'ល.រ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            26 => 
            array (
                'id' => 28,
                'key' => 'Subjects',
                'en' => 'Subjects',
                'km' => 'មុខវិជ្ជា',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            27 => 
            array (
                'id' => 29,
                'key' => 'Credits',
                'en' => 'Credits',
                'km' => 'ក្រេឌីត',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            28 => 
            array (
                'id' => 30,
                'key' => 'Hours',
                'en' => 'Hours',
                'km' => 'ម៉ោង',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            29 => 
            array (
                'id' => 31,
                'key' => 'Total Credits',
                'en' => 'Total Credits',
                'km' => 'ក្រេឌីតសរុប',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            30 => 
            array (
                'id' => 32,
                'key' => 'Career Opportunities',
                'en' => 'Career Opportunities',
                'km' => 'ឱកាសការងារ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            31 => 
            array (
                'id' => 33,
                'key' => 'Terms of Admission',
                'en' => 'Terms of Admission',
                'km' => 'លក្ខខណ្ឌនៃការចុះឈ្មោះចូលរៀន',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            32 => 
            array (
                'id' => 34,
                'key' => 'Syllabus & Course Structure',
                'en' => 'Syllabus & Course Structure',
                'km' => 'គ្រោងកម្មវិធីសិក្សា និងរចនាសម្ព័ន្ធវគ្គសិក្សា',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            33 => 
            array (
                'id' => 35,
                'key' => 'Search events...',
                'en' => 'Search events...',
                'km' => 'ស្វែងរកព្រឹត្តិការណ៍...',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            34 => 
            array (
                'id' => 36,
                'key' => 'No events found matching your criteria.',
                'en' => 'No events found matching your criteria.',
                'km' => 'រកមិនឃើញព្រឹត្តិការណ៍ដែលត្រូវនឹងលក្ខណៈវិនិច្ឆ័យរបស់អ្នកទេ។',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            35 => 
            array (
                'id' => 37,
                'key' => 'Rector Message',
                'en' => 'Rector Message',
                'km' => 'សាររបស់សាកលវិទ្យាធិការ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            36 => 
            array (
                'id' => 38,
                'key' => 'Rector\'s Message',
                'en' => 'Rector\'s Message',
                'km' => 'សាររបស់សាកលវិទ្យាធិការ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            37 => 
            array (
                'id' => 39,
                'key' => 'Foundation year',
                'en' => 'Foundation year',
                'km' => 'ឆ្នាំសិក្សាមូលដ្ឋាន',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            38 => 
            array (
                'id' => 40,
                'key' => 'Second year',
                'en' => 'Second year',
                'km' => 'ឆ្នាំទី២',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            39 => 
            array (
                'id' => 41,
                'key' => 'Third year',
                'en' => 'Third year',
                'km' => 'ឆ្នាំទី៣',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            40 => 
            array (
                'id' => 42,
                'key' => 'Last year',
                'en' => 'Last year',
                'km' => 'ឆ្នាំបញ្ចប់',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            41 => 
            array (
                'id' => 43,
                'key' => 'Read Full Article',
                'en' => 'Read Full Article',
                'km' => 'អានអត្ថបទពេញ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            42 => 
            array (
                'id' => 44,
                'key' => 'Back to Events',
                'en' => 'Back to Events',
                'km' => 'ត្រឡប់ទៅព្រឹត្តិការណ៍វិញ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            43 => 
            array (
                'id' => 45,
                'key' => 'Administration and Accounting Office',
                'en' => 'Administration and Accounting Office',
                'km' => 'ការិយាល័យរដ្ឋបាល និងហិរញ្ញវត្ថុ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            44 => 
            array (
                'id' => 46,
                'key' => 'Academic Affairs Office',
                'en' => 'Academic Affairs Office',
                'km' => 'ការិយាល័យសិក្សាធិការ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            45 => 
            array (
                'id' => 47,
                'key' => 'Student Affairs Office',
                'en' => 'Student Affairs Office',
                'km' => 'ការិយាល័យកិច្ចការនិស្សិត',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            46 => 
            array (
                'id' => 48,
                'key' => 'Personnel and Human Resources Office',
                'en' => 'Personnel and Human Resources Office',
                'km' => 'ការិយាល័យបុគ្គលិក និងអភិវឌ្ឍន៍ធនធានមនុស្ស',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            47 => 
            array (
                'id' => 49,
                'key' => 'Dormitory Office',
                'en' => 'Dormitory Office',
                'km' => 'ការិយាល័យអន្តេវាសិកដ្ឋាន',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            48 => 
            array (
                'id' => 50,
                'key' => 'Planning and Research Office',
                'en' => 'Planning and Research Office',
                'km' => 'ការិយាល័យផែនការ និងស្រាវជ្រាវ',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            49 => 
            array (
                'id' => 51,
                'key' => 'Internal Quality Assurance Office',
                'en' => 'Internal Quality Assurance Office',
                'km' => 'ការិយាល័យធានាគុណភាពផ្ទៃក្នុង',
                'created_at' => '2026-07-14 04:33:47',
                'updated_at' => '2026-07-14 04:33:47',
            ),
            50 => 
            array (
                'id' => 52,
                'key' => 'Exam and Evaluation',
                'en' => 'Exam and Evaluation',
                'km' => 'ការវាយតម្លៃ និងការប្រឡង',
                'created_at' => '2026-07-14 04:33:48',
                'updated_at' => '2026-07-14 04:33:48',
            ),
            51 => 
            array (
                'id' => 53,
                'key' => 'Departments',
                'en' => 'Departments',
                'km' => 'ដេប៉ាតឺម៉ង់',
                'created_at' => '2026-07-14 04:33:48',
                'updated_at' => '2026-07-14 04:33:48',
            ),
            52 => 
            array (
                'id' => 54,
                'key' => 'Search programs...',
                'en' => 'Search programs...',
                'km' => 'ស្វែងរកកម្មវិធីសិក្សា...',
                'created_at' => '2026-07-14 04:33:48',
                'updated_at' => '2026-07-14 04:33:48',
            ),
            53 => 
            array (
                'id' => 55,
                'key' => 'No programs found.',
                'en' => 'No programs found.',
                'km' => 'រកមិនឃើញកម្មវិធីសិក្សាទេ។',
                'created_at' => '2026-07-14 04:33:48',
                'updated_at' => '2026-07-14 04:33:48',
            ),
            54 => 
            array (
                'id' => 56,
                'key' => 'Close',
                'en' => 'Close',
                'km' => 'បិទ',
                'created_at' => '2026-07-14 04:33:48',
                'updated_at' => '2026-07-14 04:33:48',
            ),
            55 => 
            array (
                'id' => 57,
                'key' => 'Submit',
                'en' => 'Submit',
                'km' => 'បញ្ជូន',
                'created_at' => '2026-07-14 04:33:48',
                'updated_at' => '2026-07-14 04:33:48',
            ),
            56 => 
            array (
                'id' => 58,
                'key' => 'Save Changes',
                'en' => 'Save Changes',
                'km' => 'រក្សាទុកការផ្លាស់ប្តូរ',
                'created_at' => '2026-07-14 04:33:48',
                'updated_at' => '2026-07-14 04:33:48',
            ),
            57 => 
            array (
                'id' => 59,
                'key' => 'Goals and Purposes',
                'en' => 'Goals and Purposes',
                'km' => 'គោលដៅ និងគោលបំណង',
                'created_at' => '2026-07-14 07:07:54',
                'updated_at' => '2026-07-14 07:07:54',
            ),
            58 => 
            array (
                'id' => 60,
                'key' => 'History of DUC',
                'en' => 'History of DUC',
                'km' => 'ប្រវត្តិសាកលវិទ្យាល័យឌីជីថលកម្ពុជា',
                'created_at' => '2026-07-14 07:09:00',
                'updated_at' => '2026-07-14 07:09:00',
            ),
            59 => 
            array (
                'id' => 61,
                'key' => 'About Us',
                'en' => 'About Us',
                'km' => 'អំពីយើង',
                'created_at' => '2026-07-14 07:10:03',
                'updated_at' => '2026-07-14 07:10:03',
            ),
            60 => 
            array (
                'id' => 62,
                'key' => 'See All Events',
                'en' => 'See All Events',
                'km' => 'មើលព្រឹត្តិការណ៍ទាំងអស់',
                'created_at' => '2026-07-14 07:11:13',
                'updated_at' => '2026-07-14 07:11:13',
            ),
            61 => 
            array (
                'id' => 63,
                'key' => 'Read more',
                'en' => 'Read more',
                'km' => 'អានបន្ថែម',
                'created_at' => '2026-07-14 07:11:52',
                'updated_at' => '2026-07-14 07:11:52',
            ),
            62 => 
            array (
                'id' => 64,
                'key' => 'Four Years at Digital University of Cambodia',
                'en' => 'Four Years at Digital University of Cambodia',
                'km' => 'បួនឆ្នាំនៅសាកលវិទ្យាល័យឌីជីថលកម្ពុជា',
                'created_at' => '2026-07-14 07:13:28',
                'updated_at' => '2026-07-14 07:13:28',
            ),
            63 => 
            array (
                'id' => 65,
                'key' => 'Digital University of Cambodia',
                'en' => 'Digital University of Cambodia',
                'km' => 'សាកលវិទ្យាល័យឌីជីថលកម្ពុជា',
                'created_at' => '2026-07-14 07:14:03',
                'updated_at' => '2026-07-14 07:42:05',
            ),
            64 => 
            array (
                'id' => 66,
                'key' => 'Faculties',
                'en' => 'Faculties',
                'km' => 'មហាវិទ្យាល័យ',
                'created_at' => '2026-07-14 07:18:52',
                'updated_at' => '2026-07-14 07:18:52',
            ),
            65 => 
            array (
                'id' => 67,
                'key' => 'News/Events',
                'en' => 'News/Events',
                'km' => 'ព័ត៌មាន និង​ ព្រឹត្តិការណ៍',
                'created_at' => '2026-07-14 07:20:20',
                'updated_at' => '2026-07-14 07:20:20',
            ),
            66 => 
            array (
                'id' => 68,
                'key' => 'Send Us a Message',
                'en' => 'Send Us a Message',
                'km' => 'ផ្ញើសារមកកាន់យើង',
                'created_at' => '2026-07-14 07:21:23',
                'updated_at' => '2026-07-14 07:21:23',
            ),
            67 => 
            array (
                'id' => 69,
                'key' => 'Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.',
                'en' => 'Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.',
                'km' => 'តើអ្នកមានសំណួរអំពីការចូលរៀន កម្មវិធីសិក្សា ឬជីវិតក្នុងបរិវេណសាលាដែរឬទេ? សូមទាក់ទងមកយើង ហើយក្រុមការងាររបស់យើងនឹងឆ្លើយតបទៅកាន់អ្នកវិញក្នុងពេលឆាប់ៗនេះ។',
                'created_at' => '2026-07-14 07:23:26',
                'updated_at' => '2026-07-14 07:23:26',
            ),
            68 => 
            array (
                'id' => 70,
            'key' => 'Required fields are marked with an asterisk (*)',
            'en' => 'Required fields are marked with an asterisk (*)',
            'km' => 'ប្រអប់ដែលតម្រូវឱ្យបំពេញត្រូវបានសម្គាល់ដោយសញ្ញាផ្កាយ (*)',
                'created_at' => '2026-07-14 07:23:54',
                'updated_at' => '2026-07-14 07:23:54',
            ),
            69 => 
            array (
                'id' => 73,
                'key' => 'Full Name *',
                'en' => 'Full Name *',
                'km' => 'ឈ្មោះពេញ *',
                'created_at' => '2026-07-14 07:28:52',
                'updated_at' => '2026-07-14 07:28:52',
            ),
            70 => 
            array (
                'id' => 74,
                'key' => 'Email Address *',
                'en' => 'Email Address *',
                'km' => 'អាសយដ្ឋានអ៊ីមែល *',
                'created_at' => '2026-07-14 07:29:21',
                'updated_at' => '2026-07-14 07:29:21',
            ),
            71 => 
            array (
                'id' => 75,
                'key' => 'Subject *',
                'en' => 'Subject *',
                'km' => 'ប្រធានបទ *',
                'created_at' => '2026-07-14 07:29:54',
                'updated_at' => '2026-07-14 07:29:54',
            ),
            72 => 
            array (
                'id' => 76,
                'key' => 'Message *',
                'en' => 'Message *',
                'km' => 'សារ *',
                'created_at' => '2026-07-14 07:30:22',
                'updated_at' => '2026-07-14 07:30:22',
            ),
            73 => 
            array (
                'id' => 77,
                'key' => 'Address',
                'en' => 'Address',
                'km' => 'អាសយដ្ឋាន',
                'created_at' => '2026-07-14 07:30:50',
                'updated_at' => '2026-07-14 07:30:50',
            ),
            74 => 
            array (
                'id' => 78,
                'key' => 'Phone Support',
                'en' => 'Phone Support',
                'km' => 'ជំនួយទូរស័ព្ទ',
                'created_at' => '2026-07-14 07:31:21',
                'updated_at' => '2026-07-14 07:31:21',
            ),
            75 => 
            array (
                'id' => 79,
                'key' => 'Office',
                'en' => 'Office',
                'km' => 'ការិយាល័យ',
                'created_at' => '2026-07-14 07:32:15',
                'updated_at' => '2026-07-14 07:32:15',
            ),
            76 => 
            array (
                'id' => 80,
                'key' => 'About',
                'en' => 'About',
                'km' => 'អំពីយើង',
                'created_at' => '2026-07-14 07:32:51',
                'updated_at' => '2026-07-14 07:32:51',
            ),
            77 => 
            array (
                'id' => 81,
                'key' => 'Our Details',
                'en' => 'Our Details',
                'km' => 'ព័ត៌មានលម្អិតរបស់យើង',
                'created_at' => '2026-07-14 07:33:15',
                'updated_at' => '2026-07-14 07:33:15',
            ),
            78 => 
            array (
                'id' => 82,
                'key' => 'Working Hours',
                'en' => 'Working Hours',
                'km' => 'ម៉ោងធ្វើការ',
                'created_at' => '2026-07-14 07:33:36',
                'updated_at' => '2026-07-14 07:33:36',
            ),
            79 => 
            array (
                'id' => 83,
                'key' => 'Mon - Sat',
                'en' => 'Mon - Sat',
                'km' => 'ថ្ងៃចន្ទ - ថ្ងៃសៅរ៍',
                'created_at' => '2026-07-14 07:34:03',
                'updated_at' => '2026-07-14 07:34:03',
            ),
            80 => 
            array (
                'id' => 84,
                'key' => 'Weekend',
                'en' => 'Weekend',
                'km' => 'ចុងសប្តាហ៍',
                'created_at' => '2026-07-14 07:34:24',
                'updated_at' => '2026-07-14 07:34:24',
            ),
            81 => 
            array (
                'id' => 85,
                'key' => 'AM',
                'en' => 'AM',
                'km' => 'ព្រឹក',
                'created_at' => '2026-07-14 07:34:47',
                'updated_at' => '2026-07-14 07:34:47',
            ),
            82 => 
            array (
                'id' => 86,
                'key' => 'PM',
                'en' => 'PM',
                'km' => 'រសៀល',
                'created_at' => '2026-07-14 07:35:53',
                'updated_at' => '2026-07-14 07:35:53',
            ),
            83 => 
            array (
                'id' => 87,
                'key' => 'Social Media',
                'en' => 'Social Media',
                'km' => 'បណ្តាញសង្គម',
                'created_at' => '2026-07-14 07:36:15',
                'updated_at' => '2026-07-14 07:36:15',
            ),
            84 => 
            array (
                'id' => 88,
                'key' => 'Contact Information',
                'en' => 'Contact Information',
                'km' => 'ព័ត៌មានទំនាក់ទំនង',
                'created_at' => '2026-07-14 07:36:37',
                'updated_at' => '2026-07-14 07:36:37',
            ),
            85 => 
            array (
                'id' => 89,
                'key' => 'Email',
                'en' => 'Email',
                'km' => 'អ៊ីមែល',
                'created_at' => '2026-07-14 07:38:52',
                'updated_at' => '2026-07-14 07:38:52',
            ),
            86 => 
            array (
                'id' => 90,
                'key' => 'Direct Lines',
                'en' => 'Direct Lines',
                'km' => 'ទំនាក់ទំនងផ្ទាល់',
                'created_at' => '2026-07-14 07:47:23',
                'updated_at' => '2026-07-14 07:47:23',
            ),
            87 => 
            array (
                'id' => 92,
                'key' => 'Student Academic Evaluation',
                'en' => 'Student Academic Evaluation',
                'km' => 'ការវាយតម្លៃការសិក្សារបស់សិស្ស',
                'created_at' => '2026-07-14 07:53:11',
                'updated_at' => '2026-07-14 07:53:11',
            ),
            88 => 
            array (
                'id' => 93,
                'key' => 'Evaluation Criteria',
                'en' => 'Evaluation Criteria',
                'km' => 'លក្ខណៈវិនិច្ឆ័យវាយតម្លៃ',
                'created_at' => '2026-07-14 07:53:35',
                'updated_at' => '2026-07-14 07:53:35',
            ),
            89 => 
            array (
                'id' => 94,
                'key' => 'Percentage',
                'en' => 'Percentage',
                'km' => 'ភាគរយ',
                'created_at' => '2026-07-14 07:53:57',
                'updated_at' => '2026-07-14 07:53:57',
            ),
            90 => 
            array (
                'id' => 95,
                'key' => 'Total Score',
                'en' => 'Total Score',
                'km' => 'ពិន្ទុសរុប',
                'created_at' => '2026-07-14 07:54:29',
                'updated_at' => '2026-07-14 07:54:29',
            ),
            91 => 
            array (
                'id' => 96,
                'key' => 'Percentage Score',
                'en' => 'Percentage Score',
                'km' => 'ពិន្ទុជាភាគរយ',
                'created_at' => '2026-07-14 07:54:48',
                'updated_at' => '2026-07-14 07:54:48',
            ),
            92 => 
            array (
                'id' => 97,
                'key' => 'Letter Grade',
                'en' => 'Letter Grade',
                'km' => 'ចំណាត់ថ្នាក់',
                'created_at' => '2026-07-14 07:55:05',
                'updated_at' => '2026-07-14 07:56:52',
            ),
            93 => 
            array (
                'id' => 98,
                'key' => 'Grade Point',
                'en' => 'Grade Point',
                'km' => 'ពិន្ទុ',
                'created_at' => '2026-07-14 07:55:28',
                'updated_at' => '2026-07-14 07:55:28',
            ),
            94 => 
            array (
                'id' => 99,
                'key' => 'Description',
                'en' => 'Description',
                'km' => 'ការពិពណ៌នា',
                'created_at' => '2026-07-14 07:57:12',
                'updated_at' => '2026-07-14 07:57:12',
            ),
            95 => 
            array (
                'id' => 100,
                'key' => 'to',
                'en' => 'to',
                'km' => 'ដល់',
                'created_at' => '2026-07-14 08:03:13',
                'updated_at' => '2026-07-14 08:29:31',
            ),
            96 => 
            array (
                'id' => 101,
                'key' => 'The passing grade point for each subject is defined as 2.00 and above.',
                'en' => 'The passing grade point for each subject is defined as 2.00 and above.',
                'km' => 'ពិន្ទុនិទ្ទេសនៃមុខវិជ្ជានីមួយៗដែលកំណត់ថាជាប់គឺ ចាប់ពី ២.០០ ឡើងទៅ ។',
                'created_at' => '2026-07-14 08:24:31',
                'updated_at' => '2026-07-14 08:24:31',
            ),
            97 => 
            array (
                'id' => 102,
            'key' => 'The formula for calculating the Grade Point Average (GPA) is:',
            'en' => 'The formula for calculating the Grade Point Average (GPA) is:',
            'km' => 'រូបមន្តនៃការគណនារកមធ្យមភាគនៃពិន្ទុនិទ្ទេសសរុប (Grade Point Average - GIA) គឺ៖',
                'created_at' => '2026-07-14 08:24:54',
                'updated_at' => '2026-07-14 08:24:54',
            ),
            98 => 
            array (
                'id' => 103,
            'key' => 'Sum of (Grade Point × Credit Value of each studied subject)',
            'en' => 'Sum of (Grade Point × Credit Value of each studied subject)',
            'km' => 'ផលបូកនៃ (ពិន្ទុនិទ្ទេស x តម្លៃក្រេឌីតនៃមុខវិជ្ជានីមួយៗ ដែលត្រូវរៀន)',
                'created_at' => '2026-07-14 08:25:18',
                'updated_at' => '2026-07-14 08:27:27',
            ),
            99 => 
            array (
                'id' => 104,
                'key' => 'Total sum of credit values for all studied subjects',
                'en' => 'Total sum of credit values for all studied subjects',
                'km' => 'ផលបូកនៃតម្លៃក្រេឌីតដែលត្រូវរៀនគ្រប់មុខវិជ្ជា',
                'created_at' => '2026-07-14 08:28:49',
                'updated_at' => '2026-07-14 08:28:49',
            ),
            100 => 
            array (
                'id' => 105,
                'key' => 'Human Resources Office',
                'en' => 'Human Resources Office',
                'km' => 'ការិយាល័យធនធានមនុស្ស',
                'created_at' => '2026-07-14 08:46:42',
                'updated_at' => '2026-07-14 08:46:42',
            ),
            101 => 
            array (
                'id' => 106,
                'key' => 'Administration & Accounting Office',
                'en' => 'Administration & Accounting Office',
                'km' => 'ការិយាល័យរដ្ឋបាល និងគណនេយ្យ',
                'created_at' => '2026-07-14 08:48:23',
                'updated_at' => '2026-07-14 08:48:23',
            ),
            102 => 
            array (
                'id' => 107,
                'key' => 'Planning & Research Office',
                'en' => 'Planning & Research Office',
                'km' => 'ការិយាល័យផែនការ និងស្រាវជ្រាវ',
                'created_at' => '2026-07-14 08:50:04',
                'updated_at' => '2026-07-14 08:50:04',
            ),
            103 => 
            array (
                'id' => 108,
                'key' => 'Bachelor\'s Degree',
                'en' => 'Bachelor\'s Degree',
                'km' => 'បរិញ្ញាបត្រ',
                'created_at' => '2026-08-03 07:40:41',
                'updated_at' => '2026-08-03 07:43:35',
            ),
            104 => 
            array (
                'id' => 109,
                'key' => 'Associate\'s Degree',
                'en' => 'Associate\'s Degree',
                'km' => 'បរិញ្ញាបត្ររង',
                'created_at' => '2026-08-03 07:42:22',
                'updated_at' => '2026-08-03 07:42:22',
            ),
            105 => 
            array (
                'id' => 110,
                'key' => 'Event Detail',
                'en' => 'Event Detail',
                'km' => 'ព័ត៌មានលម្អិតអំពីព្រឹត្តិការណ៍',
                'created_at' => '2026-08-03 08:07:53',
                'updated_at' => '2026-08-03 08:07:53',
            ),
            106 => 
            array (
                'id' => 111,
                'key' => 'School Action Videos',
                'en' => 'School Action Videos',
                'km' => 'វីដេអូសកម្មភាពសាលារៀន',
                'created_at' => '2026-08-20 09:16:37',
                'updated_at' => '2026-08-20 09:16:37',
            ),
            107 => 
            array (
                'id' => 112,
                'key' => 'Attached documents for scholarship application',
                'en' => 'Attached documents for scholarship application',
                'km' => 'សំណុំឯកសារភ្ជាប់សម្រាប់ស្នើសុំអាហារូបករណ៍',
                'created_at' => '2026-08-21 04:00:47',
                'updated_at' => '2026-08-21 04:00:47',
            ),
        ));
        
        
    }
}