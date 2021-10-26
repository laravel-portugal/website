import express from 'express'
import {createSSRApp, h} from 'vue'
import {renderToString } from '@vue/server-renderer'
import {createInertiaApp} from '@inertiajs/inertia-vue3'
import {setupServer} from "@/Utils/Setup/SetupServer";

const server = express()
server.use(express.json())
server.post('/render', async (request, response, next) => {
    try {
        response.json(
            await createInertiaApp({
                page: request.body,
                render: renderToString,
                resolve: (name) => require(`./Pages/${name}`),
                setup({ el, app: InertiaApp, props, plugin }) {
                    const app = createSSRApp({ render: () => h(InertiaApp, props) })
                    return setupServer(app,plugin,request)
                },
            })
        )
    } catch (error) {
        next(error)
    }
})
server.listen(9000, () => console.log('🧨 Serving on port 9000.'))
console.log('🟢 Starting something funny...')
