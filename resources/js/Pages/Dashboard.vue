<script setup>
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted, watch, computed } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import ducLogo from '@/Components/path/to/duc-logo.png';
import AdminSidebar from '@/Components/AdminSidebar.vue';

const props = defineProps({
    navigationItems: Array,
    pageContents: Array,
    events: Array,
    faculties: Array,
    settings: Object,
    homeSettings: Object,
    contactSettings: Object,
    translationsData: Array,
    activityLogs: Array
});

const showFullLogsModal = ref(false);

const page = usePage();
const activeTab = computed(() => {
    try {
        const search = page.url.includes('?') ? page.url.substring(page.url.indexOf('?')) : '';
        const urlParams = new URLSearchParams(search);
        return urlParams.get('tab') || 'overview';
    } catch(e) {
        return 'overview';
    }
});

// Dark Mode Toggle State
const isDarkMode = ref(true);

onMounted(() => {
    const savedMode = localStorage.getItem('duc_dashboard_mode');
    if (savedMode !== null) {
        isDarkMode.value = savedMode === 'true';
    }
    
    // Auto-restore active selected page slug on mount or refresh
    try {
        const savedSlug = localStorage.getItem('duc_admin_selected_page_slug');
        if (savedSlug && props.pageContents) {
            const pageToRestore = props.pageContents.find(p => p.slug === savedSlug);
            if (pageToRestore) {
                startEditPage(pageToRestore);
            }
        }
    } catch (e) {}
});

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('duc_dashboard_mode', isDarkMode.value.toString());
};

// Logout Helper
const logout = () => {
    showConfirm(
        'Are you sure you want to securely log out of the admin console?',
        () => {
            localStorage.removeItem('duc_user_email');
            localStorage.removeItem('duc_user_logged_in');
            router.post(route('logout'));
        },
        'Confirm Log Out',
        'Log Out',
        'warning'
    );
};

// Events Search State
const eventsSearchQuery = ref("");
const eventsDateFilter = ref("");
const monthNames = [
    'january','february','march','april','may','june',
    'july','august','september','october','november','december'
];

const filteredAdminEvents = computed(() => {
    if (!props.events) return [];
    const q = eventsSearchQuery.value.toLowerCase().trim();
    const dateVal = eventsDateFilter.value;
    if (!q && !dateVal) return props.events;

    let parsedDay = '', parsedMonth = '', parsedYear = '';
    if (dateVal) {
        const parts = dateVal.split('-');
        if (parts.length === 3) {
            parsedYear = parts[0];
            parsedMonth = monthNames[parseInt(parts[1], 10) - 1] || '';
            parsedDay = String(parseInt(parts[2], 10));
        }
    }

    const numericQuery = q.replace(/\D/g, '');

    return props.events.filter(event => {
        const titleEn = (event.title?.en || (typeof event.title === 'string' ? event.title : '')).toLowerCase();
        const titleKm = (event.title?.km || '').toLowerCase();
        const dateEn = (event.date?.en || (typeof event.date === 'string' ? event.date : '')).toLowerCase();
        const dateKm = (event.date?.km || '').toLowerCase();

        const matchesSearch = q && (
            titleEn.includes(q) || titleKm.includes(q) ||
            dateEn.includes(q) || dateKm.includes(q) ||
            (numericQuery && (
                dateEn.replace(/\D/g, '').includes(numericQuery) ||
                dateKm.replace(/\D/g, '').includes(numericQuery)
            ))
        );

        const matchesDate = dateVal && (
            (parsedYear && parsedMonth && parsedDay && (
                (dateEn.includes(parsedDay) && dateEn.includes(parsedMonth) && dateEn.includes(parsedYear)) ||
                (dateKm.includes(parsedDay) && dateKm.includes(parsedMonth) && dateKm.includes(parsedYear))
            )) ||
            dateEn.includes(dateVal) ||
            dateKm.includes(dateVal)
        );

        if (q && dateVal) return matchesSearch && matchesDate;
        if (q) return matchesSearch;
        return matchesDate;
    });
});

const eventsCurrentPage = ref(1);
const eventsItemsPerPage = 6;

watch([eventsSearchQuery, eventsDateFilter], () => {
    eventsCurrentPage.value = 1;
});

const eventsTotalPages = computed(() => {
    return Math.ceil(filteredAdminEvents.value.length / eventsItemsPerPage);
});

const eventsVisiblePages = computed(() => {
    const total = eventsTotalPages.value;
    const current = eventsCurrentPage.value;
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

const paginatedAdminEvents = computed(() => {
    const start = (eventsCurrentPage.value - 1) * eventsItemsPerPage;
    return filteredAdminEvents.value.slice(start, start + eventsItemsPerPage);
});

const eventsNextPage = () => {
    if (eventsCurrentPage.value < eventsTotalPages.value) {
        eventsCurrentPage.value++;
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

const eventsPrevPage = () => {
    if (eventsCurrentPage.value > 1) {
        eventsCurrentPage.value--;
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

const eventsGoToPage = (page) => {
    eventsCurrentPage.value = page;
    window.scrollTo({ top: 0, behavior: "smooth" });
};

// --- CUSTOM ALERTS & MODAL CONFIRMATION STATES ---
const toast = ref({
    show: false,
    message: '',
    type: 'success'
});

const showToast = (message, type = 'success') => {
    toast.value.message = message;
    toast.value.type = type;
    toast.value.show = true;
    setTimeout(() => {
        toast.value.show = false;
    }, 3000);
};

const confirmModal = ref({
    show: false,
    message: '',
    title: '',
    confirmText: 'Confirm',
    type: 'danger',
    onConfirm: null
});

const showConfirm = (message, onConfirmCallback, title = 'Confirm Action', confirmText = 'Yes, Delete', type = 'danger') => {
    confirmModal.value = {
        show: true,
        message,
        title,
        confirmText,
        type,
        onConfirm: () => {
            confirmModal.value.show = false;
            if (typeof onConfirmCallback === 'function') {
                onConfirmCallback();
            }
        }
    };
};

// --- CMS ACTIVITY LOGS (MOCK DATA FOR HIGH-FIDELITY LAYOUT) ---
const recentActivities = ref([
    { type: 'page', title: 'Rector Message Page Updated', user: 'Admin', time: '5 mins ago', iconClass: 'bg-indigo-500/10 text-indigo-400' },
    { type: 'nav', title: 'Navigation menu re-ordered', user: 'Admin', time: '1 hour ago', iconClass: 'bg-blue-500/10 text-blue-400' },
    { type: 'event', title: 'New Event published: AI Hackathon 2026', user: 'Admin', time: '3 hours ago', iconClass: 'bg-amber-500/10 text-amber-400' },
    { type: 'settings', title: 'Direct telephone lines updated', user: 'System', time: 'Yesterday', iconClass: 'bg-emerald-500/10 text-emerald-400' }
]);

// Helper for resolving translatable database columns (stored as JSON or raw string)
const parseTranslatable = (val) => {
    if (val && typeof val === 'object') {
        return { en: val.en || '', km: val.km || '' };
    }
    if (typeof val === 'string' && val.trim()) {
        try {
            const parsed = JSON.parse(val);
            if (parsed && typeof parsed === 'object') {
                return { en: parsed.en || '', km: parsed.km || '' };
            }
        } catch(e) {}
        return { en: val, km: '' };
    }
    return { en: '', km: '' };
};

// --- NAVIGATION STATE & ACTIONS ---
const editingNavItem = ref(null);
const navItemForm = useForm({
    id: null,
    label: { en: '', km: '' },
    href: '',
    icon: '',
    parent_id: '',
    order: 0
});

const startEditNavItem = (item) => {
    editingNavItem.value = item.id;
    navItemForm.id = item.id;
    navItemForm.label = parseTranslatable(item.label);
    navItemForm.href = item.href || '';
    navItemForm.icon = item.icon || '';
    navItemForm.parent_id = item.parent_id || '';
    navItemForm.order = item.order || 0;
};

const cancelEditNavItem = () => {
    editingNavItem.value = null;
    navItemForm.reset();
    navItemForm.label = { en: '', km: '' };
};

const submitNavItem = () => {
    navItemForm.post(route('admin.navigation.save'), {
        onSuccess: () => {
            cancelEditNavItem();
            showToast('Navigation saved successfully!');
        }
    });
};

const deleteNavItem = (id) => {
    showConfirm(
        'Are you sure you want to delete this navigation item? All sub-menus will be disconnected.',
        () => {
            navItemForm.delete(route('admin.navigation.delete', id), {
                onSuccess: () => showToast('Navigation item deleted successfully!')
            });
        },
        'Delete Navigation Item'
    );
};

// --- PAGES STATE & ACTIONS ---
const selectedPage = ref(null);
const pagesSearchQuery = ref('');
const filteredPageContents = computed(() => {
    if (!props.pageContents) return [];
    const q = pagesSearchQuery.value.toLowerCase().trim();
    if (!q) return props.pageContents;
    return props.pageContents.filter(p => {
        const title = (p.title || '').toLowerCase();
        const slug = (p.slug || '').toLowerCase();
        return title.includes(q) || slug.includes(q);
    });
});
const pageContentForm = useForm({
    id: null,
    slug: '',
    title: '',
    content: {},
    is_office: false,
    office_type: '',
    apply_to_all_offices: false
});


const startEditPage = (page) => {
    selectedPage.value = page;
    try {
        if (page && page.slug) {
            localStorage.setItem('duc_admin_selected_page_slug', page.slug);
        }
    } catch (e) {}
    pageContentForm.id = page.id;
    pageContentForm.slug = page.slug;
    pageContentForm.title = parseTranslatable(page.title);
    // Handle content being a JSON string or already an object
    if (typeof page.content === 'string') {
        try {
            pageContentForm.content = JSON.parse(page.content);
        } catch (e) {
            console.error('Failed to parse page content JSON:', e);
            pageContentForm.content = {};
        }
    } else {
        pageContentForm.content = page.content || {};
    }
    pageContentForm.is_office = !!page.is_office;
    pageContentForm.office_type = page.office_type || '';
    
    // Use slug (stable across delete+restore) instead of id to determine page type
    if (page.slug === 'rector') {
        pageContentForm.content.rector_name = parseTranslatable(pageContentForm.content.rector_name);
        pageContentForm.content.rector_title = parseTranslatable(pageContentForm.content.rector_title);
        
        let existingEn = pageContentForm.content.paragraphs_en || pageContentForm.content.paragraphs || [];
        pageContentForm.content.paragraphs_en = Array.isArray(existingEn) ? existingEn.map(p => `<p>${p}</p>`).join('') : existingEn;
        
        let existingKm = pageContentForm.content.paragraphs_km || [];
        pageContentForm.content.paragraphs_km = Array.isArray(existingKm) ? existingKm.map(p => `<p>${p}</p>`).join('') : existingKm;
    } else if (page.slug === 'about') {
        pageContentForm.content.history = parseTranslatable(pageContentForm.content.history);
        pageContentForm.content.mission = parseTranslatable(pageContentForm.content.mission);
        pageContentForm.content.vision = parseTranslatable(pageContentForm.content.vision);
        pageContentForm.content.goals = (pageContentForm.content.goals || []).map(g => parseTranslatable(g));
        pageContentForm.content.custom_sections = (pageContentForm.content.custom_sections || []).map(sec => ({
            title: parseTranslatable(sec.title),
            content: parseTranslatable(sec.content)
        }));
    } else if (page.slug === 'exam-evaluation') {
        pageContentForm.content.intro = parseTranslatable(pageContentForm.content.intro);
        pageContentForm.content.breakdown = (pageContentForm.content.breakdown || []).map(b => ({
            criteria: parseTranslatable(b.criteria),
            percentage: b.percentage || ''
        }));
        pageContentForm.content.grades = (pageContentForm.content.grades || []).map(g => ({
            score: g.score || '',
            letter: g.letter || '',
            points: g.points || '',
            description: parseTranslatable(g.description)
        }));
    } else if (pageContentForm.is_office) {
        pageContentForm.content.subtitle = parseTranslatable(pageContentForm.content.subtitle);
        
        // Default title font size to 30px if not set
        if (!pageContentForm.content.title_font_size) {
            pageContentForm.content.title_font_size = 'text-2xl sm:text-3xl lg:text-4xl';
        }
        
        let customSections = pageContentForm.content.custom_sections || [];
        
        // Migrate legacy data if no custom sections exist
        if (customSections.length === 0) {
            let about = parseTranslatable(pageContentForm.content.about);
            let mission = parseTranslatable(pageContentForm.content.mission);
            let vision = parseTranslatable(pageContentForm.content.vision);
            
            if (about.en || about.km) {
                customSections.push({ title: { en: 'About', km: 'អំពី' }, content: about });
            }
            if (mission.en || mission.km) {
                customSections.push({ title: { en: 'Mission', km: 'បេសកកម្ម' }, content: mission });
            }
            if (vision.en || vision.km) {
                customSections.push({ title: { en: 'Vision', km: 'ចក្ខុវិស័យ' }, content: vision });
            }
            
            // Remove legacy keys
            delete pageContentForm.content.about;
            delete pageContentForm.content.mission;
            delete pageContentForm.content.vision;
        } else {
            customSections = customSections.map(sec => ({
                title: parseTranslatable(sec.title),
                content: parseTranslatable(sec.content)
            }));
        }
        
        pageContentForm.content.custom_sections = customSections;
    } else {
        pageContentForm.content.custom_sections = (pageContentForm.content.custom_sections || []).map(sec => ({
            title: parseTranslatable(sec.title),
            content: parseTranslatable(sec.content)
        }));
    }
};

watch(() => props.pageContents, (newPages) => {
    if (selectedPage.value && !pageContentForm.isDirty) {
        const targetSlug = selectedPage.value.slug;
        const targetId = selectedPage.value.id;
        // Prefer slug match (stable after delete+restore which can change ID)
        const freshPage = newPages.find(p => (targetSlug && p.slug === targetSlug) || (targetId && p.id === targetId));
        if (freshPage) {
            startEditPage(freshPage);
        }
    }
}, { deep: true });

const startCreatePage = (type) => {
    selectedPage.value = { 
        id: null, 
        title: { en: type === 'office' ? 'New Office' : 'New Page', km: type === 'office' ? 'ការិយាល័យថ្មី' : 'ទំព័រថ្មី' }, 
        slug: '', 
        is_office: type === 'office',
        content: type === 'office' 
            ? { subtitle: { en: '', km: '' }, about: { en: '', km: '' }, mission: { en: '', km: '' }, vision: { en: '', km: '' }, image: '' } 
            : { custom_sections: [] }
    };
    
    pageContentForm.id = null;
    pageContentForm.title = JSON.parse(JSON.stringify(selectedPage.value.title));
    pageContentForm.slug = '';
    pageContentForm.is_office = type === 'office';
    pageContentForm.office_type = '';
    pageContentForm.content = JSON.parse(JSON.stringify(selectedPage.value.content));
};



const submitPage = () => {
    pageContentForm.post(route('admin.pages.save'), {
        preserveScroll: true,
        onSuccess: () => {
            showToast('Page saved successfully!');
            pageContentForm.apply_to_all_offices = false;
        },
        onError: (errors) => {
            console.error('Page save failed:', errors);
            const firstError = Object.values(errors)[0] || 'Failed to save page content.';
            showToast(firstError, 'error');
        }
    });
};

const confirmDeletePage = (page) => {
    showConfirm(
        `Are you sure you want to delete <span class="font-bold text-slate-700 dark:text-slate-300">"${page.title}"</span>? This action cannot be undone.`,
        () => {
            router.delete(route('admin.pages.delete', page.id), {
                onSuccess: () => {
                    selectedPage.value = null;
                    showToast('Page deleted successfully!');
                }
            });
        },
        'Delete Page?'
    );
};

// Helper for About page goals list
const addAboutGoal = () => {
    if (!pageContentForm.content.goals) pageContentForm.content.goals = [];
    pageContentForm.content.goals.push({ en: '', km: '' });
};
const removeAboutGoal = (idx) => {
    if (pageContentForm.content && pageContentForm.content.goals) {
        pageContentForm.content.goals.splice(idx, 1);
    }
};
const moveAboutGoalUp = (idx) => {
    if (pageContentForm.content.goals && idx > 0) {
        const temp = pageContentForm.content.goals[idx];
        pageContentForm.content.goals[idx] = pageContentForm.content.goals[idx - 1];
        pageContentForm.content.goals[idx - 1] = temp;
    }
};
const moveAboutGoalDown = (idx) => {
    if (pageContentForm.content.goals && idx < pageContentForm.content.goals.length - 1) {
        const temp = pageContentForm.content.goals[idx];
        pageContentForm.content.goals[idx] = pageContentForm.content.goals[idx + 1];
        pageContentForm.content.goals[idx + 1] = temp;
    }
};

const toggleVisionFirst = () => {
    if (!pageContentForm.content) pageContentForm.content = {};
    pageContentForm.content.vision_first = !pageContentForm.content.vision_first;
};

// Helper to add custom section
const addCustomSection = () => {
    if (!pageContentForm.content.custom_sections) {
        pageContentForm.content.custom_sections = [];
    }
    pageContentForm.content.custom_sections.push({ title: { en: '', km: '' }, content: { en: '', km: '' } });
};

// Helper to remove custom section
const removeCustomSection = (idx) => {
    if (pageContentForm.content.custom_sections) {
        pageContentForm.content.custom_sections.splice(idx, 1);
    }
};

// Helpers to move custom section up/down
const moveCustomSectionUp = (idx) => {
    if (pageContentForm.content.custom_sections && idx > 0) {
        const temp = pageContentForm.content.custom_sections[idx];
        pageContentForm.content.custom_sections[idx] = pageContentForm.content.custom_sections[idx - 1];
        pageContentForm.content.custom_sections[idx - 1] = temp;
    }
};

const moveCustomSectionDown = (idx) => {
    if (pageContentForm.content.custom_sections && idx < pageContentForm.content.custom_sections.length - 1) {
        const temp = pageContentForm.content.custom_sections[idx];
        pageContentForm.content.custom_sections[idx] = pageContentForm.content.custom_sections[idx + 1];
        pageContentForm.content.custom_sections[idx + 1] = temp;
    }
};

const addFacultyCustomSection = () => {
    if (!facultyForm.custom_sections) {
        facultyForm.custom_sections = [];
    }
    facultyForm.custom_sections.push({ title: { en: '', km: '' }, content: { en: '', km: '' } });
};
const removeFacultyCustomSection = (idx) => {
    if (facultyForm.custom_sections) {
        facultyForm.custom_sections.splice(idx, 1);
    }
};

const addDeptCustomSection = () => {
    if (!deptForm.custom_sections) {
        deptForm.custom_sections = [];
    }
    deptForm.custom_sections.push({ title: { en: '', km: '' }, content: { en: '', km: '' } });
};
const removeDeptCustomSection = (idx) => {
    if (deptForm.custom_sections) {
        deptForm.custom_sections.splice(idx, 1);
    }
};

const getEmptyProgramObj = () => ({
    sections: [
        { type: 'richtext', title: { en: '1. Program Aim', km: '1. គោលបំណងកម្មវិធី' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] },
        { type: 'richtext', title: { en: '2. Program Learning Outcomes (PLOs)', km: '2. លទ្ធផលសិក្សា (PLOs)' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] },
        { type: 'richtext', title: { en: '3. Terms of Admission', km: '3. លក្ខខណ្ឌនៃការចូលរៀន' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] },
        { type: 'richtext', title: { en: '4. Total Credits', km: '4. ចំនួនក្រេឌីតសរុប' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] },
        { type: 'course_structure', title: { en: '5. Course Structure', km: '5. រចនាសម្ព័ន្ធកម្មវិធីសិក្សា' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] },
        { type: 'richtext', title: { en: '6. Graduation Requirements', km: '6. លក្ខខណ្ឌនៃការបញ្ចប់ការសិក្សា' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] },
        { type: 'richtext', title: { en: '7. Degree Title Awarded', km: '7. ចំណងជើងសញ្ញាបត្រ' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] },
        { type: 'richtext', title: { en: '8. Career Opportunities', km: '8. ឱកាសការងារ' }, content: { en: '', km: '' }, courseStructure: [], courseNotes: [] }
    ]
});

const addProgramSection = (majorIdx, programType) => {
    deptForm.majors[majorIdx].programs[programType].sections.push({
        type: 'richtext',
        title: { en: '', km: '' },
        content: { en: '', km: '' },
        courseStructure: [],
        courseNotes: [],
        customTable: {
            headers: [
                { key: 'col_0', label: { en: 'Header 1', km: 'ចំណងជើង ១' } },
                { key: 'col_1', label: { en: 'Header 2', km: 'ចំណងជើង ២' } }
            ],
            rows: [
                { col_0: { en: '', km: '' }, col_1: { en: '', km: '' } }
            ]
        }
    });
};

const removeProgramSection = (majorIdx, programType, sectionIdx) => {
    deptForm.majors[majorIdx].programs[programType].sections.splice(sectionIdx, 1);
};

const moveProgramSectionUp = (majorIdx, programType, sectionIdx) => {
    if (sectionIdx === 0) return;
    const sections = deptForm.majors[majorIdx].programs[programType].sections;
    const temp = sections[sectionIdx];
    sections[sectionIdx] = sections[sectionIdx - 1];
    sections[sectionIdx - 1] = temp;
};

const moveProgramSectionDown = (majorIdx, programType, sectionIdx) => {
    const sections = deptForm.majors[majorIdx].programs[programType].sections;
    if (sectionIdx === sections.length - 1) return;
    const temp = sections[sectionIdx];
    sections[sectionIdx] = sections[sectionIdx + 1];
    sections[sectionIdx + 1] = temp;
};

const addCourseYear = (section) => {
    if (!section.courseStructure) section.courseStructure = [];
    section.courseStructure.push({
        year: { en: 'Year I', km: 'ឆ្នាំទី ១' },
        semesters: []
    });
};

const ensureCustomTable = (section) => {
    if (!section.customTable) {
        section.customTable = {
            badge: { en: '', km: '' },
            subtitle: { en: '', km: '' },
            footerNote: { en: '', km: '' },
            showRowNumbers: true,
            headers: [
                { key: 'col_0', label: { en: 'Header 1', km: 'ចំណងជើង ១' }, headerAlign: 'center', bodyAlign: 'left', verticalAlign: 'top', width: 'auto' },
                { key: 'col_1', label: { en: 'Header 2', km: 'ចំណងជើង ២' }, headerAlign: 'center', bodyAlign: 'left', verticalAlign: 'top', width: 'auto' }
            ],
            rows: [
                { col_0: { en: '', km: '' }, col_1: { en: '', km: '' } }
            ]
        };
    } else {
        if (!section.customTable.badge) section.customTable.badge = { en: '', km: '' };
        if (!section.customTable.subtitle) section.customTable.subtitle = { en: '', km: '' };
        if (!section.customTable.footerNote) section.customTable.footerNote = { en: '', km: '' };
        if (typeof section.customTable.indexHeader === 'object' && section.customTable.indexHeader !== null) {
            section.customTable.indexHeader = section.customTable.indexHeader.en || section.customTable.indexHeader.km || '#';
        }
        if (!section.customTable.indexHeader) section.customTable.indexHeader = '#';
        if (section.customTable.showRowNumbers === undefined) section.customTable.showRowNumbers = true;
        if (section.customTable.headers) {
            section.customTable.headers.forEach(h => {
                if (!h.headerAlign) h.headerAlign = h.align || 'center';
                if (!h.bodyAlign) h.bodyAlign = h.align || 'left';
                if (!h.verticalAlign) h.verticalAlign = 'top';
                if (!h.width) h.width = 'auto';
            });
        }
    }
};

const addCustomTableColumn = (section) => {
    ensureCustomTable(section);
    const nextIdx = section.customTable.headers.length;
    const newKey = `col_${Date.now()}_${nextIdx}`;
    section.customTable.headers.push({
        key: newKey,
        label: { en: `Header ${nextIdx + 1}`, km: `ចំណងជើង ${nextIdx + 1}` },
        headerAlign: 'center',
        bodyAlign: 'left',
        verticalAlign: 'top',
        width: 'auto'
    });
    section.customTable.rows.forEach(row => {
        row[newKey] = { en: '', km: '' };
    });
};

const removeCustomTableColumn = (section, colIdx) => {
    ensureCustomTable(section);
    if (section.customTable.headers.length <= 1) return;
    const keyToRemove = section.customTable.headers[colIdx].key;
    section.customTable.headers.splice(colIdx, 1);
    section.customTable.rows.forEach(row => {
        delete row[keyToRemove];
    });
};

const setAllHeaderAlign = (section, align) => {
    ensureCustomTable(section);
    section.customTable.headers.forEach(h => {
        h.headerAlign = align;
    });
};

const setAllBodyAlign = (section, align) => {
    ensureCustomTable(section);
    section.customTable.headers.forEach(h => {
        h.bodyAlign = align;
    });
};

const setAllVerticalAlign = (section, valign) => {
    ensureCustomTable(section);
    section.customTable.headers.forEach(h => {
        h.verticalAlign = valign;
    });
};

const removeCustomTable = (section) => {
    section.customTable = {
        badge: { en: '', km: '' },
        subtitle: { en: '', km: '' },
        footerNote: { en: '', km: '' },
        showRowNumbers: true,
        headers: [
            { key: 'col_0', label: { en: 'Header 1', km: 'ចំណងជើង ១' }, headerAlign: 'center', bodyAlign: 'left', verticalAlign: 'top', width: 'auto' },
            { key: 'col_1', label: { en: 'Header 2', km: 'ចំណងជើង ២' }, headerAlign: 'center', bodyAlign: 'left', verticalAlign: 'top', width: 'auto' }
        ],
        rows: [
            { col_0: { en: '', km: '' }, col_1: { en: '', km: '' } }
        ]
    };
};

const moveCustomTableColumn = (section, colIdx, dir) => {
    ensureCustomTable(section);
    const headers = section.customTable.headers;
    const targetIdx = colIdx + dir;
    if (targetIdx < 0 || targetIdx >= headers.length) return;
    const temp = headers[colIdx];
    headers[colIdx] = headers[targetIdx];
    headers[targetIdx] = temp;
};

const addCustomTableRow = (section) => {
    ensureCustomTable(section);
    const newRow = {};
    section.customTable.headers.forEach(h => {
        newRow[h.key] = { en: '', km: '' };
    });
    section.customTable.rows.push(newRow);
};

const insertCustomTableRowAt = (section, targetIdx) => {
    ensureCustomTable(section);
    const newRow = {};
    section.customTable.headers.forEach(h => {
        newRow[h.key] = { en: '', km: '' };
    });
    section.customTable.rows.splice(targetIdx, 0, newRow);
};

const insertCustomTableColumnAt = (section, targetIdx) => {
    ensureCustomTable(section);
    const nextIdx = section.customTable.headers.length;
    const newKey = `col_${Date.now()}_${nextIdx}`;
    const newCol = {
        key: newKey,
        label: { en: `Header ${nextIdx + 1}`, km: `ចំណងជើង ${nextIdx + 1}` },
        headerAlign: 'center',
        bodyAlign: 'left',
        verticalAlign: 'top',
        width: 'auto'
    };
    section.customTable.headers.splice(targetIdx, 0, newCol);
    section.customTable.rows.forEach(row => {
        row[newKey] = { en: '', km: '' };
    });
};

const removeCustomTableRow = (section, rowIdx) => {
    ensureCustomTable(section);
    if (section.customTable.rows.length <= 1) return;
    section.customTable.rows.splice(rowIdx, 1);
};

const moveCustomTableRow = (section, rowIdx, dir) => {
    ensureCustomTable(section);
    const rows = section.customTable.rows;
    const targetIdx = rowIdx + dir;
    if (targetIdx < 0 || targetIdx >= rows.length) return;
    const temp = rows[rowIdx];
    rows[rowIdx] = rows[targetIdx];
    rows[targetIdx] = temp;
};

const sanitizeExcelModeData = (section) => {
    if (!section || !section.customTable || !section.customTable.rows) return;
    section.customTable.rows.forEach(row => {
        Object.keys(row).forEach(k => {
            if (row[k]) {
                if (typeof row[k].en === 'string' && row[k].en.includes('<')) {
                    row[k].en = stripHtml(row[k].en);
                }
                if (typeof row[k].km === 'string' && row[k].km.includes('<')) {
                    row[k].km = stripHtml(row[k].km);
                }
            }
        });
    });
};

const setExcelEditorMode = (section, mode) => {
    ensureCustomTable(section);
    section.customTable.editorMode = mode;
    if (mode === 'excel') {
        sanitizeExcelModeData(section);
    }
};

const handleExcelCellPaste = (event, section, startRowIdx, startHeadKey) => {
    const clipboardData = event.clipboardData || window.clipboardData;
    if (!clipboardData) return;
    let text = clipboardData.getData('text/plain') || clipboardData.getData('text');
    if (!text) return;
    
    if (text.includes('\t') || text.includes('\n')) {
        event.preventDefault();
        const rows = text.trim().split(/\r?\n/).map(r => r.split('\t'));
        ensureCustomTable(section);
        
        const headKeys = section.customTable.headers.map(h => h.key);
        const startColIdx = headKeys.indexOf(startHeadKey);
        if (startColIdx === -1) return;

        rows.forEach((rowCells, rOffset) => {
            const targetRowIdx = startRowIdx + rOffset;
            while (section.customTable.rows.length <= targetRowIdx) {
                const newRow = {};
                headKeys.forEach(k => { newRow[k] = { en: '', km: '' }; });
                section.customTable.rows.push(newRow);
            }
            const targetRow = section.customTable.rows[targetRowIdx];

            rowCells.forEach((cellVal, cOffset) => {
                const targetColIdx = startColIdx + cOffset;
                if (targetColIdx < headKeys.length) {
                    const key = headKeys[targetColIdx];
                    if (!targetRow[key]) targetRow[key] = { en: '', km: '' };
                    const formatted = stripHtml(cellVal.trim());
                    targetRow[key].en = formatted;
                    targetRow[key].km = formatted;
                }
            });
        });
    }
};

const activeCustomTableSmartPasteSection = ref(null);
const customTableSmartPasteText = ref('');
const customTableSmartPasteHasHeader = ref(true);

const openCustomTableSmartPaste = (section) => {
    activeCustomTableSmartPasteSection.value = section;
    customTableSmartPasteText.value = '';
    customTableSmartPasteHasHeader.value = true;
};

const parseWordExcelTSV = (text) => {
    if (text.includes('\t')) {
        const rows = [];
        let currentRow = [];
        let currentCell = '';
        let inQuotes = false;
        
        for (let i = 0; i < text.length; i++) {
            const char = text[i];
            const nextChar = text[i + 1];
            
            if (char === '"') {
                if (inQuotes && nextChar === '"') {
                    currentCell += '"';
                    i++;
                } else {
                    inQuotes = !inQuotes;
                }
            } else if (char === '\t' && !inQuotes) {
                currentRow.push(currentCell.trim());
                currentCell = '';
            } else if ((char === '\r' || char === '\n') && !inQuotes) {
                if (char === '\r' && nextChar === '\n') i++;
                currentRow.push(currentCell.trim());
                if (currentRow.some(c => c.length > 0)) {
                    rows.push(currentRow);
                }
                currentRow = [];
                currentCell = '';
            } else {
                currentCell += char;
            }
        }
        if (currentCell.trim().length > 0 || currentRow.length > 0) {
            currentRow.push(currentCell.trim());
            if (currentRow.some(c => c.length > 0)) {
                rows.push(currentRow);
            }
        }
        return rows;
    }
    
    const lines = text.trim().split('\n').filter(l => l.trim().length > 0);
    return lines.map(line => {
        if (line.includes('|')) return line.split('|').map(c => c.trim()).filter(c => c.length > 0);
        return [line.trim()];
    });
};

const executeCustomTableSmartPaste = () => {
    const section = activeCustomTableSmartPasteSection.value;
    if (!section || !customTableSmartPasteText.value.trim()) return;
    ensureCustomTable(section);
    
    const text = customTableSmartPasteText.value.trim();
    
    // 1. Column-based list paste detector (tab separated multiline columns)
    if (text.includes('\t')) {
        const rawBlocks = text.split('\t').map(b => b.trim()).filter(b => b.length > 0);
        
        // Check if blocks represent multiline subject columns
        if (rawBlocks.length >= 2) {
            const hasMultilineBlocks = rawBlocks.some(b => b.includes('\n'));
            if (hasMultilineBlocks) {
                const headers = [];
                const rowValues = {};
                
                rawBlocks.forEach((block, idx) => {
                    const key = `col_${Date.now()}_${idx}`;
                    const lines = block.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0);
                    
                    let headerText = `Header ${idx + 1}`;
                    let bodyLines = [];
                    
                    // Find where bullet list starts (- or • or digit)
                    const bulletIdx = lines.findIndex(l => l.startsWith('-') || l.startsWith('•') || /^\d+[\.\)]/.test(l));
                    if (bulletIdx > 0) {
                        headerText = lines.slice(0, bulletIdx).join(' ');
                        bodyLines = lines.slice(bulletIdx);
                    } else if (bulletIdx === 0) {
                        headerText = `Header ${idx + 1}`;
                        bodyLines = lines;
                    } else if (lines.length > 0) {
                        headerText = lines[0];
                        bodyLines = lines.slice(1);
                    }
                    
                    headers.push({
                        key,
                        label: { en: headerText, km: headerText },
                        align: 'left',
                        width: 'auto'
                    });
                    
                    let bodyText = '';
                    if (bodyLines.length > 0) {
                        const isBulletList = bodyLines.some(l => l.startsWith('-') || l.startsWith('•') || /^\d+[\.\)]/.test(l));
                        if (isBulletList) {
                            const lis = bodyLines.map(l => {
                                const clean = l.replace(/^[-•\d+\.\)]\s*/, '').trim();
                                return clean ? `<li>${clean}</li>` : '';
                            }).filter(l => l.length > 0).join('');
                            bodyText = `<ul>${lis}</ul>`;
                        } else {
                            bodyText = bodyLines.map(l => `<p>${l}</p>`).join('');
                        }
                    }
                    rowValues[key] = { en: bodyText, km: bodyText };
                });
                
                section.customTable.headers = headers;
                section.customTable.rows = [rowValues];
                
                activeCustomTableSmartPasteSection.value = null;
                customTableSmartPasteText.value = '';
                return;
            }
        }
    }
    
    // 2. Standard 2D Grid / CSV / TSV fallback
    const parsedRows = parseWordExcelTSV(text);
    if (parsedRows.length === 0) return;
    
    let startRowIdx = 0;
    let headers = [];
    
    if (customTableSmartPasteHasHeader.value && parsedRows.length > 0) {
        const headerCells = parsedRows[0];
        headers = headerCells.map((label, idx) => {
            const cleanLabel = label.replace(/\r?\n|\r/g, ' ').trim();
            return {
                key: `col_${Date.now()}_${idx}`,
                label: { en: cleanLabel, km: cleanLabel },
                align: 'left',
                width: 'auto'
            };
        });
        startRowIdx = 1;
    } else {
        const maxCols = Math.max(...parsedRows.map(r => r.length));
        for (let i = 0; i < maxCols; i++) {
            headers.push({
                key: `col_${Date.now()}_${i}`,
                label: { en: `Header ${i + 1}`, km: `ចំណងជើង ${i + 1}` },
                align: 'left',
                width: 'auto'
            });
        }
    }
    
    const rows = [];
    for (let r = startRowIdx; r < parsedRows.length; r++) {
        const cells = parsedRows[r];
        const rowObj = {};
        headers.forEach((h, cIdx) => {
            const val = cells[cIdx] !== undefined ? cells[cIdx] : '';
            rowObj[h.key] = { en: val, km: val };
        });
        rows.push(rowObj);
    }
    
    section.customTable.headers = headers;
    section.customTable.rows = rows.length > 0 ? rows : [{ [headers[0].key]: { en: '', km: '' } }];
    
    activeCustomTableSmartPasteSection.value = null;
    customTableSmartPasteText.value = '';
};

const removeCourseYear = (section, yearIdx) => {
    section.courseStructure.splice(yearIdx, 1);
};

const addCourseSemester = (year) => {
    if (!year.semesters) year.semesters = [];
    year.semesters.push({
        semester: { en: 'Semester I', km: 'ឆមាសទី ១' },
        subjects: []
    });
};

const removeCourseSemester = (year, semIdx) => {
    year.semesters.splice(semIdx, 1);
};

const addCourseSubject = (semester) => {
    if (!semester.subjects) semester.subjects = [];
    semester.subjects.push({
        no: semester.subjects.length + 1,
        name: { en: '', km: '' },
        credits: 3,
        hours: 45
    });
};
const activeSmartImportYear = ref(null);
const activeSmartImportSemester = ref(null);
const smartImportText = ref('');

const openSmartImport = (year, semester) => {
    activeSmartImportYear.value = year;
    activeSmartImportSemester.value = semester;
    smartImportText.value = '';
};

const parseSmartPasteTSV = (text) => {
    const rows = [];
    let currentRow = [];
    let currentCell = '';
    let inQuotes = false;
    
    for (let i = 0; i < text.length; i++) {
        const char = text[i];
        const nextChar = text[i+1];
        
        if (inQuotes) {
            if (char === '"' && nextChar === '"') {
                currentCell += '"';
                i++;
            } else if (char === '"') {
                inQuotes = false;
            } else {
                currentCell += char;
            }
        } else {
            if (char === '"' && currentCell.trim() === '') {
                inQuotes = true;
                currentCell = ''; 
            } else if (char === '\t') {
                currentRow.push(currentCell.replace(/[\r\n]+/g, ' ').trim());
                currentCell = '';
            } else if (char === '\n' || (char === '\r' && nextChar === '\n')) {
                if (char === '\r') i++;
                currentRow.push(currentCell.replace(/[\r\n]+/g, ' ').trim());
                rows.push(currentRow);
                currentRow = [];
                currentCell = '';
            } else if (char !== '\r') {
                currentCell += char;
            }
        }
    }
    
    if (currentCell !== '' || currentRow.length > 0) {
        currentRow.push(currentCell.replace(/[\r\n]+/g, ' ').trim());
        rows.push(currentRow);
    }
    
    return rows.filter(row => row.some(cell => cell !== ''));
};

const processSmartPasteSide = (cols, targetSem, lastSubjRef) => {
    const cells = cols.map(c => c.trim().replace(/^"|"$/g, '').trim()).filter(c => c !== '');
    if (cells.length === 0) return lastSubjRef;
    
    const nums = cells.filter(c => !isNaN(parseFloat(c)));
    if (nums.length >= 2) {
        const hr = cells.pop();
        const cred = cells.pop();
        const subj = cells.join(' ').trim();
        
        if (subj && !subj.toLowerCase().includes('subject') && !subj.toLowerCase().includes('hour')) {
            if (!targetSem.subjects) targetSem.subjects = [];
            const newSubj = {
                no: targetSem.subjects.length + 1,
                name: { en: subj, km: subj },
                credits: cred,
                hours: hr
            };
            targetSem.subjects.push(newSubj);
            return newSubj;
        }
    } else {
        const text = cells.join(' ').trim();
        if (text && lastSubjRef && !text.toLowerCase().includes('subject') && !text.toLowerCase().includes('hour')) {
            lastSubjRef.name.en += ' ' + text;
            lastSubjRef.name.km += ' ' + text;
        }
    }
    return lastSubjRef;
    return lastSubjRef;
};

const translateHeaderKhmer = (text) => {
    if (!text) return text;
    
    const romanMap = {
        'i': 1, 'ii': 2, 'iii': 3, 'iv': 4, 'iiii': 4, 'v': 5, 
        'vi': 6, 'vii': 7, 'viii': 8, 'ix': 9, 'x': 10
    };
    
    const khmerNumbers = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩', '១០'];
    
    const getKhmerNum = (numStr) => {
        const lower = numStr.toLowerCase();
        let num = romanMap[lower];
        if (!num) num = parseInt(numStr);
        if (num && khmerNumbers[num]) return khmerNumbers[num];
        return numStr;
    };

    const yearMatch = text.match(/^year\s+([a-z0-9]+)$/i);
    if (yearMatch) {
        return 'ឆ្នាំទី ' + getKhmerNum(yearMatch[1]);
    }
    
    const semMatch = text.match(/^semester\s+([a-z0-9]+)$/i);
    if (semMatch) {
        return 'ឆមាសទី ' + getKhmerNum(semMatch[1]);
    }
    
    return null;
};

const executeSmartImport = () => {
    if (!activeSmartImportSemester.value || !smartImportText.value.trim()) return;
    
    const year = activeSmartImportYear.value;
    const sem = activeSmartImportSemester.value;
    const semIdx = year ? year.semesters.indexOf(sem) : 0;
    
    const rows = parseSmartPasteTSV(smartImportText.value);
    
    let lastLeft = null;
    let lastRight = null;
    
    for (const rawColumns of rows) {
        const leftCols = rawColumns.slice(0, 3);
        const rightCols = rawColumns.slice(3);
        
        lastLeft = processSmartPasteSide(leftCols, sem, lastLeft);
        
        let rightSem = year ? year.semesters[semIdx + 1] : null;
        if (rightCols.filter(c => c.trim() !== '').length > 0 && year && !rightSem) {
            year.semesters.push({ semester: { en: 'Semester II', km: 'ឆមាសទី ២' }, subjects: [] });
            rightSem = year.semesters[semIdx + 1];
        }
        if (rightSem) {
            lastRight = processSmartPasteSide(rightCols, rightSem, lastRight);
        }
    }
    
    activeSmartImportSemester.value = null;
    activeSmartImportYear.value = null;
    smartImportText.value = '';
};

const activeGlobalSmartImportSection = ref(null);
const globalSmartImportText = ref('');

const openGlobalSmartImport = (section) => {
    activeGlobalSmartImportSection.value = section;
    globalSmartImportText.value = '';
};

const executeGlobalSmartImport = () => {
    const section = activeGlobalSmartImportSection.value;
    if (!section || !globalSmartImportText.value.trim()) return;
    
    // Create entirely new curriculum array
    const newCourseStructure = [];
    let currentYear = null;
    let currentSem1 = null;
    let currentSem2 = null;
    
    const rows = parseSmartPasteTSV(globalSmartImportText.value);
    
    let lastLeft = null;
    let lastRight = null;
    
    for (const rawColumns of rows) {
        const trimmedLine = rawColumns.join(' ').trim();
        if (!trimmedLine) continue;
        
        // Detect "Year" header
        if (trimmedLine.toLowerCase().startsWith('year ') || (rawColumns[0] && rawColumns[0].toLowerCase().startsWith('year '))) {
            const yName = (rawColumns[0] && rawColumns[0].toLowerCase().startsWith('year ') ? rawColumns[0] : trimmedLine).trim();
            currentYear = {
                year: { en: yName, km: translateHeaderKhmer(yName) || yName },
                semesters: []
            };
            newCourseStructure.push(currentYear);
            lastLeft = null; lastRight = null;
            continue;
        }
        
        // Detect "Semester" header
        if (trimmedLine.toLowerCase().includes('semester')) {
            const parts = rawColumns.filter(c => c !== '').map(c => c.trim());
            if (!currentYear) {
                currentYear = { year: { en: 'Year 1', km: 'ឆ្នាំទី ១' }, semesters: [] };
                newCourseStructure.push(currentYear);
            }
            
            currentYear.semesters = [];
            const sem1Name = parts[0] || 'Semester I';
            currentSem1 = { semester: { en: sem1Name, km: translateHeaderKhmer(sem1Name) || sem1Name }, subjects: [] };
            currentYear.semesters.push(currentSem1);
            
            if (parts.length > 1 && parts[1].toLowerCase().includes('semester')) {
                const sem2Name = parts[1];
                currentSem2 = { semester: { en: sem2Name, km: translateHeaderKhmer(sem2Name) || sem2Name }, subjects: [] };
                currentYear.semesters.push(currentSem2);
            } else {
                currentSem2 = null;
            }
            lastLeft = null; lastRight = null;
            continue;
        }
        
        if (!currentSem1) continue;
        
        const leftCols = rawColumns.slice(0, 3);
        const rightCols = rawColumns.slice(3);
        
        lastLeft = processSmartPasteSide(leftCols, currentSem1, lastLeft);
        
        if (rightCols.filter(c => c.trim() !== '').length > 0 && !currentSem2) {
            const autoSem2 = 'Semester II';
            currentSem2 = { semester: { en: autoSem2, km: translateHeaderKhmer(autoSem2) || autoSem2 }, subjects: [] };
            currentYear.semesters.push(currentSem2);
        }
        if (currentSem2) {
            lastRight = processSmartPasteSide(rightCols, currentSem2, lastRight);
        }
    }
    
    if (newCourseStructure.length > 0) {
        section.courseStructure = newCourseStructure;
    }
    
    activeGlobalSmartImportSection.value = null;
    globalSmartImportText.value = '';
};

const removeCourseSubject = (semester, subIdx) => {
    semester.subjects.splice(subIdx, 1);
    // reindex
    semester.subjects.forEach((s, idx) => s.no = idx + 1);
};

const computeYearTotals = (year) => {
    let credits = 0;
    let hours = 0;
    if (year.semesters) {
        year.semesters.forEach(sem => {
            if (sem.subjects) {
                sem.subjects.forEach(sub => {
                    credits += parseFloat(sub.credits) || 0;
                    hours += parseFloat(sub.hours) || 0;
                });
            }
        });
    }
    return { credits, hours };
};

const computeGrandTotals = (courseStructure) => {
    let credits = 0;
    let hours = 0;
    if (courseStructure) {
        courseStructure.forEach(year => {
            const yt = computeYearTotals(year);
            credits += yt.credits;
            hours += yt.hours;
        });
    }
    return { credits, hours };
};

const addCourseNote = (section) => {
    if (!section.courseNotes) section.courseNotes = [];
    section.courseNotes.push({ en: '', km: '' });
};

const removeCourseNote = (section, noteIdx) => {
    section.courseNotes.splice(noteIdx, 1);
};

const getEmptyPrograms = () => ({
    bachelor: getEmptyProgramObj(),
    associate: getEmptyProgramObj()
});

const addDeptMajor = () => {
    deptForm.majors.push({ 
        name: { en: '', km: '' }, 
        programs: getEmptyPrograms() 
    });
};

const removeDeptMajor = (idx) => {
    deptForm.majors.splice(idx, 1);
    // Adjust active tab if needed
    if (activeDeptMajorIndex.value >= deptForm.majors.length) {
        activeDeptMajorIndex.value = Math.max(0, deptForm.majors.length - 1);
    }
};

// Helper to add an exam breakdown row& grades
const addExamBreakdown = () => {
    if (!pageContentForm.content.breakdown) pageContentForm.content.breakdown = [];
    pageContentForm.content.breakdown.push({ criteria: { en: '', km: '' }, percentage: '' });
};
const removeExamBreakdown = (idx) => {
    pageContentForm.content.breakdown.splice(idx, 1);
};
const addExamGrade = () => {
    if (!pageContentForm.content.grades) pageContentForm.content.grades = [];
    pageContentForm.content.grades.push({ score: '', letter: '', points: '', description: { en: '', km: '' } });
};
const removeExamGrade = (idx) => {
    pageContentForm.content.grades.splice(idx, 1);
};

// Helper for Rector page paragraphs
const addRectorParagraph = () => {
    if (!pageContentForm.content.paragraphs) pageContentForm.content.paragraphs = [];
    pageContentForm.content.paragraphs.push('');
};
const removeRectorParagraph = (idx) => {
    pageContentForm.content.paragraphs.splice(idx, 1);
};

// --- EVENTS STATE & ACTIONS ---
const editingEvent = ref(null);
const eventForm = useForm({
    id: null,
    title: { en: '', km: '' },
    type: 'campus',
    date: { en: '', km: '' },
    description: { en: '', km: '' },
    content: { en: '', km: '' },
    image: '',
    detail_image: '',
    is_published: true
});

watch(editingEvent, (newVal) => {
    if (newVal) {
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.classList.remove('overflow-hidden');
    }
});

const startEditEvent = (ev = null) => {
    if (ev) {
        editingEvent.value = ev.id;
        eventForm.id = ev.id;
        eventForm.title = parseTranslatable(ev.title);
        eventForm.type = ev.type;
        eventForm.date = parseTranslatable(ev.date);
        eventForm.description = parseTranslatable(ev.description);
        eventForm.content = parseTranslatable(ev.content);
        eventForm.image = ev.image || '';
        eventForm.detail_image = ev.detail_image || '';
        eventForm.is_published = ev.is_published ?? true;
    } else {
        editingEvent.value = 'new';
        eventForm.reset();
        eventForm.title = { en: '', km: '' };
        eventForm.date = { en: '', km: '' };
        eventForm.description = { en: '', km: '' };
        eventForm.content = { en: '', km: '' };
        eventForm.is_published = true;
    }
};

const autoFillKhmerDate = () => {
    if (!eventForm.date.en) {
        eventForm.date.km = '';
        return;
    }
    const parts = eventForm.date.en.split('-');
    if (parts.length === 3) {
        const year = parts[0];
        const month = parseInt(parts[1], 10);
        const day = parseInt(parts[2], 10);
        const khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        const toKhmerNum = (numStr) => numStr.toString().split('').map(d => khmerDigits[parseInt(d, 10)]).join('');
        const khmerMonths = [
            '', 'មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 
            'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'
        ];
        eventForm.date.km = `${toKhmerNum(day)} /${khmerMonths[month]} /${toKhmerNum(year)}`;
    }
};

const submitEvent = () => {
    eventForm.post(route('admin.events.save'), {
        onSuccess: () => {
            editingEvent.value = null;
            eventForm.reset();
            showToast('Event saved successfully!');
        }
    });
};

const deleteEvent = (id) => {
    showConfirm(
        'Are you sure you want to delete this event?',
        () => {
            eventForm.delete(route('admin.events.delete', id), {
                onSuccess: () => showToast('Event deleted successfully!')
            });
        },
        'Delete Event'
    );
};

// --- FACULTIES & DEPARTMENTS STATE & ACTIONS ---
const editingFaculty = ref(null);
const facultyForm = useForm({
    id: null,
    name: { en: '', km: '' },
    cover_image: '',
    org_chart_image: '',
    mission: { en: '', km: '' },
    vision: { en: '', km: '' },
    goals: { en: '', km: '' },
    custom_sections: []
});

const startEditFaculty = (fac = null) => {
    if (fac) {
        editingFaculty.value = fac.id;
        facultyForm.id = fac.id;
        facultyForm.name = parseTranslatable(fac.name);
        facultyForm.cover_image = fac.cover_image || '';
        facultyForm.org_chart_image = fac.org_chart_image || '';
        facultyForm.mission = parseTranslatable(fac.mission);
        facultyForm.vision = parseTranslatable(fac.vision);
        facultyForm.goals = parseTranslatable(fac.goals);
        try {
            const rawSections = typeof fac.custom_sections === 'string' ? JSON.parse(fac.custom_sections) : (fac.custom_sections || []);
            facultyForm.custom_sections = rawSections.map(sec => ({
                title: parseTranslatable(sec.title),
                content: parseTranslatable(sec.content)
            }));
        } catch(e) {
            facultyForm.custom_sections = [];
        }
    } else {
        editingFaculty.value = 'new';
        facultyForm.reset();
        facultyForm.name = { en: '', km: '' };
        facultyForm.org_chart_image = '';
        facultyForm.mission = { en: '', km: '' };
        facultyForm.vision = { en: '', km: '' };
        facultyForm.goals = { en: '', km: '' };
        facultyForm.custom_sections = [];
    }
};

const submitFaculty = () => {
    facultyForm.post(route('admin.faculties.save'), {
        onSuccess: () => {
            editingFaculty.value = null;
            facultyForm.reset();
            showToast('Faculty saved successfully!');
        }
    });
};

const deleteFaculty = (id) => {
    showConfirm(
        'Are you sure you want to delete this faculty? All associated departments will be deleted.',
        () => {
            facultyForm.delete(route('admin.faculties.delete', id), {
                onSuccess: () => showToast('Faculty deleted successfully!')
            });
        },
        'Delete Faculty'
    );
};

const restoreDefaultFaculties = () => {
    showConfirm(
        'Are you sure you want to restore all default faculties and departments? This will restore any deleted default faculties.',
        () => {
            router.post(route('admin.faculties.restoreDefaults'), {}, {
                onSuccess: () => showToast('Default faculties restored successfully!')
            });
        },
        'Restore Default Faculties',
        'Restore Defaults',
        'info'
    );
};

const restoreDefaultPageContent = (pageId = 'all') => {
    const isAll = pageId === 'all' || !pageId;
    showConfirm(
        isAll
            ? 'Are you sure you want to restore default contents for all system pages?'
            : 'Are you sure you want to restore default content for this page? Any unsaved changes will be replaced with default data.',
        () => {
            router.post(route('admin.pages.restoreDefaults', pageId || 'all'), {}, {
                onSuccess: () => {
                    showToast(isAll ? 'Default contents restored for all pages!' : 'Default page content restored!');
                    if (selectedPage.value) {
                        const targetId = selectedPage.value.id;
                        const targetSlug = selectedPage.value.slug;
                        const freshPage = props.pageContents.find(p => (targetId && p.id === targetId) || (targetSlug && p.slug === targetSlug));
                        if (freshPage) {
                            startEditPage(freshPage);
                        }
                    }
                }
            });
        },
        'Restore Page Defaults',
        'Restore Defaults',
        'info'
    );
};

const restoreDefaultNavigation = () => {
    showConfirm(
        'Are you sure you want to restore the default navigation menu items?',
        () => {
            router.post(route('admin.navigation.restoreDefaults'), {}, {
                onSuccess: () => showToast('Default navigation restored!')
            });
        },
        'Restore Default Navigation',
        'Restore Defaults',
        'info'
    );
};

const restoreDefaultEvents = () => {
    showConfirm(
        'Are you sure you want to restore the default news & events list?',
        () => {
            router.post(route('admin.events.restoreDefaults'), {}, {
                onSuccess: () => showToast('Default events restored!')
            });
        },
        'Restore Default Events',
        'Restore Defaults',
        'info'
    );
};

const restoreDefaultTranslations = () => {
    showConfirm(
        'Are you sure you want to restore the base static translations?',
        () => {
            router.post(route('admin.translations.restoreDefaults'), {}, {
                onSuccess: () => showToast('Default translations restored!')
            });
        },
        'Restore Default Translations',
        'Restore Defaults',
        'info'
    );
};

const restoreDefaultSettings = () => {
    showConfirm(
        'Are you sure you want to restore default footer contact info and social links?',
        () => {
            router.post(route('admin.settings.restoreDefaults'), {}, {
                onSuccess: () => showToast('Default footer settings restored!')
            });
        },
        'Restore Default Footer Settings',
        'Restore Defaults',
        'info'
    );
};

const restoreDefaultHomeSettings = () => {
    showConfirm(
        'Are you sure you want to restore default home page slides and settings?',
        () => {
            router.post(route('admin.home.restoreDefaults'), {}, {
                onSuccess: () => showToast('Default home settings restored!')
            });
        },
        'Restore Default Home Settings',
        'Restore Defaults',
        'info'
    );
};

const navigateToContent = (item) => {
    if (!item || !item.href || item.href === '#') {
        showToast('This item is a container folder menu (no direct page content).', 'info');
        return;
    }

    const cleanSlug = item.href.replace(/^\//, '');
    const matchedPage = props.pageContents.find(p => p.slug === cleanSlug);

    if (matchedPage) {
        startEditPage(matchedPage);
        activeTab.value = 'pages';
        showToast(`Opened "${getAdminLabel(item.label)}" content in Pages tab`);
        return;
    }

    if (item.href === '/faculties' || item.href.startsWith('/department') || item.href.startsWith('/faculty')) {
        activeTab.value = 'faculties';
        showToast('Switched to Faculties & Academic tab');
        return;
    }

    if (item.href === '/events') {
        activeTab.value = 'events';
        showToast('Switched to News & Events tab');
        return;
    }

    window.open(item.href, '_blank');
};

const viewingNavItem = ref(null);
const viewingEvent = ref(null);
const viewingFaculty = ref(null);
const viewingDept = ref(null);
const viewingTranslation = ref(null);

const openViewNavItemModal = (item) => {
    viewingNavItem.value = item;
};

const openViewEventModal = (eventItem) => {
    viewingEvent.value = eventItem;
};

const openViewFacultyModal = (facultyItem) => {
    viewingFaculty.value = facultyItem;
};

const openViewDeptModal = (deptItem) => {
    viewingDept.value = deptItem;
};

const openViewTranslationModal = (translationItem) => {
    viewingTranslation.value = translationItem;
};

const navigateToPageFromModal = (item) => {
    viewingNavItem.value = null;
    if (item?.href && item.href !== '#') {
        window.open(item.href, '_blank');
    } else {
        showToast('This item is a container folder menu (no direct page content).', 'info');
    }
};

const legacySections = [
    { key: 'programAim', label: '1. Program Aim' },
    { key: 'plos', label: '2. Program Learning Outcomes' },
    { key: 'termsOfAdmission', label: '3. Terms of Admission' },
    { key: 'totalCredits', label: '4. Total Credits' },
    { key: 'courseStructure', label: '5. Course Structure' },
    { key: 'graduationRequirements', label: '6. Graduation Requirements' },
    { key: 'degreeTitleAwarded', label: '7. Degree Title Awarded' },
    { key: 'careerOpportunities', label: '8. Career Opportunities' }
];

const editingDept = ref(null);
const activeDeptProgramTab = ref('bachelor');
const activeDeptMajorIndex = ref(0);

const deptForm = useForm({
    id: null,
    faculty_id: '',
    name: { en: '', km: '' },
    slug: '',
    description: { en: '', km: '' },
    mission: { en: '', km: '' },
    vision: { en: '', km: '' },
    goals: { en: '', km: '' },
    majors: [],
    custom_sections: [],
});

const startEditDept = (dept = null) => {
    if (dept) {
        editingDept.value = dept.id;
        deptForm.id = dept.id;
        deptForm.faculty_id = dept.faculty_id;
        deptForm.name = parseTranslatable(dept.name);
        deptForm.slug = dept.slug;
        deptForm.description = parseTranslatable(dept.description);
        deptForm.mission = parseTranslatable(dept.mission);
        deptForm.vision = parseTranslatable(dept.vision);
        deptForm.goals = parseTranslatable(dept.goals);
        try {
            const rawMajors = typeof dept.majors === 'string' ? JSON.parse(dept.majors) : (dept.majors || []);
            const parseProgramObj = (obj) => {
                if (!obj) return getEmptyProgramObj();
                
                // If it already uses the dynamic sections format
                if (obj.sections && Array.isArray(obj.sections)) {
                    return {
                        sections: obj.sections.map(s => ({
                            type: s.type || 'richtext',
                            title: parseTranslatable(s.title),
                            content: parseTranslatable(s.content),
                            courseStructure: s.courseStructure || [],
                            courseNotes: s.courseNotes || [],
                            customTable: s.customTable ? {
                                badge: parseTranslatable(s.customTable.badge),
                                subtitle: parseTranslatable(s.customTable.subtitle),
                                footerNote: parseTranslatable(s.customTable.footerNote),
                                showRowNumbers: s.customTable.showRowNumbers !== undefined ? s.customTable.showRowNumbers : true,
                                headers: (s.customTable.headers || []).map(h => ({
                                    key: h.key,
                                    label: parseTranslatable(h.label),
                                    headerAlign: h.headerAlign || h.align || 'center',
                                    bodyAlign: h.bodyAlign || h.align || 'left',
                                    verticalAlign: h.verticalAlign || 'top',
                                    width: h.width || 'auto'
                                })),
                                rows: (s.customTable.rows || []).map(r => {
                                    const rowObj = {};
                                    Object.keys(r).forEach(k => {
                                        rowObj[k] = parseTranslatable(r[k]);
                                    });
                                    return rowObj;
                                })
                            } : {
                                badge: { en: '', km: '' },
                                subtitle: { en: '', km: '' },
                                footerNote: { en: '', km: '' },
                                showRowNumbers: true,
                                headers: [
                                    { key: 'col_0', label: { en: 'Header 1', km: 'ចំណងជើង ១' }, headerAlign: 'center', bodyAlign: 'left', verticalAlign: 'top', width: 'auto' },
                                    { key: 'col_1', label: { en: 'Header 2', km: 'ចំណងជើង ២' }, headerAlign: 'center', bodyAlign: 'left', verticalAlign: 'top', width: 'auto' }
                                ],
                                rows: [
                                    { col_0: { en: '', km: '' }, col_1: { en: '', km: '' } }
                                ]
                            }
                        }))
                    };
                }
                
                // Migrate legacy fixed-key format
                const sections = [];
                legacySections.forEach(sec => {
                    const isCourseStructure = sec.key === 'courseStructure';
                    let contentVal = { en: '', km: '' };
                    let courseStructureVal = [];
                    
                    if (obj[sec.key]) {
                        if (isCourseStructure && Array.isArray(obj[sec.key])) {
                            // If it's the legacy course structure array, keep it in courseStructure
                            courseStructureVal = obj[sec.key].map(yr => ({
                                year: typeof yr.year === 'string' ? { en: yr.year, km: yr.year } : yr.year,
                                semesters: yr.semesters ? yr.semesters.map(sem => ({
                                    semester: typeof sem.semester === 'string' ? { en: sem.semester, km: sem.semester } : sem.semester,
                                    subjects: sem.subjects ? sem.subjects.map(sub => ({
                                        no: sub.no,
                                        name: typeof sub.name === 'string' ? { en: sub.name, km: sub.name } : sub.name,
                                        credits: sub.credits,
                                        hours: sub.hours
                                    })) : []
                                })) : []
                            }));
                        } else {
                            contentVal = parseTranslatable(obj[sec.key]);
                        }
                    }

                    sections.push({
                        type: isCourseStructure ? 'course_structure' : 'richtext',
                        title: { en: sec.label, km: sec.label },
                        content: contentVal,
                        courseStructure: courseStructureVal,
                        courseNotes: isCourseStructure && obj.courseNotes ? obj.courseNotes.map(n => typeof n === 'string' ? { en: n, km: n } : n) : []
                    });
                });
                return { sections };
            };

            const parsePrograms = (rawProgs) => {
                if (!rawProgs) return getEmptyPrograms();
                return {
                    bachelor: parseProgramObj(rawProgs.bachelor),
                    associate: parseProgramObj(rawProgs.associate)
                };
            };

            // Migrate legacy data if the first major doesn't have a 'name' property
            // OR if it's the old format where programs were on the department.
            const oldDeptPrograms = typeof dept.programs === 'string' ? JSON.parse(dept.programs) : (dept.programs || null);

            if (rawMajors && !Array.isArray(rawMajors)) {
                deptForm.majors = [{
                    name: parseTranslatable(rawMajors),
                    programs: parsePrograms(oldDeptPrograms)
                }];
            } else {
                deptForm.majors = rawMajors.map((m, index) => {
                    if (m.name) {
                        return {
                            name: parseTranslatable(m.name),
                            programs: parsePrograms(m.programs)
                        };
                    } else {
                        // Legacy array of objects: {en: '', km: ''}
                        return {
                            name: parseTranslatable(m),
                            programs: index === 0 ? parsePrograms(oldDeptPrograms) : getEmptyPrograms()
                        };
                    }
                });
            }
        } catch(e) {
            deptForm.majors = [];
        }
        try {
            const rawSections = typeof dept.custom_sections === 'string' ? JSON.parse(dept.custom_sections) : (dept.custom_sections || []);
            deptForm.custom_sections = rawSections.map(sec => ({
                title: parseTranslatable(sec.title),
                content: parseTranslatable(sec.content)
            }));
        } catch(e) {
            deptForm.custom_sections = [];
        }
        
        activeDeptMajorIndex.value = 0;
    } else {
        editingDept.value = 'new';
        deptForm.reset();
        deptForm.id = null;
        deptForm.faculty_id = props.faculties.length > 0 ? props.faculties[0].id : '';
        deptForm.name = { en: '', km: '' };
        deptForm.slug = '';
        deptForm.description = { en: '', km: '' };
        deptForm.mission = { en: '', km: '' };
        deptForm.vision = { en: '', km: '' };
        deptForm.goals = { en: '', km: '' };
        deptForm.majors = [];
        deptForm.custom_sections = [];
        activeDeptMajorIndex.value = 0;
    }
};

const submitDept = () => {
    deptForm.post(route('admin.departments.save'), {
        onSuccess: () => {
            editingDept.value = null;
            deptForm.reset();
            showToast('Department saved successfully!');
        }
    });
};

const deleteDept = (id) => {
    showConfirm(
        'Are you sure you want to delete this department?',
        () => {
            deptForm.delete(route('admin.departments.delete', id), {
                onSuccess: () => showToast('Department deleted successfully!')
            });
        },
        'Delete Department'
    );
};

// --- TRANSLATIONS STATE & ACTIONS ---
const searchQueryTranslations = ref('');
const filteredTranslations = computed(() => {
    if (!props.translationsData) return [];
    if (!searchQueryTranslations.value) return props.translationsData;
    const q = searchQueryTranslations.value.toLowerCase();
    return props.translationsData.filter(t => 
        (t.key && t.key.toLowerCase().includes(q)) || 
        (t.en && t.en.toLowerCase().includes(q)) || 
        (t.km && t.km.toLowerCase().includes(q))
    );
});

const editingTranslation = ref(null);
const translationForm = useForm({
    id: null,
    key: '',
    en: '',
    km: ''
});

const startEditTranslation = (item = null) => {
    if (item) {
        editingTranslation.value = item.id;
        translationForm.id = item.id;
        translationForm.key = item.key;
        translationForm.en = item.en || '';
        translationForm.km = item.km || '';
    } else {
        editingTranslation.value = 'new';
        translationForm.reset();
    }
};

const cancelEditTranslation = () => {
    editingTranslation.value = null;
    translationForm.reset();
};

const submitTranslation = () => {
    translationForm.post(route('admin.translations.save'), {
        onSuccess: () => {
            cancelEditTranslation();
            showToast('Translation saved successfully!');
        }
    });
};

const deleteTranslation = (id) => {
    showConfirm(
        'Are you sure you want to delete this translation key?',
        () => {
            translationForm.delete(route('admin.translations.delete', id), {
                onSuccess: () => showToast('Translation key deleted successfully!')
            });
        },
        'Delete Translation Key'
    );
};

// --- CONTACT SETTINGS STATE & ACTIONS ---
const contactSettingsForm = useForm({
    contact_hero_title: props.contactSettings?.contact_hero_title || 'Contact Us',
    contact_hero_description: props.contactSettings?.contact_hero_description || 'Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.',
    contact_image: props.contactSettings?.contact_image || '',
    address: props.settings?.address ? (typeof props.settings.address === 'string' ? parseTranslatable(props.settings.address) : props.settings.address) : { en: 'Kompong Spue, Cambodia', km: 'Kompong Spue, Cambodia' },
    email: props.settings?.email || '',
    phone: props.settings?.phone || '',
    direct_lines: props.settings?.direct_lines ? [...props.settings.direct_lines] : [],
    social_links: props.settings?.social_links ? JSON.parse(JSON.stringify(props.settings.social_links)) : []
});

const addContactDirectLine = () => {
    contactSettingsForm.direct_lines.push('');
};
const removeContactDirectLine = (idx) => {
    contactSettingsForm.direct_lines.splice(idx, 1);
};

const addContactSocialLink = () => {
    contactSettingsForm.social_links.push({ label: '', href: '' });
};
const removeContactSocialLink = (idx) => {
    contactSettingsForm.social_links.splice(idx, 1);
};

const submitContactSettings = () => {
    contactSettingsForm.post(route('admin.contact.save'), {
        preserveScroll: true,
        onSuccess: () => {
            showToast('Contact settings updated successfully!');
        }
    });
};

const restoreDefaultContactSettings = () => {
    showConfirm(
        'Are you sure you want to restore contact page settings to their default values? This will overwrite your current configurations.',
        () => {
            contactSettingsForm.contact_hero_title = 'Contact Us';
            contactSettingsForm.contact_hero_description = 'Have questions about admissions, programs, or campus life? Reach out to us, and our team will get back to you shortly.';
            contactSettingsForm.contact_image = '';
            submitContactSettings();
        },
        'Restore Default Contact Settings'
    );
};

// --- SETTINGS STATE & ACTIONS ---
const settingsForm = useForm({
    copyright: props.settings.copyright ? (typeof props.settings.copyright === 'string' ? parseTranslatable(props.settings.copyright) : props.settings.copyright) : { en: 'Copyright © 2024 Digital University of Cambodia. All rights reserved.', km: 'Copyright © 2024 Digital University of Cambodia. All rights reserved.' },
    social_links: [...(props.settings.social_links || [])],
    header_bg_color: props.settings.header_bg_color || '#ffffff',
    header_text_color: props.settings.header_text_color || '#000000',
    footer_bg_color: props.settings.footer_bg_color || '#0d184a',
    footer_border_color: props.settings.footer_border_color || '#04a8f5',
    nav_bg_color: props.settings.nav_bg_color || '#3852a4',
    nav_text_color: props.settings.nav_text_color || '#ffffff',
    nav_active_color: props.settings.nav_active_color || '#ffb800',
    contact_image: props.settings.contact_image || '',
    sub_footer_bg_color: props.settings.sub_footer_bg_color || '#081033',
    sub_footer_text_color: props.settings.sub_footer_text_color || '#94a3b8',
    sub_footer_border_color: props.settings.sub_footer_border_color || '#1e293b',
    privacy_policy_label: props.settings.privacy_policy_label || 'Privacy Policy',
    privacy_policy_url: props.settings.privacy_policy_url || '#',
    footer_credits: props.settings.footer_credits || 'Made with ♥ by IT Department Students',
    footer_map_url: props.settings.footer_map_url || '',
    footer_map_label: props.settings.footer_map_label ? parseTranslatable(props.settings.footer_map_label) : { en: 'Phnom Penh Campus', km: 'Phnom Penh Campus' },
    footer_working_hours_weekday_label: props.settings.footer_working_hours_weekday_label ? parseTranslatable(props.settings.footer_working_hours_weekday_label) : { en: 'Mon - Sat', km: 'Mon - Sat' },
    footer_working_hours_weekday_time: props.settings.footer_working_hours_weekday_time ? parseTranslatable(props.settings.footer_working_hours_weekday_time) : { en: '8:00 AM - 5:00 PM', km: '8:00 AM - 5:00 PM' },
    footer_working_hours_weekend_label: props.settings.footer_working_hours_weekend_label ? parseTranslatable(props.settings.footer_working_hours_weekend_label) : { en: 'Weekend', km: 'Weekend' },
    footer_working_hours_weekend_time: props.settings.footer_working_hours_weekend_time ? parseTranslatable(props.settings.footer_working_hours_weekend_time) : { en: '8:00 AM - 4:00 PM', km: '8:00 AM - 4:00 PM' },
    footer_quick_links: (props.settings.footer_quick_links || []).map(link => ({
        ...link,
        label: typeof link.label === 'string' ? parseTranslatable(link.label) : (link.label || { en: '', km: '' })
    })),
    footer_label_quick_links: props.settings.footer_label_quick_links ? parseTranslatable(props.settings.footer_label_quick_links) : { en: 'Our Details', km: 'Our Details' },
    footer_label_working_hours: props.settings.footer_label_working_hours ? parseTranslatable(props.settings.footer_label_working_hours) : { en: 'Working Hours', km: 'Working Hours' },
    footer_label_social_media: props.settings.footer_label_social_media ? parseTranslatable(props.settings.footer_label_social_media) : { en: 'Social Media', km: 'Social Media' },
    footer_label_contact_info: props.settings.footer_label_contact_info ? parseTranslatable(props.settings.footer_label_contact_info) : { en: 'Contact Information', km: 'Contact Information' },
    footer_label_direct_lines: props.settings.footer_label_direct_lines ? parseTranslatable(props.settings.footer_label_direct_lines) : { en: 'Direct Lines', km: 'Direct Lines' }
});

const addSocialLink = () => {
    settingsForm.social_links.push({ label: '', href: '', svg: '', class: '', bg_color: '#ffffff', hover_color: '#1877f2', icon_color: '#000000', icon_hover_color: '#ffffff', disable_bg_hover: false, disable_icon_hover: false });
};
const removeSocialLink = (idx) => {
    settingsForm.social_links.splice(idx, 1);
};

const addQuickLink = () => {
    settingsForm.footer_quick_links.push({ label: { en: '', km: '' }, href: '' });
};
const removeQuickLink = (idx) => {
    settingsForm.footer_quick_links.splice(idx, 1);
};

const submitSettings = () => {
    settingsForm.post(route('admin.settings.save'), {
        onSuccess: () => showToast('Settings updated successfully!')
    });
};
const submitFooterSettings = submitSettings;

// --- HOME PAGE SETTINGS STATE & ACTIONS ---
const homeSettingsForm = useForm({
    home_hero_slides: (props.homeSettings?.home_hero_slides || []).map(slide => ({
        imgUrl: slide.imgUrl || '',
        altText: parseTranslatable(slide.altText)
    })),
    home_scholarship: {
        title: parseTranslatable(props.homeSettings?.home_scholarship?.title),
        description: parseTranslatable(props.homeSettings?.home_scholarship?.description),
        footer_text: parseTranslatable(props.homeSettings?.home_scholarship?.footer_text || { en: 'Your journey to excellence starts here!', km: 'ដំណើរកម្សាន្តរបស់អ្នកឆ្ពោះទៅរកភាពឆ្នើមចាប់ផ្តើមពីទីនេះ!' }),
        bg_image: props.homeSettings?.home_scholarship?.bg_image || ''
    },
    home_four_years: (props.homeSettings?.home_four_years?.length ? props.homeSettings.home_four_years : [
        { title: { en: 'Foundation year', km: 'ឆ្នាំសិក្សាមូលដ្ឋាន' }, description: { en: '', km: '' } },
        { title: { en: 'Second year', km: 'ឆ្នាំទី២' }, description: { en: '', km: '' } },
        { title: { en: 'Third year', km: 'ឆ្នាំទី៣' }, description: { en: '', km: '' } },
        { title: { en: 'Last year', km: 'ឆ្នាំបញ្ចប់' }, description: { en: '', km: '' } }
    ]).map(year => ({
        title: parseTranslatable(year.title),
        description: parseTranslatable(year.description)
    })),
    home_video_url: props.homeSettings?.home_video_url || '',
    home_video_bg_image: props.homeSettings?.home_video_bg_image || '',
    home_video_bg_color: props.homeSettings?.home_video_bg_color || '#0f2154',
    home_activities_slides: (props.homeSettings?.home_activities_slides || []).map(slide => ({
        img: slide.img || '',
        alt: parseTranslatable(slide.alt)
    })),
    home_graduate_attributes: (() => {
        let ga = props.homeSettings?.home_graduate_attributes || {};
        let cards = ga.cards;
        
        // Migrate old card_1, card_2, card_3 if cards doesn't exist
        if (!cards) {
            cards = [];
            if (ga.card_1 || !ga.title) {
                cards.push({
                    title: parseTranslatable(ga.card_1?.title || { en: 'Knowledge & Professionalism', km: 'ចំណេះដឹង និងវិជ្ជាជីវៈ' }),
                    description: parseTranslatable(ga.card_1?.description || { en: 'Communicate effectively with the body of knowledge that underpins professional practice.', km: 'ទាក់ទងដោយប្រសិទ្ធភាពជាមួយនឹងចំណេះដឹងដែលជាមូលដ្ឋានគ្រឹះនៃប្រតិបត្តិការវិជ្ជាជីវៈ។' }),
                    image: ''
                });
            }
            if (ga.card_2 || !ga.title) {
                cards.push({
                    title: parseTranslatable(ga.card_2?.title || { en: 'Active Learning', km: 'ការសិក្សាសកម្ម' }),
                    description: parseTranslatable(ga.card_2?.description || { en: 'The beautiful thing about learning is that no one can take it away from you — but the magical thing about active learning is that you own what you build.', km: 'អ្វីដែលស្រស់ស្អាតអំពីការរៀនសូត្រគឺគ្មាននរណាម្នាក់អាចយកវាចេញពីអ្នកបានឡើយ...' }),
                    image: ''
                });
            }
            if (ga.card_3 || !ga.title) {
                cards.push({
                    title: parseTranslatable(ga.card_3?.title || { en: 'Communication & Teamwork', km: 'ការប្រាសព្វប្រស្រ័យ និងការងារក្រុម' }),
                    description: parseTranslatable(ga.card_3?.description || { en: 'Have enhanced cultural, social, and ethical awareness as engaged members of the community.', km: 'មានការយល់ដឹងអំពីវប្បធម៌ សង្គម និងសីលធម៌ខ្ពស់...' }),
                    image: ga.card_3?.image || ''
                });
            }
        } else {
            cards = cards.map(c => ({
                title: parseTranslatable(c.title),
                description: parseTranslatable(c.description),
                image: c.image || ''
            }));
        }

        return {
            title: parseTranslatable(ga.title || { en: 'Graduate Attributes', km: 'គុណសម្បត្តិនៃអ្នកបញ្ចប់ការសិក្សា' }),
            cards: cards
        };
    })(),
    home_stats: (props.homeSettings?.home_stats?.length ? props.homeSettings.home_stats : [
        { value: '1', label: { en: 'University Campus', km: 'ទីតាំងសាកលវិទ្យាល័យ' }, icon: 'building' },
        { value: '1000+', label: { en: 'Active Students', km: 'និស្សិតសរុប' }, icon: 'student' },
        { value: '1200+', label: { en: 'Computers & IT Devices', km: 'កុំព្យូទ័រ & ឧបករណ៍' }, icon: 'computer' },
        { value: '50+', label: { en: 'Professors & Lecturers', km: 'សាស្ត្រាចារ្យ & បុគ្គលិក' }, icon: 'user' }
    ]).map(item => ({
        value: item.value || '',
        label: parseTranslatable(item.label),
        icon: item.icon || 'building'
    }))
});

const isHeroCollapsed = ref(localStorage.getItem('duc_home_hero_collapsed') === 'true');
const isScholarshipCollapsed = ref(localStorage.getItem('duc_home_scholarship_collapsed') === 'true');
const isFourYearsCollapsed = ref(localStorage.getItem('duc_home_four_years_collapsed') === 'true');
const isVideoSectionCollapsed = ref(localStorage.getItem('duc_home_video_collapsed') === 'true');
const isActivitiesCollapsed = ref(localStorage.getItem('duc_home_activities_collapsed') === 'true');
const isGradAttributesCollapsed = ref(localStorage.getItem('duc_home_grad_attr_collapsed') === 'true');
const isStatsCollapsed = ref(localStorage.getItem('duc_home_stats_collapsed') === 'true');

const toggleHeroCollapse = () => {
    isHeroCollapsed.value = !isHeroCollapsed.value;
    localStorage.setItem('duc_home_hero_collapsed', isHeroCollapsed.value ? 'true' : 'false');
};
const toggleScholarshipCollapse = () => {
    isScholarshipCollapsed.value = !isScholarshipCollapsed.value;
    localStorage.setItem('duc_home_scholarship_collapsed', isScholarshipCollapsed.value ? 'true' : 'false');
};
const toggleFourYearsCollapse = () => {
    isFourYearsCollapsed.value = !isFourYearsCollapsed.value;
    localStorage.setItem('duc_home_four_years_collapsed', isFourYearsCollapsed.value ? 'true' : 'false');
};
const toggleVideoSectionCollapse = () => {
    isVideoSectionCollapsed.value = !isVideoSectionCollapsed.value;
    localStorage.setItem('duc_home_video_collapsed', isVideoSectionCollapsed.value ? 'true' : 'false');
};
const toggleActivitiesCollapse = () => {
    isActivitiesCollapsed.value = !isActivitiesCollapsed.value;
    localStorage.setItem('duc_home_activities_collapsed', isActivitiesCollapsed.value ? 'true' : 'false');
};
const toggleGradAttributesCollapse = () => {
    isGradAttributesCollapsed.value = !isGradAttributesCollapsed.value;
    localStorage.setItem('duc_home_grad_attr_collapsed', isGradAttributesCollapsed.value ? 'true' : 'false');
};
const toggleStatsCollapse = () => {
    isStatsCollapsed.value = !isStatsCollapsed.value;
    localStorage.setItem('duc_home_stats_collapsed', isStatsCollapsed.value ? 'true' : 'false');
};

const addGradAttributeCard = () => {
    if (!homeSettingsForm.home_graduate_attributes.cards) {
        homeSettingsForm.home_graduate_attributes.cards = [];
    }
    homeSettingsForm.home_graduate_attributes.cards.push({ title: { en: 'New Attribute', km: 'គុណសម្បត្តិថ្មី' }, description: { en: '', km: '' }, image: '' });
    isGradAttributesCollapsed.value = false;
    localStorage.setItem('duc_home_grad_attr_collapsed', 'false');
};

const removeGradAttributeCard = (idx) => {
    if (homeSettingsForm.home_graduate_attributes.cards) {
        homeSettingsForm.home_graduate_attributes.cards.splice(idx, 1);
    }
};

const moveGradAttributeCardUp = (idx) => {
    if (homeSettingsForm.home_graduate_attributes.cards && idx > 0) {
        const temp = homeSettingsForm.home_graduate_attributes.cards[idx];
        homeSettingsForm.home_graduate_attributes.cards[idx] = homeSettingsForm.home_graduate_attributes.cards[idx - 1];
        homeSettingsForm.home_graduate_attributes.cards[idx - 1] = temp;
    }
};

const moveGradAttributeCardDown = (idx) => {
    if (homeSettingsForm.home_graduate_attributes.cards && idx < homeSettingsForm.home_graduate_attributes.cards.length - 1) {
        const temp = homeSettingsForm.home_graduate_attributes.cards[idx];
        homeSettingsForm.home_graduate_attributes.cards[idx] = homeSettingsForm.home_graduate_attributes.cards[idx + 1];
        homeSettingsForm.home_graduate_attributes.cards[idx + 1] = temp;
    }
};

const addStatItem = () => {
    homeSettingsForm.home_stats.push({
        value: '100+',
        label: { en: 'New Counter Item', km: 'ទិន្នន័យថ្មី' },
        icon: 'building'
    });
    isStatsCollapsed.value = false;
    localStorage.setItem('duc_home_stats_collapsed', 'false');
};

const removeStatItem = (idx) => {
    homeSettingsForm.home_stats.splice(idx, 1);
};

const moveStatUp = (idx) => {
    if (idx <= 0) return;
    const temp = homeSettingsForm.home_stats[idx];
    homeSettingsForm.home_stats[idx] = homeSettingsForm.home_stats[idx - 1];
    homeSettingsForm.home_stats[idx - 1] = temp;
};

const moveStatDown = (idx) => {
    if (idx >= homeSettingsForm.home_stats.length - 1) return;
    const temp = homeSettingsForm.home_stats[idx];
    homeSettingsForm.home_stats[idx] = homeSettingsForm.home_stats[idx + 1];
    homeSettingsForm.home_stats[idx + 1] = temp;
};

const addHeroSlide = () => {
    homeSettingsForm.home_hero_slides.push({ imgUrl: '', altText: { en: '', km: '' } });
    isHeroCollapsed.value = false;
    localStorage.setItem('duc_home_hero_collapsed', 'false');
};
const handleMultipleHeroUpload = (event) => {
    const files = event.target.files;
    if (!files || files.length === 0) return;
    for (let i = 0; i < files.length; i++) {
        homeSettingsForm.home_hero_slides.push({
            imgUrl: files[i],
            altText: { en: '', km: '' }
        });
    }
    isHeroCollapsed.value = false;
    localStorage.setItem('duc_home_hero_collapsed', 'false');
    event.target.value = '';
};
const removeHeroSlide = (idx) => {
    homeSettingsForm.home_hero_slides.splice(idx, 1);
};

const addActivitySlide = () => {
    homeSettingsForm.home_activities_slides.push({ img: '', alt: { en: '', km: '' } });
    isActivitiesCollapsed.value = false;
    localStorage.setItem('duc_home_activities_collapsed', 'false');
};
const handleMultipleActivityUpload = (event) => {
    const files = event.target.files;
    if (!files || files.length === 0) return;
    for (let i = 0; i < files.length; i++) {
        homeSettingsForm.home_activities_slides.push({
            img: files[i],
            alt: { en: '', km: '' }
        });
    }
    isActivitiesCollapsed.value = false;
    localStorage.setItem('duc_home_activities_collapsed', 'false');
    event.target.value = '';
};
const removeActivitySlide = (idx) => {
    homeSettingsForm.home_activities_slides.splice(idx, 1);
};

const getObjectUrl = (file) => {
    if (!file) return '';
    if (typeof file === 'string') return file;
    try {
        return URL.createObjectURL(file);
    } catch (e) {
        return '';
    }
};

const previewImageModal = ref({
    show: false,
    url: ''
});

const openImagePreview = (imgSrc) => {
    if (!imgSrc) return;
    const url = typeof imgSrc === 'object' ? getObjectUrl(imgSrc) : imgSrc;
    if (url) {
        previewImageModal.value = {
            show: true,
            url: url
        };
    }
};

const submitHomeSettings = () => {
    homeSettingsForm.post(route('admin.home.save'), {
        onSuccess: () => showToast('Home page settings updated successfully!')
    });
};

const getAdminLabel = (val) => {
    const parsed = parseTranslatable(val);
    if (!parsed.en && !parsed.km) return 'Unnamed';
    return `${parsed.en || 'No EN'} | ${parsed.km || 'No KM'}`;
};

const stripHtml = (html) => {
    if (!html || typeof html !== 'string') return '';
    if (!html.includes('<')) return html;
    let text = html;
    text = text.replace(/<li[^>]*>/gi, '\n- ');
    text = text.replace(/<\/p>|<br\s*\/?>|<\/div>/gi, '\n');
    text = text.replace(/<[^>]+>/g, '');
    text = text.replace(/&nbsp;/gi, ' ');
    text = text.split('\n').map(line => line.trim()).filter(Boolean).join('\n');
    return text;
};
</script>

<template>
    <Head title="DUC Admin Console" />

    <div 
        class="h-screen font-sans flex overflow-hidden transition-colors duration-300" 
        :class="isDarkMode ? 'dark bg-[#090d16] text-slate-100' : 'bg-[#f4f6fa] text-slate-800'"
    >
        
        <!-- SIDEBAR -->
        <AdminSidebar 
            :activeTab="activeTab" 
            :ducLogo="ducLogo" 
            :onLogout="logout" 
        />

        <!-- MAIN WORKSPACE -->
        <main class="flex-grow flex flex-col overflow-hidden">
            
            <!-- HEADER BAR -->
            <header 
                class="h-16 border-b flex justify-center items-center z-10 transition-colors duration-300 shrink-0"
                :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333]' : 'bg-white border-slate-200 shadow-sm'"
            >
                <div class="w-full max-w-[1850px] mx-auto px-6 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Console</span>
                        <span :class="isDarkMode ? 'text-slate-800' : 'text-slate-300'">/</span>
                        <span class="text-xs font-bold capitalize" :class="isDarkMode ? 'text-slate-300' : 'text-slate-650'">{{ activeTab }} View</span>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Light / Dark Switcher -->
                        <button 
                            @click="toggleDarkMode" 
                            class="p-2 rounded-xl border transition-all flex items-center justify-center"
                            :class="isDarkMode 
                                ? 'bg-slate-900 border-slate-800 text-amber-400 hover:bg-slate-800' 
                                : 'bg-slate-50 border-slate-200 text-indigo-950 hover:bg-slate-100'"
                        >
                            <svg v-if="isDarkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>

                        <!-- Visit Site -->
                        <a 
                            href="/" 
                            target="_blank" 
                            class="flex items-center gap-1.5 text-xs font-bold px-3.5 py-2 rounded-xl transition-all"
                            :class="isDarkMode 
                                ? 'text-blue-400 bg-blue-500/10 border border-blue-500/20 hover:bg-blue-500/20' 
                                : 'text-blue-600 bg-blue-50 border border-blue-100 hover:bg-blue-100'"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Visit Site
                        </a>
                    </div>
                </div>
            </header>

            <!-- WORKSPACE SCROLL BODY -->
            <div class="flex-grow overflow-y-auto p-6 max-w-[1850px] w-full mx-auto space-y-6">

                <!-- TAB: OVERVIEW -->
                <div v-if="activeTab === 'overview'" class="space-y-6 animate-fadeIn">
                    
                    <!-- Welcome Hero Banner -->
                    <div 
                        class="relative overflow-hidden rounded-3xl p-8 border transition-all"
                        :class="isDarkMode 
                            ? 'bg-gradient-to-r from-blue-950/60 via-indigo-950/30 to-transparent border-blue-900/30' 
                            : 'bg-gradient-to-r from-blue-50 via-indigo-50/20 to-white border-blue-100/80 shadow-xs'"
                    >
                        <div class="z-10 relative max-w-2xl">
                            <span 
                                class="text-[9px] font-black tracking-widest uppercase px-2.5 py-1 rounded-full mb-3.5 inline-block animate-pulse"
                                :class="isDarkMode ? 'bg-blue-500/10 border border-blue-500/20 text-blue-400' : 'bg-blue-100 text-blue-800'"
                            >
                                Administrative Console Active
                            </span>
                            <h2 
                                class="text-2xl md:text-3xl font-extrabold tracking-tight mb-2"
                                :class="isDarkMode ? 'text-white' : 'text-slate-900'"
                            >
                                Digital University of Cambodia
                            </h2>
                            <p class="text-sm leading-relaxed" :class="isDarkMode ? 'text-slate-400' : 'text-slate-650'">
                                Welcome back. This dashboard gives you total control over the public header menus, rector message blocks, student exam tables, announcements timeline, and faculty details.
                            </p>
                        </div>
                    </div>

                    <!-- Stats Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div 
                            v-for="stat in [
                                { label: 'Navigation Menu Nodes', count: props.navigationItems.length, sub: 'Active mega menus & links', tab: 'navigation', colorClass: 'text-blue-500 bg-blue-500/10' },
                                { label: 'Editable Site Pages', count: props.pageContents.length, sub: 'History, Rector & offices', tab: 'pages', colorClass: 'text-indigo-500 bg-indigo-500/10' },
                                { label: 'News Announcements', count: props.events.length, sub: 'Campus articles published', tab: 'events', colorClass: 'text-amber-500 bg-amber-500/10' },
                                { label: 'Faculties & Majors', count: props.faculties.length, sub: 'Branches & nested departments', tab: 'faculties', colorClass: 'text-emerald-500 bg-emerald-500/10' }
                            ]"
                            :key="stat.label"
                            @click="activeTab = stat.tab"
                            class="border rounded-2xl p-6 hover:translate-y-[-2px] cursor-pointer transition-all duration-300 group"
                            :class="isDarkMode 
                                ? 'bg-[#0c101b] border-[#1a2333] hover:border-slate-700 shadow-md' 
                                : 'bg-white border-slate-200/80 shadow-sm hover:shadow-md'"
                        >
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-black uppercase tracking-wider" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">{{ stat.label }}</span>
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110" :class="stat.colorClass">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                            </div>
                            <h3 class="text-3.5xl font-black" :class="isDarkMode ? 'text-white' : 'text-slate-900'">{{ stat.count }}</h3>
                            <p class="text-[11px] mt-1.5" :class="isDarkMode ? 'text-slate-500' : 'text-slate-500'">{{ stat.sub }}</p>
                        </div>
                    </div>

                    <!-- 2-COLUMN CMS ANALYTICS WORKSPACE & ACTIVITY TIMELINE -->
                    <div class="grid grid-cols-1 lg:grid-cols-[1.8fr_1fr] gap-8">
                        
                        <!-- Mini Chart Visual Mock Panel -->
                        <div 
                            class="border rounded-2xl p-6 flex flex-col justify-between"
                            :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333]' : 'bg-white border-slate-200 shadow-sm'"
                        >
                            <div>
                                <h4 class="text-sm font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-700'">Visitor traffic Overview</h4>
                                <p class="text-xs mb-6" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Visual representation of weekly portal interaction stats.</p>
                                
                                <!-- Mock SVG Bar Chart -->
                                <div class="h-48 flex items-end justify-between gap-3 pt-4 border-b border-dashed" :class="isDarkMode ? 'border-slate-800' : 'border-slate-200'">
                                    <div v-for="bar in [
                                        { day: 'Mon', h: 'h-1/3', val: '1.2k', col: 'from-blue-500 to-indigo-500' },
                                        { day: 'Tue', h: 'h-1/2', val: '2.0k', col: 'from-indigo-500 to-purple-500' },
                                        { day: 'Wed', h: 'h-3/4', val: '3.1k', col: 'from-purple-500 to-pink-500' },
                                        { day: 'Thu', h: 'h-2/3', val: '2.5k', col: 'from-blue-500 to-indigo-500' },
                                        { day: 'Fri', h: 'h-5/6', val: '3.8k', col: 'from-emerald-500 to-teal-500' },
                                        { day: 'Sat', h: 'h-1/3', val: '1.5k', col: 'from-amber-500 to-orange-500' },
                                        { day: 'Sun', h: 'h-1/4', val: '0.9k', col: 'from-rose-500 to-pink-500' }
                                    ]" :key="bar.day" class="flex-grow flex flex-col items-center gap-2 group cursor-pointer h-full justify-end">
                                        <span class="text-[9px] font-bold opacity-0 group-hover:opacity-100 transition-opacity bg-slate-950 text-white rounded px-1.5 py-0.5">{{ bar.val }}</span>
                                        <div class="w-full rounded-t-lg bg-gradient-to-t transition-all duration-500 group-hover:scale-x-105" :class="[bar.h, bar.col]"></div>
                                        <span class="text-[10px] font-bold pb-2" :class="isDarkMode ? 'text-slate-650' : 'text-slate-400'">{{ bar.day }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center text-xs mt-4 pt-2 font-bold" :class="isDarkMode ? 'text-slate-550' : 'text-slate-500'">
                                <span>Showing real-time system audit logs</span>
                                <span @click="showFullLogsModal = true" class="text-blue-500 hover:underline cursor-pointer">View full reports →</span>
                            </div>
                        </div>

                        <!-- System Logs Panel -->
                        <div 
                            class="border rounded-2xl p-6"
                            :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333]' : 'bg-white border-slate-200 shadow-sm'"
                        >
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-sm font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-700'">Recent Logs</h4>
                                <button @click="showFullLogsModal = true" class="text-[10px] font-bold text-blue-500 hover:underline">View All →</button>
                            </div>
                            <p class="text-xs mb-4" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Real-time edits tracked on SQLite tables.</p>

                            <div v-if="props.activityLogs && props.activityLogs.length > 0" class="space-y-4 max-h-[360px] overflow-y-auto pr-1">
                                <div v-for="log in props.activityLogs.slice(0, 7)" :key="log.id" class="flex gap-3 items-center">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" :class="log.iconClass">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="min-w-0 flex-grow">
                                        <p class="text-xs font-bold truncate" :class="isDarkMode ? 'text-slate-250' : 'text-slate-800'" :title="log.title">{{ log.title }}</p>
                                        <span class="text-[10px] block" :class="isDarkMode ? 'text-slate-550' : 'text-slate-400'">By {{ log.user }} • {{ log.time }}</span>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="py-8 text-center border-2 border-dashed rounded-xl" :class="isDarkMode ? 'border-slate-800 text-slate-500' : 'border-slate-200 text-slate-400'">
                                <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-xs font-bold">No recent activities logged yet.</p>
                                <p class="text-[10px] mt-1">Actions taken in dashboard will appear here in real-time.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- TAB: HOME PAGE BUILDER -->
                <div v-if="activeTab === 'home'" class="animate-fadeIn space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 sticky top-0 z-50 p-4 sm:px-6 bg-white/70 dark:bg-[#0c101b]/70 backdrop-blur-xl rounded-2xl border border-white/50 dark:border-slate-700/50 shadow-xl shadow-blue-900/5 dark:shadow-black/20 transition-all">
                        <div>
                            <h3 class="text-xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent" :class="isDarkMode ? 'from-blue-400 to-indigo-400' : ''">Home Page Builder</h3>
                            <p class="text-sm mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage dynamic content on the main landing page.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="restoreDefaultHomeSettings()" class="bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-full px-5 py-3 text-sm font-black border border-amber-500/20 transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Redo / Restore Defaults
                            </button>
                            <button @click="submitHomeSettings()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-full px-8 py-3 text-sm font-black shadow-lg shadow-blue-500/25 transition-all duration-300 hover:scale-105 hover:shadow-blue-500/40 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Save Landing Page
                            </button>
                        </div>
                    </div>

                    <form @submit.prevent="submitHomeSettings" class="space-y-6">
                        
                        <!-- Hero Slides -->
                        <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none transition-opacity group-hover:opacity-10">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm2 2h8v8H8V8zm2 2v4h4v-4h-4z"></path></svg>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-lg" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Hero Slideshow</h4>
                                        <p class="text-xs mt-0.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Main scrolling banners at the top of the site.</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label class="cursor-pointer text-[11px] font-extrabold text-emerald-600 hover:text-white hover:bg-emerald-500 px-4 py-2 bg-emerald-50 rounded-full border border-emerald-200 transition-all duration-300 shadow-sm flex items-center gap-1.5 group/btn" :class="isDarkMode ? 'bg-emerald-500/10 border-emerald-500/20 hover:bg-emerald-500 text-emerald-400' : ''">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Bulk Upload Images
                                        <input type="file" multiple accept="image/*" @change="handleMultipleHeroUpload" class="hidden">
                                    </label>
                                    <button type="button" @click="addHeroSlide()" class="text-[11px] font-extrabold text-blue-600 hover:text-white hover:bg-blue-600 px-4 py-2 bg-blue-50 rounded-full border border-blue-200 transition-all duration-300 shadow-sm flex items-center gap-1.5" :class="isDarkMode ? 'bg-blue-500/10 border-blue-500/20 hover:bg-blue-500 text-blue-400' : ''">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        Add Slide
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="toggleHeroCollapse" 
                                        class="text-[11px] font-extrabold px-4 py-2 rounded-full border transition-all duration-300 shadow-sm flex items-center gap-1.5 cursor-pointer"
                                        :class="isDarkMode ? 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200'"
                                    >
                                        <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': !isHeroCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <span>{{ isHeroCollapsed ? 'Expand' : 'Collapse' }}</span>
                                    </button>
                                </div>
                            </div>
                            <div v-show="!isHeroCollapsed" class="space-y-2.5 relative z-10">
                                <div v-for="(slide, idx) in homeSettingsForm.home_hero_slides" :key="'hero-'+idx" class="p-3.5 rounded-xl transition-all duration-200 hover:shadow-sm border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-white'">
                                    <div class="flex flex-wrap lg:flex-nowrap items-center justify-between gap-3">
                                        <!-- Left Side: Badge + Thumbnail + File Picker + Alt Texts -->
                                        <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 min-w-0 flex-1">
                                            <span class="flex items-center justify-center w-6 h-6 rounded-full text-[10px] font-black shrink-0" :class="isDarkMode ? 'bg-indigo-500/20 text-indigo-300' : 'bg-indigo-100 text-indigo-700'">{{ idx + 1 }}</span>

                                            <!-- Thumbnail Preview -->
                                            <div class="shrink-0">
                                                <div v-if="typeof slide.imgUrl === 'string' && slide.imgUrl" @click="openImagePreview(slide.imgUrl)" class="relative group/thumb cursor-pointer" title="Click to view full image">
                                                    <img :src="slide.imgUrl" alt="Preview" class="w-16 h-11 rounded-lg object-cover border shadow-2xs shrink-0 transition-transform group-hover/thumb:scale-105" :class="isDarkMode ? 'border-slate-700' : 'border-slate-200'" />
                                                    <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </div>
                                                </div>
                                                <div v-else-if="slide.imgUrl && typeof slide.imgUrl === 'object'" @click="openImagePreview(slide.imgUrl)" class="relative group/thumb cursor-pointer" title="Click to view full image">
                                                    <img :src="getObjectUrl(slide.imgUrl)" alt="New File Preview" class="w-16 h-11 rounded-lg object-cover border border-indigo-500/50 shadow-2xs shrink-0 transition-transform group-hover/thumb:scale-105" />
                                                    <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </div>
                                                </div>
                                                <div v-else class="w-16 h-11 rounded-lg border-2 border-dashed flex items-center justify-center shrink-0" :class="isDarkMode ? 'border-slate-800 bg-slate-900/50 text-slate-600' : 'border-slate-200 bg-slate-50 text-slate-400'">
                                                    <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            </div>

                                            <!-- Compact File Picker -->
                                            <div class="flex-1 min-w-[180px]">
                                                <input 
                                                    type="file" 
                                                    accept="image/*" 
                                                    @input="slide.imgUrl = $event.target.files[0]" 
                                                    class="w-full rounded-lg text-xs border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-extrabold file:cursor-pointer hover:file:opacity-90 transition-all" 
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-slate-300 file:bg-indigo-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-700 file:bg-indigo-600 file:text-white'"
                                                >
                                                <div v-if="typeof slide.imgUrl === 'string' && slide.imgUrl" class="mt-0.5 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                                    ✓ Saved
                                                </div>
                                                <div v-else-if="slide.imgUrl && typeof slide.imgUrl === 'object'" class="mt-0.5 text-[10px] font-bold text-blue-500 flex items-center gap-1">
                                                    ✨ New File Selected
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Side: Remove Button -->
                                        <button 
                                            type="button" 
                                            @click="removeHeroSlide(idx)" 
                                            class="shrink-0 text-xs font-bold text-red-500 hover:text-white hover:bg-red-500 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 px-3 py-1.5 rounded-lg transition-all flex items-center gap-1"
                                            title="Remove Slide"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Scholarship -->
                        <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none transition-opacity group-hover:opacity-10">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 7.5l-6.5-3.25L12 3.5l6.5 2.75L12 9.5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-lg" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Scholarship Block</h4>
                                        <p class="text-xs mt-0.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Highlight scholarship opportunities on the main page.</p>
                                    </div>
                                </div>
                                <button 
                                    type="button" 
                                    @click="toggleScholarshipCollapse" 
                                    class="text-[11px] font-extrabold px-4 py-2 rounded-full border transition-all duration-300 shadow-sm flex items-center gap-1.5 cursor-pointer"
                                    :class="isDarkMode ? 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200'"
                                >
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': !isScholarshipCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <span>{{ isScholarshipCollapsed ? 'Expand' : 'Collapse' }}</span>
                                </button>
                            </div>
                            <div v-show="!isScholarshipCollapsed" class="space-y-4 relative z-10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-[10px] font-black text-slate-400">EN</span>
                                        </div>
                                        <input type="text" v-model="homeSettingsForm.home_scholarship.title.en" placeholder="Scholarship Title" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-amber-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-slate-50 border-slate-200 focus:bg-white'">
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-[10px] font-black text-slate-400">KM</span>
                                        </div>
                                        <input type="text" v-model="homeSettingsForm.home_scholarship.title.km" placeholder="Scholarship Title" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-amber-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-slate-50 border-slate-200 focus:bg-white'">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="homeSettingsForm.home_scholarship.description.en" 
     
></QuillEditor></div>
                                    <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="homeSettingsForm.home_scholarship.description.km" 
     
></QuillEditor></div>
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                        Footer Highlight Text
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-[10px] font-black text-slate-400">EN</span>
                                            </div>
                                            <input type="text" v-model="homeSettingsForm.home_scholarship.footer_text.en" placeholder="Footer Highlight Text (EN)" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-amber-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-slate-50 border-slate-200 focus:bg-white'">
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-[10px] font-black text-slate-400">KM</span>
                                            </div>
                                            <input type="text" v-model="homeSettingsForm.home_scholarship.footer_text.km" placeholder="Footer Highlight Text (KM)" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-amber-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-slate-50 border-slate-200 focus:bg-white'">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 rounded-xl border transition-all" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50/50'">
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2 flex items-center gap-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Background Cover Image
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                                         <input type="file" accept="image/*" @input="homeSettingsForm.home_scholarship.bg_image = $event.target.files[0]" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-amber-500/30 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:cursor-pointer hover:file:opacity-90 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white file:bg-amber-600 file:text-white' : 'bg-white border-slate-200 file:bg-amber-500 file:text-white'">
                                         
                                         <div v-if="typeof homeSettingsForm.home_scholarship.bg_image === 'string' && homeSettingsForm.home_scholarship.bg_image" @click="openImagePreview(homeSettingsForm.home_scholarship.bg_image)" class="relative group/thumb cursor-pointer w-max" title="Click to view full image">
                                             <img :src="homeSettingsForm.home_scholarship.bg_image" alt="Scholarship Preview" class="w-28 h-16 rounded-xl object-cover border shadow-sm transition-transform group-hover/thumb:scale-105" :class="isDarkMode ? 'border-slate-700' : 'border-slate-200'" />
                                             <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                             </div>
                                         </div>
                                         <div v-else-if="homeSettingsForm.home_scholarship.bg_image && typeof homeSettingsForm.home_scholarship.bg_image === 'object'" @click="openImagePreview(homeSettingsForm.home_scholarship.bg_image)" class="relative group/thumb cursor-pointer w-max" title="Click to view full image">
                                             <img :src="getObjectUrl(homeSettingsForm.home_scholarship.bg_image)" alt="New File Preview" class="w-28 h-16 rounded-xl object-cover border border-amber-500/50 shadow-sm transition-transform group-hover/thumb:scale-105" />
                                             <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                             </div>
                                         </div>
                                     </div>
                                </div>
                            </div>
                        </div>

                        <!-- Four Years -->
                        <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none transition-opacity group-hover:opacity-10">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v12H4V6zm2 2v8h12V8H6z"></path></svg>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-lg" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Four Years Grid</h4>
                                        <p class="text-xs mt-0.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Curriculum or roadmap breakdown for the four years.</p>
                                    </div>
                                </div>
                                <button 
                                    type="button" 
                                    @click="toggleFourYearsCollapse" 
                                    class="text-[11px] font-extrabold px-4 py-2 rounded-full border transition-all duration-300 shadow-sm flex items-center gap-1.5 cursor-pointer"
                                    :class="isDarkMode ? 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200'"
                                >
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': !isFourYearsCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <span>{{ isFourYearsCollapsed ? 'Expand' : 'Collapse' }}</span>
                                </button>
                            </div>
                            <div v-show="!isFourYearsCollapsed" class="grid grid-cols-1 gap-6 relative z-10">
                                <div v-for="(year, idx) in homeSettingsForm.home_four_years" :key="'year-'+idx" class="p-5 rounded-2xl transition-all duration-300 shadow-sm border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="flex items-center justify-center w-6 h-6 rounded-full text-[10px] font-black" :class="isDarkMode ? 'bg-emerald-500/20 text-emerald-300' : 'bg-emerald-100 text-emerald-700'">{{ idx + 1 }}</span>
                                        <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Year Section</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">EN</span></div>
                                            <input type="text" v-model="year.title.en" placeholder="Year Title" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-emerald-500/30 pl-9 py-2" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">KM</span></div>
                                            <input type="text" v-model="year.title.km" placeholder="Year Title" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-emerald-500/30 pl-9 py-2" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-white text-black rounded-xl min-h-[150px] overflow-hidden border border-slate-200"><QuillEditor theme="snow" contentType="html" v-model:content="year.description.en"></QuillEditor></div>
                                        <div class="bg-white text-black rounded-xl min-h-[150px] overflow-hidden border border-slate-200"><QuillEditor theme="snow" contentType="html" v-model:content="year.description.km"></QuillEditor></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Video Section Settings -->
                        <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none transition-opacity group-hover:opacity-10">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M10 15l5.19-3L10 9v6m11.56-7.83c.13.47.22 1.1.28 1.9.07.8.1 1.49.1 2.09s-.03 1.29-.1 2.09c-.06.8-.15 1.43-.28 1.9-.32 1.22-1.28 2.18-2.5 2.5-.47.13-1.1.22-1.9.28-.8.07-1.49.1-2.09.1s-1.29-.03-2.09-.1c-.8-.06-1.43-.15-1.9-.28-1.22-.32-2.18-1.28-2.5-2.5-.13-.47-.22-1.1-.28-1.9C2.03 13.29 2 12.6 2 12s.03-1.29.1-2.09c.06-.8.15-1.43.28-1.9.32-1.22 1.28-2.18 2.5-2.5.47-.13 1.1-.22 1.9-.28.8-.07 1.49-.1 2.09-.1s1.29.03 2.09.1c.8.06 1.43.15 1.9.28 1.22.32 2.18 1.28 2.5 2.5z"></path></svg>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 relative z-10">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-2xl shadow-inner border" :class="isDarkMode ? 'bg-[#151d2c] border-[#222e45] text-red-400' : 'bg-red-50 border-red-100 text-red-600'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-lg" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Home Video Section Settings</h4>
                                        <p class="text-xs mt-0.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage the video presentation on the homepage.</p>
                                    </div>
                                </div>
                                <button 
                                    type="button" 
                                    @click="toggleVideoSectionCollapse" 
                                    class="text-[11px] font-extrabold px-4 py-2 rounded-full border transition-all duration-300 shadow-sm flex items-center gap-1.5 cursor-pointer"
                                    :class="isDarkMode ? 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200'"
                                >
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': !isVideoSectionCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <span>{{ isVideoSectionCollapsed ? 'Expand' : 'Collapse' }}</span>
                                </button>
                            </div>
                            
                            <div v-show="!isVideoSectionCollapsed" class="space-y-4 relative z-10">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-500">YouTube Video Embed URL</label>
                                        <input type="text" v-model="homeSettingsForm.home_video_url" placeholder="https://www.youtube.com/embed/G44lO3-SuuI" class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500'">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-xs font-bold text-slate-500">Background Color (Fallback/Accent)</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="homeSettingsForm.home_video_bg_color" class="h-9 w-12 rounded border p-1 cursor-pointer bg-transparent">
                                            <input type="text" v-model="homeSettingsForm.home_video_bg_color" placeholder="#0f2154" class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500'">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-500">Background Image</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                                         <div>
                                             <input type="file" accept="image/*" @input="homeSettingsForm.home_video_bg_image = $event.target.files[0]" class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all" :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] text-white focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-white border-slate-200 focus:border-blue-500 file:bg-blue-600 file:text-white'">
                                         </div>
                                         <div v-if="typeof homeSettingsForm.home_video_bg_image === 'string' && homeSettingsForm.home_video_bg_image" @click="openImagePreview(homeSettingsForm.home_video_bg_image)" class="relative group/thumb cursor-pointer w-max" title="Click to view full image">
                                             <img :src="homeSettingsForm.home_video_bg_image" alt="Background preview" class="w-32 h-16 rounded-lg object-cover border shadow-sm transition-transform group-hover/thumb:scale-105" :class="isDarkMode ? 'border-slate-700' : 'border-slate-200'" />
                                             <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                             </div>
                                         </div>
                                         <div v-else-if="homeSettingsForm.home_video_bg_image && typeof homeSettingsForm.home_video_bg_image === 'object'" @click="openImagePreview(homeSettingsForm.home_video_bg_image)" class="relative group/thumb cursor-pointer w-max" title="Click to view full image">
                                             <img :src="getObjectUrl(homeSettingsForm.home_video_bg_image)" alt="New File Preview" class="w-32 h-16 rounded-lg object-cover border border-blue-500/50 shadow-sm transition-transform group-hover/thumb:scale-105" />
                                             <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                             </div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activities -->
                        <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none transition-opacity group-hover:opacity-10">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"></path></svg>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-black text-lg" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Students Activities Slides</h4>
                                            <span class="text-[11px] font-extrabold px-2.5 py-0.5 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20">
                                                {{ homeSettingsForm.home_activities_slides.length }} {{ homeSettingsForm.home_activities_slides.length === 1 ? 'Slide' : 'Slides' }}
                                            </span>
                                        </div>
                                        <p class="text-xs mt-0.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Gallery slider showcasing university life.</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <label class="cursor-pointer text-[11px] font-extrabold text-emerald-600 hover:text-white hover:bg-emerald-500 px-4 py-2 bg-emerald-50 rounded-full border border-emerald-200 transition-all duration-300 shadow-sm flex items-center gap-1.5 group/btn" :class="isDarkMode ? 'bg-emerald-500/10 border-emerald-500/20 hover:bg-emerald-500 text-emerald-400' : ''">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Bulk Upload
                                        <input type="file" multiple accept="image/*" @change="handleMultipleActivityUpload" class="hidden">
                                    </label>
                                    <button type="button" @click="addActivitySlide()" class="text-[11px] font-extrabold text-cyan-600 hover:text-white hover:bg-cyan-600 px-4 py-2 bg-cyan-50 rounded-full border border-cyan-200 transition-all duration-300 shadow-sm flex items-center gap-1.5" :class="isDarkMode ? 'bg-cyan-500/10 border-cyan-500/20 hover:bg-cyan-500 text-cyan-400' : ''">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        Add Activity
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="toggleActivitiesCollapse" 
                                        class="text-[11px] font-extrabold px-4 py-2 rounded-full border transition-all duration-300 shadow-sm flex items-center gap-1.5 cursor-pointer"
                                        :class="isDarkMode ? 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200'"
                                        :title="isActivitiesCollapsed ? 'Expand Gallery Slides' : 'Collapse Gallery Slides'"
                                    >
                                        <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': !isActivitiesCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <span>{{ isActivitiesCollapsed ? 'Expand' : 'Collapse' }}</span>
                                    </button>
                                </div>
                            </div>
                            <div v-show="!isActivitiesCollapsed" class="space-y-2.5 relative z-10">
                                <div v-for="(slide, idx) in homeSettingsForm.home_activities_slides" :key="'act-'+idx" class="p-3.5 rounded-xl transition-all duration-200 hover:shadow-sm border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-white'">
                                    <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-3">
                                        <!-- Left Side: Badge + Small Image Thumbnail + File Picker -->
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            <span class="flex items-center justify-center w-6 h-6 rounded-full text-[10px] font-black shrink-0" :class="isDarkMode ? 'bg-cyan-500/20 text-cyan-300' : 'bg-cyan-100 text-cyan-700'">{{ idx + 1 }}</span>
                                            
                                            <!-- Compact Image Thumbnail Preview (Click to view full size) -->
                                            <div class="shrink-0">
                                                <div v-if="typeof slide.img === 'string' && slide.img" @click="openImagePreview(slide.img)" class="relative group/thumb cursor-pointer" title="Click to view full image">
                                                    <img :src="slide.img" alt="Preview" class="w-16 h-12 rounded-lg object-cover border shadow-2xs shrink-0 transition-transform group-hover/thumb:scale-105" :class="isDarkMode ? 'border-slate-700' : 'border-slate-200'" />
                                                    <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </div>
                                                </div>
                                                <div v-else-if="slide.img && typeof slide.img === 'object'" @click="openImagePreview(slide.img)" class="relative group/thumb cursor-pointer" title="Click to view full image">
                                                    <img :src="getObjectUrl(slide.img)" alt="New File Preview" class="w-16 h-12 rounded-lg object-cover border border-cyan-500/50 shadow-2xs shrink-0 transition-transform group-hover/thumb:scale-105" />
                                                    <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </div>
                                                </div>
                                                <div v-else class="w-16 h-12 rounded-lg border-2 border-dashed flex items-center justify-center shrink-0" :class="isDarkMode ? 'border-slate-800 bg-slate-900/50 text-slate-600' : 'border-slate-200 bg-slate-50 text-slate-400'">
                                                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            </div>

                                            <!-- Compact File Picker -->
                                            <div class="flex-1 min-w-0">
                                                <input 
                                                    type="file" 
                                                    accept="image/*" 
                                                    @input="slide.img = $event.target.files[0]" 
                                                    class="w-full rounded-lg text-xs border focus:outline-none focus:ring-2 focus:ring-cyan-500/30 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-extrabold file:cursor-pointer hover:file:opacity-90 transition-all" 
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-slate-300 file:bg-cyan-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-700 file:bg-cyan-600 file:text-white'"
                                                >
                                                <div v-if="typeof slide.img === 'string' && slide.img" class="mt-0.5 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                                    ✓ Saved
                                                </div>
                                                <div v-else-if="slide.img && typeof slide.img === 'object'" class="mt-0.5 text-[10px] font-bold text-cyan-500 flex items-center gap-1">
                                                    ✨ New File Ready
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Side: Remove Button -->
                                        <button 
                                            type="button" 
                                            @click="removeActivitySlide(idx)" 
                                            class="shrink-0 text-xs font-bold text-red-500 hover:text-white hover:bg-red-500 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 px-3 py-1.5 rounded-lg transition-all flex items-center gap-1"
                                            title="Remove Slide"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Graduate Attributes Section -->
                        <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-lg" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Graduate Attributes Section</h4>
                                        <p class="text-xs mt-0.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage section title, attribute cards, and featured image.</p>
                                    </div>
                                </div>
                                <button 
                                    type="button" 
                                    @click="toggleGradAttributesCollapse" 
                                    class="text-[11px] font-extrabold px-4 py-2 rounded-full border transition-all duration-300 shadow-sm flex items-center gap-1.5 cursor-pointer"
                                    :class="isDarkMode ? 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200'"
                                >
                                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': !isGradAttributesCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <span>{{ isGradAttributesCollapsed ? 'Expand' : 'Collapse' }}</span>
                                </button>
                            </div>

                            <div v-show="!isGradAttributesCollapsed" class="space-y-6 relative z-10">
                                <!-- Section Main Title -->
                                <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                    <label class="block text-xs font-black uppercase tracking-wider mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Section Title</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">EN</span></div>
                                            <input type="text" v-model="homeSettingsForm.home_graduate_attributes.title.en" placeholder="Graduate Attributes" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">KM</span></div>
                                            <input type="text" v-model="homeSettingsForm.home_graduate_attributes.title.km" placeholder="គុណសម្បត្តិនៃអ្នកបញ្ចប់ការសិក្សា" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Graduate Attribute Cards -->
                                <div v-for="(card, idx) in homeSettingsForm.home_graduate_attributes.cards" :key="idx" class="p-4 rounded-2xl border space-y-3 mb-4" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-black uppercase tracking-wider text-indigo-500">Attribute Card #{{ idx + 1 }}</span>
                                        <div class="flex items-center gap-3">
                                            <button v-if="idx > 0" type="button" @click="moveGradAttributeCardUp(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Up">↑ Up</button>
                                            <button v-if="idx < homeSettingsForm.home_graduate_attributes.cards.length - 1" type="button" @click="moveGradAttributeCardDown(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Down">↓ Down</button>
                                            <button type="button" @click="removeGradAttributeCard(idx)" class="text-red-500 hover:text-red-400 text-xs font-bold">Remove ✕</button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">EN</span></div>
                                            <input type="text" v-model="card.title.en" placeholder="Card Title" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">KM</span></div>
                                            <input type="text" v-model="card.title.km" placeholder="ចំណងជើងកាត" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <textarea v-model="card.description.en" rows="2" placeholder="Description (EN)" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 p-3 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'"></textarea>
                                        <textarea v-model="card.description.km" rows="2" placeholder="ការពិពណ៌នា (KM)" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 p-3 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'"></textarea>
                                    </div>
                                    <div class="pt-2">
                                        <label class="block text-xs font-black uppercase tracking-wider mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Card Feature Image (Optional)</label>
                                        <input type="file" accept="image/*" @input="card.image = $event.target.files[0]" class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:cursor-pointer hover:file:opacity-90 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white file:bg-indigo-600 file:text-white' : 'bg-white border-slate-200 file:bg-indigo-600 file:text-white'">
                                        <div v-if="typeof card.image === 'string' && card.image" class="mt-2 flex items-center gap-2">
                                            <img :src="card.image" @click="openImagePreview(card.image)" alt="Preview" class="w-16 h-12 rounded-lg object-cover border shadow-2xs shrink-0 cursor-pointer" />
                                            <span class="text-[10px] font-black text-emerald-500">Image Saved</span>
                                            <button type="button" @click="card.image = ''" class="text-[10px] font-bold text-red-500 hover:underline ml-2">Remove Image</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-center mt-2">
                                    <button type="button" @click="addGradAttributeCard" class="bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-extrabold px-4 py-2 rounded-full shadow-sm hover:shadow transition-all flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        Add Attribute Card
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 7: HOME UNIVERSITY STATISTICS COUNTERS -->
                        <div 
                            class="rounded-3xl p-6 sm:p-8 border shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden transition-all duration-300 mt-6"
                            :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'"
                        >
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b mb-6 gap-4 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-lg" :class="isDarkMode ? 'text-white' : 'text-slate-900'">University Statistics & Counter Section</h4>
                                        <p class="text-xs mt-0.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Add, edit, reorder, or remove numerical counters displayed on home page.</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button 
                                        type="button" 
                                        @click="addStatItem" 
                                        class="bg-amber-600 hover:bg-amber-500 text-white text-[11px] font-extrabold px-4 py-2 rounded-full shadow-sm hover:shadow transition-all flex items-center gap-1.5 cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        Add Counter Item
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="toggleStatsCollapse" 
                                        class="text-[11px] font-extrabold px-4 py-2 rounded-full border transition-all duration-300 shadow-sm flex items-center gap-1.5 cursor-pointer"
                                        :class="isDarkMode ? 'bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700' : 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-slate-200'"
                                    >
                                        <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="{ 'rotate-180': !isStatsCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <span>{{ isStatsCollapsed ? 'Expand' : 'Collapse' }}</span>
                                    </button>
                                </div>
                            </div>

                            <div v-show="!isStatsCollapsed" class="space-y-4 relative z-10">
                                <div v-for="(item, idx) in homeSettingsForm.home_stats" :key="'stat-'+idx" class="p-4 rounded-2xl border transition-all duration-200" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-slate-50'">
                                    <div class="flex items-center justify-between gap-3 mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-full bg-amber-500/20 text-amber-500 flex items-center justify-center text-xs font-black">{{ idx + 1 }}</span>
                                            <span class="text-xs font-black uppercase tracking-wider" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Stat Counter Card #{{ idx + 1 }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button type="button" @click="moveStatUp(idx)" :disabled="idx === 0" class="p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-800 disabled:opacity-30 text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                            </button>
                                            <button type="button" @click="moveStatDown(idx)" :disabled="idx === homeSettingsForm.home_stats.length - 1" class="p-1 rounded hover:bg-slate-200 dark:hover:bg-slate-800 disabled:opacity-30 text-slate-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                            <button type="button" @click="removeStatItem(idx)" class="p-1 rounded text-red-500 hover:bg-red-500/10">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Count Number / Value</label>
                                            <input type="text" v-model="item.value" placeholder="e.g. 1000+ or 100%" class="w-full rounded-xl text-sm border px-3 py-2 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Label Title (EN)</label>
                                            <input type="text" v-model="item.label.en" placeholder="Active Students" class="w-full rounded-xl text-sm border px-3 py-2 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Label Title (KM)</label>
                                            <input type="text" v-model="item.label.km" placeholder="និស្សិតសរុប" class="w-full rounded-xl text-sm border px-3 py-2 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Icon Theme</label>
                                        <select v-model="item.icon" class="w-full sm:w-1/3 rounded-xl text-sm border px-3 py-2 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                            <option value="building">🏫 Campus / Building</option>
                                            <option value="student">🎓 Graduation / Students</option>
                                            <option value="computer">💻 Computer / Digital Devices</option>
                                            <option value="user">👨‍🏫 Professors / Lecturers</option>
                                            <option value="book">📚 Books / Courses</option>
                                            <option value="trophy">🏆 Awards / Achievements</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- TAB: NAVIGATION TREE BUILDER -->
                <div v-if="activeTab === 'navigation'" class="animate-fadeIn space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-8 items-start">
                        
                        <!-- List Tree -->
                        <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none transition-opacity group-hover:opacity-10">
                                <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h-3v2h3v3h-2v2h4v-7z"></path></svg>
                            </div>

                            <div class="flex justify-between items-center mb-6 relative z-10">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Menu Navigation Tree</h3>
                                        <p class="text-sm mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage structural mega menus and standard top-level header links.</p>
                                    </div>
                                </div>
                                <button type="button" @click="restoreDefaultNavigation()" class="bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-xl px-4 py-2 text-xs font-black border border-amber-500/20 transition-all flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Redo / Restore Defaults
                                </button>
                            </div>

                            <div class="space-y-5 relative z-10">
                                <div 
                                    v-for="item in props.navigationItems.filter(i => !i.parent_id)" 
                                    :key="item.id" 
                                    class="border rounded-2xl p-5 transition-all duration-300 hover:shadow-md"
                                    :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] hover:border-indigo-500/30' : 'bg-slate-50/50 border-slate-200 hover:border-indigo-200 hover:bg-white'"
                                >
                                    <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 min-w-0 flex-1 flex-wrap sm:flex-nowrap">
                                            <span class="shrink-0 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded bg-indigo-500/10 border border-indigo-500/20 text-indigo-500" :class="isDarkMode ? 'text-indigo-400' : ''">Level 1</span>
                                            <button type="button" @click="navigateToContent(item)" title="Click to view/edit page content" class="font-black text-base hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-left flex items-center gap-1.5 group/title min-w-0 max-w-[260px] sm:max-w-xs shrink">
                                                <span class="truncate">{{ getAdminLabel(item.label) }}</span>
                                                <svg class="w-3.5 h-3.5 opacity-0 group-hover/title:opacity-100 transition-opacity text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            <a :href="item.href || '#'" target="_blank" :title="item.href || '/'" class="text-xs font-mono px-2 py-0.5 rounded-md hover:underline flex items-center gap-1 min-w-0 max-w-[200px] sm:max-w-[280px] truncate shrink" :class="isDarkMode ? 'bg-slate-800 text-slate-400 hover:text-white' : 'bg-slate-100 text-slate-500 hover:text-indigo-600'">
                                                <span class="truncate">{{ item.href || '/' }}</span>
                                                <svg v-if="item.href && item.href !== '#'" class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0 opacity-80 hover:opacity-100 transition-opacity ml-auto">
                                            <button type="button" @click="openViewNavItemModal(item)" title="View Link Details" class="px-2.5 py-1.5 rounded-xl text-emerald-600 hover:text-white hover:bg-emerald-600 border border-emerald-200 dark:border-emerald-500/30 dark:bg-emerald-500/10 transition-all shadow-xs flex items-center gap-1 text-xs font-extrabold">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" @click="startEditNavItem(item)" title="Edit Link Settings" class="px-2.5 py-1.5 rounded-xl text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-200 dark:border-blue-500/30 dark:bg-blue-500/10 transition-all shadow-xs flex items-center gap-1 text-xs font-extrabold">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span>Edit</span>
                                            </button>
                                            <button type="button" @click="deleteNavItem(item.id)" title="Delete Link" class="px-2.5 py-1.5 rounded-xl text-red-500 hover:text-white hover:bg-red-500 border border-red-200 dark:border-red-500/30 dark:bg-red-500/10 transition-all shadow-xs flex items-center gap-1 text-xs font-extrabold">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>Delete</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Sub-links Level 2 -->
                                    <div class="pl-6 mt-4 space-y-3 border-l-2 border-indigo-500/20 ml-2">
                                        <div 
                                            v-for="child in props.navigationItems.filter(i => i.parent_id === item.id)" 
                                            :key="child.id" 
                                            class="border rounded-xl p-4 transition-all duration-300 shadow-sm hover:shadow"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]/70' : 'bg-white border-slate-200'"
                                        >
                                            <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-3">
                                                <div class="flex items-center gap-3 min-w-0 flex-1 flex-wrap sm:flex-nowrap">
                                                    <span class="shrink-0 text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20 text-emerald-600" :class="isDarkMode ? 'text-emerald-400' : ''">Level 2</span>
                                                    <button type="button" @click="openViewNavItemModal(child)" title="Click to view node details" class="font-extrabold text-sm hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-left flex items-center gap-1 group/childtitle min-w-0 max-w-[220px] sm:max-w-[260px] shrink">
                                                        <span class="truncate">{{ getAdminLabel(child.label) }}</span>
                                                        <svg class="w-3 h-3 opacity-0 group-hover/childtitle:opacity-100 transition-opacity text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    </button>
                                                    <a :href="child.href || '#'" target="_blank" :title="child.href || '/'" class="text-[11px] font-mono px-2 py-0.5 rounded-md hover:underline flex items-center gap-1 min-w-0 max-w-[180px] sm:max-w-[250px] truncate shrink" :class="isDarkMode ? 'bg-slate-800 text-slate-400 hover:text-white' : 'bg-slate-50 text-slate-500 hover:text-indigo-600'">
                                                        <span class="truncate">{{ child.href || '/' }}</span>
                                                        <svg v-if="child.href && child.href !== '#'" class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    </a>
                                                </div>
                                                <div class="flex items-center gap-1.5 shrink-0 opacity-80 hover:opacity-100 transition-opacity ml-auto">
                                                    <button type="button" @click="openViewNavItemModal(child)" title="View Link Details" class="px-2 py-1 rounded-lg text-emerald-600 hover:bg-emerald-500/10 transition-colors flex items-center gap-1 text-xs font-bold">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View
                                                    </button>
                                                    <button type="button" @click="startEditNavItem(child)" title="Edit Link Settings" class="px-2 py-1 rounded-lg text-blue-600 hover:bg-blue-500/10 transition-colors flex items-center gap-1 text-xs font-bold">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit
                                                    </button>
                                                    <button type="button" @click="deleteNavItem(child.id)" title="Delete Link" class="px-2 py-1 rounded-lg text-red-500 hover:bg-red-500/10 transition-colors flex items-center gap-1 text-xs font-bold">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Mega-links Level 3 -->
                                            <div class="pl-5 mt-3 space-y-2 border-l-2 border-emerald-500/20 ml-1">
                                                <div 
                                                    v-for="subChild in props.navigationItems.filter(i => i.parent_id === child.id)" 
                                                    :key="subChild.id" 
                                                    class="border rounded-lg p-3 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 text-xs transition-all hover:border-emerald-200"
                                                    :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333]/50' : 'bg-slate-50 border-slate-100'"
                                                >
                                                    <div class="flex items-center gap-2.5 min-w-0 flex-1 flex-wrap sm:flex-nowrap">
                                                        <span class="text-[8px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded bg-amber-500/10 border border-amber-500/20 text-amber-600 shrink-0" :class="isDarkMode ? 'text-amber-400' : ''">Level 3</span>
                                                        <button type="button" @click="openViewNavItemModal(subChild)" title="Click to view node details" class="font-bold hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors text-left truncate min-w-0 max-w-[180px] sm:max-w-[220px] shrink">
                                                            <span class="truncate">{{ getAdminLabel(subChild.label) }}</span>
                                                        </button>
                                                        <a :href="subChild.href || '#'" target="_blank" :title="subChild.href || '/'" class="text-[10px] font-mono hover:underline truncate min-w-0 max-w-[140px] sm:max-w-[220px] shrink flex items-center gap-0.5" :class="isDarkMode ? 'text-slate-500 hover:text-white' : 'text-slate-400 hover:text-indigo-600'">
                                                            <span class="truncate">{{ subChild.href || '/' }}</span>
                                                            <span class="shrink-0">↗</span>
                                                        </a>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 shrink-0 opacity-80 hover:opacity-100 transition-opacity ml-auto">
                                                        <button type="button" @click="openViewNavItemModal(subChild)" title="View Link Details" class="p-1 rounded text-emerald-600 hover:bg-emerald-500/10 transition-colors flex items-center gap-0.5 text-[11px] font-bold">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View
                                                        </button>
                                                        <button type="button" @click="startEditNavItem(subChild)" title="Edit Link Settings" class="p-1 rounded text-blue-500 hover:bg-blue-500/10 transition-colors flex items-center gap-0.5 text-[11px] font-bold">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit
                                                        </button>
                                                        <button type="button" @click="deleteNavItem(subChild.id)" title="Delete Link" class="p-1 rounded text-red-500 hover:bg-red-500/10 transition-colors flex items-center gap-0.5 text-[11px] font-bold">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Card -->
                        <div class="sticky top-6">
                            <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 group" :class="isDarkMode ? 'bg-[#0f1524] border border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                                <div class="absolute top-0 right-0 p-6 opacity-10 pointer-events-none transition-opacity group-hover:opacity-20">
                                    <span class="text-5xl">✨</span>
                                </div>

                                <div class="flex items-center gap-3 mb-6 relative z-10">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-lg" :class="editingNavItem ? 'bg-gradient-to-br from-amber-400 to-orange-500 shadow-amber-500/30' : 'bg-gradient-to-br from-blue-500 to-indigo-600 shadow-blue-500/30'">
                                        <svg v-if="editingNavItem" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black" :class="isDarkMode ? 'text-white' : 'text-slate-900'">
                                            {{ editingNavItem ? 'Edit Link Node' : 'Register New Link' }}
                                        </h3>
                                        <p class="text-sm mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Set parameters to render navigation items dynamically.</p>
                                    </div>
                                </div>

                                <form @submit.prevent="submitNavItem" class="space-y-5 relative z-10">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Link Label (English)</label>
                                            <div class="absolute bottom-[10px] left-3 pointer-events-none text-slate-400 font-black text-[10px]">EN</div>
                                            <input 
                                                type="text" 
                                                v-model="navItemForm.label.en" 
                                                required 
                                                class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 pl-9 py-2.5 transition-all"
                                                :class="isDarkMode 
                                                    ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500/50 focus:ring-indigo-500/20' 
                                                    : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-indigo-500/50 focus:ring-indigo-500/20'" 
                                                placeholder="e.g. About DUC" 
                                            />
                                        </div>
                                        <div class="relative">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Link Label (Khmer)</label>
                                            <div class="absolute bottom-[10px] left-3 pointer-events-none text-slate-400 font-black text-[10px]">KM</div>
                                            <input 
                                                type="text" 
                                                v-model="navItemForm.label.km" 
                                                class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 pl-9 py-2.5 transition-all"
                                                :class="isDarkMode 
                                                    ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500/50 focus:ring-indigo-500/20' 
                                                    : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-indigo-500/50 focus:ring-indigo-500/20'" 
                                                placeholder="e.g. អំពីសាកលវិទ្យាល័យ" 
                                            />
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Destination Href Path</label>
                                        <div class="absolute bottom-[10px] left-3 pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        </div>
                                        <input 
                                            type="text" 
                                            v-model="navItemForm.href" 
                                            class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 pl-9 py-2.5 transition-all font-mono"
                                            :class="isDarkMode 
                                                ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500/50 focus:ring-indigo-500/20' 
                                                : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-indigo-500/50 focus:ring-indigo-500/20'" 
                                            placeholder="e.g. /about, /rector, /department/1/graphic-design" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Parent Hierarchy Node</label>
                                        <select 
                                            v-model="navItemForm.parent_id" 
                                            class="w-full rounded-xl text-sm border focus:outline-none focus:ring-2 px-3 py-2.5 transition-all cursor-pointer"
                                            :class="isDarkMode 
                                                ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500/50 focus:ring-indigo-500/20' 
                                                : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-indigo-500/50 focus:ring-indigo-500/20'"
                                        >
                                            <option value="">-- Root Level link (No Parent) --</option>
                                            <option v-for="parent in props.navigationItems.filter(i => !i.parent_id || !props.navigationItems.find(p => p.id === i.parent_id)?.parent_id)" :key="parent.id" :value="parent.id">
                                                {{ parent.label }}
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">SVG Icon Vector Markup</label>
                                        <textarea 
                                            v-model="navItemForm.icon" 
                                            rows="2" 
                                            class="w-full rounded-xl text-xs font-mono border focus:outline-none focus:ring-2 px-3 py-3 transition-all"
                                        :class="isDarkMode 
                                            ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 focus:ring-blue-500/10' 
                                            : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-600 focus:ring-blue-600/10'" 
                                        placeholder="<svg ...>...</svg>"
                                    ></textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Priority Index (Sorting Order)</label>
                                    <input 
                                        type="number" 
                                        v-model="navItemForm.order" 
                                        class="w-full rounded-xl text-sm border focus:outline-none focus:ring-4 transition-all"
                                        :class="isDarkMode 
                                            ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 focus:ring-blue-500/10' 
                                            : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-600 focus:ring-blue-600/10'" 
                                    />
                                </div>
                                <div class="flex gap-3 pt-2">
                                    <button type="submit" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-2.5 text-xs font-black shadow-lg shadow-blue-500/10 transition-colors">
                                        {{ editingNavItem ? 'Save Changes' : 'Create Menu Link' }}
                                    </button>
                                    <button 
                                        v-if="editingNavItem" 
                                        type="button" 
                                        @click="cancelEditNavItem" 
                                        class="rounded-xl px-5 py-2.5 text-xs font-bold border transition-colors"
                                        :class="isDarkMode 
                                            ? 'bg-slate-800 border-slate-700 hover:bg-slate-700 text-slate-300' 
                                            : 'bg-slate-100 border-slate-200 hover:bg-slate-250 text-slate-700'"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: PAGES & CUSTOM CONTENT -->
                <div v-if="activeTab === 'pages'" class="animate-fadeIn space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8 items-start">
                        
                        <!-- List Pages Sidebar -->
                        <div class="sticky top-0 z-10 max-h-[calc(100vh-3rem)] overflow-y-auto rounded-3xl p-6 sm:p-8 relative transition-all duration-300 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] border" :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'">
                            <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none transition-opacity">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 2l5 5h-5V4zM6 20V4h5v7h7v9H6z"></path></svg>
                            </div>

                            <div class="flex items-center justify-between mb-4 relative z-10">
                                <div class="flex items-center gap-2 pl-2">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h4 class="text-sm font-black uppercase tracking-widest" :class="isDarkMode ? 'text-white' : 'text-slate-800'">Pages</h4>
                                </div>
                                <button type="button" @click="restoreDefaultPageContent('all')" title="Restore Default Pages" class="text-[10px] font-extrabold text-amber-600 dark:text-amber-400 bg-amber-500/10 hover:bg-amber-500 hover:text-white px-2.5 py-1.5 rounded-xl transition-all border border-amber-500/20 shadow-sm flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Redo
                                </button>
                            </div>

                            <div class="flex gap-2 mb-3 relative z-10">
                                <button @click="startCreatePage('custom')" class="flex-1 py-2 text-[10px] font-extrabold rounded-xl bg-blue-500/10 text-blue-600 hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-500/30 transition-all border border-blue-500/20">+ Custom Page</button>
                                <button @click="startCreatePage('office')" class="flex-1 py-2 text-[10px] font-extrabold rounded-xl bg-amber-500/10 text-amber-600 hover:bg-amber-500 hover:text-white hover:shadow-lg hover:shadow-amber-500/30 transition-all border border-amber-500/20">+ Office</button>
                            </div>

                            <!-- Page Search Bar -->
                            <div class="mb-3 relative z-10">
                                <input 
                                    type="text" 
                                    v-model="pagesSearchQuery" 
                                    placeholder="🔍 Search page or office..." 
                                    class="w-full text-xs font-medium rounded-xl border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition-all" 
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white placeholder-slate-500' : 'bg-slate-50 border-slate-200 text-slate-800 placeholder-slate-400'"
                                />
                            </div>

                            <div class="space-y-1.5 relative z-10 max-h-[500px] overflow-y-auto pr-1">
                                <button 
                                    v-for="page in filteredPageContents" 
                                    :key="page.id"
                                    @click="startEditPage(page)"
                                    class="w-full text-left px-4 py-3 rounded-xl text-xs font-bold transition-all flex items-center justify-between group"
                                    :class="selectedPage && selectedPage.id === page.id 
                                        ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' 
                                        : (isDarkMode ? 'text-slate-400 hover:bg-[#1a2333] hover:text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border border-transparent hover:border-slate-100')"
                                >
                                    <span>{{ parseTranslatable(page.title).en || parseTranslatable(page.title).km || page.title }}</span>
                                    <span v-if="page.is_office" class="text-[9px] uppercase font-black px-2 py-1 rounded-md transition-colors shrink-0 ml-2" :class="selectedPage && selectedPage.id === page.id ? 'bg-white/20 text-white' : 'bg-amber-500/10 text-amber-600 group-hover:bg-amber-500/20'">Office</span>
                                </button>
                                <div v-if="filteredPageContents.length === 0" class="text-center py-6 text-xs text-slate-500">
                                    No pages found matching "{{ pagesSearchQuery }}".
                                </div>
                            </div>
                        </div>

                        <!-- Editor Form Panel -->
                        <div class="rounded-3xl p-6 sm:p-8 relative transition-all duration-300 border shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]" :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'">
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none transition-opacity overflow-hidden rounded-3xl">
                                <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M11 2v4.09C13.29 6.27 15.35 7.15 17 8.52V4.5C17 3.12 14.31 2 11 2zm6 7.5c-1.39-1.12-3.52-1.91-6-2.09V20.1C14.33 19.92 17 18.24 17 16V9.5zM4.5 9.5v6.5C4.5 18.24 7.17 19.92 10 20.1V7.41c-2.48.18-4.61.97-6 2.09zm0-5V8.52c1.65-1.37 3.71-2.25 6-2.43V2c-3.31 0-6 1.12-6 2.5z"></path></svg>
                            </div>

                            <!-- Empty view -->
                            <div v-if="!selectedPage" class="flex flex-col items-center justify-center h-[400px] relative z-10">
                                <div class="w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800/50 flex items-center justify-center text-slate-400 mb-6 shadow-inner">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <h3 class="text-lg font-black mb-2" :class="isDarkMode ? 'text-white' : 'text-slate-800'">No Page Selected</h3>
                                <p class="text-xs font-bold text-slate-500 text-center max-w-[250px]">Select a page content record from the left list to load the CMS editor workspace.</p>
                            </div>

                            <!-- Live form -->
                            <form v-else @submit.prevent="submitPage" class="space-y-8 relative z-10">
                                <div class="flex flex-col gap-4 bg-slate-50/50 dark:bg-[#090d16]/50 p-5 rounded-2xl border border-slate-100 dark:border-[#1a2333]">
                                    <!-- Title Row (Bilingual Title Fields) -->
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-md shrink-0" :class="selectedPage.id ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-blue-500/10 text-blue-500 border border-blue-500/20'">
                                                {{ selectedPage.id ? 'Edit Mode' : 'Create Mode' }} {{ pageContentForm.is_office ? 'Office' : 'Page' }}
                                            </span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Page / Office Title (EN & KM)</span>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">EN</span></div>
                                                <input type="text" v-model="pageContentForm.title.en" placeholder="Page Title (English)" class="w-full rounded-xl text-sm font-bold border pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-white border-slate-200 text-slate-900 focus:border-blue-500'" />
                                            </div>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">KM</span></div>
                                                <input type="text" v-model="pageContentForm.title.km" placeholder="ចំណងជើងទំព័រ/ការិយាល័យ (ខ្មែរ)" class="w-full rounded-xl text-sm font-bold border pl-9 py-2.5 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-white border-slate-200 text-slate-900 focus:border-blue-500'" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Controls + Buttons Row -->
                                    <div class="flex flex-wrap items-center gap-3">
                                        <!-- Page Slug -->
                                        <div class="flex items-center gap-2">
                                            <label class="text-[10px] font-black tracking-widest uppercase text-slate-500 shrink-0">Page Slug</label>
                                            <div class="flex items-center w-44 shadow-sm rounded-xl overflow-hidden border transition-all" :class="isDarkMode ? 'border-[#1a2333] focus-within:border-blue-500/50 focus-within:ring-2 focus-within:ring-blue-500/20' : 'border-slate-200 focus-within:border-blue-500/50 focus-within:ring-2 focus-within:ring-blue-500/20'">
                                                <span class="px-3 py-2 text-xs font-mono font-black" :class="isDarkMode ? 'bg-[#0c101b] text-slate-600' : 'bg-slate-100 text-slate-400'">/</span>
                                                <input 
                                                    type="text" 
                                                    v-model="pageContentForm.slug" 
                                                    class="w-full text-xs font-mono font-black py-2 px-3 focus:outline-none"
                                                    :class="isDarkMode ? 'bg-[#090d16] text-white' : 'bg-white text-slate-900'" 
                                                    placeholder="page-url-path"
                                                />
                                            </div>
                                        </div>

                                        <!-- Title Size -->
                                        <div class="flex items-center gap-2">
                                            <label class="text-[10px] font-black tracking-widest uppercase text-slate-500 shrink-0">Title Size</label>
                                            <select 
                                                v-model="pageContentForm.content.title_font_size" 
                                                class="text-xs font-bold rounded-xl py-2 px-3 border focus:outline-none transition-all"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-white border-slate-200 text-slate-900 focus:border-blue-650'"
                                            >
                                                <option value="text-2xl sm:text-3xl lg:text-4xl">Default (30px)</option>
                                                <option value="text-xl sm:text-2xl lg:text-3xl">XS (24px)</option>
                                                <option value="text-3xl sm:text-4xl lg:text-5xl">Medium (36px)</option>
                                                <option value="text-4xl sm:text-5xl lg:text-6xl">Large (48px)</option>
                                                <option value="text-5xl sm:text-6xl lg:text-7xl">XL (60px)</option>
                                                <option value="text-6xl sm:text-7xl lg:text-8xl">Huge (72px)</option>
                                            </select>
                                        </div>

                                        <!-- Apply to All Offices -->
                                        <label v-if="pageContentForm.is_office" class="flex items-center gap-1.5 cursor-pointer px-2.5 py-1.5 rounded-xl border border-dashed transition-all" :class="isDarkMode ? 'border-blue-500/30 bg-blue-500/10 text-blue-400 hover:border-blue-500' : 'border-blue-200 bg-blue-50 text-blue-700 hover:border-blue-400'">
                                            <input 
                                                type="checkbox" 
                                                v-model="pageContentForm.apply_to_all_offices" 
                                                class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-3.5 h-3.5"
                                            />
                                            <span class="text-[11px] font-extrabold">Apply to ALL Offices</span>
                                        </label>

                                        <!-- Spacer -->
                                        <div class="flex-1"></div>

                                        <!-- Action Buttons -->
                                        <div class="flex gap-2 shrink-0">
                                            <button v-if="selectedPage.id" type="button" @click="restoreDefaultPageContent(selectedPage.id)" class="bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-xl px-4 py-2.5 text-xs font-black transition-all border border-amber-500/20 shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                Redo Defaults
                                            </button>
                                            <button v-if="selectedPage.id" type="button" @click="confirmDeletePage(selectedPage)" class="bg-red-500/10 hover:bg-red-500 hover:text-white text-red-500 rounded-xl px-4 py-2.5 text-xs font-black transition-all border border-red-500/20 shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Delete
                                            </button>
                                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:shadow-blue-500/40 hover:scale-[1.02] text-white rounded-xl px-5 py-2.5 text-xs font-black shadow-lg shadow-blue-500/20 transition-all flex items-center gap-1.5 whitespace-nowrap">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Office Page Form -->
                                <div v-if="pageContentForm.is_office" class="space-y-4">
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-slate-50'">
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="block text-xs font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Office Header Image</label>
                                            <button 
                                                v-if="pageContentForm.content.image" 
                                                type="button" 
                                                @click="pageContentForm.content.image = ''" 
                                                class="text-xs font-bold text-red-500 hover:underline flex items-center gap-1"
                                            >
                                                ✕ Clear / Remove Image
                                            </button>
                                        </div>

                                        <!-- Current Image Preview -->
                                        <div v-if="pageContentForm.content.image" class="mb-3 flex items-center gap-4 p-2 rounded-xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-white border-slate-200'">
                                            <img 
                                                v-if="typeof pageContentForm.content.image === 'string' && pageContentForm.content.image" 
                                                :src="pageContentForm.content.image" 
                                                alt="Current Office Image" 
                                                class="h-16 w-28 object-cover rounded-lg border border-slate-300 shrink-0" 
                                                @error="$event.target.style.display='none'"
                                            />
                                            <img 
                                                v-else-if="pageContentForm.content.image && typeof pageContentForm.content.image === 'object'" 
                                                :src="getObjectUrl(pageContentForm.content.image)" 
                                                alt="New File Preview" 
                                                class="h-16 w-28 object-cover rounded-lg border border-cyan-500 shrink-0" 
                                            />
                                            <div class="min-w-0 text-xs">
                                                <p v-if="typeof pageContentForm.content.image === 'string'" class="font-mono text-[11px] truncate text-slate-500">{{ pageContentForm.content.image }}</p>
                                                <p v-else-if="pageContentForm.content.image && typeof pageContentForm.content.image === 'object'" class="font-bold text-cyan-500">✨ New File Selected: {{ pageContentForm.content.image.name }}</p>
                                            </div>
                                        </div>

                                        <!-- File Upload -->
                                        <div class="space-y-1.5">
                                            <label class="block text-[11px] font-bold" :class="isDarkMode ? 'text-slate-400' : 'text-slate-600'">Upload Image File</label>
                                            <input 
                                                type="file" 
                                                accept="image/*"
                                                @input="pageContentForm.content.image = $event.target.files[0]" 
                                                class="w-full rounded-xl text-xs border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-xs file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-slate-300 focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-700 focus:bg-white focus:border-blue-600 file:bg-blue-600 file:text-white'" 
                                            />
                                        </div>

                                        <!-- OR URL Input -->
                                        <div class="mt-3">
                                            <label class="block text-[11px] font-bold mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-600'">Or Paste Image URL</label>
                                            <input 
                                                type="text" 
                                                :value="typeof pageContentForm.content.image === 'string' ? pageContentForm.content.image : ''"
                                                @input="pageContentForm.content.image = $event.target.value"
                                                placeholder="https://images.unsplash.com/photo-..." 
                                                class="w-full rounded-xl text-xs border px-3 py-2 focus:outline-none" 
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-white border-slate-200 text-slate-900 focus:border-blue-500'" 
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Rector Message Form -->
                                <div v-if="selectedPage.slug === 'rector'" class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Rector Image (Upload File)</label>
                                        <input 
                                            type="file" 
                                            accept="image/*"
                                            @input="pageContentForm.content.rector_image = $event.target.files[0]" 
                                            class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-slate-300 focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-700 focus:bg-white focus:border-blue-650 file:bg-blue-600 file:text-white'" 
                                        />
                                        <div v-if="typeof pageContentForm.content.rector_image === 'string' && pageContentForm.content.rector_image" class="mt-2 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Image uploaded and saved. Select a new file to replace it.
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Rector Official Name (EN)</label>
                                            <input 
                                                type="text" 
                                                v-model="pageContentForm.content.rector_name.en" 
                                                class="w-full rounded-xl text-sm border focus:outline-none"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Rector Official Name (KM)</label>
                                            <input 
                                                type="text" 
                                                v-model="pageContentForm.content.rector_name.km" 
                                                class="w-full rounded-xl text-sm border focus:outline-none"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Rector Title / Subtitle (EN)</label>
                                            <input 
                                                type="text" 
                                                v-model="pageContentForm.content.rector_title.en" 
                                                class="w-full rounded-xl text-sm border focus:outline-none"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Rector Title / Subtitle (KM)</label>
                                            <input 
                                                type="text" 
                                                v-model="pageContentForm.content.rector_title.km" 
                                                class="w-full rounded-xl text-sm border focus:outline-none"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                    </div>
                                    <div class="border-t pt-4 grid grid-cols-1 gap-6" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                        <!-- English Body -->
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Message Body (English)</label>
                                                <span class="text-[9px] font-bold px-2 py-0.5 rounded" :class="isDarkMode ? 'text-blue-400 bg-blue-500/10' : 'text-blue-800 bg-blue-100'">
                                                    {{ pageContentForm.content.paragraphs_en ? pageContentForm.content.paragraphs_en.length : 0 }} Paragraphs
                                                </span>
                                            </div>
                                            <div class="rounded-xl overflow-hidden border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-white border-slate-200'">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="pageContentForm.content.paragraphs_en" 
     
></QuillEditor></div>
                                            </div>
                                        </div>
                                        <!-- Khmer Body -->
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Message Body (Khmer)</label>
                                                <span class="text-[9px] font-bold px-2 py-0.5 rounded" :class="isDarkMode ? 'text-blue-400 bg-blue-500/10' : 'text-blue-800 bg-blue-100'">
                                                    {{ pageContentForm.content.paragraphs_km ? pageContentForm.content.paragraphs_km.length : 0 }} Paragraphs
                                                </span>
                                            </div>
                                            <div class="rounded-xl overflow-hidden border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-white border-slate-200'">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="pageContentForm.content.paragraphs_km" 
     
></QuillEditor></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- About Us Form -->
                                <div v-else-if="selectedPage.slug === 'about'" class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">About Banner Image (Upload File)</label>
                                        <input 
                                            type="file" 
                                            accept="image/*"
                                            @input="pageContentForm.content.about_image = $event.target.files[0]" 
                                            class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-slate-300 focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-700 focus:bg-white focus:border-blue-650 file:bg-blue-600 file:text-white'" 
                                        />
                                        <div v-if="typeof pageContentForm.content.about_image === 'string' && pageContentForm.content.about_image" class="mt-2 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Image uploaded and saved. Select a new file to replace it.
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">DUC History (EN)</label>
                                            <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="pageContentForm.content.history.en" 
     
></QuillEditor></div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">DUC History (KM)</label>
                                            <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="pageContentForm.content.history.km" 
     
></QuillEditor></div>
                                        </div>
                                    </div>

                                    <!-- Faculties Sidebar Management Card -->
                                    <div class="border rounded-2xl p-5 space-y-4" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-slate-50/50'">
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-blue-600/10 text-blue-600 flex items-center justify-center font-bold">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-black uppercase tracking-wider" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Faculties Sidebar List</label>
                                                    <p class="text-[11px]" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">These faculties appear on the sidebar next to DUC History on the About page.</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="restoreDefaultFaculties()" class="text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-500/10 hover:bg-amber-500 hover:text-white px-3.5 py-1.5 rounded-xl transition-all border border-amber-500/20 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Redo Defaults
                                                </button>
                                                <button type="button" @click="startEditFaculty()" class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-3.5 py-1.5 rounded-xl transition-colors shadow-sm flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg> Add Faculty
                                                </button>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <div v-for="fac in props.faculties" :key="fac.id" class="flex justify-between items-center p-3 rounded-xl border transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-white border-slate-200'">
                                                <div class="flex items-center gap-3">
                                                    <span class="text-blue-600 font-bold">•</span>
                                                    <span class="text-xs font-bold" :class="isDarkMode ? 'text-slate-200' : 'text-slate-800'">{{ getAdminLabel(fac.name) }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" @click="startEditFaculty(fac)" class="text-xs font-bold text-blue-600 hover:underline px-2 py-1">Edit</button>
                                                    <button type="button" @click="deleteFaculty(fac.id)" class="text-xs font-bold text-red-500 hover:underline px-2 py-1">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Mission & Vision Container (Orderable) -->
                                    <div class="space-y-4">
                                        <template v-if="!pageContentForm.content.vision_first">
                                            <!-- Mission Section Card (First) -->
                                            <div class="border rounded-2xl p-5 space-y-4" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-slate-50/50'">
                                                <div class="flex items-center justify-between">
                                                    <label class="block text-xs font-black uppercase tracking-widest flex items-center gap-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> #1 Mission Statement Section
                                                    </label>
                                                    <button type="button" @click="toggleVisionFirst" class="text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-500/10 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-xl transition-all border border-blue-500/20 flex items-center gap-1 shadow-sm">
                                                        ↓ Move Down (Place Vision First)
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Mission Description (EN)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.mission.en"></QuillEditor></div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Mission Description (KM)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.mission.km"></QuillEditor></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Vision Section Card (Second) -->
                                            <div class="border rounded-2xl p-5 space-y-4" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-slate-50/50'">
                                                <div class="flex items-center justify-between">
                                                    <label class="block text-xs font-black uppercase tracking-widest flex items-center gap-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> #2 Vision Statement Section
                                                    </label>
                                                    <button type="button" @click="toggleVisionFirst" class="text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-500/10 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-xl transition-all border border-blue-500/20 flex items-center gap-1 shadow-sm">
                                                        ↑ Move Up (Place Vision First)
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Vision Statement (EN)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.vision.en"></QuillEditor></div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Vision Statement (KM)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.vision.km"></QuillEditor></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <template v-else>
                                            <!-- Vision Section Card (First) -->
                                            <div class="border rounded-2xl p-5 space-y-4" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-slate-50/50'">
                                                <div class="flex items-center justify-between">
                                                    <label class="block text-xs font-black uppercase tracking-widest flex items-center gap-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> #1 Vision Statement Section
                                                    </label>
                                                    <button type="button" @click="toggleVisionFirst" class="text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-500/10 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-xl transition-all border border-blue-500/20 flex items-center gap-1 shadow-sm">
                                                        ↓ Move Down (Place Mission First)
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Vision Statement (EN)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.vision.en"></QuillEditor></div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Vision Statement (KM)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.vision.km"></QuillEditor></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mission Section Card (Second) -->
                                            <div class="border rounded-2xl p-5 space-y-4" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-200 bg-slate-50/50'">
                                                <div class="flex items-center justify-between">
                                                    <label class="block text-xs font-black uppercase tracking-widest flex items-center gap-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> #2 Mission Statement Section
                                                    </label>
                                                    <button type="button" @click="toggleVisionFirst" class="text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-500/10 hover:bg-blue-500 hover:text-white px-3 py-1.5 rounded-xl transition-all border border-blue-500/20 flex items-center gap-1 shadow-sm">
                                                        ↑ Move Up (Place Mission First)
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Mission Description (EN)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.mission.en"></QuillEditor></div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Mission Description (KM)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.mission.km"></QuillEditor></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="border-t pt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                        <div class="flex justify-between items-center mb-3">
                                            <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Goals & Purposes List</label>
                                            <button type="button" @click="addAboutGoal" class="text-xs font-bold text-blue-500 hover:underline">+ Add Goal</button>
                                        </div>
                                        <div class="space-y-3">
                                            <div v-for="(goal, idx) in pageContentForm.content.goals" :key="idx" class="flex gap-2 items-center p-2 rounded-xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-200'">
                                                <span class="text-xs font-bold text-slate-400 w-6 text-center shrink-0">#{{ idx + 1 }}</span>
                                                <input 
                                                    type="text" 
                                                    v-model="goal.en" 
                                                    placeholder="Goal (EN)"
                                                    class="flex-1 rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                    :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] text-white focus:border-blue-500' : 'bg-white border-slate-200 text-slate-900 focus:border-blue-500'" 
                                                />
                                                <input 
                                                    type="text" 
                                                    v-model="goal.km" 
                                                    placeholder="Goal (KM)"
                                                    class="flex-1 rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                    :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] text-white focus:border-blue-500' : 'bg-white border-slate-200 text-slate-900 focus:border-blue-500'" 
                                                />
                                                <div class="flex items-center gap-1 shrink-0 ml-1">
                                                    <button v-if="idx > 0" type="button" @click="moveAboutGoalUp(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold px-1.5 py-1 rounded bg-blue-500/10" title="Move Up">↑ Up</button>
                                                    <button v-if="idx < pageContentForm.content.goals.length - 1" type="button" @click="moveAboutGoalDown(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold px-1.5 py-1 rounded bg-blue-500/10" title="Move Down">↓ Down</button>
                                                    <button type="button" @click="removeAboutGoal(idx)" class="text-red-500 hover:text-red-400 px-2 py-1 text-xs font-bold rounded bg-red-500/10" title="Remove Goal">✕</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-t pt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                        <div class="flex justify-between items-center mb-3">
                                            <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Custom Sections</label>
                                            <button type="button" @click="addCustomSection" class="text-xs font-bold text-blue-500 hover:underline">+ Add Section</button>
                                        </div>
                                        <div class="space-y-6">
                                            <div v-for="(section, idx) in pageContentForm.content.custom_sections" :key="idx" class="space-y-4 p-4 border rounded-xl" :class="isDarkMode ? 'border-slate-800 bg-[#0c101b]' : 'border-slate-100 bg-white'">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-xs font-bold">Custom Block #{{ idx + 1 }}</span>
                                                    <div class="flex items-center gap-3">
                                                        <button v-if="idx > 0" type="button" @click="moveCustomSectionUp(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Up">↑ Up</button>
                                                        <button v-if="idx < pageContentForm.content.custom_sections.length - 1" type="button" @click="moveCustomSectionDown(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Down">↓ Down</button>
                                                        <button type="button" @click="removeCustomSection(idx)" class="text-red-500 hover:text-red-400 text-xs font-bold">Remove Section ✕</button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (EN)</label>
                                                        <input 
                                                            type="text" 
                                                            v-model="section.title.en" 
                                                            placeholder="E.g., Core Values"
                                                            class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                                        />
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (KM)</label>
                                                        <input 
                                                            type="text" 
                                                            v-model="section.title.km" 
                                                            placeholder="E.g., គុណតម្លៃស្នូល"
                                                            class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                                        />
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (English)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.en" contentType="html"  ></QuillEditor></div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (Khmer)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.km" contentType="html"  ></QuillEditor></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Exam & Evaluation Form -->
                                <div v-else-if="selectedPage.slug === 'exam-evaluation'" class="space-y-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-2 flex items-center gap-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Introductory Overview (EN)
                                            </label>
                                            <div class="rounded-xl overflow-hidden border transition-all hover:border-blue-500/30 shadow-sm" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-white border-slate-200'">
                                                <div class="bg-white text-black min-h-[200px]"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.intro.en"></QuillEditor></div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-2 flex items-center gap-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Introductory Overview (KM)
                                            </label>
                                            <div class="rounded-xl overflow-hidden border transition-all hover:border-blue-500/30 shadow-sm" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-white border-slate-200'">
                                                <div class="bg-white text-black min-h-[200px]"><QuillEditor theme="snow" contentType="html" v-model:content="pageContentForm.content.intro.km"></QuillEditor></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded-2xl p-6 transition-all bg-slate-50/30 dark:bg-[#0c101b]/50" :class="isDarkMode ? 'border-[#1a2333]' : 'border-slate-100'">
                                        <div class="flex justify-between items-center mb-6">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500 border border-indigo-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-black tracking-widest uppercase" :class="isDarkMode ? 'text-white' : 'text-slate-800'">Scoring Breakdown Table</h4>
                                                </div>
                                            </div>
                                            <button type="button" @click="addExamBreakdown" class="text-[11px] font-extrabold text-indigo-600 hover:text-white hover:bg-indigo-600 px-4 py-2 rounded-full bg-indigo-50 border border-indigo-200 transition-all duration-300 shadow-sm flex items-center gap-1.5" :class="isDarkMode ? 'bg-indigo-500/10 border-indigo-500/20 text-indigo-400 hover:bg-indigo-500' : ''">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg> Add Row
                                            </button>
                                        </div>
                                        <div class="space-y-4">
                                            <div v-for="(item, idx) in pageContentForm.content.breakdown" :key="idx" class="flex flex-col sm:flex-row gap-3 items-center p-3 rounded-xl border transition-all hover:shadow-md" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] hover:border-indigo-500/30' : 'bg-white border-slate-200 hover:border-indigo-300'">
                                                <div class="relative flex-1 w-full">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">EN</span></div>
                                                    <input type="text" v-model="item.criteria.en" placeholder="Criteria Name" class="w-full rounded-lg text-sm border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-indigo-500/30 pl-9 py-2" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                </div>
                                                <div class="relative flex-1 w-full">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-[10px] font-black text-slate-400">KM</span></div>
                                                    <input type="text" v-model="item.criteria.km" placeholder="Criteria Name" class="w-full rounded-lg text-sm border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-indigo-500/30 pl-9 py-2" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                </div>
                                                <div class="relative w-full sm:w-32">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                                                    </div>
                                                    <input type="text" v-model="item.percentage" placeholder="e.g. 55%" class="w-full rounded-lg text-sm font-black border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-indigo-500/30 pl-8 py-2" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                </div>
                                                <button type="button" @click="removeExamBreakdown(idx)" class="w-8 h-8 rounded-full flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors flex-shrink-0" :class="isDarkMode ? 'bg-red-500/10 text-red-400' : ''">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border rounded-2xl p-6 transition-all bg-slate-50/30 dark:bg-[#0c101b]/50" :class="isDarkMode ? 'border-[#1a2333]' : 'border-slate-100'">
                                        <div class="flex justify-between items-center mb-6">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500 border border-amber-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-black tracking-widest uppercase" :class="isDarkMode ? 'text-white' : 'text-slate-800'">Grading Scale Table</h4>
                                                </div>
                                            </div>
                                            <button type="button" @click="addExamGrade" class="text-[11px] font-extrabold text-amber-600 hover:text-white hover:bg-amber-500 px-4 py-2 rounded-full bg-amber-50 border border-amber-200 transition-all duration-300 shadow-sm flex items-center gap-1.5" :class="isDarkMode ? 'bg-amber-500/10 border-amber-500/20 text-amber-500 hover:bg-amber-500' : ''">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg> Add Range
                                            </button>
                                        </div>
                                        <div class="space-y-3">
                                            <div v-for="(item, idx) in pageContentForm.content.grades" :key="idx" class="grid grid-cols-1 md:grid-cols-[1fr_0.8fr_0.8fr_2fr_2fr_40px] gap-3 items-center p-3 rounded-xl border transition-all hover:shadow-md" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] hover:border-amber-500/30' : 'bg-white border-slate-200 hover:border-amber-300'">
                                                <input type="text" v-model="item.score" placeholder="Score range (e.g. 85-100)" class="w-full rounded-lg text-[11px] font-bold border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-amber-500/30 px-3 py-2 text-center" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                <input type="text" v-model="item.letter" placeholder="Letter (A)" class="w-full rounded-lg text-[11px] font-black border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-amber-500/30 px-3 py-2 text-center text-amber-600 dark:text-amber-500" />
                                                <input type="text" v-model="item.points" placeholder="Point (4.0)" class="w-full rounded-lg text-[11px] font-bold border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-amber-500/30 px-3 py-2 text-center text-blue-600 dark:text-blue-400" />
                                                
                                                <div class="relative w-full">
                                                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none"><span class="text-[9px] font-black text-slate-400">EN</span></div>
                                                    <input type="text" v-model="item.description.en" placeholder="Description" class="w-full rounded-lg text-[11px] border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-amber-500/30 pl-8 py-2" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                </div>
                                                <div class="relative w-full">
                                                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none"><span class="text-[9px] font-black text-slate-400">KM</span></div>
                                                    <input type="text" v-model="item.description.km" placeholder="Description" class="w-full rounded-lg text-[11px] border-none bg-slate-50 dark:bg-[#0f1524] focus:outline-none focus:ring-2 focus:ring-amber-500/30 pl-8 py-2" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                </div>
                                                
                                                <button type="button" @click="removeExamGrade(idx)" class="w-8 h-8 mx-auto rounded-full flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors" :class="isDarkMode ? 'bg-red-500/10 text-red-400' : ''">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Office Page Form -->
                                <div v-else-if="pageContentForm.is_office" class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Office Image (Upload File)</label>
                                        <input 
                                            type="file" 
                                            accept="image/*"
                                            @input="pageContentForm.content.image = $event.target.files[0]" 
                                            class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-slate-300 focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-700 focus:bg-white focus:border-blue-650 file:bg-blue-600 file:text-white'" 
                                        />
                                        <div v-if="typeof pageContentForm.content.image === 'string' && pageContentForm.content.image" class="mt-2 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Image uploaded and saved. Select a new file to replace it.
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Office Subtitle / Intro Text (EN)</label>
                                            <textarea v-model="pageContentForm.content.subtitle.en" rows="3" class="w-full rounded-lg text-sm border focus:outline-none px-3 py-2 resize-y" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500'" placeholder="e.g. A brief introduction text displayed centered above the About section."></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Office Subtitle / Intro Text (KM)</label>
                                            <textarea v-model="pageContentForm.content.subtitle.km" rows="3" class="w-full rounded-lg text-sm border focus:outline-none px-3 py-2 resize-y" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500'" placeholder="អត្ថបទណែនាំសង្ខេប..."></textarea>
                                        </div>
                                    </div>
                                    <!-- Office Custom Sections -->
                                    <div class="border-t pt-4 mt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                        <div class="flex justify-between items-center mb-3">
                                            <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Custom Office Sections</label>
                                            <button type="button" @click="addCustomSection" class="text-xs font-bold text-blue-500 hover:underline">+ Add Section</button>
                                        </div>
                                        
                                        <div v-if="!pageContentForm.content.custom_sections || pageContentForm.content.custom_sections.length === 0" class="text-center py-8 border-2 border-dashed rounded-xl" :class="isDarkMode ? 'border-slate-800 text-slate-500' : 'border-slate-200 text-slate-400'">
                                            <p class="text-xs font-bold">This office has no custom sections yet.</p>
                                            <button type="button" @click="addCustomSection" class="mt-2 text-xs font-bold text-blue-500">Click here to add one</button>
                                        </div>
                                        
                                        <div class="space-y-6">
                                            <div v-for="(section, idx) in pageContentForm.content.custom_sections" :key="idx" class="space-y-4 p-4 border rounded-xl" :class="isDarkMode ? 'border-slate-800 bg-[#0c101b]' : 'border-slate-100 bg-white'">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-xs font-bold">Section #{{ idx + 1 }}</span>
                                                    <div class="flex items-center gap-3">
                                                        <button v-if="idx > 0" type="button" @click="moveCustomSectionUp(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Up">↑ Up</button>
                                                        <button v-if="idx < pageContentForm.content.custom_sections.length - 1" type="button" @click="moveCustomSectionDown(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Down">↓ Down</button>
                                                        <button type="button" @click="removeCustomSection(idx)" class="text-red-500 hover:text-red-400 text-xs font-bold">Remove ✕</button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (EN)</label>
                                                        <input type="text" v-model="section.title.en" placeholder="E.g., About Us, Responsibilities" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" />
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (KM)</label>
                                                        <input type="text" v-model="section.title.km" placeholder="E.g., អំពីយើង, តួនាទី" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" />
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Title Size</label>
                                                        <select v-model="section.title_font_size" class="w-full rounded-xl text-xs font-bold border focus:outline-none px-3 py-1.5" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'">
                                                            <option value="">Default (30px / Large)</option>
                                                            <option value="text-base sm:text-lg">XS (18px)</option>
                                                            <option value="text-lg sm:text-xl">Small (20px)</option>
                                                            <option value="text-xl sm:text-2xl">Medium (24px)</option>
                                                            <option value="text-2xl sm:text-3xl">Large (30px)</option>
                                                            <option value="text-3xl sm:text-4xl">XL (36px)</option>
                                                            <option value="text-4xl sm:text-5xl">Huge (48px)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (English)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.en" contentType="html"></QuillEditor></div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (Khmer)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.km" contentType="html"></QuillEditor></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Generic Page Form -->
                                <div v-else class="space-y-4">
                                    <div class="border-t pt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                        <div class="flex justify-between items-center mb-3">
                                            <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Custom Page Content Sections</label>
                                            <button type="button" @click="addCustomSection" class="text-xs font-bold text-blue-500 hover:underline">+ Add Content Block</button>
                                        </div>
                                        
                                        <div v-if="!pageContentForm.content.custom_sections || pageContentForm.content.custom_sections.length === 0" class="text-center py-8 border-2 border-dashed rounded-xl" :class="isDarkMode ? 'border-slate-800 text-slate-500' : 'border-slate-200 text-slate-400'">
                                            <p class="text-xs font-bold">This page has no content blocks yet.</p>
                                            <button type="button" @click="addCustomSection" class="mt-2 text-xs font-bold text-blue-500">Click here to add one</button>
                                        </div>
                                        
                                        <div class="space-y-6">
                                            <div v-for="(section, idx) in pageContentForm.content.custom_sections" :key="idx" class="space-y-4 p-4 border rounded-xl" :class="isDarkMode ? 'border-slate-800 bg-[#0c101b]' : 'border-slate-100 bg-white'">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-xs font-bold">Custom Block #{{ idx + 1 }}</span>
                                                    <div class="flex items-center gap-3">
                                                        <button v-if="idx > 0" type="button" @click="moveCustomSectionUp(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Up">↑ Up</button>
                                                        <button v-if="idx < pageContentForm.content.custom_sections.length - 1" type="button" @click="moveCustomSectionDown(idx)" class="text-blue-500 hover:text-blue-400 text-xs font-bold" title="Move Down">↓ Down</button>
                                                        <button type="button" @click="removeCustomSection(idx)" class="text-red-500 hover:text-red-400 text-xs font-bold">Remove Block ✕</button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (EN)</label>
                                                        <input 
                                                            type="text" 
                                                            v-model="section.title.en" 
                                                            placeholder="E.g., Welcome to DUC"
                                                            class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                                        />
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (KM)</label>
                                                        <input 
                                                            type="text" 
                                                            v-model="section.title.km" 
                                                            placeholder="E.g., សូមស្វាគមន៍មកកាន់ DUC"
                                                            class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                                        />
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Title Size</label>
                                                        <select v-model="section.title_font_size" class="w-full rounded-xl text-xs font-bold border focus:outline-none px-3 py-1.5" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'">
                                                            <option value="">Default (30px / Large)</option>
                                                            <option value="text-base sm:text-lg">XS (18px)</option>
                                                            <option value="text-lg sm:text-xl">Small (20px)</option>
                                                            <option value="text-xl sm:text-2xl">Medium (24px)</option>
                                                            <option value="text-2xl sm:text-3xl">Large (30px)</option>
                                                            <option value="text-3xl sm:text-4xl">XL (36px)</option>
                                                            <option value="text-4xl sm:text-5xl">Huge (48px)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 gap-4">
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (English)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.en" contentType="html"  ></QuillEditor></div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (Khmer)</label>
                                                        <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.km" contentType="html"  ></QuillEditor></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>

                <!-- TAB: NEWS & EVENTS -->
                <div v-if="activeTab === 'events'" class="animate-fadeIn space-y-8">
                    
                    <!-- Header Block -->
                    <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 border shadow-[0_8px_30px_rgb(0,0,0,0.04)]" :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'">
                        <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"></path></svg>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white shadow-lg shadow-pink-500/30">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Manage News & Announcements</h3>
                                    <p class="text-sm mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Publish official notices, campus articles, and tech industry updates.</p>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row items-center gap-4 w-full md:w-auto mt-6 md:mt-0">
                                <div class="flex items-center rounded-xl px-4 py-2.5 w-full md:w-64 border transition-colors relative" :class="isDarkMode ? 'bg-[#1a2333] border-[#2d3748] focus-within:border-indigo-500 text-white' : 'bg-slate-50 border-slate-200 focus-within:border-blue-500 text-slate-900'">
                                    <svg class="w-4 h-4 shrink-0 mr-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    <input v-model="eventsSearchQuery" type="text" placeholder="Search events..." class="bg-transparent border-none outline-none text-sm w-full p-0 focus:ring-0" :class="isDarkMode ? 'placeholder-slate-500' : 'placeholder-slate-400'" />
                                    <button v-if="eventsSearchQuery" @click="eventsSearchQuery = ''" class="absolute right-3 hover:text-red-500 text-slate-400"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                                </div>
                                
                                <div class="flex items-center rounded-xl px-4 py-2.5 w-full md:w-48 border transition-colors relative" :class="isDarkMode ? 'bg-[#1a2333] border-[#2d3748] focus-within:border-indigo-500 text-white' : 'bg-slate-50 border-slate-200 focus-within:border-blue-500 text-slate-900'">
                                    <svg class="w-4 h-4 shrink-0 mr-2" :class="eventsDateFilter ? 'text-blue-500' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <input v-model="eventsDateFilter" type="date" class="bg-transparent border-none outline-none text-sm w-full p-0 focus:ring-0 [&::-webkit-calendar-picker-indicator]:absolute [&::-webkit-calendar-picker-indicator]:inset-0 [&::-webkit-calendar-picker-indicator]:w-full [&::-webkit-calendar-picker-indicator]:h-full [&::-webkit-calendar-picker-indicator]:opacity-0 [&::-webkit-calendar-picker-indicator]:cursor-pointer" />
                                    <button v-if="eventsDateFilter" @click="eventsDateFilter = ''" class="absolute right-3 hover:text-red-500 text-slate-400 z-10"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                                </div>

                                <button type="button" @click="restoreDefaultEvents()" class="w-full md:w-auto bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-xl px-5 py-2.5 text-sm font-black border border-amber-500/20 transition-all flex items-center justify-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Redo / Restore Defaults
                                </button>
                                <button v-if="editingEvent !== 'new'" @click="startEditEvent()" class="w-full md:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:shadow-blue-500/40 hover:scale-[1.02] text-white rounded-xl px-6 py-2.5 text-sm font-black shadow-lg shadow-blue-500/20 transition-all flex items-center justify-center gap-2 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    Add Event
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Events list grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div 
                            v-for="ev in paginatedAdminEvents" 
                            :key="ev.id" 
                            class="rounded-3xl overflow-hidden flex flex-col justify-between group transition-all duration-300 border hover:-translate-y-2 hover:shadow-[0_20px_40px_rgb(0,0,0,0.1)] relative"
                            :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] hover:shadow-[0_20px_40px_rgb(0,0,0,0.6)] hover:border-indigo-500/50' : 'bg-white border-slate-100 hover:border-indigo-200'"
                        >
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-0"></div>
                            <div class="relative z-10 flex-1 flex flex-col">
                                <div class="h-48 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-transparent transition-all z-10"></div>
                                    <img :src="ev.image" :alt="getAdminLabel(ev.title)" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
                                    
                                    <div class="absolute top-4 right-4 z-20">
                                        <span class="text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full text-white backdrop-blur-md bg-black/40 border border-white/20 shadow-lg">{{ ev.type }}</span>
                                    </div>
                                    <div class="absolute bottom-4 left-4 z-20 flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <span class="text-[11px] font-black text-white drop-shadow-md">{{ ev.date }}</span>
                                    </div>
                                </div>
                                <div class="p-6 flex-1 flex flex-col relative">
                                    <div v-if="!ev.is_published" class="absolute -top-3 right-6">
                                        <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full bg-amber-500 text-white shadow-lg shadow-amber-500/40">Draft</span>
                                    </div>
                                    <h4 class="font-extrabold text-lg line-clamp-2 leading-tight mb-3" :class="isDarkMode ? 'text-white group-hover:text-indigo-400' : 'text-slate-900 group-hover:text-indigo-600'">{{ getAdminLabel(ev.title) }}</h4>
                                    <p class="text-sm line-clamp-3 leading-relaxed mb-4 flex-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">{{ getAdminLabel(ev.description) }}</p>
                                </div>
                            </div>
                            <div class="px-6 py-4 border-t flex justify-between items-center relative z-10 transition-colors" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]/50 group-hover:bg-[#0c101b]' : 'border-slate-100 bg-slate-50/50 group-hover:bg-indigo-50/30'">
                                <div class="flex items-center gap-2">
                                    <button @click="openViewEventModal(ev)" class="text-[11px] font-extrabold text-emerald-600 hover:text-white hover:bg-emerald-600 px-4 py-2 rounded-full transition-all duration-300 shadow-sm flex items-center gap-1.5" :class="isDarkMode ? 'bg-emerald-500/10 hover:shadow-emerald-500/20' : 'bg-emerald-50'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View
                                    </button>
                                    <button @click="deleteEvent(ev.id)" class="text-[11px] font-extrabold text-red-500 hover:text-white hover:bg-red-500 px-4 py-2 rounded-full transition-all duration-300 shadow-sm flex items-center gap-1.5" :class="isDarkMode ? 'bg-red-500/10 hover:shadow-red-500/20' : 'bg-red-50'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                                    </button>
                                </div>
                                <button @click="startEditEvent(ev)" class="text-[11px] font-extrabold text-white bg-indigo-500 hover:bg-indigo-600 px-5 py-2 rounded-full transition-all duration-300 shadow-md shadow-indigo-500/20 flex items-center gap-1.5 transform group-hover:scale-105">
                                    Edit Details <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination Controls -->
                    <div 
                        v-if="eventsTotalPages > 1"
                        class="mt-14 flex flex-wrap justify-center items-center gap-2 pb-8"
                    >
                        <button 
                            @click="eventsPrevPage" 
                            :disabled="eventsCurrentPage === 1"
                            class="px-4 py-2 rounded-lg border text-sm font-medium transition-colors"
                            :class="eventsCurrentPage === 1 ? 'border-slate-200 text-slate-400 cursor-not-allowed dark:border-slate-700 dark:text-slate-600' : (isDarkMode ? 'border-[#2d3748] text-slate-300 hover:bg-[#1a2333] hover:text-white' : 'border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-indigo-600')"
                        >
                            Previous
                        </button>
                        
                        <button 
                            v-for="(page, index) in eventsVisiblePages" 
                            :key="index"
                            @click="page !== '...' ? eventsGoToPage(page) : null"
                            :disabled="page === '...'"
                            class="w-10 h-10 rounded-lg border text-sm font-medium transition-colors flex items-center justify-center"
                            :class="[
                                eventsCurrentPage === page ? 'bg-indigo-600 border-indigo-600 text-white shadow-md shadow-indigo-500/20' : (isDarkMode ? 'border-[#2d3748] text-slate-300' : 'border-slate-300 text-slate-700'),
                                page !== '...' ? (isDarkMode ? 'hover:bg-[#1a2333] hover:text-white cursor-pointer' : 'hover:bg-slate-50 hover:text-indigo-600 cursor-pointer') : 'cursor-default border-transparent hover:bg-transparent shadow-none'
                            ]"
                        >
                            {{ page }}
                        </button>
                        
                        <button 
                            @click="eventsNextPage" 
                            :disabled="eventsCurrentPage === eventsTotalPages"
                            class="px-4 py-2 rounded-lg border text-sm font-medium transition-colors"
                            :class="eventsCurrentPage === eventsTotalPages ? 'border-slate-200 text-slate-400 cursor-not-allowed dark:border-slate-700 dark:text-slate-600' : (isDarkMode ? 'border-[#2d3748] text-slate-300 hover:bg-[#1a2333] hover:text-white' : 'border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-indigo-600')"
                        >
                            Next
                        </button>
                    </div>
                </div>

                <!-- TAB: FACULTIES & DEPARTMENTS -->
                <div v-if="activeTab === 'faculties'" class="animate-fadeIn space-y-8">
                    
                    <!-- Header Block -->
                    <div class="rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all duration-300 border shadow-[0_8px_30px_rgb(0,0,0,0.04)]" :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'">
                        <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L1 9l11 6l9-4.91V17h2V9L12 3zm6.72 5.12L12 11.28 5.28 7.61 12 3.94l6.72 4.18zM12 21l-9-4.91v-2.18l9 4.91 9-4.91v2.18L12 21z"></path></svg>
                        </div>
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Academic Org Chart & Curricula</h3>
                                    <p class="text-sm mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage nested departments and faculty profiles displayed on public show routes.</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                                <button @click="restoreDefaultFaculties()" class="w-full sm:w-auto bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-xl px-5 py-3 text-sm font-black border border-amber-500/20 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Redo / Restore Defaults
                                </button>
                                <button @click="startEditFaculty()" class="w-full sm:w-auto bg-[#1e293b] hover:bg-[#0f172a] hover:scale-[1.02] text-white rounded-xl px-6 py-3 text-sm font-black shadow-lg shadow-slate-900/20 border border-slate-700 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg> Add Faculty
                                </button>
                                <button @click="startEditDept()" class="w-full sm:w-auto bg-gradient-to-r from-emerald-600 to-teal-600 hover:shadow-emerald-500/40 hover:scale-[1.02] text-white rounded-xl px-6 py-3 text-sm font-black shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg> Add Department
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Faculties listings -->
                    <div class="space-y-8">
                        <div 
                            v-for="f in props.faculties" 
                            :key="f.id" 
                            class="rounded-3xl p-6 sm:p-8 border shadow-[0_8px_30px_rgb(0,0,0,0.02)] transition-all duration-300 hover:shadow-[0_15px_40px_rgb(0,0,0,0.06)] relative overflow-hidden group"
                            :class="isDarkMode ? 'bg-[#0f1524]/60 backdrop-blur-md border-[#1a2333] hover:border-emerald-500/30' : 'bg-white border-slate-100 hover:border-emerald-100'"
                        >
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-0"></div>
                            
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-6 relative z-10 gap-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="font-black text-lg leading-tight" :class="isDarkMode ? 'text-white' : 'text-slate-900'">{{ getAdminLabel(f.name) }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">DB ID: {{ f.id }}</span>
                                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">{{ f.departments.length }} Depts</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2 text-xs font-bold w-full md:w-auto">
                                    <button @click="openViewFacultyModal(f)" class="flex-1 md:flex-none text-center px-4 py-2 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all duration-300 dark:bg-emerald-500/10 dark:hover:bg-emerald-600 dark:text-emerald-400 dark:hover:text-white flex items-center justify-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View
                                    </button>
                                    <button @click="startEditFaculty(f)" class="flex-1 md:flex-none text-center px-4 py-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-300 dark:bg-blue-500/10 dark:hover:bg-blue-600 dark:text-blue-400 dark:hover:text-white">Edit Faculty</button>
                                    <button @click="deleteFaculty(f.id)" class="flex-1 md:flex-none text-center px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 dark:bg-red-500/10 dark:hover:bg-red-600 dark:text-red-400 dark:hover:text-white">Delete</button>
                                </div>
                            </div>

                            <!-- Departments grid -->
                            <div class="relative z-10">
                                <span class="text-[10px] font-black uppercase tracking-widest block mb-4" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Associated Departments</span>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div 
                                        v-for="d in f.departments" 
                                        :key="d.id" 
                                        class="rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-lg border"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] hover:border-emerald-500/50' : 'bg-slate-50 border-slate-100 hover:border-emerald-200 hover:bg-white'"
                                    >
                                        <div>
                                            <h6 class="font-extrabold text-sm leading-snug mb-2" :class="isDarkMode ? 'text-slate-200' : 'text-slate-800'">{{ getAdminLabel(d.name) }}</h6>
                                            <span class="inline-block px-2 py-0.5 rounded text-[9px] font-mono mb-3" :class="isDarkMode ? 'bg-slate-800 text-slate-400' : 'bg-slate-200 text-slate-500'">/{{ d.slug }}</span>
                                            <p class="text-[13px] line-clamp-3 leading-relaxed" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">{{ stripHtml(getAdminLabel(d.description)) }}</p>
                                        </div>
                                        <div class="mt-5 border-t pt-4 flex justify-between items-center" :class="isDarkMode ? 'border-slate-800' : 'border-slate-200'">
                                            <div class="flex items-center gap-2">
                                                <button @click="openViewDeptModal(d)" class="text-[11px] font-extrabold text-emerald-600 hover:text-emerald-800 transition-colors flex items-center gap-1 dark:text-emerald-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> View
                                                </button>
                                                <button @click="deleteDept(d.id)" class="text-[11px] font-extrabold text-red-500 hover:text-red-700 transition-colors flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Delete
                                                </button>
                                            </div>
                                            <button @click="startEditDept(d)" class="text-[11px] font-extrabold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1 dark:text-blue-400">
                                                Edit Dept <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- TAB: FOOTER SETTINGS -->
                <div v-if="activeTab === 'settings'" class="animate-fadeIn space-y-6">
                    <form @submit.prevent="submitFooterSettings" class="space-y-6">
                        
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 sticky top-0 z-50 p-4 sm:px-6 bg-white/70 dark:bg-[#0c101b]/70 backdrop-blur-xl rounded-2xl border border-white/50 dark:border-slate-700/50 shadow-xl shadow-blue-900/5 dark:shadow-black/20 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black leading-tight mb-1" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Global Site Footer Information</h3>
                                    <p class="text-sm" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Update address details, phones, copyright texts, and social anchor tags.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <button type="button" @click="restoreDefaultSettings()" class="w-full md:w-auto bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-full px-6 py-3 text-sm font-black border border-amber-500/20 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Redo / Restore Defaults
                                </button>
                                <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:shadow-blue-500/40 hover:scale-[1.02] text-white rounded-full px-8 py-3 text-sm font-black shadow-lg shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Save Footer Settings
                                </button>
                            </div>
                        </div>

                        <div 
                            class="rounded-3xl p-6 sm:p-8 border shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden transition-all duration-300"
                            :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'"
                        >
                            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none">
                                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path></svg>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 relative z-10">

                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Footer Copyright Signature</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input 
                                            type="text" 
                                            v-model="settingsForm.copyright.en" 
                                            placeholder="EN Copyright"
                                            required 
                                            class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-blue-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                        />
                                        <input 
                                            type="text" 
                                            v-model="settingsForm.copyright.km" 
                                            placeholder="KM Copyright"
                                            required 
                                            class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-blue-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                        />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Privacy Policy Label Text</label>
                                    <input 
                                        type="text" 
                                        v-model="settingsForm.privacy_policy_label" 
                                        placeholder="Privacy Policy"
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-blue-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                    />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Privacy Policy Link / URL</label>
                                    <input 
                                        type="text" 
                                        v-model="settingsForm.privacy_policy_url" 
                                        placeholder="/privacy-policy or #"
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-blue-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                    />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Bottom Footer Credits / Made With Text</label>
                                    <input 
                                        type="text" 
                                        v-model="settingsForm.footer_credits" 
                                        placeholder="Made with ♥ by IT Department Students"
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-blue-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                    />
                                </div>
                            </div>
                            <!-- Footer Map & Working Hours Section -->
                            <div class="border-t pt-8 mt-10 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center dark:bg-orange-500/20 dark:text-orange-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM12 11.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black uppercase tracking-wider" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Footer Map & Working Hours</h4>
                                        <p class="text-xs" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage the embedded map and operating hours shown in the footer.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Footer Map Embed URL (iframe src)</label>
                                        <input 
                                            type="text" 
                                            v-model="settingsForm.footer_map_url" 
                                            placeholder="https://www.google.com/maps/embed?pb=..."
                                            class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Footer Map Label</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_map_label.en" 
                                                placeholder="EN"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_map_label.km" 
                                                placeholder="KM"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-4">
                                        <h5 class="text-xs font-bold" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Weekday Hours</h5>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Label</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekday_label.en" 
                                                    placeholder="EN"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekday_label.km" 
                                                    placeholder="KM"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Time</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekday_time.en" 
                                                    placeholder="EN"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekday_time.km" 
                                                    placeholder="KM"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <h5 class="text-xs font-bold" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Weekend Hours</h5>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Label</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekend_label.en" 
                                                    placeholder="EN"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekend_label.km" 
                                                    placeholder="KM"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Time</label>
                                            <div class="grid grid-cols-2 gap-2">
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekend_time.en" 
                                                    placeholder="EN"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                                <input 
                                                    type="text" 
                                                    v-model="settingsForm.footer_working_hours_weekend_time.km" 
                                                    placeholder="KM"
                                                    class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-orange-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-orange-500'" 
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Section Titles -->
                            <div class="border-t pt-8 mt-10 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center dark:bg-pink-500/20 dark:text-pink-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black uppercase tracking-wider" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Footer Section Titles</h4>
                                        <p class="text-xs" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Customize the headings used in the footer.</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Quick Links Title</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_quick_links.en" 
                                                placeholder="EN"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_quick_links.km" 
                                                placeholder="KM"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Working Hours Title</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_working_hours.en" 
                                                placeholder="EN"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_working_hours.km" 
                                                placeholder="KM"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Social Media Title</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_social_media.en" 
                                                placeholder="EN"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_social_media.km" 
                                                placeholder="KM"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Contact Info Title</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_contact_info.en" 
                                                placeholder="EN"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_contact_info.km" 
                                                placeholder="KM"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Direct Lines Title</label>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_direct_lines.en" 
                                                placeholder="EN"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                            <input 
                                                type="text" 
                                                v-model="settingsForm.footer_label_direct_lines.km" 
                                                placeholder="KM"
                                                class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-pink-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-pink-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Header & Footer Colors Section -->
                            <div class="border-t pt-8 mt-10 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center dark:bg-purple-500/20 dark:text-purple-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black uppercase tracking-wider" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Header Navigation & Footer Custom Colors</h4>
                                        <p class="text-xs" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Customize header and footer background and text colors.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                    <!-- Nav Bar BG Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Nav Bar Background</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.nav_bg_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.nav_bg_color" placeholder="#3852a4" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Nav Bar Text Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Nav Link Text Color</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.nav_text_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.nav_text_color" placeholder="#ffffff" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Nav Active Underline Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Nav Active Accent / Line</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.nav_active_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.nav_active_color" placeholder="#ffb800" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <!-- Header BG Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Header Background</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.header_bg_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.header_bg_color" placeholder="#ffffff" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Header Text Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Header Text Color</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.header_text_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.header_text_color" placeholder="#000000" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Footer BG Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Footer Background</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.footer_bg_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.footer_bg_color" placeholder="#0d184a" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Footer Top Accent Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Footer Top Border Accent</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.footer_border_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.footer_border_color" placeholder="#04a8f5" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Sub-Footer BG Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Bottom Copyright Bar BG</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.sub_footer_bg_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.sub_footer_bg_color" placeholder="#081033" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Sub-Footer Text Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Bottom Copyright Text Color</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.sub_footer_text_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.sub_footer_text_color" placeholder="#94a3b8" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>

                                    <!-- Sub-Footer Border Color -->
                                    <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333] bg-[#0c101b]' : 'border-slate-100 bg-slate-50'">
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Bottom Copyright Border</label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" v-model="settingsForm.sub_footer_border_color" class="h-10 w-12 rounded-xl border p-1 cursor-pointer bg-transparent shrink-0">
                                            <input type="text" v-model="settingsForm.sub_footer_border_color" placeholder="#1e293b" class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2 transition-all" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white' : 'bg-white border-slate-200'">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- Quick Links -->
                            <div class="border-t pt-8 mt-10 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center dark:bg-cyan-500/20 dark:text-cyan-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        </div>
                                        <label class="block text-[11px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Footer Quick Links ("Our Details")</label>
                                    </div>
                                    <button type="button" @click="addQuickLink" class="text-[11px] font-black uppercase tracking-widest bg-cyan-50 text-cyan-600 hover:bg-cyan-600 hover:text-white px-4 py-2 rounded-xl transition-colors dark:bg-cyan-500/10 dark:text-cyan-400 dark:hover:bg-cyan-600 dark:hover:text-white flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg> Add Link
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div v-for="(link, idx) in settingsForm.footer_quick_links" :key="idx" class="flex flex-col gap-2 relative group bg-slate-50 dark:bg-[#090d16] p-4 rounded-2xl border border-slate-100 dark:border-[#1a2333]">
                                        <div class="grid grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                v-model="link.label.en" 
                                                required 
                                                class="w-full rounded-xl text-sm border-2 focus:outline-none px-3 py-2 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#151c2c] border-[#1a2333] text-white focus:border-cyan-500' : 'bg-white border-slate-200 text-slate-900 focus:border-cyan-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                                placeholder="EN Label (e.g. About Us)" 
                                            />
                                            <input 
                                                type="text" 
                                                v-model="link.label.km" 
                                                required 
                                                class="w-full rounded-xl text-sm border-2 focus:outline-none px-3 py-2 transition-all duration-300"
                                                :class="isDarkMode ? 'bg-[#151c2c] border-[#1a2333] text-white focus:border-cyan-500' : 'bg-white border-slate-200 text-slate-900 focus:border-cyan-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                                placeholder="KM Label" 
                                            />
                                        </div>
                                        <input 
                                            type="text" 
                                            v-model="link.href" 
                                            required 
                                            class="w-full rounded-xl text-sm border-2 focus:outline-none px-3 py-2 transition-all duration-300"
                                            :class="isDarkMode ? 'bg-[#151c2c] border-[#1a2333] text-white focus:border-cyan-500' : 'bg-white border-slate-200 text-slate-900 focus:border-cyan-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                            placeholder="URL (e.g. /about)" 
                                        />
                                        <button type="button" @click="removeQuickLink(idx)" class="absolute top-2 right-2 p-1.5 rounded-full bg-red-100 text-red-500 opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 hover:text-white dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white" title="Remove link">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Social media icon blocks -->
                            <div class="border-t pt-8 mt-10 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center dark:bg-indigo-500/20 dark:text-indigo-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        </div>
                                        <label class="block text-[11px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Social Media Accounts</label>
                                    </div>
                                    <button type="button" @click="addSocialLink" class="text-[11px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white px-4 py-2 rounded-xl transition-colors dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-600 dark:hover:text-white flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg> Append Link
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div 
                                        v-for="(item, idx) in settingsForm.social_links" 
                                        :key="idx" 
                                        class="rounded-3xl p-6 sm:p-8 space-y-6 border transition-all duration-300 hover:shadow-lg"
                                        :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] hover:border-indigo-500/30' : 'bg-slate-50 border-slate-100 hover:border-indigo-200 hover:bg-white'"
                                    >
                                        <div class="flex justify-between items-center border-b pb-4 mb-2" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                            <h5 class="text-[11px] font-black uppercase tracking-widest flex items-center gap-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                <span class="w-6 h-6 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] dark:bg-indigo-500/20 dark:text-indigo-400">#{{ idx + 1 }}</span>
                                                Platform Profile
                                            </h5>
                                            <button type="button" @click="removeSocialLink(idx)" class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg bg-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-colors dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white flex items-center gap-1.5">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Remove
                                            </button>
                                        </div>
                                        <!-- Row 1: Title and URL -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                            <div>
                                                <label class="block text-[9px] font-black uppercase tracking-wider mb-2" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Platform Title</label>
                                                <input 
                                                    type="text" 
                                                    v-model="item.label" 
                                                    required 
                                                    :class="isDarkMode ? 'bg-[#151c2c] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-white border-slate-200 text-slate-900 focus:border-indigo-500'" 
                                                    class="w-full border-2 rounded-xl text-xs px-4 py-3 focus:outline-none transition-all shadow-sm" 
                                                />
                                            </div>
                                            <div>
                                                <label class="block text-[9px] font-black uppercase tracking-wider mb-2" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Account URL Href</label>
                                                <input 
                                                    type="text" 
                                                    v-model="item.href" 
                                                    required 
                                                    :class="isDarkMode ? 'bg-[#151c2c] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-white border-slate-200 text-slate-900 focus:border-indigo-500'" 
                                                    class="w-full border-2 rounded-xl text-xs px-4 py-3 focus:outline-none transition-all shadow-sm" 
                                                />
                                            </div>
                                        </div>

                                        <!-- Row 2: Colors (Full Width Box) -->
                                        <div class="p-5 rounded-2xl border relative overflow-hidden" :class="isDarkMode ? 'bg-[#151c2c] border-[#1a2333]' : 'bg-white border-slate-100 shadow-sm'">
                                            <div class="flex flex-wrap items-center justify-between gap-4 mb-5 pb-3 border-b" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                                <h6 class="text-[10px] font-black uppercase tracking-widest flex items-center gap-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                    <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                                                    Color Customization
                                                </h6>
                                                <div class="flex items-center gap-4">
                                                    <label class="flex items-center gap-2 cursor-pointer text-[9px] font-bold uppercase tracking-wider group" :class="isDarkMode ? 'text-slate-400 hover:text-white' : 'text-slate-500 hover:text-indigo-600'" title="Disable background color change on hover">
                                                        <input type="checkbox" v-model="item.disable_bg_hover" class="w-4 h-4 rounded cursor-pointer border-slate-300 text-indigo-500 focus:ring-indigo-500 transition-colors" />
                                                        Disable Bg Hover
                                                    </label>
                                                    <label class="flex items-center gap-2 cursor-pointer text-[9px] font-bold uppercase tracking-wider group" :class="isDarkMode ? 'text-slate-400 hover:text-white' : 'text-slate-500 hover:text-indigo-600'" title="Disable icon color change on hover">
                                                        <input type="checkbox" v-model="item.disable_icon_hover" class="w-4 h-4 rounded cursor-pointer border-slate-300 text-indigo-500 focus:ring-indigo-500 transition-colors" />
                                                        Disable Icon Hover
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-5">
                                                <!-- Base Background -->
                                                <div>
                                                    <label class="flex justify-between items-center mb-2">
                                                        <span class="block text-[9px] font-bold uppercase tracking-wider" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Base Bg</span>
                                                        <button type="button" @click="item.bg_color = 'transparent'" class="text-[9px] font-bold text-indigo-500 hover:underline">Clear</button>
                                                    </label>
                                                    <div class="flex items-center gap-2 bg-slate-50 dark:bg-[#0c101b] p-1.5 rounded-xl border border-slate-200 dark:border-slate-800">
                                                        <input v-if="item.bg_color !== 'transparent'" type="color" v-model="item.bg_color" class="h-8 w-8 rounded-lg cursor-pointer border-0 p-0 shrink-0 shadow-sm" />
                                                        <div v-else class="h-8 w-8 rounded-lg border border-dashed flex items-center justify-center shrink-0" :class="isDarkMode ? 'border-slate-600 bg-slate-800/50' : 'border-slate-300 bg-slate-100'">
                                                            <span class="text-[8px] font-bold" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">None</span>
                                                        </div>
                                                        <input type="text" v-model="item.bg_color" placeholder="transparent" class="w-full bg-transparent border-none text-[10px] px-2 py-1.5 focus:ring-0 font-mono" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                    </div>
                                                </div>
                                                
                                                <!-- Base Icon -->
                                                <div>
                                                    <label class="flex justify-between items-center mb-2">
                                                        <span class="block text-[9px] font-bold uppercase tracking-wider" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Base Icon</span>
                                                        <button type="button" @click="item.icon_color = 'transparent'" class="text-[9px] font-bold text-indigo-500 hover:underline">Clear</button>
                                                    </label>
                                                    <div class="flex items-center gap-2 bg-slate-50 dark:bg-[#0c101b] p-1.5 rounded-xl border border-slate-200 dark:border-slate-800">
                                                        <input v-if="item.icon_color !== 'transparent'" type="color" v-model="item.icon_color" class="h-8 w-8 rounded-lg cursor-pointer border-0 p-0 shrink-0 shadow-sm" />
                                                        <div v-else class="h-8 w-8 rounded-lg border border-dashed flex items-center justify-center shrink-0" :class="isDarkMode ? 'border-slate-600 bg-slate-800/50' : 'border-slate-300 bg-slate-100'">
                                                            <span class="text-[8px] font-bold" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">None</span>
                                                        </div>
                                                        <input type="text" v-model="item.icon_color" placeholder="transparent" class="w-full bg-transparent border-none text-[10px] px-2 py-1.5 focus:ring-0 font-mono" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                    </div>
                                                </div>

                                                <!-- Hover Background -->
                                                <div :class="{ 'opacity-40 grayscale': item.disable_bg_hover }" class="transition-all duration-300">
                                                    <label class="flex justify-between items-center mb-2">
                                                        <span class="block text-[9px] font-bold uppercase tracking-wider" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Hover Bg</span>
                                                        <button type="button" @click="item.hover_color = 'transparent'" :disabled="item.disable_bg_hover" class="text-[9px] font-bold text-indigo-500 hover:underline disabled:opacity-50">Clear</button>
                                                    </label>
                                                    <div class="flex items-center gap-2 bg-slate-50 dark:bg-[#0c101b] p-1.5 rounded-xl border border-slate-200 dark:border-slate-800">
                                                        <input v-if="item.hover_color !== 'transparent'" type="color" v-model="item.hover_color" :disabled="item.disable_bg_hover" class="h-8 w-8 rounded-lg cursor-pointer border-0 p-0 shrink-0 shadow-sm disabled:cursor-not-allowed" />
                                                        <div v-else class="h-8 w-8 rounded-lg border border-dashed flex items-center justify-center shrink-0" :class="isDarkMode ? 'border-slate-600 bg-slate-800/50' : 'border-slate-300 bg-slate-100'">
                                                            <span class="text-[8px] font-bold" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">None</span>
                                                        </div>
                                                        <input type="text" v-model="item.hover_color" :disabled="item.disable_bg_hover" placeholder="transparent" class="w-full bg-transparent border-none text-[10px] px-2 py-1.5 focus:ring-0 font-mono disabled:cursor-not-allowed" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                    </div>
                                                </div>

                                                <!-- Hover Icon -->
                                                <div :class="{ 'opacity-40 grayscale': item.disable_icon_hover }" class="transition-all duration-300">
                                                    <label class="flex justify-between items-center mb-2">
                                                        <span class="block text-[9px] font-bold uppercase tracking-wider" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Hover Icon</span>
                                                        <button type="button" @click="item.icon_hover_color = 'transparent'" :disabled="item.disable_icon_hover" class="text-[9px] font-bold text-indigo-500 hover:underline disabled:opacity-50">Clear</button>
                                                    </label>
                                                    <div class="flex items-center gap-2 bg-slate-50 dark:bg-[#0c101b] p-1.5 rounded-xl border border-slate-200 dark:border-slate-800">
                                                        <input v-if="item.icon_hover_color !== 'transparent'" type="color" v-model="item.icon_hover_color" :disabled="item.disable_icon_hover" class="h-8 w-8 rounded-lg cursor-pointer border-0 p-0 shrink-0 shadow-sm disabled:cursor-not-allowed" />
                                                        <div v-else class="h-8 w-8 rounded-lg border border-dashed flex items-center justify-center shrink-0" :class="isDarkMode ? 'border-slate-600 bg-slate-800/50' : 'border-slate-300 bg-slate-100'">
                                                            <span class="text-[8px] font-bold" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">None</span>
                                                        </div>
                                                        <input type="text" v-model="item.icon_hover_color" :disabled="item.disable_icon_hover" placeholder="transparent" class="w-full bg-transparent border-none text-[10px] px-2 py-1.5 focus:ring-0 font-mono disabled:cursor-not-allowed" :class="isDarkMode ? 'text-white' : 'text-slate-900'" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-[9px] font-black uppercase tracking-wider mb-2" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">Inline SVG Code</label>
                                            <textarea 
                                                v-model="item.svg" 
                                                rows="3" 
                                                required 
                                                :class="isDarkMode ? 'bg-[#151c2c] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-white border-slate-200 text-slate-900 focus:border-indigo-500'" 
                                                class="w-full border-2 rounded-xl text-[11px] px-4 py-3 focus:outline-none transition-all font-mono leading-relaxed shadow-sm resize-none"
                                                placeholder="<svg>...</svg>"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TAB: TRANSLATIONS MANAGER -->
                <!-- TAB: CONTACT SETTINGS -->
                <div v-if="activeTab === 'contact'" class="animate-fadeIn space-y-6">
                    <form @submit.prevent="submitContactSettings" class="space-y-6">
                        
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 sticky top-0 z-50 p-4 sm:px-6 bg-white/70 dark:bg-[#0c101b]/70 backdrop-blur-xl rounded-2xl border border-white/50 dark:border-slate-700/50 shadow-xl shadow-blue-900/5 dark:shadow-black/20 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black leading-tight mb-1" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Contact Page Settings</h3>
                                    <p class="text-sm" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage hero texts and the featured image on the Contact page.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <button type="button" @click="restoreDefaultContactSettings()" class="w-full md:w-auto bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-full px-6 py-3 text-sm font-black border border-amber-500/20 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Restore Defaults
                                </button>
                                <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 hover:shadow-indigo-500/40 hover:scale-[1.02] text-white rounded-full px-8 py-3 text-sm font-black shadow-lg shadow-indigo-500/20 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Save Contact Settings
                                </button>
                            </div>
                        </div>

                        <div 
                            class="rounded-3xl p-6 sm:p-8 border shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden transition-all duration-300"
                            :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'"
                        >
                            <div class="grid grid-cols-1 gap-8 relative z-10">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Contact Page Hero Title</label>
                                    <input 
                                        type="text" 
                                        v-model="contactSettingsForm.contact_hero_title" 
                                        required 
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                    />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Contact Page Hero Description</label>
                                    <textarea 
                                        v-model="contactSettingsForm.contact_hero_description" 
                                        required 
                                        rows="3"
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                    ></textarea>
                                </div>
                            </div>

                            <div class="border-t pt-8 mt-10 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center dark:bg-blue-500/20 dark:text-blue-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black uppercase tracking-wider" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Contact Page Featured Image</h4>
                                        <p class="text-xs" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Upload or change the campus banner image displayed on the Contact Us page.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Upload New Campus Image</label>
                                        <input 
                                            type="file" 
                                            accept="image/*" 
                                            @input="contactSettingsForm.contact_image = $event.target.files[0]" 
                                            class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-2.5 transition-all file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:cursor-pointer hover:file:opacity-90"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-100 text-slate-900 file:bg-blue-600 file:text-white'" 
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Current Preview (Click to view full size)</label>
                                        <div v-if="typeof contactSettingsForm.contact_image === 'string' && contactSettingsForm.contact_image" @click="openImagePreview(contactSettingsForm.contact_image)" class="relative group/thumb cursor-pointer w-max" title="Click to view full image">
                                            <img :src="contactSettingsForm.contact_image" alt="Contact Preview" class="w-36 h-20 rounded-xl object-cover border shadow-sm transition-transform group-hover/thumb:scale-105" :class="isDarkMode ? 'border-slate-700' : 'border-slate-200'" />
                                            <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </div>
                                        </div>
                                        <div v-else-if="contactSettingsForm.contact_image && typeof contactSettingsForm.contact_image === 'object'" @click="openImagePreview(contactSettingsForm.contact_image)" class="relative group/thumb cursor-pointer w-max" title="Click to view full image">
                                            <img :src="getObjectUrl(contactSettingsForm.contact_image)" alt="New File Preview" class="w-36 h-20 rounded-xl object-cover border border-blue-500/50 shadow-sm transition-transform group-hover/thumb:scale-105" />
                                            <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover/thumb:opacity-100 transition-opacity flex items-center justify-center text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </div>
                                        </div>
                                        <div v-else class="text-xs text-slate-400 italic">No image selected</div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t pt-8 mt-10 relative z-10" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center dark:bg-indigo-500/20 dark:text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black uppercase tracking-wider" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Contact Information</h4>
                                        <p class="text-xs" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage address, email, phone numbers, and social media links displayed on the contact page.</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Address (English)</label>
                                        <textarea v-model="contactSettingsForm.address.en" rows="3" class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500'"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Address (Khmer)</label>
                                        <textarea v-model="contactSettingsForm.address.km" rows="3" class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500'"></textarea>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start mt-6">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Email Address</label>
                                        <input type="email" v-model="contactSettingsForm.email" class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500'" />
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Main Phone Number</label>
                                        <input type="text" v-model="contactSettingsForm.phone" class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500'" />
                                    </div>
                                </div>
                                
                                <div class="mt-6 border border-slate-100 dark:border-slate-800 rounded-2xl p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Direct Telephone Lines</label>
                                        <button type="button" @click="addContactDirectLine" class="text-[11px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white px-3 py-1.5 rounded-xl transition-colors dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-600 dark:hover:text-white flex items-center gap-1.5">
                                            + Add Line
                                        </button>
                                    </div>
                                    <div class="space-y-3">
                                        <div v-for="(line, idx) in contactSettingsForm.direct_lines" :key="'cdl'+idx" class="flex items-center gap-3">
                                            <input type="text" v-model="contactSettingsForm.direct_lines[idx]" placeholder="e.g. 099 111 111" class="flex-1 rounded-xl text-sm border-2 focus:outline-none px-4 py-2 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500'" />
                                            <button type="button" @click="removeContactDirectLine(idx)" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500 dark:hover:text-white flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                        <div v-if="contactSettingsForm.direct_lines.length === 0" class="text-xs text-center italic py-2" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">No direct lines added.</div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 border border-slate-100 dark:border-slate-800 rounded-2xl p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">Social Media Links</label>
                                        <button type="button" @click="addContactSocialLink" class="text-[11px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white px-3 py-1.5 rounded-xl transition-colors dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-600 dark:hover:text-white flex items-center gap-1.5">
                                            + Add Link
                                        </button>
                                    </div>
                                    <div class="space-y-3">
                                        <div v-for="(link, idx) in contactSettingsForm.social_links" :key="'csl'+idx" class="flex flex-col sm:flex-row items-center gap-3">
                                            <input type="text" v-model="contactSettingsForm.social_links[idx].label" placeholder="Platform (e.g. Facebook)" class="w-full sm:w-1/3 rounded-xl text-sm border-2 focus:outline-none px-4 py-2 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500'" />
                                            <div class="flex items-center gap-3 w-full sm:w-2/3">
                                                <input type="text" v-model="contactSettingsForm.social_links[idx].href" placeholder="URL Link" class="flex-1 rounded-xl text-sm border-2 focus:outline-none px-4 py-2 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500'" />
                                                <button type="button" @click="removeContactSocialLink(idx)" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500 dark:hover:text-white flex-shrink-0">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div v-if="contactSettingsForm.social_links.length === 0" class="text-xs text-center italic py-2" :class="isDarkMode ? 'text-slate-500' : 'text-slate-400'">No social links added.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TAB: TRANSLATIONS -->
                <div v-if="activeTab === 'translations'" class="animate-fadeIn space-y-8">
                    <!-- Sticky Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 sticky top-0 z-50 p-4 sm:px-6 bg-white/70 dark:bg-[#0c101b]/70 backdrop-blur-xl rounded-2xl border border-white/50 dark:border-slate-700/50 shadow-xl shadow-blue-900/5 dark:shadow-black/20 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 7.31 16.5 1 18"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-black leading-tight mb-1" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Translations Manager</h3>
                                <p class="text-sm" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage English and Khmer translation dictionaries for site-wide static labels.</p>
                            </div>
                        </div>
                        <button type="button" @click="restoreDefaultTranslations()" class="w-full md:w-auto bg-amber-500/10 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-full px-6 py-3 text-sm font-black border border-amber-500/20 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Redo / Restore Defaults
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-[1.5fr_1fr] gap-8 items-start">
                        
                        <!-- Translations List -->
                        <div 
                            class="rounded-3xl p-6 sm:p-8 border shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden transition-all duration-300"
                            :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'"
                        >
                            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 mb-8 relative z-10">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black mb-1 leading-tight" :class="isDarkMode ? 'text-white' : 'text-slate-900'">Static UI Translations</h3>
                                        <p class="text-sm" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Manage static interface strings and phrases (English to Khmer).</p>
                                    </div>
                                </div>
                                <div class="relative w-full xl:w-72 shrink-0 group">
                                    <input type="text" v-model="searchQueryTranslations" placeholder="Search keys or translations..." class="w-full rounded-2xl text-sm border-2 focus:outline-none px-5 py-3.5 pl-11 transition-all duration-300" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500 focus:bg-[#0c101b] shadow-inner' : 'bg-slate-50 border-slate-100 focus:bg-white focus:border-indigo-500 focus:shadow-[0_8px_30px_rgb(0,0,0,0.06)]'">
                                    <svg class="w-5 h-5 absolute left-4 top-3.5 transition-colors duration-300" :class="isDarkMode ? 'text-slate-500 group-focus-within:text-indigo-400' : 'text-slate-400 group-focus-within:text-indigo-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>

                            <div class="overflow-x-auto rounded-2xl border" :class="isDarkMode ? 'border-[#1a2333]' : 'border-slate-100'">
                                <table class="w-full text-sm text-left">
                                    <thead :class="isDarkMode ? 'bg-[#1a2333]/50 text-slate-300' : 'bg-slate-50 text-slate-600'">
                                        <tr class="border-b" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                            <th class="py-4 px-5 font-black uppercase tracking-widest text-[10px]">Key (English Phrase)</th>
                                            <th class="py-4 px-5 font-black uppercase tracking-widest text-[10px]">Khmer Translation</th>
                                            <th class="py-4 px-5 text-right font-black uppercase tracking-widest text-[10px]">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y" :class="isDarkMode ? 'divide-slate-800/50' : 'divide-slate-100'">
                                        <tr v-for="tItem in filteredTranslations" :key="tItem.id" class="transition-colors hover:bg-indigo-50/50 group" :class="isDarkMode ? 'hover:bg-[#1a2333]/40' : ''">
                                            <td class="py-4 px-5 font-bold font-mono text-xs max-w-[200px] truncate" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">{{ tItem.key }}</td>
                                            <td class="py-4 px-5">
                                                <div v-if="tItem.km" class="font-bold text-[13px] flex items-center gap-2" :class="isDarkMode ? 'text-emerald-400' : 'text-emerald-600'">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> {{ tItem.km }}
                                                </div>
                                                <div v-else class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-black uppercase tracking-wider" :class="isDarkMode ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-red-50 text-red-500 border border-red-100'">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Missing Translation
                                                </div>
                                            </td>
                                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button @click="openViewTranslationModal(tItem)" class="p-2 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-colors dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white" title="View Translation Details">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </button>
                                                    <button @click="startEditTranslation(tItem)" class="p-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors dark:bg-blue-500/10 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    </button>
                                                    <button @click="deleteTranslation(tItem.id)" class="p-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white" title="Delete">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="!filteredTranslations || filteredTranslations.length === 0">
                                            <td colspan="3" class="py-12 text-center">
                                                <div class="inline-flex flex-col items-center justify-center text-center">
                                                    <div class="w-16 h-16 mb-4 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                    <span class="text-sm font-bold" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <span v-if="searchQueryTranslations">No translations found matching your search.</span>
                                                        <span v-else>No static translations registered yet.</span>
                                                    </span>
                                                    <span v-if="!searchQueryTranslations" class="text-xs mt-1" :class="isDarkMode ? 'text-slate-500' : 'text-slate-500'">Click 'Register New Translation Key' on the right to start.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Translation Form -->
                        <div class="sticky top-[95px]">
                            <div 
                                class="rounded-3xl p-6 sm:p-8 border shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden"
                                :class="isDarkMode ? 'bg-[#0f1524] border-[#1a2333] shadow-[0_8px_30px_rgb(0,0,0,0.5)]' : 'bg-white border-slate-100'"
                            >
                            <div class="absolute top-0 right-0 p-6 opacity-5 pointer-events-none">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            </div>
                            
                            <h3 class="text-xl font-black mb-2 relative z-10 flex items-center gap-2" :class="isDarkMode ? 'text-white' : 'text-slate-900'">
                                <span v-if="editingTranslation && editingTranslation !== 'new'" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center dark:bg-blue-500/20 dark:text-blue-400">✏️</span>
                                <span v-else class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center dark:bg-indigo-500/20 dark:text-indigo-400">✨</span>
                                {{ editingTranslation && editingTranslation !== 'new' ? 'Edit Translation' : 'Register New Key' }}
                            </h3>
                            <p class="text-sm mb-6 relative z-10" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Map any English phrase to its Khmer equivalent. The system will auto-translate components matching this key.</p>

                            <form @submit.prevent="submitTranslation" class="space-y-5 relative z-10">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Translation Key (English Phrase)</label>
                                    <textarea 
                                        v-model="translationForm.key" 
                                        required 
                                        :disabled="editingTranslation && editingTranslation !== 'new'"
                                        rows="2"
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300 resize-none"
                                        :class="isDarkMode 
                                            ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500 disabled:opacity-50 disabled:bg-[#0c101b]' 
                                            : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)] disabled:opacity-50 disabled:bg-slate-100'" 
                                        placeholder="e.g. Rector's Message"
                                    ></textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">English Value (Optional fallback)</label>
                                    <textarea 
                                        v-model="translationForm.en" 
                                        rows="2"
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300 resize-none"
                                        :class="isDarkMode 
                                            ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-indigo-500' 
                                            : 'bg-slate-50 border-slate-100 text-slate-900 focus:bg-white focus:border-indigo-500 focus:shadow-[0_4px_20px_rgb(0,0,0,0.05)]'" 
                                        placeholder="e.g. Rector's Message"
                                    ></textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-2" :class="isDarkMode ? 'text-emerald-400' : 'text-emerald-600'">Khmer Value (Translation) *</label>
                                    <textarea 
                                        v-model="translationForm.km" 
                                        required
                                        rows="3"
                                        class="w-full rounded-2xl text-sm border-2 focus:outline-none px-4 py-3 transition-all duration-300 resize-none"
                                        :class="isDarkMode 
                                            ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-emerald-500' 
                                            : 'bg-emerald-50/30 border-emerald-100 text-slate-900 focus:bg-white focus:border-emerald-500 focus:shadow-[0_4px_20px_rgb(16,185,129,0.1)]'" 
                                        placeholder="e.g. សាររបស់សាកលវិទ្យាធិការ"
                                    ></textarea>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                    <button type="submit" class="w-full sm:flex-1 bg-gradient-to-r from-indigo-600 to-violet-600 hover:shadow-indigo-500/40 hover:scale-[1.02] text-white rounded-xl py-3.5 text-[13px] font-black shadow-lg shadow-indigo-500/20 transition-all flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        {{ editingTranslation && editingTranslation !== 'new' ? 'Save Changes' : 'Register Key' }}
                                    </button>
                                    <button 
                                        v-if="editingTranslation" 
                                        type="button" 
                                        @click="cancelEditTranslation" 
                                        class="w-full sm:w-auto rounded-xl px-6 py-3.5 text-[13px] font-bold border transition-all hover:scale-[1.02]"
                                        :class="isDarkMode 
                                            ? 'bg-slate-800 border-slate-700 hover:bg-slate-700 text-slate-300 shadow-lg shadow-slate-900/50' 
                                            : 'bg-white border-slate-200 hover:bg-slate-50 text-slate-700 shadow-sm'"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        <!-- Event form Modal -->
        <Teleport to="body">
            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <div v-if="editingEvent" class="fixed inset-0 z-[100] flex sm:items-start items-start justify-center p-4 py-12 backdrop-blur-md overflow-y-auto">
                    <div 
                        class="relative w-full max-w-3xl rounded-3xl p-8 border shadow-2xl transform transition-all duration-300 my-8 "
                        :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333]' : 'bg-white border-slate-200'"
                        @click.stop
                    >
                    <!-- Close Button -->
                    <button 
                        @click="editingEvent = null" 
                        class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full transition-colors"
                        :class="isDarkMode ? 'bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800'"
                    >
                        ✕
                    </button>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-blue-500 bg-blue-500/10 ring-4 ring-blue-500/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-extrabold tracking-tight" :class="isDarkMode ? 'text-white' : 'text-slate-900'">
                                {{ editingEvent === 'new' ? 'Create New Event Article' : 'Edit Event Article' }}
                            </h4>
                            <p class="text-xs mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                Fill out the form below to publish your event or save it as a draft.
                            </p>
                        </div>
                    </div>
                    
                    <form @submit.prevent="submitEvent" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Article Title (English)</label>
                                <input 
                                    type="text" 
                                    v-model="eventForm.title.en" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none focus:ring-4 transition-all px-4 py-2.5"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 focus:ring-blue-500/10' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-blue-500/10'" 
                                />
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Article Title (Khmer)</label>
                                <input 
                                    type="text" 
                                    v-model="eventForm.title.km" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none focus:ring-4 transition-all px-4 py-2.5"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 focus:ring-blue-500/10' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-blue-500/10'" 
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Event Type / Class</label>
                                <select 
                                    v-model="eventForm.type" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none focus:ring-4 transition-all px-4 py-2.5"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 focus:ring-blue-500/10' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-blue-500/10'"
                                >
                                    <option value="campus">Campus Event</option>
                                    <option value="digital">Digital Industry Event</option>
                                    <option value="announcement">Important Announcement</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Date (EN)</label>
                                    <input 
                                        type="date" 
                                        v-model="eventForm.date.en" 
                                        @input="autoFillKhmerDate"
                                        required 
                                        class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2.5"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500'" 
                                    />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Date (KM) Auto-filled</label>
                                    <input 
                                        type="text" 
                                        v-model="eventForm.date.km" 
                                        placeholder="e.g. ១៥ /មិថុនា /២០២៦"
                                        required 
                                        class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2.5"
                                        :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500'" 
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Grid Card Image (Upload File)</label>
                                <input 
                                    type="file" 
                                    accept="image/*"
                                    @input="eventForm.image = $event.target.files[0]" 
                                    class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500 file:bg-blue-600 file:text-white'" 
                                />
                                <div v-if="typeof eventForm.image === 'string' && eventForm.image" class="mt-2 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Image uploaded and saved. Select a new file to replace it.
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Detail Banner Image (Upload File)</label>
                                <input 
                                    type="file" 
                                    accept="image/*"
                                    @input="eventForm.detail_image = $event.target.files[0]" 
                                    class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500 file:bg-blue-600 file:text-white'" 
                                />
                                <div v-if="typeof eventForm.detail_image === 'string' && eventForm.detail_image" class="mt-2 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Image uploaded and saved. Select a new file to replace it.
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Grid Abstract Description (English)</label>
                                <textarea 
                                    v-model="eventForm.description.en" 
                                    required 
                                    rows="2" 
                                    class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2.5"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500'"
                                ></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Grid Abstract Description (Khmer)</label>
                                <textarea 
                                    v-model="eventForm.description.km" 
                                    required 
                                    rows="2" 
                                    class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2.5"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-500'"
                                ></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Full Article Text (English)</label>
                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="eventForm.content.en" 
     
></QuillEditor></div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Full Article Text (Khmer)</label>
                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
    theme="snow" 
    contentType="html" 
    v-model:content="eventForm.content.km" 
     
></QuillEditor></div>
                            </div>
                        </div>
                        <div class="flex gap-4 pt-4 border-t" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <button 
                                type="button" 
                                @click="editingEvent = null" 
                                class="flex-1 rounded-xl px-5 py-3 text-sm font-bold border transition-all focus:ring-4 focus:outline-none"
                                :class="isDarkMode 
                                    ? 'bg-slate-800 border-slate-700 hover:bg-slate-700 text-slate-300 focus:ring-slate-800' 
                                    : 'bg-slate-100 border-slate-200 hover:bg-slate-200 text-slate-700 focus:ring-slate-200'"
                            >
                                Cancel
                            </button>
                            <button 
                                type="button" 
                                @click="eventForm.is_published = false; submitEvent()"
                                class="flex-1 rounded-xl px-5 py-3 text-sm font-bold border transition-all focus:ring-4 focus:outline-none"
                                :class="isDarkMode 
                                    ? 'bg-slate-700 border-slate-600 hover:bg-slate-600 text-slate-200 focus:ring-slate-700' 
                                    : 'bg-slate-200 border-slate-300 hover:bg-slate-300 text-slate-800 focus:ring-slate-300'"
                            >
                                Save as Draft
                            </button>
                            <button 
                                type="button" 
                                @click="eventForm.is_published = true; submitEvent()"
                                class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-3 text-sm font-black shadow-lg shadow-blue-500/20 transition-all focus:ring-4 focus:outline-none focus:ring-blue-500/30">
                                Publish Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Transition>
    </Teleport>

        <!-- Faculty Form Modal -->
        <Teleport to="body">
            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <div v-if="editingFaculty" class="fixed inset-0 z-[100] flex sm:items-start items-start justify-center p-4 py-12 backdrop-blur-md overflow-y-auto bg-slate-900/60">
                    <div 
                        class="relative w-full max-w-5xl rounded-3xl p-8 border shadow-2xl transform transition-all duration-300 my-8"
                        :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333]' : 'bg-white border-slate-200'"
                        @click.stop
                    >
                    <!-- Close Button -->
                    <button 
                        @click="editingFaculty = null" 
                        class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full transition-colors"
                        :class="isDarkMode ? 'bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800'"
                    >
                        ✕
                    </button>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-blue-500 bg-blue-500/10 ring-4 ring-blue-500/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-extrabold tracking-tight" :class="isDarkMode ? 'text-white' : 'text-slate-900'">
                                {{ editingFaculty === 'new' ? '✨ Add New Faculty' : '✏️ Edit Faculty' }}
                            </h4>
                            <p class="text-xs mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                Fill out the form below to save faculty information.
                            </p>
                        </div>
                    </div>
                    
                    <form @submit.prevent="submitFaculty" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Faculty Name (English)</label>
                                <input 
                                    type="text" 
                                    v-model="facultyForm.name.en" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                />
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Faculty Name (Khmer)</label>
                                <input 
                                    type="text" 
                                    v-model="facultyForm.name.km" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none px-4 py-2"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                />
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Cover Image (For Faculty Menu)</label>
                            <input 
                                type="file" 
                                accept="image/*"
                                @input="facultyForm.cover_image = $event.target.files[0]" 
                                class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650 file:bg-blue-600 file:text-white'" 
                            />
                            <div v-if="typeof facultyForm.cover_image === 'string' && facultyForm.cover_image" class="mt-2 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Image uploaded and saved. Select a new file to replace it.
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Organization Structure Chart Image (Upload File)</label>
                            <input 
                                type="file" 
                                accept="image/*"
                                @input="facultyForm.org_chart_image = $event.target.files[0]" 
                                class="w-full rounded-xl text-sm border focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-bold file:cursor-pointer hover:file:opacity-90 transition-all"
                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500 file:bg-blue-600 file:text-white' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650 file:bg-blue-600 file:text-white'" 
                            />
                            <div v-if="typeof facultyForm.org_chart_image === 'string' && facultyForm.org_chart_image" class="mt-2 text-[10px] font-bold text-emerald-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Image uploaded and saved. Select a new file to replace it.
                            </div>
                        </div>
                        
                        <!-- Faculty Custom Sections -->
                        <div class="border-t pt-4 mt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Custom Sections</label>
                                <button type="button" @click="addFacultyCustomSection" class="text-xs font-bold text-blue-500 hover:underline">+ Add Section</button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div v-for="(section, idx) in facultyForm.custom_sections" :key="idx" class="flex flex-col gap-3 p-4 border rounded-xl" :class="isDarkMode ? 'border-slate-800 bg-[#0c101b]' : 'border-slate-100 bg-white'">
                                    <div class="flex justify-between items-center">
                                        <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title</label>
                                        <button type="button" @click="removeFacultyCustomSection(idx)" class="text-red-500 hover:text-red-400 text-xs font-bold">✕ Delete</button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (EN)</label>
                                            <input 
                                                type="text" 
                                                v-model="section.title.en" 
                                                placeholder="E.g., Mission, Vision"
                                                class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (KM)</label>
                                            <input 
                                                type="text" 
                                                v-model="section.title.km" 
                                                placeholder="E.g., បេសកកម្ម និងចក្ខុវិស័យ"
                                                class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 mt-2">
                                        <div class="flex-grow flex flex-col">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (EN)</label>
                                            <div class="bg-white text-black flex-grow flex flex-col" :class="isDarkMode ? 'rounded overflow-hidden' : ''">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.en" contentType="html"  ></QuillEditor></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow flex flex-col">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (KM)</label>
                                            <div class="bg-white text-black flex-grow flex flex-col" :class="isDarkMode ? 'rounded overflow-hidden' : ''">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.km" contentType="html"  ></QuillEditor></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex gap-3 mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-2.5 text-xs font-black shadow-lg shadow-blue-500/10">Save Faculty</button>
                            <button 
                                type="button" 
                                @click="editingFaculty = null" 
                                class="rounded-xl px-4 py-2.5 text-xs font-bold border transition-colors"
                                :class="isDarkMode 
                                    ? 'bg-slate-800 border-slate-700 hover:bg-slate-700 text-slate-300' 
                                    : 'bg-slate-100 border-slate-200 hover:bg-slate-250 text-slate-700'"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Department Form Modal -->
        <Teleport to="body">
            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <div v-if="editingDept" class="fixed inset-0 z-[100] flex sm:items-start items-start justify-center p-4 py-12 backdrop-blur-md overflow-y-auto bg-slate-900/60">
                    <div 
                        class="relative w-full max-w-5xl rounded-3xl p-8 border shadow-2xl transform transition-all duration-300 my-8"
                        :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333]' : 'bg-white border-slate-200'"
                        @click.stop
                    >
                    <!-- Close Button -->
                    <button 
                        @click="editingDept = null" 
                        class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full transition-colors"
                        :class="isDarkMode ? 'bg-slate-800 text-slate-400 hover:bg-slate-700 hover:text-white' : 'bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-800'"
                    >
                        ✕
                    </button>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-emerald-500 bg-emerald-500/10 ring-4 ring-emerald-500/10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v12a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-extrabold tracking-tight" :class="isDarkMode ? 'text-white' : 'text-slate-900'">
                                {{ editingDept === 'new' ? '✨ Add New Department' : '✏️ Edit Department' }}
                            </h4>
                            <p class="text-xs mt-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                Fill out the form below to save department information.
                            </p>
                        </div>
                    </div>

                    <form @submit.prevent="submitDept" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Parent Faculty</label>
                                <select 
                                    v-model="deptForm.faculty_id" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none text-slate-230 px-3 py-2"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'"
                                >
                                    <option v-for="f in props.faculties" :key="f.id" :value="f.id">{{ getAdminLabel(f.name) }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Dept Name (EN)</label>
                                <input 
                                    type="text" 
                                    v-model="deptForm.name.en" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                />
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Dept Name (KM)</label>
                                <input 
                                    type="text" 
                                    v-model="deptForm.name.km" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                />
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">URL Slug</label>
                                <input 
                                    type="text" 
                                    v-model="deptForm.slug" 
                                    required 
                                    class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2"
                                    :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                    placeholder="e.g. graphic-design" 
                                />
                            </div>
                        </div>
                        <div class="border-t pt-4 mt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Majors</label>
                                <button type="button" @click="addDeptMajor" class="text-xs font-bold text-blue-500 hover:underline">+ Add Major</button>
                            </div>
                            <div class="space-y-4">
                                <div v-for="(major, idx) in deptForm.majors" :key="idx" class="grid grid-cols-2 gap-4 items-center">
                                    <div>
                                        <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Major (EN)</label>
                                        <input 
                                            type="text" 
                                            v-model="major.name.en" 
                                            class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2"
                                            :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            placeholder="e.g. Information Technology" 
                                        />
                                    </div>
                                    <div class="flex gap-2 items-end">
                                        <div class="flex-grow">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Major (KM)</label>
                                            <input 
                                                type="text" 
                                                v-model="major.name.km" 
                                                class="w-full rounded-xl text-sm border focus:outline-none px-3 py-2"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                                placeholder="e.g. បច្ចេកវិទ្យាព័ត៌មាន" 
                                            />
                                        </div>
                                        <button type="button" @click="removeDeptMajor(idx)" class="text-red-500 hover:text-red-400 mb-2 p-1 font-bold text-xs">✕</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Overview Description (English)</label>
                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
                                    theme="snow" 
                                    contentType="html" 
                                    v-model:content="deptForm.description.en" 
                                    
                                    ></QuillEditor></div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Overview Description (Khmer)</label>
                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor 
                                    theme="snow" 
                                    contentType="html" 
                                    v-model:content="deptForm.description.km" 
                                    
                                    ></QuillEditor></div>
                            </div>
                        </div>
                        
                        <!-- Dept Custom Sections -->
                        <div class="border-t pt-4 mt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex justify-between items-center mb-3">
                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Custom Sections</label>
                                <button type="button" @click="addDeptCustomSection" class="text-xs font-bold text-blue-500 hover:underline">+ Add Section</button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div v-for="(section, idx) in deptForm.custom_sections" :key="idx" class="flex flex-col gap-3 p-4 border rounded-xl" :class="isDarkMode ? 'border-slate-800 bg-[#0c101b]' : 'border-slate-100 bg-white'">
                                    <div class="flex justify-between items-center">
                                        <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title</label>
                                        <button type="button" @click="removeDeptCustomSection(idx)" class="text-red-500 hover:text-red-400 text-xs font-bold">✕ Delete</button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (EN)</label>
                                            <input 
                                                type="text" 
                                                v-model="section.title.en" 
                                                placeholder="E.g., Mission, Vision"
                                                class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (KM)</label>
                                            <input 
                                                type="text" 
                                                v-model="section.title.km" 
                                                placeholder="E.g., បេសកកម្ម និងចក្ខុវិស័យ"
                                                class="w-full rounded-xl text-sm border focus:outline-none px-3 py-1.5"
                                                :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 text-slate-900 focus:bg-white focus:border-blue-650'" 
                                            />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 mt-2">
                                        <div class="flex-grow flex flex-col">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (EN)</label>
                                            <div class="bg-white text-black flex-grow flex flex-col" :class="isDarkMode ? 'rounded overflow-hidden' : ''">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.en" contentType="html"  ></QuillEditor></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow flex flex-col">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5 mt-2" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Content (KM)</label>
                                            <div class="bg-white text-black flex-grow flex flex-col" :class="isDarkMode ? 'rounded overflow-hidden' : ''">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor theme="snow" v-model:content="section.content.km" contentType="html"  ></QuillEditor></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Degree Programs Sections -->
                        <div class="border-t pt-4 mt-4" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Degree Programs Content</label>
                            </div>
                            <div v-if="deptForm.majors.length === 0" class="p-4 rounded-xl text-sm border border-dashed" :class="isDarkMode ? 'border-slate-700 text-slate-400' : 'border-slate-300 text-slate-500'">
                                Please add at least one major above to define degree program content.
                            </div>
                            <div v-else>
                                <!-- Major Selection Tabs -->
                                <div class="flex mb-4 space-x-2 border-b overflow-x-auto pb-1" :class="isDarkMode ? 'border-slate-800' : 'border-slate-200'">
                                    <button 
                                        v-for="(major, idx) in deptForm.majors" 
                                        :key="idx"
                                        type="button" 
                                        @click="activeDeptMajorIndex = idx" 
                                        class="px-4 py-2 text-sm font-semibold border-b-2 whitespace-nowrap" 
                                        :class="activeDeptMajorIndex === idx ? 'border-emerald-500 text-emerald-600' : 'border-transparent ' + (isDarkMode ? 'text-slate-400 hover:text-slate-300' : 'text-slate-500 hover:text-slate-700')"
                                    >
                                        {{ major.name.en || ('Major ' + (idx + 1)) }}
                                    </button>
                                </div>
                                
                                <!-- Degree Tabs -->
                                <div class="flex mb-6 space-x-2 border-b" :class="isDarkMode ? 'border-slate-800' : 'border-slate-200'">
                                    <button type="button" @click="activeDeptProgramTab = 'bachelor'" class="px-4 py-2 text-sm font-semibold border-b-2" :class="activeDeptProgramTab === 'bachelor' ? 'border-blue-500 text-blue-600' : 'border-transparent ' + (isDarkMode ? 'text-slate-400 hover:text-slate-300' : 'text-slate-500 hover:text-slate-700')">Bachelor's Degree</button>
                                    <button type="button" @click="activeDeptProgramTab = 'associate'" class="px-4 py-2 text-sm font-semibold border-b-2" :class="activeDeptProgramTab === 'associate' ? 'border-blue-500 text-blue-600' : 'border-transparent ' + (isDarkMode ? 'text-slate-400 hover:text-slate-300' : 'text-slate-500 hover:text-slate-700')">Associate's Degree</button>
                                </div>

                            <div class="space-y-6">
                                <div v-for="(section, idx) in deptForm.majors[activeDeptMajorIndex].programs[activeDeptProgramTab].sections" :key="idx" class="flex flex-col gap-3 p-4 border rounded-xl" :class="isDarkMode ? 'border-slate-800 bg-[#0c101b]' : 'border-slate-100 bg-white'">
                                    <div class="flex justify-between items-start gap-4">
                                        <div class="flex-grow grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="space-y-1">
                                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (EN)</label>
                                                <input type="text" v-model="section.title.en" class="w-full rounded-lg text-sm border focus:outline-none px-3 py-2" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500'" placeholder="e.g. 1. Program Aim" />
                                            </div>
                                            <div class="space-y-1">
                                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Section Title (KM)</label>
                                                <input type="text" v-model="section.title.km" class="w-full rounded-lg text-sm border focus:outline-none px-3 py-2" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333] text-white focus:border-blue-500' : 'bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500'" placeholder="e.g. ១. គោលបំណងកម្មវិធី" />
                                            </div>
                                            <div class="col-span-1 md:col-span-2 space-y-1">
                                                <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Content Type</label>
                                                <div class="flex gap-4 flex-wrap">
                                                    <label class="flex items-center gap-2 text-sm cursor-pointer" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <input type="radio" v-model="section.type" value="richtext" class="text-blue-500 focus:ring-blue-500" />
                                                        Rich Text Editor
                                                    </label>
                                                    <label class="flex items-center gap-2 text-sm cursor-pointer" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <input type="radio" v-model="section.type" value="course_structure" class="text-blue-500 focus:ring-blue-500" />
                                                        Course Structure Table
                                                    </label>
                                                    <label class="flex items-center gap-2 text-sm cursor-pointer" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                        <input type="radio" v-model="section.type" value="custom_table" class="text-blue-500 focus:ring-blue-500" />
                                                        Custom Data Table
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1 mt-6">
                                            <button v-if="idx > 0" type="button" @click="moveProgramSectionUp(activeDeptMajorIndex, activeDeptProgramTab, idx)" class="text-blue-500 hover:bg-blue-50 p-2 rounded-lg transition-colors" title="Move Section Up">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                            </button>
                                            <button v-if="idx < deptForm.majors[activeDeptMajorIndex].programs[activeDeptProgramTab].sections.length - 1" type="button" @click="moveProgramSectionDown(activeDeptMajorIndex, activeDeptProgramTab, idx)" class="text-blue-500 hover:bg-blue-50 p-2 rounded-lg transition-colors" title="Move Section Down">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                            <button type="button" @click="removeProgramSection(activeDeptMajorIndex, activeDeptProgramTab, idx)" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Remove Section">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Rich Text Editor -->
                                    <div v-if="section.type === 'richtext'" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                        <div class="flex-grow flex flex-col">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Content (EN)</label>
                                            <div class="bg-white text-black flex-grow flex flex-col" :class="isDarkMode ? 'rounded overflow-hidden' : ''">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor :key="`en-${activeDeptMajorIndex}-${activeDeptProgramTab}-${idx}`" theme="snow" v-model:content="section.content.en" contentType="html"  ></QuillEditor></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow flex flex-col">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1.5" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Content (KM)</label>
                                            <div class="bg-white text-black flex-grow flex flex-col" :class="isDarkMode ? 'rounded overflow-hidden' : ''">
                                                <div class="bg-white text-black rounded min-h-[200px] overflow-hidden"><QuillEditor :key="`km-${activeDeptMajorIndex}-${activeDeptProgramTab}-${idx}`" theme="snow" v-model:content="section.content.km" contentType="html"  ></QuillEditor></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Course Structure Builder -->
                                    <div v-else-if="section.type === 'course_structure'" class="mt-4 p-4 rounded-xl border" :class="isDarkMode ? 'bg-[#0c101b] border-slate-800' : 'bg-indigo-50/30 border-indigo-200'">
                                        <div class="flex justify-between items-center mb-4">
                                            <h4 class="font-bold text-base" :class="isDarkMode ? 'text-white' : 'text-[#1c244b]'">Course Structure Builder</h4>
                                            <div class="flex gap-4 text-sm font-extrabold" :class="isDarkMode ? 'text-blue-400' : 'text-[#3852a4]'">
                                                <span>Grand Total: {{ computeGrandTotals(section.courseStructure).credits }} Credits</span>
                                                <span>{{ computeGrandTotals(section.courseStructure).hours }} Hours</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-6">
                                            <button @click="openGlobalSmartImport(section)" type="button" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-lg font-black text-sm transition-all transform hover:scale-[1.01] shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                ✨ Smart Paste Full Curriculum (Word/Excel)
                                            </button>
                                            
                                            <!-- Global Smart Paste Area -->
                                            <div v-if="activeGlobalSmartImportSection === section" class="mt-3 p-5 rounded-xl border-2 border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-800/60">
                                                <div class="flex items-start gap-3 mb-3">
                                                    <div class="p-2 bg-purple-200 dark:bg-purple-800/50 rounded-lg text-purple-700 dark:text-purple-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                    <div>
                                                        <h5 class="text-sm font-bold text-purple-900 dark:text-purple-300">Paste Entire Curriculum</h5>
                                                        <p class="text-xs text-purple-700 dark:text-purple-400">Copy the full table (including "Year X" and "Semester" headers) and paste it below. This will <strong>overwrite</strong> the current structure.</p>
                                                    </div>
                                                </div>
                                                <textarea v-model="globalSmartImportText" rows="8" class="w-full rounded-xl text-sm border-2 border-purple-200 focus:border-purple-500 focus:outline-none p-4 resize-y dark:bg-[#0c101b] dark:border-purple-900/50 dark:text-slate-300" placeholder="Year I&#10;Semester I    Semester II&#10;Computer for Office..."></textarea>
                                                <div class="flex justify-end gap-3 mt-3">
                                                    <button @click="activeGlobalSmartImportSection = null" type="button" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400">Cancel</button>
                                                    <button @click="executeGlobalSmartImport()" type="button" class="px-5 py-2 text-xs font-black bg-purple-600 text-white rounded-lg hover:bg-purple-700 shadow-md">🚀 Generate Curriculum</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div v-for="(yr, yIdx) in section.courseStructure" :key="yIdx" class="mb-6 p-4 rounded-lg bg-white border border-slate-200 shadow-sm" :class="isDarkMode ? 'bg-[#090d16] border-slate-800' : ''">
                                            <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100" :class="isDarkMode ? 'border-slate-800' : ''">
                                                <div class="flex gap-3">
                                                    <input type="text" v-model="yr.year.en" @input="() => { const kh = translateHeaderKhmer(yr.year.en); if (kh) yr.year.km = kh; }" placeholder="Year I (EN)" class="rounded-md text-sm border focus:outline-none px-2 py-1" :class="isDarkMode ? 'bg-[#0c101b] border-slate-700 text-white' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                    <input type="text" v-model="yr.year.km" placeholder="Year I (KM)" class="rounded-md text-sm border focus:outline-none px-2 py-1" :class="isDarkMode ? 'bg-[#0c101b] border-slate-700 text-white' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <span class="text-xs font-bold" :class="isDarkMode ? 'text-slate-300' : 'text-slate-500'">Year Total: {{ computeYearTotals(yr).credits }} Cr / {{ computeYearTotals(yr).hours }} Hr</span>
                                                    <button @click="removeCourseYear(section, yIdx)" type="button" class="text-red-500 hover:text-red-700 text-xs font-bold">Remove Year</button>
                                                </div>
                                            </div>
                                            
                                            <div v-for="(sem, sIdx) in yr.semesters" :key="sIdx" class="mb-4 pl-4 border-l-2 border-[#3852a4]/30">
                                                <div class="flex justify-between items-center mb-3">
                                                    <div class="flex gap-2">
                                                        <input type="text" v-model="sem.semester.en" @input="() => { const kh = translateHeaderKhmer(sem.semester.en); if (kh) sem.semester.km = kh; }" placeholder="Semester I (EN)" class="w-32 rounded text-xs border focus:outline-none px-2 py-1" :class="isDarkMode ? 'bg-[#0c101b] border-slate-700 text-white' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                        <input type="text" v-model="sem.semester.km" placeholder="Semester I (KM)" class="w-32 rounded text-xs border focus:outline-none px-2 py-1" :class="isDarkMode ? 'bg-[#0c101b] border-slate-700 text-white' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                    </div>
                                                    <button @click="removeCourseSemester(yr, sIdx)" type="button" class="text-red-500 hover:text-red-700 text-xs font-bold">Remove Sem</button>
                                                </div>
                                                
                                                <table class="w-full text-left text-sm mb-2 rounded overflow-hidden">
                                                    <thead class="bg-[#1c244b] text-white text-xs">
                                                        <tr>
                                                            <th class="px-2 py-1 w-10">No.</th>
                                                            <th class="px-2 py-1">Subject (EN)</th>
                                                            <th class="px-2 py-1">Subject (KM)</th>
                                                            <th class="px-2 py-1 w-20 text-center">Credits</th>
                                                            <th class="px-2 py-1 w-20 text-center">Hours</th>
                                                            <th class="px-2 py-1 w-10"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100" :class="isDarkMode ? 'divide-slate-800' : ''">
                                                        <tr v-for="(sub, subIdx) in sem.subjects" :key="subIdx">
                                                            <td class="px-2 py-1 text-center font-bold" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">{{ subIdx + 1 }}</td>
                                                            <td class="px-2 py-1"><input type="text" v-model="sub.name.en" placeholder="e.g. Critical Thinking" class="w-full bg-transparent border-b focus:outline-none px-1" :class="isDarkMode ? 'border-slate-700 text-slate-200 focus:border-blue-400' : 'border-slate-300 text-slate-800'"/></td>
                                                            <td class="px-2 py-1"><input type="text" v-model="sub.name.km" placeholder="e.g. ការគិតបែបស៊ីជម្រៅ" class="w-full bg-transparent border-b focus:outline-none px-1" :class="isDarkMode ? 'border-slate-700 text-slate-200 focus:border-blue-400' : 'border-slate-300 text-slate-800'"/></td>
                                                            <td class="px-2 py-1"><input type="text" v-model="sub.credits" class="w-full bg-transparent border-b focus:outline-none text-center px-1" :class="isDarkMode ? 'border-slate-700 text-slate-200 focus:border-blue-400' : 'border-slate-300 text-slate-800'"/></td>
                                                            <td class="px-2 py-1"><input type="text" v-model="sub.hours" class="w-full bg-transparent border-b focus:outline-none text-center px-1" :class="isDarkMode ? 'border-slate-700 text-slate-200 focus:border-blue-400' : 'border-slate-300 text-slate-800'"/></td>
                                                            <td class="px-2 py-1 text-center"><button @click="removeCourseSubject(sem, subIdx)" type="button" class="text-red-400 hover:text-red-600 font-bold">&times;</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="flex items-center gap-4 mt-2 mb-2">
                                                    <button @click="addCourseSubject(sem)" type="button" class="text-xs font-bold hover:underline" :class="isDarkMode ? 'text-indigo-400' : 'text-[#3852a4]'">+ Add Subject</button>
                                                    <button @click="openSmartImport(yr, sem)" type="button" class="text-xs hover:underline font-bold flex items-center gap-1" :class="isDarkMode ? 'text-indigo-400' : 'text-indigo-600'"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Smart Paste (Word/Excel)</button>
                                                </div>
                                                
                                                <!-- Smart Paste Area -->
                                                <div v-if="activeSmartImportSemester === sem" class="mt-3 p-4 rounded-xl border border-indigo-200 bg-indigo-50/50 dark:bg-indigo-900/10 dark:border-indigo-800/50 transition-all duration-300">
                                                    <label class="block text-[10px] font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400 mb-2">Paste Table Data (Subject Name | Credits | Hours)</label>
                                                    <textarea v-model="smartImportText" rows="4" class="w-full rounded-xl text-sm border-2 border-indigo-100 focus:border-indigo-500 focus:outline-none p-3 resize-none transition-all dark:bg-[#0c101b] dark:border-indigo-900/50 dark:text-slate-300 dark:focus:border-indigo-500" placeholder="Copy rows from Word or Excel and paste them directly here..."></textarea>
                                                    <div class="flex justify-end gap-3 mt-3">
                                                        <button @click="activeSmartImportSemester = null" type="button" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">Cancel</button>
                                                        <button @click="executeSmartImport()" type="button" class="px-5 py-2 text-xs font-black bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg hover:shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:scale-[1.02]">✨ Parse & Auto-Fill</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button @click="addCourseSemester(yr)" type="button" class="text-xs px-3 py-1.5 rounded font-bold transition-colors" :class="isDarkMode ? 'bg-slate-800 hover:bg-slate-700 text-indigo-300 border border-slate-700' : 'bg-slate-100 hover:bg-slate-200 text-slate-700'">+ Add Semester</button>
                                        </div>
                                        
                                        <button @click="addCourseYear(section)" type="button" class="w-full py-2.5 border-2 border-dashed rounded-lg font-bold text-sm transition-colors mb-6" :class="isDarkMode ? 'border-indigo-500/50 text-indigo-300 hover:bg-indigo-500/20 bg-indigo-950/30' : 'border-[#3852a4]/40 text-[#3852a4] hover:bg-[#3852a4]/5'">+ Add Year</button>
                                        
                                        <!-- Course Notes Array -->
                                        <div class="border-t pt-4" :class="isDarkMode ? 'border-slate-800' : 'border-[#3852a4]/20'">
                                            <h5 class="text-xs font-black uppercase tracking-widest mb-3" :class="isDarkMode ? 'text-blue-400' : 'text-slate-500'">Course Notes (Optional)</h5>
                                            <div class="space-y-4">
                                                <div v-for="(note, nIdx) in section.courseNotes" :key="nIdx" class="relative group p-4 border rounded-xl" :class="isDarkMode ? 'border-slate-800 bg-[#090d16]' : 'border-slate-100 bg-white'">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div class="space-y-1">
                                                            <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-blue-400' : 'text-slate-400'">Note (EN)</label>
                                                            <div class="bg-white text-black rounded overflow-hidden">
                                                                <QuillEditor :key="`notes-en-${activeDeptMajorIndex}-${activeDeptProgramTab}-${idx}-${nIdx}`" theme="snow" v-model:content="note.en" contentType="html"></QuillEditor>
                                                            </div>
                                                        </div>
                                                        <div class="space-y-1">
                                                            <label class="block text-[10px] font-black uppercase tracking-widest" :class="isDarkMode ? 'text-emerald-400' : 'text-slate-400'">Note (KM)</label>
                                                            <div class="bg-white text-black rounded overflow-hidden">
                                                                <QuillEditor :key="`notes-km-${activeDeptMajorIndex}-${activeDeptProgramTab}-${idx}-${nIdx}`" theme="snow" v-model:content="note.km" contentType="html"></QuillEditor>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button @click="removeCourseNote(section, nIdx)" type="button" class="absolute -top-2 -right-2 bg-red-100 text-red-500 hover:bg-red-500 hover:text-white rounded-full p-1 shadow-sm opacity-0 group-hover:opacity-100 transition-all z-10" title="Remove Note">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <button @click="addCourseNote(section)" type="button" class="mt-4 text-xs font-bold px-3.5 py-2 rounded-lg transition-colors w-full md:w-auto" :class="isDarkMode ? 'bg-indigo-600 hover:bg-indigo-500 text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 text-slate-700'">+ Add Note</button>
                                        </div>
                                    </div>

                                    <!-- Custom Data Table Builder -->
                                    <div v-else-if="section.type === 'custom_table'" class="mt-4 p-4 rounded-xl border" :class="isDarkMode ? 'bg-[#121928] border-slate-700' : 'bg-indigo-50/30 border-indigo-200'">
                                        {{ ensureCustomTable(section) }}
                                        
                                        <!-- Header & Smart Paste Toolbar -->
                                        <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                                            <div>
                                                <h4 class="font-bold text-base" :class="isDarkMode ? 'text-white' : 'text-[#1c244b]'">Custom Data Table Builder</h4>
                                                <p class="text-xs" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Customize section badges, column headers, alignments, widths, and row values using Rich Text Editors.</p>
                                            </div>
                                            <div class="flex gap-2 flex-wrap">
                                                <button @click="openCustomTableSmartPaste(section)" type="button" class="px-3.5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white rounded-lg text-xs font-black shadow-md transition-all flex items-center gap-1.5">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                                    ✨ Smart Paste (Word/Excel)
                                                </button>
                                                <button @click="addCustomTableColumn(section)" type="button" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-colors">
                                                    + Add Column
                                                </button>
                                                <button @click="addCustomTableRow(section)" type="button" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-colors">
                                                    + Add Row
                                                </button>
                                                <button @click="removeCustomTable(section)" type="button" class="px-3 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1" title="Reset/Clear Table">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Clear Table
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Smart Paste Drawer -->
                                        <div v-if="activeCustomTableSmartPasteSection === section" class="mb-4 p-4 rounded-xl border border-purple-300 bg-purple-50 dark:bg-purple-900/20 dark:border-purple-800/60">
                                            <div class="flex justify-between items-center mb-2">
                                                <h5 class="text-xs font-bold text-purple-900 dark:text-purple-300">Paste Table Data from Word or Excel</h5>
                                                <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer text-purple-800 dark:text-purple-300">
                                                    <input type="checkbox" v-model="customTableSmartPasteHasHeader" class="rounded text-purple-600 focus:ring-purple-500" />
                                                    First row is Header
                                                </label>
                                            </div>
                                            <textarea v-model="customTableSmartPasteText" rows="5" class="w-full rounded-xl text-xs border border-purple-200 p-3 resize-y focus:outline-none focus:border-purple-500 dark:bg-[#0c101b] dark:border-purple-900/50 dark:text-slate-200" placeholder="Copy columns & rows from Excel or Word and paste here...&#10;Subject Name&#tHeader 2&#tHeader 3&#10;Mathematics for Economics&#t100&#tPass"></textarea>
                                            <div class="flex justify-end gap-2 mt-2">
                                                <button @click="activeCustomTableSmartPasteSection = null" type="button" class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 dark:text-slate-400 font-bold">Cancel</button>
                                                <button @click="executeCustomTableSmartPaste()" type="button" class="px-4 py-1.5 text-xs font-black bg-purple-600 text-white rounded-lg hover:bg-purple-700 shadow">🚀 Populate Table</button>
                                            </div>
                                        </div>

                                        <!-- Badge Title & Subtitle Options -->
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-3 rounded-xl border" :class="isDarkMode ? 'bg-[#0c101b] border-slate-800' : 'bg-white border-slate-200'">
                                            <div>
                                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1 flex items-center justify-between" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">
                                                    <span>Blue Pill Badge (Optional)</span>
                                                    <span class="inline-block rounded bg-[#3852a4] px-1.5 py-0.5 text-[9px] font-bold text-white">Preview</span>
                                                </label>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <input type="text" v-model="section.customTable.badge.en" placeholder="e.g. Basic Major Subjects (EN)" class="w-full text-xs rounded border px-2 py-1.5 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-slate-700 text-white focus:border-blue-400' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                    <input type="text" v-model="section.customTable.badge.km" placeholder="e.g. មុខវិជ្ជាគ្រឹះនៃឯកទេស (KM)" class="w-full text-xs rounded border px-2 py-1.5 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-slate-700 text-white focus:border-blue-400' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Subtitle Header (Optional)</label>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <input type="text" v-model="section.customTable.subtitle.en" placeholder="e.g. Overview (EN)" class="w-full text-xs rounded border px-2 py-1.5 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-slate-700 text-white focus:border-blue-400' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                    <input type="text" v-model="section.customTable.subtitle.km" placeholder="e.g. ព័ត៌មានទូទៅ (KM)" class="w-full text-xs rounded border px-2 py-1.5 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-slate-700 text-white focus:border-blue-400' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 pt-4">
                                                <label class="flex items-center gap-2 text-xs font-bold cursor-pointer" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">
                                                    <input type="checkbox" v-model="section.customTable.showRowNumbers" class="rounded text-blue-600 focus:ring-blue-500" />
                                                    Show Row Index Number (#)
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Bulk Alignment Controls (Quill-style Icon Buttons with Hover Tooltips) -->
                                        <div class="flex items-center gap-4 flex-wrap text-xs p-3 rounded-xl border mb-4" :class="isDarkMode ? 'bg-[#0c101b] border-slate-800 text-slate-300' : 'bg-slate-50 border-slate-200 text-slate-700'">
                                            <div class="flex items-center gap-2">
                                                <span class="font-black text-[10px] uppercase tracking-wider" :class="isDarkMode ? 'text-indigo-400' : 'text-[#1c244b]'">Headers Align:</span>
                                                <div class="inline-flex rounded-lg border border-slate-300 dark:border-slate-700 overflow-hidden bg-white dark:bg-[#090d16] p-0.5 shadow-sm">
                                                    <button @click="setAllHeaderAlign(section, 'left')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.headerAlign === 'left') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Headers Left">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h14"></path></svg>
                                                    </button>
                                                    <button @click="setAllHeaderAlign(section, 'center')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.headerAlign === 'center') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Headers Center">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M5 18h14"></path></svg>
                                                    </button>
                                                    <button @click="setAllHeaderAlign(section, 'right')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.headerAlign === 'right') ? 'bg-indigo-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Headers Right">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M6 18h14"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-black text-[10px] uppercase tracking-wider text-emerald-500">Body H-Align:</span>
                                                <div class="inline-flex rounded-lg border border-slate-300 dark:border-slate-700 overflow-hidden bg-white dark:bg-[#090d16] p-0.5 shadow-sm">
                                                    <button @click="setAllBodyAlign(section, 'left')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.bodyAlign === 'left') ? 'bg-emerald-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Body Left">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h14"></path></svg>
                                                    </button>
                                                    <button @click="setAllBodyAlign(section, 'center')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.bodyAlign === 'center') ? 'bg-emerald-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Body Center">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M5 18h14"></path></svg>
                                                    </button>
                                                    <button @click="setAllBodyAlign(section, 'right')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.bodyAlign === 'right') ? 'bg-emerald-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Body Right">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M6 18h14"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 ml-auto md:ml-2">
                                                <span class="font-black text-[10px] uppercase tracking-wider text-purple-400">Body V-Align:</span>
                                                <div class="inline-flex rounded-lg border border-slate-300 dark:border-slate-700 overflow-hidden bg-white dark:bg-[#090d16] p-0.5 shadow-sm">
                                                    <button @click="setAllVerticalAlign(section, 'top')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.verticalAlign === 'top') ? 'bg-purple-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Vertical Top">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M8 8v12M16 8v8"></path></svg>
                                                    </button>
                                                    <button @click="setAllVerticalAlign(section, 'middle')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.verticalAlign === 'middle') ? 'bg-purple-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Vertical Middle">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16M8 6v12M16 8v8"></path></svg>
                                                    </button>
                                                    <button @click="setAllVerticalAlign(section, 'bottom')" type="button" class="p-1 rounded transition-colors" :class="section.customTable.headers.every(h => h.verticalAlign === 'bottom') ? 'bg-purple-600 text-white' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'" title="Align All Vertical Bottom">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20h16M8 4v12M16 8v8"></path></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Custom Table Preview / Input Container -->
                                        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm mb-4 max-w-full" :class="isDarkMode ? 'bg-[#0c101b] border-slate-700' : ''">
                                            <table class="w-full text-left text-sm border-collapse min-w-[600px]">
                                                <thead class="bg-[#1c244b] text-white text-xs">
                                                    <tr>
                                                        <th v-if="section.customTable.showRowNumbers" class="px-2.5 py-2.5 min-w-[70px] w-20 text-center border-r border-slate-700">
                                                            <div class="space-y-1.5">
                                                                <span class="text-[10px] text-blue-300 font-black uppercase">Index Header</span>
                                                                <input type="text" v-model="section.customTable.indexHeader" placeholder="#" class="w-full text-xs px-2 py-1 bg-[#090d16] text-white text-center rounded border border-slate-700 focus:outline-none focus:border-blue-400 font-bold" />
                                                            </div>
                                                        </th>
                                                        <th v-for="(head, hIdx) in section.customTable.headers" :key="head.key" class="px-3 py-2.5 border-r border-slate-700 min-w-[200px] last:border-r-0">
                                                            <div class="space-y-1.5">
                                                                <div class="flex justify-between items-center">
                                                                    <span class="text-[10px] text-blue-300 font-black uppercase">Col {{ hIdx + 1 }}</span>
                                                                    <div class="flex items-center gap-1">
                                                                        <button v-if="hIdx > 0" @click="moveCustomTableColumn(section, hIdx, -1)" type="button" class="text-slate-300 hover:text-white text-xs px-1" title="Move Left">←</button>
                                                                        <button v-if="hIdx < section.customTable.headers.length - 1" @click="moveCustomTableColumn(section, hIdx, 1)" type="button" class="text-slate-300 hover:text-white text-xs px-1" title="Move Right">→</button>
                                                                        <button v-if="section.customTable.headers.length > 1" @click="removeCustomTableColumn(section, hIdx)" type="button" class="text-red-400 hover:text-red-200 text-xs font-bold px-1" title="Delete Column">✕</button>
                                                                    </div>
                                                                </div>
                                                                <input type="text" v-model="head.label.en" placeholder="Header (EN)" class="w-full text-xs px-2 py-1 bg-[#090d16] text-white rounded border border-slate-700 focus:outline-none focus:border-blue-400" />
                                                                <input type="text" v-model="head.label.km" placeholder="Header (KM)" class="w-full text-xs px-2 py-1 bg-[#090d16] text-white rounded border border-slate-700 focus:outline-none focus:border-blue-400" />
                                                                
                                                                <!-- Single Column Settings (Head Align, Body Align, Vertical Align) -->
                                                                <div class="space-y-1 pt-1 border-t border-slate-700/60 mt-1">
                                                                    <div class="flex items-center justify-between gap-1">
                                                                        <span class="text-[9px] text-blue-300 font-bold">Head:</span>
                                                                        <div class="inline-flex rounded border border-slate-700 bg-[#090d16] p-0.5">
                                                                            <button @click="head.headerAlign = 'left'" type="button" class="p-0.5 rounded transition-colors" :class="head.headerAlign === 'left' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Header Left">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h14"></path></svg>
                                                                            </button>
                                                                            <button @click="head.headerAlign = 'center'" type="button" class="p-0.5 rounded transition-colors" :class="head.headerAlign === 'center' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Header Center">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M5 18h14"></path></svg>
                                                                            </button>
                                                                            <button @click="head.headerAlign = 'right'" type="button" class="p-0.5 rounded transition-colors" :class="head.headerAlign === 'right' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Header Right">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M6 18h14"></path></svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="flex items-center justify-between gap-1">
                                                                        <span class="text-[9px] text-emerald-300 font-bold">Body H:</span>
                                                                        <div class="inline-flex rounded border border-slate-700 bg-[#090d16] p-0.5">
                                                                            <button @click="head.bodyAlign = 'left'" type="button" class="p-0.5 rounded transition-colors" :class="head.bodyAlign === 'left' ? 'bg-emerald-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Body Left">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h14"></path></svg>
                                                                            </button>
                                                                            <button @click="head.bodyAlign = 'center'" type="button" class="p-0.5 rounded transition-colors" :class="head.bodyAlign === 'center' ? 'bg-emerald-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Body Center">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M5 18h14"></path></svg>
                                                                            </button>
                                                                            <button @click="head.bodyAlign = 'right'" type="button" class="p-0.5 rounded transition-colors" :class="head.bodyAlign === 'right' ? 'bg-emerald-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Body Right">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M6 18h14"></path></svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="flex items-center justify-between gap-1">
                                                                        <span class="text-[9px] text-purple-300 font-bold">Body V:</span>
                                                                        <div class="inline-flex rounded border border-slate-700 bg-[#090d16] p-0.5">
                                                                            <button @click="head.verticalAlign = 'top'" type="button" class="p-0.5 rounded transition-colors" :class="head.verticalAlign === 'top' ? 'bg-purple-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Vertical Top">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M8 8v12M16 8v8"></path></svg>
                                                                            </button>
                                                                            <button @click="head.verticalAlign = 'middle'" type="button" class="p-0.5 rounded transition-colors" :class="head.verticalAlign === 'middle' ? 'bg-purple-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Vertical Middle">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16M8 6v12M16 8v8"></path></svg>
                                                                            </button>
                                                                            <button @click="head.verticalAlign = 'bottom'" type="button" class="p-0.5 rounded transition-colors" :class="head.verticalAlign === 'bottom' ? 'bg-purple-600 text-white' : 'text-slate-400 hover:text-white'" title="Align Vertical Bottom">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 20h16M8 4v12M16 8v8"></path></svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th class="px-2 py-2 w-14 text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-100" :class="isDarkMode ? 'divide-slate-800 bg-[#090d16]' : 'bg-white'">
                                                    <tr v-for="(row, rIdx) in section.customTable.rows" :key="rIdx" class="transition-colors" :class="isDarkMode ? 'hover:bg-slate-800/40 bg-[#0c101b]' : 'hover:bg-slate-50/50 bg-white'">
                                                        <td v-if="section.customTable.showRowNumbers" class="px-2 py-2 text-center text-xs font-black" :class="isDarkMode ? 'text-blue-400 border-r border-slate-800' : 'text-slate-600 border-r border-slate-100'">{{ rIdx + 1 }}</td>
                                                        <td v-for="head in section.customTable.headers" :key="head.key" class="px-2.5 py-3 border-r border-slate-100 min-w-[200px]" :class="isDarkMode ? 'border-slate-800' : ''">
                                                            <div class="space-y-3" v-if="row[head.key]">
                                                                <div class="space-y-3">
                                                                    <div>
                                                                        <label class="block text-[10px] font-black uppercase tracking-wider mb-1" :class="isDarkMode ? 'text-blue-400' : 'text-blue-600'">Content (EN)</label>
                                                                        <div class="bg-white text-black rounded-lg border overflow-hidden shadow-sm" :class="isDarkMode ? 'border-slate-700' : 'border-slate-300'">
                                                                            <QuillEditor 
                                                                                :key="`cell-en-${activeDeptMajorIndex}-${activeDeptProgramTab}-${idx}-${rIdx}-${head.key}`" 
                                                                                theme="snow" 
                                                                                v-model:content="row[head.key].en" 
                                                                                contentType="html"
                                                                                :toolbar="[['bold', 'italic', 'underline', 'link'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], [{ 'align': [] }], ['clean']]"
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <label class="block text-[10px] font-black uppercase tracking-wider mb-1" :class="isDarkMode ? 'text-emerald-400' : 'text-emerald-600'">Content (KM)</label>
                                                                        <div class="bg-white text-black rounded-lg border overflow-hidden shadow-sm" :class="isDarkMode ? 'border-slate-700' : 'border-slate-300'">
                                                                            <QuillEditor 
                                                                                :key="`cell-km-${activeDeptMajorIndex}-${activeDeptProgramTab}-${idx}-${rIdx}-${head.key}`" 
                                                                                theme="snow" 
                                                                                v-model:content="row[head.key].km" 
                                                                                contentType="html"
                                                                                :toolbar="[['bold', 'italic', 'underline', 'link'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], [{ 'align': [] }], ['clean']]"
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-2 py-2 text-center">
                                                            <div class="flex flex-col items-center justify-center gap-1.5">
                                                                <button @click="insertCustomTableRowAt(section, rIdx)" type="button" class="p-1 rounded bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-[10px] font-bold" title="Insert Row Above">+ Row</button>
                                                                <div class="flex items-center gap-1">
                                                                    <button v-if="rIdx > 0" @click="moveCustomTableRow(section, rIdx, -1)" type="button" class="text-slate-400 hover:text-slate-600 text-xs font-bold px-1" title="Move Row Up">↑</button>
                                                                    <button v-if="rIdx < section.customTable.rows.length - 1" @click="moveCustomTableRow(section, rIdx, 1)" type="button" class="text-slate-400 hover:text-slate-600 text-xs font-bold px-1" title="Move Row Down">↓</button>
                                                                </div>
                                                                <button v-if="section.customTable.rows.length > 1" @click="removeCustomTableRow(section, rIdx)" type="button" class="text-red-500 hover:text-red-700 text-xs font-bold px-1" title="Delete Row">✕</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Footer Note Option -->
                                        <div class="p-3 rounded-xl border" :class="isDarkMode ? 'bg-[#0c101b] border-slate-800' : 'bg-white border-slate-200'">
                                            <label class="block text-[10px] font-black uppercase tracking-widest mb-1" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'">Footer Note / Total Pill (Optional)</label>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                <input type="text" v-model="section.customTable.footerNote.en" placeholder="e.g. Note: All courses are compulsory (EN)" class="w-full text-xs rounded border px-2 py-1.5 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-slate-700 text-white focus:border-blue-400' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                                <input type="text" v-model="section.customTable.footerNote.km" placeholder="e.g. ចំណាំ៖ គ្រប់មុខវិជ្ជាទាំងអស់គឺតម្រូវឱ្យសិក្សា (KM)" class="w-full text-xs rounded border px-2 py-1.5 focus:outline-none" :class="isDarkMode ? 'bg-[#090d16] border-slate-700 text-white focus:border-blue-400' : 'bg-slate-50 border-slate-200 text-slate-900'" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" @click="addProgramSection(activeDeptMajorIndex, activeDeptProgramTab)" class="w-full py-4 border-2 border-dashed border-emerald-300 text-emerald-600 rounded-xl hover:bg-emerald-50 hover:border-emerald-400 font-bold text-sm transition-colors flex items-center justify-center gap-2" :class="isDarkMode ? 'border-emerald-500/30 text-emerald-400 hover:bg-emerald-500/10 hover:border-emerald-500/50' : ''">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> 
                                    Add New Program Section
                                </button>
                            </div>
                            </div>
                        </div>
                        
                        <div class="flex gap-3 mt-6">
                            <button type="submit" class="bg-[#10b981] hover:bg-emerald-700 text-white rounded-xl px-5 py-2.5 text-xs font-black shadow-lg shadow-emerald-500/10">Save Department</button>
                            <button 
                                type="button" 
                                @click="editingDept = null" 
                                class="rounded-xl px-4 py-2.5 text-xs font-bold border transition-colors"
                                :class="isDarkMode 
                                    ? 'bg-slate-800 border-slate-700 hover:bg-slate-700 text-slate-300' 
                                    : 'bg-slate-100 border-slate-200 hover:bg-slate-250 text-slate-700'"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- CUSTOM CONFIRM MODAL -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="confirmModal.show" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
                    <Transition
                        enter-active-class="transition ease-out duration-400 transform"
                        enter-from-class="opacity-0 scale-90 translate-y-8"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition ease-in duration-300 transform"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-90 translate-y-8"
                    >
                        <div v-if="confirmModal.show" class="relative overflow-hidden bg-white/90 dark:bg-[#0a0f1c]/90 backdrop-blur-2xl border border-white/20 dark:border-slate-800 rounded-[2rem] p-8 w-full max-w-sm shadow-[0_20px_60px_-15px_rgba(0,0,0,0.5)] transition-all pointer-events-auto">
                            <!-- Background glow effect -->
                            <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full blur-3xl opacity-20 pointer-events-none" :class="confirmModal.type === 'danger' ? 'bg-red-500' : 'bg-amber-500'"></div>
                            
                            <div class="relative z-10">
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-inner mx-auto transform transition-transform hover:scale-110 duration-300" 
                                     :class="confirmModal.type === 'danger' ? 'bg-gradient-to-br from-red-100 to-red-50 dark:from-red-500/20 dark:to-red-500/5 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20' : 'bg-gradient-to-br from-amber-100 to-amber-50 dark:from-amber-500/20 dark:to-amber-500/5 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20'">
                                    
                                    <svg v-if="confirmModal.type === 'danger'" class="w-8 h-8 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    
                                    <svg v-else class="w-8 h-8 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <h3 class="text-xl font-extrabold text-center mb-3 tracking-tight" :class="isDarkMode ? 'text-white' : 'text-slate-900'">{{ confirmModal.title }}</h3>
                                <p class="text-sm text-center mb-8 leading-relaxed font-medium" :class="isDarkMode ? 'text-slate-400' : 'text-slate-500'" v-html="confirmModal.message"></p>
                                <div class="flex gap-4">
                                    <button @click="confirmModal.show = false" type="button" class="flex-1 py-3.5 rounded-xl text-sm font-bold border-2 transition-all duration-300 hover:shadow-md" :class="isDarkMode ? 'border-slate-800 bg-slate-800/50 hover:bg-slate-700 text-slate-300 hover:text-white' : 'border-slate-200 bg-white hover:bg-slate-50 text-slate-700 hover:border-slate-300'">Cancel</button>
                                    
                                    <button @click="confirmModal.onConfirm" type="button" class="flex-1 py-3.5 rounded-xl text-sm font-black text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5" 
                                            :class="confirmModal.type === 'danger' ? 'bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 shadow-red-500/25' : 'bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 shadow-amber-500/25'">
                                        {{ confirmModal.confirmText }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </Transition>
                </div>
            </Transition>
        </Teleport>

        <!-- CUSTOM DYNAMIC TOAST NOTIFICATION -->
        <Transition
            enter-active-class="transform ease-out duration-300 transition"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div 
                v-if="toast.show" 
                class="fixed bottom-6 right-6 z-[99] flex items-center gap-3 px-5 py-4 rounded-2xl border shadow-2xl transition-all duration-300 max-w-sm pointer-events-auto"
                :class="isDarkMode ? 'bg-[#0f172a]/95 border-emerald-500/30 text-white' : 'bg-white border-slate-200 text-slate-900'"
            >
                <div class="w-6 h-6 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400 font-bold">
                    ✓
                </div>
                <div>
                    <p class="text-xs font-black tracking-wide leading-none mb-0.5">Notification</p>
                    <p class="text-[11px] opacity-75 font-semibold leading-tight">{{ toast.message }}</p>
                </div>
            </div>
        </Transition>

        <!-- Navigation Node Details Modal -->
        <Teleport to="body">
            <Transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95"
            >
                <div v-if="viewingNavItem" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                    <div 
                        class="relative w-full max-w-lg rounded-3xl p-6 sm:p-8 border shadow-2xl transition-all my-8 overflow-hidden"
                        :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] text-white' : 'bg-white border-slate-200 text-slate-900'"
                    >
                        <!-- Header -->
                        <div class="flex items-center justify-between border-b pb-4 mb-6" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-black leading-tight">Navigation Node Overview</h3>
                                    <span class="text-[11px] text-slate-400 font-medium">Link Parameters & Live Page Status</span>
                                </div>
                            </div>
                            <button @click="viewingNavItem = null" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                                ✕
                            </button>
                        </div>

                        <!-- Info Grid -->
                        <div class="space-y-4 text-xs">
                            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-widest block text-slate-400 mb-1">Title (English)</span>
                                    <span class="font-black text-sm" :class="isDarkMode ? 'text-slate-200' : 'text-slate-800'">{{ viewingNavItem.label?.en || 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-widest block text-slate-400 mb-1">Title (Khmer)</span>
                                    <span class="font-black text-sm" :class="isDarkMode ? 'text-slate-200' : 'text-slate-800'">{{ viewingNavItem.label?.km || 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-widest block text-slate-400 mb-1">Destination Href</span>
                                    <span class="font-mono text-xs font-bold text-indigo-500 block truncate">{{ viewingNavItem.href || '#' }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-widest block text-slate-400 mb-1">Hierarchy Position</span>
                                    <span class="font-bold">
                                        {{ !viewingNavItem.parent_id ? 'Level 1 (Top Level)' : (props.navigationItems.find(p => p.id === viewingNavItem.parent_id)?.parent_id ? 'Level 3 (Sub Link)' : 'Level 2 (Dropdown)') }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-widest block text-slate-400 mb-1">Sorting Index</span>
                                    <span class="font-mono font-bold">{{ viewingNavItem.order ?? 0 }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-widest block text-slate-400 mb-1">Parent Hierarchy</span>
                                    <span class="font-bold text-slate-400 truncate block">
                                        {{ viewingNavItem.parent_id ? getAdminLabel(props.navigationItems.find(p => p.id === viewingNavItem.parent_id)?.label) : 'None (Root Level)' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Associated Page Content Card -->
                            <div class="p-4 rounded-2xl border transition-all" :class="isDarkMode ? 'bg-indigo-950/20 border-indigo-900/30' : 'bg-indigo-50/50 border-indigo-100'">
                                <span class="text-[10px] font-black uppercase tracking-widest block text-indigo-400 mb-1">Target Page Status</span>
                                <div class="flex items-center justify-between mt-2 gap-3">
                                    <p class="font-bold text-xs" :class="isDarkMode ? 'text-slate-200' : 'text-slate-800'">
                                        {{ props.pageContents.find(p => p.slug === viewingNavItem.href?.replace(/^\//, '')) ? 'Matched to Editable CMS Page' : (viewingNavItem.href === '/faculties' || viewingNavItem.href?.startsWith('/department') ? 'Directs to Faculties & Academic Section' : 'Navigation Container or Custom Action Route') }}
                                    </p>
                                    <button type="button" @click="navigateToPageFromModal(viewingNavItem)" class="px-4 py-2 rounded-xl text-xs font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-md transition-all shrink-0 flex items-center gap-1">
                                        Open Destination ↗
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="mt-6 pt-4 border-t flex items-center justify-end gap-3" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <button @click="viewingNavItem = null" class="px-5 py-2.5 rounded-xl text-xs font-bold border hover:bg-slate-500/10 transition-colors" :class="isDarkMode ? 'border-slate-700 text-slate-300' : 'border-slate-200 text-slate-700'">
                                Close
                            </button>
                            <button @click="startEditNavItem(viewingNavItem); viewingNavItem = null;" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow-md transition-all flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Link Settings
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Event Overview Modal -->
        <Teleport to="body">
            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="viewingEvent" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto">
                    <div class="relative w-full max-w-2xl rounded-3xl p-6 sm:p-8 border shadow-2xl transition-all my-8 overflow-hidden" :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] text-white' : 'bg-white border-slate-200 text-slate-900'">
                        <div class="flex items-center justify-between border-b pb-4 mb-6" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white shadow-md shadow-pink-500/20 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-black leading-tight">News & Event Details</h3>
                                    <span class="text-[11px] text-slate-400 font-medium">Read-Only Article Preview</span>
                                </div>
                            </div>
                            <button @click="viewingEvent = null" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">✕</button>
                        </div>
                        <div class="space-y-4 text-xs max-h-[70vh] overflow-y-auto pr-2">
                            <div v-if="viewingEvent.image" class="w-full h-48 rounded-2xl overflow-hidden relative border" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                                <img :src="viewingEvent.image" class="w-full h-full object-cover" />
                            </div>
                            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <div><span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Title (EN)</span><span class="font-extrabold text-sm">{{ getAdminLabel(viewingEvent.title) }}</span></div>
                                <div><span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Category & Date</span><span class="font-bold">{{ viewingEvent.type }} | {{ viewingEvent.date }}</span></div>
                            </div>
                            <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Abstract Description</span>
                                <p class="text-xs leading-relaxed" :class="isDarkMode ? 'text-slate-300' : 'text-slate-700'">{{ getAdminLabel(viewingEvent.description) }}</p>
                            </div>
                            <div v-if="viewingEvent.content" class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-2">Full Article Body</span>
                                <div class="prose dark:prose-invert text-xs leading-relaxed max-h-60 overflow-y-auto" v-html="getAdminLabel(viewingEvent.content)"></div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t flex items-center justify-between" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <a :href="`/events/${viewingEvent.id}`" target="_blank" class="text-xs font-bold text-indigo-500 hover:underline">Live Preview Page ↗</a>
                            <div class="flex items-center gap-3">
                                <button @click="viewingEvent = null" class="px-5 py-2.5 rounded-xl text-xs font-bold border" :class="isDarkMode ? 'border-slate-700 text-slate-300' : 'border-slate-200 text-slate-700'">Close</button>
                                <button @click="startEditEvent(viewingEvent); viewingEvent = null;" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700">Edit Article</button>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Faculty Details Modal -->
        <Teleport to="body">
            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="viewingFaculty" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                    <div class="relative w-full max-w-lg rounded-3xl p-6 sm:p-8 border shadow-2xl transition-all my-8 overflow-hidden" :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] text-white' : 'bg-white border-slate-200 text-slate-900'">
                        <div class="flex items-center justify-between border-b pb-4 mb-6" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-black leading-tight">Faculty Branch Details</h3>
                                    <span class="text-[11px] text-slate-400 font-medium">Read-Only Overview</span>
                                </div>
                            </div>
                            <button @click="viewingFaculty = null" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">✕</button>
                        </div>
                        <div class="space-y-4 text-xs">
                            <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Faculty Name</span>
                                <span class="font-extrabold text-base text-emerald-500">{{ getAdminLabel(viewingFaculty.name) }}</span>
                            </div>
                            <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-2">Associated Departments ({{ viewingFaculty.departments?.length || 0 }})</span>
                                <div class="space-y-1.5">
                                    <div v-for="d in viewingFaculty.departments" :key="d.id" class="flex items-center justify-between p-2 rounded-xl border text-xs" :class="isDarkMode ? 'bg-[#0f1524] border-slate-800' : 'bg-white border-slate-200'">
                                        <span class="font-bold">{{ getAdminLabel(d.name) }}</span>
                                        <span class="font-mono text-[10px] text-slate-400">/{{ d.slug }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t flex items-center justify-between" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <a href="/faculties" target="_blank" class="text-xs font-bold text-emerald-500 hover:underline">Live Faculties Page ↗</a>
                            <div class="flex items-center gap-3">
                                <button @click="viewingFaculty = null" class="px-5 py-2.5 rounded-xl text-xs font-bold border" :class="isDarkMode ? 'border-slate-700 text-slate-300' : 'border-slate-200 text-slate-700'">Close</button>
                                <button @click="startEditFaculty(viewingFaculty); viewingFaculty = null;" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700">Edit Faculty</button>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Department Details Modal -->
        <Teleport to="body">
            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="viewingDept" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto">
                    <div class="relative w-full max-w-xl rounded-3xl p-6 sm:p-8 border shadow-2xl transition-all my-8 overflow-hidden" :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] text-white' : 'bg-white border-slate-200 text-slate-900'">
                        <div class="flex items-center justify-between border-b pb-4 mb-6" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-black leading-tight">Academic Department Details</h3>
                                    <span class="text-[11px] text-slate-400 font-medium">Curriculum & Majors Preview</span>
                                </div>
                            </div>
                            <button @click="viewingDept = null" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">✕</button>
                        </div>
                        <div class="space-y-4 text-xs max-h-[70vh] overflow-y-auto pr-2">
                            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <div><span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Department Name</span><span class="font-extrabold text-sm text-indigo-500">{{ getAdminLabel(viewingDept.name) }}</span></div>
                                <div><span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Route Path</span><span class="font-mono text-xs font-bold">/{{ viewingDept.slug }}</span></div>
                            </div>
                            <div v-if="viewingDept.description" class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Overview Description</span>
                                <div class="text-xs leading-relaxed" v-html="getAdminLabel(viewingDept.description)"></div>
                            </div>
                            <div v-if="viewingDept.mission" class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Mission Statement</span>
                                <div class="text-xs leading-relaxed" v-html="getAdminLabel(viewingDept.mission)"></div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t flex items-center justify-between" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <a :href="`/department/${viewingDept.slug}`" target="_blank" class="text-xs font-bold text-blue-500 hover:underline">Live Department Page ↗</a>
                            <div class="flex items-center gap-3">
                                <button @click="viewingDept = null" class="px-5 py-2.5 rounded-xl text-xs font-bold border" :class="isDarkMode ? 'border-slate-700 text-slate-300' : 'border-slate-200 text-slate-700'">Close</button>
                                <button @click="startEditDept(viewingDept); viewingDept = null;" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-blue-600 text-white hover:bg-blue-700">Edit Department</button>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Translation Details Modal -->
        <Teleport to="body">
            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="viewingTranslation" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                    <div class="relative w-full max-w-lg rounded-3xl p-6 sm:p-8 border shadow-2xl transition-all my-8 overflow-hidden" :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] text-white' : 'bg-white border-slate-200 text-slate-900'">
                        <div class="flex items-center justify-between border-b pb-4 mb-6" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 7.31 16.5 1 18"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-black leading-tight">Translation Key Overview</h3>
                                    <span class="text-[11px] text-slate-400 font-medium">Bilingual Site Dictionary Pair</span>
                                </div>
                            </div>
                            <button @click="viewingTranslation = null" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">✕</button>
                        </div>
                        <div class="space-y-4 text-xs">
                            <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Translation Key Identifier</span>
                                <span class="font-mono font-bold text-sm text-indigo-500">{{ viewingTranslation.key }}</span>
                            </div>
                            <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">English Value (EN)</span>
                                <p class="text-sm font-semibold leading-relaxed" :class="isDarkMode ? 'text-slate-200' : 'text-slate-800'">{{ viewingTranslation.en || 'N/A' }}</p>
                            </div>
                            <div class="p-4 rounded-2xl border" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <span class="text-[10px] font-black uppercase text-slate-400 block mb-1">Khmer Translation (KM)</span>
                                <p class="text-sm font-semibold leading-relaxed text-emerald-500">{{ viewingTranslation.km || 'No Khmer Translation Registered' }}</p>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t flex items-center justify-end gap-3" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <button @click="viewingTranslation = null" class="px-5 py-2.5 rounded-xl text-xs font-bold border" :class="isDarkMode ? 'border-slate-700 text-slate-300' : 'border-slate-200 text-slate-700'">Close</button>
                            <button @click="startEditTranslation(viewingTranslation); viewingTranslation = null;" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700">Edit Translation</button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- Full System Activity Log Modal -->
        <Teleport to="body">
            <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <div v-if="showFullLogsModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm overflow-y-auto">
                    <div class="relative w-full max-w-2xl rounded-3xl p-6 sm:p-8 border shadow-2xl transition-all my-8 overflow-hidden" :class="isDarkMode ? 'bg-[#0c101b] border-[#1a2333] text-white' : 'bg-white border-slate-200 text-slate-900'">
                        <div class="flex items-center justify-between border-b pb-4 mb-6" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/20 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-black leading-tight">System Activity Audit Log</h3>
                                    <span class="text-[11px] text-slate-400 font-medium">Recorded Admin Modifications</span>
                                </div>
                            </div>
                            <button @click="showFullLogsModal = false" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">✕</button>
                        </div>
                        
                        <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-2">
                            <div v-for="log in props.activityLogs" :key="log.id" class="p-3.5 rounded-2xl border flex items-center gap-3 transition-colors" :class="isDarkMode ? 'bg-[#090d16] border-[#1a2333]' : 'bg-slate-50 border-slate-100'">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" :class="log.iconClass">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold leading-snug truncate" :class="isDarkMode ? 'text-slate-200' : 'text-slate-800'">{{ log.title }}</p>
                                    <div class="flex items-center gap-3 mt-0.5 text-[10px] text-slate-400">
                                        <span>User: <strong class="text-slate-300">{{ log.user }}</strong></span>
                                        <span>•</span>
                                        <span>Module: <strong class="uppercase font-mono text-indigo-400">{{ log.module }}</strong></span>
                                        <span>•</span>
                                        <span>{{ log.date_full }} ({{ log.time }})</span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="!props.activityLogs || props.activityLogs.length === 0" class="py-12 text-center text-xs text-slate-400">
                                No activity logs stored.
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t flex items-center justify-end" :class="isDarkMode ? 'border-slate-800' : 'border-slate-100'">
                            <button @click="showFullLogsModal = false" class="px-5 py-2.5 rounded-xl text-xs font-bold border" :class="isDarkMode ? 'border-slate-700 text-slate-300' : 'border-slate-200 text-slate-700'">Close Audit Report</button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- IMAGE PREVIEW LIGHTBOX MODAL -->
        <Teleport to="body">
            <Transition name="fade">
                <div v-if="previewImageModal.show" class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" @click.self="previewImageModal.show = false">
                    <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center justify-center p-2">
                        <button 
                            @click="previewImageModal.show = false" 
                            type="button"
                            class="absolute -top-12 right-0 p-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition-all border border-white/20 cursor-pointer shadow-lg flex items-center gap-1.5 text-xs font-black"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Close
                        </button>
                        <div class="overflow-hidden rounded-2xl border border-white/20 shadow-2xl bg-black/40 flex items-center justify-center p-2">
                            <img :src="previewImageModal.url" alt="Full Image Preview" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl" />
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

    </div>
</template>

<style>
/* Smooth fade-in transition for tabs */
.animate-fadeIn {
    animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
