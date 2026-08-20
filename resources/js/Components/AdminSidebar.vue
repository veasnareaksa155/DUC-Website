<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    activeTab: {
        type: String,
        required: true
    },
    ducLogo: {
        type: String,
        required: true
    },
    onLogout: {
        type: Function,
        required: true
    }
});

const menuItems = [
    { tab: 'overview', label: 'Overview', icon: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z' },
    { tab: 'home', label: 'Home Page Builder', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { tab: 'navigation', label: 'Header & Navigation', icon: 'M4 6h16M4 12h16M4 18h7' },
    { tab: 'pages', label: 'Pages & Content', icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' },
    { tab: 'events', label: 'News & Events', icon: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z' },
    { tab: 'faculties', label: 'Faculties & Academic', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4' },
    { tab: 'contact', label: 'Contact Settings', icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
    { tab: 'translations', label: 'Translations Manager', icon: 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 7.31 16.5 1 18' },
    { tab: 'settings', label: 'Footer Settings', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z' }
];
</script>

<template>
    <aside class="w-68 bg-[#0c101b] border-r border-[#1a2333] flex flex-col justify-between flex-shrink-0 z-20">
        <div>
            <!-- Brand Title -->
            <div class="p-5 border-b border-[#1a2333] flex items-center gap-3.5 bg-gradient-to-r from-blue-950/20 to-transparent">
                <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 dark:border-none flex items-center justify-center shadow-lg shadow-blue-500/20 overflow-hidden p-0.5 shrink-0">
                    <img :src="ducLogo" alt="DUC Logo" class="w-full h-full object-contain" />
                </div>
                <div class="truncate">
                    <h1 class="text-base font-black tracking-tight text-white leading-none truncate">DUC Console</h1>
                    <span class="text-[10px] text-blue-400 font-extrabold tracking-wider uppercase truncate block mt-1">Portal Management</span>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <nav class="p-3.5 space-y-1.5">
                <Link 
                    v-for="item in menuItems"
                    :key="item.tab"
                    :href="route('dashboard', { tab: item.tab })"
                    preserve-state
                    preserve-scroll
                    class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-extrabold transition-all"
                    :class="activeTab === item.tab 
                        ? 'bg-blue-600 text-white shadow-md shadow-blue-600/10' 
                        : 'text-slate-300 hover:bg-[#131927] hover:text-white'"
                >
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon"></path></svg>
                    <span class="truncate">{{ item.label }}</span>
                </Link>
            </nav>
        </div>

        <!-- Profile Info & Logout -->
        <div class="p-4 border-t border-[#1a2333] bg-[#090c14] flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-black text-slate-200 text-sm">
                    A
                </div>
                <div>
                    <p class="text-sm font-extrabold text-white">Administrator</p>
                    <span class="text-[10px] text-emerald-400 font-black tracking-wide uppercase flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Online
                    </span>
                </div>
            </div>
            <button @click="onLogout" class="text-slate-400 hover:text-red-400 p-2.5 rounded-xl hover:bg-slate-900 transition-colors" title="Log out">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </div>
    </aside>
</template>
