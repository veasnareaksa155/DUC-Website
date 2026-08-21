<script setup>
import { Head, Link } from "@inertiajs/vue3";
import SiteFooter from "@/Components/SiteFooter.vue";
import SiteHeader from "@/Components/SiteHeader.vue";
import { onMounted, onUnmounted } from "vue";

const props = defineProps({
    videosList: {
        type: Array,
        default: () => []
    }
});

// Scroll animation setup
let observer = null;

const setupScrollAnimations = () => {
    const options = {
        root: null,
        rootMargin: "0px",
        threshold: 0.15,
    };

    observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains("scroll-reveal")) {
                    entry.target.classList.remove("opacity-0", "translate-y-12");
                    entry.target.classList.add("opacity-100", "translate-y-0");
                }
                observer.unobserve(entry.target);
            }
        });
    }, options);

    const targets = document.querySelectorAll(".scroll-reveal");
    targets.forEach((target) => observer.observe(target));
};

onMounted(() => {
    setupScrollAnimations();
});

onUnmounted(() => {
    if (observer) observer.disconnect();
});

const getEmbedUrl = (video) => {
    const rawUrl = video.url;
    const type = video.type || 'youtube';
    
    if (!rawUrl) return "";
    
    // Cleanly extract URL if the user pastes an HTML embed code (iframe)
    const iframeMatch = rawUrl.match(/src="([^"]+)"/);
    if (iframeMatch) {
        return iframeMatch[1];
    }
    
    if (type === 'youtube') {
        let videoId = "";
        try {
            if (rawUrl.includes("youtu.be/")) {
                videoId = rawUrl.split("youtu.be/")[1].split("?")[0];
            } else if (rawUrl.includes("youtube.com/watch")) {
                const urlParams = new URLSearchParams(new URL(rawUrl).search);
                videoId = urlParams.get("v");
            } else if (rawUrl.includes("youtube.com/embed/")) {
                videoId = rawUrl.split("youtube.com/embed/")[1].split("?")[0];
            }
            if (videoId) {
                return `https://www.youtube.com/embed/${videoId}?rel=0`;
            }
            return rawUrl;
        } catch (e) {
            return rawUrl;
        }
    }
    
    if (type === 'facebook') {
        return `https://www.facebook.com/plugins/video.php?href=${encodeURIComponent(rawUrl)}&show_text=false&width=auto`;
    }
    
    if (type === 'tiktok') {
        // Cleanly extract video ID if the user pastes a blockquote embed code
        const tiktokMatch = rawUrl.match(/data-video-id="(\d+)"/);
        if (tiktokMatch) {
            return `https://www.tiktok.com/embed/v2/${tiktokMatch[1]}`;
        }

        let videoId = "";
        try {
            if (rawUrl.includes("/video/")) {
                videoId = rawUrl.split("/video/")[1].split("?")[0];
            }
            if (videoId) {
                return `https://www.tiktok.com/embed/v2/${videoId}`;
            }
            return rawUrl;
        } catch (e) {
            return rawUrl;
        }
    }
    
    return rawUrl;
};
</script>

<template>
    <Head title="Videos" />
    <SiteHeader />

    <main class="min-h-screen bg-[#ebf4f6]">
        <div class="mx-auto max-w-[1400px] px-4 md:px-6 pt-7 pb-12">
            <!-- Header -->
            <div class="mb-14 mt-7 border-b text-center border-slate-300/60 pb-4 scroll-reveal opacity-0 translate-y-12 transition-all duration-1000 ease-out">
                <h1 class="text-3xl​ md:text-4xl font-bold text-[#115D6D]">
                    {{ $t('School Action Videos') }}
                </h1>
            </div>

            <!-- Videos List -->
            <div v-if="videosList && videosList.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <div 
                    v-for="(video, index) in videosList" 
                    :key="index"
                    class="scroll-reveal opacity-0 translate-y-12 transition-all duration-1000 ease-out flex flex-col bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden"
                >
                    <!-- Video Top -->
                    <div class="relative aspect-video w-full bg-black">
                        <video v-if="video.type === 'file'"
                            controls
                            preload="metadata"
                            playsinline
                            class="absolute inset-0 w-full h-full object-contain"
                        >
                            <source :src="video.url" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div v-else-if="video.url && video.url.includes('<iframe')"
                            class="absolute inset-0 w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:absolute [&>iframe]:inset-0"
                            v-html="video.url"
                        ></div>
                        <iframe v-else
                            class="absolute inset-0 w-full h-full"
                            :src="getEmbedUrl(video)"
                            title="School Video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    </div>

                    <!-- Text Bottom -->
                    <div class="p-5 md:p-6 flex flex-col flex-1 bg-white">
                        <div class="flex items-start gap-3">
                            <span class="text-[#ffb800] text-[18px] leading-none mt-1 shrink-0">◆</span>
                            <div class="flex-1">
                                <h3 class="text-lg md:text-xl font-bold text-[#0f2154] leading-snug line-clamp-2">{{ $t(video.title) }}</h3>
                            </div>
                        </div>
                        <div 
                            v-if="video.description && ($t(video.description) !== '')"
                            class="mt-3 text-[14px] leading-relaxed text-slate-500 ql-editor px-0 font-normal ml-[26px] line-clamp-3" 
                            v-html="$t(video.description)"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200 shadow-sm scroll-reveal opacity-0 translate-y-12 transition-all duration-1000 ease-out">
                <svg class="mx-auto h-16 w-16 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h2 class="text-xl font-bold text-slate-600">{{ $t('No Videos Available') }}</h2>
                <p class="mt-2 text-slate-400 max-w-md mx-auto">{{ $t('Check back later for exciting school action videos.') }}</p>
            </div>
        </div>
    </main>

    <SiteFooter />
</template>
