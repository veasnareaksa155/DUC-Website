<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';
import { computed, ref } from 'vue';

const page = usePage();
const degreeCertificateSettings = computed(() => page.props.degreeCertificateSettings || {});

// Helpers for translations
const locale = computed(() => page.props.locale || 'en');
const tl = (val) => {
    if (!val) return '';
    if (typeof val === 'string') return val;
    return val[locale.value] || val.en || val.km || '';
};

// Data
const hero = computed(() => {
    const rawHero = degreeCertificateSettings.value.hero || {};
    return {
        badge: tl(rawHero.badge) || 'CERTIFICATE',
        title: tl(rawHero.title) || 'Sample Degree Certificate',
        description: tl(rawHero.description) || 'View the official digital certificate issued by Digital University of Cambodia.'
    };
});

const details = computed(() => degreeCertificateSettings.value.details || {});

const defaultVerification = {
    title: { en: 'Authenticity & Verification', km: 'ភាពត្រឹមត្រូវ និងការផ្ទៀងផ្ទាត់' },
    description: { en: 'Every degree certificate issued by the Digital University of Cambodia features a unique QR Code and serial number for immediate verification. This ensures the integrity of our academic credentials and allows employers to easily authenticate the qualifications of our graduates through our official verification system.', km: 'សញ្ញាបត្រនីមួយៗដែលចេញដោយសាកលវិទ្យាល័យឌីជីថលកម្ពុជា មាន QR Code ពិសេស និងលេខសម្គាល់ដែលអាចផ្ទៀងផ្ទាត់បាន។ នេះធានានូវបូរណភាពនៃកំណត់ត្រាសិក្សារបស់យើង ហើយអនុញ្ញាតឱ្យនិយោជកងាយស្រួលផ្ទៀងផ្ទាត់ភាពត្រឹមត្រូវនៃគុណវុឌ្ឍិរបស់និស្សិតបញ្ចប់ការសិក្សាតាមរយៈប្រព័ន្ធផ្ទៀងផ្ទាត់ផ្លូវការរបស់យើង។' }
};

const verification = computed(() => {
    const rawVerification = degreeCertificateSettings.value.verification || {};
    return {
        title: tl(rawVerification.title || defaultVerification.title),
        description: tl(rawVerification.description || defaultVerification.description)
    };
});

const activeTab = ref('bachelor'); // 'bachelor' or 'associate'

const currentCertificateImage = computed(() => {
    if (activeTab.value === 'bachelor' && details.value.bachelor_img) {
        return details.value.bachelor_img;
    }
    if (activeTab.value === 'associate' && details.value.associate_img) {
        return details.value.associate_img;
    }
    // Fallback placeholder if no image is uploaded
    return '';
});

const isFullscreen = ref(false);

const toggleFullscreen = () => {
    if (!currentCertificateImage.value) return; // don't open if no image
    isFullscreen.value = !isFullscreen.value;
    if (isFullscreen.value) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
};

</script>

<template>
    <div class="min-h-screen bg-global-bg font-sans text-slate-900 flex flex-col selection:bg-amber-400 overflow-hidden relative">
        <Head>
            <title>{{ hero.title }} | Digital University of Cambodia</title>
            <meta name="description" :content="hero.description" />
        </Head>

        <SiteHeader />

        <!-- VIBRANT Abstract Background Mesh -->
        <div class="fixed top-[300px] left-0 right-0 h-[800px] overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-40 -right-20 w-[600px] h-[600px] rounded-full bg-blue-500/10 blur-[120px] mix-blend-multiply opacity-60 animate-blob"></div>
            <div class="absolute top-20 -left-20 w-[500px] h-[500px] rounded-full bg-amber-400/10 blur-[120px] mix-blend-multiply opacity-60 animate-blob animation-delay-2000"></div>
            <div class="absolute top-[400px] left-[20%] w-[600px] h-[600px] rounded-full bg-teal-400/10 blur-[120px] mix-blend-multiply opacity-40 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Fullscreen Modal -->
        <transition name="fade">
            <div v-if="isFullscreen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4" @click="toggleFullscreen">
                <button @click.stop="toggleFullscreen" class="absolute top-6 right-6 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/25 text-white transition-all backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <img :src="currentCertificateImage" :alt="hero.title" class="max-w-full max-h-[90vh] object-contain rounded-sm shadow-2xl pointer-events-none" />
            </div>
        </transition>

        <main class="flex-grow w-full pb-16">
            
            <!-- Header Banner Section -->
            <section class="bg-[#115D6D] text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-teal-800/50 shadow-md">
                <div class="max-w-[1400px] mx-auto text-center space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-amber-300 text-xs sm:text-sm font-semibold backdrop-blur-md border border-white/15 mb-6 shadow-sm">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        <span>{{ hero.badge }}</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-[1.3] max-w-4xl mx-auto mb-6 text-white" style="font-family: 'Moul', 'Khmer OS Moul', serif; text-shadow: 0 4px 20px rgba(0,0,0,0.4);">
                        {{ hero.title }}
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-teal-50 max-w-3xl mx-auto font-medium leading-relaxed">
                        {{ hero.description }}
                    </p>
                </div>
            </section>

            <!-- Content Section -->
            <div class="max-w-[1200px] mx-auto px-6 mt-12 relative z-20">
                <div class="p-4 md:px-12 animate-fade-in-up animation-delay-300">
                    
                    <div class="flex flex-col md:flex-row items-center justify-between mb-8 pb-8 border-b border-slate-100">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">{{ tl({en: 'Official Certificate Preview', km: 'មើលសញ្ញាបត្រជាមុន'}) }}</h2>
                            <p class="text-slate-500 mt-1">{{ tl({en: 'These are samples of the degree certificates awarded to graduates.', km: 'ទាំងនេះគឺជាគំរូនៃសញ្ញាបត្រដែលប្រគល់ជូននិស្សិតបញ្ចប់ការសិក្សា។'}) }}</p>
                        </div>
                        <div class="mt-6 md:mt-0 flex flex-col sm:flex-row gap-4 items-center">
                            <!-- Tabs -->
                            <div class="flex bg-slate-100 p-1 rounded-xl shadow-inner border border-slate-200">
                                <button @click="activeTab = 'bachelor'" :class="activeTab === 'bachelor' ? 'bg-white text-indigo-700 shadow border-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200 border-transparent'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all border">
                                    {{ tl({en: "Bachelor's Degree", km: 'បរិញ្ញាបត្រ'}) }}
                                </button>
                                <button @click="activeTab = 'associate'" :class="activeTab === 'associate' ? 'bg-white text-indigo-700 shadow border-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200 border-transparent'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all border">
                                    {{ tl({en: "Associate's Degree", km: 'បរិញ្ញាបត្ររង'}) }}
                                </button>
                            </div>
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button v-if="currentCertificateImage" @click="toggleFullscreen" class="px-4 py-2.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-xl font-bold transition-all flex items-center justify-center gap-2 border border-indigo-100 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                    <span class="hidden md:inline">{{ tl({en: 'Zoom', km: 'ពង្រីក'}) }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Frame Display -->
                    <div class="relative py-8 flex justify-center items-center overflow-hidden">
                        <transition name="fade" mode="out-in">
                            <!-- The Certificate Image -->
                            <div :key="activeTab" class="relative z-10 group cursor-pointer w-full flex justify-center" @click="toggleFullscreen">
                                
                                <div class="relative transform transition-transform duration-500 group-hover:scale-[1.02] mx-auto w-fit">
                                    <img v-if="currentCertificateImage" :src="currentCertificateImage" :alt="hero.title" class="w-full max-w-2xl h-auto object-contain shadow-none" />
                                    
                                    <!-- Empty State -->
                                    <div v-else class="w-full max-w-xl aspect-[1/1.4] bg-slate-50 flex flex-col items-center justify-center border-2 border-dashed border-slate-300 p-12 text-center text-slate-500 rounded-lg">
                                        <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-lg font-semibold">{{ tl({en: 'No Certificate Image Uploaded', km: 'មិនមានរូបភាពសញ្ញាបត្រទេ'}) }}</p>
                                        <p class="text-sm mt-2 max-w-md">{{ tl({en: 'Please upload the sample degree certificate image from the Admin Dashboard.', km: 'សូមបញ្ចូលរូបភាពគំរូសញ្ញាបត្រពីផ្ទាំងគ្រប់គ្រង (Admin Dashboard)។'}) }}</p>
                                    </div>
                                </div>
                                
                                <!-- Hover Overlay -->
                                <div v-if="currentCertificateImage" class="absolute inset-0 bg-indigo-900/0 flex items-center justify-center opacity-0 transition-all duration-300 rounded-sm">
                                    <div class="bg-white/90 backdrop-blur-sm text-indigo-900 px-6 py-3 rounded-full font-bold shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 flex items-center gap-2 pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                        {{ tl({en: 'Click to enlarge', km: 'ចុចដើម្បីពង្រីក'}) }}
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <!-- Authentic Verification Notice -->
                    <div class="mt-12 bg-white rounded-2xl p-6 md:p-8 flex flex-col md:flex-row gap-6 items-center md:items-start border border-slate-200 shadow-sm">
                        <div class="w-16 h-16 shrink-0 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">{{ verification.title }}</h3>
                            <p class="text-slate-600 leading-relaxed">{{ verification.description }}</p>
                        </div>
                    </div>

                </div>
            </div>
            
        </main>
        
        <SiteFooter />
    </div>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}
.animation-delay-100 {
    animation-delay: 100ms;
}
.animation-delay-200 {
    animation-delay: 200ms;
}
.animation-delay-300 {
    animation-delay: 300ms;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
