<script setup>
import { Head, Link } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';

const props = defineProps({
    department: {
        type: Object,
        required: true,
    },
    facultyId: {
        type: [String, Number],
        required: true,
    }
});

const getCustomSections = () => {
    if (!props.department.custom_sections) return [];
    try {
        return typeof props.department.custom_sections === 'string' 
            ? JSON.parse(props.department.custom_sections) 
            : props.department.custom_sections;
    } catch (e) {
        return [];
    }
};

const majorsData = computed(() => {
    let raw = props.department.majors;
    if (!raw) return [];
    if (typeof raw === 'string') {
        try { raw = JSON.parse(raw); } catch(e) { raw = []; }
    }
    if (!Array.isArray(raw)) raw = [raw];

    const rawDeptPrograms = props.department.programs || { bachelor: null, associate: null };
    let oldDeptProgramsObj = typeof rawDeptPrograms === 'string' ? JSON.parse(rawDeptPrograms) : rawDeptPrograms;

    return raw.map((m, index) => {
        if (m.name) {
            return {
                name: m.name,
                programs: m.programs || { bachelor: null, associate: null }
            };
        } else {
            return {
                name: m,
                programs: index === 0 ? oldDeptProgramsObj : { bachelor: null, associate: null }
            };
        }
    });
});

const activeMajorIndex = ref(0);

const programs = computed(() => {
    if (majorsData.value.length === 0) return { bachelor: null, associate: null };
    const m = majorsData.value[activeMajorIndex.value];
    return m && m.programs ? m.programs : { bachelor: null, associate: null };
});

const legacySections = [
    { key: 'programAim', label: '1. Program Aim' },
    { key: 'plos', label: '2. Program Learning Outcomes (PLOs)' },
    { key: 'termsOfAdmission', label: '3. Terms of Admission' },
    { key: 'totalCredits', label: '4. Total Credits' },
    { key: 'courseStructure', label: '5. Course Structure' },
    { key: 'graduationRequirements', label: '6. Graduation Requirements' },
    { key: 'degreeTitleAwarded', label: '7. Degree Title Awarded' },
    { key: 'careerOpportunities', label: '8. Career Opportunities' }
];

const hasContent = (obj) => {
    if (!obj) return false;
    if (obj.sections && Array.isArray(obj.sections)) {
        return obj.sections.some(s => s.content && (s.content.en || s.content.km));
    }
    for (const sec of legacySections) {
        if (obj[sec.key] && (obj[sec.key].en || obj[sec.key].km)) {
            return true;
        }
    }
    return false;
};

const hasBachelor = computed(() => hasContent(programs.value.bachelor));
const hasAssociate = computed(() => hasContent(programs.value.associate));

const activeDegree = ref('bachelor');


watch([hasBachelor, hasAssociate, activeMajorIndex], () => {
    if (!hasBachelor.value && hasAssociate.value) {
        activeDegree.value = 'associate';
    } else if (hasBachelor.value && !hasAssociate.value) {
        activeDegree.value = 'bachelor';
    }
}, { immediate: true });

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

const currentDegreePrograms = computed(() => {
    const progObj = programs.value[activeDegree.value];
    if (!progObj) return [];
    
    if (progObj.sections && Array.isArray(progObj.sections)) {
        return progObj.sections.map((sec, i) => ({
            idx: i,
            type: sec.type || 'richtext',
            label: sec.title,
            content: sec.content,
            courseStructure: sec.courseStructure || [],
            courseNotes: sec.courseNotes || [],
            customTable: sec.customTable || null
        })).filter(s => {
            const hasContent = (s.content && (s.content.en || s.content.km)) || 
                (s.type === 'course_structure' && s.courseStructure && s.courseStructure.length) ||
                (s.type === 'custom_table' && s.customTable && s.customTable.headers && s.customTable.rows);
            if (!hasContent) return false;

            const labelStr = (typeof s.label === 'object' ? (s.label.en || s.label.km || '') : String(s.label || '')).toLowerCase();
            return labelStr.includes('career');
        });
    }
    
    // Legacy format
    const filledSections = [];
    for (let i = 0; i < legacySections.length; i++) {
        const sec = legacySections[i];
        if (progObj[sec.key]) {
            const isCourseStruct = sec.key === 'courseStructure' && Array.isArray(progObj[sec.key]);
            if (isCourseStruct || progObj[sec.key].en || progObj[sec.key].km) {
                const labelStr = (typeof sec.label === 'object' ? (sec.label.en || sec.label.km || '') : String(sec.label || '')).toLowerCase();
                if (!labelStr.includes('career')) {
                    continue;
                }
                filledSections.push({
                    idx: i,
                    type: isCourseStruct ? 'course_structure' : 'richtext',
                    label: { en: sec.label, km: sec.label },
                    content: isCourseStruct ? { en: '', km: '' } : progObj[sec.key],
                    courseStructure: isCourseStruct ? progObj[sec.key] : [],
                    courseNotes: isCourseStruct && progObj.courseNotes ? progObj.courseNotes.map(n => typeof n === 'string' ? { en: n, km: n } : n) : []
                });
            }
        }
    }
    return filledSections;
});
const activeProgramIndex = ref(0);
const mobileTocRef = ref(null);

watch(activeProgramIndex, async (newVal) => {
    await nextTick();
    if (mobileTocRef.value) {
        const activeTab = document.getElementById('mobile-tab-' + newVal);
        if (activeTab) {
            const container = mobileTocRef.value;
            const tabRect = activeTab.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            const scrollLeft = activeTab.offsetLeft - (containerRect.width / 2) + (tabRect.width / 2);
            container.scrollTo({ left: scrollLeft, behavior: 'smooth' });
        }
    }
});
let scrollHandler = null;

onMounted(() => {
    scrollHandler = () => {
        const scrollPosition = window.scrollY;
        let currentActiveIdx = activeProgramIndex.value;
        
        for (const prog of currentDegreePrograms.value) {
            const el = document.getElementById('program-section-' + prog.idx);
            if (el) {
                // Get element position relative to document
                const top = el.getBoundingClientRect().top + window.scrollY;
                // Offset by 160 to account for sticky header and smooth transition
                if (scrollPosition >= top - 160) {
                    currentActiveIdx = prog.idx;
                }
            }
        }
        
        if (activeProgramIndex.value !== currentActiveIdx) {
            activeProgramIndex.value = currentActiveIdx;
        }
    };

    window.addEventListener('scroll', scrollHandler, { passive: true });
    setTimeout(scrollHandler, 100);
});

onUnmounted(() => {
    if (scrollHandler) {
        window.removeEventListener('scroll', scrollHandler);
    }
});

const scrollToSection = (idx) => {
    activeProgramIndex.value = idx;
    const el = document.getElementById('program-section-' + idx);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
};

const formatTextToList = (text) => {
    if (!text) return '';
    const textStr = typeof text === 'object' ? (text.en || text.km || '') : String(text);
    if (textStr.includes('<') && textStr.includes('>')) {
        return textStr;
    }
    const lines = textStr.split('\n').map(l => l.trim()).filter(l => l.length > 0);
    if (lines.length > 1) {
        const items = lines.map(l => l.startsWith('-') || l.startsWith('•') ? l.substring(1).trim() : l);
        return `<ul class="list-disc list-outside ml-4 space-y-1">${items.map(i => `<li>${i}</li>`).join('')}</ul>`;
    }

    return lines.join('<br>');
};
</script>

<template>
    <Head :title="$t(department.title)" />

    <div class="min-h-screen bg-[#c9e0e4] font-sans flex flex-col">
        <SiteHeader />

        <!-- Page Header Block -->
        <div class="bg-[#c9e0e4] border-b border-slate-300/60">
            <div class="mx-auto max-w-[1400px] px-4 py-8 md:px-6 md:py-10">
                <Link
                    :href="`/department/${facultyId}`"
                    class="mb-4 inline-flex items-center gap-1.5 text-sm font-semibold text-[#115D6D] hover:underline"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    {{ $t('Back to') }} {{ $t(department.faculty) }}
                </Link>

                <h1 class="text-2xl font-extrabold text-[#1c244b] md:text-3xl">
                    {{ $t(department.title) }}
                </h1>
                <div v-if="majorsData.length > 0" class="mt-4 mb-6 flex flex-wrap items-center gap-2">
                    <span class="text-gray-600 mr-1 font-medium">{{ $t('Majors') }}:</span>
                    <button
                        v-for="(major, idx) in majorsData"
                        :key="idx"
                        @click="activeMajorIndex = idx; activeProgramIndex = 0;"
                        class="px-4 py-1.5 rounded-full text-sm font-semibold transition-colors border shadow-sm"
                        :class="activeMajorIndex === idx ? 'bg-[#1c244b] text-white border-[#1c244b]' : 'bg-white/80 text-gray-700 border-gray-300 hover:bg-white'"
                    >
                        {{ $t(major.name) }}
                    </button>
                </div>


                <!-- Degree Tabs -->
                <div class="flex flex-wrap gap-3">
                    <button 
                        @click="activeDegree = 'bachelor'; activeProgramIndex = 0;"
                        class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors shadow-sm"
                        :class="activeDegree === 'bachelor' ? 'bg-[#115D6D] text-white border-2 border-[#115D6D]' : 'bg-white/70 text-[#115D6D] border-2 border-[#115D6D] hover:bg-white'"
                    >
                        {{ $t("Bachelor's Degree") }}
                    </button>
                    <button 
                        @click="activeDegree = 'associate'; activeProgramIndex = 0;"
                        class="px-5 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-colors shadow-sm"
                        :class="activeDegree === 'associate' ? 'bg-[#115D6D] text-white border-2 border-[#115D6D]' : 'bg-white/70 text-[#115D6D] border-2 border-[#115D6D] hover:bg-white'"
                    >
                        {{ $t("Associate's Degree") }}
                    </button>
                </div>
            </div>
        </div>


        <!-- Mobile TOC: horizontal chip scroller -->
        <div ref="mobileTocRef" v-if="currentDegreePrograms.length > 0" class="sticky top-[45px] sm:top-[60px] md:top-[70px] z-40 overflow-x-auto border-b border-gray-300/70 bg-[#c9e0e4]/95 backdrop-blur px-4 py-3 lg:hidden shadow-sm no-scrollbar">
            <div class="flex w-max gap-2">
                <button
                    v-for="(prog, idx) in currentDegreePrograms"
                    :key="idx"
                    :id="'mobile-tab-' + prog.idx"
                    @click="scrollToSection(prog.idx)"
                    class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-bold transition-colors border"
                    :class="activeProgramIndex === prog.idx
                        ? 'bg-[#3852a4] text-white border-[#3852a4]'
                        : 'bg-white text-[#1c244b] border-gray-200 hover:bg-gray-50'"
                >
                    {{ idx + 1 }}. {{ $t(prog.label) }}
                </button>
            </div>
        </div>

        <main class="flex-grow py-8 md:py-12">
            <!-- Degree Programs Layout (if exists) -->
            <div v-if="currentDegreePrograms.length > 0" class="max-w-[1400px] mx-auto px-4 sm:px-6 mb-16">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                    <!-- Left Sidebar (PROGRAM CONTENTS) - Desktop Only -->
                    <div class="hidden lg:block lg:col-span-1">
                        <div class="sticky top-24">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">{{ $t('Program Contents') }}</h3>
                            <div class="space-y-1">
                                <button 
                                    v-for="(prog, idx) in currentDegreePrograms" 
                                    :key="idx"
                                    @click="scrollToSection(idx)"
                                    class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-3 transition-colors"
                                    :class="activeProgramIndex === idx ? 'bg-slate-100 text-[#1c244b] border-l-4 border-[#eab308]' : 'text-slate-600 hover:bg-slate-50 border-l-4 border-transparent'"
                                >
                                    <span class="w-6 h-6 shrink-0 rounded-full flex items-center justify-center text-xs" :class="activeProgramIndex === idx ? 'bg-[#eab308] text-white' : 'bg-slate-200 text-slate-500'">{{ idx + 1 }}</span>
                                    <span>{{ $t(prog.label) }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content -->
                    <div class="lg:col-span-3 space-y-16">
                        <div v-for="(prog, idx) in currentDegreePrograms" :key="idx" :id="'program-section-' + prog.idx">
                            <h2 class="text-xl font-bold text-[#1c244b] mb-4 flex items-center gap-2">
                                <span class="text-[#eab308]">{{ idx + 1 }}.</span> {{ $t(prog.label) }}
                            </h2>
                            
                            <!-- Rich Text Render -->
                            <div v-if="prog.type === 'richtext'" class="ql-editor px-0 text-gray-700 leading-relaxed" v-html="$t(prog.content)"></div>
                            
                            <!-- Course Structure Render -->
                            <div v-else-if="prog.type === 'course_structure' && prog.courseStructure && prog.courseStructure.length">
                                <div v-for="yr in prog.courseStructure" :key="yr.year.en" class="mb-8">
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
                                        <span>{{ computeGrandTotals(prog.courseStructure).credits }} {{ $t('credits') }}</span>
                                        <span>{{ computeGrandTotals(prog.courseStructure).hours }} {{ $t('hours') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Render notes if any -->
                                <div v-if="prog.courseNotes && prog.courseNotes.length" class="mt-4 space-y-4">
                                    <div v-for="(note, nIdx) in prog.courseNotes" :key="nIdx" class="ql-editor px-0 text-sm text-gray-600 leading-relaxed" v-html="$t(note)">
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Data Table Render -->
                            <div v-else-if="prog.type === 'custom_table' && prog.customTable && prog.customTable.headers && prog.customTable.rows" class="mb-8">
                                <!-- Blue Pill Badge -->
                                <div v-if="prog.customTable.badge && (prog.customTable.badge.en || prog.customTable.badge.km)" class="mb-3">
                                    <h3 class="inline-block rounded-md bg-[#3852a4] px-3 py-1 text-sm font-extrabold text-white">
                                        {{ $t(prog.customTable.badge) }}
                                    </h3>
                                </div>

                                <!-- Subtitle -->
                                <p v-if="prog.customTable.subtitle && (prog.customTable.subtitle.en || prog.customTable.subtitle.km)" class="mb-2 text-sm font-bold text-[#1c244b]">
                                    {{ $t(prog.customTable.subtitle) }}
                                </p>

                                <div class="overflow-x-auto my-2">
                                    <table class="w-full min-w-[420px] border-collapse overflow-hidden rounded-md text-sm shadow-sm border border-gray-100">
                                        <thead>
                                            <tr class="bg-[#1c244b] text-left text-white">
                                                <th v-if="prog.customTable.showRowNumbers !== false" class="w-14 px-3 py-2 font-bold text-center border-r border-slate-700/50">
                                                    {{ (prog.customTable.indexHeader && typeof prog.customTable.indexHeader === 'string') ? prog.customTable.indexHeader : (prog.customTable.indexHeader ? $t(prog.customTable.indexHeader) : '#') }}
                                                </th>
                                                <th v-for="head in prog.customTable.headers" :key="head.key" 
                                                    class="px-3.5 py-3 font-bold border-r border-slate-700/50 last:border-r-0"
                                                    :class="[
                                                        (head.headerAlign || head.align || 'center') === 'center' ? 'text-center' : (head.headerAlign || head.align) === 'right' ? 'text-right' : 'text-left',
                                                        head.width === '12' ? 'w-12' : head.width === '20' ? 'w-20' : head.width === '32' ? 'w-32' : head.width === '48' ? 'w-48' : ''
                                                    ]">
                                                    {{ $t(head.label) }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(row, rIdx) in prog.customTable.rows" :key="rIdx" class="border-b border-gray-100 odd:bg-white even:bg-gray-50 hover:bg-blue-50/30 transition-colors">
                                                <td v-if="prog.customTable.showRowNumbers !== false" class="px-3 py-2 text-center text-gray-500 font-semibold text-xs border-r border-gray-100">{{ rIdx + 1 }}</td>
                                                <td v-for="head in prog.customTable.headers" :key="head.key" 
                                                    class="ql-editor px-3.5 py-3 text-gray-800 border-r border-gray-100 last:border-r-0 leading-relaxed"
                                                    :class="[
                                                        (head.bodyAlign || head.align || 'left') === 'center' ? 'text-center' : (head.bodyAlign || head.align) === 'right' ? 'text-right' : 'text-left',
                                                        (head.verticalAlign || 'top') === 'middle' ? 'align-middle' : (head.verticalAlign || 'top') === 'bottom' ? 'align-bottom' : 'align-top'
                                                    ]"
                                                    v-html="formatCellHtml($t(row[head.key]))">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Footer Note / Summary Pill -->
                                <div v-if="prog.customTable.footerNote && (prog.customTable.footerNote.en || prog.customTable.footerNote.km)" class="flex justify-end mt-3">
                                    <div class="flex gap-6 rounded-md bg-[#f4f7fb] px-4 py-2 text-sm font-extrabold text-[#1c244b]">
                                        <span>{{ $t(prog.customTable.footerNote) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legacy Layout (Mission, Vision, Goals, Custom Sections) -->
            <div v-if="!currentDegreePrograms.length" class="max-w-[1400px] mx-auto px-4 sm:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    
                    <!-- Main Content for Custom Sections -->
                    <div class="lg:col-span-3">
                        <div v-if="getCustomSections().length > 0" class="space-y-12">
                            <section v-for="(section, idx) in getCustomSections()" :key="idx" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-[#1c244b] prose-a:text-blue-600 hover:prose-a:text-blue-800 prose-img:rounded-xl">
                                <h2 v-if="section.title" class="text-2xl font-bold mb-6 text-[#1c244b] pb-3 border-b border-gray-100">{{ $t(section.title) }}</h2>
                                <div v-html="$t(section.content)"></div>
                            </section>
                        </div>

                    </div>

                </div>
            </div>
        </main>

        <SiteFooter />
    </div>
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
