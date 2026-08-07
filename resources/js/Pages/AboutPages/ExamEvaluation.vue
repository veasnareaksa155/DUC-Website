<script setup>
import { computed } from "vue";
import { Head } from "@inertiajs/vue3";
import SiteHeader from "@/Components/SiteHeader.vue";
import SiteFooter from "@/Components/SiteFooter.vue";
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const props = defineProps({
    pageData: {
        type: Object,
        default: null,
    },
});

const intro = computed(() => {
    return (
        props.pageData?.intro ||
        `The academic evaluation for students studying at the Associate, Bachelor's, or Master's degree levels for each subject shall be implemented as follows:

1. General attendance includes class attendance, line gatherings (assemblies), morality, discipline, and all activities organized by the university.

2. Student assignments and practical learning include participation in learning activities and the Global English Test.

3. Research assignments refer to tasks assigned by instructors to individual students or groups to research any topic related to the respective subject. The scoring by the instructor or professor for research assignments must be based on the formatting, document content, and the student's presentation skills. Instructors or professors may break down the research assignment by combining it with class participation, practical exercises, and/or homework, but the total percentage of points must remain unchanged. For major subjects...`
    );
});

const breakdown = computed(() => {
    return (
        props.pageData?.breakdown || [
            { criteria: "Punctuality", percentage: "10%" },
            {
                criteria: "Student Assignments and Practical Work",
                percentage: "15%",
            },
            { criteria: "Attendance Score", percentage: "5%" },
            {
                criteria: "Research Assignments and Midterm Exam",
                percentage: "15%",
            },
            { criteria: "Final Exam", percentage: "55%" },
        ]
    );
});

const grades = computed(() => {
    return (
        props.pageData?.grades || [
            {
                score: "85 to 100",
                letter: "A",
                points: "4.00",
                description: "Excellent",
            },
            {
                score: "80 to 84",
                letter: "B+",
                points: "3.50",
                description: "Very Good",
            },
            {
                score: "70 to 79",
                letter: "B",
                points: "3.00",
                description: "Good",
            },
            {
                score: "65 to 69",
                letter: "C+",
                points: "2.50",
                description: "Fairly Good",
            },
            {
                score: "50 to 64",
                letter: "C",
                points: "2.00",
                description: "Fair",
            },
            {
                score: "45 to 49",
                letter: "D",
                points: "1.50",
                description: "Poor",
            },
            {
                score: "40 to 44",
                letter: "E",
                points: "1.00",
                description: "Very Poor",
            },
            {
                score: "00 to 40",
                letter: "F",
                points: "0.00",
                description: "Failure",
            },
        ]
    );
});
</script>

<template>
    <Head
        :title="$t('Exam and Evaluation')"
    />

    <div class="min-h-screen flex flex-col bg-white text-gray-900 font-sans">
        <SiteHeader />

        <!-- Main Wrapper aligned with Header -->
        <main
            class="flex-grow mx-auto w-full max-w-[1400px] px-4 py-12 md:px-6"
        >
            <h1
                class="text-3xl md:text-4xl font-bold text-[#0f2154] mb-10 text-left"
            >
                {{ $t("Exam and Evaluation") }}
            </h1>

            <div class="max-w-[1400px]">
                <!-- Blue Border Information Box -->
                <div
                    class="text-justify border-2 border-[#00a0e9] p-4 md:p-6 mb-6 text-sm md:text-[15px] leading-relaxed font-medium whitespace-pre-line"
                >
                    <h2 class="text-center text-lg font-bold mb-4">
                        {{ $t("Student Academic Evaluation") }}
                    </h2>
                    <div
                        v-html="$t(intro)"
                        class="prose prose-slate max-w-none prose-p:my-2 prose-a:text-blue-600 hover:prose-a:text-blue-800"
                    ></div>
                </div>

                <!-- First Table: Scoring Breakdown -->
                <h3 class="font-bold mb-2">
                    {{ $t("Student Academic Evaluation") }}
                </h3>
                <div class="overflow-x-auto mb-8">
                    <table
                        class="w-full border-collapse border border-gray-400 text-sm md:text-base"
                    >
                        <tbody>
                            <tr class="bg-gray-50">
                                <td
                                    class="border border-gray-400 p-2 text-center w-12 font-bold"
                                >
                                    {{ $t("No.") }}
                                </td>
                                <td
                                    class="border border-gray-400 p-2 font-bold"
                                >
                                    {{ $t("Evaluation Criteria") }}
                                </td>
                                <td
                                    class="border border-gray-400 p-2 text-center w-28 font-bold"
                                >
                                    {{ $t("Percentage") }}
                                </td>
                            </tr>
                            <tr v-for="(item, idx) in breakdown" :key="idx">
                                <td
                                    class="border border-gray-400 p-2 text-center"
                                >
                                    {{ idx + 1 }}
                                </td>
                                <td class="border border-gray-400 p-2">
                                    {{ $t(item.criteria) }}
                                </td>
                                <td
                                    class="border border-gray-400 p-2 text-center"
                                >
                                    {{ $t(item.percentage) }}
                                </td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td
                                    class="border border-gray-400 p-2 text-center font-bold"
                                    colspan="2"
                                >
                                    {{ $t("Total Score") }}
                                </td>
                                <td
                                    class="border border-gray-400 p-2 text-center font-bold"
                                >
                                    100%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Second Table: Grading Scale -->
                <div class="overflow-x-auto mb-6">
                    <table
                        class="w-full border-collapse border border-gray-400 text-sm md:text-base text-center"
                    >
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="border border-gray-400 p-3 font-bold"
                                >
                                    {{ $t("Percentage Score") }}
                                </th>
                                <th
                                    class="border border-gray-400 p-3 font-bold"
                                >
                                    {{ $t("Letter Grade") }}
                                </th>
                                <th
                                    class="border border-gray-400 p-3 font-bold"
                                >
                                    {{ $t("Grade Point") }}
                                </th>
                                <th
                                    class="border border-gray-400 p-3 font-bold"
                                >
                                    {{ $t("Description") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(g, idx) in grades" :key="idx">
                                <td class="border border-gray-400 p-2">
                                    {{ g.score.split(" to ")[0] }}
                                    {{ $t("to") }}
                                    {{ g.score.split(" to ")[1] }}
                                </td>
                                <td
                                    class="border border-gray-400 p-2 font-semibold"
                                    v-html="
                                        g.letter.replace('+', '<sup>+</sup>')
                                    "
                                ></td>
                                <td class="border border-gray-400 p-2">
                                    {{ $t(g.points) }}
                                </td>
                                <td
                                    class="border border-gray-400 p-2 text-left px-4"
                                >
                                    {{ $t(g.description) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Formula -->
                <div
                    class="mt-8 text-sm md:text-base leading-relaxed flex flex-col justify-center items-center"
                >
                    <p class="mb-4 text-gray-700">
                        {{
                            $t(
                                "The passing grade point for each subject is defined as 2.00 and above.",
                            )
                        }}
                    </p>
                    <p class="mb-4 text-gray-700">
                        {{
                            $t(
                                "The formula for calculating the Grade Point Average (GPA) is:",
                            )
                        }}
                    </p>
                    <div
                        class="flex items-center justify-center lg:justify-start"
                    >
                        <span class="mr-4 font-bold text-lg">GPA =</span>
                        <div
                            class="inline-flex flex-col items-center text-center"
                        >
                            <span
                                class="border-b-2 border-black pb-1 px-4 font-medium text-gray-800"
                                >{{
                                    $t(
                                        "Sum of (Grade Point × Credit Value of each studied subject)",
                                    )
                                }}</span
                            >
                            <span class="pt-1 px-4 font-medium text-gray-800">{{
                                $t(
                                    "Total sum of credit values for all studied subjects",
                                )
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <SiteFooter />
    </div>
</template>
