<template>
  <app-layout>
    <!-- Searchbar On Top -->
    <template #hero>
      <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
        <links-search
          :filters="searchFilters"
          :search-route="route('links.public')"
        />
      </div>
    </template>
    <!-- Main Container -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <div class="my-10 max-w-lg mx-auto grid gap-5 lg:grid-cols-4 lg:max-w-none">
        <card-for-frontend
          v-for="link in links.data"
          :key="link.id"
          :link="link"
          :show-buttons="false"
        />
      </div>
      <!-- Pagination -->
      <x-pagination-simple
        class="border-none"
        :links="links.links"
        :meta="links.meta"
      />
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/Frontend/AppLayout";
import CardForFrontend from "@/Models/Link/CardForFrontend";
import LinksSearch from "@/Pages/Admin/Links/Partials/LinksSearch";
import XPaginationSimple from "@/Components/Pagination/Simple";

export default {
    components: {
        XPaginationSimple,
        LinksSearch,
        CardForFrontend,
        AppLayout,
    },
    computed:{
        links(){
            return this.$page.props.links;
        },
        searchFilters() {
            return [
                {key: 'default', label: this.$t('app.link_filters.default')},
                {key: 'updated-asc', label: this.$t('app.link_filters.recently-updated')},
                {key: 'created-desc', label: this.$t('app.link_filters.recently-created')},
            ];
        }
    }
}
</script>
