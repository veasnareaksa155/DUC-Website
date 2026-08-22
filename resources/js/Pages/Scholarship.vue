<script setup>
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

const selectedPage = ref(0);
const isLightboxOpen = ref(false);
const lightboxIndex = ref(0);
const page = usePage();

const props = defineProps({
    scholarshipSettings: {
        type: Object,
        default: () => ({ documents: [], requirements: [], portals: [] })
    }
});


const tl = (obj) => {
    if (!obj) return '';
    if (typeof obj === 'string') return obj;
    return obj[page.props.locale] || obj.en || '';
};

const fallbackDocumentImages = [
    { title: { km: 'ទំព័រទី ១៖ សេចក្តីជូនដំណឹង និងមហាវិទ្យាល័យ', en: 'Page 1: Scholarship Announcement & Eligible Faculties' }, src: '/images/scholarship/scholarship-doc-1.png' },
    { title: { km: 'ទំព័រទី ២៖ លក្ខខណ្ឌ និងឯកសារភ្ជាប់', en: 'Page 2: Application Conditions & Required Documents' }, src: '/images/scholarship/scholarship-doc-2.png' },
    { title: { km: 'ទំព័រទី ៣៖ ការទំនាក់ទំនង និង QR Codes', en: 'Page 3: Contact Details & QR Code Portals' }, src: '/images/scholarship/scholarship-doc-3.png' }
];

const documentImages = (props.scholarshipSettings?.documents && props.scholarshipSettings.documents.length) 
    ? props.scholarshipSettings.documents 
    : fallbackDocumentImages;

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

const fallbackRequiredDocuments = [
    { no: '១', name: { km: 'ពាក្យសុំអាហារូបករណ៍', en: 'Scholarship Form' }, qty: { km: '១ច្បាប់', en: '1 Copy' } },
    { no: '២', name: { km: 'រូបថតបច្ចុប្បន្ន ៤x៦', en: '4x6 Photos' }, qty: { km: '៦ច្បាប់', en: '6 Copies' } },
    { no: '៣', name: { km: 'សញ្ញាបត្រមធ្យមសិក្សាទុតិយភូមិ ឬលិខិតបញ្ជាក់', en: 'High School Diploma' }, qty: { km: '១ច្បាប់', en: '1 Copy' } },
    { no: '៤', name: { km: 'សំបុត្រកំណើត', en: 'Birth Certificate' }, qty: { km: '១ច្បាប់', en: '1 Copy' } },
    { no: '៥', name: { km: 'អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ', en: 'Identity Card' }, qty: { km: '១ច្បាប់', en: '1 Copy' } },
    { no: '៦', name: { km: 'សៀវភៅគ្រួសារ ឬសៀវភៅស្នាក់នៅ', en: 'Family / Residence Book' }, qty: { km: '១ច្បាប់', en: '1 Copy' } },
    { no: '៧', name: { km: 'លិខិតបញ្ជាក់ការសិក្សា ឬលិខិតកោតសរសើរ', en: 'Recommendation / Transcript' }, qty: { km: '១ច្បាប់', en: '1 Copy' } }
];

const requiredDocuments = (props.scholarshipSettings?.requirements && props.scholarshipSettings.requirements.length) 
    ? props.scholarshipSettings.requirements 
    : fallbackRequiredDocuments;

const fallbackQrPortals = [
    { title: { km: 'ពាក្យស្នើសុំអាហារូបករណ៍', en: 'Scholarship Form' }, link: 'https://t.me/Digitaluniversityofcambodia1', desc: { km: 'ដាក់ពាក្យស្នើសុំអាហារូបករណ៍', en: 'Apply for Scholarship' }, svg: '<svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>' },
    { title: { km: 'ឆានែលតេឡេក្រាម', en: 'Telegram Channel' }, link: 'https://t.me/Digitaluniversityofcambodia1', desc: { km: 'ឆានែលព័ត៌មានផ្លូវការ', en: 'Official Info Channel' }, svg: '<svg class="w-6 h-6 text-sky-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.56 8.16l-1.97 9.28c-.15.67-.54.83-1.1.52l-3.04-2.24-1.47 1.41c-.16.16-.3.3-.61.3l.22-3.1 5.64-5.1c.25-.22-.05-.34-.38-.12l-6.97 4.39-3.01-.94c-.65-.2-.67-.65.14-.97l11.76-4.53c.54-.2 1.02.13.79 1.1z"/></svg>' },
    { title: { km: 'ទំព័រហ្វេសប៊ុក', en: 'Facebook Page' }, link: '#', desc: { km: 'ទំព័រហ្វេសប៊ុកផ្លូវការ', en: 'Official Facebook Page' }, svg: '<svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>' },
    { title: { km: 'ឆានែលយូធូប', en: 'YouTube Channel' }, link: '#', desc: { km: 'វីដេអូសកម្មភាពនិស្សិត', en: 'Student Activities Video' }, svg: '<svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>' },
    { title: { km: 'ទីកតុក', en: 'TikTok' }, link: '#', desc: { km: 'វីដេអូខ្លីៗបច្ចេកវិទ្យា', en: 'Short Tech Videos' }, svg: '<svg class="w-6 h-6 text-slate-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.98-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.56-1.31 1.52-1.31 2.52.02 1.14.67 2.18 1.68 2.67.97.46 2.14.39 3.03-.18.84-.53 1.34-1.49 1.34-2.48.03-5.46.01-10.92.02-16.38z"/></svg>' },
    { title: { km: 'ផែនទី Google Map', en: 'Google Map' }, link: '#', desc: { km: 'ទីតាំងសាកលវិទ្យាល័យ', en: 'University Location' }, svg: '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' }
];
const qrPortals = (props.scholarshipSettings?.portals && props.scholarshipSettings.portals.length) 
    ? props.scholarshipSettings.portals 
    : fallbackQrPortals;

const fallbackBenefits = {
    title: { km: 'អត្ថប្រយោជន៍ទទួលបានពីអាហារូបករណ៍', en: 'Privilege & Benefits' },
    items: [
        { text: { km: 'ទទួលបានអាហារូបករណ៍ ១០០% ពេញលេញ សម្រាប់ការសិក្សាថ្នាក់បរិញ្ញាបត្រ។', en: 'Get a 100% full scholarship for bachelor degree.' } },
        { text: { km: 'បានសិក្សាក្នុងបន្ទប់ម៉ាស៊ីនត្រជាក់ ជាមួយឧបករណ៍បច្ចេកវិទ្យាទំនើបៗ និងប្រព័ន្ធ E-Learning។', en: 'Study in A/C rooms with modern tech devices and E-Learning system.' } },
        { text: { km: 'ទទួលបានការបណ្តុះបណ្តាលជំនាញឌីជីថលបន្ថែម និងភាសាអង់គ្លេសកម្រិតខ្ពស់។', en: 'Receive additional digital skills training and advanced English language.' } },
        { text: { km: 'មានឱកាសទទួលបានការចុះកម្មសិក្សា ការចុះអនុវត្តការងារផ្ទាល់ និងឱកាសការងារក្រោយបញ្ចប់ការសិក្សា។', en: 'Have the opportunity to get internships, hands-on practice, and jobs.' } }
    ]
};
const scholarshipBenefits = props.scholarshipSettings?.benefits?.title ? props.scholarshipSettings.benefits : fallbackBenefits;
const fallbackHero = {
    badge: { km: 'អាហារូបករណ៍ ១០០% ថ្នាក់បរិញ្ញាបត្រ • ឆ្នាំសិក្សា ២០២៤-២០២៥', en: '100% Bachelor Degree Scholarship • Academic Year 2024-2025' },
    title: { km: 'សេចក្តីជូនដំណឹង អាហារូបករណ៍ ១០០%', en: '100% Scholarship Announcement' },
    description: { km: 'ការជ្រើសរើសនិស្សិតអាហារូបករណ៍ថ្នាក់បរិញ្ញាបត្រ នៅសាកលវិទ្យាល័យឌីជីថលកម្ពុជា', en: 'Bachelor Degree Scholarship Recruitment at Digital University of Cambodia' },
    doc_button: { km: 'មើលលិខិតផ្លូវការ', en: 'View Official Documents' },
    official_doc_title: { km: 'លិខិតប្រកាសអាហារូបករណ៍ផ្លូវការ', en: 'Official Scholarship Announcement Document' },
    click_to_zoom: { km: 'ចុចលើរូបភាពដើម្បីពង្រីកមើលលម្អិត', en: 'Click any document to view in high resolution' },
    apply_telegram: { km: 'ដាក់ពាក្យតាម Telegram', en: 'Apply via Telegram' },
    req_docs_title: { km: 'សំណុំឯកសារភ្ជាប់សម្រាប់ស្នើសុំអាហារូបករណ៍', en: 'Required Documents for Scholarship Application' },
    table_no: { km: 'ល.រ', en: 'No.' },
    table_doc_name: { km: 'ឈ្មោះឯកសារ', en: 'Document Name' },
    table_qty: { km: 'ចំនួន', en: 'Qty' },
    all_pages: { km: 'ទំព័រទាំង ៣ នៃសេចក្តីជូនដំណឹង៖', en: 'All 3 pages of the announcement:' },
    page: { km: 'ទំព័រ', en: 'Page' },
    of: { km: 'នៃ', en: 'of' },
    close: { km: 'បិទ', en: 'Close' },
    zoom_document: { km: 'ពង្រីករូបភាព (Zoom Document)', en: 'Zoom Document' }
};
const scholarshipHero = { ...fallbackHero, ...(props.scholarshipSettings?.hero || {}) };




const pageText = {
    apply_telegram: { km: 'ដាក់ពាក្យតាម Telegram', en: 'Apply via Telegram' },
    official_doc_title: { km: 'លិខិតប្រកាសអាហារូបករណ៍ផ្លូវការ', en: 'Official Scholarship Announcement Document' },
    click_to_zoom: { km: 'ចុចលើរូបភាពដើម្បីពង្រីកមើលលម្អិត', en: 'Click any document to view in high resolution' },
    page: { km: 'ទំព័រ', en: 'Page' },
    zoom_document: { km: 'ពង្រីករូបភាព', en: 'Zoom Document' },
    all_pages: { km: 'ទំព័រទាំង ៣ នៃសេចក្តីជូនដំណឹង៖', en: 'All 3 pages of the announcement:' },
    req_docs_title: { km: 'សំណុំឯកសារភ្ជាប់សម្រាប់ស្នើសុំអាហារូបករណ៍', en: 'Required Documents for Scholarship Application' },
    table_no: { km: 'ល.រ', en: 'No.' },
    table_qty: { km: 'ចំនួន', en: 'Qty' },
    contact_qr_title: { km: 'ការទំនាក់ទំនង និង QR Code', en: 'Contact & QR Code Portals' },
    go_to: { km: 'ចូលទៅកាន់', en: 'Go to' },
    close: { km: 'បិទ', en: 'Close' },
    of: { km: 'នៃ', en: 'of' },
    page_title: { km: 'អាហារូបករណ៍ ១០០% - សេចក្តីជូនដំណឹង | DUC', en: '100% Scholarship Announcement | DUC' }
};
</script>

<template>
    <Head :title="tl(pageText.page_title)" />

    <div class="min-h-screen bg-global-bg font-sans text-slate-900 flex flex-col">
        <SiteHeader />

        <main class="flex-grow pb-16">
            <!-- Header Banner Section -->
            <section class="bg-[#115D6D] text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-teal-800/50 shadow-md">
                <div class="max-w-[1400px] mx-auto text-center space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-amber-300 text-xs sm:text-sm font-semibold backdrop-blur-md border border-white/15 mb-6 shadow-sm">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        <span>{{ tl(scholarshipHero.badge) }}</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-[1.3] max-w-4xl mx-auto mb-6 text-white" style="font-family: 'Moul', 'Khmer OS Moul', serif; text-shadow: 0 4px 20px rgba(0,0,0,0.4);">
                        {{ tl(scholarshipHero.title) }}
                    </h1>
                    <p class="text-lg sm:text-xl text-teal-50 max-w-3xl mx-auto font-medium mb-10 leading-relaxed">
                        {{ tl(scholarshipHero.description) }}
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row flex-wrap justify-center items-center gap-4">
                        <button 
                            @click="openLightbox(0)" 
                            class="px-6 py-3 rounded-full bg-amber-400 text-slate-900 font-extrabold hover:bg-amber-300 transition-all shadow-lg flex items-center gap-2 text-sm sm:text-base"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.998-9.542-7z"/>
                            </svg>
                            {{ tl(scholarshipHero.doc_button) }}
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
                            {{ tl(scholarshipHero.apply_telegram) }}
                        </a>
                    </div>
                </div>
            </section>

            <!-- Main Content Container -->
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 space-y-12">
                
                <!-- Official Announcement Image Showcase Gallery -->
                <section class="bg-white/95 backdrop-blur-md rounded-[2rem] p-6 sm:p-10 border border-slate-200/60 shadow-xl shadow-slate-200/50 space-y-8">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-200 pb-6">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-teal-50 rounded-2xl shrink-0 border border-teal-100">
                                <svg class="w-6 h-6 text-[#115D6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="pt-1">
                                <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">
                                    {{ tl(scholarshipHero.official_doc_title) }}
                                </h2>
                                <p class="text-sm sm:text-base text-slate-500 mt-1.5 font-medium">
                                    {{ tl(scholarshipHero.click_to_zoom) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Document Image Viewer -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <div class="lg:col-span-7 relative group cursor-pointer overflow-hidden rounded-2xl border-4 border-white shadow-2xl bg-slate-900" @click="openLightbox(selectedPage)">
                            <img 
                                :src="documentImages[selectedPage].src" 
                                :alt="tl(documentImages[selectedPage].title)"
                                class="w-full h-auto object-contain max-h-[700px] transition-transform duration-500 group-hover:scale-102" 
                            />
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-5 py-2.5 rounded-full bg-white/90 text-slate-900 font-extrabold shadow-xl flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-[#115D6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                    {{ tl(scholarshipHero.zoom_document) }}
                                </span>
                            </div>
                        </div>

                        <!-- Sidebar Thumbnails & Highlights -->
                        <div class="lg:col-span-5 space-y-4">
                            <div class="flex items-center gap-3 mb-6 bg-slate-50 border-b border-slate-200 py-3 px-4 rounded-xl -mx-4 sm:mx-0">
                                <svg class="w-5 h-5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <h3 class="text-lg font-bold text-slate-800">
                                    {{ tl(scholarshipHero.all_pages) }}
                                </h3>
                            </div>
                            <div 
                                v-for="(img, idx) in documentImages" 
                                :key="idx"
                                @click="selectedPage = idx"
                                class="flex items-center gap-5 p-3 rounded-2xl transition-all cursor-pointer bg-white group"
                                :class="selectedPage === idx ? 'border-2 border-[#115D6D] shadow-lg shadow-teal-900/5' : 'border-2 border-slate-100 hover:border-slate-300 hover:shadow-md'"
                            >
                                <div class="w-16 h-20 rounded-xl overflow-hidden shrink-0 shadow-sm border border-slate-200">
                                    <img :src="img.src" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                </div>
                                <div class="flex-grow min-w-0 pr-2">
                                    <h4 class="text-[15px] leading-snug font-bold text-slate-800 group-hover:text-[#115D6D] transition-colors truncate whitespace-normal line-clamp-2">
                                        {{ tl(img.title) }}
                                    </h4>
                                </div>
                                <div class="shrink-0">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold tracking-wide transition-colors" :class="selectedPage === idx ? 'bg-teal-100 text-teal-800' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200'">
                                        {{ tl(scholarshipHero.page) }} {{ idx + 1 }}
                                    </span>
                                </div>
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
                                    {{ tl(scholarshipBenefits.title) }}
                                </h3>
                            </div>
                            <ul class="space-y-3 text-slate-700 font-medium text-sm sm:text-base">
                                <li v-for="(item, idx) in scholarshipBenefits.items" :key="idx" class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>{{ tl(item.text) }}</span>
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
                                <div>
                                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#115D6D]">
                                        {{ tl(scholarshipHero.req_docs_title) }}
                                    </h3>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse">
                                    <thead>
                                        <tr class="bg-teal-600 text-white shadow-sm border-b-2 border-teal-700">
                                            <th class="p-3 font-extrabold w-12 text-center">{{ tl(scholarshipHero.table_no) }}</th>
                                            <th class="p-3 font-extrabold text-left">{{ tl(scholarshipHero.table_doc_name) }}</th>
                                            <th class="p-3 font-extrabold w-28 text-center">{{ tl(scholarshipHero.table_qty) }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <tr v-for="doc in requiredDocuments" :key="doc.no" class="hover:bg-teal-50/50 transition-colors">
                                            <td class="p-3 text-center font-bold text-slate-500">{{ doc.no }}</td>
                                            <td class="p-3 font-semibold text-slate-800">{{ tl(doc.name) }}</td>
                                            <td class="p-3 text-center font-bold text-teal-700 bg-teal-50/80 rounded-lg">{{ tl(doc.qty) }}</td>
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
                                    {{ tl(pageText.contact_qr_title) }}
                                </h3>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div 
                                    v-for="portal in qrPortals" 
                                    :key="portal.title"
                                    class="p-4 rounded-2xl border border-slate-200 bg-white hover:shadow-md transition-all text-center flex flex-col items-center gap-2"
                                >
                                    <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50" v-html="portal.svg"></span>
                                    <h4 class="text-sm font-extrabold text-slate-900">{{ tl(portal.title) }}</h4>
                                    <p class="text-xs text-slate-500">{{ tl(portal.desc) }}</p>
                                    <a 
                                        :href="portal.link" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="mt-1 px-3 py-1 rounded-full bg-teal-100 text-[#115D6D] text-xs font-bold hover:bg-[#115D6D] hover:text-white transition-colors flex items-center gap-1"
                                    >
                                        <span>{{ tl(pageText.go_to) }}</span>
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
                <h3 class="text-lg sm:text-xl font-bold truncate">{{ tl(documentImages[lightboxIndex].title) }}</h3>
                <button @click="closeLightbox" class="text-white/70 hover:text-white px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 transition-all font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ tl(scholarshipHero.close) }}
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
                {{ tl(scholarshipHero.page) }} {{ lightboxIndex + 1 }} {{ tl(scholarshipHero.of) }} {{ documentImages.length }}
            </div>
        </div>

        <SiteFooter />
    </div>
</template>
