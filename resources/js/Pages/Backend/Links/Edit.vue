<template>
  <app-layout title="Links">
    <link-form :link="$page.props.link" />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import LinkForm from "@/Pages/Links/Link";

export default {
    components: {
        LinkForm,
        AppLayout,
    }
}
</script>
