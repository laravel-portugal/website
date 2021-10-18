<template>
  <app-layout title="Links">
    <link-form :link="$page.props.link" />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/Backend/AppLayout";
import LinkForm from "@/Models/Link/Form";

export default {
    components: {
        LinkForm,
        AppLayout,
    }
}
</script>
