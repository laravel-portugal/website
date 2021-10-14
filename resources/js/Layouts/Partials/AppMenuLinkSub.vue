<template>
  <inertia-link
    :class="classes"
    :href="href"
    class="w-full pl-6 px-1"
  >
    <slot />
  </inertia-link>
</template>
<script>
export default {
    props: {
        href: {
            type: String,
            required: true,
        },
        active: {
            type: [Boolean, Number],
            required: false,
            default: false,
        },

    },
    computed: {
        classes() {
            return this.active
                ? 'group btn-menu active select-none'
                : 'group btn-menu select-none'
        }
    },
}
</script>
