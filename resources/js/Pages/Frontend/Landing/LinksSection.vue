<template>
  <section class="relative w-full">
    <div class="max-w-7xl mx-auto mt-10">
      <page-heading
        title="Explore Links"
        subtitle="Want to follow along? Check our roadmap, and what we have planned for you folks on the next weeks/month. We should be as transparent as possible"
      />
      <!-- Tags Slider-->
      <tags-slider-animation :tags="tags" />
      <!-- Actual Cards for Links -->
      <div class="my-10 max-w-lg mx-auto grid gap-5 lg:grid-cols-4 lg:max-w-none">
        <card-for-frontend
          v-for="link in links"
          :key="link.id"
          :link="link"
          :show-buttons="false"
        />
      </div>
      <!-- Show More button -->
      <div class="px-8 mx-auto max-w-7xl lg:px-12 xl:px-16 text-center">
        <inertia-link
          :href="route('links.public')"
          target="_blank"
          class="mt-3 btn px-4 py-3"
        >
          {{ $t('app.links-show-more') }}
        </inertia-link>
      </div>
    </div>
  </section>
</template>

<script>
import PageHeading from "@/Components/Shared/PageHeading";
import TagsSliderAnimation from "@/Pages/Frontend/Landing/TagsSliderAnimation";
import CardForFrontend from "@/Models/Link/CardForFrontend";
export default {
    components: {
        CardForFrontend,
        TagsSliderAnimation,
        PageHeading
    },
    computed: {
        links(){
            return this.$page.props.links;
        },
        tags(){
            return this.$page.props.tags.data;
        }
    }
}
</script>
