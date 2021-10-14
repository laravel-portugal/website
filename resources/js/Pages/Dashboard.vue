<template>
  <app-layout title="Dashboard">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <notification-card
        title="👋 Welcome Pedro! "
        content="Hey Pedro, Thanks for joining Laravel Portugal Community website, its a pleasure to have you here. Please take a minute to find the most useful links we have prepared for you, or if you feel confident start sharing your own tips to the community!"
      />

      <div class="bg-white shadow-lg rounded-lg sm:rounded-lg py-5 px-6 mx-auto">
        <div class="max-w-full mx-auto">
          <h2 class="text-lg font-medium text-gray-900">
            Let's get started
          </h2>
          <p class="mt-1 text-sm text-gray-500">
            Once again thanks for being here, lets get started on what you can do.
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
            >Or Join our Official Discord here<span aria-hidden="true"> &rarr;</span></a>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import NotificationCard from "@/Components/Cards/NotificationCard";
import {
    ChevronRightIcon,
    TerminalIcon,
    LinkIcon,
    UserCircleIcon
} from '@heroicons/vue/outline'


export default defineComponent({
    components: {
        NotificationCard,
        AppLayout,
        ChevronRightIcon
    },
    computed: {
        items(){
            return [
                {
                    name: 'Share your Tips & Tricks via Links',
                    description: 'Start sharing your tips & tricks with the community',
                    href: route('links.create'),
                    iconColor: 'bg-red-500',
                    icon: LinkIcon,
                    wrapper: 'inertia-link',
                },
                {
                    name: 'Laravel Documentation',
                    description: 'Just because we always forget. Lets remember once more.',
                    href: 'https://laravel.com',
                    iconColor: 'bg-green-500',
                    icon: TerminalIcon,
                    wrapper: 'a',
                },
                {
                    name: 'Edit your Profile',
                    description: 'Upload your profile picture and costumize your profile',
                    href: route('profile.show'),
                    iconColor: 'bg-yellow-500',
                    icon: UserCircleIcon,
                    wrapper: 'inertia-link',
                },
            ]
        },
    }
})
</script>
