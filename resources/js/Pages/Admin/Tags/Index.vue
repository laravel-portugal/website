<template>
  <app-layout :title="$t('app.menu.admin-tags')">
    <skeleton class="mb-5" />
    <tags-list :tags="tags" />
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/Backend/AppLayout";
import TagsList from "@/Pages/Admin/Tags/Partials/TagsList";
import Skeleton from "@/Models/Tag/SkeletonCreate";

export default {
    components: {
        TagsList,
        AppLayout,
        Skeleton
    },
    computed:{
        tags(){
            return this.$page.props.tags
        },
    }
}
</script>
