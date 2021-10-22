<template>
  <app-layout title="Tags">
    <tag-form
      :tag="tag"
      :update-route="route('admin.tags.update',{tag: tag})"
      :delete-route="route('admin.tags.destroy',{tag: tag})"
      :restore-route="route('admin.tags.restore',{tag: tag})"
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
