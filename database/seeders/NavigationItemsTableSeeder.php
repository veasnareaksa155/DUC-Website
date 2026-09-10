<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NavigationItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('navigation_items')->delete();
        
        \DB::table('navigation_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'label' => '{"en":"HOME","km":"\\u1791\\u17c6\\u1796\\u17d0\\u179a\\u178a\\u17be\\u1798"}',
                'href' => '/',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 012 0v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>',
                'parent_id' => NULL,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            1 => 
            array (
                'id' => 2,
                'label' => '{"en":"About Us","km":"\\u17a2\\u17c6\\u1796\\u17b8\\u1799\\u17be\\u1784"}',
                'href' => '/about',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
                'parent_id' => NULL,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-22 12:46:48',
            ),
            2 => 
            array (
                'id' => 3,
                'label' => '{"en":"Rector\'s Message","km":"\\u179f\\u17b6\\u179a\\u1796\\u17b8\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u1792\\u17b7\\u1780\\u17b6\\u179a"}',
                'href' => '/rector',
                'icon' => NULL,
                'parent_id' => 2,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-22 12:47:49',
            ),
            3 => 
            array (
                'id' => 11,
                'label' => '{"en":"Planning and Research Office","km":"\\u1780\\u17b6\\u179a\\u17b7\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u1795\\u17c2\\u1793\\u1780\\u17b6\\u179a \\u1793\\u17b7\\u1784\\u179f\\u17d2\\u179a\\u17b6\\u179c\\u1787\\u17d2\\u179a\\u17b6\\u179c"}',
                'href' => '/planning_and_research_office',
                'icon' => NULL,
                'parent_id' => NULL,
                'order' => 7,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            4 => 
            array (
                'id' => 13,
                'label' => '{"en":"FACULTIES","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799"}',
                'href' => '/faculties',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/></svg>',
                'parent_id' => NULL,
                'order' => 3,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            5 => 
            array (
                'id' => 14,
                'label' => '{"en":"EVENTS","km":"\\u1796\\u17d0\\u178f\\u17cc\\u1798\\u17b6\\u1793 \\u1793\\u17b7\\u1784\\u1796\\u17d2\\u179a\\u17b9\\u178f\\u17d2\\u178f\\u17b7\\u1780\\u17b6\\u179a\\u178e\\u17cd"}',
                'href' => '/events',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
                'parent_id' => NULL,
                'order' => 4,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            6 => 
            array (
                'id' => 15,
                'label' => '{"en":"CONTACT","km":"\\u1791\\u17c6\\u1793\\u17b6\\u1780\\u17cb\\u1791\\u17c6\\u1793\\u1784"}',
                'href' => '/contact',
                'icon' => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>',
                'parent_id' => NULL,
                'order' => 5,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            7 => 
            array (
                'id' => 16,
                'label' => '{"en":"Faculty of Digital Industry","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u17a7\\u179f\\u17d2\\u179f\\u17b6\\u17a0\\u1780\\u1798\\u17d2\\u1798\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b"}',
                'href' => '/department/1',
                'icon' => NULL,
                'parent_id' => 13,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            8 => 
            array (
                'id' => 17,
                'label' => '{"en":"Department of Graphic Design","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1780\\u17d2\\u179a\\u17b6\\u17a0\\u17d2\\u179c\\u17b7\\u1780\\u178c\\u17b8\\u17a0\\u17d2\\u179f\\u17b6\\u1789"}',
                'href' => '/faculty/1/department/graphic-design',
                'icon' => NULL,
                'parent_id' => 16,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 07:22:01',
            ),
            9 => 
            array (
                'id' => 18,
                'label' => '{"en":"Department of Digital Marketing","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1791\\u17b8\\u1795\\u17d2\\u179f\\u17b6\\u179a\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b"}',
                'href' => '/faculty/1/department/digital-marketing',
                'icon' => NULL,
                'parent_id' => 16,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 08:23:17',
            ),
            10 => 
            array (
                'id' => 19,
                'label' => '{"en":"Department of Social Media","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1794\\u17d2\\u179a\\u1796\\u17d0\\u1793\\u17d2\\u1792\\u1795\\u17d2\\u179f\\u1796\\u17d2\\u179c\\u1795\\u17d2\\u179f\\u17b6\\u1799\\u179f\\u1784\\u17d2\\u1782\\u1798"}',
                'href' => '/faculty/1/department/social-media',
                'icon' => NULL,
                'parent_id' => 16,
                'order' => 3,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 07:27:37',
            ),
            11 => 
            array (
                'id' => 20,
                'label' => '{"en":"Department of Information Technology","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u1796\\u17d0\\u178f\\u17cc\\u1798\\u17b6\\u1793"}',
                'href' => '/faculty/1/department/information-technology',
                'icon' => NULL,
                'parent_id' => 16,
                'order' => 4,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 06:22:04',
            ),
            12 => 
            array (
                'id' => 21,
                'label' => '{"en":"Faculty of English Language","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u1797\\u17b6\\u179f\\u17b6\\u17a2\\u1784\\u17cb\\u1782\\u17d2\\u179b\\u17c1\\u179f"}',
                'href' => '/department/2',
                'icon' => NULL,
                'parent_id' => 13,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            13 => 
            array (
                'id' => 22,
                'label' => '{"en":"Department of English for Specific Purposes","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1797\\u17b6\\u179f\\u17b6\\u17a2\\u1784\\u17cb\\u1782\\u17d2\\u179b\\u17c1\\u179f\\u179f\\u1798\\u17d2\\u179a\\u17b6\\u1794\\u17cb\\u1782\\u17c4\\u179b\\u1794\\u17c6\\u178e\\u1784\\u1787\\u17b6\\u1780\\u17cb\\u179b\\u17b6\\u1780\\u17cb"}',
                'href' => '/faculty/2/department/english-for-specific-purposes',
                'icon' => NULL,
                'parent_id' => 21,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 06:22:36',
            ),
            14 => 
            array (
                'id' => 23,
                'label' => '{"en":"Department of English Education","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u17a2\\u1794\\u17cb\\u179a\\u17c6\\u1797\\u17b6\\u179f\\u17b6\\u17a2\\u1784\\u17cb\\u1782\\u17d2\\u179b\\u17c1\\u179f"}',
                'href' => '/faculty/2/department/english-education',
                'icon' => NULL,
                'parent_id' => 21,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            15 => 
            array (
                'id' => 24,
                'label' => '{"en":"Department of English for Translation and Interpretation","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1797\\u17b6\\u179f\\u17b6\\u17a2\\u1784\\u17cb\\u1782\\u17d2\\u179b\\u17c1\\u179f\\u179f\\u1798\\u17d2\\u179a\\u17b6\\u1794\\u17cb\\u1780\\u17b6\\u179a\\u1794\\u1780\\u1794\\u17d2\\u179a\\u17c2"}',
                'href' => '/faculty/2/department/english-for-translation-and-interpretation',
                'icon' => NULL,
                'parent_id' => 21,
                'order' => 3,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            16 => 
            array (
                'id' => 25,
                'label' => '{"en":"Faculty of Engineering and Architecture","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u179c\\u17b7\\u179f\\u17d2\\u179c\\u1780\\u1798\\u17d2\\u1798 \\u1793\\u17b7\\u1784\\u179f\\u17d2\\u1790\\u17b6\\u1794\\u178f\\u17d2\\u1799\\u1780\\u1798\\u17d2\\u1798"}',
                'href' => '/department/3',
                'icon' => NULL,
                'parent_id' => 13,
                'order' => 3,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            17 => 
            array (
                'id' => 26,
                'label' => '{"en":"Department of Engineering","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u179c\\u17b7\\u179f\\u17d2\\u179c\\u1780\\u1798\\u17d2\\u1798"}',
                'href' => '/faculty/3/department/engineering',
                'icon' => NULL,
                'parent_id' => 25,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            18 => 
            array (
                'id' => 27,
                'label' => '{"en":"Department of Engineering Management","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1782\\u17d2\\u179a\\u1794\\u17cb\\u1782\\u17d2\\u179a\\u1784\\u179c\\u17b7\\u179f\\u17d2\\u179c\\u1780\\u1798\\u17d2\\u1798"}',
                'href' => '/faculty/3/department/engineering-management',
                'icon' => NULL,
                'parent_id' => 25,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 06:24:27',
            ),
            19 => 
            array (
                'id' => 28,
                'label' => '{"en":"Department of Interior Design","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u179a\\u1785\\u1793\\u17b6\\u1795\\u17d2\\u1791\\u17c3\\u1780\\u17d2\\u1793\\u17bb\\u1784"}',
                'href' => '/faculty/3/department/interior-design',
                'icon' => NULL,
                'parent_id' => 25,
                'order' => 3,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            20 => 
            array (
                'id' => 29,
                'label' => '{"en":"Faculty of Agriculture and Rural Development","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u1780\\u179f\\u17b7\\u1780\\u1798\\u17d2\\u1798 \\u1793\\u17b7\\u1784\\u17a2\\u1797\\u17b7\\u179c\\u178c\\u17d2\\u178d\\u1793\\u17cd\\u1787\\u1793\\u1794\\u1791"}',
                'href' => '/department/4',
                'icon' => NULL,
                'parent_id' => 13,
                'order' => 4,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            21 => 
            array (
                'id' => 30,
                'label' => '{"en":"Department of Agronomy and Horticulture","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1780\\u17d2\\u179f\\u17c1\\u178f\\u17d2\\u179a\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a \\u1793\\u17b7\\u1784\\u179c\\u1794\\u17d2\\u1794\\u1780\\u1798\\u17d2\\u1798"}',
                'href' => '/faculty/4/department/agronomy-and-horticulture',
                'icon' => NULL,
                'parent_id' => 29,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 06:25:12',
            ),
            22 => 
            array (
                'id' => 31,
                'label' => '{"en":"Department of Agricultural Economics","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u179f\\u17c1\\u178a\\u17d2\\u178b\\u1780\\u17b7\\u1785\\u17d2\\u1785\\u1780\\u179f\\u17b7\\u1780\\u1798\\u17d2\\u1798"}',
                'href' => '/faculty/4/department/agricultural-economics',
                'icon' => NULL,
                'parent_id' => 29,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            23 => 
            array (
                'id' => 32,
                'label' => '{"en":"Department of Rural Development","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u17a2\\u1797\\u17b7\\u179c\\u178c\\u17d2\\u178d\\u1793\\u17cd\\u1787\\u1793\\u1794\\u1791"}',
                'href' => '/faculty/4/department/rural-development',
                'icon' => NULL,
                'parent_id' => 29,
                'order' => 3,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            24 => 
            array (
                'id' => 33,
                'label' => '{"en":"Faculty of Law and Political Science","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u1785\\u17d2\\u1794\\u17b6\\u1794\\u17cb \\u1793\\u17b7\\u1784\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u1793\\u1799\\u17c4\\u1794\\u17b6\\u1799"}',
                'href' => '/department/5',
                'icon' => NULL,
                'parent_id' => 13,
                'order' => 5,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 06:18:06',
            ),
            25 => 
            array (
                'id' => 34,
                'label' => '{"en":"Department of Law","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1785\\u17d2\\u1794\\u17b6\\u1794\\u17cb"}',
                'href' => '/faculty/5/department/law',
                'icon' => NULL,
                'parent_id' => 33,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 06:29:10',
            ),
            26 => 
            array (
                'id' => 35,
                'label' => '{"en":"Department of Public Administration","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u179a\\u178a\\u17d2\\u178b\\u1794\\u17b6\\u179b\\u179f\\u17b6\\u1792\\u17b6\\u179a\\u178e\\u17c8"}',
                'href' => '/faculty/5/department/public-administration',
                'icon' => NULL,
                'parent_id' => 33,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            27 => 
            array (
                'id' => 36,
                'label' => '{"en":"Department of Political Science","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u1793\\u1799\\u17c4\\u1794\\u17b6\\u1799"}',
                'href' => '/faculty/5/department/political-science',
                'icon' => NULL,
                'parent_id' => 33,
                'order' => 3,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-24 06:30:17',
            ),
            28 => 
            array (
                'id' => 37,
                'label' => '{"en":"Faculty of Digital Economic Sciences","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u179f\\u17c1\\u178a\\u17d2\\u178b\\u1780\\u17b7\\u1785\\u17d2\\u1785\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b"}',
                'href' => '/department/6',
                'icon' => NULL,
                'parent_id' => 13,
                'order' => 6,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
            29 => 
            array (
                'id' => 38,
                'label' => '{"en":"Department of Digital Economy","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u179f\\u17c1\\u178a\\u17d2\\u178b\\u1780\\u17b7\\u1785\\u17d2\\u1785\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b"}',
                'href' => '/faculty/6/department/digital-economy',
                'icon' => NULL,
                'parent_id' => 37,
                'order' => 1,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-22 06:33:16',
            ),
            30 => 
            array (
                'id' => 39,
                'label' => '{"en":"Department of E-Commerce","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1782\\u17d2\\u179a\\u1794\\u17cb\\u1782\\u17d2\\u179a\\u1784\\u1796\\u17b6\\u178e\\u17b7\\u1787\\u17d2\\u1787\\u1780\\u1798\\u17d2\\u1798\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b"}',
                'href' => '/faculty/6/department/e-commerce',
                'icon' => NULL,
                'parent_id' => 37,
                'order' => 2,
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-08-22 06:33:32',
            ),
            31 => 
            array (
                'id' => 41,
                'label' => '{"en":"About Us","km":"\\u17a2\\u17c6\\u1796\\u17b8\\u1799\\u17be\\u1784"}',
                'href' => '/about',
                'icon' => NULL,
                'parent_id' => 2,
                'order' => 1,
                'created_at' => '2026-07-21 06:29:35',
                'updated_at' => '2026-08-22 12:46:48',
            ),
            32 => 
            array (
                'id' => 42,
                'label' => '{"en":"Library","km":"\\u1794\\u178e\\u17d2\\u178e\\u17b6\\u179b\\u17d0\\u1799"}',
                'href' => '/library',
                'icon' => NULL,
                'parent_id' => NULL,
                'order' => 8,
                'created_at' => '2026-07-21 06:50:08',
                'updated_at' => '2026-07-21 06:50:46',
            ),
            33 => 
            array (
                'id' => 43,
                'label' => '{"en":"Foundation Year Department","km":"\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1790\\u17d2\\u1793\\u17b6\\u1780\\u17cb\\u1786\\u17d2\\u1793\\u17b6\\u17c6\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6\\u1798\\u17bc\\u179b\\u178a\\u17d2\\u178b\\u17b6\\u1793"}',
                'href' => '/department/7',
                'icon' => NULL,
                'parent_id' => 13,
                'order' => 0,
                'created_at' => '2026-08-21 06:38:52',
                'updated_at' => '2026-08-21 06:40:52',
            ),
            34 => 
            array (
                'id' => 44,
                'label' => '{"en":"Building","km":"\\u17a2\\u1782\\u17b6\\u179a"}',
                'href' => '/building',
                'icon' => NULL,
                'parent_id' => 2,
                'order' => 4,
                'created_at' => '2026-08-21 07:06:44',
                'updated_at' => '2026-08-25 09:19:51',
            ),
            35 => 
            array (
                'id' => 45,
                'label' => '{"en":"Sub-Decree on University Establishment","km":"\\u17a2\\u1793\\u17bb\\u1780\\u17d2\\u179a\\u17b9\\u178f\\u17d2\\u1799\\u1794\\u1784\\u17d2\\u1780\\u17be\\u178f\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799"}',
                'href' => '/sub-decree',
                'icon' => NULL,
                'parent_id' => 2,
                'order' => 3,
                'created_at' => '2026-08-21 07:06:44',
                'updated_at' => '2026-08-25 09:19:58',
            ),
            36 => 
            array (
                'id' => 46,
                'label' => '{"en":"Sample Degree Certificate","km":"\\u1782\\u17c6\\u179a\\u17bc\\u200b\\u179f\\u1789\\u17d2\\u1789\\u17b6\\u1794\\u178f\\u17d2\\u179a"}',
                'href' => '/degree-certificate',
                'icon' => NULL,
                'parent_id' => 2,
                'order' => 6,
                'created_at' => '2026-08-21 07:06:44',
                'updated_at' => '2026-08-26 07:02:28',
            ),
            37 => 
            array (
                'id' => 47,
                'label' => '{"en":"Sample Graduation Gown","km":"\\u1782\\u17c6\\u179a\\u17bc\\u17af\\u1780\\u179f\\u178e\\u17d2\\u178b\\u17b6\\u1793\\u1791\\u1791\\u17bd\\u179b\\u179f\\u1789\\u17d2\\u1789\\u17b6\\u1794\\u178f\\u17d2\\u179a"}',
                'href' => '/graduation-gown',
                'icon' => NULL,
                'parent_id' => 2,
                'order' => 7,
                'created_at' => '2026-08-21 07:06:44',
                'updated_at' => '2026-08-25 09:17:16',
            ),
            38 => 
            array (
                'id' => 48,
                'label' => '{"en":"Sample Student Uniform","km":"\\u1782\\u17c6\\u179a\\u17bc\\u17af\\u1780\\u179f\\u178e\\u17d2\\u178b\\u17b6\\u1793\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f"}',
                'href' => '/student-uniform',
                'icon' => NULL,
                'parent_id' => 2,
                'order' => 5,
                'created_at' => '2026-08-21 07:06:44',
                'updated_at' => '2026-08-25 09:17:00',
            ),
        ));
        
        
    }
}