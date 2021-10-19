<template>
  <app-layout title="Links">
    <!-- Search Bar -->
    <links-search
      :filters="searchFilters"
      :search-route="route('admin.links.index')"
    />
    <!-- List -->
    <links-list :links="links" />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/Backend/AppLayout";
import LinksList from "@/Pages/Admin/Links/Partials/LinksList";
import LinksSearch from "@/Pages/Admin/Links/Partials/LinksSearch";

export default {
    components: {
        LinksSearch,
        AppLayout,
        LinksList
    },
    computed:{
        links(){
            return this.$page.props.links
        },
        searchFilters() {
            return [
                {key: 'default', label: this.$t('app.link_filters.default')},
                {key: 'status-published', label: this.$t('app.link_filters.published')},
                {key: 'status-rejected', label: this.$t('app.link_filters.rejected')},
                {key: 'status-waiting-approval', label: this.$t('app.link_filters.waiting-approval')},
                {key: 'updated-asc', label: this.$t('app.link_filters.recently-updated')},
                {key: 'created-desc', label: this.$t('app.link_filters.recently-created')},
                {key: 'deleted', label: this.$t('app.link_filters.deleted')},
            ];
        }
    }
}
</script>
