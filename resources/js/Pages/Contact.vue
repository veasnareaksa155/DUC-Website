<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import SiteFooter from "@/Components/SiteFooter.vue";
import SiteHeader from "@/Components/SiteHeader.vue";
import { ref, computed, onMounted, onUnmounted } from "vue";

const page = usePage();
const settings = computed(() => page.props.settings || {});

const facebookLink = computed(() => {
    return settings.value.social_links?.find(link => link.label === 'Facebook')?.href || '#';
});

// ================= FORM STATE =================
const form = ref({
    name: "",
    email: "",
    subject: "",
    message: "",
});

const isSubmitting = ref(false);
const successMessage = ref("");

const handleSubmit = () => {
    isSubmitting.value = true;
    setTimeout(() => {
        isSubmitting.value = false;
        successMessage.value = "Thank you! Your message has been sent successfully.";
        form.value = { name: "", email: "", subject: "", message: "" };
        setTimeout(() => successMessage.value = "", 5000);
    }, 1500);
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
    <div class="min-h-screen bg-white text-slate-900 overflow-x-hidden">

        <main class="bg-gray-50/50">
            <section class="bg-[#0f2154] text-white py-20 sm:py-28 px-4 relative overflow-hidden">
                <div class="absolute inset-0 opacity-15 bg-[linear-gradient(to_right,#4f4f4f_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f_1px,transparent_1px)] bg-[size:40px_40px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
                
                <div class="relative max-w-[1400px] md:px-6 mx-auto text-center animate-fade-in-down">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight transition-all duration-700">
                        {{ $t('Contact Us') }}
                    </h1>
                    <div class="mx-auto mt-4 h-1.5 w-24 bg-amber-400 rounded-full shadow-sm"></div>
                    <p class="mt-6 text-base sm:text-lg md:text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed font-light">
                        {{ $t('Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.') }}
                    </p>
                </div>
            </section>

            <section class="mx-auto max-w-[1400px] px-4 md:px-6 py-12 -mt-10 sm:-mt-16 relative z-10">
                <div class="grid lg:grid-cols-12 gap-8 items-stretch">
                    
                    <div class="lg:col-span-5 flex flex-col gap-6">
                        
                        <div class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 ease-out bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 group">
                            <div class="p-3 bg-blue-50 text-[#2f47aa] rounded-xl shrink-0 group-hover:bg-[#2f47aa] group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-base sm:text-lg">{{ $t('Address') }}</h3>
                                <p class="mt-1 text-sm sm:text-base text-slate-600 font-medium">{{ $t(settings.address) }}</p>
                            </div>
                        </div>

                        <div class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 delay-100 ease-out bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 group">
                            <div class="p-3 bg-blue-50 text-[#2f47aa] rounded-xl shrink-0 group-hover:bg-[#2f47aa] group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-base sm:text-lg">{{ $t('Email Address') }}</h3>
                                <a :href="`mailto:${settings.email}`" class="mt-1 text-sm sm:text-base text-[#00a0e9] font-semibold hover:underline block break-all">
                                    {{ $t(settings.email) }}
                                </a>
                            </div>
                        </div>

                        <div class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 delay-200 ease-out bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 hover:shadow-xl hover:-translate-y-1 hover:border-blue-200 group">
                            <div class="p-3 bg-blue-50 text-[#2f47aa] rounded-xl shrink-0 group-hover:bg-[#2f47aa] group-hover:text-white transition-all duration-300 transform group-hover:scale-110">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-base sm:text-lg">{{ $t('Facebook Page') }}</h3>
                                <a :href="facebookLink" target="_blank" class="mt-1 text-sm sm:text-base text-[#00a0e9] font-semibold hover:underline block">
                                    {{ $t('Digital University of Cambodia') }}
                                </a>
                            </div>
                        </div>

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
                                        <a v-for="(phone, idx) in settings.direct_lines" :key="idx" :href="`tel:${phone.replace(/[^0-9+]/g, '')}`" class="block hover:text-[#2f47aa] hover:translate-x-1 transition-all duration-200">{{ phone }}</a>
                                    </template>
                                    <template v-else-if="settings.phone">
                                        <a :href="`tel:${settings.phone.replace(/[^0-9+]/g, '')}`" class="block hover:text-[#2f47aa] hover:translate-x-1 transition-all duration-200">{{ settings.phone }}</a>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-7 flex flex-col gap-6">
                        
                        <div class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 ease-out bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300">
                            <h2 class="text-xl sm:text-2xl font-bold text-[#0f2154] mb-2">{{ $t('Send Us a Message') }}</h2>
                            <p class="text-xs sm:text-sm text-slate-500 mb-6">{{ $t('Required fields are marked with an asterisk (*)') }}</p>
                            
                            <form @submit.prevent="handleSubmit" class="space-y-4">
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">{{ $t('Full Name *') }}</label>
                                        <input type="text" v-model="form.name" required class="w-full text-sm rounded-xl border-gray-200 focus:border-[#2f47aa] focus:ring-2 focus:ring-[#2f47aa]/20 bg-gray-50/50 p-2.5 sm:p-3 transition-all duration-200" :placeholder="$t('John Doe')" />
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">{{ $t('Email Address *') }}</label>
                                        <input type="email" v-model="form.email" required class="w-full text-sm rounded-xl border-gray-200 focus:border-[#2f47aa] focus:ring-2 focus:ring-[#2f47aa]/20 bg-gray-50/50 p-2.5 sm:p-3 transition-all duration-200" :placeholder="$t('yourname@domain.com')" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">{{ $t('Subject *') }}</label>
                                    <input type="text" v-model="form.subject" required class="w-full text-sm rounded-xl border-gray-200 focus:border-[#2f47aa] focus:ring-2 focus:ring-[#2f47aa]/20 bg-gray-50/50 p-2.5 sm:p-3 transition-all duration-200" :placeholder="$t('How can we help you?')" />
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">{{ $t('Message *') }}</label>
                                    <textarea v-model="form.message" rows="4" required class="w-full text-sm rounded-xl border-gray-200 focus:border-[#2f47aa] focus:ring-2 focus:ring-[#2f47aa]/20 bg-gray-50/50 p-2.5 sm:p-3 transition-all duration-200 resize-none" :placeholder="$t('Type your message here...')"></textarea>
                                </div>

                                <div v-if="successMessage" class="p-3 bg-emerald-50 text-emerald-700 rounded-xl text-xs sm:text-sm font-medium animate-pulse">
                                    {{ $t(successMessage) }}
                                </div>

                                <button type="submit" :disabled="isSubmitting" class="w-full sm:w-auto px-6 py-2.5 sm:py-3 rounded-xl bg-[#2f47aa] text-white font-semibold text-sm shadow-sm hover:bg-[#1f3284] active:scale-95 transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2">
                                    <span v-if="isSubmitting" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                    {{ isSubmitting ? $t('Sending...') : $t('Send Message') }}
                                </button>
                            </form>
                        </div>

                        <div class="scroll-reveal opacity-0 translate-y-8 scale-95 transition-all duration-700 delay-200 ease-out overflow-hidden rounded-2xl border-4 border-white shadow-lg bg-white p-2 group">
                            <div class="overflow-hidden rounded-xl">
                                <img 
                                    :src="settings.contact_image || 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80'" 
                                    alt="Digital University of Cambodia Campus Life" 
                                    class="w-full h-auto max-h-[400px] object-cover rounded-xl group-hover:scale-105 transition-all duration-700 ease-in-out"
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