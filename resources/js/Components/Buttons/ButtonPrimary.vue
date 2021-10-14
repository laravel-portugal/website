<template>
  <component
    :is="as"
    :class="{
      'btn-primary': variant === 'primary',
      'btn-danger': variant === 'danger',
      'btn': variant === 'secondary',
    }"
    @click="$emit('click',$event)"
  >
    <span class="flex items-center space-x-1">
      <slot />
    </span>
  </component>
</template>
<script>

export default {
    props: {
        variant: {
            type: String,
            required: false,
            default: 'primary',
        },
        as: {
            type: String,
            required: false,
            default: 'button',
        }
    },
    emits: ['click'],
}
</script>
