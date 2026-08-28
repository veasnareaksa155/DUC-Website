<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    pageData: {
        type: Object,
        default: () => ({})
    },
    pageTitle: {
        type: String,
        default: 'Building'
    }
});

const isVisible = ref(false);
const page = usePage();

const tl = (textObj) => {
    if (!textObj) return '';
    if (typeof textObj === 'string') return textObj;
    return textObj[page.props.locale] || textObj.en || textObj.km || '';
};

const defaultText = {
    page_title: { km: 'អគារ | DUC', en: 'Building | DUC' },
    badge: { km: 'អំពីសាកលវិទ្យាល័យ', en: 'About University' },
    title: { km: 'អគារសាកលវិទ្យាល័យ', en: 'University Building' },
    subtitle: { km: 'ស្វែងយល់ពីហេដ្ឋារចនាសម្ព័ន្ធ និងអគារសិក្សាដ៏ទំនើបរបស់យើង។', en: 'Explore our state-of-the-art infrastructure and modern campus.' },
    building_img: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1600&q=80', // Beautiful modern building placeholder
};

const settings = computed(() => {
    const data = props.pageData || {};
    return {
        badge: (data.badge_en || data.badge_km) ? { en: data.badge_en, km: data.badge_km } : defaultText.badge,
        title: (data.title_en || data.title_km) ? { en: data.title_en, km: data.title_km } : defaultText.title,
        subtitle: (data.subtitle_en || data.subtitle_km) ? { en: data.subtitle_en, km: data.subtitle_km } : defaultText.subtitle,
        image: data.building_image || data.image || defaultText.building_img,
    };
});

const customSections = computed(() => {
    if (!props.pageData?.custom_sections) return [];
    const parsed = typeof props.pageData.custom_sections === 'string' 
        ? JSON.parse(props.pageData.custom_sections) 
        : props.pageData.custom_sections;
        
    return parsed.filter(sec => tl(sec.title) || tl(sec.content));
});

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});
</script>

<template>
    <Head :title="tl(defaultText.page_title)" />

    <div class="min-h-screen bg-global-bg font-sans text-slate-900 flex flex-col selection:bg-amber-400 overflow-hidden relative">
        <SiteHeader />

        <main class="flex-grow w-full transition-opacity duration-1000 pb-16" :class="isVisible ? 'opacity-100' : 'opacity-0'">
            
            <!-- Header Banner Section -->
            <section class="bg-[#115D6D] text-white py-11 px-4 sm:px-6 lg:px-8 border-b border-teal-800/50 shadow-md">
                <div class="max-w-[1400px] mx-auto text-center space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-amber-300 text-xs sm:text-sm font-semibold backdrop-blur-md border border-white/15 mb-1 shadow-sm">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>{{ tl(settings.badge) }}</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight max-w-4xl mx-auto mb-6 text-white" style="font-family: 'Moul', 'Khmer OS Moul', serif; text-shadow: 0 4px 20px rgba(0,0,0,0.4); line-height: 1.7;">
                        {{ tl(settings.title) }}
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-teal-50 max-w-3xl mx-auto font-medium mb-3 leading-relaxed">
                        {{ tl(settings.subtitle) }}
                    </p>
                </div>
            </section>

            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16 space-y-16">
                <!-- Hero Image Section -->
                <section class="animate-fade-in-up" style="animation-delay: 0.1s">
                    <div class="relative overflow-hidden rounded-3xl md:rounded-[2.5rem] shadow-[0_20px_50px_rgb(0,0,0,0.15)] bg-white border border-white/60 p-2 group">
                        <div class="rounded-[2rem] overflow-hidden relative aspect-[16/9] lg:aspect-[21/9]">
                            <img 
                                :src="settings.image" 
                                alt="University Building" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            
                            <!-- Floating Info on Image -->
                            <div class="absolute bottom-4 left-6 right-6 lg:bottom-10 lg:left-10 text-white drop-shadow-md">
                                <!-- <h2 class="text-2xl sm:text-3xl font-extrabold mb-2" style="font-family: 'Moul', 'Khmer OS Moul', serif;">
                                    {{ tl(settings.title) }}
                                </h2> -->
                                <p class="text-white/90 font-medium sm:text-lg max-w-2xl">
                                    {{ tl(settings.subtitle) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Dynamic CMS Sections -->
                <template v-if="customSections.length">
                    <section 
                        v-for="(section, idx) in customSections" 
                        :key="'custom-'+idx" 
                        class="animate-fade-in-up"
                        style="animation-delay: 0.3s"
                    >
                        <div class="text-justify rounded-3xl md:rounded-[2.5rem] border border-white/60 bg-white/80 p-6 sm:p-10 lg:p-14 backdrop-blur-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] space-y-6">
                            <div v-if="tl(section.title)" class="flex items-center gap-4 mb-6">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-teal-600">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#115D6D]">
                                    {{ tl(section.title) }}
                                </h2>
                            </div>
                            <div class="text-lg font-medium leading-relaxed text-slate-700 ql-editor px-0" v-html="tl(section.content)">
                            </div>
                        </div>
                    </section>
                </template>
                <template v-else>
                    <!-- Fallback content if CMS is empty -->
                    <section class="animate-fade-in-up" style="animation-delay: 0.3s">
                        <div class="text-center py-20 bg-white/50 backdrop-blur-sm rounded-3xl border border-white/60">
                            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <p class="text-lg text-slate-500 font-medium">ព័ត៌មានលម្អិតអំពីអគារនឹងត្រូវបានបន្ថែមនាពេលខាងមុខ។</p>
                            <p class="text-slate-400">Detailed building information will be added soon.</p>
                        </div>
                    </section>
                </template>
            </div>

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
    animation: blob 10s infinite alternate;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
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
