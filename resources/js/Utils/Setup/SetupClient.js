import {FontAwesomeRegister} from "@/Utils/Plugins/FontAwesome/FontAwesome";
import {i18n} from "@/Utils/Plugins/Vuei18n/Vuei18n";
import VueAxios from "vue-axios";
import axios from "axios";
import Permissions from "@/Utils/Plugins/Permissions/Permissions";
import PortalVue from "portal-vue";
import {Link} from "@inertiajs/inertia-vue3";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

export const setupClient = (app,plugin,mountElement) => {
    // Register
    FontAwesomeRegister();

    // Plugins
    app.use(i18n);
    app.use(plugin);
    app.use(VueAxios, axios)
    app.use(Permissions);
    app.use(PortalVue)

    // Mixins
    app.mixin({ methods: { route } });

    // Components
    app.component('InertiaLink',Link);
    app.component('FontAwesomeIcon', FontAwesomeIcon)

    // Mount
    app.mount(mountElement);
    mountElement.removeAttribute('data-page');
    return app;
}
