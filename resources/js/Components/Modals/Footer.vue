<template>
  <div
    :class="{
      'grid-with-1-columns' : itemsCount === 1,
      'grid-with-2-columns space-y-2 sm:space-y-0' : itemsCount === 2,
      'grid-with-3-columns' : itemsCount === 3,
      'border-t border-gray-200 dark:border-gray-700': divided
    }"
    class="px-4 py-5"
  >
    <slot />
  </div>
</template>
<script>
export default {
    name: 'XModalFooter',
    props: {
        divided: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            itemsCount: 0,
        }
    },
    mounted() {
        // Ensure we set the amount of items in footer
        this.itemsCount = this.$el.children?.length || 0;
    },
}
</script>
