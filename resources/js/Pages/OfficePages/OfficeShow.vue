<script setup>
import { computed, ref, watch, onMounted, onUnmounted, nextTick } from 'vue';
import { Head, usePage } from "@inertiajs/vue3";
import SiteFooter from "@/Components/SiteFooter.vue";
import SiteHeader from "@/Components/SiteHeader.vue";
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    office: {
        type: String,
        default: "dormitory_office",
    },
    officeData: {
        type: Object,
        default: null
    }
});

const page = usePage();

const officeConfig = {
    academic_affairs_office: {
        title: { en: "Academic Affairs Office", km: "ការិយាល័យសិក្សាធិការ" },
        image: "https://assets.monica.im/tools-web/_next/static/media/mobile_upscale.e93d7497.webp",
        about: "The Academic Affairs Office is the central hub for all educational programs, ensuring the quality and integrity of our curriculum. We support faculty in delivering world-class education and assist students in navigating their academic journeys from enrollment to graduation.",
        mission: "To foster an innovative and rigorous academic environment that promotes intellectual growth, critical thinking, and lifelong learning among our students.",
        vision: "To be recognized globally as a leader in academic excellence, driving educational advancement and student success through cutting-edge curricula and dedicated faculty support.",
    },
    student_affairs_office: {
        title: { en: "Student Affairs Office", km: "ការិយាល័យកិច្ចការនិស្សិត" },
        image: "https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&q=80&w=1200",
        about: "The Student Affairs Office is dedicated to supporting the holistic development of our students. We manage campus life, student organizations, counseling services, and extracurricular programs to ensure a vibrant, inclusive, and supportive campus community.",
        mission: "To enhance the educational experience by providing comprehensive support services, fostering personal growth, and cultivating a diverse and inclusive campus environment.",
        vision: "To create a dynamic campus culture where every student is empowered to thrive personally, socially, and academically, preparing them for active global citizenship.",
    },
    personnel_and_human_resources: {
        title: { en: "Personnel & Human Resources Office", km: "ការិយាល័យបុគ្គលិក និងអភិវឌ្ឍន៍ធនធានមនុស្ស" },
        image: "https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&q=80&w=1200",
        about: "The Personnel and Human Resources Office manages all aspects of employment for faculty and staff. From recruitment and onboarding to professional development and benefits administration, we are committed to building a supportive and dynamic workplace.",
        mission: "To attract, retain, and develop a diverse and highly skilled workforce by providing equitable, transparent, and supportive human resource services.",
        vision: "To be an employer of choice in the higher education sector, fostering a culture of excellence, collaboration, and continuous professional growth.",
    },
    administration_and_accounting_office: {
        title: { en: "Administration & Accounting Office", km: "ការិយាល័យរដ្ឋបាល និងហិរញ្ញវត្ថុ" },
        image: "https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=1200",
        about: "This office oversees the university's financial health and administrative operations. We handle budgeting, accounting, procurement, and financial reporting to ensure resources are utilized efficiently to support the institution's strategic goals.",
        mission: "To provide transparent, accurate, and strategic financial management and administrative services that sustain and advance the university's mission.",
        vision: "To achieve financial sustainability and operational excellence through innovative practices, rigorous accountability, and strategic resource allocation.",
    },
    dormitory_office: {
        title: { en: "Dormitory Office", km: "ការិយាល័យអន្តេវាសិកដ្ឋាន" },
        image: "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&q=80&w=1200",
        about: "The Dormitory Office manages all on-campus housing facilities, ensuring a safe, comfortable, and welcoming living environment for students. We handle room assignments, facility maintenance, and residential life programming.",
        mission: "To provide secure, well-maintained, and inclusive residential communities that support the academic and personal success of our students.",
        vision: "To offer premier campus housing experiences that foster lifelong friendships, personal responsibility, and a strong sense of community belonging.",
    },
    planning_and_research_office: {
        title: { en: "Planning & Research Office", km: "ការិយាល័យផែនការ និងស្រាវជ្រាវ" },
        image: "https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=1200",
        about: "The Planning and Research Office is responsible for guiding the university's long-term strategic direction. We conduct institutional research, analyze performance metrics, and coordinate strategic planning initiatives to support evidence-based decision-making.",
        mission: "To empower university leadership with actionable data, comprehensive research, and strategic frameworks that promote continuous institutional improvement.",
        vision: "To be the catalyst for transformative institutional growth, ensuring the university remains adaptable, forward-thinking, and globally competitive.",
    },
    internal_quality_assurance_office: {
        title: { en: "Internal Quality Assurance Office", km: "ការិយាល័យធានាគុណភាពផ្ទៃក្នុង" },
        image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=1200",
        about: "The Internal Quality Assurance Office monitors and evaluates the university's programs and processes. We conduct regular audits, facilitate accreditation procedures, and promote a culture of continuous quality enhancement across all departments.",
        mission: "To safeguard and enhance the quality of education and administrative services through rigorous assessment, compliance tracking, and continuous improvement protocols.",
        vision: "To establish the university as a benchmark for quality and excellence in higher education, recognized for uncompromising standards and continuous innovation.",
    },
};

const currentOffice = computed(() => {
    const fallback = officeConfig[props.office] || officeConfig.academic_affairs_office;
    if (props.officeData) {
        return {
            ...fallback,
            ...props.officeData,
            title: props.officeData.title || fallback.title
        };
    }
    return fallback;
});

const officeTitle = computed(() => {
    const locale = page.props?.locale || 'en';
    const t = currentOffice.value?.title;
    if (t) {
        if (typeof t === 'object' && t !== null) {
            return t[locale] || t.en || t.km || '';
        }
        return page.props?.$t ? page.props.$t(t) : t;
    }
    return '';
});

const parseFontSize = (fontSizeVal) => {
    if (!fontSizeVal) return { class: '', style: {} };
    const str = String(fontSizeVal).trim();
    if (/^\d+(\.\d+)?(px|rem|em|%)?$/.test(str)) {
        const num = parseFloat(str);
        const unit = /[a-z%]+$/i.exec(str) ? /[a-z%]+$/i.exec(str)[0] : 'px';
        return { class: '', style: { fontSize: `${num}${unit}` } };
    }
    return { class: str, style: {} };
};

const colors = [
    'bg-blue-50 text-blue-600',
    'bg-amber-50 text-amber-600',
    'bg-emerald-50 text-emerald-600',
    'bg-purple-50 text-purple-600',
    'bg-rose-50 text-rose-600'
];

const icons = [
    'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', // Info
    'M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z', // Bookmark
    'M15 12a3 3 0 11-6 0 3 3 0 016 0z', // Eye (inner)
    'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', // Briefcase
    'M13 10V3L4 14h7v7l9-11h-7z' // Lightning
];

const getIconColorClass = (idx) => colors[idx % colors.length];
const getIconPath = (idx) => icons[idx % icons.length];

const imgFailed = ref(false);

const handleImageError = () => {
    imgFailed.value = true;
};

watch(() => props.officeData?.image, () => {
    imgFailed.value = false;
});

const normalizedSections = computed(() => {
    let office = currentOffice.value;
    if (office.custom_sections && office.custom_sections.length > 0) {
        try {
            return typeof office.custom_sections === 'string' 
                ? JSON.parse(office.custom_sections) 
                : office.custom_sections;
        } catch (e) {
            return [];
        }
    }
    
    // Fallback to legacy structure
    let sections = [];
    if (office.about) {
        sections.push({ title: { en: 'About', km: 'អំពី' }, content: office.about });
    }
    if (office.mission) {
        sections.push({ title: { en: 'Mission', km: 'បេសកកម្ម' }, content: office.mission });
    }
    if (office.vision) {
        sections.push({ title: { en: 'Vision', km: 'ចក្ខុវិស័យ' }, content: office.vision });
    }
    return sections;
});

// Build the array of contents for the sidebar
const allContents = computed(() => {
    const list = [];
    normalizedSections.value.forEach((sec) => {
        list.push({
            idx: list.length,
            type: 'richtext',
            label: sec.title,
            content: sec.content,
            title_font_size: sec.title_font_size
        });
    });
    return list;
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
        
        for (const prog of allContents.value) {
            const el = document.getElementById('program-section-' + prog.idx);
            if (el) {
                const top = el.getBoundingClientRect().top + window.scrollY;
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
</script>

<template>
    <Head :title="officeTitle" />
    
    <SiteHeader />
    <div class="min-h-screen bg-global-bg font-sans flex flex-col relative overflow-hidden">
        
        <!-- Mobile TOC: horizontal chip scroller -->
        <div ref="mobileTocRef" v-if="allContents.length > 0" class="sticky top-[45px] sm:top-[60px] md:top-[70px] z-40 overflow-x-auto border-b border-gray-300/70 bg-global-bg/95 backdrop-blur px-4 py-3 lg:hidden shadow-sm no-scrollbar">
            <div class="flex w-max gap-2">
                <button
                    v-for="(prog, idx) in allContents"
                    :key="idx"
                    :id="'mobile-tab-' + prog.idx"
                    @click="scrollToSection(prog.idx)"
                    class="whitespace-nowrap rounded-full px-5 py-2 text-sm font-bold transition-colors border shadow-sm"
                    :class="activeProgramIndex === prog.idx
                        ? 'bg-[#115D6D] text-white border-[#115D6D]'
                        : 'bg-white/80 text-[#115D6D] border-[#115D6D] hover:bg-white'"
                >
                    {{ idx + 1 }}. {{ $t(prog.label) }}
                </button>
            </div>
        </div>

        <main class="flex-grow py-8 md:py-12 relative z-10">
            <div v-if="allContents.length > 0" class="max-w-[1400px] mx-auto px-4 sm:px-6 mb-16 space-y-10">
                <!-- Hero Image -->
                <section v-if="currentOffice.image && currentOffice.image.trim() !== '' && !imgFailed" class="relative animate-fade-in-up">
                    <div class="relative overflow-hidden lg:rounded-2xl rounded-xl shadow-[0_20px_50px_rgb(0,0,0,0.1)] w-full bg-white">
                        <img 
                            :src="currentOffice.image" 
                            :alt="officeTitle" 
                            class="w-full h-auto block"
                            @error="handleImageError"
                        />
                    </div>
                </section>

                <!-- Title Focus -->
                <section class="animate-fade-in-up flex flex-col items-center text-center max-w-4xl mx-auto space-y-4" style="animation-delay: 0.1s">
                    <h1 
                        :class="['font-extrabold leading-[1.1] tracking-tight text-[#1c244b] drop-shadow-sm', parseFontSize(currentOffice.title_font_size).class || 'text-3xl md:text-5xl']"
                        :style="parseFontSize(currentOffice.title_font_size).style"
                    >
                        {{ officeTitle }}
                    </h1>
                </section>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                    <!-- Sticky Sidebar -->
                    <div class="hidden lg:block lg:col-span-1 sticky top-[100px] self-start h-fit z-10 transition-all duration-300">
                        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                            <h3 class="text-base font-bold text-gray-900 mb-4">{{ officeTitle }}</h3>
                            <div class="space-y-2">
                                <button 
                                    v-for="(prog, idx) in allContents" 
                                    :key="idx"
                                    @click="scrollToSection(idx)"
                                    class="w-full text-left px-4 py-2.5 rounded-md text-sm font-bold transition-colors"
                                    :class="activeProgramIndex === idx ? 'bg-[#0d4a57] text-white shadow-sm' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'"
                                >
                                    <span>{{ $t(prog.label) }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content -->
                    <div class="lg:col-span-3 space-y-12">
                        <div v-for="(prog, idx) in allContents" :key="idx" :id="'program-section-' + prog.idx" class="bg-white rounded-xl p-6 md:p-10 shadow-sm border border-gray-100 animate-fade-in-up" :style="{ animationDelay: (0.2 + (idx * 0.1)) + 's' }">
                            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl shrink-0 shadow-sm" :class="getIconColorClass(idx)">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getIconPath(idx)" />
                                    </svg>
                                </div>
                                <h2 
                                    :class="['font-extrabold text-[#1c244b]', parseFontSize(prog.title_font_size).class || 'text-2xl']"
                                    :style="parseFontSize(prog.title_font_size).style"
                                >
                                    {{ $t(prog.label) }}
                                </h2>
                            </div>
                            <!-- Rich Text Render -->
                            <div class="ql-editor px-0 text-gray-700 leading-relaxed text-base" v-html="$t(prog.content)"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="max-w-[1400px] mx-auto px-4 sm:px-6 mb-16 text-center text-gray-500 py-20 bg-white/50 rounded-3xl">
                {{ $t('No content available.') }}
            </div>
        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.animate-fade-in-up {
    opacity: 0;
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.animate-blob {
    animation: blob 8s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(24px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
</style>
