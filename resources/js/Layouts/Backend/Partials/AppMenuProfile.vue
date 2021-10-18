<template>
  <div class="flex-shrink-0 flex border-t border-gray-200 dark:border-gray-800 p-4">
    <inertia-link
      :href="route('profile.show')"
      class="flex-shrink-0 w-full group block"
    >
      <div class="flex items-center">
        <user-profile-picture :user="$page.props.user" />
        <div class="ml-3">
          <p class="text-sm leading-5 font-medium text-gray-600">
            {{ $page.props.user.name }}
          </p>
          <p class="text-xs leading-4 font-medium text-gray-400 group-hover:text-gray-500 group-hover:underline transition ease-in-out duration-150">
            {{ $t('menu.user-view-profile') }}
          </p>
        </div>
      </div>
    </inertia-link>
  </div>
</template>
<script>
import UserProfilePicture from "@/Components/Shared/UserProfilePicture";
export default {
    components: {UserProfilePicture}
}
</script>
