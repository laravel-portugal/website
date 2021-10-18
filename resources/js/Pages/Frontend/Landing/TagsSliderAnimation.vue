<template>
  <div class="slider p-2">
    <div class="slide-track space-x-7">
      <div
        v-for="tag in tags"
        :key="tag.id"
        class="slide"
      >
        <div class="relative rounded-lg border border-gray-300 bg-white px-6 py-3 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
          <div class="flex-1 min-w-0">
            <inertia-link
              :href="route('links.public',{tag: tag.slug})"
              class="focus:outline-none text-center"
            >
              <span
                class="absolute inset-0"
                aria-hidden="true"
              />
              <h3 class="text-sm text-gray-900 font-bold font-roboto">
                {{ tag.name }}
              </h3>
              <p class="text-sm text-gray-500 truncate mt-1 max-w-[100px]">
                {{ tag.description }}
              </p>
            </inertia-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        tags: {
            type: [Object,Array],
            required: true,
        },
    },
}
</script>
