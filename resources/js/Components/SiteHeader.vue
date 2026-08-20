<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

// NEW: Shrink and auto-hide on scroll state
const isScrolled = ref(false);
const handleScroll = () => {
    const currentScrollY = window.scrollY;
    
    // Shrink header on scroll down > 50px
    if (currentScrollY > 50) {
        isScrolled.value = true;
    } else {
        isScrolled.value = false;
    }
};

// State for Mobile Menu
const isMobileMenuOpen = ref(false);
const toggleMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const handleResize = () => {
    if (window.innerWidth >= 1024 && isMobileMenuOpen.value) {
        isMobileMenuOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener('resize', handleResize);
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Touch
    window.addEventListener('touchstart', handleDragStart, { passive: true });
    window.addEventListener('touchmove', handleDragMove, { passive: false });
    window.addEventListener('touchend', handleDragEnd, { passive: true });
    
    // Mouse
    window.addEventListener('mousedown', handleDragStart, { passive: true });
    window.addEventListener('mousemove', handleDragMove, { passive: false });
    window.addEventListener('mouseup', handleDragEnd, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    window.removeEventListener('scroll', handleScroll);
    
    window.removeEventListener('touchstart', handleDragStart);
    window.removeEventListener('touchmove', handleDragMove);
    window.removeEventListener('touchend', handleDragEnd);
    
    window.removeEventListener('mousedown', handleDragStart);
    window.removeEventListener('mousemove', handleDragMove);
    window.removeEventListener('mouseup', handleDragEnd);
});



// Swipe & Drag logic to open/close menu
const isDragging = ref(false);
const dragStartX = ref(0);
const dragStartY = ref(0);
const dragCurrentX = ref(0);
const isOpening = ref(false);
let isScrollIntent = null;

const handleDragStart = (e) => {
    if (window.innerWidth >= 1024) return;
    
    const isMouse = e.type.includes('mouse');
    const startX = isMouse ? e.clientX : e.touches[0].clientX;
    const startY = isMouse ? e.clientY : e.touches[0].clientY;
    
    isScrollIntent = null;

    if (!isMobileMenuOpen.value && startX < 40) {
        isDragging.value = true;
        isOpening.value = true;
        dragStartX.value = startX;
        dragStartY.value = startY;
        dragCurrentX.value = startX;
    } else if (isMobileMenuOpen.value) {
        isDragging.value = true;
        isOpening.value = false;
        dragStartX.value = startX;
        dragStartY.value = startY;
        dragCurrentX.value = startX;
    }
};

const handleDragMove = (e) => {
    if (!isDragging.value) return;
    
    const isMouse = e.type.includes('mouse');
    const currentX = isMouse ? e.clientX : e.touches[0].clientX;
    const currentY = isMouse ? e.clientY : e.touches[0].clientY;
    
    if (isScrollIntent === null) {
        const deltaX = Math.abs(currentX - dragStartX.value);
        const deltaY = Math.abs(currentY - dragStartY.value);
        if (deltaX > 5 || deltaY > 5) {
            isScrollIntent = deltaY > deltaX;
        }
    }

    if (isScrollIntent === true) {
        isDragging.value = false;
        return;
    }
    
    if (isScrollIntent === false && e.cancelable) {
        e.preventDefault();
    }
    
    dragCurrentX.value = currentX;
};

const handleDragEnd = () => {
    if (!isDragging.value) return;
    isDragging.value = false;

    if (isScrollIntent === true) return;

    if (isOpening.value) {
        if (dragCurrentX.value > dragStartX.value + 60) {
            isMobileMenuOpen.value = true;
        } else {
            isMobileMenuOpen.value = false;
        }
    } else {
        if (dragStartX.value > dragCurrentX.value + 60) {
            isMobileMenuOpen.value = false;
        } else {
            isMobileMenuOpen.value = true;
        }
    }
};

const dragStyle = computed(() => {
    if (!isDragging.value) return {};
    
    if (isOpening.value) {
        return { transform: `translateX(min(calc(-100% + ${dragCurrentX.value}px), 0px))` };
    } else {
        const delta = Math.min(0, dragCurrentX.value - dragStartX.value);
        return { transform: `translateX(${delta}px)` };
    }
});

const overlayStyle = computed(() => {
    if (!isDragging.value) return {};
    
    if (isOpening.value) {
        const opacity = Math.min(1, dragCurrentX.value / 300);
        return { opacity: opacity };
    } else {
        const delta = Math.abs(Math.min(0, dragCurrentX.value - dragStartX.value));
        const opacity = Math.max(0, 1 - (delta / 300));
        return { opacity: opacity };
    }
});

watch(isMobileMenuOpen, (isOpen) => {
    if (isOpen) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
});

// State for Mobile Accordion
const expandedMobileMenus = ref([]); 
const toggleMobileMenu = (label) => {
    if (expandedMobileMenus.value.includes(label)) {
         expandedMobileMenus.value = expandedMobileMenus.value.filter(item => item !== label);
    } else {
         expandedMobileMenus.value.push(label);
    }
};

const openMegaMenu = ref(null);
const activeMegaMenuTabs = ref({});

const isCatActive = (cat) => {
    if (isActive(cat.href)) return true;
    if (cat.links) {
        return cat.links.some(link => isActive(link.href));
    }
    return false;
};

const isItemActive = (item) => {
    if (isActive(item.href)) return true;
    if (item.megaMenu) {
        return item.megaMenu.some(cat => isCatActive(cat));
    }
    return false;
};

// Automatically set the first item with sub-links as the active tab when opening a mega menu
const resetActiveTab = (item) => {
    if (!item.megaMenu) return;
    
    // Open to the active category if one exists
    const activeCat = item.megaMenu.find(cat => isCatActive(cat));
    if (activeCat) {
        if (activeCat.links && activeCat.links.length > 0) {
            activeMegaMenuTabs.value[item.label] = activeCat.title;
        } else {
            activeMegaMenuTabs.value[item.label] = null;
        }
        return;
    }
    
    // Fallback to first tab with links
    const firstTabWithLinks = item.megaMenu.find(cat => cat.links && cat.links.length > 0);
    activeMegaMenuTabs.value[item.label] = firstTabWithLinks ? firstTabWithLinks.title : null;
};

const getActiveLinks = (menuLabel) => {
    const item = navItems.value.find(i => i.label === menuLabel);
    if (!item || !item.megaMenu) return [];
    
    const activeTabTitle = activeMegaMenuTabs.value[menuLabel];
    if (!activeTabTitle) return []; 

    const tabData = item.megaMenu.find(tab => tab.title === activeTabTitle);
    return tabData ? tabData.links : [];
};

const page = usePage();

const headerBgColor = computed(() => '#ebf4f6');
const headerTextColor = computed(() => '#115D6D');
const navBgColor = computed(() => '#0d4a57');
const navTextColor = computed(() => '#ffffff');
const navActiveColor = computed(() => '#ffb800');

const isActive = (href) => {
    if (!href || href === '#') return false;
    
    const currentUrl = String(page.url || '');
    const targetHref = String(href);
    
    let currentPath = currentUrl.split('?')[0].trim().toLowerCase();
    if (!currentPath.startsWith('/')) currentPath = '/' + currentPath;
    if (currentPath.length > 1 && currentPath.endsWith('/')) {
        currentPath = currentPath.slice(0, -1);
    }
    
    let linkPath = targetHref.split('?')[0].trim().toLowerCase();
    if (!linkPath.startsWith('/')) linkPath = '/' + linkPath;
    if (linkPath.length > 1 && linkPath.endsWith('/')) {
        linkPath = linkPath.slice(0, -1);
    }
    
    if (linkPath === '/') return currentPath === '/';
    
    return currentPath === linkPath || currentPath.startsWith(linkPath + '/');
};

const socialLinks = computed(() => {
    const links = page.props.settings?.social_links || [];
    return links.map(link => {
        let customStyle = {};
        let classes = [];
        if (link.class) {
            const parts = link.class.split(' ');
            
            const getColor = (val) => {
                if (val.startsWith('[') && val.endsWith(']')) return val.slice(1, -1);
                if (val === 'black') return '#000000';
                if (val === 'white') return '#ffffff';
                if (val === 'transparent') return 'transparent';
                return val;
            };

            parts.forEach(part => {
                if (part.startsWith('hover:bg-')) {
                    if (!link.disable_bg_hover) {
                        customStyle['--custom-hover-bg'] = getColor(part.replace('hover:bg-', ''));
                        classes.push('has-custom-hover-bg');
                    }
                } else if (part.startsWith('bg-') && part.includes('[')) {
                    customStyle['--custom-bg'] = getColor(part.replace('bg-', ''));
                    classes.push('has-custom-bg');
                } else if (part.startsWith('hover:text-')) {
                    if (!link.disable_icon_hover) {
                        customStyle['--custom-hover-text'] = getColor(part.replace('hover:text-', ''));
                        classes.push('has-custom-hover-text');
                    }
                } else if (part.startsWith('text-') && part.includes('[')) {
                    customStyle['--custom-text'] = getColor(part.replace('text-', ''));
                    classes.push('has-custom-text');
                } else {
                    classes.push(part);
                }
            });
        }
        
        if (link.bg_color && link.bg_color !== '') {
            customStyle['--custom-bg'] = link.bg_color;
            if (!classes.includes('has-custom-bg')) classes.push('has-custom-bg');
        }
        if (!link.disable_bg_hover && link.hover_color && link.hover_color !== '') {
            customStyle['--custom-hover-bg'] = link.hover_color;
            if (!classes.includes('has-custom-hover-bg')) classes.push('has-custom-hover-bg');
        }
        if (link.icon_color && link.icon_color !== '') {
            customStyle['--custom-text'] = link.icon_color;
            if (!classes.includes('has-custom-text')) classes.push('has-custom-text');
        }
        if (!link.disable_icon_hover && link.icon_hover_color && link.icon_hover_color !== '') {
            customStyle['--custom-hover-text'] = link.icon_hover_color;
            if (!classes.includes('has-custom-hover-text')) classes.push('has-custom-hover-text');
        }

        return { ...link, customStyle, processedClass: classes.join(' ') };
    });
});

const rawNavigation = computed(() => {
    return page.props.navigation || [];
});

const isOffice = (label, href) => {
    const l = (typeof label === 'object' ? (label.en || label.km || '') : String(label || '')).toLowerCase();
    const h = String(href || '').toLowerCase();
    return l.includes('office') || h.includes('/office');
};

const navItems = computed(() => {
    const items = rawNavigation.value
        .filter(item => !isOffice(item.label, item.href))
        .map((item) => {
            const hasMenu = item.children && item.children.length > 0;
            const megaMenu = hasMenu ? item.children
                .filter(cat => !isOffice(cat.label, cat.href))
                .map(cat => {
                    const hasLinks = cat.children && cat.children.length > 0;
                    const links = hasLinks ? cat.children
                        .filter(lnk => !isOffice(lnk.label, lnk.href))
                        .map(lnk => ({
                            id: lnk.id,
                            label: lnk.label,
                            href: lnk.href || '#'
                        })) : [];
                    return {
                        id: cat.id,
                        title: cat.label,
                        href: cat.href || '#',
                        links: links
                    };
                }).filter(cat => cat.links.length > 0 || cat.href !== '#') : null;

            return {
                id: item.id,
                label: item.label,
                href: item.href || '#',
                icon: item.icon || '',
                hasMenu: megaMenu && megaMenu.length > 0,
                megaMenu: megaMenu
            };
        });

    const scholarshipItem = {
        id: 'scholarship-nav-item',
        label: { en: 'Scholarship', km: 'អាហារូបករណ៍' },
        href: '/#scholarship',
        icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>',
        hasMenu: false,
        megaMenu: null
    };

    const videoItem = {
        id: 'video-nav-item',
        label: { en: 'Video', km: 'វីដេអូ' },
        href: '/#video',
        icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>',
        hasMenu: false,
        megaMenu: null
    };

    const hasScholarship = items.some(it => {
        const l = (typeof it.label === 'object' ? (it.label.en || it.label.km || '') : String(it.label)).toLowerCase();
        return l.includes('scholarship');
    });

    const hasVideo = items.some(it => {
        const l = (typeof it.label === 'object' ? (it.label.en || it.label.km || '') : String(it.label)).toLowerCase();
        return l.includes('video');
    });

    if (!hasScholarship) {
        const facIndex = items.findIndex(it => {
            const l = (typeof it.label === 'object' ? (it.label.en || it.label.km || '') : String(it.label)).toLowerCase();
            return l.includes('faculty') || l.includes('faculties');
        });
        if (facIndex !== -1) {
            items.splice(facIndex + 1, 0, scholarshipItem);
        } else {
            items.push(scholarshipItem);
        }
    }

    if (!hasVideo) {
        const contactIndex = items.findIndex(it => {
            const l = (typeof it.label === 'object' ? (it.label.en || it.label.km || '') : String(it.label)).toLowerCase();
            return l.includes('contact');
        });
        if (contactIndex !== -1) {
            items.splice(contactIndex, 0, videoItem);
        } else {
            items.push(videoItem);
        }
    }

    // Deduplicate top-level items strictly by label content and href
    const seen = new Set();
    return items.filter(item => {
        const labelStr = typeof item.label === 'object' 
            ? (item.label.en || item.label.km || JSON.stringify(item.label)) 
            : String(item.label || '');
        const key = `${labelStr.trim().toLowerCase()}_${(item.href || '#').trim().toLowerCase()}`;
        if (seen.has(key)) return false;
        seen.add(key);
        return true;
    });
});
</script>

<template>
    <div class="relative w-full">
        <!-- Spacer to prevent content jump on scroll -->
        <div class="w-full h-[75px] sm:h-[90px] md:h-[95px] lg:h-[166px]"></div>

        <header class="font-sans fixed w-full left-0 top-0 z-50 transition-all duration-500 pt-3.5 pb-0" :style="{ backgroundColor: headerBgColor || '#115D6D', color: headerTextColor || '#ffffff' }">
        
        <div class="mx-auto flex max-w-[1400px] items-center justify-between gap-4 px-6 pb-3 transition-all duration-300">
            
            <Link href="/" class="flex items-center z-50">
                <img src="./path/to/duc-logo.png" alt="DUC Logo" 
                     class="w-auto object-contain drop-shadow-md transition-all duration-300"
                     :class="isScrolled ? 'h-[48px] sm:h-[62px] md:h-[72px]' : 'h-[48px] sm:h-[68px] md:h-[76px] lg:h-[92px]'" />
                
                <div class="flex flex-col justify-center drop-shadow-md transition-all duration-300">
                    <h1 class="leading-none tracking-wide transition-all duration-300" 
                        :style="{ color: '#115D6D', fontFamily: '\'Moul\', \'Khmer OS Moul\', serif' }"
                        :class="isScrolled ? 'text-[13px] sm:text-[18px] md:text-[20px] lg:text-[22px]' : 'text-[13px] sm:text-[20px] md:text-[20px] lg:text-[26px]'">
                        សាកលវិទ្យាល័យឌីជីថលកម្ពុជា
                    </h1>
                    <h2 class="mt-1 font-[900] leading-none tracking-[0.03em] transition-all duration-300" 
                        :style="{ color: '#AF8319', fontFamily: '\'Old English Text MT\', \'UnifrakturMaguntia\', serif' }"
                        :class="isScrolled ? 'text-[14px] sm:text-[20px] md:text-[22px] lg:text-[25px]' : 'text-[14px] sm:text-[22px] md:text-[22px] lg:text-[29px]'">
                        Digital University of Cambodia
                    </h2>
                </div>
            </Link>

            <div class="hidden shrink-0 items-center gap-3 lg:flex">
                <div class="flex items-center gap-2 mr-2">
                        <a v-for="item in socialLinks" :key="item.label" :href="item.href" target="_blank" rel="noopener noreferrer" :aria-label="item.label" class="flex h-8 w-8 items-center justify-center rounded-full bg-[#e3e5e8] text-gray-700 transition-colors shadow-sm hover:shadow-md hover:scale-110" :class="item.processedClass ? item.processedClass.replace('bg-white/10', '') : ''" :style="item.customStyle">
                            <span class="flex items-center justify-center" v-html="item.svg"></span>
                        </a>
                </div>
                <div class="flex items-center bg-[#f1f3f5] p-1 rounded-full shadow-inner border border-gray-200/60">
                    <a href="/lang/km" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300" :class="page.props.locale === 'km' ? 'bg-white text-blue-700 shadow-sm ring-1 ring-gray-900/5' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-200/50'">
                        <img src="https://flagcdn.com/w40/kh.png" alt="Khmer" class="w-5 h-5 rounded-full object-cover shadow-sm" /> 
                        <span :class="page.props.locale === 'km' ? 'font-bold' : ''">KH</span>
                    </a>
                    <a href="/lang/en" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300" :class="page.props.locale === 'en' ? 'bg-white text-blue-700 shadow-sm ring-1 ring-gray-900/5' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-200/50'">
                        <img src="https://flagcdn.com/w40/us.png" alt="English" class="w-5 h-5 rounded-full object-cover shadow-sm" /> 
                        <span :class="page.props.locale === 'en' ? 'font-bold' : ''">EN</span>
                    </a>
                </div>
            </div>

            <button @click="toggleMenu" class="lg:hidden flex items-center justify-center rounded-md p-2 hover:bg-black/10 transition-colors z-50" :style="{ color: headerTextColor }">
                <span class="sr-only">Toggle main menu</span>
                <svg class="block h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
        </div>

        <nav class="hidden lg:block transition-colors duration-500 bg-[#0d4a57] border-t border-white/15 relative" :style="{ backgroundColor: navBgColor || '#0d4a57' }">
            <div class="mx-auto flex max-w-[1400px] flex-wrap items-center gap-x-10 px-6 h-[60px]">
                
                <div 
                    v-for="(item, index) in navItems" 
                    :key="item.id || index" 
                    class="h-full relative"
                    @mouseenter="item.megaMenu && (openMegaMenu = item.label, resetActiveTab(item))"
                    @mouseleave="item.megaMenu && (openMegaMenu = null)"
                >
                    <Link :href="item.href" class="group relative flex h-full items-center gap-2 text-[13px] uppercase tracking-wide font-semibold transition-all cursor-pointer antialiased"
                          :style="{ color: navTextColor }"
                          :class="isItemActive(item) ? 'opacity-100' : 'opacity-90 hover:opacity-100'">
                        <span class="flex items-center justify-center transition-transform group-hover:-translate-y-0.5 [&>svg]:w-4 [&>svg]:h-4 [&>svg]:stroke-[1.5px]" v-html="item.icon"></span>
                        <span class="transition-transform group-hover:-translate-y-0.5 mt-0.5">{{ $t(item.label) }}</span>
                        <svg v-if="item.hasMenu" class="w-3.5 h-3.5 ml-0.5 mt-0.5 transition-transform group-hover:-translate-y-0.5" :class="{ 'translate-y-0.5': openMegaMenu === item.label }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        
                        <!-- Animated Underline (Contained cleanly inside nav bar) -->
                        <span class="absolute bottom-[3px] left-0 h-[3px] rounded-full transition-all duration-300"
                              :style="{ backgroundColor: navActiveColor }"
                              :class="isItemActive(item) ? 'w-full opacity-100' : 'w-0 opacity-0 group-hover:w-full group-hover:opacity-100'">
                        </span>
                    </Link>

                    <div 
                        v-if="item.megaMenu && openMegaMenu === item.label" 
                        class="absolute left-0 top-full flex bg-white shadow-2xl border-t border-gray-100 p-8 rounded-b-md"
                        :class="activeMegaMenuTabs[item.label] ? 'w-[900px]' : 'w-max min-w-[300px]'"
                    >
                        
                        <div class="flex flex-col gap-1" :class="activeMegaMenuTabs[item.label] ? 'w-[45%] pr-6' : 'w-full'">
                            <template v-for="cat in item.megaMenu" :key="cat.id">
                                <Link 
                                    v-if="!cat.links || cat.links.length === 0"
                                    :href="cat.href"
                                    @mouseenter="activeMegaMenuTabs[item.label] = null"
                                    class="text-left px-4 py-3 rounded-r-md transition-all duration-200 outline-none flex items-center justify-between group/btn"
                                    :class="(isCatActive(cat) && !activeMegaMenuTabs[item.label])
                                        ? 'bg-[#f4f7fb] text-[#b38b1d] font-extrabold border-l-4 border-[#b38b1d]'
                                        : 'text-[#1c244b] font-bold border-l-4 border-transparent hover:bg-gray-50 hover:text-[#3852a4]'"
                                >
                                    {{ $t(cat.title) }}
                                </Link>

                                <Link 
                                    v-else
                                    :href="cat.href"
                                    @mouseenter="activeMegaMenuTabs[item.label] = cat.title"
                                    class="text-left px-4 py-3 rounded-r-md transition-all duration-200 outline-none flex items-center justify-between group/btn"
                                    :class="(activeMegaMenuTabs[item.label] === cat.title)
                                        ? 'bg-[#f4f7fb] text-[#b38b1d] font-extrabold border-l-4 border-[#b38b1d]'
                                        : 'text-[#1c244b] font-bold border-l-4 border-transparent hover:bg-gray-50 hover:text-[#3852a4]'"
                                >
                                    <span class="text-[16px]">{{ $t(cat.title) }}</span>

                                    <svg
                                        class="w-4 h-4 transition-all duration-300 transform -translate-x-2 group-hover/btn:translate-x-0"
                                        :class="activeMegaMenuTabs[item.label] === cat.title ? 'opacity-100 translate-x-0' : 'opacity-0'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </Link>
                            </template>
                        </div>

                        <template v-if="activeMegaMenuTabs[item.label]">
                            <div class="w-[1px] bg-gray-200 mx-4"></div>

                            <div class="w-[55%] flex flex-col gap-4 pl-6 py-2">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 border-b border-gray-100 pb-2">
                                    {{ $t(activeMegaMenuTabs[item.label]) }}
                                </h3>
                                
                                <Link 
                                    v-for="link in getActiveLinks(item.label)" 
                                    :key="link.label"
                                    :href="link.href"
                                    class="group/link flex items-center text-[15px] transition-colors"
                                    :class="isActive(link.href) ? 'text-[#b38b1d] font-extrabold' : 'text-[#1c244b] font-bold hover:text-[#0056b3]'"
                                >
                                    <svg class="w-4 h-4 mr-2 transition-all duration-300 transform" 
                                         :class="isActive(link.href) ? 'text-[#b38b1d] opacity-100 translate-x-0' : 'text-[#b38b1d] opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0'" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    <span :class="{ 'underline decoration-2 underline-offset-4': isActive(link.href), 'group-hover/link:underline decoration-2 underline-offset-4': !isActive(link.href) }">{{ $t(link.label) }}</span>
                                </Link>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </nav>
        </header>

        <!-- Mobile Menu Overlay -->
        <div @click="toggleMenu" 
             class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm lg:hidden transition-opacity duration-300 ease-linear"
             :class="[
                 isDragging ? '!transition-none' : '',
                 (isMobileMenuOpen || isDragging) ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'
             ]"
             :style="overlayStyle"
        >
            <!-- Floating Close Button -->
            <button class="absolute top-4 right-4 p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-full transition-all">
                <span class="sr-only">Close menu</span>
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Drawer -->
        <div class="fixed inset-y-0 left-0 z-[70] w-[80%] sm:w-[85%] sm:max-w-[450px] md:max-w-[500px] shadow-2xl lg:hidden flex flex-col h-[100dvh] transition-transform duration-300 ease-out"
             :class="[
                 isDragging ? '!transition-none' : '',
                 (isMobileMenuOpen || isDragging) ? 'translate-x-0' : '-translate-x-full'
             ]"
             :style="[dragStyle, { backgroundColor: navBgColor }]"
        >
                
                <!-- Drawer Header -->
                <div class="flex items-center bg-white gap-2 sm:gap-4 px-3 sm:px-4 drop-shadow-sm shrink-0">
                    <Link href="/" @click="toggleMenu" class="flex items-center min-w-0 w-full">
                        <img src="./path/to/duc-logo.png" alt="DUC Logo" 
                             class="w-auto object-contain drop-shadow-md transition-all duration-300 shrink-0"
                             :class="isScrolled ? 'h-[45px] sm:h-[60px] md:h-[70px]' : 'h-[45px] sm:h-[65px] md:h-[70px]'" />
                        
                        <div class="flex flex-col justify-center drop-shadow-md whitespace-nowrap min-w-0 ml-1 sm:ml-0">
                            <h1 class="leading-none text-black tracking-wide transition-all duration-300" 
                                style="font-family: 'Moul', 'Khmer OS Moul', serif;"
                                :class="isScrolled ? 'text-[13px] sm:text-[18px] md:text-[20px]' : 'text-[13px] sm:text-[20px] md:text-[20px]'">
                                សាកលវិទ្យាល័យឌីជីថលកម្ពុជា
                            </h1>
                            <h2 class="mt-1 font-[900] leading-none tracking-[0.03em] text-black transition-all duration-300" 
                                style="font-family: 'Old English Text MT', 'UnifrakturMaguntia', serif;"
                                :class="isScrolled ? 'text-[14px] sm:text-[20px] md:text-[22px]' : 'text-[14px] sm:text-[22px] md:text-[22px]'">
                                Digital University of Cambodia
                            </h2>
                        </div>
                    </Link>
                </div>

                <!-- Drawer Content -->
                <div class="flex-1 overflow-y-auto">
                    <div class="space-y-1 px-4 pb-6 pt-4">
                    
                    <div v-for="(item, index) in navItems" :key="item.id || index" class="border-b border-white/10 last:border-0 pb-1 mb-1">
                        <div v-if="item.hasMenu" class="w-full flex items-center justify-between rounded-md transition-colors" :class="isItemActive(item) ? 'bg-white/20 text-white font-extrabold' : 'text-white/90 hover:bg-white/10'">
                                    <Link :href="item.href" @click="toggleMenu" class="flex-1 flex items-center gap-3 px-3 py-3 text-base font-medium">
                                        <span class="flex items-center justify-center opacity-80" v-html="item.icon"></span>
                                        {{ $t(item.label) }}
                                    </Link>
                                    <button @click.prevent="toggleMobileMenu(item.label)" class="px-4 py-3 border-l border-white/10 opacity-70 hover:opacity-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 transition-transform duration-200" :class="expandedMobileMenus.includes(item.label) ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>

                                <Link v-else :href="item.href" @click="toggleMenu" class="flex items-center gap-3 rounded-md px-3 py-3 text-base font-medium transition-colors"
                                      :class="isItemActive(item) ? 'bg-white/20 text-white font-extrabold' : 'text-white/90 hover:bg-white/10'">
                                    <span class="flex items-center justify-center opacity-80" v-html="item.icon"></span>
                                    {{ $t(item.label) }}
                                </Link>

                        <div v-if="item.megaMenu && expandedMobileMenus.includes(item.label)" class="pl-11 pr-3 pb-3 space-y-5 pt-2">
                            <div v-for="cat in item.megaMenu" :key="cat.title">
                                <Link
                                    :href="cat.href"
                                    @click="toggleMenu"
                                    class="block font-bold text-sm uppercase tracking-wider mb-2 border-b border-white/10 pb-1"
                                    :class="isCatActive(cat) ? 'text-white border-white/50' : 'text-[#f5d98f] hover:text-white'"
                                >
                                    {{ $t(cat.title) }}
                                </Link>
                                <div class="flex flex-col gap-3 pl-2 border-l border-white/20">
                                    <Link 
                                        v-if="cat.links"
                                        v-for="link in cat.links" 
                                        :key="link.label" 
                                        :href="link.href"
                                        @click="toggleMenu"
                                        class="text-sm transition-all"
                                        :class="isActive(link.href) ? 'text-[#ffb800] font-bold underline underline-offset-4' : 'text-white/80 hover:text-white hover:underline'"
                                    >
                                        {{ $t(link.label) }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>

                <!-- Drawer Footer -->
                <div class="border-t border-blue-400/30 px-5 py-6 bg-[#2a3f82] mt-auto shrink-0">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <a v-for="item in socialLinks" :key="item.label" :href="item.href" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e3e5e8] text-gray-700 transition hover:scale-110" :class="item.processedClass ? item.processedClass.replace('bg-white/10', '') : ''" :style="item.customStyle">
                                <span class="flex items-center justify-center" v-html="item.svg"></span>
                            </a>
                        </div>
                        <div class="flex items-center bg-black/20 p-1 rounded-full shadow-inner border border-white/10">
                            <a href="/lang/km" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300" :class="page.props.locale === 'km' ? 'bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-white/60 hover:text-white hover:bg-white/5'">
                                <img src="https://flagcdn.com/w40/kh.png" alt="Khmer" class="w-5 h-5 rounded-full object-cover shadow-sm" /> 
                                <span :class="page.props.locale === 'km' ? 'font-bold' : ''">KH</span>
                            </a>
                            <a href="/lang/en" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[13px] font-semibold transition-all duration-300" :class="page.props.locale === 'en' ? 'bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-white/60 hover:text-white hover:bg-white/5'">
                                <img src="https://flagcdn.com/w40/us.png" alt="English" class="w-5 h-5 rounded-full object-cover shadow-sm" /> 
                                <span :class="page.props.locale === 'en' ? 'font-bold' : ''">EN</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>
<style scoped>
.has-custom-bg {
    background-color: var(--custom-bg) !important;
}
.has-custom-hover-bg:hover {
    background-color: var(--custom-hover-bg) !important;
}
.has-custom-text {
    color: var(--custom-text) !important;
}
.has-custom-hover-text:hover {
    color: var(--custom-hover-text) !important;
}
</style>