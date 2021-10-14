<template>
  <div
    :class="{
      'divide-y divide-gray-200': divide,
      'space-y-6 sm:space-y-5': spaced,
      'bg-gray-50 dark:bg-gray-800': bodyClasses === undefined
    }"
  >
    <slot />
  </div>
</template>

<script>
export default {
    name: "XFormContainer",
    props: {
        divide: {
            type: Boolean,
            default: true,
        },
        spaced: {
            type: Boolean,
            default: false,
        },
        bodyClasses: {
            type: String,
            default: undefined
        }
    },
}
</script>
