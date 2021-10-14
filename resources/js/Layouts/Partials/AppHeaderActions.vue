<template>
  <div class="header-actions">
    <!-- Profile dropdown -->
    <div class="flex-shrink-0 relative">
      <app-menu-profile-dropdown />
    </div>
  </div>
</template>
<script>
import AppMenuProfileDropdown from "@/Layouts/Partials/AppMenuProfileDropdown";

export default {
    components: {
        AppMenuProfileDropdown,
    }
}
</script>
