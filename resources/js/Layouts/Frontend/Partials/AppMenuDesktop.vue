<template>
  <div class="mb-10 hidden xl:block">
    <Popover class="relative bg-transparent">
      <div class="flex justify-between items-center max-w-7xl mx-auto px-4 py-6 sm:px-6 md:justify-start md:space-x-10 lg:px-8">
        <!-- Logo -->
        <div class="flex justify-start lg:w-0 lg:flex-1">
          <inertia-link href="/">
            <span class="sr-only">Laravel Portugal</span>
            <app-logo-white class="h-8 w-auto sm:h-10" />
          </inertia-link>
        </div>
        <!-- Menu -->
        <PopoverGroup
          as="nav"
          class="hidden md:flex space-x-10"
        >
          <component
            :is="$page.component === 'Landing/Index' ? 'a' : 'InertiaLink'"
            href="/#hero"
            class="text-base font-medium text-gray-100 hover:text-gray-300"
          >
            {{ $t('app.menu_landing.home') }}
          </component>

          <component
            :is="$page.component === 'Landing/Index' ? 'a' : 'InertiaLink'"
            href="/#about"
            class="text-base font-medium text-gray-100 hover:text-gray-300"
          >
            {{ $t('app.menu_landing.about') }}
          </component>

          <component
            :is="$page.component === 'Landing/Index' ? 'a' : 'InertiaLink'"
            href="/#links"
            class="text-base font-medium text-gray-100 hover:text-gray-300"
          >
            {{ $t('app.menu_landing.links') }}
          </component>
          <!-- Community -->
          <Popover
            v-slot="{ open }"
            class="relative z-50"
          >
            <PopoverButton :class="[open ? 'text-gray-300' : 'text-gray-100', 'group bg-transparent rounded-lg inline-flex items-center text-base font-medium hover:text-gray-300 focus:outline-none']">
              <span> {{ $t('app.menu_landing.community') }}</span>
              <ChevronDownIcon
                :class="[open ? 'text-gray-300' : 'text-gray-100', 'ml-2 h-5 w-5 group-hover:text-gray-400']"
                aria-hidden="true"
              />
            </PopoverButton>

            <transition
              enter-active-class="transition ease-out duration-200"
              enter-from-class="opacity-0 translate-y-1"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 translate-y-1"
            >
              <PopoverPanel class="absolute z-50 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0 shadow-white-lg rounded-lg border border-gray-700">
                <div class="rounded-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                  <div
                    class="relative grid gap-6 px-5 py-6 sm:gap-8 sm:p-8 bg-gray-900"
                    style="border-radius:10px"
                  >
                    <a
                      v-for="network in social_networks"
                      :key="network.name"
                      :href="network.href"
                      class="-m-3 p-3 block rounded-md hover:bg-primary-500 group"
                    >
                      <div class="title flex inline-flex items-center justify-center">
                        <font-awesome-icon
                          :icon="['fab',''+network.icon+'']"
                          class="text-gray-300 group-hover:text-white h-4 w-4 text-md mr-1"
                          area-hidden="true"
                        />
                        <p class="text-base font-medium text-gray-300 group-hover:text-white">
                          {{ network.name }}
                        </p>
                      </div>

                      <p class="mt-1 text-sm text-gray-500 group-hover:text-gray-300">
                        {{ network.description }}
                      </p>
                    </a>
                  </div>
                </div>
              </PopoverPanel>
            </transition>
          </Popover>
        </PopoverGroup>
        <!-- Items on the right -->
        <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
          <inertia-link
            :href="route('login')"
            class="whitespace-nowrap text-base font-medium font-medium text-gray-100 hover:text-gray-300"
          >
            {{ $t('app.menu_landing.login') }}
          </inertia-link>
          <inertia-link
            :href="route('register')"
            class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-white rounded-md shadow-sm text-base font-medium text-white hover:bg-white hover:bg-opacity-10"
          >
            {{ $t('app.menu_landing.register') }}
          </inertia-link>
        </div>
      </div>
    </Popover>
  </div>
</template>

<script>
import AppLogoWhite from "@/Layouts/Backend/Partials/AppLogoWhite";
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/solid";

export default {
    components: {
        AppLogoWhite,
        Popover,
        PopoverButton,
        PopoverGroup,
        PopoverPanel,
        ChevronDownIcon,
    },
    computed:{
        social_networks(){
            return [
                {
                    name: 'Twitter',
                    description: 'Want to join us on Twitter? Get involved on the most popular network',
                    href: this.$page.props?.meta.social.twitter,
                    icon: 'twitter',
                },
                {
                    name: 'GitHub',
                    description: 'Want to Contribute? Checkout our official GitHub Account',
                    href: this.$page.props?.meta.social.github,
                    icon: 'github',
                },
                {
                    name: 'Discord',
                    description: 'Fan of communities? Join Laravel Portugal ® on Discord today and talk with hundreds of other Developers',
                    href: this.$page.props?.meta.social.discord,
                    icon: 'discord',
                },
                {
                    name: 'Meetup',
                    description: 'Want to meet your fellow Laravel Mates in Portugal or around the world? Worry not! Lets do it.',
                    href: this.$page.props?.meta.social.meetup,
                    icon: 'meetup',
                },
            ];
        }
    }
}
</script>
