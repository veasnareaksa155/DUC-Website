<script setup>
import { Head, Link } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

import { ref, computed, onMounted, onUnmounted, watch, nextTick } from 'vue';

const props = defineProps({
    office: String,
    officeData: Object,
});

const customSections = computed(() => {
    if (!props.officeData.custom_sections) return [];
    try {
        return typeof props.officeData.custom_sections === 'string' 
            ? JSON.parse(props.officeData.custom_sections) 
            : props.officeData.custom_sections;
    } catch (e) {
        return [];
    }
});

// Build the array of contents
const allContents = computed(() => {
    const list = [];
    
    // Add main history/content if it exists
    if (props.officeData.content && (props.officeData.content.en !== '<p></p>' || props.officeData.content.km !== '<p></p>')) {
        if (props.officeData.content.en || props.officeData.content.km) {
             list.push({
                idx: 0,
                type: 'richtext',
                label: { en: 'History', km: 'ប្រវត្តិ' },
                content: props.officeData.content
            });
        }
    }

    customSections.value.forEach((sec, i) => {
        list.push({
            idx: list.length,
            type: 'richtext',
            label: sec.title,
            content: sec.content
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
</script>

<template>
    <Head :title="$t(officeData.title)" />

    <div class="min-h-screen bg-global-bg font-sans flex flex-col">
        <SiteHeader />

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

        <main class="flex-grow py-8 md:py-12">
            <!-- Content Layout (if exists) -->
            <div v-if="allContents.length > 0" class="max-w-[1400px] mx-auto px-4 sm:px-6 mb-16 space-y-10">
                
                <!-- Hero Image (Maintains Aspect Ratio) -->
                <section v-if="officeData.image" class="relative animate-fade-in-up">
                    <div class="relative overflow-hidden lg:rounded-2xl rounded-xl shadow-[0_20px_50px_rgb(0,0,0,0.1)] w-full bg-white">
                        <img 
                            :src="officeData.image" 
                            class="w-full h-auto block"
                        />
                    </div>
                </section>

                <!-- Title Focus -->
                <section class="animate-fade-in-up flex flex-col items-center text-center max-w-4xl mx-auto space-y-4" style="animation-delay: 0.1s">
                    <h1 class="text-3xl font-extrabold leading-[1.1] tracking-tight text-[#1c244b] md:text-5xl drop-shadow-sm">
                        {{ $t(officeData.title) }}
                    </h1>
                </section>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                    <div class="hidden lg:block lg:col-span-1 sticky top-[100px] self-start h-fit z-10 transition-all duration-300">
                        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                            <h3 class="text-base font-bold text-gray-900 mb-4">{{ $t(officeData.title) }}</h3>
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
                        <div v-for="(prog, idx) in allContents" :key="idx" :id="'program-section-' + prog.idx" class="bg-white rounded-xl p-6 md:p-10 shadow-sm border border-gray-100">
                            <h2 class="text-2xl font-bold text-[#1c244b] mb-6 pb-4 border-b border-gray-100">
                                {{ $t(prog.label) }}
                            </h2>
                            
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

<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
