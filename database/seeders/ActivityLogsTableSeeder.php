<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActivityLogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('activity_logs')->delete();
        
        \DB::table('activity_logs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-07-21 04:06:42',
            ),
            1 => 
            array (
                'id' => 2,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-21 04:07:11',
                'updated_at' => '2026-07-21 04:07:11',
            ),
            2 => 
            array (
                'id' => 3,
                'user_name' => 'Admin User',
                'action' => 'Restored default footer & contact settings',
                'module' => 'settings',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-21 04:07:51',
                'updated_at' => '2026-07-21 04:07:51',
            ),
            3 => 
            array (
                'id' => 4,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-21 04:08:59',
                'updated_at' => '2026-07-21 04:08:59',
            ),
            4 => 
            array (
                'id' => 5,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-21 04:13:33',
                'updated_at' => '2026-07-21 04:13:33',
            ),
            5 => 
            array (
                'id' => 6,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-21 04:14:14',
                'updated_at' => '2026-07-21 04:14:14',
            ),
            6 => 
            array (
                'id' => 7,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-21 04:14:47',
                'updated_at' => '2026-07-21 04:14:47',
            ),
            7 => 
            array (
                'id' => 8,
                'user_name' => 'Admin User',
                'action' => 'Updated translation key \'Rector\'s Message\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-07-21 06:21:24',
                'updated_at' => '2026-07-21 06:21:24',
            ),
            8 => 
            array (
                'id' => 9,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Rector\'s Message\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:23:15',
                'updated_at' => '2026-07-21 06:23:15',
            ),
            9 => 
            array (
                'id' => 10,
                'user_name' => 'Admin User',
                'action' => 'Created navigation node \'About\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:25:53',
                'updated_at' => '2026-07-21 06:25:53',
            ),
            10 => 
            array (
                'id' => 11,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'About\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:26:12',
                'updated_at' => '2026-07-21 06:26:12',
            ),
            11 => 
            array (
                'id' => 12,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'About\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:27:12',
                'updated_at' => '2026-07-21 06:27:12',
            ),
            12 => 
            array (
                'id' => 13,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'About\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-07-21 06:27:32',
                'updated_at' => '2026-07-21 06:27:32',
            ),
            13 => 
            array (
                'id' => 14,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Offices\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:28:44',
                'updated_at' => '2026-07-21 06:28:44',
            ),
            14 => 
            array (
                'id' => 15,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Rector\'s Message\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:28:54',
                'updated_at' => '2026-07-21 06:28:54',
            ),
            15 => 
            array (
                'id' => 16,
                'user_name' => 'Admin User',
                'action' => 'Created navigation node \'About\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:29:35',
                'updated_at' => '2026-07-21 06:29:35',
            ),
            16 => 
            array (
                'id' => 17,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:32:27',
                'updated_at' => '2026-07-21 06:32:27',
            ),
            17 => 
            array (
                'id' => 18,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:33:02',
                'updated_at' => '2026-07-21 06:33:02',
            ),
            18 => 
            array (
                'id' => 19,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:35:37',
                'updated_at' => '2026-07-21 06:35:37',
            ),
            19 => 
            array (
                'id' => 20,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:36:35',
                'updated_at' => '2026-07-21 06:36:35',
            ),
            20 => 
            array (
                'id' => 21,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:37:56',
                'updated_at' => '2026-07-21 06:37:56',
            ),
            21 => 
            array (
                'id' => 22,
                'user_name' => 'Admin User',
                'action' => 'Deleted page \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-07-21 06:38:48',
                'updated_at' => '2026-07-21 06:38:48',
            ),
            22 => 
            array (
                'id' => 23,
                'user_name' => 'Admin User',
                'action' => 'Restored default content for all system pages',
                'module' => 'pages',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-21 06:44:38',
                'updated_at' => '2026-07-21 06:44:38',
            ),
            23 => 
            array (
                'id' => 24,
                'user_name' => 'Admin User',
                'action' => 'Restored default content for all system pages',
                'module' => 'pages',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-21 06:45:26',
                'updated_at' => '2026-07-21 06:45:26',
            ),
            24 => 
            array (
                'id' => 25,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:45:40',
                'updated_at' => '2026-07-21 06:45:40',
            ),
            25 => 
            array (
                'id' => 26,
                'user_name' => 'Admin User',
                'action' => 'Created navigation node \'Library\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:50:08',
                'updated_at' => '2026-07-21 06:50:08',
            ),
            26 => 
            array (
                'id' => 27,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Library\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 06:50:46',
                'updated_at' => '2026-07-21 06:50:46',
            ),
            27 => 
            array (
                'id' => 28,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:52:30',
                'updated_at' => '2026-07-21 06:52:30',
            ),
            28 => 
            array (
                'id' => 29,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 06:53:04',
                'updated_at' => '2026-07-21 06:53:04',
            ),
            29 => 
            array (
                'id' => 30,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:00:58',
                'updated_at' => '2026-07-21 07:00:58',
            ),
            30 => 
            array (
                'id' => 31,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:15:02',
                'updated_at' => '2026-07-21 07:15:02',
            ),
            31 => 
            array (
                'id' => 32,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:15:20',
                'updated_at' => '2026-07-21 07:15:20',
            ),
            32 => 
            array (
                'id' => 33,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:16:05',
                'updated_at' => '2026-07-21 07:16:05',
            ),
            33 => 
            array (
                'id' => 34,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:16:35',
                'updated_at' => '2026-07-21 07:16:35',
            ),
            34 => 
            array (
                'id' => 35,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:18:23',
                'updated_at' => '2026-07-21 07:18:23',
            ),
            35 => 
            array (
                'id' => 36,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:18:59',
                'updated_at' => '2026-07-21 07:18:59',
            ),
            36 => 
            array (
                'id' => 37,
                'user_name' => 'Admin User',
                'action' => 'Updated translation key \'Academic Affairs Office\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-07-21 07:24:18',
                'updated_at' => '2026-07-21 07:24:18',
            ),
            37 => 
            array (
                'id' => 38,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 07:29:28',
                'updated_at' => '2026-07-21 07:29:28',
            ),
            38 => 
            array (
                'id' => 39,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Personnel and Human Resources Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 07:43:41',
                'updated_at' => '2026-07-21 07:43:41',
            ),
            39 => 
            array (
                'id' => 40,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Academic Affairs Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 07:44:17',
                'updated_at' => '2026-07-21 07:44:17',
            ),
            40 => 
            array (
                'id' => 41,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Administration and Accounting Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 07:45:13',
                'updated_at' => '2026-07-21 07:45:13',
            ),
            41 => 
            array (
                'id' => 42,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Internal Quality Assurance Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-07-21 07:46:46',
                'updated_at' => '2026-07-21 07:46:46',
            ),
            42 => 
            array (
                'id' => 43,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Exam and Evaluation\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 08:05:41',
                'updated_at' => '2026-07-21 08:05:41',
            ),
            43 => 
            array (
                'id' => 44,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Exam and Evaluation\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-21 08:10:24',
                'updated_at' => '2026-07-21 08:10:24',
            ),
            44 => 
            array (
                'id' => 45,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Law and Political Science\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:19:22',
                'updated_at' => '2026-07-21 08:19:22',
            ),
            45 => 
            array (
                'id' => 46,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:21:46',
                'updated_at' => '2026-07-21 08:21:46',
            ),
            46 => 
            array (
                'id' => 47,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:22:33',
                'updated_at' => '2026-07-21 08:22:33',
            ),
            47 => 
            array (
                'id' => 48,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:23:17',
                'updated_at' => '2026-07-21 08:23:17',
            ),
            48 => 
            array (
                'id' => 49,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:23:40',
                'updated_at' => '2026-07-21 08:23:40',
            ),
            49 => 
            array (
                'id' => 50,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:24:03',
                'updated_at' => '2026-07-21 08:24:03',
            ),
            50 => 
            array (
                'id' => 51,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:25:22',
                'updated_at' => '2026-07-21 08:25:22',
            ),
            51 => 
            array (
                'id' => 52,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:29:08',
                'updated_at' => '2026-07-21 08:29:08',
            ),
            52 => 
            array (
                'id' => 53,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:31:34',
                'updated_at' => '2026-07-21 08:31:34',
            ),
            53 => 
            array (
                'id' => 54,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:45:45',
                'updated_at' => '2026-07-21 08:45:45',
            ),
            54 => 
            array (
                'id' => 55,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-21 08:50:10',
                'updated_at' => '2026-07-21 08:50:10',
            ),
            55 => 
            array (
                'id' => 56,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-07-21 08:54:20',
            ),
            56 => 
            array (
                'id' => 57,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 00:53:51',
                'updated_at' => '2026-07-22 00:53:51',
            ),
            57 => 
            array (
                'id' => 58,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 01:45:47',
                'updated_at' => '2026-07-22 01:45:47',
            ),
            58 => 
            array (
                'id' => 59,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 01:49:11',
                'updated_at' => '2026-07-22 01:49:11',
            ),
            59 => 
            array (
                'id' => 60,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 01:52:41',
                'updated_at' => '2026-07-22 01:52:41',
            ),
            60 => 
            array (
                'id' => 61,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 02:30:23',
                'updated_at' => '2026-07-22 02:30:23',
            ),
            61 => 
            array (
                'id' => 62,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 02:31:13',
                'updated_at' => '2026-07-22 02:31:13',
            ),
            62 => 
            array (
                'id' => 63,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 02:33:06',
                'updated_at' => '2026-07-22 02:33:06',
            ),
            63 => 
            array (
                'id' => 64,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 03:10:52',
                'updated_at' => '2026-07-22 03:10:52',
            ),
            64 => 
            array (
                'id' => 65,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 03:13:50',
                'updated_at' => '2026-07-22 03:13:50',
            ),
            65 => 
            array (
                'id' => 66,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 03:15:00',
                'updated_at' => '2026-07-22 03:15:00',
            ),
            66 => 
            array (
                'id' => 67,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 03:15:58',
                'updated_at' => '2026-07-22 03:15:58',
            ),
            67 => 
            array (
                'id' => 68,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 03:18:20',
                'updated_at' => '2026-07-22 03:18:20',
            ),
            68 => 
            array (
                'id' => 69,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 03:43:52',
                'updated_at' => '2026-07-22 03:43:52',
            ),
            69 => 
            array (
                'id' => 70,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 04:08:35',
                'updated_at' => '2026-07-22 04:08:35',
            ),
            70 => 
            array (
                'id' => 71,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Specific Purposes\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 06:44:39',
                'updated_at' => '2026-07-22 06:44:39',
            ),
            71 => 
            array (
                'id' => 72,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 06:56:39',
                'updated_at' => '2026-07-22 06:56:39',
            ),
            72 => 
            array (
                'id' => 73,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 07:13:00',
                'updated_at' => '2026-07-22 07:13:00',
            ),
            73 => 
            array (
                'id' => 74,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 07:16:08',
                'updated_at' => '2026-07-22 07:16:08',
            ),
            74 => 
            array (
                'id' => 75,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 07:19:20',
                'updated_at' => '2026-07-22 07:19:20',
            ),
            75 => 
            array (
                'id' => 76,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 07:34:40',
                'updated_at' => '2026-07-22 07:34:40',
            ),
            76 => 
            array (
                'id' => 77,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 07:35:23',
                'updated_at' => '2026-07-22 07:35:23',
            ),
            77 => 
            array (
                'id' => 78,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 08:16:32',
                'updated_at' => '2026-07-22 08:16:32',
            ),
            78 => 
            array (
                'id' => 79,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 08:23:32',
                'updated_at' => '2026-07-22 08:23:32',
            ),
            79 => 
            array (
                'id' => 80,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 08:27:05',
                'updated_at' => '2026-07-22 08:27:05',
            ),
            80 => 
            array (
                'id' => 81,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 08:28:25',
                'updated_at' => '2026-07-22 08:28:25',
            ),
            81 => 
            array (
                'id' => 82,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Architecture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 08:32:21',
                'updated_at' => '2026-07-22 08:32:21',
            ),
            82 => 
            array (
                'id' => 83,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 08:34:10',
                'updated_at' => '2026-07-22 08:34:10',
            ),
            83 => 
            array (
                'id' => 84,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 09:13:30',
                'updated_at' => '2026-07-22 09:13:30',
            ),
            84 => 
            array (
                'id' => 85,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Architecture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-22 09:49:56',
                'updated_at' => '2026-07-22 09:49:56',
            ),
            85 => 
            array (
                'id' => 86,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Interior Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 02:10:14',
                'updated_at' => '2026-07-23 02:10:14',
            ),
            86 => 
            array (
                'id' => 87,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agronomy and Horticulture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 02:40:16',
                'updated_at' => '2026-07-23 02:40:16',
            ),
            87 => 
            array (
                'id' => 88,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agricultural Economics\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 02:59:24',
                'updated_at' => '2026-07-23 02:59:24',
            ),
            88 => 
            array (
                'id' => 89,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Rural Development\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 03:17:03',
                'updated_at' => '2026-07-23 03:17:03',
            ),
            89 => 
            array (
                'id' => 90,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 03:21:29',
                'updated_at' => '2026-07-23 03:21:29',
            ),
            90 => 
            array (
                'id' => 91,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 03:41:42',
                'updated_at' => '2026-07-23 03:41:42',
            ),
            91 => 
            array (
                'id' => 92,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 03:56:37',
                'updated_at' => '2026-07-23 03:56:37',
            ),
            92 => 
            array (
                'id' => 93,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 04:12:38',
                'updated_at' => '2026-07-23 04:12:38',
            ),
            93 => 
            array (
                'id' => 94,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Administration\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 06:40:57',
                'updated_at' => '2026-07-23 06:40:57',
            ),
            94 => 
            array (
                'id' => 95,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Science\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 07:02:50',
                'updated_at' => '2026-07-23 07:02:50',
            ),
            95 => 
            array (
                'id' => 96,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Science\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 07:31:08',
                'updated_at' => '2026-07-23 07:31:08',
            ),
            96 => 
            array (
                'id' => 97,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agronomy and Horticulture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 07:52:08',
                'updated_at' => '2026-07-23 07:52:08',
            ),
            97 => 
            array (
                'id' => 98,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agricultural Economics\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 08:03:13',
                'updated_at' => '2026-07-23 08:03:13',
            ),
            98 => 
            array (
                'id' => 99,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Rural Development\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 08:16:03',
                'updated_at' => '2026-07-23 08:16:03',
            ),
            99 => 
            array (
                'id' => 100,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 08:33:44',
                'updated_at' => '2026-07-23 08:33:44',
            ),
            100 => 
            array (
                'id' => 101,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 08:51:26',
                'updated_at' => '2026-07-23 08:51:26',
            ),
            101 => 
            array (
                'id' => 102,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Science\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 09:06:27',
                'updated_at' => '2026-07-23 09:06:27',
            ),
            102 => 
            array (
                'id' => 103,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 09:26:18',
                'updated_at' => '2026-07-23 09:26:18',
            ),
            103 => 
            array (
                'id' => 104,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 09:28:53',
                'updated_at' => '2026-07-23 09:28:53',
            ),
            104 => 
            array (
                'id' => 105,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 09:37:07',
                'updated_at' => '2026-07-23 09:37:07',
            ),
            105 => 
            array (
                'id' => 106,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 09:52:53',
                'updated_at' => '2026-07-23 09:52:53',
            ),
            106 => 
            array (
                'id' => 107,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Specific Purposes\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 10:00:08',
                'updated_at' => '2026-07-23 10:00:08',
            ),
            107 => 
            array (
                'id' => 108,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Specific Purposes\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 10:00:09',
                'updated_at' => '2026-07-23 10:00:09',
            ),
            108 => 
            array (
                'id' => 109,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Specific Purposes\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-23 10:02:11',
                'updated_at' => '2026-07-23 10:02:11',
            ),
            109 => 
            array (
                'id' => 110,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Specific Purposes\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 01:28:01',
                'updated_at' => '2026-07-24 01:28:01',
            ),
            110 => 
            array (
                'id' => 111,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 01:58:37',
                'updated_at' => '2026-07-24 01:58:37',
            ),
            111 => 
            array (
                'id' => 112,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:00:33',
                'updated_at' => '2026-07-24 02:00:33',
            ),
            112 => 
            array (
                'id' => 113,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:03:32',
                'updated_at' => '2026-07-24 02:03:32',
            ),
            113 => 
            array (
                'id' => 114,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:10:50',
                'updated_at' => '2026-07-24 02:10:50',
            ),
            114 => 
            array (
                'id' => 115,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:19:41',
                'updated_at' => '2026-07-24 02:19:41',
            ),
            115 => 
            array (
                'id' => 116,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:21:28',
                'updated_at' => '2026-07-24 02:21:28',
            ),
            116 => 
            array (
                'id' => 117,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:23:35',
                'updated_at' => '2026-07-24 02:23:35',
            ),
            117 => 
            array (
                'id' => 118,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:24:45',
                'updated_at' => '2026-07-24 02:24:45',
            ),
            118 => 
            array (
                'id' => 119,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:27:56',
                'updated_at' => '2026-07-24 02:27:56',
            ),
            119 => 
            array (
                'id' => 120,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:33:12',
                'updated_at' => '2026-07-24 02:33:12',
            ),
            120 => 
            array (
                'id' => 121,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:34:06',
                'updated_at' => '2026-07-24 02:34:06',
            ),
            121 => 
            array (
                'id' => 122,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 02:48:07',
                'updated_at' => '2026-07-24 02:48:07',
            ),
            122 => 
            array (
                'id' => 123,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 03:01:38',
                'updated_at' => '2026-07-24 03:01:38',
            ),
            123 => 
            array (
                'id' => 124,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 03:02:46',
                'updated_at' => '2026-07-24 03:02:46',
            ),
            124 => 
            array (
                'id' => 125,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 03:03:56',
                'updated_at' => '2026-07-24 03:03:56',
            ),
            125 => 
            array (
                'id' => 126,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 03:13:24',
                'updated_at' => '2026-07-24 03:13:24',
            ),
            126 => 
            array (
                'id' => 127,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Architecture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 03:22:07',
                'updated_at' => '2026-07-24 03:22:07',
            ),
            127 => 
            array (
                'id' => 128,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Interior Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 03:29:59',
                'updated_at' => '2026-07-24 03:29:59',
            ),
            128 => 
            array (
                'id' => 129,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 06:41:27',
                'updated_at' => '2026-07-24 06:41:27',
            ),
            129 => 
            array (
                'id' => 130,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of English Language\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 06:41:48',
                'updated_at' => '2026-07-24 06:41:48',
            ),
            130 => 
            array (
                'id' => 131,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Engineering and Architecture\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 06:42:02',
                'updated_at' => '2026-07-24 06:42:02',
            ),
            131 => 
            array (
                'id' => 132,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 06:42:15',
                'updated_at' => '2026-07-24 06:42:15',
            ),
            132 => 
            array (
                'id' => 133,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Law and Political Science\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 06:42:30',
                'updated_at' => '2026-07-24 06:42:30',
            ),
            133 => 
            array (
                'id' => 134,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Economic Sciences\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 06:42:49',
                'updated_at' => '2026-07-24 06:42:49',
            ),
            134 => 
            array (
                'id' => 135,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:32:42',
                'updated_at' => '2026-07-24 07:32:42',
            ),
            135 => 
            array (
                'id' => 136,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:34:44',
                'updated_at' => '2026-07-24 07:34:44',
            ),
            136 => 
            array (
                'id' => 137,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:36:17',
                'updated_at' => '2026-07-24 07:36:17',
            ),
            137 => 
            array (
                'id' => 138,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:37:21',
                'updated_at' => '2026-07-24 07:37:21',
            ),
            138 => 
            array (
                'id' => 139,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:39:20',
                'updated_at' => '2026-07-24 07:39:20',
            ),
            139 => 
            array (
                'id' => 140,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:42:28',
                'updated_at' => '2026-07-24 07:42:28',
            ),
            140 => 
            array (
                'id' => 141,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:43:01',
                'updated_at' => '2026-07-24 07:43:01',
            ),
            141 => 
            array (
                'id' => 142,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:47:13',
                'updated_at' => '2026-07-24 07:47:13',
            ),
            142 => 
            array (
                'id' => 143,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:48:01',
                'updated_at' => '2026-07-24 07:48:01',
            ),
            143 => 
            array (
                'id' => 144,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:48:26',
                'updated_at' => '2026-07-24 07:48:26',
            ),
            144 => 
            array (
                'id' => 145,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-24 07:48:33',
                'updated_at' => '2026-07-24 07:48:33',
            ),
            145 => 
            array (
                'id' => 146,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:49:45',
                'updated_at' => '2026-07-24 07:49:45',
            ),
            146 => 
            array (
                'id' => 147,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:53:25',
                'updated_at' => '2026-07-24 07:53:25',
            ),
            147 => 
            array (
                'id' => 148,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:55:42',
                'updated_at' => '2026-07-24 07:55:42',
            ),
            148 => 
            array (
                'id' => 149,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Student Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:56:14',
                'updated_at' => '2026-07-24 07:56:14',
            ),
            149 => 
            array (
                'id' => 150,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:56:46',
                'updated_at' => '2026-07-24 07:56:46',
            ),
            150 => 
            array (
                'id' => 151,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:56:54',
                'updated_at' => '2026-07-24 07:56:54',
            ),
            151 => 
            array (
                'id' => 152,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Administration and Accounting Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:57:30',
                'updated_at' => '2026-07-24 07:57:30',
            ),
            152 => 
            array (
                'id' => 153,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Dormitory Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:58:04',
                'updated_at' => '2026-07-24 07:58:04',
            ),
            153 => 
            array (
                'id' => 154,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Internal Quality Assurance Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:58:40',
                'updated_at' => '2026-07-24 07:58:40',
            ),
            154 => 
            array (
                'id' => 155,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Planning and Research Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-24 07:59:07',
                'updated_at' => '2026-07-24 07:59:07',
            ),
            155 => 
            array (
                'id' => 156,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'DUC Convocation Ceremony 2024\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-24 08:00:46',
                'updated_at' => '2026-07-24 08:00:46',
            ),
            156 => 
            array (
                'id' => 157,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Cybersecurity Awareness seminar\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-24 08:01:13',
                'updated_at' => '2026-07-24 08:01:13',
            ),
            157 => 
            array (
                'id' => 158,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'IT Department Hackathon competition\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-24 08:01:25',
                'updated_at' => '2026-07-24 08:01:25',
            ),
            158 => 
            array (
                'id' => 159,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Admission Scholarship Program open\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-24 08:01:39',
                'updated_at' => '2026-07-24 08:01:39',
            ),
            159 => 
            array (
                'id' => 160,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Fintech and Blockchain Conference\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-24 08:01:49',
                'updated_at' => '2026-07-24 08:01:49',
            ),
            160 => 
            array (
                'id' => 161,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'DUC Campus Orientation 2024\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-24 08:02:03',
                'updated_at' => '2026-07-24 08:02:03',
            ),
            161 => 
            array (
                'id' => 162,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 08:05:59',
                'updated_at' => '2026-07-24 08:05:59',
            ),
            162 => 
            array (
                'id' => 163,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 08:07:09',
                'updated_at' => '2026-07-24 08:07:09',
            ),
            163 => 
            array (
                'id' => 164,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Engineering and Architecture\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 08:23:40',
                'updated_at' => '2026-07-24 08:23:40',
            ),
            164 => 
            array (
                'id' => 165,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Engineering and Architecture\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-24 08:25:06',
                'updated_at' => '2026-07-24 08:25:06',
            ),
            165 => 
            array (
                'id' => 166,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 01:31:30',
                'updated_at' => '2026-07-27 01:31:30',
            ),
            166 => 
            array (
                'id' => 167,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:07:38',
                'updated_at' => '2026-07-27 03:07:38',
            ),
            167 => 
            array (
                'id' => 168,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:19:29',
                'updated_at' => '2026-07-27 03:19:29',
            ),
            168 => 
            array (
                'id' => 169,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:21:12',
                'updated_at' => '2026-07-27 03:21:12',
            ),
            169 => 
            array (
                'id' => 170,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:22:27',
                'updated_at' => '2026-07-27 03:22:27',
            ),
            170 => 
            array (
                'id' => 171,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:36:14',
                'updated_at' => '2026-07-27 03:36:14',
            ),
            171 => 
            array (
                'id' => 172,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:37:12',
                'updated_at' => '2026-07-27 03:37:12',
            ),
            172 => 
            array (
                'id' => 173,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Engineering and Architecture\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:41:58',
                'updated_at' => '2026-07-27 03:41:58',
            ),
            173 => 
            array (
                'id' => 174,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of English Language\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:51:02',
                'updated_at' => '2026-07-27 03:51:02',
            ),
            174 => 
            array (
                'id' => 175,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of English Language\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 03:55:34',
                'updated_at' => '2026-07-27 03:55:34',
            ),
            175 => 
            array (
                'id' => 176,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of English Language\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-27 04:00:49',
                'updated_at' => '2026-07-27 04:00:49',
            ),
            176 => 
            array (
                'id' => 177,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-27 06:30:25',
                'updated_at' => '2026-07-27 06:30:25',
            ),
            177 => 
            array (
                'id' => 178,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Student Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-27 06:30:47',
                'updated_at' => '2026-07-27 06:30:47',
            ),
            178 => 
            array (
                'id' => 179,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Student Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-27 06:31:13',
                'updated_at' => '2026-07-27 06:31:13',
            ),
            179 => 
            array (
                'id' => 180,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Dormitory Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-27 06:31:45',
                'updated_at' => '2026-07-27 06:31:45',
            ),
            180 => 
            array (
                'id' => 181,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Planning and Research Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-27 06:32:18',
                'updated_at' => '2026-07-27 06:32:18',
            ),
            181 => 
            array (
                'id' => 182,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-27 07:28:07',
                'updated_at' => '2026-07-27 07:28:07',
            ),
            182 => 
            array (
                'id' => 183,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-27 07:29:40',
                'updated_at' => '2026-07-27 07:29:40',
            ),
            183 => 
            array (
                'id' => 184,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-27 07:30:34',
                'updated_at' => '2026-07-27 07:30:34',
            ),
            184 => 
            array (
                'id' => 185,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-27 07:30:47',
                'updated_at' => '2026-07-27 07:30:47',
            ),
            185 => 
            array (
                'id' => 186,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-27 07:31:05',
                'updated_at' => '2026-07-27 07:31:05',
            ),
            186 => 
            array (
                'id' => 187,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-27 07:31:36',
                'updated_at' => '2026-07-27 07:31:36',
            ),
            187 => 
            array (
                'id' => 188,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-27 07:32:36',
                'updated_at' => '2026-07-27 07:32:36',
            ),
            188 => 
            array (
                'id' => 189,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-28 02:48:34',
                'updated_at' => '2026-07-28 02:48:34',
            ),
            189 => 
            array (
                'id' => 190,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 06:54:48',
                'updated_at' => '2026-07-28 06:54:48',
            ),
            190 => 
            array (
                'id' => 191,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 06:55:22',
                'updated_at' => '2026-07-28 06:55:22',
            ),
            191 => 
            array (
                'id' => 192,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 06:55:44',
                'updated_at' => '2026-07-28 06:55:44',
            ),
            192 => 
            array (
                'id' => 193,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 06:56:06',
                'updated_at' => '2026-07-28 06:56:06',
            ),
            193 => 
            array (
                'id' => 194,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 06:56:56',
                'updated_at' => '2026-07-28 06:56:56',
            ),
            194 => 
            array (
                'id' => 195,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 06:57:28',
                'updated_at' => '2026-07-28 06:57:28',
            ),
            195 => 
            array (
                'id' => 196,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 06:58:26',
                'updated_at' => '2026-07-28 06:58:26',
            ),
            196 => 
            array (
                'id' => 197,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 09:22:18',
                'updated_at' => '2026-07-28 09:22:18',
            ),
            197 => 
            array (
                'id' => 198,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 09:22:37',
                'updated_at' => '2026-07-28 09:22:37',
            ),
            198 => 
            array (
                'id' => 199,
                'user_name' => 'Admin User',
                'action' => 'Restored default footer & contact settings',
                'module' => 'settings',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-28 09:23:20',
                'updated_at' => '2026-07-28 09:23:20',
            ),
            199 => 
            array (
                'id' => 200,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 09:24:19',
                'updated_at' => '2026-07-28 09:24:19',
            ),
            200 => 
            array (
                'id' => 201,
                'user_name' => 'Admin User',
                'action' => 'Restored default footer & contact settings',
                'module' => 'settings',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-28 09:24:31',
                'updated_at' => '2026-07-28 09:24:31',
            ),
            201 => 
            array (
                'id' => 202,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 09:24:33',
                'updated_at' => '2026-07-28 09:24:33',
            ),
            202 => 
            array (
                'id' => 203,
                'user_name' => 'Admin User',
                'action' => 'Restored default footer & contact settings',
                'module' => 'settings',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-28 09:24:51',
                'updated_at' => '2026-07-28 09:24:51',
            ),
            203 => 
            array (
                'id' => 204,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 09:24:53',
                'updated_at' => '2026-07-28 09:24:53',
            ),
            204 => 
            array (
                'id' => 205,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 09:25:26',
                'updated_at' => '2026-07-28 09:25:26',
            ),
            205 => 
            array (
                'id' => 206,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-28 09:25:45',
                'updated_at' => '2026-07-28 09:25:45',
            ),
            206 => 
            array (
                'id' => 207,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:29:22',
                'updated_at' => '2026-07-30 02:29:22',
            ),
            207 => 
            array (
                'id' => 208,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of English Language\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-30 02:38:45',
                'updated_at' => '2026-07-30 02:38:45',
            ),
            208 => 
            array (
                'id' => 209,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:39:38',
                'updated_at' => '2026-07-30 02:39:38',
            ),
            209 => 
            array (
                'id' => 210,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:40:02',
                'updated_at' => '2026-07-30 02:40:02',
            ),
            210 => 
            array (
                'id' => 211,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:40:32',
                'updated_at' => '2026-07-30 02:40:32',
            ),
            211 => 
            array (
                'id' => 212,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:40:48',
                'updated_at' => '2026-07-30 02:40:48',
            ),
            212 => 
            array (
                'id' => 213,
                'user_name' => 'Admin User',
                'action' => 'Restored default footer & contact settings',
                'module' => 'settings',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-07-30 02:41:03',
                'updated_at' => '2026-07-30 02:41:03',
            ),
            213 => 
            array (
                'id' => 214,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:41:08',
                'updated_at' => '2026-07-30 02:41:08',
            ),
            214 => 
            array (
                'id' => 215,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:42:01',
                'updated_at' => '2026-07-30 02:42:01',
            ),
            215 => 
            array (
                'id' => 216,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:42:13',
                'updated_at' => '2026-07-30 02:42:13',
            ),
            216 => 
            array (
                'id' => 217,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:42:26',
                'updated_at' => '2026-07-30 02:42:26',
            ),
            217 => 
            array (
                'id' => 218,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-30 02:43:35',
                'updated_at' => '2026-07-30 02:43:35',
            ),
            218 => 
            array (
                'id' => 219,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-31 03:04:34',
                'updated_at' => '2026-07-31 03:04:34',
            ),
            219 => 
            array (
                'id' => 220,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-07-31 03:04:36',
                'updated_at' => '2026-07-31 03:04:36',
            ),
            220 => 
            array (
                'id' => 221,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 03:50:04',
                'updated_at' => '2026-07-31 03:50:04',
            ),
            221 => 
            array (
                'id' => 222,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 03:50:21',
                'updated_at' => '2026-07-31 03:50:21',
            ),
            222 => 
            array (
                'id' => 223,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 03:51:30',
                'updated_at' => '2026-07-31 03:51:30',
            ),
            223 => 
            array (
                'id' => 224,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 04:07:50',
                'updated_at' => '2026-07-31 04:07:50',
            ),
            224 => 
            array (
                'id' => 225,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 04:08:15',
                'updated_at' => '2026-07-31 04:08:15',
            ),
            225 => 
            array (
                'id' => 226,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 04:09:18',
                'updated_at' => '2026-07-31 04:09:18',
            ),
            226 => 
            array (
                'id' => 227,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 04:09:47',
                'updated_at' => '2026-07-31 04:09:47',
            ),
            227 => 
            array (
                'id' => 228,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 04:10:09',
                'updated_at' => '2026-07-31 04:10:09',
            ),
            228 => 
            array (
                'id' => 229,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 04:24:19',
                'updated_at' => '2026-07-31 04:24:19',
            ),
            229 => 
            array (
                'id' => 230,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-31 04:44:17',
                'updated_at' => '2026-07-31 04:44:17',
            ),
            230 => 
            array (
                'id' => 231,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-31 04:45:01',
                'updated_at' => '2026-07-31 04:45:01',
            ),
            231 => 
            array (
                'id' => 232,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-31 04:45:28',
                'updated_at' => '2026-07-31 04:45:28',
            ),
            232 => 
            array (
                'id' => 233,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-31 04:49:57',
                'updated_at' => '2026-07-31 04:49:57',
            ),
            233 => 
            array (
                'id' => 234,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-31 04:55:21',
                'updated_at' => '2026-07-31 04:55:21',
            ),
            234 => 
            array (
                'id' => 235,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-07-31 04:55:40',
                'updated_at' => '2026-07-31 04:55:40',
            ),
            235 => 
            array (
                'id' => 236,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-07-31 05:05:30',
                'updated_at' => '2026-07-31 05:05:30',
            ),
            236 => 
            array (
                'id' => 237,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:00:38',
                'updated_at' => '2026-08-03 07:00:38',
            ),
            237 => 
            array (
                'id' => 238,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 07:01:26',
                'updated_at' => '2026-08-03 07:01:26',
            ),
            238 => 
            array (
                'id' => 239,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:34:18',
                'updated_at' => '2026-08-03 07:34:18',
            ),
            239 => 
            array (
                'id' => 240,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:35:04',
                'updated_at' => '2026-08-03 07:35:04',
            ),
            240 => 
            array (
                'id' => 241,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of English Language\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:35:32',
                'updated_at' => '2026-08-03 07:35:32',
            ),
            241 => 
            array (
                'id' => 242,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Engineering and Architecture\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:35:49',
                'updated_at' => '2026-08-03 07:35:49',
            ),
            242 => 
            array (
                'id' => 243,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:36:06',
                'updated_at' => '2026-08-03 07:36:06',
            ),
            243 => 
            array (
                'id' => 244,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Law and Political Science\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:36:22',
                'updated_at' => '2026-08-03 07:36:22',
            ),
            244 => 
            array (
                'id' => 245,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Economic Sciences\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-03 07:36:36',
                'updated_at' => '2026-08-03 07:36:36',
            ),
            245 => 
            array (
                'id' => 246,
                'user_name' => 'Admin User',
                'action' => 'Registered new translation key \'Bachelor\'s Degree\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-08-03 07:40:41',
                'updated_at' => '2026-08-03 07:40:41',
            ),
            246 => 
            array (
                'id' => 247,
                'user_name' => 'Admin User',
                'action' => 'Registered new translation key \'Associate\'s Degree\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-08-03 07:42:22',
                'updated_at' => '2026-08-03 07:42:22',
            ),
            247 => 
            array (
                'id' => 248,
                'user_name' => 'Admin User',
                'action' => 'Updated translation key \'Bachelor\'s Degree\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-08-03 07:43:35',
                'updated_at' => '2026-08-03 07:43:35',
            ),
            248 => 
            array (
                'id' => 249,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 07:46:59',
                'updated_at' => '2026-08-03 07:46:59',
            ),
            249 => 
            array (
                'id' => 250,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 07:49:52',
                'updated_at' => '2026-08-03 07:49:52',
            ),
            250 => 
            array (
                'id' => 251,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 07:51:23',
                'updated_at' => '2026-08-03 07:51:23',
            ),
            251 => 
            array (
                'id' => 252,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 07:53:56',
                'updated_at' => '2026-08-03 07:53:56',
            ),
            252 => 
            array (
                'id' => 253,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 07:58:36',
                'updated_at' => '2026-08-03 07:58:36',
            ),
            253 => 
            array (
                'id' => 254,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:00:29',
                'updated_at' => '2026-08-03 08:00:29',
            ),
            254 => 
            array (
                'id' => 255,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'DUC Convocation Ceremony 2024\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:01:31',
                'updated_at' => '2026-08-03 08:01:31',
            ),
            255 => 
            array (
                'id' => 256,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Cybersecurity Awareness seminar\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:01:39',
                'updated_at' => '2026-08-03 08:01:39',
            ),
            256 => 
            array (
                'id' => 257,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'IT Department Hackathon competition\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:01:47',
                'updated_at' => '2026-08-03 08:01:47',
            ),
            257 => 
            array (
                'id' => 258,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Admission Scholarship Program open\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:01:58',
                'updated_at' => '2026-08-03 08:01:58',
            ),
            258 => 
            array (
                'id' => 259,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Fintech and Blockchain Conference\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:02:06',
                'updated_at' => '2026-08-03 08:02:06',
            ),
            259 => 
            array (
                'id' => 260,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'DUC Campus Orientation 2024\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:02:22',
                'updated_at' => '2026-08-03 08:02:22',
            ),
            260 => 
            array (
                'id' => 261,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Admission Scholarship Program open\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:02:58',
                'updated_at' => '2026-08-03 08:02:58',
            ),
            261 => 
            array (
                'id' => 262,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Fintech and Blockchain Conference\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:03:10',
                'updated_at' => '2026-08-03 08:03:10',
            ),
            262 => 
            array (
                'id' => 263,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:03:33',
                'updated_at' => '2026-08-03 08:03:33',
            ),
            263 => 
            array (
                'id' => 264,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'DUC Convocation Ceremony 2024\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:05:01',
                'updated_at' => '2026-08-03 08:05:01',
            ),
            264 => 
            array (
                'id' => 265,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Cybersecurity Awareness seminar\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:05:58',
                'updated_at' => '2026-08-03 08:05:58',
            ),
            265 => 
            array (
                'id' => 266,
                'user_name' => 'Admin User',
                'action' => 'Registered new translation key \'Event Detail\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-08-03 08:07:53',
                'updated_at' => '2026-08-03 08:07:53',
            ),
            266 => 
            array (
                'id' => 267,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Fintech and Blockchain Conference\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:09:05',
                'updated_at' => '2026-08-03 08:09:05',
            ),
            267 => 
            array (
                'id' => 268,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'IT Department Hackathon competition\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:10:29',
                'updated_at' => '2026-08-03 08:10:29',
            ),
            268 => 
            array (
                'id' => 269,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'Admission Scholarship Program open\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:13:52',
                'updated_at' => '2026-08-03 08:13:52',
            ),
            269 => 
            array (
                'id' => 270,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'DUC Campus Orientation 2024\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:14:58',
                'updated_at' => '2026-08-03 08:14:58',
            ),
            270 => 
            array (
                'id' => 271,
                'user_name' => 'Admin User',
                'action' => 'Updated event article \'DUC Convocation Ceremony 2024\'',
                'module' => 'events',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-03 08:15:30',
                'updated_at' => '2026-08-03 08:15:30',
            ),
            271 => 
            array (
                'id' => 272,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:18:33',
                'updated_at' => '2026-08-03 08:18:33',
            ),
            272 => 
            array (
                'id' => 273,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:19:22',
                'updated_at' => '2026-08-03 08:19:22',
            ),
            273 => 
            array (
                'id' => 274,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:21:24',
                'updated_at' => '2026-08-03 08:21:24',
            ),
            274 => 
            array (
                'id' => 275,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:22:37',
                'updated_at' => '2026-08-03 08:22:37',
            ),
            275 => 
            array (
                'id' => 276,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:24:08',
                'updated_at' => '2026-08-03 08:24:08',
            ),
            276 => 
            array (
                'id' => 277,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:24:18',
                'updated_at' => '2026-08-03 08:24:18',
            ),
            277 => 
            array (
                'id' => 278,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:31:16',
                'updated_at' => '2026-08-03 08:31:16',
            ),
            278 => 
            array (
                'id' => 279,
                'user_name' => 'Admin User',
                'action' => 'Updated landing page builder settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:31:57',
                'updated_at' => '2026-08-03 08:31:57',
            ),
            279 => 
            array (
                'id' => 280,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:33:35',
                'updated_at' => '2026-08-03 08:33:35',
            ),
            280 => 
            array (
                'id' => 281,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:34:37',
                'updated_at' => '2026-08-03 08:34:37',
            ),
            281 => 
            array (
                'id' => 282,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Dormitory Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:37:01',
                'updated_at' => '2026-08-03 08:37:01',
            ),
            282 => 
            array (
                'id' => 283,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Dormitory Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:47:53',
                'updated_at' => '2026-08-03 08:47:53',
            ),
            283 => 
            array (
                'id' => 284,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Academic Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:48:12',
                'updated_at' => '2026-08-03 08:48:12',
            ),
            284 => 
            array (
                'id' => 285,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Student Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:48:18',
                'updated_at' => '2026-08-03 08:48:18',
            ),
            285 => 
            array (
                'id' => 286,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:48:24',
                'updated_at' => '2026-08-03 08:48:24',
            ),
            286 => 
            array (
                'id' => 287,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Administration and Accounting Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:48:30',
                'updated_at' => '2026-08-03 08:48:30',
            ),
            287 => 
            array (
                'id' => 288,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Dormitory Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:48:39',
                'updated_at' => '2026-08-03 08:48:39',
            ),
            288 => 
            array (
                'id' => 289,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Planning and Research Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:48:58',
                'updated_at' => '2026-08-03 08:48:58',
            ),
            289 => 
            array (
                'id' => 290,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Internal Quality Assurance Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:49:05',
                'updated_at' => '2026-08-03 08:49:05',
            ),
            290 => 
            array (
                'id' => 291,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-03 08:49:17',
                'updated_at' => '2026-08-03 08:49:17',
            ),
            291 => 
            array (
                'id' => 292,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-03 08:50:04',
                'updated_at' => '2026-08-03 08:50:04',
            ),
            292 => 
            array (
                'id' => 293,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 03:38:47',
                'updated_at' => '2026-08-20 03:38:47',
            ),
            293 => 
            array (
                'id' => 294,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 03:54:53',
                'updated_at' => '2026-08-20 03:54:53',
            ),
            294 => 
            array (
                'id' => 295,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 03:55:14',
                'updated_at' => '2026-08-20 03:55:14',
            ),
            295 => 
            array (
                'id' => 296,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 03:56:10',
                'updated_at' => '2026-08-20 03:56:10',
            ),
            296 => 
            array (
                'id' => 297,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 04:07:59',
                'updated_at' => '2026-08-20 04:07:59',
            ),
            297 => 
            array (
                'id' => 298,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 04:08:42',
                'updated_at' => '2026-08-20 04:08:42',
            ),
            298 => 
            array (
                'id' => 299,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-20 04:11:36',
            ),
            299 => 
            array (
                'id' => 300,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 04:12:57',
                'updated_at' => '2026-08-20 04:12:57',
            ),
            300 => 
            array (
                'id' => 301,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 04:15:46',
                'updated_at' => '2026-08-20 04:15:46',
            ),
            301 => 
            array (
                'id' => 302,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 04:17:10',
                'updated_at' => '2026-08-20 04:17:10',
            ),
            302 => 
            array (
                'id' => 303,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 06:08:09',
                'updated_at' => '2026-08-20 06:08:09',
            ),
            303 => 
            array (
                'id' => 304,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 06:11:29',
                'updated_at' => '2026-08-20 06:11:29',
            ),
            304 => 
            array (
                'id' => 305,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 06:12:08',
                'updated_at' => '2026-08-20 06:12:08',
            ),
            305 => 
            array (
                'id' => 306,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 06:24:11',
                'updated_at' => '2026-08-20 06:24:11',
            ),
            306 => 
            array (
                'id' => 307,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 06:26:26',
                'updated_at' => '2026-08-20 06:26:26',
            ),
            307 => 
            array (
                'id' => 308,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 07:07:42',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            308 => 
            array (
                'id' => 309,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 07:11:10',
                'updated_at' => '2026-08-20 07:11:10',
            ),
            309 => 
            array (
                'id' => 310,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 07:20:09',
                'updated_at' => '2026-08-20 07:20:09',
            ),
            310 => 
            array (
                'id' => 311,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 07:52:03',
                'updated_at' => '2026-08-20 07:52:03',
            ),
            311 => 
            array (
                'id' => 312,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 07:52:45',
                'updated_at' => '2026-08-20 07:52:45',
            ),
            312 => 
            array (
                'id' => 313,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 07:54:27',
                'updated_at' => '2026-08-20 07:54:27',
            ),
            313 => 
            array (
                'id' => 314,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 08:26:56',
                'updated_at' => '2026-08-20 08:26:56',
            ),
            314 => 
            array (
                'id' => 315,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 08:33:19',
                'updated_at' => '2026-08-20 08:33:19',
            ),
            315 => 
            array (
                'id' => 316,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 08:38:15',
                'updated_at' => '2026-08-20 08:38:15',
            ),
            316 => 
            array (
                'id' => 317,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 08:47:21',
                'updated_at' => '2026-08-20 08:47:21',
            ),
            317 => 
            array (
                'id' => 318,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 08:48:27',
                'updated_at' => '2026-08-20 08:48:27',
            ),
            318 => 
            array (
                'id' => 319,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 08:57:41',
                'updated_at' => '2026-08-20 08:57:41',
            ),
            319 => 
            array (
                'id' => 320,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:11:26',
                'updated_at' => '2026-08-20 09:11:26',
            ),
            320 => 
            array (
                'id' => 321,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:12:15',
                'updated_at' => '2026-08-20 09:12:15',
            ),
            321 => 
            array (
                'id' => 322,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:12:36',
                'updated_at' => '2026-08-20 09:12:36',
            ),
            322 => 
            array (
                'id' => 323,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:13:42',
                'updated_at' => '2026-08-20 09:13:42',
            ),
            323 => 
            array (
                'id' => 324,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:15:11',
                'updated_at' => '2026-08-20 09:15:11',
            ),
            324 => 
            array (
                'id' => 325,
                'user_name' => 'Admin User',
                'action' => 'Registered new translation key \'School Action Videos\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-08-20 09:16:37',
                'updated_at' => '2026-08-20 09:16:37',
            ),
            325 => 
            array (
                'id' => 326,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:24:21',
                'updated_at' => '2026-08-20 09:24:21',
            ),
            326 => 
            array (
                'id' => 327,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:35:30',
                'updated_at' => '2026-08-20 09:35:30',
            ),
            327 => 
            array (
                'id' => 328,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:37:12',
                'updated_at' => '2026-08-20 09:37:12',
            ),
            328 => 
            array (
                'id' => 329,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:38:02',
                'updated_at' => '2026-08-20 09:38:02',
            ),
            329 => 
            array (
                'id' => 330,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:39:19',
                'updated_at' => '2026-08-20 09:39:19',
            ),
            330 => 
            array (
                'id' => 331,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:41:07',
                'updated_at' => '2026-08-20 09:41:07',
            ),
            331 => 
            array (
                'id' => 332,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:41:28',
                'updated_at' => '2026-08-20 09:41:28',
            ),
            332 => 
            array (
                'id' => 333,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:43:33',
                'updated_at' => '2026-08-20 09:43:33',
            ),
            333 => 
            array (
                'id' => 334,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:48:21',
                'updated_at' => '2026-08-20 09:48:21',
            ),
            334 => 
            array (
                'id' => 335,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:48:38',
                'updated_at' => '2026-08-20 09:48:38',
            ),
            335 => 
            array (
                'id' => 336,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:49:53',
                'updated_at' => '2026-08-20 09:49:53',
            ),
            336 => 
            array (
                'id' => 337,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:54:36',
                'updated_at' => '2026-08-20 09:54:36',
            ),
            337 => 
            array (
                'id' => 338,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:56:38',
                'updated_at' => '2026-08-20 09:56:38',
            ),
            338 => 
            array (
                'id' => 339,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:56:58',
                'updated_at' => '2026-08-20 09:56:58',
            ),
            339 => 
            array (
                'id' => 340,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 09:58:18',
                'updated_at' => '2026-08-20 09:58:18',
            ),
            340 => 
            array (
                'id' => 341,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-20 10:01:26',
                'updated_at' => '2026-08-20 10:01:26',
            ),
            341 => 
            array (
                'id' => 342,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 01:13:46',
                'updated_at' => '2026-08-21 01:13:46',
            ),
            342 => 
            array (
                'id' => 343,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 01:15:17',
                'updated_at' => '2026-08-21 01:15:17',
            ),
            343 => 
            array (
                'id' => 344,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 01:18:39',
                'updated_at' => '2026-08-21 01:18:39',
            ),
            344 => 
            array (
                'id' => 345,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 01:19:46',
                'updated_at' => '2026-08-21 01:19:46',
            ),
            345 => 
            array (
                'id' => 346,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:11:39',
                'updated_at' => '2026-08-21 03:11:39',
            ),
            346 => 
            array (
                'id' => 347,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:12:23',
                'updated_at' => '2026-08-21 03:12:23',
            ),
            347 => 
            array (
                'id' => 348,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:17:22',
                'updated_at' => '2026-08-21 03:17:22',
            ),
            348 => 
            array (
                'id' => 349,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:18:03',
                'updated_at' => '2026-08-21 03:18:03',
            ),
            349 => 
            array (
                'id' => 350,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:18:43',
                'updated_at' => '2026-08-21 03:18:43',
            ),
            350 => 
            array (
                'id' => 351,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:18:59',
                'updated_at' => '2026-08-21 03:18:59',
            ),
            351 => 
            array (
                'id' => 352,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:19:28',
                'updated_at' => '2026-08-21 03:19:28',
            ),
            352 => 
            array (
                'id' => 353,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:24:29',
                'updated_at' => '2026-08-21 03:24:29',
            ),
            353 => 
            array (
                'id' => 354,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:24:45',
                'updated_at' => '2026-08-21 03:24:45',
            ),
            354 => 
            array (
                'id' => 355,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:37:04',
                'updated_at' => '2026-08-21 03:37:04',
            ),
            355 => 
            array (
                'id' => 356,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:38:24',
                'updated_at' => '2026-08-21 03:38:24',
            ),
            356 => 
            array (
                'id' => 357,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:38:45',
                'updated_at' => '2026-08-21 03:38:45',
            ),
            357 => 
            array (
                'id' => 358,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:38:47',
                'updated_at' => '2026-08-21 03:38:47',
            ),
            358 => 
            array (
                'id' => 359,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 03:38:48',
                'updated_at' => '2026-08-21 03:38:48',
            ),
            359 => 
            array (
                'id' => 360,
                'user_name' => 'Admin User',
                'action' => 'Registered new translation key \'Attached documents for scholarship application\'',
                'module' => 'translations',
                'icon_class' => 'bg-purple-500/10 text-purple-500',
                'created_at' => '2026-08-21 04:00:47',
                'updated_at' => '2026-08-21 04:00:47',
            ),
            360 => 
            array (
                'id' => 361,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 04:26:59',
                'updated_at' => '2026-08-21 04:26:59',
            ),
            361 => 
            array (
                'id' => 362,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 04:27:12',
                'updated_at' => '2026-08-21 04:27:12',
            ),
            362 => 
            array (
                'id' => 363,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 06:20:10',
                'updated_at' => '2026-08-21 06:20:10',
            ),
            363 => 
            array (
                'id' => 364,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 06:27:44',
                'updated_at' => '2026-08-21 06:27:44',
            ),
            364 => 
            array (
                'id' => 365,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 06:28:44',
                'updated_at' => '2026-08-21 06:28:44',
            ),
            365 => 
            array (
                'id' => 366,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 06:32:21',
                'updated_at' => '2026-08-21 06:32:21',
            ),
            366 => 
            array (
                'id' => 367,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 06:33:07',
                'updated_at' => '2026-08-21 06:33:07',
            ),
            367 => 
            array (
                'id' => 368,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 06:33:23',
                'updated_at' => '2026-08-21 06:33:23',
            ),
            368 => 
            array (
                'id' => 369,
                'user_name' => 'Admin User',
                'action' => 'Created new faculty \'Foundation Year Department\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 06:38:52',
                'updated_at' => '2026-08-21 06:38:52',
            ),
            369 => 
            array (
                'id' => 370,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Foundation Year Department\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-21 06:40:52',
                'updated_at' => '2026-08-21 06:40:52',
            ),
            370 => 
            array (
                'id' => 371,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Personnel and Human Resources Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-21 07:16:41',
                'updated_at' => '2026-08-21 07:16:41',
            ),
            371 => 
            array (
                'id' => 372,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Student Affairs Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-21 07:16:45',
                'updated_at' => '2026-08-21 07:16:45',
            ),
            372 => 
            array (
                'id' => 373,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Academic Affairs Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-21 07:16:47',
                'updated_at' => '2026-08-21 07:16:47',
            ),
            373 => 
            array (
                'id' => 374,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Administration and Accounting Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-21 07:16:49',
                'updated_at' => '2026-08-21 07:16:49',
            ),
            374 => 
            array (
                'id' => 375,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Dormitory Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-21 07:16:52',
                'updated_at' => '2026-08-21 07:16:52',
            ),
            375 => 
            array (
                'id' => 376,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Internal Quality Assurance Office\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-21 07:16:55',
                'updated_at' => '2026-08-21 07:16:55',
            ),
            376 => 
            array (
                'id' => 377,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Offices\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-21 07:16:58',
                'updated_at' => '2026-08-21 07:16:58',
            ),
            377 => 
            array (
                'id' => 378,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Building\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-21 07:25:38',
                'updated_at' => '2026-08-21 07:25:38',
            ),
            378 => 
            array (
                'id' => 379,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sub-Decree on University Establishment\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-21 07:26:30',
                'updated_at' => '2026-08-21 07:26:30',
            ),
            379 => 
            array (
                'id' => 380,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Degree Certificate\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-21 07:26:46',
                'updated_at' => '2026-08-21 07:26:46',
            ),
            380 => 
            array (
                'id' => 381,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Graduation Gown\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-21 07:26:58',
                'updated_at' => '2026-08-21 07:26:58',
            ),
            381 => 
            array (
                'id' => 382,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Student Uniform\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-21 07:27:14',
                'updated_at' => '2026-08-21 07:27:14',
            ),
            382 => 
            array (
                'id' => 383,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-21 07:53:59',
                'updated_at' => '2026-08-21 07:53:59',
            ),
            383 => 
            array (
                'id' => 384,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 08:44:29',
                'updated_at' => '2026-08-21 08:44:29',
            ),
            384 => 
            array (
                'id' => 385,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 08:45:29',
                'updated_at' => '2026-08-21 08:45:29',
            ),
            385 => 
            array (
                'id' => 386,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-21 08:46:59',
                'updated_at' => '2026-08-21 08:46:59',
            ),
            386 => 
            array (
                'id' => 387,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 08:50:15',
                'updated_at' => '2026-08-21 08:50:15',
            ),
            387 => 
            array (
                'id' => 388,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 08:53:20',
                'updated_at' => '2026-08-21 08:53:20',
            ),
            388 => 
            array (
                'id' => 389,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 08:57:08',
                'updated_at' => '2026-08-21 08:57:08',
            ),
            389 => 
            array (
                'id' => 390,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 08:57:31',
                'updated_at' => '2026-08-21 08:57:31',
            ),
            390 => 
            array (
                'id' => 391,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 08:58:09',
                'updated_at' => '2026-08-21 08:58:09',
            ),
            391 => 
            array (
                'id' => 392,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:00:50',
                'updated_at' => '2026-08-21 09:00:50',
            ),
            392 => 
            array (
                'id' => 393,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Specific Purposes\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:01:46',
                'updated_at' => '2026-08-21 09:01:46',
            ),
            393 => 
            array (
                'id' => 394,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:02:19',
                'updated_at' => '2026-08-21 09:02:19',
            ),
            394 => 
            array (
                'id' => 395,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:02:44',
                'updated_at' => '2026-08-21 09:02:44',
            ),
            395 => 
            array (
                'id' => 396,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:03:31',
                'updated_at' => '2026-08-21 09:03:31',
            ),
            396 => 
            array (
                'id' => 397,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Architecture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:04:00',
                'updated_at' => '2026-08-21 09:04:00',
            ),
            397 => 
            array (
                'id' => 398,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Interior Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:04:21',
                'updated_at' => '2026-08-21 09:04:21',
            ),
            398 => 
            array (
                'id' => 399,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agronomy and Horticulture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:04:45',
                'updated_at' => '2026-08-21 09:04:45',
            ),
            399 => 
            array (
                'id' => 400,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agricultural Economics\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:05:18',
                'updated_at' => '2026-08-21 09:05:18',
            ),
            400 => 
            array (
                'id' => 401,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agricultural Economics\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:05:29',
                'updated_at' => '2026-08-21 09:05:29',
            ),
            401 => 
            array (
                'id' => 402,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Rural Development\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:05:59',
                'updated_at' => '2026-08-21 09:05:59',
            ),
            402 => 
            array (
                'id' => 403,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:06:57',
                'updated_at' => '2026-08-21 09:06:57',
            ),
            403 => 
            array (
                'id' => 404,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Administration\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:07:28',
                'updated_at' => '2026-08-21 09:07:28',
            ),
            404 => 
            array (
                'id' => 405,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Science\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:07:53',
                'updated_at' => '2026-08-21 09:07:53',
            ),
            405 => 
            array (
                'id' => 406,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Economy\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:09:59',
                'updated_at' => '2026-08-21 09:09:59',
            ),
            406 => 
            array (
                'id' => 407,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-21 09:13:42',
                'updated_at' => '2026-08-21 09:13:42',
            ),
            407 => 
            array (
                'id' => 408,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 09:18:46',
                'updated_at' => '2026-08-21 09:18:46',
            ),
            408 => 
            array (
                'id' => 409,
                'user_name' => 'Admin User',
                'action' => 'Updated Scholarship settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-21 09:19:15',
                'updated_at' => '2026-08-21 09:19:15',
            ),
            409 => 
            array (
                'id' => 410,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 05:27:52',
                'updated_at' => '2026-08-22 05:27:52',
            ),
            410 => 
            array (
                'id' => 411,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Building\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 05:39:52',
                'updated_at' => '2026-08-22 05:39:52',
            ),
            411 => 
            array (
                'id' => 412,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 05:58:08',
                'updated_at' => '2026-08-22 05:58:08',
            ),
            412 => 
            array (
                'id' => 413,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Science\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 06:16:34',
                'updated_at' => '2026-08-22 06:16:34',
            ),
            413 => 
            array (
                'id' => 414,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Science\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 06:17:37',
                'updated_at' => '2026-08-22 06:17:37',
            ),
            414 => 
            array (
                'id' => 415,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Economy\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 06:33:16',
                'updated_at' => '2026-08-22 06:33:16',
            ),
            415 => 
            array (
                'id' => 416,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of E-Commerce\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 06:33:32',
                'updated_at' => '2026-08-22 06:33:32',
            ),
            416 => 
            array (
                'id' => 417,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:00:50',
                'updated_at' => '2026-08-22 07:00:50',
            ),
            417 => 
            array (
                'id' => 418,
                'user_name' => 'Admin User',
                'action' => 'Deleted page \'Internal Quality Assurance Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-22 07:24:00',
                'updated_at' => '2026-08-22 07:24:00',
            ),
            418 => 
            array (
                'id' => 419,
                'user_name' => 'Admin User',
                'action' => 'Deleted page \'Planning and Research Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-22 07:24:05',
                'updated_at' => '2026-08-22 07:24:05',
            ),
            419 => 
            array (
                'id' => 420,
                'user_name' => 'Admin User',
                'action' => 'Deleted page \'Administration and Accounting Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-22 07:24:11',
                'updated_at' => '2026-08-22 07:24:11',
            ),
            420 => 
            array (
                'id' => 421,
                'user_name' => 'Admin User',
                'action' => 'Deleted page \'Personnel and Human Resources Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-22 07:24:16',
                'updated_at' => '2026-08-22 07:24:16',
            ),
            421 => 
            array (
                'id' => 422,
                'user_name' => 'Admin User',
                'action' => 'Deleted page \'Student Affairs Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-22 07:24:26',
                'updated_at' => '2026-08-22 07:24:26',
            ),
            422 => 
            array (
                'id' => 423,
                'user_name' => 'Admin User',
                'action' => 'Deleted page \'Dormitory Office\'',
                'module' => 'pages',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-22 07:24:30',
                'updated_at' => '2026-08-22 07:24:30',
            ),
            423 => 
            array (
                'id' => 424,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:40:58',
                'updated_at' => '2026-08-22 07:40:58',
            ),
            424 => 
            array (
                'id' => 425,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:41:15',
                'updated_at' => '2026-08-22 07:41:15',
            ),
            425 => 
            array (
                'id' => 426,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Degree Certificate\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:47:18',
                'updated_at' => '2026-08-22 07:47:18',
            ),
            426 => 
            array (
                'id' => 427,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Degree Certificate\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:47:41',
                'updated_at' => '2026-08-22 07:47:41',
            ),
            427 => 
            array (
                'id' => 428,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Degree Certificate\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:48:53',
                'updated_at' => '2026-08-22 07:48:53',
            ),
            428 => 
            array (
                'id' => 429,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Student Uniform\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:52:06',
                'updated_at' => '2026-08-22 07:52:06',
            ),
            429 => 
            array (
                'id' => 430,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Graduation Gown\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:53:54',
                'updated_at' => '2026-08-22 07:53:54',
            ),
            430 => 
            array (
                'id' => 431,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Graduation Gown\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:54:29',
                'updated_at' => '2026-08-22 07:54:29',
            ),
            431 => 
            array (
                'id' => 432,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Degree Certificate\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:55:18',
                'updated_at' => '2026-08-22 07:55:18',
            ),
            432 => 
            array (
                'id' => 433,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sub-Decree\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:56:26',
                'updated_at' => '2026-08-22 07:56:26',
            ),
            433 => 
            array (
                'id' => 434,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 07:56:56',
                'updated_at' => '2026-08-22 07:56:56',
            ),
            434 => 
            array (
                'id' => 435,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 08:01:44',
                'updated_at' => '2026-08-22 08:01:44',
            ),
            435 => 
            array (
                'id' => 436,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 08:04:07',
                'updated_at' => '2026-08-22 08:04:07',
            ),
            436 => 
            array (
                'id' => 437,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Library\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 08:04:29',
                'updated_at' => '2026-08-22 08:04:29',
            ),
            437 => 
            array (
                'id' => 438,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:05:35',
                'updated_at' => '2026-08-22 08:05:35',
            ),
            438 => 
            array (
                'id' => 439,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:19:45',
                'updated_at' => '2026-08-22 08:19:45',
            ),
            439 => 
            array (
                'id' => 440,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:20:26',
                'updated_at' => '2026-08-22 08:20:26',
            ),
            440 => 
            array (
                'id' => 441,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:21:22',
                'updated_at' => '2026-08-22 08:21:22',
            ),
            441 => 
            array (
                'id' => 442,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:21:54',
                'updated_at' => '2026-08-22 08:21:54',
            ),
            442 => 
            array (
                'id' => 443,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:22:02',
                'updated_at' => '2026-08-22 08:22:02',
            ),
            443 => 
            array (
                'id' => 444,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:22:32',
                'updated_at' => '2026-08-22 08:22:32',
            ),
            444 => 
            array (
                'id' => 445,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:42:23',
                'updated_at' => '2026-08-22 08:42:23',
            ),
            445 => 
            array (
                'id' => 446,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:46:32',
                'updated_at' => '2026-08-22 08:46:32',
            ),
            446 => 
            array (
                'id' => 447,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:47:01',
                'updated_at' => '2026-08-22 08:47:01',
            ),
            447 => 
            array (
                'id' => 448,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:51:59',
                'updated_at' => '2026-08-22 08:51:59',
            ),
            448 => 
            array (
                'id' => 449,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:54:33',
                'updated_at' => '2026-08-22 08:54:33',
            ),
            449 => 
            array (
                'id' => 450,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:54:55',
                'updated_at' => '2026-08-22 08:54:55',
            ),
            450 => 
            array (
                'id' => 451,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 08:55:17',
                'updated_at' => '2026-08-22 08:55:17',
            ),
            451 => 
            array (
                'id' => 452,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:17:49',
                'updated_at' => '2026-08-22 09:17:49',
            ),
            452 => 
            array (
                'id' => 453,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:18:23',
                'updated_at' => '2026-08-22 09:18:23',
            ),
            453 => 
            array (
                'id' => 454,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:18:42',
                'updated_at' => '2026-08-22 09:18:42',
            ),
            454 => 
            array (
                'id' => 455,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:27:29',
                'updated_at' => '2026-08-22 09:27:29',
            ),
            455 => 
            array (
                'id' => 456,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:27:45',
                'updated_at' => '2026-08-22 09:27:45',
            ),
            456 => 
            array (
                'id' => 457,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:28:22',
                'updated_at' => '2026-08-22 09:28:22',
            ),
            457 => 
            array (
                'id' => 458,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:29:54',
                'updated_at' => '2026-08-22 09:29:54',
            ),
            458 => 
            array (
                'id' => 459,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:31:18',
                'updated_at' => '2026-08-22 09:31:18',
            ),
            459 => 
            array (
                'id' => 460,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:31:50',
                'updated_at' => '2026-08-22 09:31:50',
            ),
            460 => 
            array (
                'id' => 461,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:34:09',
                'updated_at' => '2026-08-22 09:34:09',
            ),
            461 => 
            array (
                'id' => 462,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:34:25',
                'updated_at' => '2026-08-22 09:34:25',
            ),
            462 => 
            array (
                'id' => 463,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:35:28',
                'updated_at' => '2026-08-22 09:35:28',
            ),
            463 => 
            array (
                'id' => 464,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:35:53',
                'updated_at' => '2026-08-22 09:35:53',
            ),
            464 => 
            array (
                'id' => 465,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:36:20',
                'updated_at' => '2026-08-22 09:36:20',
            ),
            465 => 
            array (
                'id' => 466,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:37:24',
                'updated_at' => '2026-08-22 09:37:24',
            ),
            466 => 
            array (
                'id' => 467,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:38:04',
                'updated_at' => '2026-08-22 09:38:04',
            ),
            467 => 
            array (
                'id' => 468,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:39:04',
                'updated_at' => '2026-08-22 09:39:04',
            ),
            468 => 
            array (
                'id' => 469,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:39:38',
                'updated_at' => '2026-08-22 09:39:38',
            ),
            469 => 
            array (
                'id' => 470,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 09:42:00',
                'updated_at' => '2026-08-22 09:42:00',
            ),
            470 => 
            array (
                'id' => 471,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 11:57:21',
                'updated_at' => '2026-08-22 11:57:21',
            ),
            471 => 
            array (
                'id' => 472,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 12:09:20',
                'updated_at' => '2026-08-22 12:09:20',
            ),
            472 => 
            array (
                'id' => 473,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:14:55',
                'updated_at' => '2026-08-22 12:14:55',
            ),
            473 => 
            array (
                'id' => 474,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:19:45',
                'updated_at' => '2026-08-22 12:19:45',
            ),
            474 => 
            array (
                'id' => 475,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:19:48',
                'updated_at' => '2026-08-22 12:19:48',
            ),
            475 => 
            array (
                'id' => 476,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:19:51',
                'updated_at' => '2026-08-22 12:19:51',
            ),
            476 => 
            array (
                'id' => 477,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:19:54',
                'updated_at' => '2026-08-22 12:19:54',
            ),
            477 => 
            array (
                'id' => 478,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:20:03',
                'updated_at' => '2026-08-22 12:20:03',
            ),
            478 => 
            array (
                'id' => 479,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:20:06',
                'updated_at' => '2026-08-22 12:20:06',
            ),
            479 => 
            array (
                'id' => 480,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:20:13',
                'updated_at' => '2026-08-22 12:20:13',
            ),
            480 => 
            array (
                'id' => 481,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:20:34',
                'updated_at' => '2026-08-22 12:20:34',
            ),
            481 => 
            array (
                'id' => 482,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:26:41',
                'updated_at' => '2026-08-22 12:26:41',
            ),
            482 => 
            array (
                'id' => 483,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:30:44',
                'updated_at' => '2026-08-22 12:30:44',
            ),
            483 => 
            array (
                'id' => 484,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:30:50',
                'updated_at' => '2026-08-22 12:30:50',
            ),
            484 => 
            array (
                'id' => 485,
                'user_name' => 'Admin User',
                'action' => 'Reordered faculties list',
                'module' => 'faculties',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-22 12:31:04',
                'updated_at' => '2026-08-22 12:31:04',
            ),
            485 => 
            array (
                'id' => 486,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:31:09',
                'updated_at' => '2026-08-22 12:31:09',
            ),
            486 => 
            array (
                'id' => 487,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:32:39',
                'updated_at' => '2026-08-22 12:32:39',
            ),
            487 => 
            array (
                'id' => 488,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:33:34',
                'updated_at' => '2026-08-22 12:33:34',
            ),
            488 => 
            array (
                'id' => 489,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sub-Decree\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:34:12',
                'updated_at' => '2026-08-22 12:34:12',
            ),
            489 => 
            array (
                'id' => 490,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:34:22',
                'updated_at' => '2026-08-22 12:34:22',
            ),
            490 => 
            array (
                'id' => 491,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:34:38',
                'updated_at' => '2026-08-22 12:34:38',
            ),
            491 => 
            array (
                'id' => 492,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Exam and Evaluation\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:34:56',
                'updated_at' => '2026-08-22 12:34:56',
            ),
            492 => 
            array (
                'id' => 493,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:39:36',
                'updated_at' => '2026-08-22 12:39:36',
            ),
            493 => 
            array (
                'id' => 494,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:39:56',
                'updated_at' => '2026-08-22 12:39:56',
            ),
            494 => 
            array (
                'id' => 495,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:45:55',
                'updated_at' => '2026-08-22 12:45:55',
            ),
            495 => 
            array (
                'id' => 496,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:46:15',
                'updated_at' => '2026-08-22 12:46:15',
            ),
            496 => 
            array (
                'id' => 497,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:46:35',
                'updated_at' => '2026-08-22 12:46:35',
            ),
            497 => 
            array (
                'id' => 498,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'About Us\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:46:48',
                'updated_at' => '2026-08-22 12:46:48',
            ),
            498 => 
            array (
                'id' => 499,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Exam and Evaluation\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:47:03',
                'updated_at' => '2026-08-22 12:47:03',
            ),
            499 => 
            array (
                'id' => 500,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Exam and Evaluation\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:47:12',
                'updated_at' => '2026-08-22 12:47:12',
            ),
        ));
        \DB::table('activity_logs')->insert(array (
            0 => 
            array (
                'id' => 501,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Messageeee\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:47:36',
                'updated_at' => '2026-08-22 12:47:36',
            ),
            1 => 
            array (
                'id' => 502,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-22 12:47:49',
                'updated_at' => '2026-08-22 12:47:49',
            ),
            2 => 
            array (
                'id' => 503,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 13:04:27',
                'updated_at' => '2026-08-22 13:04:27',
            ),
            3 => 
            array (
                'id' => 504,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of English Language\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 13:05:30',
                'updated_at' => '2026-08-22 13:05:30',
            ),
            4 => 
            array (
                'id' => 505,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Engineering and Architecture\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 13:05:51',
                'updated_at' => '2026-08-22 13:05:51',
            ),
            5 => 
            array (
                'id' => 506,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Agriculture and Rural Development\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 13:06:14',
                'updated_at' => '2026-08-22 13:06:14',
            ),
            6 => 
            array (
                'id' => 507,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Law and Political Science\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 13:06:39',
                'updated_at' => '2026-08-22 13:06:39',
            ),
            7 => 
            array (
                'id' => 508,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Economic Sciences\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 13:07:03',
                'updated_at' => '2026-08-22 13:07:03',
            ),
            8 => 
            array (
                'id' => 509,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 13:57:59',
                'updated_at' => '2026-08-22 13:57:59',
            ),
            9 => 
            array (
                'id' => 510,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 13:58:24',
                'updated_at' => '2026-08-22 13:58:24',
            ),
            10 => 
            array (
                'id' => 511,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 13:58:48',
                'updated_at' => '2026-08-22 13:58:48',
            ),
            11 => 
            array (
                'id' => 512,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 13:59:02',
                'updated_at' => '2026-08-22 13:59:02',
            ),
            12 => 
            array (
                'id' => 513,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 13:59:25',
                'updated_at' => '2026-08-22 13:59:25',
            ),
            13 => 
            array (
                'id' => 514,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:00:07',
                'updated_at' => '2026-08-22 14:00:07',
            ),
            14 => 
            array (
                'id' => 515,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:00:28',
                'updated_at' => '2026-08-22 14:00:28',
            ),
            15 => 
            array (
                'id' => 516,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:00:40',
                'updated_at' => '2026-08-22 14:00:40',
            ),
            16 => 
            array (
                'id' => 517,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:01:05',
                'updated_at' => '2026-08-22 14:01:05',
            ),
            17 => 
            array (
                'id' => 518,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:02:12',
                'updated_at' => '2026-08-22 14:02:12',
            ),
            18 => 
            array (
                'id' => 519,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:02:34',
                'updated_at' => '2026-08-22 14:02:34',
            ),
            19 => 
            array (
                'id' => 520,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:02:35',
                'updated_at' => '2026-08-22 14:02:35',
            ),
            20 => 
            array (
                'id' => 521,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:02:51',
                'updated_at' => '2026-08-22 14:02:51',
            ),
            21 => 
            array (
                'id' => 522,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:03:04',
                'updated_at' => '2026-08-22 14:03:04',
            ),
            22 => 
            array (
                'id' => 523,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:03:13',
                'updated_at' => '2026-08-22 14:03:13',
            ),
            23 => 
            array (
                'id' => 524,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:03:26',
                'updated_at' => '2026-08-22 14:03:26',
            ),
            24 => 
            array (
                'id' => 525,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:08:32',
                'updated_at' => '2026-08-22 14:08:32',
            ),
            25 => 
            array (
                'id' => 526,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:09:19',
                'updated_at' => '2026-08-22 14:09:19',
            ),
            26 => 
            array (
                'id' => 527,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:09:30',
                'updated_at' => '2026-08-22 14:09:30',
            ),
            27 => 
            array (
                'id' => 528,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:13:47',
                'updated_at' => '2026-08-22 14:13:47',
            ),
            28 => 
            array (
                'id' => 529,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:14:15',
                'updated_at' => '2026-08-22 14:14:15',
            ),
            29 => 
            array (
                'id' => 530,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:14:26',
                'updated_at' => '2026-08-22 14:14:26',
            ),
            30 => 
            array (
                'id' => 531,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:14:42',
                'updated_at' => '2026-08-22 14:14:42',
            ),
            31 => 
            array (
                'id' => 532,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:14:57',
                'updated_at' => '2026-08-22 14:14:57',
            ),
            32 => 
            array (
                'id' => 533,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:15:19',
                'updated_at' => '2026-08-22 14:15:19',
            ),
            33 => 
            array (
                'id' => 534,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:15:37',
                'updated_at' => '2026-08-22 14:15:37',
            ),
            34 => 
            array (
                'id' => 535,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 14:17:30',
                'updated_at' => '2026-08-22 14:17:30',
            ),
            35 => 
            array (
                'id' => 536,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 14:18:28',
                'updated_at' => '2026-08-22 14:18:28',
            ),
            36 => 
            array (
                'id' => 537,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Digital Industry\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-22 14:23:54',
                'updated_at' => '2026-08-22 14:23:54',
            ),
            37 => 
            array (
                'id' => 538,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:34:39',
                'updated_at' => '2026-08-22 14:34:39',
            ),
            38 => 
            array (
                'id' => 539,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:35:23',
                'updated_at' => '2026-08-22 14:35:23',
            ),
            39 => 
            array (
                'id' => 540,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:38:10',
                'updated_at' => '2026-08-22 14:38:10',
            ),
            40 => 
            array (
                'id' => 541,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:44:04',
                'updated_at' => '2026-08-22 14:44:04',
            ),
            41 => 
            array (
                'id' => 542,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:44:24',
                'updated_at' => '2026-08-22 14:44:24',
            ),
            42 => 
            array (
                'id' => 543,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:44:53',
                'updated_at' => '2026-08-22 14:44:53',
            ),
            43 => 
            array (
                'id' => 544,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:45:06',
                'updated_at' => '2026-08-22 14:45:06',
            ),
            44 => 
            array (
                'id' => 545,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:45:49',
                'updated_at' => '2026-08-22 14:45:49',
            ),
            45 => 
            array (
                'id' => 546,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:50:38',
                'updated_at' => '2026-08-22 14:50:38',
            ),
            46 => 
            array (
                'id' => 547,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 14:51:22',
                'updated_at' => '2026-08-22 14:51:22',
            ),
            47 => 
            array (
                'id' => 548,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:04:00',
                'updated_at' => '2026-08-22 15:04:00',
            ),
            48 => 
            array (
                'id' => 549,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:04:24',
                'updated_at' => '2026-08-22 15:04:24',
            ),
            49 => 
            array (
                'id' => 550,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:06:22',
                'updated_at' => '2026-08-22 15:06:22',
            ),
            50 => 
            array (
                'id' => 551,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:06:49',
                'updated_at' => '2026-08-22 15:06:49',
            ),
            51 => 
            array (
                'id' => 552,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:07:10',
                'updated_at' => '2026-08-22 15:07:10',
            ),
            52 => 
            array (
                'id' => 553,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:07:23',
                'updated_at' => '2026-08-22 15:07:23',
            ),
            53 => 
            array (
                'id' => 554,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:07:51',
                'updated_at' => '2026-08-22 15:07:51',
            ),
            54 => 
            array (
                'id' => 555,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:08:13',
                'updated_at' => '2026-08-22 15:08:13',
            ),
            55 => 
            array (
                'id' => 556,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-22 15:08:22',
                'updated_at' => '2026-08-22 15:08:22',
            ),
            56 => 
            array (
                'id' => 557,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 01:55:52',
                'updated_at' => '2026-08-24 01:55:52',
            ),
            57 => 
            array (
                'id' => 558,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 01:57:43',
                'updated_at' => '2026-08-24 01:57:43',
            ),
            58 => 
            array (
                'id' => 559,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 01:58:13',
                'updated_at' => '2026-08-24 01:58:13',
            ),
            59 => 
            array (
                'id' => 560,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:13:49',
                'updated_at' => '2026-08-24 02:13:49',
            ),
            60 => 
            array (
                'id' => 561,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:15:40',
                'updated_at' => '2026-08-24 02:15:40',
            ),
            61 => 
            array (
                'id' => 562,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:16:05',
                'updated_at' => '2026-08-24 02:16:05',
            ),
            62 => 
            array (
                'id' => 563,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:16:30',
                'updated_at' => '2026-08-24 02:16:30',
            ),
            63 => 
            array (
                'id' => 564,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:16:56',
                'updated_at' => '2026-08-24 02:16:56',
            ),
            64 => 
            array (
                'id' => 565,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:16:56',
                'updated_at' => '2026-08-24 02:16:56',
            ),
            65 => 
            array (
                'id' => 566,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:17:17',
                'updated_at' => '2026-08-24 02:17:17',
            ),
            66 => 
            array (
                'id' => 567,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:18:44',
                'updated_at' => '2026-08-24 02:18:44',
            ),
            67 => 
            array (
                'id' => 568,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:20:49',
                'updated_at' => '2026-08-24 02:20:49',
            ),
            68 => 
            array (
                'id' => 569,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:21:04',
                'updated_at' => '2026-08-24 02:21:04',
            ),
            69 => 
            array (
                'id' => 570,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 02:23:13',
                'updated_at' => '2026-08-24 02:23:13',
            ),
            70 => 
            array (
                'id' => 571,
                'user_name' => 'Admin User',
                'action' => 'Deleted navigation node \'Exam and Evaluation\'',
                'module' => 'navigation',
                'icon_class' => 'bg-red-500/10 text-red-500',
                'created_at' => '2026-08-24 03:13:26',
                'updated_at' => '2026-08-24 03:13:26',
            ),
            71 => 
            array (
                'id' => 572,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:16:48',
                'updated_at' => '2026-08-24 03:16:48',
            ),
            72 => 
            array (
                'id' => 573,
                'user_name' => 'Admin User',
                'action' => 'Updated home page settings',
                'module' => 'home',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:17:02',
                'updated_at' => '2026-08-24 03:17:02',
            ),
            73 => 
            array (
                'id' => 574,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-24 03:18:49',
                'updated_at' => '2026-08-24 03:18:49',
            ),
            74 => 
            array (
                'id' => 575,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-24 03:19:21',
                'updated_at' => '2026-08-24 03:19:21',
            ),
            75 => 
            array (
                'id' => 576,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-24 03:31:07',
                'updated_at' => '2026-08-24 03:31:07',
            ),
            76 => 
            array (
                'id' => 577,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-24 03:31:56',
                'updated_at' => '2026-08-24 03:31:56',
            ),
            77 => 
            array (
                'id' => 578,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:36:52',
                'updated_at' => '2026-08-24 03:36:52',
            ),
            78 => 
            array (
                'id' => 579,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:42:26',
                'updated_at' => '2026-08-24 03:42:26',
            ),
            79 => 
            array (
                'id' => 580,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:42:45',
                'updated_at' => '2026-08-24 03:42:45',
            ),
            80 => 
            array (
                'id' => 581,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:43:01',
                'updated_at' => '2026-08-24 03:43:01',
            ),
            81 => 
            array (
                'id' => 582,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:43:35',
                'updated_at' => '2026-08-24 03:43:35',
            ),
            82 => 
            array (
                'id' => 583,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:45:05',
                'updated_at' => '2026-08-24 03:45:05',
            ),
            83 => 
            array (
                'id' => 584,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:49:32',
                'updated_at' => '2026-08-24 03:49:32',
            ),
            84 => 
            array (
                'id' => 585,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:50:06',
                'updated_at' => '2026-08-24 03:50:06',
            ),
            85 => 
            array (
                'id' => 586,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:56:45',
                'updated_at' => '2026-08-24 03:56:45',
            ),
            86 => 
            array (
                'id' => 587,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:57:00',
                'updated_at' => '2026-08-24 03:57:00',
            ),
            87 => 
            array (
                'id' => 588,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:57:19',
                'updated_at' => '2026-08-24 03:57:19',
            ),
            88 => 
            array (
                'id' => 589,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:58:45',
                'updated_at' => '2026-08-24 03:58:45',
            ),
            89 => 
            array (
                'id' => 590,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 03:59:46',
                'updated_at' => '2026-08-24 03:59:46',
            ),
            90 => 
            array (
                'id' => 591,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 04:07:16',
                'updated_at' => '2026-08-24 04:07:16',
            ),
            91 => 
            array (
                'id' => 592,
                'user_name' => 'Admin User',
                'action' => 'Restored default faculties & departments structure',
                'module' => 'faculties',
                'icon_class' => 'bg-amber-500/10 text-amber-500',
                'created_at' => '2026-08-24 06:18:06',
                'updated_at' => '2026-08-24 06:18:06',
            ),
            92 => 
            array (
                'id' => 593,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:19:56',
                'updated_at' => '2026-08-24 06:19:56',
            ),
            93 => 
            array (
                'id' => 594,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:20:46',
                'updated_at' => '2026-08-24 06:20:46',
            ),
            94 => 
            array (
                'id' => 595,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:21:11',
                'updated_at' => '2026-08-24 06:21:11',
            ),
            95 => 
            array (
                'id' => 596,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:22:04',
                'updated_at' => '2026-08-24 06:22:04',
            ),
            96 => 
            array (
                'id' => 597,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Specific Purposes\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:22:36',
                'updated_at' => '2026-08-24 06:22:36',
            ),
            97 => 
            array (
                'id' => 598,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English Education\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:23:00',
                'updated_at' => '2026-08-24 06:23:00',
            ),
            98 => 
            array (
                'id' => 599,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:23:20',
                'updated_at' => '2026-08-24 06:23:20',
            ),
            99 => 
            array (
                'id' => 600,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:24:06',
                'updated_at' => '2026-08-24 06:24:06',
            ),
            100 => 
            array (
                'id' => 601,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Engineering Management\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:24:27',
                'updated_at' => '2026-08-24 06:24:27',
            ),
            101 => 
            array (
                'id' => 602,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Interior Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:24:46',
                'updated_at' => '2026-08-24 06:24:46',
            ),
            102 => 
            array (
                'id' => 603,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agronomy and Horticulture\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:25:12',
                'updated_at' => '2026-08-24 06:25:12',
            ),
            103 => 
            array (
                'id' => 604,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agricultural Economics\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:25:28',
                'updated_at' => '2026-08-24 06:25:28',
            ),
            104 => 
            array (
                'id' => 605,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Rural Development\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:25:45',
                'updated_at' => '2026-08-24 06:25:45',
            ),
            105 => 
            array (
                'id' => 606,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Rural Development\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:25:54',
                'updated_at' => '2026-08-24 06:25:54',
            ),
            106 => 
            array (
                'id' => 607,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:29:10',
                'updated_at' => '2026-08-24 06:29:10',
            ),
            107 => 
            array (
                'id' => 608,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Political Science\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:30:17',
                'updated_at' => '2026-08-24 06:30:17',
            ),
            108 => 
            array (
                'id' => 609,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 06:34:25',
                'updated_at' => '2026-08-24 06:34:25',
            ),
            109 => 
            array (
                'id' => 610,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Economy\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:03:52',
                'updated_at' => '2026-08-24 07:03:52',
            ),
            110 => 
            array (
                'id' => 611,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Economy\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:05:05',
                'updated_at' => '2026-08-24 07:05:05',
            ),
            111 => 
            array (
                'id' => 612,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of E-Commerce\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:12:20',
                'updated_at' => '2026-08-24 07:12:20',
            ),
            112 => 
            array (
                'id' => 613,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Public Administration\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:14:28',
                'updated_at' => '2026-08-24 07:14:28',
            ),
            113 => 
            array (
                'id' => 614,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Agricultural Economics\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:16:29',
                'updated_at' => '2026-08-24 07:16:29',
            ),
            114 => 
            array (
                'id' => 615,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:19:27',
                'updated_at' => '2026-08-24 07:19:27',
            ),
            115 => 
            array (
                'id' => 616,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of English for Translation and Interpretation\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:19:52',
                'updated_at' => '2026-08-24 07:19:52',
            ),
            116 => 
            array (
                'id' => 617,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:22:02',
                'updated_at' => '2026-08-24 07:22:02',
            ),
            117 => 
            array (
                'id' => 618,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Economy\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:24:17',
                'updated_at' => '2026-08-24 07:24:17',
            ),
            118 => 
            array (
                'id' => 619,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of E-Commerce\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:24:43',
                'updated_at' => '2026-08-24 07:24:43',
            ),
            119 => 
            array (
                'id' => 620,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:27:37',
                'updated_at' => '2026-08-24 07:27:37',
            ),
            120 => 
            array (
                'id' => 621,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Law\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:36:42',
                'updated_at' => '2026-08-24 07:36:42',
            ),
            121 => 
            array (
                'id' => 622,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Rural Development\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-24 07:39:32',
                'updated_at' => '2026-08-24 07:39:32',
            ),
            122 => 
            array (
                'id' => 623,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 07:52:39',
                'updated_at' => '2026-08-24 07:52:39',
            ),
            123 => 
            array (
                'id' => 624,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 08:04:29',
                'updated_at' => '2026-08-24 08:04:29',
            ),
            124 => 
            array (
                'id' => 625,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-24 08:13:31',
                'updated_at' => '2026-08-24 08:13:31',
            ),
            125 => 
            array (
                'id' => 626,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 01:52:45',
                'updated_at' => '2026-08-25 01:52:45',
            ),
            126 => 
            array (
                'id' => 627,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 01:53:19',
                'updated_at' => '2026-08-25 01:53:19',
            ),
            127 => 
            array (
                'id' => 628,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 02:29:57',
                'updated_at' => '2026-08-25 02:29:57',
            ),
            128 => 
            array (
                'id' => 629,
                'user_name' => 'Admin User',
                'action' => 'Updated campus contact & social accounts settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 02:34:47',
                'updated_at' => '2026-08-25 02:34:47',
            ),
            129 => 
            array (
                'id' => 630,
                'user_name' => 'Admin User',
                'action' => 'Updated faculty \'Faculty of Law and Political Science\'',
                'module' => 'faculties',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-25 02:57:14',
                'updated_at' => '2026-08-25 02:57:14',
            ),
            130 => 
            array (
                'id' => 631,
                'user_name' => 'Admin User',
                'action' => 'Updated Sub-decree settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 06:36:37',
                'updated_at' => '2026-08-25 06:36:37',
            ),
            131 => 
            array (
                'id' => 632,
                'user_name' => 'Admin User',
                'action' => 'Updated Sub-decree settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 06:40:09',
                'updated_at' => '2026-08-25 06:40:09',
            ),
            132 => 
            array (
                'id' => 633,
                'user_name' => 'Admin User',
                'action' => 'Updated Sub-decree settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 07:01:45',
                'updated_at' => '2026-08-25 07:01:45',
            ),
            133 => 
            array (
                'id' => 634,
                'user_name' => 'Admin User',
                'action' => 'Updated Sub-decree settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 07:02:32',
                'updated_at' => '2026-08-25 07:02:32',
            ),
            134 => 
            array (
                'id' => 635,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Graphic Design\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-25 07:27:56',
                'updated_at' => '2026-08-25 07:27:56',
            ),
            135 => 
            array (
                'id' => 636,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Digital Marketing\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-25 07:31:38',
                'updated_at' => '2026-08-25 07:31:38',
            ),
            136 => 
            array (
                'id' => 637,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-25 07:37:17',
                'updated_at' => '2026-08-25 07:37:17',
            ),
            137 => 
            array (
                'id' => 638,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Social Media\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-25 07:57:59',
                'updated_at' => '2026-08-25 07:57:59',
            ),
            138 => 
            array (
                'id' => 639,
                'user_name' => 'Admin User',
                'action' => 'Updated department \'Department of Information Technology\'',
                'module' => 'departments',
                'icon_class' => 'bg-emerald-500/10 text-emerald-500',
                'created_at' => '2026-08-25 08:34:47',
                'updated_at' => '2026-08-25 08:34:47',
            ),
            139 => 
            array (
                'id' => 640,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 08:46:04',
                'updated_at' => '2026-08-25 08:46:04',
            ),
            140 => 
            array (
                'id' => 641,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-25 08:58:16',
                'updated_at' => '2026-08-25 08:58:16',
            ),
            141 => 
            array (
                'id' => 642,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-25 09:01:35',
                'updated_at' => '2026-08-25 09:01:35',
            ),
            142 => 
            array (
                'id' => 643,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Rector\'s Message\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-25 09:04:48',
                'updated_at' => '2026-08-25 09:04:48',
            ),
            143 => 
            array (
                'id' => 644,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sub-Decree\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-25 09:06:11',
                'updated_at' => '2026-08-25 09:06:11',
            ),
            144 => 
            array (
                'id' => 645,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sub-Decree on University Establishment\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-25 09:06:44',
                'updated_at' => '2026-08-25 09:06:44',
            ),
            145 => 
            array (
                'id' => 646,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Degree Certificate\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-25 09:07:47',
                'updated_at' => '2026-08-25 09:07:47',
            ),
            146 => 
            array (
                'id' => 647,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Degree Certificate\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-25 09:11:50',
                'updated_at' => '2026-08-25 09:11:50',
            ),
            147 => 
            array (
                'id' => 648,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Graduation Gown\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-25 09:12:54',
                'updated_at' => '2026-08-25 09:12:54',
            ),
            148 => 
            array (
                'id' => 649,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Student Uniform\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:16:02',
                'updated_at' => '2026-08-25 09:16:02',
            ),
            149 => 
            array (
                'id' => 650,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Graduation Gown\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:16:22',
                'updated_at' => '2026-08-25 09:16:22',
            ),
            150 => 
            array (
                'id' => 651,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Student Uniform\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:16:45',
                'updated_at' => '2026-08-25 09:16:45',
            ),
            151 => 
            array (
                'id' => 652,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Student Uniform\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:17:00',
                'updated_at' => '2026-08-25 09:17:00',
            ),
            152 => 
            array (
                'id' => 653,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Graduation Gown\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:17:16',
                'updated_at' => '2026-08-25 09:17:16',
            ),
            153 => 
            array (
                'id' => 654,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Building\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:18:57',
                'updated_at' => '2026-08-25 09:18:57',
            ),
            154 => 
            array (
                'id' => 655,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sub-Decree on University Establishment\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:19:05',
                'updated_at' => '2026-08-25 09:19:05',
            ),
            155 => 
            array (
                'id' => 656,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sample Graduation Gown\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:19:21',
                'updated_at' => '2026-08-25 09:19:21',
            ),
            156 => 
            array (
                'id' => 657,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Building\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:19:51',
                'updated_at' => '2026-08-25 09:19:51',
            ),
            157 => 
            array (
                'id' => 658,
                'user_name' => 'Admin User',
                'action' => 'Updated navigation node \'Sub-Decree on University Establishment\'',
                'module' => 'navigation',
                'icon_class' => 'bg-blue-500/10 text-blue-500',
                'created_at' => '2026-08-25 09:19:58',
                'updated_at' => '2026-08-25 09:19:58',
            ),
            158 => 
            array (
                'id' => 659,
                'user_name' => 'Admin User',
                'action' => 'Updated Sub-decree settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 02:07:58',
                'updated_at' => '2026-08-26 02:07:58',
            ),
            159 => 
            array (
                'id' => 660,
                'user_name' => 'Admin User',
                'action' => 'Updated Sub-decree settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 02:09:24',
                'updated_at' => '2026-08-26 02:09:24',
            ),
            160 => 
            array (
                'id' => 661,
                'user_name' => 'Admin User',
                'action' => 'Updated Sub-decree settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 02:11:47',
                'updated_at' => '2026-08-26 02:11:47',
            ),
            161 => 
            array (
                'id' => 662,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 03:06:54',
                'updated_at' => '2026-08-26 03:06:54',
            ),
            162 => 
            array (
                'id' => 663,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:13:49',
                'updated_at' => '2026-08-26 06:13:49',
            ),
            163 => 
            array (
                'id' => 664,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:14:55',
                'updated_at' => '2026-08-26 06:14:55',
            ),
            164 => 
            array (
                'id' => 665,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:18:02',
                'updated_at' => '2026-08-26 06:18:02',
            ),
            165 => 
            array (
                'id' => 666,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:22:18',
                'updated_at' => '2026-08-26 06:22:18',
            ),
            166 => 
            array (
                'id' => 667,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:22:49',
                'updated_at' => '2026-08-26 06:22:49',
            ),
            167 => 
            array (
                'id' => 668,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:30:28',
                'updated_at' => '2026-08-26 06:30:28',
            ),
            168 => 
            array (
                'id' => 669,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:35:45',
                'updated_at' => '2026-08-26 06:35:45',
            ),
            169 => 
            array (
                'id' => 670,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:51:35',
                'updated_at' => '2026-08-26 06:51:35',
            ),
            170 => 
            array (
                'id' => 671,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:53:43',
                'updated_at' => '2026-08-26 06:53:43',
            ),
            171 => 
            array (
                'id' => 672,
                'user_name' => 'Admin User',
                'action' => 'Updated Student Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 06:55:27',
                'updated_at' => '2026-08-26 06:55:27',
            ),
            172 => 
            array (
                'id' => 673,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Sample Degree Certificate\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-26 07:02:28',
                'updated_at' => '2026-08-26 07:02:28',
            ),
            173 => 
            array (
                'id' => 674,
                'user_name' => 'Admin User',
                'action' => 'Updated Degree Certificate settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 07:49:42',
                'updated_at' => '2026-08-26 07:49:42',
            ),
            174 => 
            array (
                'id' => 675,
                'user_name' => 'Admin User',
                'action' => 'Updated Degree Certificate settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 07:56:23',
                'updated_at' => '2026-08-26 07:56:23',
            ),
            175 => 
            array (
                'id' => 676,
                'user_name' => 'Admin User',
                'action' => 'Updated Degree Certificate settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 08:06:06',
                'updated_at' => '2026-08-26 08:06:06',
            ),
            176 => 
            array (
                'id' => 677,
                'user_name' => 'Admin User',
                'action' => 'Updated Degree Certificate settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 08:13:48',
                'updated_at' => '2026-08-26 08:13:48',
            ),
            177 => 
            array (
                'id' => 678,
                'user_name' => 'Admin User',
                'action' => 'Updated Degree Certificate settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 08:14:14',
                'updated_at' => '2026-08-26 08:14:14',
            ),
            178 => 
            array (
                'id' => 679,
                'user_name' => 'Admin User',
                'action' => 'Updated Degree Certificate settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-26 08:19:32',
                'updated_at' => '2026-08-26 08:19:32',
            ),
            179 => 
            array (
                'id' => 680,
                'user_name' => 'Admin User',
                'action' => 'Updated Graduation Uniform settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-27 01:57:07',
                'updated_at' => '2026-08-27 01:57:07',
            ),
            180 => 
            array (
                'id' => 681,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-27 02:27:35',
                'updated_at' => '2026-08-27 02:27:35',
            ),
            181 => 
            array (
                'id' => 682,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-27 02:37:54',
                'updated_at' => '2026-08-27 02:37:54',
            ),
            182 => 
            array (
                'id' => 683,
                'user_name' => 'Admin User',
                'action' => 'Updated contact page settings',
                'module' => 'settings',
                'icon_class' => 'bg-rose-500/10 text-rose-500',
                'created_at' => '2026-08-27 02:41:41',
                'updated_at' => '2026-08-27 02:41:41',
            ),
            183 => 
            array (
                'id' => 684,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-27 08:04:25',
                'updated_at' => '2026-08-27 08:04:25',
            ),
            184 => 
            array (
                'id' => 685,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-27 08:05:30',
                'updated_at' => '2026-08-27 08:05:30',
            ),
            185 => 
            array (
                'id' => 686,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-27 08:09:47',
                'updated_at' => '2026-08-27 08:09:47',
            ),
            186 => 
            array (
                'id' => 687,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-27 08:15:27',
                'updated_at' => '2026-08-27 08:15:27',
            ),
            187 => 
            array (
                'id' => 688,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-28 02:45:32',
                'updated_at' => '2026-08-28 02:45:32',
            ),
            188 => 
            array (
                'id' => 689,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-28 03:20:10',
                'updated_at' => '2026-08-28 03:20:10',
            ),
            189 => 
            array (
                'id' => 690,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-28 03:26:50',
                'updated_at' => '2026-08-28 03:26:50',
            ),
            190 => 
            array (
                'id' => 691,
                'user_name' => 'Admin User',
                'action' => 'Updated page content for \'Building\'',
                'module' => 'pages',
                'icon_class' => 'bg-indigo-500/10 text-indigo-500',
                'created_at' => '2026-08-28 03:35:32',
                'updated_at' => '2026-08-28 03:35:32',
            ),
        ));
        
        
    }
}