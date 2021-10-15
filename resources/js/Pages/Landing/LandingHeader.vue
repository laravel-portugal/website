<template>
  <header>
    <navigation-mobile />
    <navigation-desktop />
  </header>
</template>

<script>
import NavigationMobile from "@/Pages/Landing/NavigationMobile";
import NavigationDesktop from "@/Pages/Landing/NavigationDesktop";

export default {
    components: {
        NavigationDesktop,
        NavigationMobile,
    },
}
</script>
