<script setup>
import { Link, Head } from "@inertiajs/vue3";
import SiteHeader from "@/Components/SiteHeader.vue";
import SiteFooter from "@/Components/SiteFooter.vue";

import { computed } from "vue";
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    facultyData: {
        type: Object,
        required: true,
    },
});

const parsedCustomSections = computed(() => {
    if (!props.facultyData || !props.facultyData.custom_sections) return [];
    try {
        return typeof props.facultyData.custom_sections === 'string' 
            ? JSON.parse(props.facultyData.custom_sections) 
            : props.facultyData.custom_sections;
    } catch (e) {
        return [];
    }
});
</script>

<template>
    <Head :title="$t(facultyData.name)" />
    
    <div class="min-h-screen flex flex-col bg-global-bg text-slate-900 font-sans">
        <SiteHeader />

        <main class="flex-grow mx-auto w-full max-w-[1400px] px-4 py-12 md:px-6">
            
            <div class="mb-8 border-b border-slate-300/60 pb-4">
                <h1 class="text-3xl md:text-4xl font-bold text-[#115D6D] mb-2">
                    {{ $t(facultyData.name) }}
                </h1>
    <p class="text-gray-600 font-medium text-lg">
    {{ $t('Departments:') }}
    <template
        v-for="(dept, index) in facultyData.departments"
        :key="index"
    >
        <Link
            :href="`/faculty/${facultyData.id}/department/${dept.slug}`"
            class="text-blue-700 hover:text-blue-900 hover:underline underline-offset-2 transition-colors font-semibold"
        >
            {{ $t(dept.name).replace('Department of ', '') }}
        </Link>
        <span
            v-if="index < facultyData.departments.length - 1"
            class="text-gray-400 mx-2"
        >|</span>
    </template>
</p>
            </div>

            <div
                class="mb-10 bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm flex items-center justify-center p-2"
            >
                <img
                    v-if="facultyData.orgChartImage"
                    :src="facultyData.orgChartImage"
                    alt="Organizational Chart"
                    class="w-full h-auto object-contain rounded-xl"
                />
                <div
                    v-else
                    class="h-64 md:h-96 w-full bg-gray-100 flex items-center justify-center text-gray-500 rounded-xl"
                >
                    <span>[ Organizational Chart Image ]</span>
                </div>
            </div>

            <div
                class="bg-white border border-gray-300 rounded-2xl shadow-sm p-6 md:p-10 mb-10"
                v-if="parsedCustomSections && parsedCustomSections.length > 0"
            >
                <template v-for="(section, idx) in parsedCustomSections" :key="'sec-'+idx">
                    <div :class="{'mt-8': idx > 0, 'mb-8': idx < parsedCustomSections.length - 1}">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            {{ $t(section.title) }}
                        </h2>
                        <div class="text-gray-700 leading-relaxed ql-editor px-0" v-html="$t(section.content)"></div>
                    </div>
                </template>
            </div>

        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
/* Scoped styles are left blank as Tailwind CSS covers all styling requirements */
</style>
