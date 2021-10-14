<template>
  <x-dropdown
    :overlay="true"
    align="right"
    class="relative"
    width="48"
  >
    <template #trigger>
      <button
        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-indigo-600 transition duration-150 ease-in-out"
      >
        <span class="inline-block relative">
          <img
            v-if="$page.props.user.profile_photo_url"
            :alt="$page.props.user.name"
            :src="$page.props.user.profile_photo_url"
            class="h-8 w-8 rounded-full"
          >
          <span
            v-else
            class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100"
          >
            <span class="text-sm font-light leading-none text-indigo-800">{{ $page.props.user.name_letters }}</span>
          </span>
        </span>
      </button>
    </template>

    <template #default>
      <!-- Account Management -->
      <div class="block px-4 py-2 text-xs text-gray-400">
        {{ $t('app.menu.user-account') }}
      </div>

      <inertia-link
        class="dropdown-item"
        :href="route('profile.show')"
      >
        {{ $t('app.menu.user-profile') }}
      </inertia-link>

      <inertia-link
        v-if="$page.props.jetstream.hasApiFeatures"
        class="dropdown-item"
        :href="route('api-tokens.index')"
      >
        {{ $t('app.menu.api-tokens') }}
      </inertia-link>

      <div class="mt-2 border-t border-gray-100 dark:border-gray-700" />

      <!-- Authentication -->
      <button
        class="dropdown-item w-full flex items-start"
        @click.prevent="logout"
      >
        {{ $t('app.menu.logout') }}
      </button>
    </template>
  </x-dropdown>
</template>

<script>
import XDropdown from "@/Components/Menus/Dropdown";

export default {
    components: {
        XDropdown,
    },
    methods: {
        switchToTeam(team) {
            this.$inertia.put('/current-team', {
                'team_id': team.id
            }, {
                preserveState: false
            })
        },
        logout() {
            this.axios.post('/logout').then(response => {
                window.location = '/';
            })
        },
    },
}
</script>
