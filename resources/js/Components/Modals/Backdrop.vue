<template>
  <div
    aria-hidden="true"
    class="fixed inset-0 transition-opacity"
    @click="$emit('click')"
  >
    <div class="absolute inset-0 bg-gray-500 opacity-75 bg-black bg-opacity-50 dark:bg-opacity-75" />
  </div>
</template>
<script>
export default {
    name: 'XModalBackdrop',
    emits: ['click'],
}
</script>
