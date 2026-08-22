<script setup>
import { Link, Head } from "@inertiajs/vue3";
import SiteHeader from "@/Components/SiteHeader.vue";
import SiteFooter from "@/Components/SiteFooter.vue";

const props = defineProps({
    faculties: {
        type: Array,
        default: () => []
    }
});

const getFacultyImage = (faculty) => {
    // If the database has a custom uploaded cover image, use it!
    if (faculty.cover_image && !faculty.cover_image.includes('placeholder')) {
        return faculty.cover_image;
    }
    // Fallback to org_chart_image for legacy support
    if (faculty.org_chart_image && !faculty.org_chart_image.includes('placeholder')) {
        return faculty.org_chart_image;
    }
    
    // Otherwise, fall back to the beautiful custom illustrations matching each faculty
    const fallbacks = {
        1: "https://s3.minio.itc.rupp.edu.kh/ruppweb/sub-sub-menus-images/01K9NY160XV04QBKKW4F9RAJR7.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=IPRqVNbIaRnx8CNMvBWB%2F20260707%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260707T063518Z&X-Amz-SignedHeaders=host&X-Amz-Expires=900&X-Amz-Signature=f6cfaff456203cc2bf4f5892178d606c3262243096b367103167068f82975cae",
        2: "https://s3.minio.itc.rupp.edu.kh/ruppweb/sub-sub-menus-images/01KC5KYAB90BX9H9EHABTRG9KD.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=IPRqVNbIaRnx8CNMvBWB%2F20260707%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260707T063518Z&X-Amz-SignedHeaders=host&X-Amz-Expires=900&X-Amz-Signature=ce89ab0a6945473af719cd39afd221f0e2c653b1afe4b55862d968ba6720b7cc",
        3: "https://s3.minio.itc.rupp.edu.kh/ruppweb/sub-sub-menus-images/01KC5KZ55ZK45C3FXZB4TV7ZPT.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=IPRqVNbIaRnx8CNMvBWB%2F20260707%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260707T063518Z&X-Amz-SignedHeaders=host&X-Amz-Expires=900&X-Amz-Signature=9476a7ce2f99b38aef72a224378210a66847e92d5a4a513565fe0629cdea300f",
        4: "https://s3.minio.itc.rupp.edu.kh/ruppweb/sub-sub-menus-images/01KBESC0PKPQWCATK1DNMBJDMS.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=IPRqVNbIaRnx8CNMvBWB%2F20260707%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260707T063518Z&X-Amz-SignedHeaders=host&X-Amz-Expires=900&X-Amz-Signature=60016abb0ea4d0927668598ea65a0e89f8e922ac0006867d9c69973bba77cca8",
        5: "https://s3.minio.itc.rupp.edu.kh/ruppweb/sub-sub-menus-images/01KBESDN3ZGANH962Q9CTRN2KY.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=IPRqVNbIaRnx8CNMvBWB%2F20260707%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260707T063518Z&X-Amz-SignedHeaders=host&X-Amz-Expires=900&X-Amz-Signature=aa08b99db5b2dc8a8fa569cb3277574c1ffd640c1e13ae98d9d74d2451a24f9f",
        6: "https://s3.minio.itc.rupp.edu.kh/ruppweb/sub-sub-menus-images/01KC5M0BMFVASZTC1DTWJHVFK8.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=IPRqVNbIaRnx8CNMvBWB%2F20260707%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20260707T063518Z&X-Amz-SignedHeaders=host&X-Amz-Expires=900&X-Amz-Signature=a1b210314ba57235b6ea41cbefd6c7b50d78a80c24c6314a7c7862346e12017f"
    };
    return fallbacks[faculty.id] || "https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=600&q=80";
};
</script>

<template>
    <Head :title="$t('Faculties')" />
    
    <div class="min-h-screen flex flex-col bg-global-bg text-slate-900 font-sans">
        <SiteHeader />

        <!-- UPDATED WRAPPER: Changed to max-w-[1400px] and matched padding to header -->
        <main class="flex-grow mx-auto w-full max-w-[1400px] px-4 md:px-6 py-12">
            <div class="mb-10 border-b border-slate-300/60 pb-4">
                <h1 class="text-3xl md:text-4xl font-bold text-[#115D6D] mb-2 text-left">{{ $t('Faculties') }}</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <Link
                    v-for="faculty in faculties"
                    :key="faculty.id"
                    :href="'/department/' + faculty.id"
                    class="group bg-card-bg rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col overflow-hidden"
                >
                    <div class="h-56 bg-gray-200 relative overflow-hidden">
                        <img 
                            :src="getFacultyImage(faculty)" 
                            :alt="$t(faculty.name)"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                    </div>

                    <div class="bg-card-bg text-[#115D6D] group-hover:text-blue-600 transition-colors p-5 text-center flex-grow flex items-center justify-center">
                        <h3 class="font-bold text-lg leading-snug">{{ $t(faculty.name) }}</h3>
                    </div>
                </Link>
            </div>
        </main>

        <SiteFooter />
    </div>
</template>
