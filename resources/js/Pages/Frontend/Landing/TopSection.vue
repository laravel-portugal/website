<template>
  <section class="relative w-full">
    <div class="absolute inset-0">
      <video
        autoplay
        loop
        muted
        class="w-full h-full object-cover"
      >
        <source
          class="w-full"
          src="img/videos/portugal.mp4"
          type="video/mp4"
        >
        <source
          class="w-full"
          src="img/videos/portugal.webm"
          type="video/webm"
        >
        <img
          class="h-full w-full object-cover"
          src="img/videos/portugal.jpg"
          title="Your browser does not support the <video> tag"
          alt="Laravel Portugal"
        >
      </video>
      <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-primary-500 to-yellow-200 mix-blend-multiply" />
    </div>
    <landing-header />
    <landing-hero />
    <curve class="mt-[-10%] text-white" />
  </section>
</template>

<script>
import LandingHeader from "@/Pages/Landing/Partials/LandingHeader";
import LandingHero from "@/Pages/Landing/Partials/LandingHero";
import Curve from "@/Components/Shared/Curve";
export default {
    components: {
        Curve,
        LandingHero,
        LandingHeader
    }
}
</script>
