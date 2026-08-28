<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

const props = defineProps({
    studentUniformSettings: Object
});

const isVisible = ref(false);
const page = usePage();

const tl = (obj) => {
    if (!obj) return '';
    if (typeof obj === 'string') return obj;
    return obj[page.props.locale] || obj.en || '';
};

const defaultText = {
    page_title: { km: 'ឯកសណ្ឋាននិស្សិត | DUC', en: 'Student Uniform | DUC' },
    title: { km: '១. ឯកសណ្ឋាន', en: '1. Uniform' },
    subtitle: { km: 'ហេតុអ្វីបានជាឯកសណ្ឋានសាលាសំខាន់?', en: 'Why is school uniform important?' },
    description: { km: 'ឯកសណ្ឋានសាលាគឺជាផ្នែកមួយដ៏សំខាន់នៃប្រព័ន្ធអប់រំដែលជួយបង្កើត បរិយាកាសសិក្សា ប្រកបដោយវិជ្ជាជីវៈ និងសេចក្តីថ្លៃថ្នូរ។', en: 'School uniform is an important part of the education system that helps create a professional and dignified learning environment.' },
    hero_badge: { km: 'ព័ត៌មាននិស្សិត', en: 'Student Information' },
    hero_title: { km: 'ឯកសណ្ឋាននិស្សិត', en: 'Student Uniform' },
    hero_subtitle: { km: 'សេចក្តីណែនាំអំពីឯកសណ្ឋាននិស្សិតនៃសាកលវិទ្យាល័យឌីជីថលកម្ពុជា។', en: 'Guidelines on Student Uniform of the Digital University of Cambodia.' },
    hero_button: { km: 'មើលសេចក្តីលម្អិត', en: 'View Details' },
    equality_title: { km: 'សមភាព', en: 'Equality' },
    equality_desc: { km: 'ភាពស្មើគ្នា', en: 'Equality among all students' },
    discipline_title: { km: 'វិន័យ', en: 'Discipline' },
    discipline_desc: { km: 'ជួយឲ្យសិស្សមានសណ្តាប់ធ្នាប់', en: 'Helps students maintain order' },
    identity_title: { km: 'អត្តសញ្ញាណ', en: 'Identity' },
    identity_desc: { km: 'បង្កើតមោទនភាព និងភាពងាយស្រួលក្នុងការសម្គាល់សមាជិកក្នុងសាលា។', en: 'Creates pride and ease of identifying members in the school.' },
    male_student: { km: 'និស្សិតប្រុស', en: 'Male Student' },
    female_student: { km: 'និស្សិតស្រី', en: 'Female Student' },
    male_title: { km: '១.១ ឯកសណ្ឋាននិស្សិតប្រុស', en: '1.1 Male Student Uniform' },
    female_title: { km: '១.២ ឯកសណ្ឋាននិស្សិតស្រី', en: '1.2 Female Student Uniform' },
    clothing: { km: '១. សម្លៀកបំពាក់សិស្ស', en: '1. Student Clothing' },
    logo: { km: '២. Logo', en: '2. Logo' },
    shoes: { km: '៣. ស្បែកជើងសិស្ស', en: '3. Student Shoes' },
};

const heroSettings = computed(() => {
    const hero = props.studentUniformSettings?.hero || {};
    return {
        badge: hero.badge?.en ? hero.badge : defaultText.hero_badge,
        title: hero.title?.en ? hero.title : defaultText.hero_title,
        subtitle: hero.subtitle?.en ? hero.subtitle : defaultText.hero_subtitle,
        button: hero.button?.en ? hero.button : defaultText.hero_button,
    };
});

const overviewSettings = computed(() => {
    const ov = props.studentUniformSettings?.overview || {};
    return {
        title: ov.title?.en ? ov.title : defaultText.title,
        subtitle: ov.subtitle?.en ? ov.subtitle : defaultText.subtitle,
        description: ov.description?.en ? ov.description : defaultText.description,
    };
});

const cardsSettings = computed(() => {
    if (Array.isArray(props.studentUniformSettings?.cards) && props.studentUniformSettings.cards.length > 0) {
        return props.studentUniformSettings.cards;
    }
    return [
        { title: defaultText.equality_title, desc: defaultText.equality_desc, icon: 'Users' },
        { title: defaultText.discipline_title, desc: defaultText.discipline_desc, icon: 'ShieldCheck' },
        { title: defaultText.identity_title, desc: defaultText.identity_desc, icon: 'Briefcase' }
    ];
});

const gendersSettings = computed(() => {
    const g = props.studentUniformSettings?.genders || {};
    return {
        male_title: g.male_title?.en ? g.male_title : defaultText.male_student,
        male_img: g.male_img || 'https://images.unsplash.com/photo-1594913271166-4177573678da?q=80&w=600&auto=format&fit=crop',
        female_title: g.female_title?.en ? g.female_title : defaultText.female_student,
        female_img: g.female_img || 'https://images.unsplash.com/photo-1592837380126-1d15d666d66e?q=80&w=600&auto=format&fit=crop'
    };
});

const maleDetailsSettings = computed(() => {
    const m = props.studentUniformSettings?.male_details || {};
    return {
        section_title: m.section_title?.en ? m.section_title : defaultText.male_title,
        full_img: m.full_img || 'https://images.unsplash.com/photo-1594913271166-4177573678da?q=80&w=800&auto=format&fit=crop',
        clothing_title: m.clothing_title?.en ? m.clothing_title : defaultText.clothing,
        clothing_img: m.clothing_img || 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=600&auto=format&fit=crop',
        logo_title: m.logo_title?.en ? m.logo_title : defaultText.logo,
        logo_img: m.logo_img || null,
        shoes_title: m.shoes_title?.en ? m.shoes_title : defaultText.shoes,
        shoes_img: m.shoes_img || 'https://images.unsplash.com/photo-1614252339474-af32588b35db?q=80&w=600&auto=format&fit=crop'
    };
});

const femaleDetailsSettings = computed(() => {
    const f = props.studentUniformSettings?.female_details || {};
    return {
        section_title: f.section_title?.en ? f.section_title : defaultText.female_title,
        full_img: f.full_img || 'https://images.unsplash.com/photo-1592837380126-1d15d666d66e?q=80&w=800&auto=format&fit=crop',
        clothing_title: f.clothing_title?.en ? f.clothing_title : defaultText.clothing,
        clothing_img: f.clothing_img || 'https://images.unsplash.com/photo-1592837380126-1d15d666d66e?q=80&w=600&auto=format&fit=crop',
        logo_title: f.logo_title?.en ? f.logo_title : defaultText.logo,
        logo_img: f.logo_img || null,
        shoes_title: f.shoes_title?.en ? f.shoes_title : defaultText.shoes,
        shoes_img: f.shoes_img || 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop'
    };
});

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});
</script>

<template>
    <Head :title="tl(defaultText.page_title)" />

    <div class="min-h-screen bg-global-bg font-sans text-slate-900 flex flex-col selection:bg-amber-400 overflow-hidden relative">
        <SiteHeader />

        <!-- VIBRANT Abstract Background Mesh -->
        <div class="fixed top-[300px] left-0 right-0 h-[800px] overflow-hidden pointer-events-none -z-10">
            <div class="absolute -top-40 -right-20 w-[600px] h-[600px] rounded-full bg-blue-500/10 blur-[120px] mix-blend-multiply opacity-60 animate-blob"></div>
            <div class="absolute top-20 -left-20 w-[500px] h-[500px] rounded-full bg-amber-400/10 blur-[120px] mix-blend-multiply opacity-60 animate-blob animation-delay-2000"></div>
            <div class="absolute top-[400px] left-[20%] w-[600px] h-[600px] rounded-full bg-teal-400/10 blur-[120px] mix-blend-multiply opacity-40 animate-blob animation-delay-4000"></div>
        </div>

        <main class="flex-grow w-full transition-opacity duration-1000 pb-16" :class="isVisible ? 'opacity-100' : 'opacity-0'">
            
            <!-- Header Banner Section -->
            <section class="bg-[#115D6D] text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-teal-800/50 shadow-md">
                <div class="max-w-[1400px] mx-auto text-center space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-amber-300 text-xs sm:text-sm font-semibold backdrop-blur-md border border-white/15 mb-6 shadow-sm">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                        <span>{{ tl(heroSettings.badge) }}</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-[1.3] max-w-4xl mx-auto mb-6 text-white" style="font-family: 'Moul', 'Khmer OS Moul', serif; text-shadow: 0 4px 20px rgba(0,0,0,0.4);">
                        {{ tl(heroSettings.title) }}
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-teal-50 max-w-3xl mx-auto font-medium mb-10 leading-relaxed">
                        {{ tl(heroSettings.subtitle) }}
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row flex-wrap justify-center items-center gap-4">
                        <a href="#details" class="px-6 py-3 rounded-full bg-amber-400 text-slate-900 font-extrabold hover:bg-amber-300 transition-all shadow-lg flex items-center gap-2 text-sm sm:text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.998-9.542-7z"/>
                            </svg>
                            {{ tl(heroSettings.button) }}
                        </a>
                    </div>
                </div>
            </section>

            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16 space-y-16 lg:space-y-24" id="details">
                <!-- Section 1: Overview & Importance -->
            <section class="animate-fade-in-up" style="animation-delay: 0.1s">
                <div class="bg-white/80 backdrop-blur-xl border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-[2.5rem] p-8 lg:p-14 overflow-hidden relative transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
                        <!-- Text Content -->
                        <div class="space-y-8">
                            <div>
                                <h1 class="text-4xl lg:text-5xl font-extrabold text-[#283593] mb-4 tracking-tight drop-shadow-sm" style="font-family: 'Moul', 'Khmer OS Moul', serif;">
                                    {{ tl(overviewSettings.title) }}
                                </h1>
                                <h2 class="text-2xl font-bold text-slate-800 mb-6">
                                    {{ tl(overviewSettings.subtitle) }}
                                </h2>
                                <p class="text-lg text-slate-600 leading-relaxed font-medium">
                                    {{ tl(overviewSettings.description) }}
                                </p>
                            </div>

                            <div class="space-y-5">
                                <div v-for="(card, idx) in cardsSettings" :key="idx" class="flex items-start gap-4 p-4 rounded-2xl bg-gradient-to-br from-blue-50/50 to-transparent border border-blue-100/50 hover:-translate-y-1 transition-transform duration-300">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 font-bold text-xl">
                                        <svg v-if="card.icon === 'Users'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <svg v-else-if="card.icon === 'ShieldCheck'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-extrabold text-[#283593]">{{ tl(card.title) }}</h3>
                                        <p class="text-slate-600 font-medium">{{ tl(card.desc) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Representation -->
                        <div class="relative">
                            <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-100 grid grid-cols-2 gap-4">
                                <div class="space-y-3 text-center group">
                                    <div class="aspect-[3/4] rounded-2xl bg-slate-100 overflow-hidden relative border border-slate-200 group-hover:shadow-md transition-all">
                                        <img :src="gendersSettings.male_img" alt="Male Student" class="w-full h-full object-cover object-top filter contrast-125 opacity-90 group-hover:scale-105 transition-transform duration-700" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                        <div class="absolute bottom-3 left-0 right-0 text-white font-bold text-lg drop-shadow-md">{{ tl(gendersSettings.male_title) }}</div>
                                    </div>
                                </div>
                                <div class="space-y-3 text-center group">
                                    <div class="aspect-[3/4] rounded-2xl bg-slate-100 overflow-hidden relative border border-slate-200 group-hover:shadow-md transition-all">
                                        <img :src="gendersSettings.female_img" alt="Female Student" class="w-full h-full object-cover object-top filter contrast-125 opacity-90 group-hover:scale-105 transition-transform duration-700" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                        <div class="absolute bottom-3 left-0 right-0 text-white font-bold text-lg drop-shadow-md">{{ tl(gendersSettings.female_title) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 2: Male Uniform Details -->
            <section class="animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="text-center mb-10">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-[#283593] inline-block relative" style="font-family: 'Moul', 'Khmer OS Moul', serif;">
                        {{ tl(maleDetailsSettings.section_title) }}
                        <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-1/2 h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent rounded-full"></span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center bg-white/70 backdrop-blur-lg border border-white/50 p-8 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.03)]">
                    
                    <!-- Left: Full body image -->
                    <div class="md:col-span-4 rounded-3xl overflow-hidden bg-slate-50 border border-slate-100 shadow-inner h-[600px] relative group">
                        <img :src="maleDetailsSettings.full_img" alt="Male Uniform Full" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-1000" />
                    </div>
                    
                    <!-- Right: Details -->
                    <div class="md:col-span-8 space-y-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            
                            <!-- Detail 1: Clothing -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">1</div>
                                    <h3 class="text-xl font-bold text-slate-800">{{ tl(maleDetailsSettings.clothing_title) }}</h3>
                                </div>
                                <div class="aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img :src="maleDetailsSettings.clothing_img" alt="Male Suit" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                </div>
                            </div>
                            
                            <!-- Detail 2: Logo -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold">2</div>
                                    <h3 class="text-xl font-bold text-slate-800">{{ tl(maleDetailsSettings.logo_title) }}</h3>
                                </div>
                                <div v-if="maleDetailsSettings.logo_img" class="aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center p-4">
                                    <img :src="maleDetailsSettings.logo_img" alt="Male Logo" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500" />
                                </div>
                                <div v-else class="aspect-square rounded-xl flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-200 shadow-inner relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-amber-400 via-transparent to-transparent"></div>
                                    <div class="text-amber-400 text-4xl font-extrabold tracking-widest relative z-10" style="font-family: 'Old English Text MT', serif; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));">DUC</div>
                                </div>
                            </div>

                        </div>

                        <!-- Detail 3: Shoes -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold">3</div>
                                <h3 class="text-xl font-bold text-slate-800">{{ tl(maleDetailsSettings.shoes_title) }}</h3>
                            </div>
                            <div class="h-48 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center p-4">
                                <img :src="maleDetailsSettings.shoes_img" alt="Male Shoes" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 3: Female Uniform Details -->
            <section class="animate-fade-in-up" style="animation-delay: 0.5s">
                <div class="text-center mb-10">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-[#283593] inline-block relative" style="font-family: 'Moul', 'Khmer OS Moul', serif;">
                        {{ tl(femaleDetailsSettings.section_title) }}
                        <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-1/2 h-1 bg-gradient-to-r from-transparent via-amber-500 to-transparent rounded-full"></span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center bg-white/70 backdrop-blur-lg border border-white/50 p-8 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.03)]">
                    
                    <!-- Left: Details -->
                    <div class="md:col-span-8 space-y-8 order-2 md:order-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            
                            <!-- Detail 1: Clothing -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">1</div>
                                    <h3 class="text-xl font-bold text-slate-800">{{ tl(femaleDetailsSettings.clothing_title) }}</h3>
                                </div>
                                <div class="aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center p-4">
                                    <img :src="femaleDetailsSettings.clothing_img" alt="Female Uniform" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                </div>
                            </div>
                            
                            <!-- Detail 2: Logo -->
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold">2</div>
                                    <h3 class="text-xl font-bold text-slate-800">{{ tl(femaleDetailsSettings.logo_title) }}</h3>
                                </div>
                                <div v-if="femaleDetailsSettings.logo_img" class="aspect-square rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center p-4">
                                    <img :src="femaleDetailsSettings.logo_img" alt="Female Logo" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500" />
                                </div>
                                <div v-else class="aspect-square rounded-xl flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-200 shadow-inner relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-amber-400 via-transparent to-transparent"></div>
                                    <div class="text-amber-400 text-4xl font-extrabold tracking-widest relative z-10" style="font-family: 'Old English Text MT', serif; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));">DUC</div>
                                </div>
                            </div>

                        </div>

                        <!-- Detail 3: Shoes -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow group">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold">3</div>
                                <h3 class="text-xl font-bold text-slate-800">{{ tl(femaleDetailsSettings.shoes_title) }}</h3>
                            </div>
                            <div class="h-48 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center p-4">
                                <img :src="femaleDetailsSettings.shoes_img" alt="Female Shoes" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right: Full body image -->
                    <div class="md:col-span-4 rounded-3xl overflow-hidden bg-slate-50 border border-slate-100 shadow-inner h-[600px] relative group order-1 md:order-2">
                        <img :src="femaleDetailsSettings.full_img" alt="Female Uniform Full" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-1000" />
                    </div>

                </div>
            </section>
            </div>

        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
.animate-fade-in-up {
    opacity: 0;
    animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-blob {
    animation: blob 10s infinite alternate;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
</style>
