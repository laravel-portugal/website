<template>
  <!-- Search Bar -->
  <links-search />
  <!-- Actual List -->
  <div class="bg-white shadow overflow-hidden rounded-lg">
    <ul
      v-if="links.data.length"
      role="list"
      class="divide-y divide-gray-200"
    >
      <links-list-item
        v-for="link in links.data"
        :key="link.id"
        :link="link"
      />
    </ul>
    <!-- Currently no data available -->
    <div
      v-else
      class="text-center px-4 py-5 sm:p-6"
    >
      <h3 class="mt-2 text-sm font-medium text-gray-900">
        🧐 Oops. We couldn't find any records.
      </h3>
      <p class="mt-1 text-sm text-gray-500">
        This may happen if you have any filters or query search applied.
      </p>
      <div class="mt-6">
        <inertia-link
          :href="route('admin.links.index')"
          type="button"
          class="btn"
        >
          <RefreshIcon
            class="-ml-1 mr-2 h-5 w-5"
            aria-hidden="true"
          />
          Clear Search
        </inertia-link>
      </div>
    </div>
  </div>
  <!-- Pagination -->
  <x-pagination-simple
    :links="links.links"
    :meta="links.meta"
  />
</template>

<script>
import LinksListItem from "@/Pages/Backend/Links/Partials/LinksListItem";
import LinksSearch from "@/Pages/Backend/Links/Partials/LinksSearch";
import {RefreshIcon} from "@heroicons/vue/outline";
import XPaginationSimple from "@/Components/Pagination/Simple";


export default {
    components: {
        XPaginationSimple,
        LinksSearch,
        LinksListItem,
        RefreshIcon
    },
    props: {
        links: {
            type: [Object],
            required: true,
        },
    },
}
</script>
