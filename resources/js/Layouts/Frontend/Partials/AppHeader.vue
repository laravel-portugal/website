<template>
  <header>
    <app-menu-mobile />
    <app-menu-desktop />
  </header>
</template>

<script>
import AppMenuMobile from "@/Layouts/Frontend/Partials/AppMenuMobile";
import AppMenuDesktop from "@/Layouts/Frontend/Partials/AppMenuDesktop";

export default {
    components: {
        AppMenuMobile,
        AppMenuDesktop,
    },
}
</script>
