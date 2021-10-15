<template>
  <div class="block xl:hidden">
    <Popover
      v-slot="{ open }"
      class="relative bg-transparent z-50"
    >
      <!-- Desktop -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center px-4 py-6 sm:px-6">
          <!-- Desktop Logo -->
          <div class="flex justify-start lg:w-0 lg:flex-1">
            <a href="/">
              <span
                class="sr-only"
                v-html="$page.props.meta.site_name"
              />
              <app-logo-white class="h-20 w-auto" />
              <!--              <img-->
              <!--                class="h-20 w-auto"-->
              <!--                src="img/logo-compressed.png"-->
              <!--                :alt="$page.props.meta.site_name"-->
              <!--              >-->
            </a>
          </div>
          <!-- Desktop Hamburger Menu -->
          <div class="flex justify-end -mr-2 -my-2 xl:hidden">
            <PopoverButton class="bg-transparent rounded-md p-2 inline-flex items-center justify-center text-gray-300 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
              <span class="sr-only">Open menu</span>
              <MenuAlt3Icon
                class="h-8 w-8"
                aria-hidden="true"
              />
            </PopoverButton>
          </div>
        </div>
      </div>
      <!-- Mobile Menu -->
      <transition
        enter-active-class="duration-200 ease-out"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="duration-100 ease-in"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <PopoverPanel
          focus
          class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right xl:hidden z-50"
        >
          <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-gray-900 divide-y-2 divide-gray-50 w-full">
            <div class="pt-5 pb-6 px-5">
              <div class="flex items-center justify-between">
                <div>
                  <app-logo-white class="h-20 w-auto" />
                </div>
                <div class="-mr-2">
                  <PopoverButton class="bg-gray-900 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                    <span class="sr-only">Close menu</span>
                    <XIcon
                      class="h-6 w-6"
                      aria-hidden="true"
                    />
                  </PopoverButton>
                  <portal to="overlay">
                    <div
                      v-if="open"
                      class="bg-gray-900"
                      :class="{'opacity-90 fixed inset-0 z-40 h-100' : open, 'opacity-0': !open}"
                    />
                  </portal>
                </div>
              </div>
              <div class="pt-5 pb-1 px-5">
                <div class="grid grid-cols-2 gap-4">
                  <PopoverButton
                    as="div"
                    class="text-gray-300 text-base font-medium hover:underline"
                  >
                    <inertia-link href="/">
                      {{ $t('generic.menu.home') }}
                    </inertia-link>
                  </PopoverButton>

                  <PopoverButton
                    as="div"
                    class="text-gray-300 text-base font-medium hover:underline"
                  >
                    <inertia-link href="/#about">
                      {{ $t('generic.menu.about') }}
                    </inertia-link>
                  </PopoverButton>

                  <PopoverButton
                    as="div"
                    class="text-gray-300 text-base font-medium hover:underline"
                  >
                    <inertia-link href="/#collection">
                      {{ $t('generic.menu.collection') }}
                    </inertia-link>
                  </PopoverButton>

                  <PopoverButton
                    as="div"
                    class="text-gray-300 text-base font-medium hover:underline"
                  >
                    <inertia-link href="/#roadmap">
                      {{ $t('generic.menu.roadmap') }}
                    </inertia-link>
                  </PopoverButton>

                  <PopoverButton
                    as="div"
                    class="text-gray-300 text-base font-medium hover:underline"
                  >
                    <inertia-link href="/#faqs">
                      {{ $t('generic.menu.faqs') }}
                    </inertia-link>
                  </popoverbutton>
                </div>
                <div class="mt-6 border-t border-gray-500">
                  <div class="pt-5 grid grid-cols-2 gap-4">
                    <a
                      v-for="network in social_networks"
                      :key="network.name"
                      :href="network.href"
                      target="_blank"
                      class="text-gray-300 text-base font-medium hover:underline flex inline-flex items-center"
                    >
                      <i
                        class="h-4 w-4 text-md mr-1 fab"
                        :class="{
                          'fa-instagram': network.icon === 'instagram',
                          'fa-facebook': network.icon === 'facebook',
                          'fa-twitter': network.icon === 'twitter',
                          'fa-telegram': network.icon === 'telegram',
                          'fa-discord': network.icon === 'discord',
                        }"
                        aria-hidden="true"
                      />
                      {{ network.name }}
                    </a>
                  </div>
                </div>
                <div class="mt-6">
                  <inertia-link
                    :href="route('sales.show')"
                    class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700"
                  >
                    {{ $t('generic.join-presale') }}
                  </inertia-link>
                </div>
              </div>
            </div>
          </div>
        </PopoverPanel>
      </transition>
    </Popover>
  </div>
</template>

<script>
import { Popover, PopoverButton, PopoverGroup, PopoverPanel,PopoverOverlay } from '@headlessui/vue'
import { MenuAlt3Icon, XIcon } from '@heroicons/vue/outline'
import AppLogoWhite from "@/Layouts/Partials/AppLogoWhite";
export default {
    components: {
        AppLogoWhite,
        Popover,
        PopoverButton,
        PopoverPanel,
        XIcon,
        MenuAlt3Icon
    },
    computed: {
        social_networks(){
            return [
                {
                    name: 'Twitter',
                    description: 'Want to join us on Twitter? Get involved on the most popular network',
                    href: $t('app.social.twitter'),
                    icon: 'twitter',
                },
                {
                    name: 'Instagram',
                    description: 'Keen to check our artworks on Instagram? Follow us on Instagram at @cryptomoons',
                    href: $t('generic.social.instagram'),
                    icon: 'instagram',
                },
                {
                    name: 'Telegram',
                    description: 'Need to join the community on the most secure chatting app? Lets get started',
                    href: $t('generic.social.telegram'),
                    icon: 'telegram',
                },
                {
                    name: 'Discord',
                    description: 'Fan of communities? Join Crypto Moons® on Discord today and talk with hundreds of other NFT Buyers.',
                    href: $t('generic.social.discord'),
                    icon: 'discord',
                },
            ];
        }
    },
}
</script>
