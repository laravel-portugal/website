<template>
  <!-- SEO Stuff -->
  <app-head :title="$page.props.title || $t('app.seo.frontend-landing-title')">
    <meta
      name="description"
      :content="$t('app.seo.frontend-landing-description')"
    >
  </app-head>
  <!-- Hero and Menu -->
  <top-section id="top" />
  <links-section id="links" />
  <app-footer />
</template>

<script>
import AppHead from "@/Layouts/Backend/Partials/AppHead";
import TopSection from "@/Pages/Frontend/Landing/TopSection";
import LinksSection from "@/Pages/Frontend/Landing/LinksSection";
import AppFooter from "@/Layouts/Frontend/Partials/AppFooter";

export default {
    components: {
        TopSection,
        LinksSection,
        AppFooter,
        AppHead
    }
}
</script>
