<template>
  <div class="block xl:hidden">
    <Popover
      v-slot="{ open }"
      class="relative bg-transparent z-50"
    >
      <!-- Mobile -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center px-4 py-6 sm:px-6">
          <!-- Mobile Logo -->
          <div class="flex justify-start lg:w-0 lg:flex-1">
            <a href="/">
              <span
                class="sr-only"
                v-html="$page.props.meta.site_name"
              />
              <app-logo-white class="h-20 w-auto" />
            </a>
          </div>
          <!-- Mobile Hamburger Menu -->
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
                    <component
                      :is="$page.component === 'Frontend/Landing/Index' ? 'a' : 'InertiaLink'"
                      href="/#top"
                      class="text-base font-medium text-gray-100 hover:text-gray-300"
                    >
                      {{ $t('app.menu_landing.home') }}
                    </component>
                  </PopoverButton>

                  <!--                  <PopoverButton-->
                  <!--                    as="div"-->
                  <!--                    class="text-gray-300 text-base font-medium hover:underline"-->
                  <!--                  >-->
                  <!--                    <component-->
                  <!--                      :is="$page.component === 'Frontend/Landing/Index' ? 'a' : 'InertiaLink'"-->
                  <!--                      href="/#about"-->
                  <!--                      class="text-base font-medium text-gray-100 hover:text-gray-300"-->
                  <!--                    >-->
                  <!--                      {{ $t('app.menu_landing.about') }}-->
                  <!--                    </component>-->
                  <!--                  </PopoverButton>-->

                  <PopoverButton
                    as="div"
                    class="text-gray-300 text-base font-medium hover:underline"
                  >
                    <component
                      :is="$page.component === 'Frontend/Landing/Index' ? 'a' : 'InertiaLink'"
                      href="/#links"
                      class="text-base font-medium text-gray-100 hover:text-gray-300"
                    >
                      {{ $t('app.menu_landing.links') }}
                    </component>
                  </PopoverButton>

                  <!--                  <PopoverButton-->
                  <!--                    as="div"-->
                  <!--                    class="text-gray-300 text-base font-medium hover:underline"-->
                  <!--                  >-->
                  <!--                    <inertia-link href="/#community">-->
                  <!--                      {{ $t('app.menu_landing.community') }}-->
                  <!--                    </inertia-link>-->
                  <!--                  </PopoverButton>-->
                </div>
                <div class="mt-6 border-t border-gray-500">
                  <div class="pt-5 grid grid-cols-2 gap-4">
                    <a
                      v-for="network in socialNetworks"
                      :key="network.name"
                      :href="network.link"
                      target="_blank"
                      rel="nofollow"
                      class="text-gray-300 text-base font-medium hover:underline flex inline-flex items-center"
                    >
                      <font-awesome-icon
                        :icon="['fab',''+network.icon+'']"
                        class="mr-1 h-4 w-4 text-md"
                        area-hidden="true"
                      />
                      <span>
                        {{ $t(network.name) }}
                      </span>
                    </a>
                  </div>
                </div>
                <div class="mt-6">
                  <inertia-link
                    :href="route('login')"
                    class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700"
                  >
                    {{ $t('app.menu_landing.login') }}
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
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import AppLogoWhite from "@/Layouts/Backend/Partials/AppLogoWhite";
import {socialNetworks} from "@/Utils/useSocialNetworks";

export default {
    components: {
        AppLogoWhite,
        Popover,
        PopoverButton,
        PopoverPanel,
        XIcon,
        MenuAlt3Icon,
        FontAwesomeIcon
    },
    computed: {
        socialNetworks(){
            return socialNetworks.value;
        },
    },
}
</script>
