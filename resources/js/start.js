import {createSSRApp, h} from 'vue'
import {renderToString } from '@vue/server-renderer'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {setupServer} from "@/Utils/Setup/SetupServer";

const page = JSON.parse(process.argv[2]);

createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => require(`./Pages/${name}`),
    setup({ el, app: InertiaApp, props, plugin }) {
        const app = createSSRApp({ render: () => h(InertiaApp, props) })
        return setupServer(app, plugin, page)
    },
}).then((output) => console.log(JSON.stringify(output)));
