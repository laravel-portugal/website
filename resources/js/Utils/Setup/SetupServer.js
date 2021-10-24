import {FontAwesomeRegister} from "@/Utils/Plugins/FontAwesome/FontAwesome";
import {i18n} from "@/Utils/Plugins/Vuei18n/Vuei18n";
import Permissions from "@/Utils/Plugins/Permissions/Permissions";
import PortalVue from "portal-vue";
import {Link} from "@inertiajs/inertia-vue3";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import route from 'ziggy'; // Yeah its being used

export const setupServer = (app,plugin,request) => {
    // Register
    FontAwesomeRegister();

    // Specially Ziggy Setup to take Inertia Props
    const Ziggy = {
        ...request.body.props.ziggy,
        location: new URL(request.body.props.ziggy.url)
    }

    // Plugins
    app.use(i18n);
    app.use(plugin);
    app.use(Permissions);
    app.use(PortalVue);

    // Mixins
    app.mixin({
        methods: {
            route: (name, params, absolute, config = Ziggy) => route(name, params, absolute, config),
        }
    });

    // Components
    app.component('InertiaLink',Link);
    app.component('FontAwesomeIcon', FontAwesomeIcon)
    return app;
}
