<template>
  <app-head :title="title || $page.props.title" />
  <section class="relative w-full h-72">
    <app-header-video-background />
    <app-header />
    <div class="z-20">
      <slot name="hero" />
    </div>
  </section>
  <curve class="text-white mt-[-10%] z-0 lg:bottom-[-10px]" />
  <main>
    <div class="-mt-28 pb-8 z-30">
      <slot />
    </div>
  </main>
  <app-footer />
</template>

<script>
import AppHead from "@/Layouts/Backend/Partials/AppHead";
import AppHeaderVideoBackground from "@/Layouts/Frontend/Partials/AppHeaderVideoBackground";
import AppHeader from "@/Layouts/Frontend/Partials/AppHeader";
import Curve from "@/Components/Shared/Curve";
import AppFooter from "@/Layouts/Backend/Partials/AppFooter";

export default {
    components: {
        AppFooter,
        Curve,
        AppHeader,
        AppHeaderVideoBackground,
        AppHead
    },
    props: {
        title: {
            type: String,
            required: false,
            default: null,
        },
    },
}
</script>
