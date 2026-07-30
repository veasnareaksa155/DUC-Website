<?php

/**
 * Program/major content, keyed by the URL slug used in the
 * FACULTIES nav menu links (e.g. "/department/1/graphic-design"
 * -> key "graphic-design").
 *
 * Only 'graphic-design' has real content right now (copied from
 * the demo data already in Show.vue). Every other key is a
 * placeholder stub so the page never 404s — it just shows a
 * "coming soon" state (see Show.vue) until real content is added.
 *
 * TODO: replace each stub below with the actual Program Aim, PLOs,
 * admission requirements, course structure, etc. for that major.
 * Don't guess at real curriculum/accreditation content — pull it
 * from the department's actual program documentation.
 */

function stub(string $departmentLabel, string $majorLabel, array $degreeLevels = ["Bachelor's degree"]): array
{
    return [
        'department' => $departmentLabel,
        'majors' => $majorLabel,
        'degreeLevels' => $degreeLevels,
        'programAim' => '',
        'plos' => [],
        'admissionRequirements' => [],
        'totalCredits' => ['years' => 0, 'credits' => 0],
        'courseStructure' => [],
        'grandTotal' => ['credits' => 0, 'hours' => 0],
        'courseNotes' => [],
        'graduationRequirements' => [],
        'degreeTitleAwarded' => '',
        'careerOpportunities' => [],
    ];
}

return [

    // -------- Faculty of Digital Industry --------
    'graphic-design' => [
        'department' => 'Department of Graphic Design',
        'majors' => 'Graphic Design',
        'degreeLevels' => ["Bachelor's degree", "Associate's degree"],

        'programAim' =>
            "The Associate of Information Technology education at the Faculty of Digital Industry is designed to provide knowledge and skills in computer networking and security systems. This program helps graduates develop the competence required to contribute to the network security sector, solve cybersecurity challenges, and protect the integrity, confidentiality, and availability of information within digital networks. It also develops interpersonal skills and teamwork to enable students to succeed in today's and tomorrow's significantly changing and evolving professional environments.",

        'plos' => [
            [
                'category' => 'A. Knowledge',
                'items' => [
                    'PLO1: Analyze system security, Intrusion Detection Systems (IDS), and Intrusion Prevention Systems (IPS).',
                    'PLO2: Understand security tools, techniques, and technologies used in protecting networks and systems.',
                    'PLO3: Apply network protocols in usage and communication to design and implement secure and efficient network infrastructures.',
                ],
            ],
            [
                'category' => 'B. Cognitive Skills',
                'items' => [
                    'PLO4: Create network performance monitoring tools to analyze and troubleshoot network issues, ensuring optimal performance of device health and network design for Cisco network management and programming.',
                    'PLO5: Analyze network architecture designs for smooth network data management and network troubleshooting.',
                    'PLO6: Evaluate and mitigate security risks within network environments.',
                ],
            ],
            [
                'category' => 'C. Interpersonal Skills and Responsibility',
                'items' => [
                    'PLO7: Implement secure network architectures that meet the requirements of various organizations and institutions.',
                    'PLO8: Communicate effectively on network security topics with both technical and non-technical stakeholders.',
                ],
            ],
            [
                'category' => 'D. Numerical Skills, Information Technology, and Communication',
                'items' => [
                    'PLO9: Use automation tools and analyze network security data to generate reports and effectively convey information to technical teams and managers.',
                ],
            ],
            [
                'category' => 'E. Psychomotor Skills',
                'items' => [
                    'PLO10: Install, configure, and test actual network hardware — such as routers, switches, and security appliances — to ensure the performance of a secure network.',
                ],
            ],
        ],

        'admissionRequirements' => [
            'Hold a Technical and Vocational Certificate 3 (Level 4), or',
            'Have passed the High School Exam (Bac II), or',
            'Hold a Foundation Year Course Certificate, or',
            'Hold an equivalent degree/certificate.',
        ],

        'totalCredits' => ['years' => 2, 'credits' => 60],

        'courseStructure' => [
            [
                'year' => 'Year I',
                'semesters' => [
                    [
                        'semester' => 'Semester I',
                        'subjects' => [
                            ['no' => 1, 'name' => 'Computer Fundamentals', 'credits' => 3, 'hours' => 45],
                            ['no' => 2, 'name' => 'Office Application', 'credits' => 3, 'hours' => 45],
                            ['no' => 3, 'name' => 'English for Information Technology I (Part-I)', 'credits' => 3, 'hours' => 45],
                            ['no' => 4, 'name' => 'Internet Fundamental', 'credits' => 3, 'hours' => 45],
                            ['no' => 5, 'name' => 'C/C++ Programming', 'credits' => 3, 'hours' => 45],
                        ],
                    ],
                    [
                        'semester' => 'Semester II',
                        'subjects' => [
                            ['no' => 6, 'name' => 'Cisco I', 'credits' => 3, 'hours' => 45],
                            ['no' => 7, 'name' => 'English for Information Technology I (Part-II)', 'credits' => 3, 'hours' => 45],
                            ['no' => 8, 'name' => 'System Administration I', 'credits' => 3, 'hours' => 45],
                            ['no' => 9, 'name' => 'Network Administration I', 'credits' => 3, 'hours' => 45],
                            ['no' => 10, 'name' => 'Network Security I', 'credits' => 3, 'hours' => 45],
                        ],
                    ],
                ],
                'yearTotal' => ['credits' => 30, 'hours' => 600],
            ],
            [
                'year' => 'Year II',
                'semesters' => [
                    [
                        'semester' => 'Semester I',
                        'subjects' => [
                            ['no' => 11, 'name' => 'Cisco II', 'credits' => 3, 'hours' => 45],
                            ['no' => 12, 'name' => 'System Administration II', 'credits' => 3, 'hours' => 45],
                            ['no' => 13, 'name' => 'English for Information Technology II (Part-I)', 'credits' => 3, 'hours' => 45],
                            ['no' => 14, 'name' => 'Network Administration II', 'credits' => 3, 'hours' => 45],
                            ['no' => 15, 'name' => 'Network Security II', 'credits' => 3, 'hours' => 45],
                        ],
                    ],
                    [
                        'semester' => 'Semester II',
                        'subjects' => [
                            ['no' => 16, 'name' => 'Cisco III', 'credits' => 3, 'hours' => 45],
                            ['no' => 17, 'name' => 'Professional Life', 'credits' => 3, 'hours' => 45],
                            ['no' => 18, 'name' => 'English for Information Technology II (Part-II)', 'credits' => 3, 'hours' => 45],
                            ['no' => 19, 'name' => 'Container', 'credits' => 3, 'hours' => 45],
                            ['no' => 20, 'name' => 'Cybersecurity Fundamentals', 'credits' => 3, 'hours' => 45],
                        ],
                    ],
                ],
                'yearTotal' => ['credits' => 30, 'hours' => 660],
            ],
        ],

        'grandTotal' => ['credits' => 60, 'hours' => 1260],

        'courseNotes' => [
            '3 means the classroom-based study has 3 credits.',
            '3 (2.0.1) means the classroom-based study has 2 credits and the practical study at the educational institution has 1 credit.',
            '3 (2.0.1) means the classroom-based study has 2 credits and the hands-on practice (fieldwork) has 1 credit.',
        ],

        'graduationRequirements' => [
            'Successfully complete all courses according to the total credits required by the curriculum.',
            'Complete an internship at a public or private institution and successfully defend the internship report.',
            'Pass the final comprehensive examinations on major-related subjects.',
        ],

        'degreeTitleAwarded' => "Associate's Degree of Information Technology in Computer Networks and Security.",

        'careerOpportunities' => [
            'IT Support Specialist',
            'Linux System Administrator',
            'Cybersecurity Analyst',
            'Network Security Specialist',
            'Network Administrator',
        ],
    ],

    'digital-marketing' => stub('Department of Digital Marketing', 'Digital Marketing'),
    'social-media' => stub('Department of Social Media', 'Social Media'),
    'information-technology' => stub('Department of Information Technology', 'Information Technology'),

    // -------- Faculty of English Language --------
    'english-for-specific-purposes' => stub('Department of English for Specific Purposes', 'English for Specific Purposes'),
    'english-for-business-communication' => stub('Department of English for Business Communication', 'English for Business Communication'),
    'english-education' => stub('Department of English Education', 'English Education'),
    'teaching-english-as-a-foreign-language' => stub('Department of Teaching English as a Foreign Language', 'Teaching English as a Foreign Language'),
    'english-for-translation-and-interpretation' => stub('Department of English for Translation and Interpretation', 'English for Translation and Interpretation'),

    // -------- Faculty of Engineering and Architecture --------
    'engineering' => stub('Department of Engineering', 'Engineering'),
    'interior-design' => stub('Department of Interior Design', 'Interior Design'),
    'engineering-management' => stub('Department of Engineering Management', 'Engineering Management'),

    // -------- Faculty of Agriculture and Rural Development --------
    'agronomy-and-horticulture' => stub('Department of Agronomy and Horticulture', 'Agronomy and Horticulture'),
    'agricultural-economics' => stub('Department of Agricultural Economics', 'Agricultural Economics'),
    'rural-development' => stub('Department of Rural Development', 'Rural Development'),

    // -------- Faculty of Law and Political Science --------
    'law' => stub('Department of Law', 'Law'),
    'public-law' => stub('Department of Public Law', 'Public Law'),
    'private-law' => stub('Department of Private Law', 'Private Law'),
    'international-business-law' => stub('Department of International Business Law', 'International Business Law'),
    'public-administration' => stub('Department of Public Administration', 'Public Administration'),
    'political-science' => stub('Department of Political Science', 'Political Science'),

    // -------- Faculty of Digital Economic Sciences --------
    'digital-economy' => stub('Department of Digital Economy', 'Digital Economy'),
    'e-commerce' => stub('Department of E-Commerce', 'E-Commerce'),

];