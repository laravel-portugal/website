<template>
  <header>
    <navigation-mobile />
    <navigation-desktop />
  </header>
</template>

<script>
import NavigationMobile from "@/Pages/Landing/Partials/NavigationMobile";
import NavigationDesktop from "@/Pages/Landing/Partials/NavigationDesktop";

export default {
    components: {
        NavigationDesktop,
        NavigationMobile,
    },
}
</script>
