<template>
  <footer class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
      <nav
        class="-mx-5 -my-2 flex flex-wrap justify-center"
        aria-label="Footer"
      >
        <div
          v-for="item in navigation"
          :key="item.name"
          class="px-5 py-2"
        >
          <component
            :is="$page.component === 'Frontend/Landing/Index' ? 'a' : 'InertiaLink'"
            :href="item.href"
            class="text-base text-gray-500 hover:text-gray-900"
          >
            {{ item.name }}
          </component>
        </div>
      </nav>
      <div class="mt-8 flex justify-center space-x-6">
        <a
          v-for="network in socialNetworks"
          :key="network.name"
          :href="network.link"
          target="_blank"
          rel="nofollow"
          class="text-gray-400 hover:text-gray-500"
        >
          <span class="sr-only">{{ $t(network.name) }}</span>
          <font-awesome-icon
            :icon="['fab',''+network.icon+'']"
            class="h-6 w-6 text-md mr-1"
            area-hidden="true"
          />
        </a>
      </div>
      <p class="mt-8 text-center text-base text-gray-400">
        {{ }}
      </p>
    </div>
  </footer>
</template>

<script>
import {socialNetworks} from "@/Utils/useSocialNetworks";
export default {
    computed: {
        socialNetworks(){
            return socialNetworks.value;
        },
        copyright(){
            return this.$t('app.copyright',{ year: new Date().getFullYear(),site_name: this.$page.props.meta.site_name})
        },
        navigation() {
            return [
                { name: this.$t('app.menu_landing.home'), href: '#top' },
                { name: this.$t('app.menu_landing.links'), href: '#links' },
                { name: this.$t('app.menu_landing.login'), href: this.route('login') },
                { name: this.$t('app.menu_landing.register'), href: this.route('register') },
                { name: this.$t('app.menu_landing.tos'), href: this.route('terms.show') },
                { name: this.$t('app.menu_landing.privacy'), href: this.route('policy.show') },
            ];
        }
    },
}
</script>
