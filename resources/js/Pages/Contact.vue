<script setup>
import { Head, usePage, useForm } from "@inertiajs/vue3";
import SiteFooter from "@/Components/SiteFooter.vue";
import SiteHeader from "@/Components/SiteHeader.vue";
import { computed, onMounted, onUnmounted, ref } from "vue";

const page = usePage();
const settings = computed(() => page.props.settings || {});

const facebookLink = computed(() => {
    return settings.value.social_links?.find(link => link.label === 'Facebook')?.href || '#';
});

const tl = (obj) => {
    if (!obj) return '';
    if (typeof obj === 'string') return obj;
    return obj[page.props.locale] || obj.en || '';
};

// ================= FORM STATE =================
const form = useForm({
    name: "",
    email: "",
    subject: "",
    message: "",
});

const successMessage = ref("");

const handleSubmit = () => {
    form.post(route('contact.submit'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            successMessage.value = page.props.flash?.success || "Thank you! Your message has been sent successfully.";
            setTimeout(() => successMessage.value = "", 5000);
        },
    });
};

// ================= SCROLL ANIMATIONS =================
let observer = null;

const setupScrollAnimations = () => {
    const options = {
        root: null,
        rootMargin: "0px",
        threshold: 0.1
    };

    observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                // Reveal the element when it comes into view
                entry.target.classList.remove("opacity-0", "translate-y-8", "scale-95");
                entry.target.classList.add("opacity-100", "translate-y-0", "scale-100");
                observer.unobserve(entry.target);
            }
        });
    }, options);

    // Grab all elements that need revealing
    const targets = document.querySelectorAll(".scroll-reveal");
    targets.forEach((target) => observer.observe(target));
};

onMounted(() => {
    setupScrollAnimations();
});

onUnmounted(() => {
    if (observer) observer.disconnect();
});
</script>

<template>
    <Head :title="$t('Contact Us')" />

    <SiteHeader />
    <div class="min-h-screen bg-global-bg text-slate-900 overflow-x-hidden">

        <main class="bg-gray-50/50">
            <section class="relative w-full bg-[#115D6D] text-white py-16 sm:py-24 px-4 overflow-hidden shadow-sm">
                <div class="absolute inset-0 opacity-15 bg-[linear-gradient(to_right,#4f4f4f_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f_1px,transparent_1px)] bg-[size:40px_40px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
                
                <div class="relative max-w-[1400px] md:px-6 mx-auto text-center animate-fade-in-down">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight transition-all duration-700">
                        {{ settings.contact_hero_title ? tl(settings.contact_hero_title) : $t('Contact Us') }}
                    </h1>
                    <div class="mx-auto mt-4 h-1.5 w-24 bg-amber-400 rounded-full shadow-sm"></div>
                    <p class="mt-6 text-base sm:text-lg md:text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed font-light">
                        {{ settings.contact_hero_description ? tl(settings.contact_hero_description) : $t('Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.') }}
                    </p>
                </div>
            </section>

            <section class="mx-auto max-w-[1400px] px-4 md:px-6 py-12 -mt-10 sm:-mt-16 relative z-10">
                <div class="grid lg:grid-cols-12 gap-8 items-stretch">
                    
                    <div class="lg:col-span-5 flex flex-col gap-6">
                        
                        <a :href="settings.contact_map_link || '#'" target="_blank" rel="noopener noreferrer" class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 ease-out bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 group cursor-pointer block">
                            <div class="flex items-start gap-4 w-full">
                                <div class="p-3 bg-blue-50 text-[#2f47aa] rounded-xl shrink-0 group-hover:bg-[#2f47aa] group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base sm:text-lg">{{ $t('Address') }}</h3>
                                    <div class="mt-1 text-sm sm:text-base text-[#00a0e9] font-semibold group-hover:underline block">
                                        {{ $t(typeof settings.address === 'object' ? (settings.address[$page.props.locale] || settings.address.en) : settings.address) }}
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- GMAIL COMPOSE LINK -->
                        <a :href="`https://mail.google.com/mail/?view=cm&fs=1&to=${settings.email}`" target="_blank" rel="noopener noreferrer" class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 delay-100 ease-out bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 group cursor-pointer block">
                            <div class="flex items-start gap-4 w-full">
                                <div class="p-3 bg-blue-50 text-[#2f47aa] rounded-xl shrink-0 group-hover:bg-[#2f47aa] group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base sm:text-lg">{{ $t('Email Address') }}</h3>
                                    <div class="mt-1 text-sm sm:text-base text-[#00a0e9] font-semibold group-hover:underline block break-all">
                                        {{ $t(settings.email) }}
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a :href="facebookLink" target="_blank" class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 delay-200 ease-out bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 group cursor-pointer block">
                            <div class="flex items-start gap-4 w-full">
                                <div class="p-3 bg-blue-50 text-[#2f47aa] rounded-xl shrink-0 group-hover:bg-[#2f47aa] group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base sm:text-lg">{{ $t('Facebook Page') }}</h3>
                                    <div class="mt-1 text-sm sm:text-base text-[#00a0e9] font-semibold group-hover:underline block">
                                        {{ $t('Digital University of Cambodia') }}
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 delay-300 ease-out bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 group flex-1">
                            <div class="p-3 bg-blue-50 text-[#2f47aa] rounded-xl shrink-0 group-hover:bg-[#2f47aa] group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.436-4.136-7.032-7.032l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                            </div>
                            <div class="w-full">
                                <h3 class="font-bold text-slate-800 text-base sm:text-lg">{{ $t('Phone Support') }}</h3>
                                <div class="mt-3 space-y-2.5 text-sm sm:text-base font-semibold text-slate-700">
                                    <template v-if="settings.direct_lines && settings.direct_lines.length > 0">
                                        <template v-for="(phone, idx) in settings.direct_lines" :key="idx">
                                            <a v-if="phone.startsWith('http')" :href="phone" target="_blank" rel="noopener noreferrer" class="block hover:text-[#2f47aa] hover:translate-x-1 transition-all duration-200 break-all">{{ phone }}</a>
                                            <a v-else :href="`tel:${phone.replace(/[^0-9+]/g, '')}`" class="block hover:text-[#2f47aa] hover:translate-x-1 transition-all duration-200 break-all">{{ phone }}</a>
                                        </template>
                                    </template>
                                    <template v-else-if="settings.phone">
                                        <a :href="`tel:${settings.phone.replace(/[^0-9+]/g, '')}`" class="block hover:text-[#2f47aa] hover:translate-x-1 transition-all duration-200">{{ settings.phone }}</a>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-7 flex flex-col gap-6">
                        
                        <div class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 delay-200 ease-out overflow-hidden rounded-2xl border-4 border-white shadow-lg bg-white p-2 group">
                            <div class="overflow-hidden rounded-xl">
                                <img 
                                    :src="settings.contact_image || 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80'" 
                                    alt="Digital University of Cambodia Campus Life" 
                                    class="w-full h-auto max-h-[600px] object-cover rounded-xl group-hover:scale-105 transition-all duration-700 ease-in-out"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
/* Top header slide-down animation */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out forwards;
}
</style>
