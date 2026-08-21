<script setup>
import { onMounted, ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

const getLocLabel = (obj, defaultStr) => {
    if (!obj) return defaultStr;
    if (typeof obj === 'string') {
        try {
            const parsed = JSON.parse(obj);
            if (parsed && typeof parsed === 'object') {
                return parsed[page.props.locale] || parsed.en || defaultStr;
            }
        } catch (e) {}
    }
    if (typeof obj === 'object') return obj[page.props.locale] || obj.en || defaultStr;
    return obj;
};

const footerMapUrl = computed(() => page.props.settings?.footer_map_url || 'https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1518.5686343584584!2d104.76673604474675!3d11.416249673060195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2skh!4v1783649287380!5m2!1sen!2skh');
const footerMapLabel = computed(() => getLocLabel(page.props.settings?.footer_map_label, 'Phnom Penh Campus'));
const footerQuickLinks = computed(() => page.props.settings?.footer_quick_links || []);
const footerWorkingHoursWeekdayLabel = computed(() => getLocLabel(page.props.settings?.footer_working_hours_weekday_label, 'Mon - Sat'));
const footerWorkingHoursWeekdayTime = computed(() => getLocLabel(page.props.settings?.footer_working_hours_weekday_time, '8:00 AM - 5:00 PM'));
const footerWorkingHoursWeekendLabel = computed(() => getLocLabel(page.props.settings?.footer_working_hours_weekend_label, 'Weekend'));
const footerWorkingHoursWeekendTime = computed(() => getLocLabel(page.props.settings?.footer_working_hours_weekend_time, '8:00 AM - 4:00 PM'));
const footerLabelQuickLinks = computed(() => getLocLabel(page.props.settings?.footer_label_quick_links, 'Our Details'));
const footerLabelWorkingHours = computed(() => getLocLabel(page.props.settings?.footer_label_working_hours, 'Working Hours'));
const footerLabelSocialMedia = computed(() => getLocLabel(page.props.settings?.footer_label_social_media, 'Social Media'));
const footerLabelContactInfo = computed(() => getLocLabel(page.props.settings?.footer_label_contact_info, 'Contact Information'));
const footerLabelDirectLines = computed(() => getLocLabel(page.props.settings?.footer_label_direct_lines, 'Direct Lines'));


const footerBgColor = computed(() => '#115D6D');
const footerBorderColor = computed(() => '#00a0e9');
const footerTextColor = computed(() => '#ffffff');

const subFooterBgColor = computed(() => '#0d4a57');
const subFooterTextColor = computed(() => '#cbd5e1');
const subFooterBorderColor = computed(() => '#0f4e5c');

const privacyPolicyLabel = computed(() => page.props.settings?.privacy_policy_label ?? 'Privacy Policy');
const privacyPolicyUrl = computed(() => page.props.settings?.privacy_policy_url ?? '#');
const footerCredits = computed(() => page.props.settings?.footer_credits ?? 'Made with ♥ by IT Department Students');

const socialLinks = computed(() => {
    const links = page.props.settings?.social_links || [];
    return links.map(link => {
        let customStyle = {};
        let classes = [];
        if (link.class) {
            const parts = link.class.split(' ');
            
            const getColor = (val) => {
                if (val.startsWith('[') && val.endsWith(']')) return val.slice(1, -1);
                if (val === 'black') return '#000000';
                if (val === 'white') return '#ffffff';
                if (val === 'transparent') return 'transparent';
                return val;
            };

            parts.forEach(part => {
                if (part.startsWith('hover:bg-')) {
                    if (!link.disable_bg_hover) {
                        customStyle['--custom-hover-bg'] = getColor(part.replace('hover:bg-', ''));
                        classes.push('has-custom-hover-bg');
                    }
                } else if (part.startsWith('bg-') && part.includes('[')) {
                    customStyle['--custom-bg'] = getColor(part.replace('bg-', ''));
                    classes.push('has-custom-bg');
                } else if (part.startsWith('hover:text-')) {
                    if (!link.disable_icon_hover) {
                        customStyle['--custom-hover-text'] = getColor(part.replace('hover:text-', ''));
                        classes.push('has-custom-hover-text');
                    }
                } else if (part.startsWith('text-') && part.includes('[')) {
                    customStyle['--custom-text'] = getColor(part.replace('text-', ''));
                    classes.push('has-custom-text');
                } else {
                    classes.push(part);
                }
            });
        }
        
        if (link.bg_color && link.bg_color !== '') {
            customStyle['--custom-bg'] = link.bg_color;
            if (!classes.includes('has-custom-bg')) classes.push('has-custom-bg');
        }
        if (!link.disable_bg_hover && link.hover_color && link.hover_color !== '') {
            customStyle['--custom-hover-bg'] = link.hover_color;
            if (!classes.includes('has-custom-hover-bg')) classes.push('has-custom-hover-bg');
        }
        if (link.icon_color && link.icon_color !== '') {
            customStyle['--custom-text'] = link.icon_color;
            if (!classes.includes('has-custom-text')) classes.push('has-custom-text');
        }
        if (!link.disable_icon_hover && link.icon_hover_color && link.icon_hover_color !== '') {
            customStyle['--custom-hover-text'] = link.icon_hover_color;
            if (!classes.includes('has-custom-hover-text')) classes.push('has-custom-hover-text');
        }

        return { ...link, customStyle, processedClass: classes.join(' ') };
    });
});

const address = computed(() => getLocLabel(page.props.settings?.address, 'Kompong Spue, Cambodia'));
const phone = computed(() => page.props.settings?.phone || '012 4444 12');
const email = computed(() => page.props.settings?.email || 'duc2024@gmail.com');
const copyright = computed(() => getLocLabel(page.props.settings?.copyright, 'Copyright © 2024 Digital University of Cambodia. All rights reserved.'));
const directLines = computed(() => page.props.settings?.direct_lines || []);

// Simple intersection observer to trigger animations when scrolling down
const footerRef = ref(null);
const isVisible = ref(false);

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            isVisible.value = true;
            observer.disconnect(); // Only animate once
        }
    }, { threshold: 0.1 });

    if (footerRef.value) {
        observer.observe(footerRef.value);
    }
});
</script>

<template>
    <footer id="contact" ref="footerRef" class="font-sans overflow-hidden">
        
        <div class="relative text-white overflow-hidden border-t-4 transition-colors duration-500" :style="{ backgroundColor: footerBgColor, borderColor: footerBorderColor }">
            <div class="absolute top-0 right-0 -mr-20 -mt-25 w-90 h-90 bg-blue-600/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="mx-auto grid max-w-[1400px] gap-8 px-4 py-10 md:px-6 md:py-12 lg:grid-cols-[1.2fr_1fr_1fr] relative z-10">
                
                <!-- Map Card: Zoomed out and slightly smaller height -->
                <div 
                    class="relative overflow-hidden rounded-3xl bg-white/5 shadow-2xl ring-1 ring-white/10 transition-all duration-1000 transform flex flex-col min-h-[200px] h-full"
                    :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'"
                >
                    <div class="absolute top-4 left-4 z-20 bg-white/90 backdrop-blur-sm text-[#115D6D] px-3 py-1.5 rounded-full shadow-md text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        {{ $t(footerMapLabel) }}
                    </div>

                    <!-- Map iframe with dynamic URL -->
                    <iframe :src="footerMapUrl" class="w-full flex-1 border-0" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                
                </div>

                <section 
                    class="text-[14px] leading-relaxed text-white/80 transition-all duration-1000 delay-200 transform"
                    :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'"
                >
                    <template v-if="footerQuickLinks && footerQuickLinks.length > 0">
                        <h2 class="mb-3 text-base font-bold text-white tracking-wide flex items-center gap-2">
                            <span class="w-6 h-[2px] bg-[#f5d98f]"></span> {{ $t(footerLabelQuickLinks) }}
                        </h2>
                        
                        <ul class="space-y-2 mb-6">
                            <li v-for="item in footerQuickLinks" :key="item.label" class="group flex items-center gap-3">
                                <span class="text-[#f5d98f] transition-transform group-hover:translate-x-1">▸</span>
                                <a :href="item.href" class="transition-colors hover:text-white hover:underline underline-offset-4 decoration-white/30">{{ $t(getLocLabel(item.label, 'Link')) }}</a>
                            </li>
                        </ul>
                    </template>

                    <h2 class="mb-3 text-base font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="w-6 h-[2px] bg-[#f5d98f]"></span> {{ $t(footerLabelWorkingHours) }}
                    </h2>
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10 mb-6">
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-white font-medium">{{ $t(footerWorkingHoursWeekdayLabel) }}</span>
                            <span class="text-[#f5d98f] font-mono text-xs">{{ $t(footerWorkingHoursWeekdayTime) }}</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-white/10 pt-1.5">
                            <span class="text-white font-medium">{{ $t(footerWorkingHoursWeekendLabel) }}</span>
                            <span class="text-[#f5d98f] font-mono text-xs">{{ $t(footerWorkingHoursWeekendTime) }}</span>
                        </div>
                    </div>

                    <h2 class="mb-3 text-base font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="w-6 h-[2px] bg-[#f5d98f]"></span> {{ $t(footerLabelSocialMedia) }}
                    </h2>
                    
                    <div class="flex gap-4">
                        <a
                            v-for="item in socialLinks"
                            :key="item.label"
                            :href="item.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            :aria-label="item.label"
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e3e5e8] text-gray-700 transition-all duration-300 shadow-md hover:scale-110 hover:-translate-y-1"
                            :class="item.processedClass ? item.processedClass.replace('bg-white/10', '') : ''"
                            :style="item.customStyle"
                        >
                            <span v-html="item.svg"></span>
                        </a>
                    </div>
                </section>

                <section 
                    class="text-[14px] leading-relaxed text-white/80 transition-all duration-1000 delay-400 transform flex flex-col"
                    :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'"
                >
                    <h2 class="mb-4 text-base font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="w-6 h-[2px] bg-[#f5d98f]"></span> {{ $t(footerLabelContactInfo) }}
                    </h2>
                    
                    <ul class="space-y-4 mb-6">
                        <li class="flex items-start gap-3 group">
                            <div class="p-1.5 bg-white/10 rounded-lg text-[#f5d98f] transition-colors group-hover:bg-[#f5d98f] group-hover:text-[#115D6D]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wider mb-0.5">{{ $t('Address') }}</span>
                                <span class="text-white text-sm">{{ $t(address) }}</span>
                            </div>
                        </li>
                        
                        <li class="flex items-start gap-3 group">
                            <div class="p-1.5 bg-white/10 rounded-lg text-[#f5d98f] transition-colors group-hover:bg-[#f5d98f] group-hover:text-[#115D6D]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wider mb-0.5">{{ $t('Phone Number') }}</span>
                                <a :href="'tel:' + phone.replace(/\s+/g, '')" class="text-white text-sm hover:text-[#f5d98f] transition-colors">{{ $t(phone) }}</a>
                            </div>
                        </li>

                        <li class="flex items-start gap-3 group">
                            <div class="p-1.5 bg-white/10 rounded-lg text-[#f5d98f] transition-colors group-hover:bg-[#f5d98f] group-hover:text-[#115D6D]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wider mb-0.5">{{ $t('Email') }}</span>
                                <a :href="'mailto:' + email" class="text-white text-sm hover:text-[#f5d98f] transition-colors">{{ $t(email) }}</a>
                            </div>
                        </li>
                    </ul>

                    <div class="bg-[#0d4a57] rounded-2xl p-4 border border-white/10 relative overflow-hidden group mt-auto shadow-inner">
                        <div class="absolute -right-6 -top-6 w-20 h-20 bg-white/5 rounded-full transition-transform duration-500 group-hover:scale-150"></div>
                        
                        <h2 class="mb-2 text-xs font-bold text-gray-300 uppercase tracking-widest relative z-10">{{ $t(footerLabelDirectLines) }}</h2>
                        <div class="space-y-1.5 relative z-10 font-mono text-white text-[13px]">
                            <p v-for="line in directLines" :key="line" class="flex items-center gap-2 hover:text-[#f5d98f] cursor-default transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                                {{ line }}
                            </p>
                        </div>
                    </div>
                </section>
                
            </div>
        </div>

        <div class="border-t transition-colors duration-500" :style="{ backgroundColor: subFooterBgColor, borderColor: subFooterBorderColor, color: subFooterTextColor }">
            <div class="mx-auto max-w-[1400px] px-4 py-3 md:px-6 flex flex-col md:flex-row items-center justify-between gap-3 text-xs font-medium" :style="{ color: subFooterTextColor }">
                <p>{{ $t(copyright) }}</p>
                <div v-if="privacyPolicyLabel || footerCredits" class="flex items-center gap-3">
                    <a v-if="privacyPolicyLabel" :href="privacyPolicyUrl || '#'" class="hover:underline transition-colors" :style="{ color: subFooterTextColor }">{{ $t(privacyPolicyLabel) }}</a>
                    <span v-if="privacyPolicyLabel && footerCredits" class="w-1 h-1 rounded-full opacity-40 bg-current"></span>
                    <span v-if="footerCredits">{{ $t(footerCredits) }}</span>
                </div>
            </div>
        </div>
    </footer>
</template>
<style scoped>
.has-custom-bg {
    background-color: var(--custom-bg) !important;
}
.has-custom-hover-bg:hover {
    background-color: var(--custom-hover-bg) !important;
}
.has-custom-text {
    color: var(--custom-text) !important;
}
.has-custom-hover-text:hover {
    color: var(--custom-hover-text) !important;
}
</style>