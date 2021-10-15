import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import languageBundle from '../lang/index';
import { createI18n } from 'vue-i18n';
import axios from 'axios'
import VueAxios from 'vue-axios'
import Permissions from "@/Utils/Plugins/Permissions/Permissions";
import PortalVue from 'portal-vue'

// Register fa Icons
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faInstagram, faFacebook, faTwitter, faDiscord, faMeetup, faGithub } from '@fortawesome/free-brands-svg-icons'
library.add(faInstagram, faFacebook, faTwitter, faDiscord, faMeetup, faGithub)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel Portugal';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name =>  import(`@/Pages/${name}`).then(module => module.default),
    setup({ el, app: InertiaApp, props, plugin }) {
        const app =  createApp({ render: () => h(InertiaApp, props) })

        app.mixin({ methods: { route } });

        // Plugins
        const i18n = createI18n({
            locale: 'en',
            messages: languageBundle,
        });


        app.use(i18n);
        app.use(plugin); // Inertia Plugin
        app.use(VueAxios, axios)
        app.use(Permissions);
        app.use(PortalVue) // Portal Vue is a bit better since it allows to render elements outside of the mounting point.

        // Components
        app.component('InertiaLink',Link);
        app.component('FontAwesomeIcon', FontAwesomeIcon)

        app.mount(el);
        el.removeAttribute('data-page');
    },
});

InertiaProgress.init({ color: '#4B5563', delay:50 });


