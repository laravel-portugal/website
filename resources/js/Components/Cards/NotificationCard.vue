<template>
  <div class="py-5 mx-auto">
    <div class="bg-white shadow-lg rounded-lg sm:rounded-lg dark:bg-gray-750 dark:text-white dark:shadow-dark-xl">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
          <slot name="title">
            <span v-html="title" />
          </slot>
        </h3>
        <div class="mt-2 sm:flex sm:items-start sm:justify-between">
          <div class="w-full text-sm leading-5 text-gray-500 dark:text-gray-400">
            <p>
              <slot name="content">
                <span v-html="content" />
              </slot>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: false,
            default: ''
        },
        content: {
            type: String,
            required: false,
            default: ''
        }
    }
}
</script>
