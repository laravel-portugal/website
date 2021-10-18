<template>
  <app-layout title="Links">
    <!-- Search Bar -->
    <links-search />
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
        }
    }
}
</script>
