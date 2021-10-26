<template>
  <inertia-head :title="title">
    <slot />
  </inertia-head>
</template>
<script>
import { Head as InertiaHead } from '@inertiajs/inertia-vue3'
export default {
    name: "AppHead",
    components: {
        InertiaHead
    },
    props: {
        title: {
            type: [String, Number],
            default: ''
        }
    }
}
</script>
