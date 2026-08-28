<script setup>
import { ref, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

const props = defineProps({
    graduationUniformSettings: Object
});

const page = usePage();

const tl = (obj) => {
    if (!obj) return '';
    if (typeof obj === 'string') return obj;
    return obj[page.props.locale] || obj.en || '';
};

const graduationUniformSettings = computed(() => props.graduationUniformSettings || {});

const defaultHero = {
    badge: { en: 'CERTIFICATE', km: 'វិញ្ញាបនបត្រ' },
    title: { en: 'Graduation Uniform', km: 'កម្រងឯកសណ្ឋានទទួលសញ្ញាបត្រ' },
    subtitle: { en: 'Guidelines on the graduation uniform of the Digital University of Cambodia.', km: 'គោលការណ៍ណែនាំស្តីពីកម្រងឯកសណ្ឋានទទួលសញ្ញាបត្ររបស់សាកលវិទ្យាល័យឌីជីថលកម្ពុជា។' },
};

const hero = computed(() => {
    const rawHero = graduationUniformSettings.value.hero || {};
    return {
        badge: tl(rawHero.badge || defaultHero.badge),
        title: tl(rawHero.title || defaultHero.title),
        subtitle: tl(rawHero.subtitle || defaultHero.subtitle),
    };
});

const defaultUniforms = {
    doctorate_img: null,
    master_img: null,
    bachelor_img: null,
    associate_img: null
};

const uniforms = computed(() => {
    return graduationUniformSettings.value.uniforms || defaultUniforms;
});

const activeTab = ref('doctorate'); // 'doctorate', 'master', 'bachelor', 'associate'

const currentUniformImage = computed(() => {
    if (activeTab.value === 'doctorate' && uniforms.value.doctorate_img) return uniforms.value.doctorate_img;
    if (activeTab.value === 'master' && uniforms.value.master_img) return uniforms.value.master_img;
    if (activeTab.value === 'bachelor' && uniforms.value.bachelor_img) return uniforms.value.bachelor_img;
    if (activeTab.value === 'associate' && uniforms.value.associate_img) return uniforms.value.associate_img;
    return '';
});

const isFullscreen = ref(false);

const toggleFullscreen = () => {
    if (!currentUniformImage.value) return; // don't open if no image
    isFullscreen.value = !isFullscreen.value;
    if (isFullscreen.value) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
};
</script>

<template>
    <Head :title="tl({en: 'Graduation Uniform | DUC', km: 'កម្រងឯកសណ្ឋានទទួលសញ្ញាបត្រ | DUC'})" />
    
    <div class="min-h-screen flex flex-col bg-slate-50 selection:bg-indigo-500/30 font-sans">
        <SiteHeader />
        
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
                    
                    <p class="text-lg sm:text-xl text-teal-50 max-w-3xl mx-auto font-medium mb-10 leading-relaxed">
                        {{ hero.subtitle }}
                    </p>
                </div>
            </section>

            <!-- Content Section -->
            <div class="max-w-[1200px] mx-auto px-6 mt-12 relative z-20">
                <div class="p-4 md:px-12 animate-fade-in-up animation-delay-300">
                    
                    <div class="flex flex-col md:flex-row items-center justify-between mb-8 pb-8 border-b border-slate-100">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">{{ tl({en: 'Uniform Gallery', km: 'កម្រងឯកសណ្ឋាន'}) }}</h2>
                            <p class="text-slate-500 mt-1">{{ tl({en: 'Select a degree type to view the corresponding graduation uniform.', km: 'សូមជ្រើសរើសកម្រិតសញ្ញាបត្រដើម្បីមើលឯកសណ្ឋាន'}) }}</p>
                        </div>
                        <div class="mt-6 md:mt-0 flex flex-col sm:flex-row gap-4 items-center">
                            <!-- Tabs -->
                            <div class="flex bg-slate-100 p-1 rounded-xl shadow-inner border border-slate-200">
                                <button @click="activeTab = 'doctorate'" :class="activeTab === 'doctorate' ? 'bg-white text-indigo-700 shadow border-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200 border-transparent'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all border">
                                    {{ tl({en: "Doctorate", km: 'បណ្ឌិត'}) }}
                                </button>
                                <button @click="activeTab = 'master'" :class="activeTab === 'master' ? 'bg-white text-indigo-700 shadow border-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200 border-transparent'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all border">
                                    {{ tl({en: "Master's", km: 'បរិញ្ញាបត្រជាន់ខ្ពស់'}) }}
                                </button>
                                <button @click="activeTab = 'bachelor'" :class="activeTab === 'bachelor' ? 'bg-white text-indigo-700 shadow border-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200 border-transparent'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all border">
                                    {{ tl({en: "Bachelor's", km: 'បរិញ្ញាបត្រ'}) }}
                                </button>
                                <button @click="activeTab = 'associate'" :class="activeTab === 'associate' ? 'bg-white text-indigo-700 shadow border-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200 border-transparent'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all border">
                                    {{ tl({en: "Associate's", km: 'បរិញ្ញាបត្ររង'}) }}
                                </button>
                            </div>
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button v-if="currentUniformImage" @click="toggleFullscreen" class="px-4 py-2.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-xl font-bold transition-all flex items-center justify-center gap-2 border border-indigo-100 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                    <span class="hidden md:inline">{{ tl({en: 'Zoom', km: 'ពង្រីក'}) }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Image Display -->
                    <div class="relative py-8 flex justify-center items-center overflow-hidden">
                        <transition name="fade" mode="out-in">
                            <div :key="activeTab" class="relative z-10 group cursor-pointer w-full flex justify-center" @click="toggleFullscreen">
                                <div class="relative transform transition-transform duration-500 group-hover:scale-[1.02] mx-auto w-fit">
                                    <img v-if="currentUniformImage" :src="currentUniformImage" class="w-full max-w-2xl h-auto object-contain shadow-none" alt="Graduation Uniform" />
                                    <div v-else class="w-full max-w-xl aspect-[1/1.4] bg-slate-50 flex flex-col items-center justify-center border-2 border-dashed border-slate-300 p-12 text-center text-slate-500 rounded-lg">
                                        <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-lg font-semibold">{{ tl({en: 'No image uploaded yet', km: 'មិនទាន់មានរូបភាពឯកសណ្ឋាន'}) }}</p>
                                    </div>
                                </div>
                                <!-- Hover Overlay -->
                                <div v-if="currentUniformImage" class="absolute inset-0 bg-indigo-900/0 flex items-center justify-center opacity-0 transition-all duration-300 rounded-sm">
                                    <div class="bg-white/90 backdrop-blur-sm text-indigo-900 px-6 py-3 rounded-full font-bold shadow-xl transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 flex items-center gap-2 pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                        {{ tl({en: 'Click to enlarge', km: 'ចុចដើម្បីពង្រីក'}) }}
                                    </div>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </main>
        
        <SiteFooter />
    </div>

    <!-- Fullscreen Image Modal -->
    <transition name="modal">
        <div v-if="isFullscreen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-md" @click.self="toggleFullscreen">
            <button @click="toggleFullscreen" class="absolute top-6 right-6 p-3 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-full transition-all z-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="relative w-full h-full p-4 md:p-12 flex items-center justify-center">
                <img :src="currentUniformImage" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" alt="Full Screen Graduation Uniform" />
            </div>
        </div>
    </transition>
</template>

<style scoped>
.font-khmer {
    font-family: 'Khmer OS Siemreap', 'Kantumruy Pro', sans-serif;
}

.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.fade-enter-from {
    opacity: 0;
    transform: translateY(10px) scale(0.98);
}

.fade-leave-to {
    opacity: 0;
    transform: translateY(-10px) scale(0.98);
}

.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-from img,
.modal-leave-to img {
    transform: scale(0.95);
}

.modal-enter-active img,
.modal-leave-active img {
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Animations from SiteHeader/StudentUniform style */
.animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    opacity: 0;
}

.animation-delay-300 {
    animation-delay: 300ms;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
