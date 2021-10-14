import {usePage} from "@inertiajs/inertia-vue3";

export default {
    install: (app) => {

        /**
         * @param permission - The wanted role
         * @returns boolean
         */
        const hasPermission = (permission) => {
            return !(!usePage()?.props.value?.user?.permissions || usePage().props.value?.user?.permissions?.indexOf(permission) < 0)
        }

        /**
         * @param role - The wanted role
         * @returns boolean
         */
        const hasRole = (role) => {
            return !(!usePage().props.value?.user?.roles || usePage().props.value?.user?.roles?.indexOf(role) < 0)
        }

        app.config.globalProperties.$can = hasPermission
        app.config.globalProperties.$hasRole = hasRole;

        app.mixin({
            methods: {
                can: hasPermission,
                hasRole: hasRole
            }
        })
    }
}
