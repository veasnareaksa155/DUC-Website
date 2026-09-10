<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('events')->delete();
        
        \DB::table('events')->insert(array (
            0 => 
            array (
                'id' => 1,
                'image' => '/storage/events/hYL1o4fGT6EF9RD5PavKHFlwcQM8hKX18LjVOxYQ.jpg',
                'detail_image' => '/storage/events/jEsaK9nTD1YBcM5PkSyrSZjVls9uvgA8cISqi05h.jpg',
                'type' => 'campus',
                'title' => '{"en":"DUC Campus Orientation 2024","km":"\\u1791\\u17b7\\u179c\\u17b6\\u178e\\u17c2\\u1793\\u17b6\\u17c6\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u1790\\u17d2\\u1798\\u17b8\\u179a\\u1794\\u179f\\u17cb\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6 \\u17e2\\u17e0\\u17e2\\u17e4"}',
                'date' => '{"en":"3 \\/June \\/2024","km":"\\u17e3 \\/\\u1798\\u17b7\\u1790\\u17bb\\u1793\\u17b6 \\/\\u17e2\\u17e0\\u17e2\\u17e4"}',
                'description' => '{"en":"Welcoming new students to the Digital University of Cambodia with dynamic tours and introduction sessions.","km":"\\u1780\\u17b6\\u179a\\u179f\\u17d2\\u179c\\u17b6\\u1782\\u1798\\u1793\\u17cd\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u1790\\u17d2\\u1798\\u17b8\\u1798\\u1780\\u1780\\u17b6\\u1793\\u17cb\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6 \\u1787\\u17b6\\u1798\\u17bd\\u1799\\u1793\\u17b9\\u1784\\u178a\\u17c6\\u178e\\u17be\\u179a\\u1791\\u179f\\u17d2\\u179f\\u1793\\u1780\\u17b7\\u1785\\u17d2\\u1785 \\u1793\\u17b7\\u1784\\u179c\\u1782\\u17d2\\u1782\\u178e\\u17c2\\u1793\\u17b6\\u17c6\\u178a\\u17cf\\u179a\\u179f\\u17cb\\u179a\\u179c\\u17be\\u1780\\u17d4"}',
                'content' => '{"en":"<p>Campus Orientation is our annual event to introduce students to digital learning strategies, campus guidelines, and the university leadership team.<\\/p>","km":"<p>\\u1791\\u17b7\\u179c\\u17b6\\u178e\\u17c2\\u1793\\u17b6\\u17c6\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u1790\\u17d2\\u1798\\u17b8 \\u1782\\u17ba\\u1787\\u17b6\\u1796\\u17d2\\u179a\\u17b9\\u178f\\u17d2\\u178f\\u17b7\\u1780\\u17b6\\u179a\\u178e\\u17cd\\u1794\\u17d2\\u179a\\u1785\\u17b6\\u17c6\\u1786\\u17d2\\u1793\\u17b6\\u17c6\\u179a\\u1794\\u179f\\u17cb\\u1799\\u17be\\u1784 \\u178a\\u17be\\u1798\\u17d2\\u1794\\u17b8\\u178e\\u17c2\\u1793\\u17b6\\u17c6\\u179f\\u17b7\\u179f\\u17d2\\u179f\\u17b1\\u17d2\\u1799\\u179f\\u17d2\\u1782\\u17b6\\u179b\\u17cb\\u1799\\u17bb\\u1791\\u17d2\\u1792\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b \\u1782\\u17c4\\u179b\\u1780\\u17b6\\u179a\\u178e\\u17cd\\u178e\\u17c2\\u1793\\u17b6\\u17c6\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1794\\u179a\\u17b7\\u179c\\u17c1\\u178e\\u179f\\u17b6\\u179b\\u17b6 \\u1793\\u17b7\\u1784\\u1780\\u17d2\\u179a\\u17bb\\u1798\\u1790\\u17d2\\u1793\\u17b6\\u1780\\u17cb\\u178a\\u17b9\\u1780\\u1793\\u17b6\\u17c6\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u17d4<\\/p>"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-03 08:14:58',
                'is_published' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'image' => '/storage/events/hOk98XQd6qrEDgEhrgH8ssoarLXsI0EcK365LFNg.jpg',
                'detail_image' => '/storage/events/SbXGvpwJdcIKlwSQkbTO1tNLulnGvsEhwhB7JkE3.jpg',
                'type' => 'digital',
                'title' => '{"en":"Fintech and Blockchain Conference","km":"\\u179f\\u1793\\u17d2\\u1793\\u17b7\\u179f\\u17b8\\u1791\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u17a0\\u17b7\\u179a\\u1789\\u17d2\\u1789\\u179c\\u178f\\u17d2\\u1790\\u17bb \\u1793\\u17b7\\u1784\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6 Blockchain"}',
                'date' => '{"en":"12 \\/July \\/2024","km":"\\u17e1\\u17e2 \\/\\u1780\\u1780\\u17d2\\u1780\\u178a\\u17b6 \\/\\u17e2\\u17e0\\u17e2\\u17e4"}',
                'description' => '{"en":"Leading industry speakers present on the future of decentralised finance and electronic trade in Cambodia.","km":"\\u179c\\u17b6\\u1782\\u17d2\\u1798\\u17b7\\u1793\\u1788\\u17b6\\u1793\\u1798\\u17bb\\u1781\\u1782\\u17c1\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u17a7\\u179f\\u17d2\\u179f\\u17b6\\u17a0\\u1780\\u1798\\u17d2\\u1798\\u1792\\u17d2\\u179c\\u17be\\u1794\\u1791\\u1794\\u1784\\u17d2\\u17a0\\u17b6\\u1789\\u17a2\\u17c6\\u1796\\u17b8\\u17a2\\u1793\\u17b6\\u1782\\u178f\\u1793\\u17c3\\u17a0\\u17b7\\u179a\\u1789\\u17d2\\u1789\\u179c\\u178f\\u17d2\\u1790\\u17bb\\u179c\\u17b7\\u1798\\u1787\\u17d2\\u1788\\u1780\\u17b6\\u179a \\u1793\\u17b7\\u1784\\u1796\\u17b6\\u178e\\u17b7\\u1787\\u17d2\\u1787\\u1780\\u1798\\u17d2\\u1798\\u17a2\\u17c1\\u17a1\\u17b7\\u1785\\u178f\\u17d2\\u179a\\u17bc\\u1793\\u17b7\\u1780\\u1793\\u17c5\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1794\\u17d2\\u179a\\u1791\\u17c1\\u179f\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6\\u17d4"}',
                'content' => '{"en":"<p>This conference covers Web3, e-commerce integrations, digital wallets, and blockchain security protocols in cooperation with regional banks.<\\/p>","km":"<p>\\u179f\\u1793\\u17d2\\u1793\\u17b7\\u179f\\u17b8\\u1791\\u1793\\u17c1\\u17c7\\u1782\\u17d2\\u179a\\u1794\\u178a\\u178e\\u17d2\\u178f\\u1794\\u17cb\\u179b\\u17be Web3 \\u1780\\u17b6\\u179a\\u1792\\u17d2\\u179c\\u17be\\u179f\\u1798\\u17b6\\u17a0\\u179a\\u178e\\u1780\\u1798\\u17d2\\u1798\\u1796\\u17b6\\u178e\\u17b7\\u1787\\u17d2\\u1787\\u1780\\u1798\\u17d2\\u1798\\u17a2\\u17c1\\u17a1\\u17b7\\u1785\\u178f\\u17d2\\u179a\\u17bc\\u1793\\u17b7\\u1780 \\u1780\\u17b6\\u1794\\u17bc\\u1794\\u179b\\u17bb\\u1799\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b \\u1793\\u17b7\\u1784\\u1796\\u17b7\\u1792\\u17b8\\u179f\\u17b6\\u179a\\u179f\\u17bb\\u179c\\u178f\\u17d2\\u1790\\u17b7\\u1797\\u17b6\\u1796\\u1794\\u17d2\\u179b\\u17bb\\u1780\\u1786\\u17c1\\u1793 \\u179f\\u17a0\\u1780\\u17b6\\u179a\\u1787\\u17b6\\u1798\\u17bd\\u1799\\u1792\\u1793\\u17b6\\u1782\\u17b6\\u179a\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u178f\\u17c6\\u1794\\u1793\\u17cb\\u17d4<\\/p>"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-03 08:09:05',
                'is_published' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'image' => '/storage/events/WSvuEzggPQ62lawOwyKPHl5UerR14Yiz1zbARFiR.jpg',
                'detail_image' => '/storage/events/0vC9STLT2EKZZvPEauoxIC2dZIhvI2aH9D8eYFPy.jpg',
                'type' => 'announcement',
                'title' => '{"en":"Admission Scholarship Program open","km":"\\u1780\\u17b6\\u179a\\u1794\\u17be\\u1780\\u1791\\u1791\\u17bd\\u179b\\u1796\\u17b6\\u1780\\u17d2\\u1799\\u1780\\u1798\\u17d2\\u1798\\u179c\\u17b7\\u1792\\u17b8\\u17a2\\u17b6\\u17a0\\u17b6\\u179a\\u17bc\\u1794\\u1780\\u179a\\u178e\\u17cd\\u1790\\u17d2\\u1793\\u17b6\\u1780\\u17cb\\u1794\\u179a\\u17b7\\u1789\\u17d2\\u1789\\u17b6\\u1794\\u178f\\u17d2\\u179a"}',
                'date' => '{"en":"20 \\/August \\/2024","km":"\\u17e2\\u17e0 \\/\\u179f\\u17b8\\u17a0\\u17b6 \\/\\u17e2\\u17e0\\u17e2\\u17e4"}',
                'description' => '{"en":"Apply for full and partial scholarship slots in technology, architecture, and language majors.","km":"\\u178a\\u17b6\\u1780\\u17cb\\u1796\\u17b6\\u1780\\u17d2\\u1799\\u179f\\u17d2\\u1793\\u17be\\u179f\\u17bb\\u17c6\\u17a2\\u17b6\\u17a0\\u17b6\\u179a\\u17bc\\u1794\\u1780\\u179a\\u178e\\u17cd\\u1796\\u17c1\\u1789 \\u1793\\u17b7\\u1784\\u1798\\u17bd\\u1799\\u1795\\u17d2\\u1793\\u17c2\\u1780 \\u179b\\u17be\\u1787\\u17c6\\u1793\\u17b6\\u1789\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6 \\u179f\\u17d2\\u1790\\u17b6\\u1794\\u178f\\u17d2\\u1799\\u1780\\u1798\\u17d2\\u1798 \\u1793\\u17b7\\u1784\\u1797\\u17b6\\u179f\\u17b6\\u17a2\\u1784\\u17cb\\u1782\\u17d2\\u179b\\u17c1\\u179f\\u17d4"}',
                'content' => '{"en":"<p>Scholarship applications are open to local high school graduates showing excellent performance in mathematics, language, and technology fields.<\\/p>","km":"<p>\\u1780\\u17b6\\u179a\\u178a\\u17b6\\u1780\\u17cb\\u1796\\u17b6\\u1780\\u17d2\\u1799\\u179f\\u17bb\\u17c6\\u17a2\\u17b6\\u17a0\\u17b6\\u179a\\u17bc\\u1794\\u1780\\u179a\\u178e\\u17cd\\u178f\\u17d2\\u179a\\u17bc\\u179c\\u1794\\u17b6\\u1793\\u1794\\u17be\\u1780\\u1785\\u17c6\\u17a0\\u179f\\u1798\\u17d2\\u179a\\u17b6\\u1794\\u17cb\\u179f\\u17b7\\u179f\\u17d2\\u179f\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u179f\\u17d2\\u179a\\u17bb\\u1780\\u178a\\u17c2\\u179b\\u1798\\u17b6\\u1793\\u179b\\u1791\\u17d2\\u1792\\u1795\\u179b\\u1786\\u17d2\\u1793\\u17be\\u1798\\u179b\\u17be\\u1798\\u17bb\\u1781\\u179c\\u17b7\\u1787\\u17d2\\u1787\\u17b6\\u1782\\u178e\\u17b7\\u178f\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6 \\u1797\\u17b6\\u179f\\u17b6 \\u1793\\u17b7\\u1784\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u17d4<\\/p>"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-03 08:13:52',
                'is_published' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'image' => '/storage/events/D3fjlSMI85SCjse1j5TPeQN9POnFdLkFeaeFDlV5.jpg',
                'detail_image' => '/storage/events/0Ht1hkpajnPvb1V0QlfEauLQnaEfLBl5mE9sgTN4.jpg',
                'type' => 'campus',
                'title' => '{"en":"IT Department Hackathon competition","km":"\\u1780\\u17b6\\u179a\\u1794\\u17d2\\u179a\\u1780\\u17bd\\u178f\\u1794\\u17d2\\u179a\\u1787\\u17c2\\u1784 Hackathon \\u179a\\u1794\\u179f\\u17cb\\u178a\\u17c1\\u1794\\u17c9\\u17b6\\u178f\\u17ba\\u1798\\u17c9\\u1784\\u17cb\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u1796\\u17d0\\u178f\\u17cc\\u1798\\u17b6\\u1793"}',
                'date' => '{"en":"5 \\/September \\/2024","km":"\\u17e5 \\/\\u1780\\u1789\\u17d2\\u1789\\u17b6 \\/\\u17e2\\u17e0\\u17e2\\u17e4"}',
                'description' => '{"en":"A 48-hour student coding competition to build responsive web applications resolving local issues.","km":"\\u1780\\u17b6\\u179a\\u1794\\u17d2\\u179a\\u1780\\u17bd\\u178f\\u1794\\u17d2\\u179a\\u1787\\u17c2\\u1784\\u179f\\u179a\\u179f\\u17c1\\u179a\\u1780\\u17bc\\u178a\\u179a\\u1794\\u179f\\u17cb\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u179a\\u1799\\u17c8\\u1796\\u17c1\\u179b \\u17e4\\u17e8 \\u1798\\u17c9\\u17c4\\u1784 \\u178a\\u17be\\u1798\\u17d2\\u1794\\u17b8\\u1794\\u1784\\u17d2\\u1780\\u17be\\u178f\\u1782\\u17c1\\u17a0\\u1791\\u17c6\\u1796\\u17d0\\u179a\\u178a\\u17c4\\u17c7\\u179f\\u17d2\\u179a\\u17b6\\u1799\\u1794\\u1789\\u17d2\\u17a0\\u17b6\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u178f\\u17c6\\u1794\\u1793\\u17cb\\u17d4"}',
                'content' => '{"en":"<p>The Hackathon provides students a chance to collaborate with peers, solve real-world community challenges, and win cash prizes from sponsors.<\\/p>","km":"<p>Hackathon \\u1795\\u17d2\\u178f\\u179b\\u17cb\\u17b1\\u1780\\u17b6\\u179f\\u17b1\\u17d2\\u1799\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u179f\\u17a0\\u1780\\u17b6\\u179a\\u1782\\u17d2\\u1793\\u17b6 \\u178a\\u17c4\\u17c7\\u179f\\u17d2\\u179a\\u17b6\\u1799\\u1794\\u1789\\u17d2\\u17a0\\u17b6\\u1794\\u17d2\\u179a\\u1788\\u1798\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u179f\\u17a0\\u1782\\u1798\\u1793\\u17cd\\u1787\\u17b6\\u1780\\u17cb\\u179f\\u17d2\\u178f\\u17c2\\u1784 \\u1793\\u17b7\\u1784\\u1788\\u17d2\\u1793\\u17c7\\u179a\\u1784\\u17d2\\u179c\\u17b6\\u1793\\u17cb\\u1787\\u17b6\\u179f\\u17b6\\u1785\\u17cb\\u1794\\u17d2\\u179a\\u17b6\\u1780\\u17cb\\u1796\\u17b8\\u17a2\\u17d2\\u1793\\u1780\\u17a7\\u1794\\u178f\\u17d2\\u1790\\u1798\\u17d2\\u1797\\u17d4<\\/p>"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-03 08:10:29',
                'is_published' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'image' => '/storage/events/QkbsybxSlWx7nQK5GuAjZq4UBthtNr1qr4AoTJQY.jpg',
                'detail_image' => '/storage/events/ocSV16o7znAlyxF5wiZ5MYgGFzltYg1Gr9eS7dVa.jpg',
                'type' => 'digital',
            'title' => '{"en":"Cybersecurity Awareness seminar","km":"\\u179f\\u17b7\\u1780\\u17d2\\u1781\\u17b6\\u179f\\u17b6\\u179b\\u17b6\\u1799\\u1780\\u1785\\u17b7\\u178f\\u17d2\\u178f\\u1791\\u17bb\\u1780\\u178a\\u17b6\\u1780\\u17cb\\u17a2\\u17c6\\u1796\\u17b8\\u179f\\u17bb\\u179c\\u178f\\u17d2\\u1790\\u17b7\\u1797\\u17b6\\u1796\\u178f\\u17b6\\u1798\\u1794\\u17d2\\u179a\\u1796\\u17d0\\u1793\\u17d2\\u1792\\u17a2\\u17ca\\u17b8\\u1793\\u1792\\u17ba\\u178e\\u17b7\\u178f (Cybersecurity)"}',
                'date' => '{"en":"18 \\/October \\/2024","km":"\\u17e1\\u17e8 \\/\\u178f\\u17bb\\u179b\\u17b6 \\/\\u17e2\\u17e0\\u17e2\\u17e4"}',
                'description' => '{"en":"Learn vital strategies to defend critical infrastructure and personal databases from online threats.","km":"\\u179f\\u17d2\\u179c\\u17c2\\u1784\\u1799\\u179b\\u17cb\\u1796\\u17b8\\u1799\\u17bb\\u1791\\u17d2\\u1792\\u179f\\u17b6\\u179f\\u17d2\\u178f\\u17d2\\u179a\\u179f\\u17c6\\u1781\\u17b6\\u1793\\u17cb\\u17d7\\u178a\\u17be\\u1798\\u17d2\\u1794\\u17b8\\u1780\\u17b6\\u179a\\u1796\\u17b6\\u179a\\u17a0\\u17c1\\u178a\\u17d2\\u178b\\u17b6\\u179a\\u1785\\u1793\\u17b6\\u179f\\u1798\\u17d2\\u1796\\u17d0\\u1793\\u17d2\\u1792\\u179f\\u17c6\\u1781\\u17b6\\u1793\\u17cb\\u17d7 \\u1793\\u17b7\\u1784\\u1798\\u17bc\\u179b\\u178a\\u17d2\\u178b\\u17b6\\u1793\\u1791\\u17b7\\u1793\\u17d2\\u1793\\u1793\\u17d0\\u1799\\u1795\\u17d2\\u1791\\u17b6\\u179b\\u17cb\\u1781\\u17d2\\u179b\\u17bd\\u1793\\u1796\\u17b8\\u1780\\u17b6\\u179a\\u1782\\u17c6\\u179a\\u17b6\\u1798\\u1780\\u17c6\\u17a0\\u17c2\\u1784\\u178f\\u17b6\\u1798\\u17a2\\u17ca\\u17b8\\u1793\\u1792\\u17ba\\u178e\\u17b7\\u178f\\u17d4"}',
            'content' => '{"en":"<p>This seminar presents details on phishing prevention, multi-factor authentication, network firewalls, and secure digital architectures.<\\/p>","km":"<p>\\u179f\\u17b7\\u1780\\u17d2\\u1781\\u17b6\\u179f\\u17b6\\u179b\\u17b6\\u1793\\u17c1\\u17c7\\u1794\\u1784\\u17d2\\u17a0\\u17b6\\u1789\\u1796\\u17d0\\u178f\\u17cc\\u1798\\u17b6\\u1793\\u179b\\u1798\\u17d2\\u17a2\\u17b7\\u178f\\u17a2\\u17c6\\u1796\\u17b8\\u1780\\u17b6\\u179a\\u1780\\u17b6\\u179a\\u1796\\u17b6\\u179a\\u1780\\u17b6\\u179a\\u1794\\u1793\\u17d2\\u179b\\u17c6 (phishing) \\u1780\\u17b6\\u179a\\u1795\\u17d2\\u1791\\u17c0\\u1784\\u1795\\u17d2\\u1791\\u17b6\\u178f\\u17cb\\u1797\\u17b6\\u1796\\u178f\\u17d2\\u179a\\u17b9\\u1798\\u178f\\u17d2\\u179a\\u17bc\\u179c\\u1785\\u17d2\\u179a\\u17be\\u1793\\u1780\\u178f\\u17d2\\u178f\\u17b6 (MFA) \\u1787\\u1789\\u17d2\\u1787\\u17b6\\u17c6\\u1784\\u1780\\u17b6\\u179a\\u1796\\u17b6\\u179a\\u1794\\u178e\\u17d2\\u178f\\u17b6\\u1789 \\u1793\\u17b7\\u1784\\u179f\\u17d2\\u1790\\u17b6\\u1794\\u178f\\u17d2\\u1799\\u1780\\u1798\\u17d2\\u1798\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u178a\\u17c2\\u179b\\u1798\\u17b6\\u1793\\u179f\\u17bb\\u179c\\u178f\\u17d2\\u1790\\u17b7\\u1797\\u17b6\\u1796\\u17d4<\\/p>"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-03 08:05:58',
                'is_published' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'image' => '/storage/events/Lwks70I6hrmzNXaUiR5ZTDxEdtrbr2dO4smx67vi.jpg',
                'detail_image' => '/storage/events/DztWbsyK6Nb4mZXZV62ERTKCyQB95vqUsHePsP0u.jpg',
                'type' => 'announcement',
                'title' => '{"en":"DUC Convocation Ceremony 2024","km":"\\u1796\\u17b7\\u1792\\u17b8\\u1794\\u17d2\\u179a\\u1782\\u179b\\u17cb\\u179f\\u1789\\u17d2\\u1789\\u17b6\\u1794\\u178f\\u17d2\\u179a\\u179a\\u1794\\u179f\\u17cb\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u1792\\u17b7\\u1780\\u17b6\\u179a\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6 \\u17e2\\u17e0\\u17e2\\u17e4"}',
                'date' => '{"en":"30 \\/November \\/2024","km":"\\u17e3\\u17e0 \\/\\u179c\\u17b7\\u1785\\u17d2\\u1786\\u17b7\\u1780\\u17b6 \\/\\u17e2\\u17e0\\u17e2\\u17e4"}',
                'description' => '{"en":"Celebrating the success and graduation of the pioneer batch of Digital University of Cambodia.","km":"\\u17a2\\u1794\\u17a2\\u179a\\u179f\\u17b6\\u1791\\u179a\\u1797\\u17b6\\u1796\\u1787\\u17c4\\u1782\\u1787\\u17d0\\u1799 \\u1793\\u17b7\\u1784\\u1780\\u17b6\\u179a\\u1794\\u1789\\u17d2\\u1785\\u1794\\u17cb\\u1780\\u17b6\\u179a\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6\\u179a\\u1794\\u179f\\u17cb\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u1787\\u17c6\\u1793\\u17b6\\u1793\\u17cb\\u178a\\u17c6\\u1794\\u17bc\\u1784\\u1793\\u17c3\\u179f\\u17b6\\u1780\\u179b\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6\\u179b\\u17d0\\u1799\\u178c\\u17b8\\u1787\\u17b8\\u1790\\u179b\\u1780\\u1798\\u17d2\\u1796\\u17bb\\u1787\\u17b6\\u17d4"}',
                'content' => '{"en":"<p>Join us in recognizing the academic excellence of our graduating students as they embark on professional careers in technology and management.<\\/p><p>Join us in recognizing the academic excellence of our graduating students as they embark on professional careers in technology and management.<\\/p><p>Join us in recognizing the academic excellence of our graduating students as they embark on professional careers in technology and management.Join us in recognizing the academic excellence of our graduating students as they embark on professional careers in technology and management.<\\/p>","km":"<p>\\u1785\\u17bc\\u179b\\u179a\\u17bd\\u1798\\u1787\\u17b6\\u1798\\u17bd\\u1799\\u1799\\u17be\\u1784\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1780\\u17b6\\u179a\\u1791\\u1791\\u17bd\\u179b\\u179f\\u17d2\\u1782\\u17b6\\u179b\\u17cb\\u17a7\\u178f\\u17d2\\u178f\\u1798\\u1797\\u17b6\\u1796\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6\\u179a\\u1794\\u179f\\u17cb\\u1793\\u17b7\\u179f\\u17d2\\u179f\\u17b7\\u178f\\u178a\\u17c2\\u179b\\u1794\\u1789\\u17d2\\u1785\\u1794\\u17cb\\u1780\\u17b6\\u179a\\u179f\\u17b7\\u1780\\u17d2\\u179f\\u17b6\\u179a\\u1794\\u179f\\u17cb\\u1799\\u17be\\u1784 \\u1793\\u17c5\\u1796\\u17c1\\u179b\\u1796\\u17bd\\u1780\\u1782\\u17c1\\u1785\\u17b6\\u1794\\u17cb\\u1795\\u17d2\\u178f\\u17be\\u1798\\u17a2\\u17b6\\u1787\\u17b8\\u1796\\u179c\\u17b7\\u1787\\u17d2\\u1787\\u17b6\\u1787\\u17b8\\u179c\\u17c8\\u1780\\u17d2\\u1793\\u17bb\\u1784\\u1795\\u17d2\\u1793\\u17c2\\u1780\\u1794\\u1785\\u17d2\\u1785\\u17c1\\u1780\\u179c\\u17b7\\u1791\\u17d2\\u1799\\u17b6 \\u1793\\u17b7\\u1784\\u1780\\u17b6\\u179a\\u1782\\u17d2\\u179a\\u1794\\u17cb\\u1782\\u17d2\\u179a\\u1784\\u17d4<\\/p>"}',
                'created_at' => '2026-07-21 03:52:14',
                'updated_at' => '2026-08-03 08:15:30',
                'is_published' => 1,
            ),
        ));
        
        
    }
}