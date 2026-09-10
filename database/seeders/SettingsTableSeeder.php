<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'address',
                'value' => '{"en":"National Road No. 3 in Trapeang Sla Village, Preah Nirvan Commune, Kong Pisey District, Kampong Speu Province, Cambodia","km":"\\u1795\\u17d2\\u179b\\u17bc\\u179c\\u1787\\u17b6\\u178f\\u17b7\\u179b\\u17c1\\u1781 3 \\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1797\\u17bc\\u1798\\u17b7\\u178f\\u17d2\\u179a\\u1796\\u17b6\\u17c6\\u1784\\u179f\\u17d2\\u179b\\u17b6 \\u1783\\u17bb\\u17c6\\u1796\\u17d2\\u179a\\u17c7\\u1793\\u17b7\\u1796\\u17d2\\u179c\\u17b6\\u1793 \\u179f\\u17d2\\u179a\\u17bb\\u1780\\u1782\\u1784\\u1796\\u17b7\\u179f\\u17b8 \\u1781\\u17c1\\u178f\\u17d2\\u178f\\u1780\\u17c6\\u1796\\u1784\\u17cb\\u179f\\u17d2\\u1796\\u17ba \\u1794\\u17d2\\u179a\\u1791\\u17c1\\u179f\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-22 08:22:32',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'phone',
                'value' => '012344558',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-20 06:08:09',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'email',
                'value' => 'remsonich9999@gmail.com',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-24 07:52:39',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'direct_lines',
                'value' => '["012344558","https:\\/\\/t.me\\/Digitaluniversityofcambodia1"]',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-20 06:12:08',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'copyright',
                'value' => '{"en":"Copyright \\u00a9 2026 Digital University of Cambodia. All rights reserved.","km":"\\u179a\\u1780\\u17d2\\u179f\\u17b6\\u179f\\u17b7\\u1791\\u17d2\\u1792\\u17b7 \\u00a9 \\u17e2\\u17e0\\u17e2\\u17e6 \\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6\\u17d4 \\u179a\\u1780\\u17d2\\u179f\\u17b6\\u179f\\u17b7\\u1791\\u17d2\\u1792\\u17b7\\u1782\\u17d2\\u179a\\u1794\\u17cb\\u1799\\u17c9\\u17b6\\u1784\\u17d4"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'social_links',
                'value' => '[{"label":"Facebook","href":"https:\\/\\/www.facebook.com\\/DUCambodia\\/","svg":"<svg viewBox=\\"0 0 24 24\\" class=\\"h-4 w-4\\" fill=\\"currentColor\\"><path d=\\"M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z\\"\\/><\\/svg>","class":"hover:bg-[#1877f2] bg-white\\/10","icon_hover_color":"#ffffff","hover_color":"#0866ff","icon_color":"#397ad0"},{"label":"Telegram","href":"https:\\/\\/t.me\\/digitaluniversityofcambodia","svg":"<svg viewBox=\\"0 0 24 24\\" class=\\"h-4 w-4\\" fill=\\"currentColor\\"><path d=\\"M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z\\"\\/><\\/svg>","class":"hover:bg-[#2aabee] bg-white\\/10","hover_color":"#2e99d0","icon_hover_color":"#ffffff","icon_color":"#51abc2"},{"label":"YouTube","href":"https:\\/\\/www.youtube.com\\/@DUCambodia","svg":"<svg viewBox=\\"0 0 24 24\\" class=\\"h-4 w-4\\" fill=\\"currentColor\\"><path d=\\"M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z\\"\\/><\\/svg>","class":"hover:bg-[#ff0000] bg-white\\/10","hover_color":"#ff0033","icon_hover_color":"#ffffff","icon_color":"#d30d0d"},{"label":"Tiktok","href":"https:\\/\\/www.tiktok.com\\/@ducambodia","svg":"<svg viewBox=\\"0 0 24 24\\" class=\\"h-4 w-4\\" fill=\\"currentColor\\"><path d=\\"M16.6 5.82s.51.5 0 0A4.278 4.278 0 0 1 15.54 3h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6 0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64 0 3.33 2.76 5.7 5.69 5.7 3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48z\\"\\/><\\/svg>","class":"hover:bg-black bg-white\\/10","icon_hover_color":"#ffffff","bg_color":"#e3e5e8","icon_color":"#1b1818"}]',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-24 03:43:01',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'header_bg_color',
                'value' => '#ffffff',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 14:14:26',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'header_text_color',
                'value' => '#104652',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 14:03:26',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'footer_bg_color',
                'value' => '#104652',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 14:15:37',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'footer_border_color',
                'value' => '#104652',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 11:57:21',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'footer_text_color',
                'value' => '#ffffff',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-07-21 04:06:42',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'sub_footer_bg_color',
                'value' => '#104652',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 09:34:25',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'sub_footer_text_color',
                'value' => '#d1d9e5',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-24 03:59:46',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'sub_footer_border_color',
                'value' => '#AF8319',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 14:00:40',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'nav_bg_color',
                'value' => '#104652',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 15:08:22',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'nav_text_color',
                'value' => '#ffffff',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 14:13:47',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'nav_active_color',
                'value' => '#AF8319',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-22 09:37:24',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'contact_image',
                'value' => '/storage/settings/Jyx16o3udCbAuy7kCpoJ4M2hvFwqKEtlS1mmWRra.png',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-25 08:58:16',
            ),
            18 => 
            array (
                'id' => 19,
                'key' => 'privacy_policy_label',
                'value' => '',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-24 04:07:16',
            ),
            19 => 
            array (
                'id' => 20,
                'key' => 'privacy_policy_url',
                'value' => '',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-08-24 04:07:16',
            ),
            20 => 
            array (
                'id' => 21,
                'key' => 'footer_credits',
                'value' => 'Made with ♥ by IT Department Students',
                'created_at' => '2026-07-21 04:06:42',
                'updated_at' => '2026-07-21 04:06:42',
            ),
            21 => 
            array (
                'id' => 22,
                'key' => 'home_hero_slides',
                'value' => '[{"imgUrl":"\\/storage\\/home\\/LCoc2p0R7aDuxpA2EX9aJ1ZUK9BmIF7xiidsy82V.jpg","altText":{"en":null,"km":null}},{"imgUrl":"\\/storage\\/home\\/vxSq3O8FTPVzyIz9Zd2mYmq3zUV3aNTIGZBdiXM4.jpg","altText":{"en":null,"km":null}},{"imgUrl":"\\/storage\\/home\\/HDJ1u9SNTLp0XkOJuq9KaryBp5CwqiA4wHHHwbxg.jpg","altText":{"en":null,"km":null}},{"imgUrl":"\\/storage\\/home\\/bK3cohxjDda8hW4ynSvWxU13PyEDKaeVMcpdRfwp.jpg","altText":{"en":null,"km":null}},{"imgUrl":"\\/storage\\/home\\/HYogTx09b6yOiCoFJVGZkF6BfENAXqZzkZt7zc1D.jpg","altText":{"en":null,"km":null}},{"imgUrl":"\\/storage\\/home\\/ZYp0MHCxBU7Tt8B69F8ZYSeW98mB0d2qD3RXZkqF.jpg","altText":{"en":null,"km":null}}]',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-21 01:13:46',
            ),
            22 => 
            array (
                'id' => 23,
                'key' => 'home_scholarship',
                'value' => '{"title":{"en":"Welcome to the Digital University of Cambodia","km":"\\u179f\\u17bc\\u1798\\u179f\\u17d2\\u179c\\u17b6\\u1782\\u1798\\u1793\\u17cd\\u1798\\u1780\\u1780\\u17b6\\u1793\\u17cb\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6"},"description":{"en":"<p>Empowering the next generation of digital leaders, innovators, and change makers. We are proud to offer a <strong>100% Full Scholarship exclusively for Cambodian students<\\/strong>, ensuring that financial barriers never stand in the way of world-class education.<\\/p><p>Unlock your potential, master the skills of tomorrow, and shape the future of our nation completely tuition-free. <\\/p>","km":"<p>\\u1795\\u17d2\\u178f\\u179b\\u17cb\\u17a2\\u17c6\\u178e\\u17b6\\u1785\\u178a\\u179b\\u17cb\\u17a2\\u17d2\\u1793\\u1780\\u178a\\u17b9\\u1780\\u1793\\u17b6\\u17c6\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u1787\\u17c6\\u1793\\u17b6\\u1793\\u17cb\\u1780\\u17d2\\u179a\\u17c4\\u1799 \\u17a2\\u17d2\\u1793\\u1780\\u1785\\u17d2\\u1793\\u17c3\\u1794\\u17d2\\u179a\\u178c\\u17b7\\u178f \\u1793\\u17b7\\u1784\\u17a2\\u17d2\\u1793\\u1780\\u1792\\u17d2\\u179c\\u17be\\u1780\\u17b6\\u179a\\u1795\\u17d2\\u179b\\u17b6\\u179f\\u17cb\\u1794\\u17d2\\u178f\\u17bc\\u179a\\u17d4 \\u1799\\u17be\\u1784\\u1798\\u17b6\\u1793\\u1798\\u17c4\\u1791\\u1793\\u1797\\u17b6\\u1796\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1780\\u17b6\\u179a\\u1795\\u17d2\\u178f\\u179b\\u17cb\\u17a2\\u17b6\\u17a0\\u17b6\\u179a\\u17bc\\u1794\\u1780\\u179a\\u178e\\u17cd\\u1796\\u17c1\\u1789\\u179b\\u17c1\\u1789 100% \\u179f\\u1798\\u17d2\\u179a\\u17b6\\u1794\\u17cb\\u178f\\u17c2\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6\\u1794\\u17c9\\u17bb\\u178e\\u17d2\\u178e\\u17c4\\u17c7 \\u178a\\u17c4\\u1799\\u1792\\u17b6\\u1793\\u17b6\\u1790\\u17b6\\u17a7\\u1794\\u179f\\u1782\\u17d2\\u1782\\u1795\\u17d2\\u1793\\u17c2\\u1780\\u17a0\\u17b7\\u179a\\u1789\\u17d2\\u1789\\u179c\\u178f\\u17d2\\u1790\\u17bb\\u1798\\u17b7\\u1793\\u178a\\u17c2\\u179b\\u179a\\u17b6\\u179a\\u17b6\\u17c6\\u1784\\u178a\\u179b\\u17cb\\u1780\\u17b6\\u179a\\u17a2\\u1794\\u17cb\\u179a\\u17c6\\u179b\\u17c6\\u178a\\u17b6\\u1794\\u17cb\\u1796\\u17b7\\u1797\\u1796\\u179b\\u17c4\\u1780\\u17a1\\u17be\\u1799\\u17d4 <\\/p><p>\\u178a\\u17c4\\u17c7\\u179f\\u17c4\\u179f\\u1780\\u17d2\\u178f\\u17b6\\u1793\\u17bb\\u1796\\u179b\\u179a\\u1794\\u179f\\u17cb\\u17a2\\u17d2\\u1793\\u1780 \\u1792\\u17d2\\u179c\\u17be\\u1787\\u17b6\\u1798\\u17d2\\u1785\\u17b6\\u179f\\u17cb\\u179b\\u17be\\u1787\\u17c6\\u1793\\u17b6\\u1789\\u1790\\u17d2\\u1784\\u17c3\\u179f\\u17d2\\u17a2\\u17c2\\u1780 \\u1793\\u17b7\\u1784\\u1794\\u1784\\u17d2\\u1780\\u17be\\u178f\\u17a2\\u1793\\u17b6\\u1782\\u178f\\u1793\\u17c3\\u1794\\u17d2\\u179a\\u1791\\u17c1\\u179f\\u1787\\u17b6\\u178f\\u17b7\\u179a\\u1794\\u179f\\u17cb\\u1799\\u17be\\u1784\\u178a\\u17c4\\u1799\\u1798\\u17b7\\u1793\\u1782\\u17b7\\u178f\\u1790\\u17d2\\u179b\\u17c3\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6\\u1791\\u17b6\\u17c6\\u1784\\u179f\\u17d2\\u179a\\u17bb\\u1784\\u17d4<\\/p>"},"footer_text":{"en":"Your journey to excellence starts here!","km":"\\u178a\\u17c6\\u178e\\u17be\\u179a\\u179a\\u1794\\u179f\\u17cb\\u17a2\\u17d2\\u1793\\u1780\\u1786\\u17d2\\u1796\\u17c4\\u17c7\\u1791\\u17c5\\u179a\\u1780\\u1797\\u17b6\\u1796\\u1786\\u17d2\\u1793\\u17be\\u1798\\u1785\\u17b6\\u1794\\u17cb\\u1795\\u17d2\\u178f\\u17be\\u1798\\u1796\\u17b8\\u1791\\u17b8\\u1793\\u17c1\\u17c7!"},"bg_image":"\\/storage\\/home\\/m98qskchpql9K8bBid5RA7nFChUG7rbzwa8atSiZ.jpg"}',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-24 03:17:02',
            ),
            23 => 
            array (
                'id' => 24,
                'key' => 'home_four_years',
            'value' => '[{"title":{"en":"Foundation year","km":"\\u1786\\u17d2\\u1793\\u17b6\\u17c6\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6\\u1798\\u17bc\\u179b\\u178a\\u17d2\\u178b\\u17b6\\u1793"},"description":{"en":"<p>Master strong specialized competencies and professional proficiency across diverse domains including Engineering, Law, Languages, Agriculture, Economics, and Technology utilizing modern tools and industry-standard workflows.<\\/p>","km":"<p>\\u1791\\u1791\\u17bd\\u179b\\u1794\\u17b6\\u1793\\u1785\\u17c6\\u178e\\u17c1\\u17c7\\u178a\\u17b9\\u1784 \\u1793\\u17b7\\u1784\\u1787\\u17c6\\u1793\\u17b6\\u1789\\u17af\\u1780\\u1791\\u17c1\\u179f\\u1799\\u17c9\\u17b6\\u1784\\u179a\\u17b9\\u1784\\u1798\\u17b6\\u17c6\\u178f\\u17b6\\u1798\\u1798\\u17bb\\u1781\\u179c\\u17b7\\u1787\\u17d2\\u1787\\u17b6\\u1785\\u17c6\\u178e\\u17b6\\u1793\\u17b8\\u1798\\u17bd\\u1799\\u17d7 \\u1798\\u17b7\\u1793\\u1790\\u17b6\\u1795\\u17d2\\u1793\\u17c2\\u1780 \\u179c\\u17b7\\u179f\\u17d2\\u179c\\u1780\\u1798\\u17d2\\u1798 \\u1785\\u17d2\\u1794\\u17b6\\u1794\\u17cb \\u1797\\u17b6\\u179f\\u17b6 \\u1780\\u179f\\u17b7\\u1780\\u1798\\u17d2\\u1798 \\u179f\\u17c1\\u178a\\u17d2\\u178b\\u1780\\u17b7\\u1785\\u17d2\\u1785 \\u17ac\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6 \\u1787\\u17b6\\u1798\\u17bd\\u1799\\u1780\\u17b6\\u179a\\u17a2\\u1793\\u17bb\\u179c\\u178f\\u17d2\\u178f\\u17a7\\u1794\\u1780\\u179a\\u178e\\u17cd \\u1793\\u17b7\\u1784\\u179c\\u17b7\\u1792\\u17b8\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u1792\\u17d2\\u179c\\u17be\\u1780\\u17b6\\u179a\\u1784\\u17b6\\u179a\\u1791\\u17c6\\u1793\\u17be\\u1794\\u17d7\\u178f\\u17b6\\u1798\\u179f\\u17d2\\u178f\\u1784\\u17cb\\u178a\\u17b6\\u179a\\u17a7\\u179f\\u17d2\\u179f\\u17b6\\u17a0\\u1780\\u1798\\u17d2\\u1798\\u17d4<\\/p>"}},{"title":{"en":"Second year","km":"\\u1786\\u17d2\\u1793\\u17b6\\u17c6\\u1791\\u17b8\\u17e2"},"description":{"en":"<p><span style=\\"background-color: rgb(255, 255, 255); color: rgb(100, 116, 139);\\">Develop critical thinking, research capabilities, and innovative problem-solving skills to tackle complex real-world organizational challenges through hands-on Project-Based Learning (PBL).<\\/span><\\/p>","km":"<p><span style=\\"background-color: rgb(255, 255, 255); color: rgb(100, 116, 139);\\">\\u17a2\\u1797\\u17b7\\u179c\\u178c\\u17d2\\u178d\\u179f\\u1798\\u178f\\u17d2\\u1790\\u1797\\u17b6\\u1796\\u1782\\u17b7\\u178f\\u179c\\u17b7\\u1797\\u17b6\\u1782\\u179f\\u17ca\\u17b8\\u1787\\u1798\\u17d2\\u179a\\u17c5 (Critical Thinking) \\u1780\\u17b6\\u179a\\u179f\\u17d2\\u179a\\u17b6\\u179c\\u1787\\u17d2\\u179a\\u17b6\\u179c \\u1793\\u17b7\\u1784\\u1780\\u17b6\\u179a\\u1785\\u17d2\\u1793\\u17c3\\u1794\\u17d2\\u179a\\u178c\\u17b7\\u178f\\u1793\\u179c\\u17b6\\u1793\\u17bb\\u179c\\u178f\\u17d2\\u178f\\u1793\\u17cd \\u178a\\u17be\\u1798\\u17d2\\u1794\\u17b8\\u178a\\u17c4\\u17c7\\u179f\\u17d2\\u179a\\u17b6\\u1799\\u1794\\u1789\\u17d2\\u17a0\\u17b6\\u1794\\u17d2\\u179a\\u1788\\u1798\\u179f\\u17d2\\u1798\\u17bb\\u1782\\u179f\\u17d2\\u1798\\u17b6\\u1789\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u179f\\u17d2\\u1790\\u17b6\\u1794\\u17d0\\u1793 \\u178f\\u17b6\\u1798\\u179a\\u1799\\u17c8\\u1780\\u17b6\\u179a\\u179a\\u17c0\\u1793\\u179f\\u17bc\\u178f\\u17d2\\u179a\\u1795\\u17d2\\u17a2\\u17c2\\u1780\\u179b\\u17be\\u1782\\u1798\\u17d2\\u179a\\u17c4\\u1784 (Project-Based Learning - PBL)\\u17d4<\\/span><\\/p>"}},{"title":{"en":"Third year","km":"\\u1786\\u17d2\\u1793\\u17b6\\u17c6\\u1791\\u17b8\\u17e3"},"description":{"en":"<p><span style=\\"background-color: rgb(255, 255, 255); color: rgb(100, 116, 139);\\">Gain full workforce readiness through direct industry immersion, specialized lab\\/studio training, cross-disciplinary projects, and practical internships with key sector partners.<\\/span><\\/p>","km":"<p><span style=\\"background-color: rgb(255, 255, 255); color: rgb(100, 116, 139);\\">\\u1791\\u1791\\u17bd\\u179b\\u1794\\u17b6\\u1793\\u1794\\u1791\\u1796\\u17b7\\u179f\\u17c4\\u1792\\u1793\\u17cd\\u1792\\u17d2\\u179c\\u17be\\u1780\\u17b6\\u179a\\u1784\\u17b6\\u179a\\u1787\\u17b6\\u1780\\u17cb\\u179f\\u17d2\\u178f\\u17c2\\u1784 \\u178f\\u17b6\\u1798\\u179a\\u1799\\u17c8\\u1780\\u17b6\\u179a\\u17a2\\u1793\\u17bb\\u179c\\u178f\\u17d2\\u178f\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1794\\u1793\\u17d2\\u1791\\u1794\\u17cb\\u1796\\u17b7\\u179f\\u17c4\\u1792\\u1793\\u17cd\\/\\u179f\\u17d2\\u1791\\u17bc\\u178c\\u17b8\\u1799\\u17c4 \\u1780\\u17b6\\u179a\\u1792\\u17d2\\u179c\\u17be\\u1782\\u1798\\u17d2\\u179a\\u17c4\\u1784\\u17a2\\u1793\\u17d2\\u178f\\u179a\\u1787\\u17c6\\u1793\\u17b6\\u1789 \\u1793\\u17b7\\u1784\\u1780\\u17b6\\u179a\\u1785\\u17bb\\u17c7\\u1780\\u1798\\u17d2\\u1798\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6 (Internship) \\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1780\\u17d2\\u179a\\u17bb\\u1798\\u17a0\\u17ca\\u17bb\\u1793 \\u17ac\\u179f\\u17d2\\u1790\\u17b6\\u1794\\u17d0\\u1793\\u178a\\u17c3\\u1782\\u17bc \\u178a\\u17c2\\u179b\\u178f\\u17d2\\u179a\\u17c0\\u1798\\u1781\\u17d2\\u179b\\u17bd\\u1793\\u1785\\u17bc\\u179b\\u1792\\u17d2\\u179c\\u17be\\u1780\\u17b6\\u179a\\u1794\\u17b6\\u1793\\u1797\\u17d2\\u179b\\u17b6\\u1798\\u17d7\\u17d4<\\/span><\\/p>"}},{"title":{"en":"Last year","km":"\\u1786\\u17d2\\u1793\\u17b6\\u17c6\\u1794\\u1789\\u17d2\\u1785\\u1794\\u17cb"},"description":{"en":"<p>Emerge as ethically grounded professional leaders equipped with strong communication skills, social responsibility, and the adaptability to drive transformation in a digital society.<\\/p>","km":"<p>\\u178f\\u17d2\\u179a\\u17c0\\u1798\\u1781\\u17d2\\u179b\\u17bd\\u1793\\u1780\\u17d2\\u179b\\u17b6\\u1799\\u1787\\u17b6\\u17a2\\u17d2\\u1793\\u1780\\u178a\\u17b9\\u1780\\u1793\\u17b6\\u17c6 \\u1793\\u17b7\\u1784\\u1787\\u17b6\\u17a2\\u17d2\\u1793\\u1780\\u1787\\u17c6\\u1793\\u17b6\\u1789\\u1794\\u17d2\\u179a\\u1780\\u1794\\u178a\\u17c4\\u1799\\u179f\\u17b8\\u179b\\u1792\\u1798\\u17cc\\u179c\\u17b7\\u1787\\u17d2\\u1787\\u17b6\\u1787\\u17b8\\u179c\\u17c8\\u1781\\u17d2\\u1796\\u179f\\u17cb \\u1780\\u17b6\\u179a\\u1791\\u1791\\u17bd\\u179b\\u1781\\u17bb\\u179f\\u178f\\u17d2\\u179a\\u17bc\\u179c \\u1787\\u17c6\\u1793\\u17b6\\u1789\\u1791\\u17c6\\u1793\\u17b6\\u1780\\u17cb\\u1791\\u17c6\\u1793\\u1784\\u17a2\\u1793\\u17d2\\u178f\\u179a\\u1794\\u17bb\\u1782\\u17d2\\u1782\\u179b \\u1793\\u17b7\\u1784\\u179f\\u1798\\u178f\\u17d2\\u1790\\u1797\\u17b6\\u1796\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1780\\u17b6\\u179a\\u179f\\u1798\\u17d2\\u179a\\u1794\\u1781\\u17d2\\u179b\\u17bd\\u1793\\u1791\\u17c5\\u1793\\u17b9\\u1784\\u1780\\u17b6\\u179a\\u1795\\u17d2\\u179b\\u17b6\\u179f\\u17cb\\u1794\\u17d2\\u178f\\u17bc\\u179a\\u1793\\u17c3\\u179f\\u1784\\u17d2\\u1782\\u1798\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u17d4<\\/p>"}}]',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-21 01:13:46',
            ),
            24 => 
            array (
                'id' => 25,
                'key' => 'home_video_url',
                'value' => 'https://youtu.be/zB7gSnf1gys?si=8jatfeGX1VB3wAmA',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-21 01:19:46',
            ),
            25 => 
            array (
                'id' => 26,
                'key' => 'home_video_bg_image',
                'value' => '/storage/home/wN3W4xVTjjRDRJTYTeC9bMSRNomWj2ZTWlrCfMyB.jpg',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-20 10:01:26',
            ),
            26 => 
            array (
                'id' => 27,
                'key' => 'home_video_bg_color',
                'value' => '#0f2154',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-07-21 08:54:20',
            ),
            27 => 
            array (
                'id' => 28,
                'key' => 'home_activities_slides',
                'value' => '[{"img":"\\/storage\\/home\\/QTHk2zbwUnAvM58TaOw6EKRPDeQn0SZaBSFfzfze.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/LK8iI028NtI74PxCCQFhdGv2bDlU6v5vKUvAvHYO.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/lTlfbrMA0zbns2t9lHhZ8cYYMJaDYal20jMwMvaJ.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/xgYEHjrOoQdQW94LOMuqTH8AAbIJexgnQER8Qkot.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/Vbq8OqTEzNXWqwXo4cWyyc1S2sQYc9sf1oo8sS9E.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/IM0LTgHSHBrzyuxBvzqqPbNueJUMnFhcITeyk6TC.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/sGICuq7M06PL2OSYPSsUuAQXGTgHeWTOqbOLBMA7.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/mVZn8dkAtIWuLKdPR0T5y2utW9kvrPR1KMa0ZRFe.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/7t80f5seaFUZMun3vtNa2Oskh98rMJftpHDYAquP.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/mY5ZH2kdV0DaYOFvGT1v6utVSoHoVTsbTvPJp9Rd.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/dSm1J28PhvV5tIt1B1TyIh45YqeCUkFCV5tAlO8Y.jpg","alt":{"en":null,"km":null}},{"img":"\\/storage\\/home\\/hp01dbMxswKLQCm9O7WUxWZOJl122P2UmyzWRI6A.jpg","alt":{"en":null,"km":null}},{"img":null,"alt":{"en":null,"km":null}}]',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-21 01:13:46',
            ),
            28 => 
            array (
                'id' => 29,
                'key' => 'home_graduate_attributes',
                'value' => '{"title":{"en":"Graduate Attributes","km":"\\u1782\\u17bb\\u178e\\u179c\\u17bb\\u178c\\u17d2\\u178d\\u17b7\\u179a\\u1794\\u179f\\u17cb\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u1794\\u1789\\u17d2\\u1785\\u1794\\u17cb\\u1780\\u17b6\\u179a\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6"},"cards":[{"title":{"en":"Knowledge & Professionalism","km":"\\u1785\\u17c6\\u178e\\u17c1\\u17c7\\u178a\\u17b9\\u1784 \\u1793\\u17b7\\u1784\\u179c\\u17b7\\u1787\\u17d2\\u1787\\u17b6\\u1787\\u17b8\\u179c\\u17c8"},"description":{"en":"Communicate effectively with the body of knowledge that underpins professional practice.","km":"\\u1791\\u17c6\\u1793\\u17b6\\u1780\\u17cb\\u1791\\u17c6\\u1793\\u1784\\u1794\\u17d2\\u179a\\u1780\\u1794\\u178a\\u17c4\\u1799\\u1794\\u17d2\\u179a\\u179f\\u17b7\\u1791\\u17d2\\u1792\\u1797\\u17b6\\u1796\\u1787\\u17b6\\u1798\\u17bd\\u1799\\u179f\\u17d2\\u1790\\u17b6\\u1794\\u17d0\\u1793\\u1785\\u17c6\\u178e\\u17c1\\u17c7\\u178a\\u17b9\\u1784\\u178a\\u17c2\\u179b\\u1787\\u17b6\\u1798\\u17bc\\u179b\\u178a\\u17d2\\u178b\\u17b6\\u1793\\u1782\\u17d2\\u179a\\u17b9\\u17c7\\u1793\\u17c3\\u1780\\u17b6\\u179a\\u17a2\\u1793\\u17bb\\u179c\\u178f\\u17d2\\u178f\\u179c\\u17b7\\u1787\\u17d2\\u1787\\u17b6\\u1787\\u17b8\\u179c\\u17c8\\u17d4"},"image":null},{"title":{"en":"Active Learning","km":"\\u1780\\u17b6\\u179a\\u179a\\u17c0\\u1793\\u179f\\u17bc\\u178f\\u17d2\\u179a\\u179f\\u1780\\u1798\\u17d2\\u1798"},"description":{"en":"The beautiful thing about learning is that no one can take it away from you \\u2014 but the magical thing about active learning is that you own what you build.","km":"\\u179a\\u17bf\\u1784\\u178a\\u17cf\\u179f\\u17d2\\u179a\\u179f\\u17cb\\u179f\\u17d2\\u17a2\\u17b6\\u178f\\u17a2\\u17c6\\u1796\\u17b8\\u1780\\u17b6\\u179a\\u179a\\u17c0\\u1793\\u179f\\u17bc\\u178f\\u17d2\\u179a \\u1782\\u17ba\\u1790\\u17b6\\u1782\\u17d2\\u1798\\u17b6\\u1793\\u1793\\u179a\\u178e\\u17b6\\u1798\\u17d2\\u1793\\u17b6\\u1780\\u17cb\\u17a2\\u17b6\\u1785\\u1799\\u1780\\u179c\\u17b6\\u1785\\u17c1\\u1789\\u1796\\u17b8\\u17a2\\u17d2\\u1793\\u1780\\u1794\\u17b6\\u1793\\u17a1\\u17be\\u1799 \\u2014 \\u1794\\u17c9\\u17bb\\u1793\\u17d2\\u178f\\u17c2\\u179a\\u17bf\\u1784\\u178a\\u17cf\\u17a2\\u179f\\u17d2\\u1785\\u17b6\\u179a\\u17d2\\u1799\\u17a2\\u17c6\\u1796\\u17b8\\u1780\\u17b6\\u179a\\u179a\\u17c0\\u1793\\u179f\\u17bc\\u178f\\u17d2\\u179a\\u1799\\u17c9\\u17b6\\u1784\\u179f\\u1780\\u1798\\u17d2\\u1798 \\u1782\\u17ba\\u1790\\u17b6\\u17a2\\u17d2\\u1793\\u1780\\u1787\\u17b6\\u1798\\u17d2\\u1785\\u17b6\\u179f\\u17cb\\u179b\\u17be\\u17a2\\u17d2\\u179c\\u17b8\\u178a\\u17c2\\u179b\\u17a2\\u17d2\\u1793\\u1780\\u1794\\u17b6\\u1793\\u1780\\u179f\\u17b6\\u1784\\u17d4"},"image":null},{"title":{"en":"Communication & Teamwork","km":"\\u1780\\u17b6\\u179a\\u1791\\u17c6\\u1793\\u17b6\\u1780\\u17cb\\u1791\\u17c6\\u1793\\u1784 \\u1793\\u17b7\\u1784\\u1780\\u17b6\\u179a\\u1784\\u17b6\\u179a\\u1787\\u17b6\\u1780\\u17d2\\u179a\\u17bb\\u1798"},"description":{"en":"Have enhanced cultural, social, and ethical awareness as engaged members of the community.","km":"\\u1798\\u17b6\\u1793\\u1780\\u17b6\\u179a\\u1799\\u179b\\u17cb\\u178a\\u17b9\\u1784\\u1780\\u17b6\\u1793\\u17cb\\u178f\\u17c2\\u1785\\u17d2\\u1794\\u17b6\\u179f\\u17cb\\u17a2\\u17c6\\u1796\\u17b8\\u179c\\u1794\\u17d2\\u1794\\u1792\\u1798\\u17cc \\u179f\\u1784\\u17d2\\u1782\\u1798 \\u1793\\u17b7\\u1784\\u179f\\u17b8\\u179b\\u1792\\u1798\\u17cc\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1793\\u17b6\\u1798\\u1787\\u17b6\\u179f\\u1798\\u17b6\\u1787\\u17b7\\u1780\\u178a\\u17c2\\u179b\\u1785\\u17bc\\u179b\\u179a\\u17bd\\u1798\\u1799\\u17c9\\u17b6\\u1784\\u179f\\u1780\\u1798\\u17d2\\u1798\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u179f\\u17a0\\u1782\\u1798\\u1793\\u17cd\\u17d4"},"image":"\\/storage\\/home\\/Tm7T7m0KmK9dNK7sAiVUH0GbEMpdZrcOVsqo7lkP.jpg"}]}',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-21 01:19:46',
            ),
            29 => 
            array (
                'id' => 30,
                'key' => 'home_stats',
                'value' => '[{"value":"1","label":{"en":"University Campus","km":"\\u1791\\u17b8\\u178f\\u17b6\\u17c6\\u1784\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799"},"icon":"building"},{"value":"1000+","label":{"en":"Active Students","km":"\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u179f\\u179a\\u17bb\\u1794"},"icon":"student"},{"value":"1200+","label":{"en":"Computers & IT Devices","km":"\\u1780\\u17bb\\u17c6\\u1796\\u17d2\\u1799\\u17bc\\u1791\\u17d0\\u179a & \\u17a7\\u1794\\u1780\\u179a\\u178e\\u17cd"},"icon":"computer"},{"value":"50+","label":{"en":"Professors & Lecturers","km":"\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u17b6\\u1785\\u17b6\\u179a\\u17d2\\u1799 & \\u1794\\u17bb\\u1782\\u17d2\\u1782\\u179b\\u17b7\\u1780"},"icon":"user"}]',
                'created_at' => '2026-07-21 08:54:20',
                'updated_at' => '2026-08-03 08:24:18',
            ),
            30 => 
            array (
                'id' => 31,
                'key' => 'contact_hero_title',
                'value' => '{"en":"Contact Us","km":"ទាក់ទងមកយើង"}',
                'created_at' => '2026-08-20 03:55:14',
                'updated_at' => '2026-08-27 02:37:54',
            ),
            31 => 
            array (
                'id' => 32,
                'key' => 'contact_hero_description',
                'value' => '{"en":"Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.","km":"តើអ្នកមានសំណួរអំពីការចូលរៀន កម្មវិធីសិក្សា ឬជីវិតក្នុងបរិវេណសាលាដែរឬទេ? សូមទាក់ទងមកយើង ហើយក្រុមការងាររបស់យើងនឹងឆ្លើយតបទៅកាន់អ្នកវិញក្នុងពេលឆាប់ៗនេះ។"}',
                'created_at' => '2026-08-20 03:55:14',
                'updated_at' => '2026-08-27 02:37:54',
            ),
            32 => 
            array (
                'id' => 33,
                'key' => 'footer_label_quick_links',
                'value' => '{"en":"Our Details","km":"Our Details"}',
                'created_at' => '2026-08-20 04:07:59',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            33 => 
            array (
                'id' => 34,
                'key' => 'footer_label_working_hours',
                'value' => '{"en":"Working Hours","km":"Working Hours"}',
                'created_at' => '2026-08-20 04:07:59',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            34 => 
            array (
                'id' => 35,
                'key' => 'footer_label_social_media',
                'value' => '{"en":"Social Media","km":"Social Media"}',
                'created_at' => '2026-08-20 04:07:59',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            35 => 
            array (
                'id' => 36,
                'key' => 'footer_label_contact_info',
                'value' => '{"en":"Contact Information","km":"Contact Information"}',
                'created_at' => '2026-08-20 04:07:59',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            36 => 
            array (
                'id' => 37,
                'key' => 'footer_label_direct_lines',
                'value' => '{"en":"Direct Lines","km":"Direct Lines"}',
                'created_at' => '2026-08-20 04:07:59',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            37 => 
            array (
                'id' => 38,
                'key' => 'footer_map_url',
                'value' => 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1518.5686343584584!2d104.76673604474675!3d11.416249673060195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2skh!4v1783649287380!5m2!1sen!2skh',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-20 04:11:36',
            ),
            38 => 
            array (
                'id' => 39,
                'key' => 'footer_map_label',
                'value' => '{"en":"Phnom Penh Campus","km":null}',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            39 => 
            array (
                'id' => 40,
                'key' => 'footer_working_hours_weekday_label',
                'value' => '{"en":"Mon - Sat","km":"\\u1790\\u17d2\\u1784\\u17c3\\u1785\\u1793\\u17d2\\u1791 - \\u1790\\u17d2\\u1784\\u17c3\\u179f\\u17c5\\u179a\\u17cd"}',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            40 => 
            array (
                'id' => 41,
                'key' => 'footer_working_hours_weekday_time',
                'value' => '{"en":"8:00 AM - 12:00 PM","km":"8:00 AM - 12:00 PM"}',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-25 02:29:57',
            ),
            41 => 
            array (
                'id' => 42,
                'key' => 'footer_working_hours_weekend_label',
                'value' => '{"en":"Weekend","km":"\\u1785\\u17bb\\u1784\\u179f\\u1794\\u17d2\\u178f\\u17b6\\u17a0\\u17cd"}',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-20 07:07:42',
            ),
            42 => 
            array (
                'id' => 43,
                'key' => 'footer_working_hours_weekend_time',
                'value' => '{"en":"8:00 AM - 12:00 PM","km":"8:00 AM - 12:00 PM"}',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-25 02:29:57',
            ),
            43 => 
            array (
                'id' => 44,
                'key' => 'footer_quick_links',
                'value' => '[{"label":{"en":"About","km":"\\u17a2\\u17c6\\u1796\\u17b8"},"href":"\\/about"},{"label":{"en":"Scholarship","km":"\\u17a2\\u17b6\\u17a0\\u17b6\\u179a\\u17bc\\u1794\\u1780\\u179a\\u178e\\u17cd"},"href":"\\/scholarship"},{"label":{"en":"Faculties","km":"\\u1798\\u17a0\\u17b6\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799"},"href":"\\/faculties"}]',
                'created_at' => '2026-08-20 04:11:36',
                'updated_at' => '2026-08-25 02:34:47',
            ),
            44 => 
            array (
                'id' => 45,
                'key' => 'videos_list',
            'value' => '[{"type":"youtube","url":"https:\\/\\/youtu.be\\/d6TCRRJDstQ?si=hq4TWgpnSvcj9uKw","file":null,"title":{"en":"Sabay nas mak","km":"\\u1785\\u17c6\\u178e\\u1784\\u1787\\u17be\\u1784\\u179c\\u17b8\\u178a\\u17c1\\u17a2\\u17bc\\u1790\\u17d2\\u1798\\u17b8"},"description":{"en":"<p>Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.<\\/p>","km":"<p>\\u178f\\u17be\\u17a2\\u17d2\\u1793\\u1780\\u1798\\u17b6\\u1793\\u179f\\u17c6\\u178e\\u17bd\\u179a\\u17a2\\u17c6\\u1796\\u17b8\\u1780\\u17b6\\u179a\\u1785\\u17bc\\u179b\\u179a\\u17c0\\u1793 \\u1780\\u1798\\u17d2\\u1798\\u179c\\u17b7\\u1792\\u17b8\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6 \\u17ac\\u1787\\u17b8\\u179c\\u17b7\\u178f\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1794\\u179a\\u17b7\\u179c\\u17c1\\u178e\\u179f\\u17b6\\u179b\\u17b6\\u178a\\u17c2\\u179a\\u17ac\\u1791\\u17c1? \\u179f\\u17bc\\u1798\\u1791\\u17b6\\u1780\\u17cb\\u1791\\u1784\\u1798\\u1780\\u1799\\u17be\\u1784 \\u17a0\\u17be\\u1799\\u1780\\u17d2\\u179a\\u17bb\\u1798\\u1780\\u17b6\\u179a\\u1784\\u17b6\\u179a\\u179a\\u1794\\u179f\\u17cb\\u1799\\u17be\\u1784\\u1793\\u17b9\\u1784\\u1786\\u17d2\\u179b\\u17be\\u1799\\u178f\\u1794\\u1791\\u17c5\\u1780\\u17b6\\u1793\\u17cb\\u17a2\\u17d2\\u1793\\u1780\\u179c\\u17b7\\u1789\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1796\\u17c1\\u179b\\u1786\\u17b6\\u1794\\u17cb\\u17d7\\u1793\\u17c1\\u17c7\\u17d4<\\/p>"}},{"type":"file","url":"\\/storage\\/videos\\/HvIOw0iFxhLufDcGlQbN36aIbcPMyeh7PcX8T7SC.mp4","file":null,"title":{"en":"Barack Obama","km":"\\u1794\\u17b6\\u179a\\u17c9\\u17b6\\u1780\\u17cb \\u17a2\\u17bc\\u1794\\u17b6\\u1798\\u17c9\\u17b6"},"description":{"en":"<p><span style=\\"background-color: rgb(255, 255, 255); color: rgb(100, 116, 139);\\">Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.<\\/span><\\/p>","km":"<p>\\u178f\\u17be\\u17a2\\u17d2\\u1793\\u1780\\u1798\\u17b6\\u1793\\u179f\\u17c6\\u178e\\u17bd\\u179a\\u17a2\\u17c6\\u1796\\u17b8\\u1780\\u17b6\\u179a\\u1785\\u17bc\\u179b\\u179a\\u17c0\\u1793 \\u1780\\u1798\\u17d2\\u1798\\u179c\\u17b7\\u1792\\u17b8\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6 \\u17ac\\u1787\\u17b8\\u179c\\u17b7\\u178f\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1794\\u179a\\u17b7\\u179c\\u17c1\\u178e\\u179f\\u17b6\\u179b\\u17b6\\u178a\\u17c2\\u179a\\u17ac\\u1791\\u17c1? \\u179f\\u17bc\\u1798\\u1791\\u17b6\\u1780\\u17cb\\u1791\\u1784\\u1798\\u1780\\u1799\\u17be\\u1784 \\u17a0\\u17be\\u1799\\u1780\\u17d2\\u179a\\u17bb\\u1798\\u1780\\u17b6\\u179a\\u1784\\u17b6\\u179a\\u179a\\u1794\\u179f\\u17cb\\u1799\\u17be\\u1784\\u1793\\u17b9\\u1784\\u1786\\u17d2\\u179b\\u17be\\u1799\\u178f\\u1794\\u1791\\u17c5\\u1780\\u17b6\\u1793\\u17cb\\u17a2\\u17d2\\u1793\\u1780\\u179c\\u17b7\\u1789\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1796\\u17c1\\u179b\\u1786\\u17b6\\u1794\\u17cb\\u17d7\\u1793\\u17c1\\u17c7\\u17d4<\\/p>"}},{"type":"youtube","url":"https:\\/\\/youtu.be\\/zB7gSnf1gys?si=QLRlo3wCndq2PEJI","file":null,"title":{"en":"Video youtube","km":"\\u179c\\u17b8\\u178a\\u17c1\\u17a2\\u17bc\\u1799\\u17bc\\u1792\\u17bc\\u1794"},"description":{"en":"<p><span style=\\"background-color: rgb(255, 255, 255); color: rgb(100, 116, 139);\\">Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.<\\/span><\\/p>","km":"<p>\\u178f\\u17be\\u17a2\\u17d2\\u1793\\u1780\\u1798\\u17b6\\u1793\\u179f\\u17c6\\u178e\\u17bd\\u179a\\u17a2\\u17c6\\u1796\\u17b8\\u1780\\u17b6\\u179a\\u1785\\u17bc\\u179b\\u179a\\u17c0\\u1793 \\u1780\\u1798\\u17d2\\u1798\\u179c\\u17b7\\u1792\\u17b8\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6 \\u17ac\\u1787\\u17b8\\u179c\\u17b7\\u178f\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1794\\u179a\\u17b7\\u179c\\u17c1\\u178e\\u179f\\u17b6\\u179b\\u17b6\\u178a\\u17c2\\u179a\\u17ac\\u1791\\u17c1? \\u179f\\u17bc\\u1798\\u1791\\u17b6\\u1780\\u17cb\\u1791\\u1784\\u1798\\u1780\\u1799\\u17be\\u1784 \\u17a0\\u17be\\u1799\\u1780\\u17d2\\u179a\\u17bb\\u1798\\u1780\\u17b6\\u179a\\u1784\\u17b6\\u179a\\u179a\\u1794\\u179f\\u17cb\\u1799\\u17be\\u1784\\u1793\\u17b9\\u1784\\u1786\\u17d2\\u179b\\u17be\\u1799\\u178f\\u1794\\u1791\\u17c5\\u1780\\u17b6\\u1793\\u17cb\\u17a2\\u17d2\\u1793\\u1780\\u179c\\u17b7\\u1789\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1796\\u17c1\\u179b\\u1786\\u17b6\\u1794\\u17cb\\u17d7\\u1793\\u17c1\\u17c7\\u17d4<\\/p>"}}]',
                'created_at' => '2026-08-20 08:26:56',
                'updated_at' => '2026-08-20 09:49:53',
            ),
            45 => 
            array (
                'id' => 46,
                'key' => 'scholarship_documents',
                'value' => '[{"title":{"km":"ទំព័រទី ១៖ សេចក្តីជូនដំណឹង និងមហាវិទ្យាល័យ","en":"Page 1: Scholarship Announcement & Eligible Faculties"},"src":"\\/images\\/scholarship\\/scholarship-doc-1.png"},{"title":{"km":"ទំព័រទី ២៖ លក្ខខណ្ឌ និងឯកសារភ្ជាប់","en":"Page 2: Application Conditions & Required Documents"},"src":"\\/images\\/scholarship\\/scholarship-doc-2.png"},{"title":{"km":"ទំព័រទី ៣៖ ការទំនាក់ទំនង និង QR Codes","en":"Page 3: Contact Details & QR Code Portals"},"src":"\\/images\\/scholarship\\/scholarship-doc-3.png"}]',
                'created_at' => '2026-08-21 03:11:38',
                'updated_at' => '2026-08-21 03:11:38',
            ),
            46 => 
            array (
                'id' => 47,
                'key' => 'scholarship_requirements',
                'value' => '[{"no":"1","name":{"km":"ពាក្យសុំអាហារូបករណ៍","en":"Scholarship Form"},"qty":{"km":"១ច្បាប់","en":"1 Copy"}},{"no":"2","name":{"km":"រូបថតបច្ចុប្បន្ន ៤x៦","en":"4x6 Photos"},"qty":{"km":"៦ច្បាប់","en":"6 Copies"}},{"no":"3","name":{"km":"សញ្ញាបត្រមធ្យមសិក្សាទុតិយភូមិ ឬលិខិតបញ្ជាក់","en":"High School Diploma"},"qty":{"km":"១ច្បាប់","en":"1 Copy"}},{"no":"4","name":{"km":"សំបុត្រកំណើត","en":"Birth Certificate"},"qty":{"km":"១ច្បាប់","en":"1 Copy"}},{"no":"5","name":{"km":"អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ","en":"Identity Card"},"qty":{"km":"១ច្បាប់","en":"1 Copy"}},{"no":"6","name":{"km":"សៀវភៅគ្រួសារ ឬសៀវភៅស្នាក់នៅ","en":"Family \\/ Residence Book"},"qty":{"km":"១ច្បាប់","en":"1 Copy"}},{"no":"7","name":{"km":"លិខិតបញ្ជាក់ការសិក្សា ឬលិខិតកោតសរសើរ","en":"Recommendation \\/ Transcript"},"qty":{"km":"១ច្បាប់","en":"1 Copy"}}]',
                'created_at' => '2026-08-21 03:11:39',
                'updated_at' => '2026-08-21 06:33:23',
            ),
            47 => 
            array (
                'id' => 48,
                'key' => 'scholarship_portals',
                'value' => '[{"title":{"km":"ពាក្យស្នើសុំអាហារូបករណ៍","en":"Scholarship Form"},"link":"https:\\/\\/t.me\\/Digitaluniversityofcambodia1","desc":{"km":"ដាក់ពាក្យស្នើសុំអាហារូបករណ៍","en":"Apply for Scholarship"},"svg":"<svg class=\\"w-6 h-6 text-teal-600\\" fill=\\"none\\" stroke=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\" stroke-width=\\"2\\" d=\\"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\\"\\/><\\/svg>"},{"title":{"km":"ឆានែលតេឡេក្រាម","en":"Telegram Channel"},"link":"https:\\/\\/t.me\\/Digitaluniversityofcambodia1","desc":{"km":"ឆានែលព័ត៌មានផ្លូវការ","en":"Official Info Channel"},"svg":"<svg class=\\"w-6 h-6 text-sky-500\\" fill=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path d=\\"M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.56 8.16l-1.97 9.28c-.15.67-.54.83-1.1.52l-3.04-2.24-1.47 1.41c-.16.16-.3.3-.61.3l.22-3.1 5.64-5.1c.25-.22-.05-.34-.38-.12l-6.97 4.39-3.01-.94c-.65-.2-.67-.65.14-.97l11.76-4.53c.54-.2 1.02.13.79 1.1z\\"\\/><\\/svg>"},{"title":{"km":"ទំព័រហ្វេសប៊ុក","en":"Facebook Page"},"link":"https:\\/\\/www.facebook.com\\/DUCambodia\\/","desc":{"km":"ទំព័រហ្វេសប៊ុកផ្លូវការ","en":"Official Facebook Page"},"svg":"<svg class=\\"w-6 h-6 text-blue-600\\" fill=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path d=\\"M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z\\"\\/><\\/svg>"},{"title":{"km":"ឆានែលយូធូប","en":"YouTube Channel"},"link":"https:\\/\\/www.youtube.com\\/@DUCambodia","desc":{"km":"វីដេអូសកម្មភាពនិស្សិត","en":"Student Activities Video"},"svg":"<svg class=\\"w-6 h-6 text-red-600\\" fill=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path d=\\"M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z\\"\\/><\\/svg>"},{"title":{"km":"ទីកតុក","en":"TikTok"},"link":"https:\\/\\/www.tiktok.com\\/@ducambodia","desc":{"km":"វីដេអូខ្លីៗបច្ចេកវិទ្យា","en":"Short Tech Videos"},"svg":"<svg class=\\"w-6 h-6 text-slate-900\\" fill=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path d=\\"M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.56-1.31 1.52-1.31 2.52.02 1.14.67 2.18 1.68 2.67.97.46 2.14.39 3.03-.18.84-.53 1.34-1.49 1.34-2.48.03-5.46.01-10.92.02-16.38z\\"\\/><\\/svg>"},{"title":{"km":"ផែនទី Google Map","en":"Google Map"},"link":"https:\\/\\/maps.app.goo.gl\\/mVhjigcdBs16J7kBA","desc":{"km":"ទីតាំងសាកលវិទ្យាល័យ","en":"University Location"},"svg":"<svg class=\\"w-6 h-6 text-red-500\\" fill=\\"none\\" stroke=\\"currentColor\\" viewBox=\\"0 0 24 24\\"><path stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\" stroke-width=\\"2\\" d=\\"M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z\\"\\/><path stroke-linecap=\\"round\\" stroke-linejoin=\\"round\\" stroke-width=\\"2\\" d=\\"M15 11a3 3 0 11-6 0 3 3 0 016 0z\\"\\/><\\/svg>"}]',
                'created_at' => '2026-08-21 03:11:39',
                'updated_at' => '2026-08-21 06:28:44',
            ),
            48 => 
            array (
                'id' => 49,
                'key' => 'scholarship_benefits',
                'value' => '{"title":{"km":"អត្ថប្រយោជន៍ទទួលបានពីអាហារូបករណ៍","en":"Privilege & Benefits"},"items":[{"text":{"km":"ទទួលបានអាហារូបករណ៍ ១០០% ពេញលេញ សម្រាប់ការសិក្សាថ្នាក់បរិញ្ញាបត្រ។","en":"Get a 100% full scholarship for bachelor degree."}},{"text":{"km":"បានសិក្សាក្នុងបន្ទប់ម៉ាស៊ីនត្រជាក់ ជាមួយឧបករណ៍បច្ចេកវិទ្យាទំនើបៗ និងប្រព័ន្ធ E-Learning។","en":"Study in A\\/C rooms with modern tech devices and E-Learning system."}},{"text":{"km":"ទទួលបានការបណ្តុះបណ្តាលជំនាញឌីជីថលបន្ថែម និងភាសាអង់គ្លេសកម្រិតខ្ពស់។","en":"Receive additional digital skills training and advanced English language."}},{"text":{"km":"មានឱកាសទទួលបានការចុះកម្មសិក្សា ការចុះអនុវត្តការងារផ្ទាល់ និងឱកាសការងារក្រោយបញ្ចប់ការសិក្សា។","en":"Have the opportunity to get internships, hands-on practice, and jobs."}}]}',
                'created_at' => '2026-08-21 03:11:39',
                'updated_at' => '2026-08-21 03:11:39',
            ),
            49 => 
            array (
                'id' => 50,
                'key' => 'scholarship_hero',
                'value' => '{"badge":{"km":"អាហារូបករណ៍ ១០០% ថ្នាក់បរិញ្ញាបត្រ និង ថ្នាក់បរិញ្ញាបត្ររង • ឆ្នាំសិក្សា ២០២៤-២០២៥","en":"100% Bachelor Degree And Associate Degree Scholarship​​​ • Academic Year 2024-2025"},"title":{"km":"សេចក្តីជូនដំណឹង អាហារូបករណ៍ ១០០%","en":"100% Scholarship Announcement"},"description":{"km":"ការជ្រើសរើសនិស្សិតអាហារូបករណ៍ថ្នាក់បរិញ្ញាបត្រ នៅសាកលវិទ្យាល័យឌីជីថលកម្ពុជា","en":"Bachelor Degree Scholarship Recruitment at Digital University of Cambodia"},"doc_button":{"km":"មើលលិខិតផ្លូវការ","en":"View Official Documents"},"official_doc_title":{"km":"លិខិតប្រកាសអាហារូបករណ៍ផ្លូវការ","en":"Official Scholarship Announcement Document"},"click_to_zoom":{"km":"ចុចលើរូបភាពដើម្បីពង្រីកមើលលម្អិត","en":"Click any document to view in high resolution"},"apply_telegram":{"km":"ដាក់ពាក្យតាម Telegram","en":"Apply via Telegram"},"req_docs_title":{"km":"សំណុំឯកសារភ្ជាប់សម្រាប់ស្នើសុំអាហារូបករណ៍","en":"Required Documents for Scholarship Application"},"table_no":{"km":"ល.រ","en":"No."},"table_doc_name":{"km":"ឈ្មោះឯកសារ","en":"Document Name"},"table_qty":{"km":"ចំនួន","en":"Qty"},"all_pages":{"km":"ទំព័រទាំង ៣ នៃសេចក្តីជូនដំណឹង៖","en":"All 3 pages of the announcement:"},"page":{"km":"ទំព័រ","en":"Page"},"of":{"km":"នៃ","en":"of"},"close":{"km":"បិទ","en":"Close"},"zoom_document":{"km":"ពង្រីករូបភាព","en":"Zoom Document"}}',
                'created_at' => '2026-08-21 03:17:22',
                'updated_at' => '2026-08-21 09:19:15',
            ),
            50 => 
            array (
                'id' => 51,
                'key' => 'contact_form_title',
                'value' => '{"en":"Send Us a Message","km":"\\u1795\\u17d2\\u1789\\u17be\\u179f\\u17b6\\u179a\\u1798\\u1780\\u1780\\u17b6\\u1793\\u17cb\\u1799\\u17be\\u1784"}',
                'created_at' => '2026-08-22 08:19:45',
                'updated_at' => '2026-08-22 08:19:45',
            ),
            51 => 
            array (
                'id' => 52,
                'key' => 'contact_form_name_label',
                'value' => '{"en":"Full Name *","km":"\\u1788\\u17d2\\u1798\\u17c4\\u17c7\\u1796\\u17c1\\u1789 *"}',
                'created_at' => '2026-08-22 08:19:45',
                'updated_at' => '2026-08-22 08:21:54',
            ),
            52 => 
            array (
                'id' => 53,
                'key' => 'contact_form_email_label',
                'value' => '{"en":"Email Address *","km":"\\u17a2\\u17b6\\u179f\\u1799\\u178a\\u17d2\\u178b\\u17b6\\u1793\\u17a2\\u17ca\\u17b8\\u1798\\u17c2\\u179b *"}',
                'created_at' => '2026-08-22 08:19:45',
                'updated_at' => '2026-08-22 08:21:54',
            ),
            53 => 
            array (
                'id' => 54,
                'key' => 'contact_form_subject_label',
                'value' => '{"en":"Subject *","km":"\\u1794\\u17d2\\u179a\\u1792\\u17b6\\u1793\\u1794\\u1791 *"}',
                'created_at' => '2026-08-22 08:19:45',
                'updated_at' => '2026-08-22 08:21:54',
            ),
            54 => 
            array (
                'id' => 55,
                'key' => 'contact_form_message_label',
                'value' => '{"en":"Message *","km":"\\u179f\\u17b6\\u179a *"}',
                'created_at' => '2026-08-22 08:19:45',
                'updated_at' => '2026-08-22 08:21:54',
            ),
            55 => 
            array (
                'id' => 56,
                'key' => 'contact_form_submit_label',
                'value' => '{"en":"Send Message","km":"\\u1795\\u17d2\\u1789\\u17be\\u179f\\u17b6\\u179a"}',
                'created_at' => '2026-08-22 08:19:45',
                'updated_at' => '2026-08-22 08:19:45',
            ),
            56 => 
            array (
                'id' => 57,
                'key' => 'contact_map_embed_url',
                'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.5349704717714!2d104.7664375!3d11.416812499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310943007130a9b7%3A0x5587668d4e351135!2sDigital%20University%20of%20Cambodia!5e1!3m2!1sen!2skh!4v1787388121525!5m2!1sen!2skh" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>',
                'created_at' => '2026-08-22 08:42:23',
                'updated_at' => '2026-08-22 08:42:23',
            ),
            57 => 
            array (
                'id' => 58,
                'key' => 'contact_map_link',
                'value' => 'https://maps.app.goo.gl/q3shX7iSQ8AhRu6MA',
                'created_at' => '2026-08-22 08:46:32',
                'updated_at' => '2026-08-27 02:41:41',
            ),
            58 => 
            array (
                'id' => 59,
                'key' => 'header_subtitle_color',
                'value' => '#AF8319',
                'created_at' => '2026-08-22 09:27:29',
                'updated_at' => '2026-08-22 09:27:29',
            ),
            59 => 
            array (
                'id' => 60,
                'key' => 'global_bg_color',
                'value' => '#f4f5f6',
                'created_at' => '2026-08-22 14:38:10',
                'updated_at' => '2026-08-24 03:58:45',
            ),
            60 => 
            array (
                'id' => 61,
                'key' => 'card_bg_color',
                'value' => '#ffffff',
                'created_at' => '2026-08-22 14:38:10',
                'updated_at' => '2026-08-24 03:58:45',
            ),
            61 => 
            array (
                'id' => 62,
                'key' => 'primary_button_color',
                'value' => '#104652',
                'created_at' => '2026-08-22 14:38:10',
                'updated_at' => '2026-08-24 02:17:17',
            ),
            62 => 
            array (
                'id' => 63,
                'key' => 'primary_button_hover',
                'value' => '#316d7a',
                'created_at' => '2026-08-22 14:38:10',
                'updated_at' => '2026-08-24 02:17:17',
            ),
            63 => 
            array (
                'id' => 64,
                'key' => 'subdecree_hero',
            'value' => '{"badge":{"km":"អនុក្រឹត្យស្ដីពីការបង្កើតសាកលវិទ្យាល័យ","en":"Sub-decree on the establishment of the university"},"title":{"km":"សេចក្តីជូនដំណឹង និងអនុក្រឹត្យ","en":"Announcement & Sub-decree"},"description":{"km":"អនុក្រឹត្យស្ដីពីការបង្កើតសាកលវិទ្យាល័យឌីជីថលកម្ពុជា។","en":"Sub-decree on the establishment of the Digital University of Cambodia."},"doc_button":{"km":"មើលលិខិតផ្លូវការ","en":"View Official Documents"},"official_doc_title":{"km":"លិខិតប្រកាសផ្លូវការ","en":"Official Announcement Document"},"click_to_zoom":{"km":"ចុចលើរូបភាពដើម្បីពង្រីកមើលលម្អិត","en":"Click any document to view in high resolution"},"all_pages":{"km":"ទំព័រទាំងអស់៖","en":"All pages:"},"page":{"km":"ទំព័រ","en":"Page"},"of":{"km":"នៃ","en":"of"},"close":{"km":"បិទ","en":"Close"},"zoom_document":{"km":"ពង្រីករូបភាព (Zoom Document)","en":"Zoom Document"}}',
                'created_at' => '2026-08-25 06:36:37',
                'updated_at' => '2026-08-25 07:02:31',
            ),
            64 => 
            array (
                'id' => 65,
                'key' => 'subdecree_documents',
                'value' => '[{"title":{"km":"ទំព័រទី ១","en":"Page 1"},"src":"\\/storage\\/subdecree\\/GbuyHmzSQ2u3ZPRBAvhwIOlw8gDY6LsNfSTm9i4j.png"},{"title":{"km":"ទំព័រទី ២","en":"Page 2"},"src":"\\/storage\\/subdecree\\/uCoNQI9T5J29kgnmsdeFXJDDdqN4jgXfceTh6Fk1.png"},{"title":{"km":"ទំព័រទី ៣","en":"Page 3"},"src":"\\/storage\\/subdecree\\/bAnv6vzKzt8t1QpdkI3EYKZ2RefcX9XdrjvaHhPd.png"},{"title":{"km":"ទំព័រទី ៤","en":"Page 4"},"src":"\\/storage\\/subdecree\\/7mGIXqaTw9LlTZ3h2TuZhT09Da0cSS1Eh5hsYN0r.png"}]',
                'created_at' => '2026-08-25 06:36:37',
                'updated_at' => '2026-08-26 02:11:47',
            ),
            65 => 
            array (
                'id' => 66,
                'key' => 'studentuniform_hero',
                'value' => '{"badge":{"en":"Student Information","km":"ព័ត៌មាននិស្សិត"},"title":{"en":"Student Uniform","km":"ឯកសណ្ឋាននិស្សិត"},"subtitle":{"en":"Guidelines on Student Uniform.","km":"សេចក្តីណែនាំអំពីឯកសណ្ឋាននិស្សិត។"},"button":{"en":"View Details","km":"មើលសេចក្តីលម្អិត"}}',
                'created_at' => '2026-08-26 03:06:54',
                'updated_at' => '2026-08-26 03:06:54',
            ),
            66 => 
            array (
                'id' => 67,
                'key' => 'studentuniform_overview',
                'value' => '{"title":{"km":"១. ឯកសណ្ឋាន","en":"1. Uniform"},"subtitle":{"km":"ហេតុអ្វីបានជាឯកសណ្ឋានសាលាសំខាន់?","en":"Why is school uniform important?"},"description":{"km":"ឯកសណ្ឋានសាលាគឺជាផ្នែកមួយដ៏សំខាន់នៃប្រព័ន្ធអប់រំដែលជួយបង្កើត បរិយាកាសសិក្សា ប្រកបដោយវិជ្ជាជីវៈ និងសេចក្តីថ្លៃថ្នូរ។","en":"School uniform is an important part of the education system that helps create a professional and dignified learning environment."}}',
                'created_at' => '2026-08-26 03:06:54',
                'updated_at' => '2026-08-26 03:06:54',
            ),
            67 => 
            array (
                'id' => 68,
                'key' => 'studentuniform_cards',
                'value' => '[{"title":{"en":"Equality","km":"សមភាព"},"desc":{"en":"Equality among all students","km":"ភាពស្មើគ្នា"},"icon":"Users"},{"title":{"en":"Discipline","km":"វិន័យ"},"desc":{"en":"Promotes discipline","km":"លើកកម្ពស់វិន័យ"},"icon":"ShieldCheck"},{"title":{"en":"Professionalism","km":"វិជ្ជាជីវៈ"},"desc":{"en":"Prepares for future careers","km":"ត្រៀមសម្រាប់អាជីព"},"icon":"Briefcase"}]',
                'created_at' => '2026-08-26 03:06:54',
                'updated_at' => '2026-08-26 03:06:54',
            ),
            68 => 
            array (
                'id' => 69,
                'key' => 'studentuniform_genders',
                'value' => '{"male_title":{"km":"និស្សិតប្រុស","en":"Male Student"},"male_img":"\\/storage\\/student-uniform\\/081dW6HjWqISWxvp7ypEzkUxXEgkjNjvlXNn0nO5.png","female_title":{"km":"និស្សិតស្រី","en":"Female Student"},"female_img":"\\/storage\\/student-uniform\\/8OWDRCVnsCwIlzHBJ2Qy6wJ5fQ9B3qfNRhhbaEZL.png"}',
                'created_at' => '2026-08-26 03:06:54',
                'updated_at' => '2026-08-26 06:18:02',
            ),
            69 => 
            array (
                'id' => 70,
                'key' => 'studentuniform_male_details',
                'value' => '{"section_title":{"km":"១.១ ឯកសណ្ឋាននិស្សិតប្រុស","en":"1.1 Male Student Uniform"},"full_img":"\\/storage\\/student-uniform\\/ZNeqvXYMXpaV8K2nUInqRcJyt9R6p37x4qj9sTxr.png","clothing_title":{"km":"សម្លៀកបំពាក់សិស្ស","en":"Student Clothing"},"clothing_img":"\\/storage\\/student-uniform\\/rnJX9ae3NHLikVXNeX96ejU0WUh4inYmDlLeFh4P.png","logo_title":{"km":"Logo","en":"Logo"},"logo_img":"\\/storage\\/student-uniform\\/XUtgViCrwnvsJysVwfOoYPa7m9ZbncLdDBuNOrzN.png","shoes_title":{"km":"ស្បែកជើងសិស្ស","en":"Student Shoes"},"shoes_img":"\\/storage\\/student-uniform\\/gSK8fyHdzjQb7QduQCdFiURLGu2OoTEEeVh6DuE9.png"}',
                'created_at' => '2026-08-26 03:06:54',
                'updated_at' => '2026-08-26 06:55:27',
            ),
            70 => 
            array (
                'id' => 71,
                'key' => 'studentuniform_female_details',
                'value' => '{"section_title":{"km":"១.២ ឯកសណ្ឋាននិស្សិតស្រី","en":"1.2 Female Student Uniform"},"full_img":"\\/storage\\/student-uniform\\/eCl54HNFBbPdng6ImunJW39EXTUbTSda5b3XGWNJ.png","clothing_title":{"km":"សម្លៀកបំពាក់សិស្ស","en":"Student Clothing"},"clothing_img":"\\/storage\\/student-uniform\\/VZX3AjhVZoS6m0lI09L2zsm1dEQlvwumtDBgrbqE.png","logo_title":{"km":"Logo","en":"Logo"},"logo_img":"\\/storage\\/student-uniform\\/6vtRaCoMtbXFFfrDzVhxPQtOVbiy9WwjHGyVjTDP.png","shoes_title":{"km":"ស្បែកជើងសិស្ស","en":"Student Shoes"},"shoes_img":"\\/storage\\/student-uniform\\/zqfTIVP21JqM3McvAjntyyI7LicIA3CXZwu0DhVH.png"}',
                'created_at' => '2026-08-26 03:06:54',
                'updated_at' => '2026-08-26 06:55:27',
            ),
            71 => 
            array (
                'id' => 72,
                'key' => 'degree_certificate_hero',
                'value' => '{"badge":{"en":"CERTIFICATE","km":"វិញ្ញាបនបត្រ"},"title":{"en":"Sample Degree Certificate","km":"គំរូសញ្ញាបត្រ"},"description":{"en":"View the official digital certificate issued by Digital University of Cambodia.","km":"ពិនិត្យមើលសញ្ញាបត្រឌីជីថលផ្លូវការដែលចេញដោយសាកលវិទ្យាល័យឌីជីថលកម្ពុជា។"}}',
                'created_at' => '2026-08-26 07:49:42',
                'updated_at' => '2026-08-26 07:49:42',
            ),
            72 => 
            array (
                'id' => 73,
                'key' => 'degree_certificate_details',
                'value' => '{"bachelor_img":"\\/storage\\/degree-certificate\\/5w7573QRGD72twEYQNAHfRbZB8HPhxE41ynYQkm1.png","associate_img":"\\/storage\\/degree-certificate\\/vzTKzbSu9jOUCW1VJgbBYlx9zyAyIBI19h1zKwlh.jpg"}',
                'created_at' => '2026-08-26 07:49:42',
                'updated_at' => '2026-08-26 08:19:32',
            ),
            73 => 
            array (
                'id' => 74,
                'key' => 'degree_certificate_verification',
                'value' => '{"title":{"en":"Authenticity & Verification","km":"ភាពត្រឹមត្រូវ និងការផ្ទៀងផ្ទាត់"},"description":{"en":"Every degree certificate issued by the Digital University of Cambodia features a unique QR Code and serial number for immediate verification. This ensures the integrity of our academic credentials and allows employers to easily authenticate the qualifications of our graduates through our official verification system.","km":"សញ្ញាបត្រនីមួយៗដែលចេញដោយសាកលវិទ្យាល័យឌីជីថលកម្ពុជា មាន QR Code ពិសេស និងលេខសម្គាល់ដែលអាចផ្ទៀងផ្ទាត់បាន។ នេះធានានូវបូរណភាពនៃកំណត់ត្រាសិក្សារបស់យើង ហើយអនុញ្ញាតឱ្យនិយោជកងាយស្រួលផ្ទៀងផ្ទាត់ភាពត្រឹមត្រូវនៃគុណវុឌ្ឍិរបស់និស្សិតបញ្ចប់ការសិក្សាតាមរយៈប្រព័ន្ធផ្ទៀងផ្ទាត់ផ្លូវការរបស់យើង។"}}',
                'created_at' => '2026-08-26 08:13:48',
                'updated_at' => '2026-08-26 08:13:48',
            ),
            74 => 
            array (
                'id' => 75,
                'key' => 'graduationuniform_hero',
                'value' => '{"title":{"en":"Graduation Uniform","km":"កម្រងឯកសណ្ឋានទទួលសញ្ញាបត្រ"},"subtitle":{"en":"Guidelines on the graduation uniform of the Digital University of Cambodia.","km":"គោលការណ៍ណែនាំស្តីពីកម្រងឯកសណ្ឋានទទួលសញ្ញាបត្ររបស់សាកលវិទ្យាល័យឌីជីថលកម្ពុជា។"}}',
                'created_at' => '2026-08-27 01:57:07',
                'updated_at' => '2026-08-27 01:57:07',
            ),
            75 => 
            array (
                'id' => 76,
                'key' => 'graduationuniform_images',
                'value' => '{"doctorate_img":"\\/storage\\/graduation-uniform\\/epIWolrR3XXRCvONQZfJi3S1S5s2VJ5ot511Bfie.jpg","master_img":"\\/storage\\/graduation-uniform\\/jHcq3Wn8Pj6mFO9Ke1BXmXSSDINrKrbF6697HRnq.jpg","bachelor_img":"\\/storage\\/graduation-uniform\\/bTRdk089XvveWiwjYMckr6rTa0bVF5qlwIaAsUPM.jpg","associate_img":"\\/storage\\/graduation-uniform\\/Bs91Hu7IV3utFdXFUJTPw68G5d2vKUyeVJpsujZQ.jpg"}',
                'created_at' => '2026-08-27 01:57:07',
                'updated_at' => '2026-08-27 01:57:07',
            ),
        ));
        
        
    }
}