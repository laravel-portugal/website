<template>
  <div
    :class="{
      'pt-4 sm:pt-6': !icon
    }"
    class="mb-3"
  >
    <slot
      v-if="icon"
      name="icon"
    >
      <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-primary-200">
        <i class="fal fa-info-circle text-lg text-gray-800" />
      </div>
    </slot>
    <div
      :class="{
        'mt-2 sm:mt-5': icon
      }"
      class=" text-center "
    >
      <h3 class="modal-title">
        <slot />
      </h3>
    </div>
  </div>
</template>

<script>
export default {
    name: 'XModalHeader',
    props: {
        icon: {
            type: Boolean,
            default: false,
            required: false
        }
    }
}
</script>
