<template>
  <inertia-link
    :class="classes"
    :href="href"
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
                ? 'group btn-menu active px-2 py-3'
                : 'group btn-menu px-2 py-3'
        }
    },
}
</script>
