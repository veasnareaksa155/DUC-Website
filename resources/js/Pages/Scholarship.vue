<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

const selectedPage = ref(0);
const isLightboxOpen = ref(false);
const lightboxIndex = ref(0);

const documentImages = [
    {
        title: 'ទំព័រទី ១៖ សេចក្តីជូនដំណឹង និងមហាវិទ្យាល័យ',
        titleEn: 'Page 1: Scholarship Announcement & Eligible Faculties',
        src: '/images/scholarship/scholarship-doc-1.png'
    },
    {
        title: 'ទំព័រទី ២៖ លក្ខខណ្ឌ និងឯកសារភ្ជាប់',
        titleEn: 'Page 2: Application Conditions & Required Documents',
        src: '/images/scholarship/scholarship-doc-2.png'
    },
    {
        title: 'ទំព័រទី ៣៖ ការទំនាក់ទំនង និង QR Codes',
        titleEn: 'Page 3: Contact Details & QR Code Portals',
        src: '/images/scholarship/scholarship-doc-3.png'
    }
];

const openLightbox = (index) => {
    lightboxIndex.value = index;
    isLightboxOpen.value = true;
};

const closeLightbox = () => {
    isLightboxOpen.value = false;
};

const nextImage = () => {
    lightboxIndex.value = (lightboxIndex.value + 1) % documentImages.length;
};

const prevImage = () => {
    lightboxIndex.value = (lightboxIndex.value - 1 + documentImages.length) % documentImages.length;
};

const requiredDocuments = [
    { no: '១', name: 'ពាក្យសុំអាហារូបករណ៍ (Scholarship Form)', qty: '១ច្បាប់' },
    { no: '២', name: 'រូបថតបច្ចុប្បន្ន ៤x៦ (4x6 Photos)', qty: '៦ច្បាប់' },
    { no: '៣', name: 'សញ្ញាបត្រមធ្យមសិក្សាទុតិយភូមិ ឬលិខិតបញ្ជាក់ (High School Diploma)', qty: '១ច្បាប់' },
    { no: '៤', name: 'សំបុត្រកំណើត (Birth Certificate)', qty: '១ច្បាប់' },
    { no: '៥', name: 'អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ (Identity Card)', qty: '១ច្បាប់' },
    { no: '៦', name: 'សៀវភៅគ្រួសារ ឬសៀវភៅស្នាក់នៅ (Family / Residence Book)', qty: '១ច្បាប់' },
    { no: '៧', name: 'លិខិតបញ្ជាក់ការសិក្សា ឬលិខិតកោតសរសើរ (Recommendation / Transcript)', qty: '១ច្បាប់' }
];

const qrPortals = [
    { 
        title: 'Scholarship Form', 
        link: 'https://t.me/Digitaluniversityofcambodia1', 
        desc: 'ដាក់ពាក្យស្នើសុំអាហារូបករណ៍',
        svg: `<svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`
    },
    { 
        title: 'Telegram Channel', 
        link: 'https://t.me/Digitaluniversityofcambodia1', 
        desc: 'ឆានែលព័ត៌មានផ្លូវការ',
        svg: `<svg class="w-6 h-6 text-sky-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.56 8.16l-1.97 9.28c-.15.67-.54.83-1.1.52l-3.04-2.24-1.47 1.41c-.16.16-.3.3-.61.3l.22-3.1 5.64-5.1c.25-.22-.05-.34-.38-.12l-6.97 4.39-3.01-.94c-.65-.2-.67-.65.14-.97l11.76-4.53c.54-.2 1.02.13.79 1.1z"/></svg>`
    },
    { 
        title: 'Facebook Page', 
        link: '#', 
        desc: 'ទំព័រហ្វេសប៊ុកផ្លូវការ',
        svg: `<svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>`
    },
    { 
        title: 'YouTube Channel', 
        link: '#', 
        desc: 'វីដេអូសកម្មភាពនិស្សិត',
        svg: `<svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>`
    },
    { 
        title: 'TikTok', 
        link: '#', 
        desc: 'វីដេអូខ្លីៗបច្ចេកវិទ្យា',
        svg: `<svg class="w-6 h-6 text-slate-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.56-1.31 1.52-1.31 2.52.02 1.14.67 2.18 1.68 2.67.97.46 2.14.39 3.03-.18.84-.53 1.34-1.49 1.34-2.48.03-5.46.01-10.92.02-16.38z"/></svg>`
    },
    { 
        title: 'Google Map', 
        link: '#', 
        desc: 'ទីតាំងសាកលវិទ្យាល័យ',
        svg: `<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
    }
];
</script>

<template>
    <Head title="អាហារូបករណ៍ ១០០% - Scholarship Announcement | DUC" />

    <div class="min-h-screen bg-[#c9e0e4] font-sans text-slate-900 flex flex-col">
        <SiteHeader />

        <main class="flex-grow pb-16">
            <!-- Header Banner Section -->
            <section class="bg-[#115D6D] text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-teal-800/50 shadow-md">
                <div class="max-w-[1400px] mx-auto text-center space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-amber-300 text-xs sm:text-sm font-semibold backdrop-blur-md border border-white/15">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        <span>អាហារូបករណ៍ ១០០% ថ្នាក់បរិញ្ញាបត្រ</span>
                        <span>•</span>
                        <span>ឆ្នាំសិក្សា ២០២៤-២០២៥</span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight max-w-4xl mx-auto" style="font-family: 'Moul', 'Khmer OS Moul', serif;">
                        សេចក្តីជូនដំណឹង អាហារូបករណ៍ ១០០%
                    </h1>
                    <p class="text-lg sm:text-xl text-teal-100 max-w-3xl mx-auto font-medium">
                        ការជ្រើសរើសនិស្សិតអាហារូបករណ៍ថ្នាក់បរិញ្ញាបត្រ នៅសាកលវិទ្យាល័យឌីជីថលកម្ពុជា (Digital University of Cambodia)
                    </p>

                    <div class="pt-4 flex flex-wrap justify-center gap-4">
                        <button 
                            @click="openLightbox(0)" 
                            class="px-6 py-3 rounded-full bg-amber-400 text-slate-900 font-extrabold hover:bg-amber-300 transition-all shadow-lg flex items-center gap-2 text-sm sm:text-base"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.998-9.542-7z"/>
                            </svg>
                            មើលលិខិតផ្លូវការ (View Official Documents)
                        </button>
                        <a 
                            href="https://t.me/Digitaluniversityofcambodia1" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="px-6 py-3 rounded-full bg-white/15 text-white font-bold hover:bg-white/25 transition-all border border-white/20 backdrop-blur-md flex items-center gap-2 text-sm sm:text-base"
                        >
                            <svg class="w-5 h-5 text-sky-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.56 8.16l-1.97 9.28c-.15.67-.54.83-1.1.52l-3.04-2.24-1.47 1.41c-.16.16-.3.3-.61.3l.22-3.1 5.64-5.1c.25-.22-.05-.34-.38-.12l-6.97 4.39-3.01-.94c-.65-.2-.67-.65.14-.97l11.76-4.53c.54-.2 1.02.13.79 1.1z"/>
                            </svg>
                            ដាក់ពាក្យតាម Telegram
                        </a>
                    </div>
                </div>
            </section>

            <!-- Main Content Container -->
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 space-y-12">
                
                <!-- Official Announcement Image Showcase Gallery -->
                <section class="bg-white/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/80 shadow-xl space-y-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-200 pb-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-[#115D6D] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#115D6D]">
                                    លិខិតប្រកាសអាហារូបករណ៍ផ្លូវការ (Official Announcement Document)
                                </h2>
                                <p class="text-sm text-slate-600 mt-0.5">
                                    ចុចលើរូបភាពដើម្បីពង្រីកមើលលម្អិត (Click any document to view in high resolution)
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button 
                                v-for="(img, idx) in documentImages" 
                                :key="idx"
                                @click="selectedPage = idx"
                                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all border"
                                :class="selectedPage === idx ? 'bg-[#115D6D] text-white border-[#115D6D] shadow-md' : 'bg-slate-100 text-slate-700 border-slate-300 hover:bg-slate-200'"
                            >
                                ទំព័រ {{ idx + 1 }}
                            </button>
                        </div>
                    </div>

                    <!-- Selected Document Image Viewer -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-7 relative group cursor-pointer overflow-hidden rounded-2xl border-4 border-white shadow-2xl bg-slate-900" @click="openLightbox(selectedPage)">
                            <img 
                                :src="documentImages[selectedPage].src" 
                                :alt="documentImages[selectedPage].title"
                                class="w-full h-auto object-contain max-h-[700px] transition-transform duration-500 group-hover:scale-102" 
                            />
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-5 py-2.5 rounded-full bg-white/90 text-slate-900 font-extrabold shadow-xl flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-[#115D6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                    ពង្រីករូបភាព (Zoom Document)
                                </span>
                            </div>
                        </div>

                        <!-- Sidebar Thumbnails & Highlights -->
                        <div class="lg:col-span-5 space-y-4">
                            <h3 class="text-lg font-extrabold text-[#115D6D] mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#115D6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                ទំព័រទាំង ៣ នៃសេចក្តីជូនដំណឹង៖
                            </h3>
                            <div 
                                v-for="(img, idx) in documentImages" 
                                :key="idx"
                                @click="selectedPage = idx"
                                class="flex items-center gap-4 p-3 rounded-2xl border-2 transition-all cursor-pointer bg-white"
                                :class="selectedPage === idx ? 'border-[#115D6D] shadow-md bg-teal-50/50' : 'border-slate-200 hover:border-slate-300'"
                            >
                                <img :src="img.src" class="w-16 h-20 object-cover rounded-lg border border-slate-200 shrink-0" />
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ img.title }}</h4>
                                    <p class="text-xs text-slate-500 truncate mt-0.5">{{ img.titleEn }}</p>
                                </div>
                                <span class="text-xs font-bold text-[#115D6D] bg-teal-100 px-2.5 py-1 rounded-full">
                                    ទំព័រ {{ idx + 1 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Detailed Information Sections -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <!-- Left Column: Requirements & Benefits -->
                    <div class="lg:col-span-7 space-y-8">
                        
                        <!-- Privilege & Benefits Card -->
                        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/80 shadow-xl space-y-4">
                            <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
                                <span class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl shrink-0">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-[#115D6D]">
                                    អត្ថប្រយោជន៍ទទួលបានពីអាហារូបករណ៍
                                </h3>
                            </div>
                            <ul class="space-y-3 text-slate-700 font-medium text-sm sm:text-base">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>ទទួលបានអាហារូបករណ៍ <strong>១០០% ពេញលេញ</strong> សម្រាប់ការសិក្សាថ្នាក់បរិញ្ញាបត្រ។</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>បានសិក្សាក្នុងបន្ទប់ម៉ាស៊ីនត្រជាក់ ជាមួយឧបករណ៍បច្ចេកវិទ្យាទំនើបៗ និងប្រព័ន្ធ E-Learning។</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>ទទួលបានការបណ្តុះបណ្តាលជំនាញឌីជីថលបន្ថែម និងភាសាអង់គ្លេសកម្រិតខ្ពស់។</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>មានឱកាសទទួលបានការចុះកម្សាន្ត ការចុះអនុវត្តការងារផ្ទាល់ និងឱកាសការងារក្រោយបញ្ចប់ការសិក្សា។</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Documents Checklist Table -->
                        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/80 shadow-xl space-y-4">
                            <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
                                <span class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xl shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </span>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-[#115D6D]">
                                    សំណុំឯកសារភ្ជាប់សម្រាប់ស្នើសុំអាហារូបករណ៍
                                </h3>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse">
                                    <thead>
                                        <tr class="bg-slate-100 text-[#115D6D] border-b border-slate-200">
                                            <th class="p-3 font-extrabold w-12 text-center">ល.រ</th>
                                            <th class="p-3 font-extrabold">ឈ្មោះឯកសារ</th>
                                            <th class="p-3 font-extrabold w-28 text-center">ចំនួន</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <tr v-for="doc in requiredDocuments" :key="doc.no" class="hover:bg-teal-50/50 transition-colors">
                                            <td class="p-3 text-center font-bold text-slate-500">{{ doc.no }}</td>
                                            <td class="p-3 font-semibold text-slate-800">{{ doc.name }}</td>
                                            <td class="p-3 text-center font-bold text-teal-700 bg-teal-50/80 rounded-lg">{{ doc.qty }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Portal & Quick QR Codes -->
                    <div class="lg:col-span-5 space-y-8">
                        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/80 shadow-xl space-y-6">
                            <div class="flex items-center gap-3 border-b border-slate-200 pb-3">
                                <span class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-xl shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </span>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-[#115D6D]">
                                    ប្រព័ន្ធទំនាក់ទំនង និងស្កែន QR Code
                                </h3>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div 
                                    v-for="portal in qrPortals" 
                                    :key="portal.title"
                                    class="p-4 rounded-2xl border border-slate-200 bg-white hover:shadow-md transition-all text-center flex flex-col items-center gap-2"
                                >
                                    <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50" v-html="portal.svg"></span>
                                    <h4 class="text-sm font-extrabold text-slate-900">{{ portal.title }}</h4>
                                    <p class="text-xs text-slate-500">{{ portal.desc }}</p>
                                    <a 
                                        :href="portal.link" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="mt-1 px-3 py-1 rounded-full bg-teal-100 text-[#115D6D] text-xs font-bold hover:bg-[#115D6D] hover:text-white transition-colors flex items-center gap-1"
                                    >
                                        <span>ចូលទៅកាន់</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>

        <!-- Document Lightbox Modal -->
        <div v-if="isLightboxOpen" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex flex-col items-center justify-between p-4 sm:p-6" @click.self="closeLightbox">
            <div class="w-full max-w-6xl flex justify-between items-center text-white pb-4 border-b border-white/20">
                <h3 class="text-lg sm:text-xl font-bold truncate">{{ documentImages[lightboxIndex].title }}</h3>
                <button @click="closeLightbox" class="px-4 py-2 rounded-full bg-white/20 hover:bg-white/30 text-white transition-colors flex items-center gap-2 text-sm font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    បិទ
                </button>
            </div>

            <div class="relative flex-grow flex items-center justify-center my-4 w-full">
                <button @click="prevImage" class="absolute left-2 sm:left-6 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <img :src="documentImages[lightboxIndex].src" class="max-h-[80vh] w-auto max-w-full object-contain rounded-xl shadow-2xl" />
                <button @click="nextImage" class="absolute right-2 sm:right-6 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div class="text-white text-sm font-semibold">
                ទំព័រ {{ lightboxIndex + 1 }} នៃ {{ documentImages.length }}
            </div>
        </div>

        <SiteFooter />
    </div>
</template>
