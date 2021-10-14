<template>
  <div
    v-if="hasBreadcrumbs"
    class="mx-auto pb-5 px-2 overflow-x-scroll no-scroll-bar"
  >
    <nav
      class="flex items-center text-sm leading-5 font-medium"
    >
      <template v-for="(breadcrumb,index) in $page.props.breadcrumbs">
        <inertia-link
          v-if="index > 0"
          :key="index+breadcrumb.url"
          :href="breadcrumb.url"
          class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out dark:text-gray-400 dark:hover:text-white whitespace-nowrap"
        >
          {{ breadcrumb.title }}
        </inertia-link>

        <!-- First Icon -->
        <inertia-link
          v-else
          :key="index+breadcrumb.url"
          :href="breadcrumb.url"
          class="text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out dark:text-gray-400 dark:hover:text-white whitespace-nowrap"
          v-html="breadcrumb.title"
        />

        <!-- Next breadcrumb icon -->
        <chevron-right-icon
          v-if="index !== ($page.props.breadcrumbs.length-1)"
          :key="index+'_icon'"
          class="flex-shrink-0 h-4 w-4 text-gray-300"
          aria-hidden="true"
        />
      </template>
    </nav>
  </div>
</template>

<script>
import { ChevronRightIcon } from '@heroicons/vue/outline';

export default {
    components: {
        ChevronRightIcon
    },
    computed:{
        hasBreadcrumbs(){
            return this.$page.props.breadcrumbs.length >= 1
        }
    }
}
</script>
