<script setup>
import { computed } from 'vue';
import { Head } from "@inertiajs/vue3";
import SiteFooter from "@/Components/SiteFooter.vue";
import SiteHeader from "@/Components/SiteHeader.vue";

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

const officeConfig = {
    academic_affairs_office: {
    
        title: "Academic Affairs Office",
        
        image: "https://assets.monica.im/tools-web/_next/static/media/mobile_upscale.e93d7497.webp",
        about: "The Academic Affairs Office is the central hub for all educational programs, ensuring the quality and integrity of our curriculum. We support faculty in delivering world-class education and assist students in navigating their academic journeys from enrollment to graduation.",
        mission: "To foster an innovative and rigorous academic environment that promotes intellectual growth, critical thinking, and lifelong learning among our students.",
        vision: "To be recognized globally as a leader in academic excellence, driving educational advancement and student success through cutting-edge curricula and dedicated faculty support.",
    },
    student_affairs_office: {
   
        title: "Student Affairs Office",
       
        image: "https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?auto=format&fit=crop&q=80&w=1200",
        about: "The Student Affairs Office is dedicated to supporting the holistic development of our students. We manage campus life, student organizations, counseling services, and extracurricular programs to ensure a vibrant, inclusive, and supportive campus community.",
        mission: "To enhance the educational experience by providing comprehensive support services, fostering personal growth, and cultivating a diverse and inclusive campus environment.",
        vision: "To create a dynamic campus culture where every student is empowered to thrive personally, socially, and academically, preparing them for active global citizenship.",
    },
    personnel_and_human_resources: {

        title: "Human Resources Office",
        
        image: "https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&q=80&w=1200",
        about: "The Personnel and Human Resources Office manages all aspects of employment for faculty and staff. From recruitment and onboarding to professional development and benefits administration, we are committed to building a supportive and dynamic workplace.",
        mission: "To attract, retain, and develop a diverse and highly skilled workforce by providing equitable, transparent, and supportive human resource services.",
        vision: "To be an employer of choice in the higher education sector, fostering a culture of excellence, collaboration, and continuous professional growth.",
    },
    administration_and_accounting_office: {
        title: "Administration & Accounting Office",
       
        image: "https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&q=80&w=1200",
        about: "This office oversees the university's financial health and administrative operations. We handle budgeting, accounting, procurement, and financial reporting to ensure resources are utilized efficiently to support the institution's strategic goals.",
        mission: "To provide transparent, accurate, and strategic financial management and administrative services that sustain and advance the university's mission.",
        vision: "To achieve financial sustainability and operational excellence through innovative practices, rigorous accountability, and strategic resource allocation.",
    },
    dormitory_office: {
        title: "Dormitory Office",
        
        image: "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&q=80&w=1200",
        about: "The Dormitory Office manages all on-campus housing facilities, ensuring a safe, comfortable, and welcoming living environment for students. We handle room assignments, facility maintenance, and residential life programming.",
        mission: "To provide secure, well-maintained, and inclusive residential communities that support the academic and personal success of our students.",
        vision: "To offer premier campus housing experiences that foster lifelong friendships, personal responsibility, and a strong sense of community belonging.",
    },
    planning_and_research_office: {

        title: "Planning & Research Office",
       
        image: "https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=1200",
        about: "The Planning and Research Office is responsible for guiding the university's long-term strategic direction. We conduct institutional research, analyze performance metrics, and coordinate strategic planning initiatives to support evidence-based decision-making.",
        mission: "To empower university leadership with actionable data, comprehensive research, and strategic frameworks that promote continuous institutional improvement.",
        vision: "To be the catalyst for transformative institutional growth, ensuring the university remains adaptable, forward-thinking, and globally competitive.",
    },
    internal_quality_assurance_office: {

        title: "Internal Quality Assurance Office",
        image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=1200",
        about: "The Internal Quality Assurance Office monitors and evaluates the university's programs and processes. We conduct regular audits, facilitate accreditation procedures, and promote a culture of continuous quality enhancement across all departments.",
        mission: "To safeguard and enhance the quality of education and administrative services through rigorous assessment, compliance tracking, and continuous improvement protocols.",
        vision: "To establish the university as a benchmark for quality and excellence in higher education, recognized for uncompromising standards and continuous innovation.",
    },
};

const currentOffice = computed(() => {
    return props.officeData || officeConfig[props.office] || officeConfig.academic_affairs_office;
});
</script>

<template>
    <Head :title="$t(currentOffice.title)" />
    
    <SiteHeader />
    <div class="min-h-screen flex flex-col bg-slate-50 text-gray-900 font-sans selection:bg-blue-300 overflow-hidden relative">
        
        <!-- VIBRANT Abstract Background Mesh -->
        <div class="absolute top-0 left-0 right-0 h-[700px] overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-40 -right-20 w-[600px] h-[600px] rounded-full bg-cyan-400/20 blur-[120px] mix-blend-multiply opacity-80 animate-blob"></div>
            <div class="absolute top-10 -left-20 w-[500px] h-[500px] rounded-full bg-blue-400/20 blur-[120px] mix-blend-multiply opacity-80 animate-blob animation-delay-2000"></div>
            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px]"></div>
        </div>


       <main class="flex-grow w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-10">
            <!-- Hero Image (Full Extent Container) -->
            <section class="relative animate-fade-in-up">
                <div class="group relative overflow-hidden lg:rounded-[2.5rem] rounded-[1rem] shadow-[0_20px_50px_rgb(0,0,0,0.1)] h-[400px] md:h-[500px] lg:h-[600px] w-full">
                    <div class="absolute inset-0 bg-blue-900/10 group-hover:bg-transparent transition-colors duration-700 z-10 mix-blend-overlay"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 via-transparent to-transparent z-10 opacity-60"></div>
                    <img 
                        :src="currentOffice.image" 
                        :alt="$t(currentOffice.title)" 
                        class="h-full w-full object-cover transform transition-transform duration-1000 ease-out group-hover:scale-105"
                    />
                </div>
            </section>

            <!-- Title & Subtitle Focus -->
            <section class="animate-fade-in-up flex flex-col items-center text-center max-w-4xl mx-auto space-y-6" style="animation-delay: 0.1s">
            
                <!-- Office Title -->
                <h1 class="text-4xl font-extrabold leading-[1.1] tracking-tight text-[#283593] sm:text-5xl lg:text-6xl drop-shadow-sm">
                    {{ $t(currentOffice.title) }}
                </h1>
                
                <!-- Office Subtitle -->
                <p class="text-xl font-medium leading-relaxed text-slate-700 sm:text-2xl max-w-3xl" v-if="currentOffice.subtitle">
                    {{ $t(currentOffice.subtitle) }}
                </p>
            </section>

            <!-- Organizational Details Section (About, Mission, Vision) -->
            <section class="animate-fade-in-up pt-1" style="animation-delay: 0.2s">
                <div class="grid gap-8 lg:grid-cols-1">
                    
                    <!-- About Card -->
                    <div class="text-justify rounded-[2.5rem] border border-white/60 bg-white/80 p-8 sm:p-12 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]" v-if="currentOffice.about">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-extrabold text-[#283593]">
                                {{ $t('About') }}
                            </h2>
                        </div>
                        <div class="text-lg font-medium leading-relaxed text-slate-700 ql-editor px-0" v-html="$t(currentOffice.about)"></div>
                    </div>

                    <!-- Mission & Vision Shared Card -->
                    <div class="text-justify rounded-[2.5rem] border border-white/60 bg-white/80 p-8 sm:p-12 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] grid md:grid-cols-2 gap-12" v-if="currentOffice.mission || currentOffice.vision">
                        
                        <!-- Mission -->
                        <div v-if="currentOffice.mission">
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
                            <div class="text-lg font-medium leading-relaxed text-slate-700 ql-editor px-0" v-html="$t(currentOffice.mission)"></div>
                        </div>
                        
                        <!-- Vision -->
                        <div v-if="currentOffice.vision">
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
                            <div class="text-lg font-medium leading-relaxed text-slate-700 ql-editor px-0" v-html="$t(currentOffice.vision)"></div>
                        </div>

                    </div>
                </div>
            </section>

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