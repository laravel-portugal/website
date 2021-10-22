<template>
  <top-section id="top" />
  <links-section id="links" />
  <app-footer />
</template>

<script>
import TopSection from "@/Pages/Frontend/Landing/TopSection";
import LinksSection from "@/Pages/Frontend/Landing/LinksSection";
import AppFooter from "@/Layouts/Frontend/Partials/AppFooter";

export default {
    components: {
        TopSection,
        LinksSection,
        AppFooter,
    }
}
</script>
