<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import SiteHeader from "@/Components/SiteHeader.vue";
import SiteFooter from "@/Components/SiteFooter.vue";

const props = defineProps({
    events: {
        type: Array,
        default: () => [],
    },
});

const searchQuery = ref(""); const dateFilter = ref("");
const currentPage = ref(1);
const itemsPerPage = 6;

watch([searchQuery, dateFilter], () => {
    currentPage.value = 1;
});

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

const totalPages = computed(() => {
    return Math.ceil(filteredEvents.value.length / itemsPerPage);
});

const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;
    const delta = 1;
    
    if (total <= 5) {
        return Array.from({ length: total }, (_, i) => i + 1);
    }
    
    const pages = [];
    const left = Math.max(2, current - delta);
    const right = Math.min(total - 1, current + delta);
    
    pages.push(1);
    
    if (left > 2) {
        pages.push('...');
    }
    
    for (let i = left; i <= right; i++) {
        pages.push(i);
    }
    
    if (right < total - 1) {
        pages.push('...');
    }
    
    pages.push(total);
    
    return pages;
});

const paginatedEvents = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    return filteredEvents.value.slice(start, start + itemsPerPage);
});

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        scrollToTop();
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        scrollToTop();
    }
};

const goToPage = (page) => {
    currentPage.value = page;
    scrollToTop();
};

const monthNames = [
    'january','february','march','april','may','june',
    'july','august','september','october','november','december'
];

const filteredEvents = computed(() => {
    const q = searchQuery.value.toLowerCase().trim();
    const dateVal = dateFilter.value; // e.g. "2024-06-03"
    if (!q && !dateVal) return props.events;

    // Parse the ISO date into parts for matching against formatted strings like "3 /June /2024"
    let parsedDay = '', parsedMonth = '', parsedYear = '';
    if (dateVal) {
        const parts = dateVal.split('-'); // ["2024", "06", "03"]
        if (parts.length === 3) {
            parsedYear = parts[0];
            parsedMonth = monthNames[parseInt(parts[1], 10) - 1] || ''; // "june"
            parsedDay = String(parseInt(parts[2], 10)); // "3" (no leading zero)
        }
    }

    const numericQuery = q.replace(/\D/g, '');

    return props.events.filter(event => {
        const titleEn = (event.title?.en || (typeof event.title === 'string' ? event.title : '')).toLowerCase();
        const titleKm = (event.title?.km || '').toLowerCase();
        const descEn = (event.description?.en || (typeof event.description === 'string' ? event.description : '')).toLowerCase();
        const descKm = (event.description?.km || '').toLowerCase();
        const dateEn = (event.date?.en || (typeof event.date === 'string' ? event.date : '')).toLowerCase();
        const dateKm = (event.date?.km || '').toLowerCase();

        // Text search: match title, description, or date string
        const matchesSearch = q && (
            titleEn.includes(q) || titleKm.includes(q) ||
            descEn.includes(q) || descKm.includes(q) ||
            dateEn.includes(q) || dateKm.includes(q) ||
            (numericQuery && (
                dateEn.replace(/\D/g, '').includes(numericQuery) ||
                dateKm.replace(/\D/g, '').includes(numericQuery)
            ))
        );

        // Date picker filter: check that day, month name, and year all appear in event date string
        const matchesDate = dateVal && (
            (parsedYear && parsedMonth && parsedDay && (
                (dateEn.includes(parsedDay) && dateEn.includes(parsedMonth) && dateEn.includes(parsedYear)) ||
                (dateKm.includes(parsedDay) && dateKm.includes(parsedMonth) && dateKm.includes(parsedYear))
            )) ||
            dateEn.includes(dateVal) ||
            dateKm.includes(dateVal)
        );

        // If both filters active → must match both; if only one active → match that one
        if (q && dateVal) return matchesSearch && matchesDate;
        if (q) return matchesSearch;
        return matchesDate;
    });
});

const fallbackClasses = {
    campus: "from-[#203f67] via-[#647c55] to-[#d8dfeb]",
    digital: "from-[#171717] via-[#242424] to-[#0d0d0d]",
    announcement: "from-[#233557] via-[#4d8b16] to-[#d8e7ff]",
};

const stripHtml = (html) => {
    if (!html) return '';
    return html.replace(/<\/?[^>]+(>|$)/g, "");
};
</script>

<template>
    <Head :title="$t('News/Events')" />

    <div class="min-h-screen bg-[#c9e0e4] font-sans text-slate-900">
        <SiteHeader />
        <div class="relative overflow-x-hidden pb-16">

            <!-- UPDATED WRAPPER: Changed max-width to 1400px and matched padding to header (px-4 md:px-6) -->
            <main
                class="relative z-10 mx-auto w-full max-w-[1400px] px-4 pt-7 md:px-6"
            >
                <div
                    class="mb-14 border-b mt-7 pb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <h1 class="text-3xl md:text-4xl font-bold text-[#115D6D]">
                        {{ $t('News/Events') }}
                    </h1>

                    <div
                        class="group relative flex h-11 w-full max-w-sm items-center rounded-xl bg-white px-4 border border-slate-200 shadow-sm transition-all duration-200 focus-within:border-[#38a7ee] focus-within:shadow-[0_0_0_3px_rgba(56,167,238,0.15)]"
                    >
                        <span class="sr-only">{{ $t('Search news and events') }}</span>
                        <!-- Search Icon -->
                        <svg
                            class="mr-2.5 h-[18px] w-[18px] shrink-0 text-slate-400 transition-colors duration-200 group-focus-within:text-[#38a7ee]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>

                        <!-- Text Input -->
                        <input
                            v-model="searchQuery"
                            type="search"
                            :placeholder="$t('Search events...')"
                            class="h-full min-w-0 flex-1 border-0 bg-transparent p-0 text-sm font-medium text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-0"
                        />

                        <!-- Selected Date Badge -->
                        <div v-if="dateFilter" class="hidden sm:flex items-center ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-[#eaf6fc] text-[#38a7ee] whitespace-nowrap pointer-events-none">
                            {{ dateFilter }}
                        </div>

                        <!-- Date Picker Icon inside input -->
                        <div class="relative flex items-center justify-center ml-2 h-full w-6 shrink-0">
                            <svg 
                                class="h-[18px] w-[18px] transition-colors duration-150 cursor-pointer" 
                                :class="dateFilter ? 'text-[#38a7ee]' : 'text-slate-400 hover:text-[#38a7ee]'"
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor" 
                                stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <!-- Hidden date input overlaying the icon -->
                            <input
                                v-model="dateFilter"
                                type="date"
                                :title="$t('Filter by date')"
                                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full [&::-webkit-calendar-picker-indicator]:absolute [&::-webkit-calendar-picker-indicator]:inset-0 [&::-webkit-calendar-picker-indicator]:w-full [&::-webkit-calendar-picker-indicator]:h-full [&::-webkit-calendar-picker-indicator]:opacity-0 [&::-webkit-calendar-picker-indicator]:cursor-pointer z-10"
                            />
                            <!-- Indicator dot if date is selected (for mobile where badge might be hidden) -->
                            <span v-if="dateFilter" class="sm:hidden absolute top-[11px] right-0 h-1.5 w-1.5 rounded-full bg-red-500 z-20 pointer-events-none"></span>
                        </div>

                        <!-- Clear Both Button -->
                        <button
                            v-if="searchQuery.trim() || dateFilter"
                            @click="searchQuery = ''; dateFilter = ''"
                            class="ml-2 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors duration-150 relative z-20"
                            :aria-label="$t('Clear filters')"
                        >
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <section
                    v-if="filteredEvents && filteredEvents.length > 0"
                    class="grid gap-x-8 gap-y-14 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="event in paginatedEvents"
                        :key="event.id"
                        class="group flex min-w-0 cursor-pointer flex-col"
                    >
                        <Link
                            :href="`/events/${event.id}`"
                            class="relative aspect-[1.25/1] w-full overflow-hidden rounded-[14px] bg-slate-100 transition duration-300 group-hover:-translate-y-1 group-hover:shadow-[0_14px_26px_rgba(15,23,42,0.12)]"
                            :aria-label="`Open ${event.title}`"
                        >
                            <div
                                class="absolute inset-0 bg-gradient-to-br"
                                :class="fallbackClasses[event.type]"
                            >
                                <div
                                    v-if="event.type === 'campus'"
                                    class="absolute inset-0"
                                >
                                    <div
                                        class="absolute -left-7 -top-9 h-32 w-32 rounded-full border-[16px] border-white/35"
                                    ></div>
                                    <div
                                        class="absolute bottom-0 right-0 h-20 w-[82%] rounded-tl-[42px] bg-white/20 backdrop-blur-[1px]"
                                    ></div>
                                    <div
                                        class="absolute bottom-4 right-5 text-right text-2xl font-black tracking-normal text-white/85"
                                    >
                                        DUC
                                    </div>
                                </div>
                                <div
                                    v-else-if="event.type === 'digital'"
                                    class="absolute inset-0 flex flex-col items-center justify-center text-center"
                                >
                                    <div
                                        class="mb-4 h-12 w-20 bg-[#0e4aba] shadow-sm"
                                    >
                                        <div
                                            class="mt-4 h-4 bg-[#df1f2d]"
                                        ></div>
                                    </div>
                                    <div
                                        class="text-[28px] font-black leading-none tracking-normal text-[#ff9c00]"
                                    >
                                        DIGITAL 2024
                                    </div>
                                    <div
                                        class="mt-1 text-[10px] font-bold tracking-[0.14em] text-white"
                                    >
                                        CAMBODIA
                                    </div>
                                </div>
                                <div v-else class="absolute inset-0">
                                    <div
                                        class="absolute right-0 top-0 h-[62%] w-[78%] rounded-bl-[48px] bg-black/30"
                                    ></div>
                                    <div
                                        class="absolute bottom-0 left-0 h-8 w-full bg-[#48a809]"
                                    ></div>
                                    <div
                                        class="absolute bottom-9 left-5 right-5 text-[20px] font-black leading-tight text-white"
                                    >
                                        DUC Announcement
                                    </div>
                                    <div
                                        class="absolute bottom-2 left-5 text-[11px] font-bold text-white"
                                    >
                                        Digital University of Cambodia
                                    </div>
                                </div>
                            </div>
                            <img
                                :src="event.image"
                                :alt="event.title"
                                class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                @error="
                                    $event.currentTarget.classList.add('hidden')
                                "
                            />
                        </Link>

                        <div class="flex min-w-0 flex-grow flex-col">
                            <Link
                                :href="`/events/${event.id}`"
                                class="line-clamp-2 pt-5 font-bold text-slate-900 transition-colors hover:text-[#00a0e9]"
                            >
                                {{ $t(event.title) }}
                            </Link>
                            <p
                                class="mt-2 line-clamp-2 text-sm leading-relaxed text-slate-500"
                            >
                                {{ stripHtml($t(event.description)) }}
                            </p>

                            <div
                                class="mt-auto pt-4 flex items-center justify-between text-xs font-medium text-slate-400"
                            >
                                <div
                                    class="flex min-w-0 items-center gap-1.5 whitespace-nowrap"
                                >
                                    <svg
                                        class="h-4 w-4 shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $t(event.date) }}</span>
                                </div>

                                <Link
                                    :href="`/events/${event.id}`"
                                    class="flex shrink-0 items-center whitespace-nowrap text-[#00a0e9] hover:underline"
                                    :aria-label="`Read more about ${$t(event.title)}`"
                                >
                                    {{ $t('Read more') }} &rarr;
                                </Link>
                            </div>
                        </div>
                    </article>
                </section>

                <!-- Pagination Controls -->
                <div 
                    v-if="totalPages > 1"
                    class="mt-14 flex flex-wrap justify-center items-center gap-2 pb-8"
                >
                    <button 
                        @click="prevPage" 
                        :disabled="currentPage === 1"
                        class="px-4 py-2 rounded-lg border text-sm font-medium transition-colors"
                        :class="currentPage === 1 ? 'border-slate-200 text-slate-400 cursor-not-allowed' : 'border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-[#0f2154]'"
                    >
                        {{ $t('Previous') }}
                    </button>
                    
                    <button 
                        v-for="(page, index) in visiblePages" 
                        :key="index"
                        @click="page !== '...' ? goToPage(page) : null"
                        :disabled="page === '...'"
                        class="w-10 h-10 rounded-lg border text-sm font-medium transition-colors flex items-center justify-center"
                        :class="[
                            currentPage === page ? 'bg-[#0f2154] border-[#0f2154] text-white' : 'border-slate-300 text-slate-700',
                            page !== '...' ? 'hover:bg-slate-50 hover:text-[#0f2154] cursor-pointer' : 'cursor-default border-transparent hover:bg-transparent shadow-none'
                        ]"
                    >
                        {{ page }}
                    </button>
                    
                    <button 
                        @click="nextPage" 
                        :disabled="currentPage === totalPages"
                        class="px-4 py-2 rounded-lg border text-sm font-medium transition-colors"
                        :class="currentPage === totalPages ? 'border-slate-200 text-slate-400 cursor-not-allowed' : 'border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-[#0f2154]'"
                    >
                        {{ $t('Next') }}
                    </button>
                </div>

                <div
                    v-if="!filteredEvents || filteredEvents.length === 0"
                    class="mt-14 py-24 text-center text-gray-500 bg-gray-50/80 rounded-3xl border border-gray-100 border-dashed"
                >
                    <svg
                        class="mx-auto h-14 w-14 text-gray-300 mb-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L16.5 5.5M9 11l3 3L22 4"
                        />
                    </svg>
                    <p class="text-xl font-medium text-gray-600">
                        {{ searchQuery.trim() ? $t('No search results found') : $t('No events found') }}
                    </p>
                    <p class="text-sm mt-2 text-gray-400">
                        {{ searchQuery.trim() ? $t('Try checking your spelling or search for another keyword.') : $t('There are currently no upcoming news or events to display.') }}
                    </p>
                </div>
            </main>
        </div>

        <SiteFooter />
    </div>
</template>

<style scoped>
/* Hide the native browser clear button on search inputs */
input[type="search"]::-webkit-search-cancel-button,
input[type="search"]::-webkit-search-decoration {
    -webkit-appearance: none;
    appearance: none;
    display: none;
}
</style>
