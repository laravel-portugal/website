<template>
  <landing-top-section id="top" />
  <landing-links-section id="links" />
  <landing-discord-section id="discord" />
  <app-footer />
</template>

<script>
import AppFooter from "@/Layouts/Partials/AppFooter";
import LandingLinksSection from "@/Pages/Landing/LandingLinksSection";
import LandingDiscordSection from "@/Pages/Landing/LandingDiscordSection";
import LandingTopSection from "@/Pages/Landing/LandingTopSection";

export default {
    components: {
        LandingTopSection,
        LandingDiscordSection,
        LandingLinksSection,
        AppFooter,
    }
}
</script>
