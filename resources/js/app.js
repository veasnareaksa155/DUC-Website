import '../css/app.css';
import './bootstrap';

import { createInertiaApp, usePage } from '@inertiajs/vue3';
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
