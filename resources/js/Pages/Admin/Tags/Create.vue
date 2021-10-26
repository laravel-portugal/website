<template>
  <app-layout :title="$t('app.menu.tags-create')">
    <tag-form
      :tag="tag"
      :store-route="route('admin.tags.store')"
    />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/Backend/AppLayout";
import TagForm from "@/Models/Tag/Form";

export default {
    components: {
        TagForm,
        AppLayout,
    },
    computed:{
        tag(){
            return this.$page.props.tag;
        }
    }
}
</script>
