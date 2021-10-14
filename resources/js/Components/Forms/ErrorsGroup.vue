<template>
  <div v-if="hasErrors">
    <div
      class="font-medium text-red-600"
      v-html="errorsTitle"
    />
    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
      <li
        v-for="(error, key) in errors"
        :key="key"
      >
        {{ error }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
    name: 'XFormErrorsGroup',
    props: {
        errorsTitle: {
            type: String,
            required: false,
            default: 'The following errors occurred.',
        },
    },
    computed: {
        errors() {
            return this.$page.props.errors
        },
        hasErrors() {
            return Object.keys(this.errors).length > 0;
        },
    }
}
</script>
