<template>
  <section class="relative w-full">
    <app-header-video-background />
    <app-header />
    <hero />
    <curve class="mt-[-10%] text-white" />
  </section>
</template>

<script>
import AppHeader from "@/Layouts/Frontend/Partials/AppHeader";
import Curve from "@/Components/Shared/Curve";
import AppHeaderVideoBackground from "@/Layouts/Frontend/Partials/AppHeaderVideoBackground";
import Hero from "@/Pages/Frontend/Landing/Hero";
export default {
    components: {
        AppHeader,
        Hero,
        AppHeaderVideoBackground,
        Curve,
    }
}
</script>
