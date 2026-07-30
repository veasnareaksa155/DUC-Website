<script setup>
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';
/**
 * Props
 * -----
 * Pass real data from your MajorController@show via Inertia::render().
 * The default() below is placeholder/demo content only, mirroring the
 * layout the client asked for, so this file renders correctly even
 * before you wire it up to the database.
 */
const props = defineProps({
    program: {
        type: Object,
        default: () => ({
            department: 'Department of Graphic Design',
            majors: 'Graphic Design',
            degreeLevels: ["Bachelor's degree", "Associate's degree"],

            programAim:
                "The Associate of Information Technology education at the Faculty of Digital Industry is designed to provide knowledge and skills in computer networking and security systems. This program helps graduates develop the competence required to contribute to the network security sector, solve cybersecurity challenges, and protect the integrity, confidentiality, and availability of information within digital networks. It also develops interpersonal skills and teamwork to enable students to succeed in today's and tomorrow's significantly changing and evolving professional environments.",

            plos: [
                {
                    category: 'A. Knowledge',
                    items: [
                        'PLO1: Analyze system security, Intrusion Detection Systems (IDS), and Intrusion Prevention Systems (IPS).',
                        'PLO2: Understand security tools, techniques, and technologies used in protecting networks and systems.',
                        'PLO3: Apply network protocols in usage and communication to design and implement secure and efficient network infrastructures.',
                    ],
                },
                {
                    category: 'B. Cognitive Skills',
                    items: [
                        'PLO4: Create network performance monitoring tools to analyze and troubleshoot network issues, ensuring optimal performance of device health and network design for Cisco network management and programming.',
                        'PLO5: Analyze network architecture designs for smooth network data management and network troubleshooting.',
                        'PLO6: Evaluate and mitigate security risks within network environments.',
                    ],
                },
                {
                    category: 'C. Interpersonal Skills and Responsibility',
                    items: [
                        'PLO7: Implement secure network architectures that meet the requirements of various organizations and institutions.',
                        'PLO8: Communicate effectively on network security topics with both technical and non-technical stakeholders.',
                    ],
                },
                {
                    category: 'D. Numerical Skills, Information Technology, and Communication',
                    items: [
                        'PLO9: Use automation tools and analyze network security data to generate reports and effectively convey information to technical teams and managers.',
                    ],
                },
                {
                    category: 'E. Psychomotor Skills',
                    items: [
                        'PLO10: Install, configure, and test actual network hardware — such as routers, switches, and security appliances — to ensure the performance of a secure network.',
                    ],
                },
            ],

            admissionRequirements: [
                'Hold a Technical and Vocational Certificate 3 (Level 4), or',
                'Have passed the High School Exam (Bac II), or',
                'Hold a Foundation Year Course Certificate, or',
                'Hold an equivalent degree/certificate.',
            ],

            totalCredits: {
                years: 2,
                credits: 60,
            },

            courseStructure: [
                {
                    year: 'Year I',
                    semesters: [
                        {
                            semester: 'Semester I',
                            subjects: [
                                { no: 1, name: 'Computer Fundamentals', credits: 3, hours: 45 },
                                { no: 2, name: 'Office Application', credits: 3, hours: 45 },
                                { no: 3, name: 'English for Information Technology I (Part-I)', credits: 3, hours: 45 },
                                { no: 4, name: 'Internet Fundamental', credits: 3, hours: 45 },
                                { no: 5, name: 'C/C++ Programming', credits: 3, hours: 45 },
                            ],
                        },
                        {
                            semester: 'Semester II',
                            subjects: [
                                { no: 6, name: 'Cisco I', credits: 3, hours: 45 },
                                { no: 7, name: 'English for Information Technology I (Part-II)', credits: 3, hours: 45 },
                                { no: 8, name: 'System Administration I', credits: 3, hours: 45 },
                                { no: 9, name: 'Network Administration I', credits: 3, hours: 45 },
                                { no: 10, name: 'Network Security I', credits: 3, hours: 45 },
                            ],
                        },
                    ],
                    yearTotal: { credits: 30, hours: 600 },
                },
                {
                    year: 'Year II',
                    semesters: [
                        {
                            semester: 'Semester I',
                            subjects: [
                                { no: 11, name: 'Cisco II', credits: 3, hours: 45 },
                                { no: 12, name: 'System Administration II', credits: 3, hours: 45 },
                                { no: 13, name: 'English for Information Technology II (Part-I)', credits: 3, hours: 45 },
                                { no: 14, name: 'Network Administration II', credits: 3, hours: 45 },
                                { no: 15, name: 'Network Security II', credits: 3, hours: 45 },
                            ],
                        },
                        {
                            semester: 'Semester II',
                            subjects: [
                                { no: 16, name: 'Cisco III', credits: 3, hours: 45 },
                                { no: 17, name: 'Professional Life', credits: 3, hours: 45 },
                                { no: 18, name: 'English for Information Technology II (Part-II)', credits: 3, hours: 45 },
                                { no: 19, name: 'Container', credits: 3, hours: 45 },
                                { no: 20, name: 'Cybersecurity Fundamentals', credits: 3, hours: 45 },
                            ],
                        },
                    ],
                    yearTotal: { credits: 30, hours: 660 },
                },
            ],

            grandTotal: { credits: 60, hours: 1260 },

            courseNotes: [
                '3 means the classroom-based study has 3 credits.',
                '3 (2.0.1) means the classroom-based study has 2 credits and the practical study at the educational institution has 1 credit.',
                '3 (2.0.1) means the classroom-based study has 2 credits and the hands-on practice (fieldwork) has 1 credit.',
            ],

            graduationRequirements: [
                'Successfully complete all courses according to the total credits required by the curriculum.',
                'Complete an internship at a public or private institution and successfully defend the internship report.',
                'Pass the final comprehensive examinations on major-related subjects.',
            ],

            degreeTitleAwarded:
                "Associate's Degree of Information Technology in Computer Networks and Security.",

            careerOpportunities: [
                'IT Support Specialist',
                'Linux System Administrator',
                'Cybersecurity Analyst',
                'Network Security Specialist',
                'Network Administrator',
            ],
        }),
    },
    // Optional: link back to the parent faculty page
    facultyHref: {
        type: String,
        default: '/faculties',
    },
});

/* ---------------- Table of contents + scroll-spy ---------------- */

const legacySections = [
    { id: 'programAim', key: 'programAim', num: 1, label: 'Program Aim' },
    { id: 'plos', key: 'plos', num: 2, label: 'Program Learning Outcomes (PLOs)' },
    { id: 'admission', key: 'termsOfAdmission', num: 3, label: 'Terms of Admission' },
    { id: 'credits', key: 'totalCredits', num: 4, label: 'Total Credits' },
    { id: 'structure', key: 'courseStructure', num: 5, label: 'Course Structure' },
    { id: 'graduation', key: 'graduationRequirements', num: 6, label: 'Graduation Requirements' },
    { id: 'degree-title', key: 'degreeTitleAwarded', num: 7, label: 'Degree Title Awarded' },
    { id: 'careers', key: 'careerOpportunities', num: 8, label: 'Career Opportunities' },
];

const computeYearTotals = (year) => {
    let credits = 0;
    let hours = 0;
    if (year.semesters) {
        year.semesters.forEach(sem => {
            if (sem.subjects) {
                sem.subjects.forEach(sub => {
                    credits += Number(sub.credits) || 0;
                    hours += Number(sub.hours) || 0;
                });
            }
        });
    }
    return { credits, hours };
};

const computeGrandTotals = (courseStructure) => {
    let credits = 0;
    let hours = 0;
    if (courseStructure) {
        courseStructure.forEach(year => {
            const yt = computeYearTotals(year);
            credits += yt.credits;
            hours += yt.hours;
        });
    }
    return { credits, hours };
};

const sections = computed(() => {
    if (props.program.sections && Array.isArray(props.program.sections)) {
        return props.program.sections.map((sec, i) => ({
            id: `custom-section-${i}`,
            num: i + 1,
            type: sec.type || 'richtext',
            label: sec.title,
            content: sec.content,
            courseStructure: sec.courseStructure || [],
            courseNotes: sec.courseNotes || []
        })).filter(s => (s.content && (s.content.en || s.content.km)) || (s.type === 'course_structure' && s.courseStructure && s.courseStructure.length));
    }
    
    // Legacy support
    return legacySections.map((sec) => {
        const isCourseStruct = sec.key === 'courseStructure' && Array.isArray(props.program[sec.key]);
        return {
            id: sec.id,
            num: sec.num,
            type: isCourseStruct ? 'course_structure' : 'richtext',
            label: { en: sec.label, km: sec.label },
            content: isCourseStruct ? { en: '', km: '' } : props.program[sec.key],
            courseStructure: isCourseStruct ? props.program[sec.key] : [],
            courseNotes: isCourseStruct && props.program.courseNotes ? props.program.courseNotes.map(n => typeof n === 'string' ? { en: n, km: n } : n) : []
        };
    }).filter(s => (s.content && (s.content.en || s.content.km)) || (s.type === 'course_structure' && s.courseStructure && s.courseStructure.length));
});

const activeSection = ref(sections.value.length > 0 ? sections.value[0].id : 'program-aim');
const mobileTocRef = ref(null);

watch(activeSection, async (newVal) => {
    await nextTick();
    if (mobileTocRef.value) {
        const activeTab = document.getElementById('mobile-tab-' + newVal);
        if (activeTab) {
            const container = mobileTocRef.value;
            const tabRect = activeTab.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            
            // If the tab is out of the visible area of the container, scroll to it
            if (tabRect.left < containerRect.left || tabRect.right > containerRect.right) {
                const scrollLeft = activeTab.offsetLeft - (container.offsetWidth / 2) + (activeTab.offsetWidth / 2);
                container.scrollTo({ left: scrollLeft, behavior: 'smooth' });
            }
        }
    }
});
let scrollHandler = null;

onMounted(() => {
    scrollHandler = () => {
        const scrollPosition = window.scrollY;
        
        let currentActiveId = activeSection.value;
        
        for (const s of sections.value) {
            const el = document.getElementById(s.id);
            if (el) {
                // Get element position relative to document
                const top = el.getBoundingClientRect().top + window.scrollY;
                // Offset by 160 to account for sticky header and smooth transition
                if (scrollPosition >= top - 160) {
                    currentActiveId = s.id;
                }
            }
        }
        
        if (currentActiveId && activeSection.value !== currentActiveId) {
            activeSection.value = currentActiveId;
        }
    };

    window.addEventListener('scroll', scrollHandler, { passive: true });
    // Trigger once on mount
    setTimeout(scrollHandler, 100);
});

onUnmounted(() => {
    if (scrollHandler) {
        window.removeEventListener('scroll', scrollHandler);
    }
});

const scrollToSection = (id) => {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};

import { usePage } from '@inertiajs/vue3';
const pageObj = usePage();

const pageTitle = computed(() => {
    const translations = pageObj.props.translations || {};
    const t = (val) => translations[val] || val;
    return `${t(props.program.majors)} — ${t(props.program.department)}`;
});
</script>

<template>
    <Head :title="pageTitle" />

    <SiteHeader/>
    <div class="bg-white font-sans">
        <!-- Page header / breadcrumb block -->
        <div class="bg-[#f4f7fb] border-b border-gray-200">
            <div class="mx-auto max-w-[1400px] px-4 py-8 md:px-6 md:py-10">
                <Link
                    :href="facultyHref"
                    class="mb-4 inline-flex items-center gap-1.5 text-sm font-semibold text-[#3852a4] hover:underline"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ $t('Back to Faculties') }}
                </Link>

                <h1 class="text-2xl font-extrabold text-[#1c244b] md:text-3xl">
                    {{ $t(program.department) }}
                </h1>
                <p class="mt-1 text-base text-gray-600">
                    {{ $t('Majors:') }} <span class="font-semibold text-[#1c244b]">{{ $t(program.majors) }}</span>
                </p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <span
                        v-for="level in program.degreeLevels"
                        :key="level"
                        class="rounded-full border border-[#3852a4]/30 bg-white px-3 py-1 text-xs font-bold uppercase tracking-wide text-[#3852a4]"
                    >
                        {{ $t(level) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Mobile TOC: horizontal chip scroller -->
        <div ref="mobileTocRef" class="sticky top-[45px] sm:top-[60px] md:top-[70px] z-30 overflow-x-auto border-b border-gray-200 bg-white/95 backdrop-blur px-4 py-3 lg:hidden no-scrollbar">
            <div class="flex w-max gap-2">
                <button
                    v-for="s in sections"
                    :key="s.id"
                    :id="'mobile-tab-' + s.id"
                    @click="scrollToSection(s.id)"
                    class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-bold transition-colors"
                    :class="activeSection === s.id
                        ? 'bg-[#3852a4] text-white'
                        : 'bg-gray-100 text-[#1c244b] hover:bg-gray-200'"
                >
                    {{ s.num }}. {{ $t(s.label) }}
                </button>
            </div>
        </div>

        <div class="mx-auto max-w-[1400px] gap-10 px-4 py-10 md:px-6 lg:flex">
            <!-- Desktop sticky sidebar TOC -->
            <aside class="hidden shrink-0 lg:block lg:w-[260px]">
                <nav class="sticky top-28 space-y-1">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-400">
                        Program Contents
                    </p>
                    <button
                        v-for="s in sections"
                        :key="s.id"
                        @click="scrollToSection(s.id)"
                        class="flex w-full items-center gap-3 rounded-r-md border-l-4 px-3 py-2.5 text-left text-sm transition-all duration-200"
                        :class="activeSection === s.id
                            ? 'border-[#b38b1d] bg-[#f4f7fb] font-extrabold text-[#b38b1d]'
                            : 'border-transparent font-semibold text-[#1c244b] hover:bg-gray-50 hover:text-[#3852a4]'"
                    >
                        <span
                            class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full text-[11px] font-bold"
                            :class="activeSection === s.id ? 'bg-[#b38b1d] text-white' : 'bg-gray-200 text-gray-600'"
                        >
                            {{ s.num }}
                        </span>
                        {{ $t(s.label) }}
                    </button>
                </nav>
            </aside>

            <!-- Main content -->
            <article class="min-w-0 flex-1 space-y-14">
                <section v-for="s in sections" :key="s.id" :id="s.id" class="scroll-mt-36">
                    <h2 class="mb-3 text-lg font-extrabold text-[#1c244b]">
                        <span class="text-[#b38b1d]">{{ s.num }}.</span> {{ $t(s.label) }}
                    </h2>
                    
                    <div v-if="s.type === 'richtext' && s.content">
                        <!-- Legacy array format like plos -->
                        <div v-if="Array.isArray(s.content) && s.content.length > 0" class="space-y-4">
                            <div
                                v-for="(item, idx) in s.content"
                                :key="idx"
                                class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition-shadow hover:shadow-md"
                            >
                                <div class="flex items-start gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f4f7fb] text-lg font-bold text-[#b38b1d]">
                                        {{ idx + 1 }}
                                    </div>
                                    <div class="pt-1">
                                        <h3 v-if="item.title || item.year || item.semester" class="mb-1 font-bold text-[#1c244b]">
                                            {{ $t(item.title || item.year || item.semester) }}
                                        </h3>
                                        <p v-if="item.desc" class="text-sm leading-relaxed text-gray-600">
                                            {{ $t(item.desc) }}
                                        </p>
                                        <p v-else-if="typeof item === 'string'" class="text-sm leading-relaxed text-gray-600">
                                            {{ $t(item) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- String format -->
                        <p v-else-if="typeof s.content === 'string'" class="leading-relaxed text-gray-700">
                            {{ $t(s.content) }}
                        </p>
                        
                        <!-- HTML/Quill format (translatable object) -->
                        <div v-else-if="s.content.en || s.content.km" class="prose max-w-none text-gray-700" v-html="$t(s.content)"></div>
                    </div>
                    
                    <!-- Course Structure Table Render -->
                    <div v-else-if="s.type === 'course_structure' && s.courseStructure && s.courseStructure.length">
                        <div v-for="yr in s.courseStructure" :key="yr.year.en" class="mb-8">
                            <h3 class="mb-3 inline-block rounded-md bg-[#3852a4] px-3 py-1 text-sm font-extrabold text-white">
                                {{ $t(yr.year) }}
                            </h3>

                            <div v-for="sem in yr.semesters" :key="sem.semester.en" class="mb-4 overflow-x-auto">
                                <p class="mb-2 text-sm font-bold text-[#1c244b]">{{ $t(sem.semester) }}</p>
                                <table class="w-full min-w-[420px] border-collapse overflow-hidden rounded-md text-sm shadow-sm">
                                    <thead>
                                        <tr class="bg-[#1c244b] text-left text-white">
                                            <th class="w-12 px-3 py-2 font-bold">{{ $t('No.') }}</th>
                                            <th class="px-3 py-2 font-bold">{{ $t('Subjects') }}</th>
                                            <th class="w-20 px-3 py-2 text-center font-bold">{{ $t('Credits') }}</th>
                                            <th class="w-20 px-3 py-2 text-center font-bold">{{ $t('Hours') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="subj in sem.subjects"
                                            :key="subj.no"
                                            class="border-b border-gray-100 odd:bg-white even:bg-gray-50"
                                        >
                                            <td class="px-3 py-2 text-gray-500">{{ subj.no }}</td>
                                            <td class="px-3 py-2 text-gray-800">{{ $t(subj.name) }}</td>
                                            <td class="px-3 py-2 text-center text-gray-800">{{ subj.credits }}</td>
                                            <td class="px-3 py-2 text-center text-gray-800">{{ subj.hours }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-end">
                                <div class="flex gap-6 rounded-md bg-[#f4f7fb] px-4 py-2 text-sm font-extrabold text-[#1c244b]">
                                    <span>{{ $t('Total') }} {{ $t(yr.year) }}</span>
                                    <span>{{ computeYearTotals(yr).credits }} {{ $t('credits') }}</span>
                                    <span>{{ computeYearTotals(yr).hours }} {{ $t('hours') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <div class="flex gap-6 rounded-md bg-[#3852a4] px-4 py-2.5 text-sm font-extrabold text-white mb-6">
                                <span>{{ $t('Total of Program') }}</span>
                                <span>{{ computeGrandTotals(s.courseStructure).credits }} {{ $t('credits') }}</span>
                                <span>{{ computeGrandTotals(s.courseStructure).hours }} {{ $t('hours') }}</span>
                            </div>
                        </div>
                        
                        <!-- Render notes if any -->
                        <div v-if="s.courseNotes && s.courseNotes.length" class="mt-4 space-y-4">
                            <div v-for="(note, nIdx) in s.courseNotes" :key="nIdx" class="prose max-w-none text-sm text-gray-600 leading-relaxed" v-html="$t(note)">
                            </div>
                        </div>
                    </div>
                    
                    <p v-else class="text-sm italic text-gray-400">{{ $t('Program details will be published soon.') }}</p>
                </section>
            </article>
        </div>
    </div>
    <SiteFooter/>
</template>

<style scoped>
/* Hide scrollbar for mobile TOC */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>