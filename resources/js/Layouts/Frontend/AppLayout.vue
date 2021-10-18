<template>
  <app-head :title="title || $page.props.title" />
  <section class="relative w-full">
    <app-header-video-background />
    <app-header />

    <div class="-mt-24 pb-8">
      <slot />
    </div>

    <curve class="mt-[-10%] text-white" />
  </section>
</template>

<script>
import AppHead from "@/Layouts/Backend/Partials/AppHead";
import AppHeaderVideoBackground from "@/Layouts/Frontend/Partials/AppHeaderVideoBackground";
import AppHeader from "@/Layouts/Frontend/Partials/AppHeader";
import Curve from "@/Components/Shared/Curve";

export default {
    components: {
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

    data() {
        return {
            showMenu: false,
        }
    },
}
</script>
