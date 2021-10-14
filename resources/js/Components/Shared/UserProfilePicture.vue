<template>
  <div>
    <img
      v-if="user.profile_photo_url"
      :alt="user.name"
      :src="user.profile_photo_url"
      class="inline-block rounded-full"
      :class="size"
    >
    <span
      v-else
      class="inline-flex items-center justify-center rounded-full bg-indigo-100"
      :class="size"
    >
      <span
        class="font-light leading-none text-indigo-800"
        :class="textSize"
      >{{ user.name_letters }}</span>
    </span>
  </div>
</template>

<script>
export default {
    props: {
        user: {
            type: [Object, Array],
            required: true,
        },
        size: {
            type: [String],
            default: 'h-9 w-9',
            required: false,
        },
        textSize: {
            type: [String],
            default: 'text-sm',
            required: false,
        }
    },
}
</script>
