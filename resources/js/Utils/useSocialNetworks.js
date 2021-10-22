import {usePage} from "@inertiajs/inertia-vue3";
import {computed} from "vue";

// TODO: this must be checked later on, because on build time the usePage() is not yet available
// due to the fact that inertia didnt booted up yet neither vue.

export const socialNetworks = computed(() => {
    return [
        {
            name: 'app.social_networks.twitter-title',
            description: 'app.social_networks.twitter-text',
            link: usePage().props.value?.meta.social.twitter,
            icon: 'twitter',
        },
        {
            name: 'app.social_networks.github-title',
            description: 'app.social_networks.github-text',
            link: usePage().props.value?.meta.social.github,
            icon: 'github',
        },
        {
            name: 'app.social_networks.discord-title',
            description: 'app.social_networks.discord-text',
            link: usePage().props.value?.meta.social.discord,
            icon: 'discord',
        },
        {
            name: 'app.social_networks.meetup-title',
            description: 'app.social_networks.meetup-text',
            link: usePage().props.value?.meta.social.meetup,
            icon: 'meetup',
        },
        {
            name: 'app.social_networks.youtube-title',
            description: 'app.social_networks.youtube-text',
            link: usePage().props.value?.meta.social.youtube,
            icon: 'youtube',
        },
    ]
})
//
// export const socialNetworksss = () => {
//     return [
//         {
//             name: 'app.social_networks.twitter-title',
//             description: 'app.social_networks.twitter-text',
//             link: usePage().props.value?.meta.social.twitter,
//             icon: 'twitter',
//         },
//         {
//             name: 'app.social_networks.github-title',
//             description: 'app.social_networks.github-text',
//             link: usePage().props.value?.meta.social.github,
//             icon: 'github',
//         },
//         {
//             name: 'app.social_networks.discord-title',
//             description: 'app.social_networks.discord-text',
//             link: usePage().props.value?.meta.social.discord,
//             icon: 'discord',
//         },
//         {
//             name: 'app.social_networks.meetup-title',
//             description: 'app.social_networks.meetup-text',
//             link: usePage().props.value?.meta.social.meetup,
//             icon: 'meetup',
//         },
//         {
//             name: 'app.social_networks.youtube-title',
//             description: 'app.social_networks.youtube-text',
//             link: usePage().props.value?.meta.social.youtube,
//             icon: 'youtube',
//         },
//     ]
// }
