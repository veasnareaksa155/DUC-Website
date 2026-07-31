<script setup>
import { ref, onMounted, computed } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import SiteHeader from "@/Components/SiteHeader.vue";
import SiteFooter from "@/Components/SiteFooter.vue";
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    pageData: {
        type: Object,
        default: null
    },
    faculties: {
        type: Array,
        default: () => []
    }
});

const isVisible = ref(false);

const history = computed(() => {
    return props.pageData?.history || `The Digital University of Cambodia (DUC) is the first digital university in the Kingdom of Cambodia to focus on technology in line with the Royal Government of Cambodia's strategy of one corner: technology.

The DUC was recognized by a Royal Decree dated March 22, 2024. After operating for the past four months, DUC has been operating normally, with activities in the Faculty of Digital Industry, Faculty of Foreign Languages Education, Faculty of Agriculture and Rural Development, and Faculty of Engineering and Architecture, Faculty of Law and Political Science, Faculty of Economics and Finance. These include the Department of Information Technology, the Department of Graphic Design, the Department of Digital Marketing, the Department of Social Media, the Department of English Education, the Department of Agriculture and Horticulture, the Department of Architecture and the Department of Public Administration, the Department of Economics and the Department of Public Administration.

At the same time, the university does not yet have a platform such as the official website of the university. Comprehensive and convenient for International course for use in DUC.`;
});

const departments = computed(() => {
    if (props.pageData) {
        return props.pageData.goals || [];
    }
    return [
        "The Department of Graphic Design,",
        "the Department of Digital Marketing,",
        "the Department of Social Media,",
        "the Department of English Education,",
        "the Department of Agriculture and Horticulture,",
        "the Department of Architecture and",
        "the Department of Public Administration,",
        "the Department of Economics and",
        "the Department of Public Administration.",
    ];
});

const mission = computed(() => {
    if (props.pageData) {
        return props.pageData.mission || "";
    }
    return "The DUC was recognized by a Royal Decree dated March 22, 2024. After operating for the past four months, DUC has been operating normally, with activities in the Faculty of Digital Industry, Faculty of Foreign Languages Education, Faculty of Agriculture and Rural Development, and Faculty of Engineering and Architecture, Faculty of Law and Political Science, Faculty Economics and Finance. These include the Department of Information Technology.";
});

const vision = computed(() => {
    if (props.pageData) {
        return props.pageData.vision || "";
    }
    return "Vision content coming soon...";
});

const hasMissionOrVision = computed(() => {
    const m = typeof mission.value === 'object' ? (mission.value?.en || mission.value?.km) : mission.value;
    const v = typeof vision.value === 'object' ? (vision.value?.en || vision.value?.km) : vision.value;
    const hasM = m && m.trim() !== '' && m !== '<p></p>';
    const hasV = v && v.trim() !== '' && v !== '<p></p>' && v !== 'Vision content coming soon...';
    return hasM || hasV;
});

// Clean up department list (formatting names, filtering duplicates, removing conjunctions)
const processedDepartments = computed(() => {
    const raw = departments.value;
    const items = raw.map(dept => {
        let enName = '';
        let kmName = '';
        
        if (typeof dept === 'object' && dept !== null) {
            enName = dept.en || '';
            kmName = dept.km || '';
        } else if (typeof dept === 'string') {
            enName = dept;
            kmName = dept; // fallback
        }
        
        // Clean both names (remove trailing punctuation, replace "the Department of" with "Department of")
        const cleanName = (str) => {
            let name = str.trim();
            name = name.replace(/[,.]\s*$/, '').trim();
            name = name.replace(/\s+and\s*$/, '').trim();
            
            if (name.toLowerCase().startsWith('the department of')) {
                name = 'Department of' + name.slice(17);
            } else if (name.toLowerCase().startsWith('the department')) {
                name = 'Department' + name.slice(14);
            } else if (name.toLowerCase().startsWith('the ')) {
                name = name.slice(4);
            }
            return name;
        };

        const cleanedEn = cleanName(enName);
        const cleanedKm = cleanName(kmName);

        return {
            en: cleanedEn,
            km: cleanedKm,
            matchKey: cleanedEn,
            labelObj: {
                en: cleanedEn,
                km: cleanedKm
            }
        };
    }).filter(item => item.en.length > 0);

    // Remove duplicates based on English name
    const seen = new Set();
    return items.filter(item => {
        const duplicate = seen.has(item.en.toLowerCase());
        seen.add(item.en.toLowerCase());
        return !duplicate;
    });
});

// List of faculties parsed dynamically from props or fallback
const displayedFaculties = computed(() => {
    if (props.faculties && props.faculties.length > 0) {
        return props.faculties.map(fac => ({
            id: fac.id,
            name: fac.name,
            href: `/department/${fac.id}`
        }));
    }
    return [
        { id: 1, name: "Faculty of Digital Industry", href: "/department/1" },
        { id: 2, name: "Faculty of Foreign Languages Education", href: "/department/2" },
        { id: 3, name: "Faculty of Agriculture and Rural Development", href: "/department/4" },
        { id: 4, name: "Faculty of Engineering and Architecture", href: "/department/3" },
        { id: 5, name: "Faculty of Law and Political Science", href: "/department/5" },
        { id: 6, name: "Faculty of Economics and Finance", href: "/department/6" },
    ];
});

// A static mapping helper for department links
const getDepartmentLink = (matchKey) => {
    const name = matchKey.toLowerCase();
    if (name.includes('design') || name.includes('graphic')) {
        return '/faculty/1/department/graphic-design';
    }
    if (name.includes('marketing')) {
        return '/faculty/1/department/digital-marketing';
    }
    if (name.includes('social') || name.includes('media')) {
        return '/faculty/1/department/social-media';
    }
    if (name.includes('english') || name.includes('education')) {
        return '/faculty/2/department/english-education';
    }
    if (name.includes('agriculture') || name.includes('horticulture') || name.includes('agronomy')) {
        return '/faculty/4/department/agronomy-and-horticulture';
    }
    if (name.includes('architecture') || name.includes('engineering')) {
        return '/faculty/3/department/engineering';
    }
    if (name.includes('public') || name.includes('administration')) {
        return '/faculty/5/department/public-administration';
    }
    if (name.includes('economics') || name.includes('finance') || name.includes('economy')) {
        return '/faculty/6/department/digital-economy';
    }
    if (name.includes('information') || name.includes('technology') || name.includes('computer')) {
        return '/faculty/1/department/information-technology';
    }
    return null;
};

onMounted(() => {
    isVisible.value = true;
});
</script>

<template>
    <Head :title="$t('About Us')" />
    
    <SiteHeader />
    <div class="min-h-screen flex flex-col bg-slate-50 text-gray-900 font-sans selection:bg-blue-300 overflow-hidden relative">
        
        <!-- VIBRANT Abstract Background Mesh -->
        <div class="absolute top-0 left-0 right-0 h-[700px] overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-40 -right-20 w-[600px] h-[600px] rounded-full bg-cyan-400/20 blur-[120px] mix-blend-multiply opacity-80 animate-blob"></div>
            <div class="absolute top-10 -left-20 w-[500px] h-[500px] rounded-full bg-blue-400/20 blur-[120px] mix-blend-multiply opacity-80 animate-blob animation-delay-2000"></div>
            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px]"></div>
        </div>

        <main class="flex-grow w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-10 transition-opacity duration-1000" :class="isVisible ? 'opacity-100' : 'opacity-0'">
            <!-- Banner Image -->
            <section v-if="props.pageData?.about_image" class="relative animate-fade-in-up">
                <div class="relative overflow-hidden lg:rounded-2xl rounded-xl shadow-[0_20px_50px_rgb(0,0,0,0.1)] w-full bg-white">
                    <img 
                        :src="props.pageData?.about_image" 
                        alt="About Us Banner" 
                        class="w-full h-auto block"
                    />
                </div>
            </section>

            <!-- Title -->
            <section class="animate-fade-in-up flex flex-col items-center text-center max-w-4xl mx-auto space-y-4" style="animation-delay: 0.1s">
                <h1 :class="['font-extrabold leading-[1.1] tracking-tight text-[#283593] drop-shadow-sm', props.pageData?.title_font_size || 'text-4xl sm:text-5xl lg:text-6xl']">
                    {{ $t('About Us') }}
                </h1>
            </section>

            <!-- Organizational Details (History & Faculties) -->
            <section class="animate-fade-in-up pt-1" style="animation-delay: 0.2s">
                <div class="text-justify rounded-3xl md:rounded-[2.5rem] border border-white/60 bg-white/80 p-5 sm:p-8 lg:p-12 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                        <!-- History Text -->
                        <div class="lg:col-span-8 space-y-6">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h2 class="text-3xl font-extrabold text-[#283593]">
                                    {{ $t('History of DUC') }}
                                </h2>
                            </div>
                            <div class="text-lg font-medium leading-relaxed text-slate-700 ql-editor px-0" v-html="$t(history)"></div>
                        </div>

                        <!-- Side list of faculties -->
                        <div class="lg:col-span-4 w-full">
                            <div class="rounded-2xl border border-slate-100 bg-[#f8fafc] p-6 shadow-sm">
                                <h3 class="text-xl font-extrabold text-[#283593] mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $t('Faculties') }}
                                </h3>
                                <ul class="space-y-3">
                                    <li v-for="fac in displayedFaculties" :key="fac.id">
                                        <Link 
                                            :href="fac.href" 
                                            class="flex items-start gap-2.5 text-slate-700 text-sm font-semibold hover:text-blue-600 transition-colors duration-150 group"
                                        >
                                            <span class="text-blue-600 mt-1 group-hover:translate-x-0.5 transition-transform">•</span>
                                            <span class="group-hover:underline">{{ $t(fac.name) }}</span>
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Mission & Vision Shared Card -->
            <section v-if="hasMissionOrVision" class="animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="text-justify rounded-3xl md:rounded-[2.5rem] border border-white/60 bg-white/80 p-5 sm:p-8 lg:p-12 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] grid md:grid-cols-2 gap-8 lg:gap-12">
                    
                    <!-- Mission -->
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-[#283593]">
                                {{ $t('Mission') }}
                            </h2>
                        </div>
                        <div class="text-lg font-medium leading-relaxed text-slate-700 ql-editor px-0" v-html="$t(mission)"></div>
                    </div>

                    <!-- Vision -->
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-[#283593]">
                                {{ $t('Vision') }}
                            </h2>
                        </div>
                        <div class="text-lg font-medium leading-relaxed text-slate-700">
                            <p class="text-slate-400 italic py-2" v-if="vision === 'Vision content coming soon...'">
                                <em>{{ $t(vision) }}</em>
                            </p>
                            <div v-else class="ql-editor px-0" v-html="$t(vision)"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Goals and Purposes (Departments) Card -->
            <section v-if="processedDepartments && processedDepartments.length > 0" class="animate-fade-in-up" style="animation-delay: 0.4s">
                <div class="text-justify rounded-3xl md:rounded-[2.5rem] border border-white/60 bg-white/80 p-5 sm:p-8 lg:p-12 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-[#283593]">
                            {{ $t('Goals and Purposes') }}
                        </h2>
                    </div>

                    <p class="text-lg font-medium text-slate-600 leading-relaxed mb-6">
                        {{ $t('Our specialized departments are designed to prepare students with industry-relevant skills and comprehensive knowledge.') }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <Link 
                            v-for="(item, index) in processedDepartments" 
                            :key="index"
                            :href="getDepartmentLink(item.matchKey) || '/faculties'"
                            class="flex items-center gap-3 p-4 rounded-2xl bg-[#f8fafc] border border-slate-100 hover:bg-white hover:shadow-md hover:border-blue-200 hover:-translate-y-0.5 transition-all duration-200 group cursor-pointer"
                        >
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-base font-semibold text-slate-700 group-hover:text-blue-700 transition-colors duration-200">
                                {{ $t(item.labelObj) }}
                            </span>
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Dynamic CMS Sections -->
            <template v-if="props.pageData?.custom_sections?.length">
                <section 
                    v-for="(section, idx) in props.pageData.custom_sections" 
                    :key="'custom-'+idx" 
                    class="animate-fade-in-up"
                    style="animation-delay: 0.5s"
                >
                    <div class="text-justify rounded-3xl md:rounded-[2.5rem] border border-white/60 bg-white/80 p-5 sm:p-8 lg:p-12 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] space-y-6">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-[#283593]">
                                {{ $t(section.title) }}
                            </h2>
                        </div>
                        <div class="text-lg font-medium leading-relaxed text-slate-700 ql-editor" v-html="$t(section.content)">
                        </div>
                    </div>
                </section>
            </template>
        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
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