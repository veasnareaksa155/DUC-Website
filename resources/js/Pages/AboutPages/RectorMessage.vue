<script setup>
import { computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import SiteHeader from "@/Components/SiteHeader.vue";
import SiteFooter from "@/Components/SiteFooter.vue";
import directorImage from "./images/rectorImage.jpg";

const props = defineProps({
    pageData: {
        type: Object,
        default: null
    }
});

const page = usePage();

const rectorName = computed(() => {
    const locale = page.props?.locale || 'en';
    const raw = props.pageData?.rector_name;
    if (raw) {
        if (typeof raw === 'object' && raw !== null) {
            return raw[locale] || raw.en || raw.km || '';
        }
        return raw;
    }
    return locale === 'km' ? "ឯកឧត្តម បណ្ឌិត ខឹម ភារុណ" : "H.E. Dr. KHEM Phearun";
});

const rectorTitle = computed(() => {
    const locale = page.props?.locale || 'en';
    const raw = props.pageData?.rector_title;
    if (raw) {
        if (typeof raw === 'object' && raw !== null) {
            return raw[locale] || raw.en || raw.km || '';
        }
        return raw;
    }
    return locale === 'km' ? "សាកលវិទ្យាធិការ នៃសាកលវិទ្យាល័យឌីជីថលកម្ពុជា" : "Rector of the Digital University of Cambodia";
});
const paragraphs = computed(() => {
    const locale = page.props?.locale || 'en';
    if (props.pageData) {
        if (locale === 'km' && props.pageData.paragraphs_km) {
            return props.pageData.paragraphs_km;
        }
        return props.pageData.paragraphs_en || props.pageData.paragraphs || [];
    }
    return [
        "As the Rector of the Digital University of Cambodia, I am thrilled and honored to lead an institution at the forefront of innovation in this rapidly evolving technology sector. In this fast-paced field, the need for continuous learning and adaptation is truly essential, requiring us to design and develop new curricula to keep pace with the latest advancements in the AI era, cybersecurity, supply chains, data science, and many other areas. We believe that the future of technology lies in the hands of those who possess not only technical expertise but also the vision to apply these tools in innovative and effective ways.",
        "Today, digital technology is no longer just an academic field; it is the foundation of modern society, driving progress across all institutions, sectors, and industries—from agriculture, healthcare, and education to entertainment, digital marketing, and finance.",
        "At our university, we recognize that while our digital technology is in its foundational stages, we are actively training students to help solve some of the world's most complex challenges. Whether it is developing advanced artificial intelligence, improving cybersecurity, building sustainable smart cities, or driving next-generation digital experiences, our faculty, students, and researchers are at the heart of this global social transformation. Our mission is to provide a comprehensive education that goes beyond theory and equips our students with the practical skills and visionary mindset needed for excellence in this dynamic field, accompanied by a spirit of nationalism.",
        "Our university emphasizes hands-on learning, internships, cutting-edge research, and close collaboration with the Ministry of Education, Youth and Sport to ensure that our graduates are not only well-versed in the latest technologies but also fully prepared to lead the way in shaping precise digital skills for the future.",
        "The future of digital technology is bright, but it is only through learning, curiosity, and innovation that we can dispel ignorance and fully unlock its potential. Whether you are just beginning your journey or are a digital industry professional seeking advanced knowledge, our university offers an environment where digital curiosity meets real-world application.",
        "I encourage all of you to join us in exploring the limitless possibilities of digital technology. Together, we can drive forward-thinking solutions that will positively impact our nation and our world."
    ];
});
</script>

<template>
    <Head :title="$t('Rector\'s Message')" />

    <div class="min-h-screen bg-white font-sans text-black flex flex-col">
        <SiteHeader />

        <main
            class="mx-auto w-full max-w-[1400px] px-4 py-12 md:px-6 flex-grow"
        >
            <section
                class="grid grid-cols-1 gap-10 md:grid-cols-[350px_1fr] lg:grid-cols-[420px_1fr] lg:gap-16 items-start animate-[fadeIn_0.8s_ease-out]"
            >
                <div
                    class="w-full overflow-hidden rounded-[24px] bg-slate-100 shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-xl group"
                >
                    <img
                        :src="pageData?.rector_image || directorImage"
                        alt="Rector of Digital University of Cambodia"
                        class="h-[400px] lg:h-[480px] w-full object-cover object-center transition-transform duration-700 group-hover:scale-105"
                        onerror="
                            this.src =
                                'https://placehold.co/400x500/1e293b/ffffff.png?text=Director'
                        "
                    />
                </div>

                <div class="pt-2 md:pt-4 min-w-0">
                    <h2
                        class="text-[32px] font-black leading-tight text-[#1c244b] tracking-tight"
                    >
                        {{ rectorName }}
                    </h2>
                    <p class="text-[24px] font-semibold text-slate-700 mt-1">{{ rectorTitle }}</p>


                <div
                    class="mt-3 space-y-6 text-[18px] leading-relaxed text-black/80 text-justify">
                
                    <div v-if="Array.isArray(paragraphs)" v-for="(para, idx) in paragraphs" :key="idx" :class="{ 'font-semibold text-[#1c244b]': idx === paragraphs.length - 1 }">
                        {{ $t(para) }}
                    </div>
                    <div v-else class="ql-editor px-0" v-html="paragraphs"></div>
                </div>
                </div>
            </section>

            
        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
