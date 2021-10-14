<template>
  <app-layout title="Links">
    <list-empty-state v-if="!hasLinks" />
    <list-with-cards v-else />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import ListEmptyState from "@/Pages/Links/Partials/ListEmptyState";
import ListWithCards from "@/Pages/Links/Partials/ListWithCards";

export default {
    components: {
        ListWithCards,
        ListEmptyState,
        AppLayout,
    },
    computed:{
        hasLinks(){
            return this.$page.props?.links?.data.length > 0
        }
    }
}
</script>
