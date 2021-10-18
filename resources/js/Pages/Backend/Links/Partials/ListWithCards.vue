<template>
  <div class="max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
    <skeleton-create />
    <link-card
      v-for="link in links"
      :key="link.id"
      :link="link"
    />
  </div>
</template>
<script>
import SkeletonCreate from "@/Models/Link/SkeletonCreate";
import LinkCard from "@/Models/Link/CardForBackend";
export default {
    components: {
        SkeletonCreate,
        LinkCard,
    },
    computed: {
       links(){
           return this.$page.props.links.data
       }
   }
}
</script>
