import '../css/app.css';
import './bootstrap';

import { createInertiaApp, usePage, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => {
        const baseName = 'Digital University of Cambodia';
        return title && title !== baseName ? `${title} - ${baseName}` : baseName;
    },
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        const syncThemeColors = (settings) => {
            if (!settings) return;
            const root = document.documentElement;
            if (settings.global_bg_color) root.style.setProperty('--global-bg', settings.global_bg_color);
            if (settings.card_bg_color) root.style.setProperty('--card-bg', settings.card_bg_color);
            if (settings.primary_button_color) root.style.setProperty('--btn-primary', settings.primary_button_color);
            if (settings.primary_button_hover) root.style.setProperty('--btn-primary-hover', settings.primary_button_hover);
        };

        // Sync initially
        syncThemeColors(props.initialPage.props.settings);

        // Sync on navigation
        router.on('navigate', (event) => {
            syncThemeColors(event.detail.page.props.settings);
        });

        // Register global translation helper
        app.config.globalProperties.$t = (val) => {
            if (!val) return '';
            let page;
            try {
                page = usePage();
            } catch (e) {
                page = { props: {} };
            }
            const locale = page.props?.locale || 'en';
            const translations = page.props?.translations || {};

            if (typeof val === 'object') {
                return val[locale] || val['en'] || '';
            }
            if (typeof val === 'string' && (val.startsWith('{') || val.startsWith('['))) {
                try {
                    const parsed = JSON.parse(val);
                    if (typeof parsed === 'object') {
                        return parsed[locale] || parsed['en'] || '';
                    }
                } catch (e) {
                    // ignore
                }
            }
            return translations[val] !== undefined ? translations[val] : val;
        };

        return app
            .component('QuillEditor', QuillEditor)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
