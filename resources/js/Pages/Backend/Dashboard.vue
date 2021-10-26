<template>
  <app-layout :title="$t('app.menu.dashboard')">
    <notification-card
      class="pb-5"
      :title="$t('app.welcome-message-title',{name: $page.props.user.name})"
      :content="$t('app.welcome-message-text',{name: $page.props.meta.site_name})"
    />

    <div class="bg-white shadow-lg rounded-lg sm:rounded-lg py-5 px-6 mx-auto">
      <div class="max-w-full mx-auto">
        <h2 class="text-lg font-medium text-gray-900">
          {{ $t('app.tour-title') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500">
          {{ $t('app.tour-subtitle') }}
        </p>
        <ul
          role="list"
          class="mt-6 border-t border-b border-gray-200 divide-y divide-gray-200"
        >
          <li
            v-for="(item, itemIdx) in items"
            :key="itemIdx"
          >
            <div class="relative group py-4 flex items-start space-x-3">
              <div class="flex-shrink-0">
                <span :class="[item.iconColor, 'inline-flex items-center justify-center h-10 w-10 rounded-lg']">
                  <component
                    :is="item.icon"
                    class="h-6 w-6 text-white"
                    aria-hidden="true"
                  />
                </span>
              </div>
              <div class="min-w-0 flex-1">
                <div class="text-sm font-medium text-gray-900">
                  <component
                    :is="item.wrapper"
                    :href="item.href"
                    target="_blank"
                  >
                    <span
                      class="absolute inset-0"
                      aria-hidden="true"
                    />
                    {{ item.name }}
                  </component>
                </div>
                <p class="text-sm text-gray-500">
                  {{ item.description }}
                </p>
              </div>
              <div class="flex-shrink-0 self-center">
                <ChevronRightIcon
                  class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                  aria-hidden="true"
                />
              </div>
            </div>
          </li>
        </ul>
        <div class="mt-6 flex">
          <a
            href="#"
            class="text-sm font-medium text-gray-500 hover:text-gray-600"
          > {{ $t('app.tour-whats-next') }}<span aria-hidden="true"> &rarr;</span></a>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/Backend/AppLayout.vue'
import NotificationCard from "@/Components/Cards/NotificationCard";
import {ChevronRightIcon, TerminalIcon, LinkIcon, UserCircleIcon} from '@heroicons/vue/outline'

export default{
    components: {
        NotificationCard,
        AppLayout,
        ChevronRightIcon
    },
    computed: {
        items(){
            return [
                {
                    name: this.$t('app.tour-step-one'),
                    description: this.$t('app.tour-step-one-text'),
                    href: this.route('links.create'),
                    iconColor: 'bg-red-500',
                    icon: LinkIcon,
                    wrapper: 'inertia-link',
                },
                {
                    name: this.$t('app.tour-step-two'),
                    description: this.$t('app.tour-step-two-text'),
                    href: 'https://laravel.com',
                    iconColor: 'bg-green-500',
                    icon: TerminalIcon,
                    wrapper: 'a',
                },
                {
                    name: this.$t('app.tour-step-three'),
                    description: this.$t('app.tour-step-three-text'),
                    href: this.route('profile.show'),
                    iconColor: 'bg-yellow-500',
                    icon: UserCircleIcon,
                    wrapper: 'inertia-link',
                },
            ]
        },
    }
}
</script>
