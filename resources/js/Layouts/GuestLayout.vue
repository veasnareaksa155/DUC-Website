<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    noCard: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-[#070b13] pt-6 sm:justify-center sm:pt-0 relative overflow-hidden"
    >
        <!-- Background decorative elements -->
        <div class="absolute top-0 -left-4 w-[500px] h-[500px] bg-cyan-600 rounded-full mix-blend-screen filter blur-[120px] opacity-10 animate-pulse"></div>
        <div class="absolute top-0 -right-4 w-[500px] h-[500px] bg-blue-600 rounded-full mix-blend-screen filter blur-[120px] opacity-10 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-8 left-20 w-[500px] h-[500px] bg-teal-600 rounded-full mix-blend-screen filter blur-[120px] opacity-10 animate-pulse" style="animation-delay: 4s;"></div>

        <!-- Default Logo (Hidden when custom card layout is used) -->
        <div v-if="!noCard" class="z-10 relative mb-6">
            <Link href="/">
                <ApplicationLogo class="h-24 w-auto object-contain drop-shadow-xl hover:scale-105 transition-transform duration-300" />
            </Link>
        </div>

        <!-- Default Card Container (Bypassed when noCard is true) -->
        <div
            v-if="!noCard"
            class="z-10 relative mt-6 w-full overflow-hidden bg-white/40 backdrop-blur-2xl border border-white/60 px-8 py-10 shadow-[0_8px_30px_rgb(0,0,0,0.08)] sm:max-w-md sm:rounded-3xl"
        >
            <slot />
        </div>
        
        <slot v-else />
    </div>
</template>
