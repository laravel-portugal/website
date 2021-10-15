<template>
  <div class="relative">
    <div class="absolute inset-0">
      <video
        autoplay
        loop
        muted
        class="w-full h-full object-cover"
      >
        <source
          class="w-full"
          src="img/videos/hero.mp4"
          type="video/mp4"
        >
        <source
          class="w-full"
          src="img/videos/hero.mp4"
          type="video/webm"
        >
        <img
          class="h-full w-full object-cover"
          src="img/headers/home.jpg"
          title="Your browser does not support the <video> tag"
          alt="Laravel Portugal"
        >
      </video>
      <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-primary-500 to-yellow-200 mix-blend-multiply" />
    </div>
    <landing-header />
    <landing-hero />
  </div>
</template>

<script>
import LandingHeader from "@/Pages/Landing/LandingHeader";
import LandingHero from "@/Pages/Landing/LandingHero";
export default {
    components: {LandingHero, LandingHeader}
}
</script>
