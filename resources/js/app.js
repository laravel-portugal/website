import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import {setupClient} from "@/Utils/Setup/SetupClient";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel Portugal';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name =>  import(`@/Pages/${name}`).then(module => module.default),
    setup({ el, app: InertiaApp, props, plugin }) {
        const app = createApp({ render: () => h(InertiaApp, props) })
        return setupClient(app,plugin,el)
    },
});

InertiaProgress.init({ color: '#4B5563', delay:50 });


