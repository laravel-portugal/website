<template>
  <div class="max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
    <link-card-create />
    <link-card-for-user
      v-for="link in links"
      :key="link.id"
      :link="link"
    />
  </div>
</template>
<script>
import LinkCardCreate from "@/Pages/Links/Partials/LinkCardCreate";
import LinkCardForUser from "@/Pages/Links/Partials/LinkCardForUser";
export default {
    components: {
        LinkCardForUser,
        LinkCardCreate,
    },
    computed: {
       links(){
           return this.$page.props.links.data
       }
   }
}
</script>
