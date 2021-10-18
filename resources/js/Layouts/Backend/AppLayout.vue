<template>
  <app-head :title="title || $page.props.title" />
  <div class="main">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <x-slide-over
      v-model="showMenu"
      :container-classes="'bg-gray-100 dark:bg-gray-900'"
      class="lg:hidden"
    >
      <div class="absolute top-0 right-0 -mr-14 p-1">
        <button
          aria-label="Close sidebar"
          class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600"
          @click="showMenu = false"
        >
          <x-icon
            name="close-off-canvas"
            class="h-6 w-6"
          />
        </button>
      </div>
      <div class="flex-shrink-0 flex items-center px-4">
        <app-logo-color />
      </div>
      <div class="mt-5 flex-1 h-0 overflow-y-auto">
        <div class="block lg:hidden h-5 pointer-events-none absolute inset-x-0 z-50 bg-gradient-to-b from-gray-100 to-transparent" />
        <nav class="pt-3 px-2 space-y-1">
          <app-menu
            :url="url"
            @hideMenu="showMenu = false"
            @hide-menu="showMenu = false"
          />
        </nav>
      </div>
      <app-menu-profile />
    </x-slide-over>

    <header class="header">
      <div class="header-wrapper">
        <div class="header-container">
          <!-- Mobile Menu -->
          <div class="mobile-menu-wrapper">
            <button
              aria-label="Open sidebar"
              class="mobile-menu-button"
              type="button"
              @click="showMenu = !showMenu"
            >
              <span class="sr-only">{{ $t('app.open') }}</span>
              <menu-alt4-icon class="h-6 w-6" />
            </button>
          </div>
          <!-- Logo -->
          <app-header-logo />
          <!-- Balance, Notifications, Profile -->
          <app-header-actions />
        </div>
      </div>
    </header>

    <!-- Main Wrapper -->
    <div class="py-10">
      <div class="content">
        <!-- Sidebar -->
        <div
          :class="{'xl:col-span-2': $slots['right-column'],'lg:col-span-2': !$slots['right-column']}"
          class="hidden lg:block"
        >
          <nav
            aria-label="Sidebar"
            class="sticky top-4 divide-y divide-gray-300"
          >
            <app-menu :url="url" />
          </nav>
        </div>

        <!-- Main -->
        <main
          :class="{'xl:col-span-6': $slots['right-column']}"
          class="lg:col-span-10"
        >
          <!-- Breadcrumbs -->
          <app-breadcrumbs />
          <!-- Portal to Flash Notifications -->
          <portal-target
            name="flash"
            multiple
          />
          <!-- Main Content goes here -->
          <slot />
        </main>

        <!-- Left sidebar -->
        <slot name="right-column">
          <div v-if="$slots['right-column']" />
        </slot>
      </div>
    </div>
  </div>
  <!-- Authorization Failed Modal -->
  <authorization-failed v-if="$page.props.authorization" />
</template>

<script>
import {Inertia} from '@inertiajs/inertia'
import {MenuAlt4Icon,XIcon} from "@heroicons/vue/outline";
import AppMenu from "@/Layouts/Backend/Partials/AppMenu";
import AppMenuProfile from "@/Layouts/Backend/Partials/AppMenuProfile";
import AppLogoColor from "@/Layouts/Backend/Partials/AppLogoColor";
import AppHeaderActions from "@/Layouts/Backend/Partials/AppHeaderActions";
import AppHeaderLogo from "@/Layouts/Backend/Partials/AppHeaderLogo";
import AppHead from "@/Layouts/Backend/Partials/AppHead";
import XSlideOver from "@/Components/Menus/SlideOver";
import AuthorizationFailed from "@/Components/Modals/AuthorizationFailed";
import AppBreadcrumbs from "@/Layouts/Backend/Partials/AppBreadcrumbs";

export default {
    components: {
        AppBreadcrumbs,
        AuthorizationFailed,
        XSlideOver,
        AppHead,
        AppHeaderLogo,
        AppHeaderActions,
        AppLogoColor,
        AppMenuProfile,
        AppMenu,
        MenuAlt4Icon,
        XIcon
    },
    props: {
        title: {
            type: String,
            required: false,
            default: null,
        },
    },

    data() {
        return {
            showMenu: false,
        }
    },
    computed: {
        path() {
            return window.location.pathname
        },
        url(){
            return location.pathname.substr(1)
        }
    },
    mounted() {
        Inertia.on('finish', event => {
            this.showMenu = false;
        })
    },
}
</script>
