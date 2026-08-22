<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

const props = defineProps({
    event: {
        type: Object,
        required: true,
    },
});

const fallbackClasses = {
    campus: 'from-[#203f67] via-[#647c55] to-[#d8dfeb]',
    digital: 'from-[#171717] via-[#242424] to-[#0d0d0d]',
    announcement: 'from-[#233557] via-[#4d8b16] to-[#d8e7ff]',
};

const pageObj = usePage();
const paragraphs = computed(() => {
    const locale = pageObj.props.locale || 'en';
    const contentObj = props.event.content;
    let contentStr = '';
    
    if (contentObj && typeof contentObj === 'object') {
        contentStr = contentObj[locale] || contentObj['en'] || '';
    } else if (typeof contentObj === 'string') {
        try {
            const parsed = JSON.parse(contentObj);
            if (parsed && typeof parsed === 'object') {
                contentStr = parsed[locale] || parsed['en'] || '';
            } else {
                contentStr = contentObj;
            }
        } catch (e) {
            contentStr = contentObj;
        }
    }
    
    if (contentStr) {
        // If it's already HTML (from Quill), just return it
        if (/<[a-z][\s\S]*>/i.test(contentStr)) {
            return contentStr;
        }
        // Otherwise wrap plain text in paragraphs to match the v-html rendering
        return contentStr.split('\n').filter(p => p.trim()).map(p => `<p>${p}</p>`).join('');
    }
    
    return [
        "No details available."
    ];
});
</script>

<template>
    <Head :title="$t(event.title)" />

    <div class="min-h-screen bg-global-bg font-sans text-slate-900">
        <SiteHeader />

        <main class="mx-auto w-full max-w-[1400px] px-4 py-12 md:px-6">
            <div class="mb-9 flex items-center justify-between gap-4">
                <h1 class="text-[26px] font-bold leading-tight text-[#115D6D]">{{ $t('Event Detail') }}</h1>

                <Link href="/events" class="text-sm font-semibold text-[#115D6D] transition hover:text-[#00a6ff]">
                    {{ $t('Back to Events') }}
                </Link>
            </div>

            <section>
                <div class="relative overflow-hidden rounded-[18px] bg-slate-100 shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br" :class="fallbackClasses[event.type]">
                        <div v-if="event.type === 'campus'" class="absolute inset-0">
                            <div class="absolute -left-16 -top-20 h-64 w-64 rounded-full border-[34px] border-white/35"></div>
                            <div class="absolute bottom-0 right-0 h-40 w-[82%] rounded-tl-[72px] bg-white/20"></div>
                            <div class="absolute bottom-8 right-10 text-right text-5xl font-black tracking-normal text-white/85">DUC</div>
                        </div>
                        <div v-else-if="event.type === 'digital'" class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <div class="mb-7 h-20 w-32 bg-[#0e4aba] shadow-sm">
                                <div class="mt-7 h-7 bg-[#df1f2d]"></div>
                            </div>
                            <div class="text-5xl font-black leading-none tracking-normal text-[#ff9c00] sm:text-6xl">DIGITAL 2024</div>
                            <div class="mt-3 text-sm font-bold tracking-[0.18em] text-white">CAMBODIA</div>
                        </div>
                        <div v-else class="absolute inset-0">
                            <div class="absolute right-0 top-0 h-[62%] w-[78%] rounded-bl-[72px] bg-black/30"></div>
                            <div class="absolute bottom-0 left-0 h-16 w-full bg-[#48a809]"></div>
                            <div class="absolute bottom-20 left-8 right-8 text-4xl font-black leading-tight text-white">DUC Announcement</div>
                            <div class="absolute bottom-5 left-8 text-base font-bold text-white">Digital University of Cambodia</div>
                        </div>
                    </div>

                    <img
                        :src="event.detail_image || event.image"
                        :alt="event.title"
                        class="relative h-[260px] w-full object-cover sm:h-[360px] lg:h-[500px]"
                        @error="$event.currentTarget.classList.add('hidden')"
                    />
                </div>

                <article class="mt-8 max-w-[1040px] px-2 sm:px-3">
                    <h2 class="text-[18px] font-bold leading-tight text-black">{{ $t(event.title) }}</h2>

                    <div class="mt-2 text-[14px] leading-[1.12] text-black sm:text-[15px] sm:leading-snug ql-editor px-0" v-html="paragraphs">
                    </div>
                </article>
            </section>
        </main>

        <SiteFooter />
    </div>
</template>
