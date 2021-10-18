<template>
  <app-layout title="Links">
    <link-form :link="link" />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import LinkForm from "@/Models/Link/Form";

export default {
    components: {
        LinkForm,
        AppLayout,
    },
    computed:{
        link(){
            return this.$page.props.link;
        }
    }
}
</script>
