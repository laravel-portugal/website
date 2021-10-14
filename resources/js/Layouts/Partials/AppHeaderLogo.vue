<template>
  <div class="header-logo-wrapper">
    <div class="header-logo-container">
      <inertia-link :href="route('dashboard')">
        <app-logo-color class="block h-8 w-auto" />
      </inertia-link>
    </div>
  </div>
</template>
<script>
import AppLogoColor from "@/Layouts/Partials/AppLogoColor";

export default {
    components: {
        AppLogoColor,
    }
}
</script>
