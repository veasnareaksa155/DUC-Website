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
    subDecreeSettings: {
        type: Object,
        default: () => ({ documents: [], hero: {} })
    }
});

const tl = (obj) => {
    if (!obj) return '';
    if (typeof obj === 'string') return obj;
    return obj[page.props.locale] || obj.en || '';
};

const fallbackDocumentImages = [
    { title: { km: 'ទំព័រទី ១', en: 'Page 1' }, src: '' },
    { title: { km: 'ទំព័រទី ២', en: 'Page 2' }, src: '' },
    { title: { km: 'ទំព័រទី ៣', en: 'Page 3' }, src: '' },
    { title: { km: 'ទំព័រទី ៤', en: 'Page 4' }, src: '' }
];

const documentImages = (props.subDecreeSettings?.documents && props.subDecreeSettings.documents.length) 
    ? props.subDecreeSettings.documents 
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

const fallbackHero = {
    badge: { km: 'អនុក្រឹត្យស្ដីពីការបង្កើតសាកលវិទ្យាល័យ', en: 'Sub-decree on the establishment of the university' },
    title: { km: 'សេចក្តីជូនដំណឹង និងអនុក្រឹត្យ', en: 'Announcement & Sub-decree' },
    description: { km: 'អនុក្រឹត្យស្ដីពីការបង្កើតសាកលវិទ្យាល័យឌីជីថលកម្ពុជា។', en: 'Sub-decree on the establishment of the Digital University of Cambodia.' },
    doc_button: { km: 'មើលលិខិតផ្លូវការ', en: 'View Official Documents' },
    official_doc_title: { km: 'លិខិតប្រកាសផ្លូវការ', en: 'Official Announcement Document' },
    click_to_zoom: { km: 'ចុចលើរូបភាពដើម្បីពង្រីកមើលលម្អិត', en: 'Click any document to view in high resolution' },
    all_pages: { km: 'ទំព័រទាំងអស់៖', en: 'All pages:' },
    page: { km: 'ទំព័រ', en: 'Page' },
    of: { km: 'នៃ', en: 'of' },
    close: { km: 'បិទ', en: 'Close' },
    zoom_document: { km: 'ពង្រីករូបភាព (Zoom Document)', en: 'Zoom Document' }
};
const heroSettings = { ...fallbackHero, ...(props.subDecreeSettings?.hero || {}) };

const pageText = {
    page_title: { km: 'អនុក្រឹត្យស្ដីពីការបង្កើតសាកលវិទ្យាល័យ | DUC', en: 'Sub-decree | DUC' }
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
                        <span>{{ tl(heroSettings.badge) }}</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-[1.3] max-w-4xl mx-auto mb-6 text-white" style="font-family: 'Moul', 'Khmer OS Moul', serif; text-shadow: 0 4px 20px rgba(0,0,0,0.4);">
                        {{ tl(heroSettings.title) }}
                    </h1>
                    <p class="text-lg sm:text-xl text-teal-50 max-w-3xl mx-auto font-medium mb-10 leading-relaxed">
                        {{ tl(heroSettings.description) }}
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
                            {{ tl(heroSettings.doc_button) }}
                        </button>
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
                                <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight leading-relaxed py-2">
                                    {{ tl(heroSettings.official_doc_title) }}
                                </h2>
                                <p class="text-sm sm:text-base text-slate-500 mt-1.5 font-medium">
                                    {{ tl(heroSettings.click_to_zoom) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Document Image Viewer -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <div class="lg:col-span-7 relative group cursor-pointer overflow-hidden rounded-2xl border-4 border-white shadow-2xl bg-slate-900" @click="openLightbox(selectedPage)">
                            <img 
                                v-if="documentImages[selectedPage]?.src"
                                :src="documentImages[selectedPage].src" 
                                :alt="tl(documentImages[selectedPage].title)"
                                class="w-full h-auto object-contain max-h-[700px] transition-transform duration-500 group-hover:scale-102" 
                            />
                            <div v-else class="w-full h-[500px] flex items-center justify-center text-slate-500">
                                No image set
                            </div>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-5 py-2.5 rounded-full bg-white/90 text-slate-900 font-extrabold shadow-xl flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-[#115D6D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                    {{ tl(heroSettings.zoom_document) }}
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
                                    {{ tl(heroSettings.all_pages) }}
                                </h3>
                            </div>
                            <div 
                                v-for="(img, idx) in documentImages" 
                                :key="idx"
                                @click="selectedPage = idx"
                                class="flex items-center gap-5 p-3 rounded-2xl transition-all cursor-pointer bg-card-bg group"
                                :class="selectedPage === idx ? 'border-2 border-[#115D6D] shadow-lg shadow-teal-900/5' : 'border-2 border-slate-100 hover:border-slate-300 hover:shadow-md'"
                            >
                                <div class="w-16 h-20 rounded-xl overflow-hidden shrink-0 shadow-sm border border-slate-200">
                                    <img v-if="img.src" :src="img.src" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                    <div v-else class="w-full h-full bg-slate-200"></div>
                                </div>
                                <div class="flex-grow min-w-0 pr-2">
                                    <h4 class="text-base leading-relaxed font-bold text-slate-800 group-hover:text-[#115D6D] transition-colors py-1">
                                        {{ tl(img.title) }}
                                    </h4>
                                </div>
                                <div class="shrink-0">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-bold tracking-wide transition-colors" :class="selectedPage === idx ? 'bg-teal-100 text-teal-800' : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200'">
                                        {{ tl(heroSettings.page) }} {{ idx + 1 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
                    {{ tl(heroSettings.close) }}
                </button>
            </div>

            <div class="relative flex-grow flex items-center justify-center my-4 w-full">
                <button @click="prevImage" class="absolute left-2 sm:left-6 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <img v-if="documentImages[lightboxIndex].src" :src="documentImages[lightboxIndex].src" class="max-h-[80vh] w-auto max-w-full object-contain rounded-xl shadow-2xl" />
                <div v-else class="max-h-[80vh] w-[80vw] bg-slate-800 rounded-xl"></div>
                <button @click="nextImage" class="absolute right-2 sm:right-6 p-3 rounded-full bg-white/20 hover:bg-white/40 text-white transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div class="text-white text-sm font-semibold">
                {{ tl(heroSettings.page) }} {{ lightboxIndex + 1 }} {{ tl(heroSettings.of) }} {{ documentImages.length }}
            </div>
        </div>

        <SiteFooter />
    </div>
</template>
