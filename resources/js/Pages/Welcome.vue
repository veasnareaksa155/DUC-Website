<script setup>
import { Head, Link } from "@inertiajs/vue3";
import SiteFooter from "@/Components/SiteFooter.vue";
import SiteHeader from "@/Components/SiteHeader.vue";
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/autoplay';
import 'swiper/css/effect-fade';
import 'swiper/css/effect-coverflow';
import { Navigation, Pagination, Autoplay, EffectFade, EffectCoverflow } from 'swiper/modules';
const props = defineProps({
    recentEvents: {
        type: Array,
        default: () => []
    },
    homeSettings: {
        type: Object,
        default: () => ({})
    }
});

const statsItems = computed(() => {
    const customStats = props.homeSettings?.home_stats;
    if (customStats && Array.isArray(customStats) && customStats.length > 0) {
        return customStats;
    }
    return [
        { value: '1', label: { en: 'University Campus', km: 'ទីតាំងសាកលវិទ្យាល័យ' }, icon: 'building' },
        { value: '1000+', label: { en: 'Active Students', km: 'និស្សិតសរុប' }, icon: 'student' },
        { value: '1200+', label: { en: 'Computers & IT Devices', km: 'កុំព្យូទ័រ & ឧបករណ៍' }, icon: 'computer' },
        { value: '50+', label: { en: 'Professors & Lecturers', km: 'សាស្ត្រាចារ្យ & បុគ្គលិក' }, icon: 'user' }
    ];
});

const fallbackClasses = {
    campus: 'from-[#203f67] via-[#647c55] to-[#d8dfeb]',
    digital: 'from-[#171717] via-[#242424] to-[#0d0d0d]',
    announcement: 'from-[#233557] via-[#4d8b16] to-[#d8e7ff]',
};

// ================= HERO CAROUSEL STATE =================
const slides = computed(() => {
    if (props.homeSettings?.home_hero_slides?.length > 0) {
        return props.homeSettings.home_hero_slides;
    }
    return [
        {
            imgUrl: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTh8n8gF1G7cCVcNSbdRLYi32AItD4bqXqg1MbqlvNy4HTYpCtMuZOnFO8",
            altText: "DUC Students Group",
        },
        {
            imgUrl: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSvbI20ViYLMCDTyejEmwEiaKJkqD23aYWlQssf874ZvD5c7BRb73YokQox&s=10",
            altText: "DUC Campus Layout",
        },
        {
            imgUrl: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzu2oR8YVBZ4GuJXJQzKq5HT5odxP0plf-s269P_B_ZGhmtORzwojlKhg&s=10",
            altText: "DUC Campus Layout",
        },
    ];
});

// ================= STUDENTS ACTIVITIES CAROUSEL STATE =================
const activitiesSlides = computed(() => {
    if (props.homeSettings && Array.isArray(props.homeSettings.home_activities_slides)) {
        return props.homeSettings.home_activities_slides.filter(
            slide => slide && slide.img && typeof slide.img === 'string' && slide.img.trim() !== ''
        );
    }
    return [
        {
            img: "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=500&q=80",
            alt: "Laptop distribution event",
        },
        {
            img: "https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=500&q=80",
            alt: "Conference Group photo",
        },
        {
            img: "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=500&q=80",
            alt: "Students collaborating",
        },
        {
            img: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=500&q=80",
            alt: "Graduation day",
        },
    ];
});

// ================= DYNAMIC SECTIONS FALLBACKS =================
const scholarship = computed(() => {
    const defaultFooterText = { en: "Your journey to excellence starts here!", km: "ដំណើរកម្សាន្តរបស់អ្នកឆ្ពោះទៅរកភាពឆ្នើមចាប់ផ្តើមពីទីនេះ!" };
    if (props.homeSettings?.home_scholarship?.title) {
        return {
            footer_text: defaultFooterText,
            ...props.homeSettings.home_scholarship
        };
    }
    return {
        title: "Welcome to the Digital University of Cambodia",
        description: "Empowering the next generation of digital leaders, innovators, and change makers. We are proud to offer a 100% Full Scholarship exclusively for Cambodian students, ensuring that financial barriers never stand in the way of world-class education.\nUnlock your potential, master the skills of tomorrow, and shape the future of our nation completely tuition-free.",
        footer_text: defaultFooterText,
        bg_image: "https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80"
    };
});

const fourYears = computed(() => {
    if (props.homeSettings?.home_four_years?.length === 4) {
        return props.homeSettings.home_four_years;
    }
    return [
        { title: "Foundation year", description: "The Department of Software Engineering aims to graduate world-class super engineers and global leaders by using cutting-edge methodologies." },
        { title: "Second year", description: "The Department of Software Engineering aims to graduate world-class super engineers and global leaders by using cutting-edge methodologies." },
        { title: "Third year", description: "The Department of Software Engineering aims to graduate world-class super engineers and global leaders by using cutting-edge methodologies." },
        { title: "Last year", description: "The Department of Software Engineering aims to graduate world-class super engineers and global leaders by using cutting-edge methodologies." }
    ];
});

const graduateAttributes = computed(() => {
    let ga = props.homeSettings?.home_graduate_attributes || {};
    let cards = ga.cards;
    
    // Fallback migration logic in case the new structure isn't saved yet
    if (!cards) {
        cards = [];
        if (ga.card_1 || !ga.title) {
            cards.push({
                title: ga.card_1?.title || { en: 'Knowledge & Professionalism', km: 'ចំណេះដឹង និងវិជ្ជាជីវៈ' },
                description: ga.card_1?.description || { en: 'Communicate effectively with the body of knowledge that underpins professional practice.', km: 'ទាក់ទងដោយប្រសិទ្ធភាពជាមួយនឹងចំណេះដឹងដែលជាមូលដ្ឋានគ្រឹះនៃប្រតិបត្តិការវិជ្ជាជីវៈ។' },
                image: ''
            });
        }
        if (ga.card_2 || !ga.title) {
            cards.push({
                title: ga.card_2?.title || { en: 'Active Learning', km: 'ការសិក្សាសកម្ម' },
                description: ga.card_2?.description || { en: 'The beautiful thing about learning is that no one can take it away from you — but the magical thing about active learning is that you own what you build.', km: 'អ្វីដែលស្រស់ស្អាតអំពីការរៀនសូត្រគឺគ្មាននរណាម្នាក់អាចយកវាចេញពីអ្នកបានឡើយ...' },
                image: ''
            });
        }
        if (ga.card_3 || !ga.title) {
            cards.push({
                title: ga.card_3?.title || { en: 'Communication & Teamwork', km: 'ការប្រាសព្វប្រស្រ័យ និងការងារក្រុម' },
                description: ga.card_3?.description || { en: 'Have enhanced cultural, social, and ethical awareness as engaged members of the community.', km: 'មានការយល់ដឹងអំពីវប្បធម៌ សង្គម និងសីលធម៌ខ្ពស់...' },
                image: (typeof ga.card_3?.image === 'string' && ga.card_3.image.trim() !== '') ? ga.card_3.image : "https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=80"
            });
        }
    } else {
        // Sanitize cards to prevent empty object image rendering issues
        cards = cards.map(card => {
            return {
                ...card,
                image: (typeof card.image === 'string' && card.image.trim() !== '') ? card.image : null
            };
        });
    }

    return {
        title: ga.title || { en: 'Graduate Attributes', km: 'គុណសម្បត្តិនៃអ្នកបញ្ចប់ការសិក្សា' },
        cards: cards
    };
});

const videoSection = ref(null);
const videoIframe = ref(null);
const isVideoVisible = ref(false);
let observer = null;
let videoObserver = null;

const videoUrl = computed(() => {
    let rawUrl = props.homeSettings?.home_video_url;
    let baseEmbed = "";
    
    if (!rawUrl) {
        baseEmbed = "https://www.youtube.com/embed/G44lO3-SuuI?si=R_zTl8N6H8Qje7Gj";
    } else {
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
                baseEmbed = `https://www.youtube.com/embed/${videoId}`;
            } else {
                baseEmbed = rawUrl;
            }
        } catch (e) {
            baseEmbed = rawUrl;
        }
    }
    
    // Always include enablejsapi so we can control play/pause via postMessage
    const separator = baseEmbed.includes('?') ? '&' : '?';
    return `${baseEmbed}${separator}enablejsapi=1&mute=1`;
});

// Send play/pause commands to YouTube iframe via postMessage
const sendVideoCommand = (command) => {
    if (!videoIframe.value) return;
    try {
        const message = JSON.stringify({ event: 'command', func: command, args: [] });
        videoIframe.value.contentWindow.postMessage(message, '*');
    } catch (e) {
        // Silently ignore cross-origin errors
    }
};


// ================= SCROLL ANIMATION CONFIGURATION =================

const animateCountUp = (el) => {
    const target = parseInt(el.getAttribute('data-target') || '0', 10);
    const duration = 2000;
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        // easeOutQuart
        const easeProgress = 1 - Math.pow(1 - progress, 4);
        el.innerText = Math.floor(easeProgress * target);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
};

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
                if (entry.target.classList.contains("count-up")) {
                    animateCountUp(entry.target);
                }
                observer.unobserve(entry.target);
            }
        });
    }, options);

    const targets = document.querySelectorAll(".scroll-reveal, .count-up");
    targets.forEach((target) => observer.observe(target));
};

const setupVideoAutoplay = () => {
    if (!videoSection.value) return;

    videoObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                // User scrolled to the video section — autoplay
                isVideoVisible.value = true;
                sendVideoCommand('playVideo');
            } else {
                // User scrolled away — pause the video
                isVideoVisible.value = false;
                sendVideoCommand('pauseVideo');
            }
        });
    }, {
        threshold: 0.25
    });

    videoObserver.observe(videoSection.value);
};

// ================= LIFECYCLE MANAGEMENT =================
onMounted(() => {
    setupScrollAnimations();
    setupVideoAutoplay();
});

onUnmounted(() => {
    if (observer) observer.disconnect();
    if (videoObserver) videoObserver.disconnect();
});

const stripHtml = (html) => {
    if (!html) return '';
    return html.replace(/<\/?[^>]+(>|$)/g, "");
};

const videoBgColor = computed(() => {
    const color = props.homeSettings?.home_video_bg_color;
    if (color && color !== '#0f2154' && color !== '#0d184a' && color !== '#3852a4') {
        return color;
    }
    return '#115D6D';
});
</script>

<template>
    <Head title="Digital University of Cambodia" />

    <div class="min-h-screen bg-[#c9e0e4] text-slate-900">
        <SiteHeader />

        <main class="bg-[#c9e0e4] overflow-hidden">
            <section class="relative w-full overflow-hidden bg-slate-950">
                <div class="relative w-full group hero-swiper">
                    <Swiper
                        :modules="[Navigation, Pagination, Autoplay, EffectCoverflow]"
                        :autoplay="{ delay: 5000, disableOnInteraction: false }"
                        :pagination="{ clickable: true }"
                        :navigation="true"
                        :loop="true"
                        :centeredSlides="true"
                        grabCursor="true"
                        :speed="800"
                        slidesPerView="auto"
                        effect="coverflow"
                        :coverflowEffect="{
                            rotate: 40,
                            stretch: -25,
                            depth: 300,
                            modifier: 1.5,
                            scale: 0.9,
                            slideShadows: true
                        }"
                        class="w-full py-6 md:py-10"
                    >
                        <SwiperSlide v-for="(slide, index) in slides" :key="index" style="width: calc(100vw - 32px); max-width: 1368px;">
                            <img
                                :src="slide.imgUrl"
                                :alt="typeof slide.altText === 'object' ? slide.altText.en : slide.altText"
                                class="w-full h-auto select-none rounded-2xl md:rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.5)]"
                            />
                        </SwiperSlide>
                    </Swiper>
                </div>
            </section>

            <section class="scroll-reveal transition-all duration-1000 ease-out mx-auto max-w-[1400px] px-4 md:px-6 py-16 bg-white">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h2 class="text-2xl font-bold text-[#115D6D]">{{ $t('News/Event') }}</h2>
                    <Link href="/events" class="text-sm font-semibold text-[#115D6D] hover:underline flex items-center gap-1">
                        {{ $t('See All Events') }} <span class="text-lg">→</span>
                    </Link>
                </div>

                <div v-if="recentEvents && recentEvents.length > 0" class="mt-8 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div v-for="event in recentEvents" :key="event.id" class="flex flex-col justify-between">
                        <div>
                            <Link :href="`/events/${event.id}`" class="block overflow-hidden rounded-xl bg-gray-100 aspect-[4/3] relative group cursor-pointer">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br"
                                    :class="fallbackClasses[event.type] || 'from-[#203f67] via-[#647c55] to-[#d8dfeb]'"
                                >
                                    <div v-if="event.type === 'campus'" class="absolute inset-0">
                                        <div class="absolute -left-7 -top-9 h-32 w-32 rounded-full border-[16px] border-white/35"></div>
                                        <div class="absolute bottom-0 right-0 h-20 w-[82%] rounded-tl-[42px] bg-white/20 backdrop-blur-[1px]"></div>
                                        <div class="absolute bottom-4 right-5 text-right text-2xl font-black tracking-normal text-white/85">DUC</div>
                                    </div>
                                    <div v-else-if="event.type === 'digital'" class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                        <div class="mb-4 h-12 w-20 bg-[#0e4aba] shadow-sm">
                                            <div class="mt-4 h-4 bg-[#df1f2d]"></div>
                                        </div>
                                        <div class="text-[28px] font-black leading-none tracking-normal text-[#ff9c00]">DIGITAL 2024</div>
                                        <div class="mt-1 text-[10px] font-bold tracking-[0.14em] text-white">CAMBODIA</div>
                                    </div>
                                    <div v-else class="absolute inset-0">
                                        <div class="absolute right-0 top-0 h-[62%] w-[78%] rounded-bl-[48px] bg-black/30"></div>
                                        <div class="absolute bottom-0 left-0 h-8 w-full bg-[#48a809]"></div>
                                        <div class="absolute bottom-9 left-5 right-5 text-[20px] font-black leading-tight text-white">DUC Announcement</div>
                                        <div class="absolute bottom-2 left-5 text-[11px] font-bold text-white">Digital University of Cambodia</div>
                                    </div>
                                </div>
                                <img
                                    v-if="event.image"
                                    :src="event.image"
                                    :alt="event.title"
                                    class="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition duration-500"
                                    @error="$event.currentTarget.classList.add('hidden')"
                                />
                            </Link>
                            <Link :href="`/events/${event.id}`" class="block pt-5 font-bold text-slate-900 hover:text-[#00a0e9] transition-colors line-clamp-2">
                                <h3>{{ $t(event.title) }}</h3>
                            </Link>
                            <p class="mt-2 text-sm leading-relaxed text-slate-500 line-clamp-2">
                                {{ stripHtml($t(event.description)) }}
                            </p>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xs font-medium text-slate-400">
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $t(event.date) }}
                            </span>
                            <Link :href="`/events/${event.id}`" class="text-[#00a0e9] hover:underline">{{ $t('Read more') }} →</Link>
                        </div>
                    </div>
                </div>

                <div v-else class="mt-8 py-16 text-center text-gray-500 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L16.5 5.5M9 11l3 3L22 4" />
                    </svg>
                    <p class="text-lg font-medium text-gray-600">{{ $t('No events found') }}</p>
                    <p class="text-sm mt-1 text-gray-400">{{ $t('There are currently no upcoming news or events to display.') }}</p>
                </div>
            </section>

            <hr class="border-gray-200" />

            <section class="scholarship-block scroll-reveal transition-all duration-1000 ease-out mx-auto max-w-[1400px] px-4 md:px-6 py-16 bg-slate-50/50">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-[#115D6D]">{{ $t('Scholarship for Students') }}</h2>
                    <div class="mx-auto mt-2 h-1 w-36 bg-amber-400 rounded-full"></div>
                </div>

                <div class="mt-12 grid items-center gap-10 lg:grid-cols-12">
                    <div class="lg:col-span-5 overflow-hidden rounded-2xl shadow-sm bg-white p-2 border border-gray-100">
                        <img :src="scholarship.bg_image" alt="Campus Life" class="w-full rounded-xl object-cover aspect-[4/3]" />
                    </div>

                    <div class="lg:col-span-7 space-y-4">
                        <div class="flex items-start gap-2 text-xl font-bold text-slate-800 lg:text-2xl">
                            <span class="text-amber-500 mt-1">◆</span>
                            <h3 class="font-extrabold text-[#115D6D] text-xl lg:text-2xl scholarship-title">{{ $t(scholarship.title) }}</h3>
                        </div>
                        <div class="text-slate-600 space-y-4 leading-relaxed text-sm md:text-base">
                            <div class="whitespace-pre-wrap ql-editor px-0 scholarship-text-content" v-html="$t(scholarship.description)"></div>
                            <p v-if="scholarship.footer_text" class="font-semibold text-[#115D6D] italic scholarship-footer-text">
                                {{ $t(scholarship.footer_text) }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <hr class="border-gray-200" />

            <section class="scroll-reveal transition-all duration-1000 ease-out mx-auto max-w-[1400px] px-4 md:px-6 py-16 bg-white">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-[#115D6D]">{{ $t('Four Years at Digital University of Cambodia') }}</h2>
                    <div class="mx-auto mt-2 h-1 w-56 bg-amber-400 rounded-full"></div>
                </div>

                <div class="mt-12 grid gap-8 sm:grid-cols-2 w-full">
                    <div v-for="(year, index) in fourYears" :key="index"
                         class="rounded-xl p-8 shadow-sm flex flex-col justify-center min-h-[220px] hover:shadow-lg transition duration-300"
                         :class="(index === 0 || index === 3) ? 'bg-[#115D6D] text-white' : 'bg-white text-slate-800 border border-gray-200'">
                        <h3 class="text-xl font-bold text-center" :class="(index === 0 || index === 3) ? 'text-white' : 'text-slate-900'">{{ $t(year.title) }}</h3>
                        <div class="mt-4 text-sm text-center leading-relaxed ql-editor px-0" :class="(index === 0 || index === 3) ? 'text-slate-200' : 'text-slate-500'" v-html="$t(year.description)">
                        </div>
                    </div>
                </div>
            </section>

            <section
                ref="videoSection"
                class="scroll-reveal transition-all duration-1000 ease-out w-full overflow-hidden bg-cover bg-center bg-no-repeat bg-blend-multiply py-16"
                :style="{
                    backgroundImage: props.homeSettings?.home_video_bg_image ? `url(${props.homeSettings.home_video_bg_image})` : 'none',
                    backgroundColor: videoBgColor
                }"
            >
                <div class="relative max-w-[1400px] px-4 md:px-6 mx-auto w-full">
                    <div class="relative aspect-video w-full rounded-2xl overflow-hidden border-4 border-teal-400 shadow-2xl bg-black">
                        <iframe
                            ref="videoIframe"
                            class="absolute inset-0 w-full h-full"
                            :src="videoUrl"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share;"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </section>

            <hr class="border-gray-200" />

            <section v-if="activitiesSlides && activitiesSlides.length > 0" class="scroll-reveal transition-all duration-1000 ease-out mx-auto max-w-[1400px] px-4 md:px-6 py-16 bg-white">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-[#115D6D]">{{ $t('Students Activities') }}</h2>
                    <div class="mx-auto mt-2 h-1 w-28 bg-amber-400 rounded-full"></div>
                </div>

                <div class="relative mt-12 w-full mx-auto px-4 sm:px-12 activities-swiper-container">
                    <Swiper
                        :modules="[Navigation, Pagination, Autoplay]"
                        :autoplay="{ delay: 3500, disableOnInteraction: false, pauseOnMouseEnter: true }"
                        :navigation="{
                            nextEl: '.activities-next',
                            prevEl: '.activities-prev',
                        }"
                        :loop="true"
                        :pagination="{ clickable: true }"
                        :spaceBetween="24"
                        :breakpoints="{
                            320: { slidesPerView: 1 },
                            640: { slidesPerView: 2 },
                            1024: { slidesPerView: 3 },
                        }"
                        class="w-full !pt-4 !pb-12"
                    >
                        <SwiperSlide v-for="(slide, index) in activitiesSlides" :key="index" class="h-auto">
                            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow p-3 h-full cursor-pointer group">
                                <div class="overflow-hidden rounded-xl h-64">
                                    <img :src="slide.img" :alt="$t(slide.alt)" class="w-full h-full object-cover select-none transform group-hover:scale-105 transition-transform duration-500" />
                                </div>
                            </div>
                        </SwiperSlide>
                    </Swiper>

                    <!-- Custom Navigation Buttons -->
                    <button class="activities-prev absolute left-0 top-1/2 -translate-y-1/2 z-10 rounded-full bg-white p-3 shadow-lg border border-gray-100 hover:bg-gray-50 text-slate-800 transition focus:outline-none hidden sm:flex disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button class="activities-next absolute right-0 top-1/2 -translate-y-1/2 z-10 rounded-full bg-white p-3 shadow-lg border border-gray-100 hover:bg-gray-50 text-slate-800 transition focus:outline-none hidden sm:flex disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </section>

            <section class="scroll-reveal transition-all duration-1000 ease-out w-full py-16 sm:py-20 bg-gradient-to-b from-slate-50 via-white to-teal-50/40 border-t border-b border-gray-100 relative overflow-hidden">
                <!-- Subtle Background Glows -->
                <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="mx-auto max-w-[1400px] px-4 md:px-6 relative z-10 text-center">
                    <!-- Section Header -->
                    <h2 class="text-2xl sm:text-3xl font-black text-[#115D6D] tracking-tight">{{ $t('Digital University of Cambodia') }}</h2>
                    <div class="mx-auto mt-3 h-1.5 w-24 bg-gradient-to-r from-amber-400 to-yellow-500 rounded-full shadow-sm"></div>

                    <!-- Dynamic Counter Cards Grid -->
                    <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 justify-center">
                        <div 
                            v-for="(item, index) in statsItems" 
                            :key="'stat-card-'+index"
                            class="group relative bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-[0_10px_30px_rgb(0,0,0,0.03)] hover:shadow-[0_20px_40px_rgba(17,93,109,0.12)] hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center"
                        >
                            <!-- Icon Badge -->
                            <div class="w-16 h-16 rounded-2xl bg-teal-50 text-[#115D6D] border border-teal-100 flex items-center justify-center mb-4 shadow-inner group-hover:scale-110 group-hover:bg-[#115D6D] group-hover:text-white transition-all duration-300">
                                <!-- Dynamic Icon Render -->
                                <svg v-if="item.icon === 'building'" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" /></svg>
                                <svg v-else-if="item.icon === 'student'" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>
                                <svg v-else-if="item.icon === 'computer'" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25M19.5 5.25l-15 0A2.25 2.25 0 002.25 7.5v6.563c0 .126.06.245.165.32l2.625 1.875a.375.375 0 00.46 0l2.625-1.875a.375.375 0 01.46 0l2.625 1.875a.375.375 0 00.46 0l2.625-1.875a.125.125 0 01.165-.32V7.5A2.25 2.25 0 0019.5 5.25z" /></svg>
                                <svg v-else-if="item.icon === 'user'" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                <svg v-else-if="item.icon === 'book'" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" /></svg>
                                <svg v-else-if="item.icon === 'trophy'" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75c-.621 0-1.125.504-1.125 1.125v3.375m9 0h-9m9-11.25a3 3 0 003-3V3.75H2.25V4.5a3 3 0 003 3h1.5m10.5 0V4.5M6 7.5V4.5m0 3h10.5" /></svg>
                                <svg v-else class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" /></svg>
                            </div>

                            <!-- Number Value -->
                            <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-none mb-2 count-up" :data-target="item.value">
                                {{ item.value }}
                            </span>

                            <!-- Label Title -->
                            <span class="text-xs sm:text-sm font-extrabold text-slate-600 tracking-wide uppercase">
                                {{ typeof item.label === 'object' ? (item.label[$page.props.locale] || item.label.en) : item.label }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="scroll-reveal transition-all duration-1000 ease-out w-full py-16 bg-[#115D6D]/10 border-t border-slate-200">
                <div class="mx-auto max-w-[1400px] px-4 md:px-6">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-[#115D6D]">{{ $t(graduateAttributes.title) }}</h2>
                        <div class="mx-auto mt-2 h-1 w-32 bg-amber-400 rounded-full"></div>
                    </div>

                    <div class="mt-12 flex flex-col md:flex-row gap-8 w-full items-stretch">
                        <!-- Text-only cards column -->
                        <div v-if="graduateAttributes.cards.some(c => !c.image)" class="flex-1 flex flex-col gap-8">
                            <div v-for="(card, index) in graduateAttributes.cards.filter(c => !c.image)" :key="'text-'+index" class="rounded-[32px] bg-white border border-slate-200/80 p-8 sm:p-10 flex flex-col hover:-translate-y-1 shadow-md hover:shadow-xl transition-all duration-300 flex-1">
                                <h3 class="text-xl font-bold text-[#115D6D] tracking-tight">{{ $t(card.title) }}</h3>
                                <p class="mt-4 text-sm md:text-base text-slate-700 leading-relaxed">
                                    {{ $t(card.description) }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Image cards column -->
                        <div v-if="graduateAttributes.cards.some(c => c.image)" class="flex-1 flex flex-col gap-8">
                            <div v-for="(card, index) in graduateAttributes.cards.filter(c => c.image)" :key="'img-'+index" class="rounded-[32px] bg-white border border-slate-200/80 p-8 sm:p-10 flex flex-col hover:-translate-y-1 shadow-md hover:shadow-xl transition-all duration-300 flex-1">
                                <div class="flex flex-col">
                                    <h3 class="text-xl font-bold text-[#115D6D] tracking-tight">{{ $t(card.title) }}</h3>
                                    <p class="mt-4 text-sm md:text-base text-slate-700 leading-relaxed">
                                        {{ $t(card.description) }}
                                    </p>
                                </div>
                                <div class="mt-8 overflow-hidden rounded-[24px] bg-gray-200 w-full flex-1 min-h-[250px] shadow-inner">
                                    <img :src="card.image" :alt="$t(card.title)" class="w-full h-full object-cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main> 

        <SiteFooter />
    </div>
</template>
<style>
/* Premium Hero Swiper Styles */
.hero-swiper .swiper-wrapper {
    transition-timing-function: cubic-bezier(0.15, 0.85, 0.35, 1) !important;
}
/* Centered Slide Animation */
.hero-swiper .swiper-slide {
    transition: opacity 0.8s cubic-bezier(0.15, 0.85, 0.35, 1);
    opacity: 0.3;
}
.hero-swiper .swiper-slide-active {
    opacity: 1;
}
.hero-swiper .swiper-slide-active img {
}

.hero-swiper .swiper-button-next, .hero-swiper .swiper-button-prev { 
    display: none;
    color: transparent; 
    background-color: rgba(255, 255, 255, 0.1); 
    backdrop-filter: blur(16px); 
    -webkit-backdrop-filter: blur(16px);
    width: 44px; 
    height: 44px; 
    border-radius: 50%; 
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2), inset 0 0 0 1px rgba(255, 255, 255, 0.1);
}
@media (min-width: 1024px) {
    .hero-swiper .swiper-button-next, .hero-swiper .swiper-button-prev { 
        display: flex;
        width: 54px; 
        height: 54px; 
    }
}
.hero-swiper .swiper-button-next:hover, .hero-swiper .swiper-button-prev:hover { 
    background-color: rgba(255, 255, 255, 0.25); 
    transform: scale(1.15); 
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 0 0 1px rgba(255, 255, 255, 0.2);
}
.hero-swiper .swiper-button-next::after, .hero-swiper .swiper-button-prev::after { 
    display: none; 
}
.hero-swiper .swiper-button-prev { 
    left: max(12px, calc(50% - 760px)); 
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M15 19l-7-7 7-7' /%3E%3C/svg%3E");
    background-position: center;
    background-repeat: no-repeat;
    background-size: 24px;
}
.hero-swiper .swiper-button-next { 
    right: max(12px, calc(50% - 760px)); 
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M9 5l7 7-7 7' /%3E%3C/svg%3E");
    background-position: center;
    background-repeat: no-repeat;
    background-size: 24px;
}

/* Dash Pagination Indicators */
.hero-swiper .swiper-pagination { 
    bottom: 0px !important; 
}

.hero-swiper .swiper-pagination-bullet { 
    background: white; 
    opacity: 0.5; 
    width: 32px; 
    height: 4px; 
    border-radius: 4px; 
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
    margin: 0 6px !important;
}
.hero-swiper .swiper-pagination-bullet-active { 
    background: #ffd700; /* Premium Yellow */
    opacity: 1; 
    width: 64px; 
    box-shadow: 0 0 12px rgba(255, 215, 0, 0.5);
}

.activities-swiper-container .swiper-pagination-bullet { background: #cbd5e1; opacity: 1; width: 10px; height: 10px; transition: all 0.3s; }
.activities-swiper-container .swiper-pagination-bullet-active { background: #f59e0b; width: 24px; border-radius: 5px; }
.activities-swiper-container .swiper-pagination { bottom: 0px !important; }
</style>