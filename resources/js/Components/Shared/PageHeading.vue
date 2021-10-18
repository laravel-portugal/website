<template>
  <div class="relative mb-10">
    <h3
      data-aos="fade-down"
      class="text-5xl font-bold leading-tight md:text-6xl lg:text-7xl xl:text-7xl xl:leading-tight text-center tracking-wide font-roboto aos-init aos-animate"
    >
      {{ title }}
    </h3>
    <div class="text-gray-400 text-center max-w-2xl mx-auto mt-4">
      {{ subtitle }}
    </div>
  </div>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        subtitle: {
            type: String,
            required: false,
            default: '',
        },
    },
}
</script>
