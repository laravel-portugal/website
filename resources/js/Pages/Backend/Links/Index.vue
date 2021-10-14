<template>
  <app-layout title="Links">
    <links-list :links="$page.props.links" />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import LinksList from "@/Pages/Backend/Links/Partials/LinksList";

export default {
    components: {
        AppLayout,
        LinksList
    },
}
</script>
