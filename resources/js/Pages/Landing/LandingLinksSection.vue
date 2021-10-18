<template>
  <section class="relative w-full">
    <div class="max-w-7xl mx-auto mt-10">
      <page-heading
        title="Explore Links"
        subtitle="Want to follow along? Check our roadmap, and what we have planned for you folks on the next weeks/month. We should be as transparent as possible"
      />
      <landing-links-slider />
      <div class="my-10 max-w-lg mx-auto grid gap-5 lg:grid-cols-4 lg:max-w-none">
        <link-card-for-frontend
          v-for="link in $page.props.links"
          :key="link.id"
          :link="link"
          :show-buttons="false"
        />
      </div>
      <div class="px-8 mx-auto max-w-7xl lg:px-12 xl:px-16 text-center">
        <a
          href="#"
          target="_blank"
          class="mt-3 btn px-4 py-3"
        >
          Looking for more?
        </a>
      </div>
    </div>
  </section>
</template>

<script>
import PageHeading from "@/Components/Shared/PageHeading";
import LandingLinksSlider from "@/Pages/Landing/Partials/LandingLinksSlider";
import LinkCardForFrontend from "@/Pages/Links/Partials/LinkCardForFrontend";
export default {
    components: {
        LinkCardForFrontend,
        LandingLinksSlider,
        PageHeading
    }
}
</script>
