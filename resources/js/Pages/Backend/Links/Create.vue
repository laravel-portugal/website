<template>
  <app-layout :title="$t('app.menu.links-create')">
    <link-form
      :link="link"
      :store-route="route('links.store',{})"
    />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/Backend/AppLayout";
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
