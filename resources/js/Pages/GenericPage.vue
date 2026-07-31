<script setup>
import { Head } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

const props = defineProps({
    pageData: {
        type: Object,
        default: () => ({ custom_sections: [] })
    },
    pageTitle: {
        type: String,
        default: 'Page'
    }
});
</script>

<template>
    <Head :title="$t(pageTitle)" />

    <div class="min-h-screen bg-slate-50 font-sans flex flex-col">
        <SiteHeader />

        <main class="flex-grow pt-12 pb-20">
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6">
                <!-- Page Header -->
                <div class="mb-12 border-b pb-6">
                    <h1 :class="['font-extrabold text-slate-900 tracking-tight', pageData.title_font_size || 'text-4xl']">{{ $t(pageTitle) }}</h1>
                    <div class="w-20 h-1.5 bg-blue-600 mt-6"></div>
                </div>

                <!-- Custom Sections Content -->
                <div v-if="pageData.custom_sections && pageData.custom_sections.length > 0" class="space-y-12">
                    <section v-for="(section, idx) in pageData.custom_sections" :key="idx" class="prose prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-blue-600 hover:prose-a:text-blue-800 prose-img:rounded-xl prose-img:shadow-md">
                        <h2 v-if="section.title" :class="['font-bold mb-4 text-slate-900', section.title_font_size || 'text-2xl']">{{ $t(section.title) }}</h2>
                        <div v-html="$t(section.content)"></div>
                    </section>
                </div>

                <div v-else class="text-center py-20 text-slate-500">
                    <p>{{ $t('This page is currently under construction. Please check back later.') }}</p>
                </div>
            </div>
        </main>

        <SiteFooter />
    </div>
</template>
