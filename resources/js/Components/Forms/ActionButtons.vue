<template>
  <div class="space-x-2 flex items-center">
    <!-- Success Message -->
    <x-form-action-message
      v-if="withSuccessMessage"
      :on="form.recentlySuccessful"
    />

    <!-- Reset The form  -->
    <button-primary
      v-if="withReset"
      variant="secondary"
      @click.prevent="reset"
    >
      {{ resetText }}
    </button-primary>

    <!-- Cancel the form  -->
    <button-primary
      v-if="withCancel"
      variant="secondary"
      class="sm:col-start-1 w-full sm:mt-0 mt-3"
      type="button"
      @click="$emit('canceled')"
    >
      {{ nevermindText }}
    </button-primary>

    <!-- Submit/Save -->
    <button-loading
      :invalid="!form.isDirty && !submitAlwaysEnable"
      :loading="form.processing"
    >
      {{ submitText }}
    </button-loading>
  </div>
</template>

<script>
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";
import XFormActionMessage from "@/Components/Forms/ActionMessage";

export default {
    name: "XFormActionButtons",
    components: {
        XFormActionMessage,
        ButtonPrimary,
        ButtonLoading,
    },
    props: {
        form: {
            type: Object,
            required: true
        },
        withReset: {
            type: Boolean,
            default: true
        },
        withCancel: {
            type: Boolean,
            default: false
        },
        withSuccessMessage: {
            type: Boolean,
            default: true
        },
        submitAlwaysEnable: {
            type: Boolean,
            default: false
        },
        submitLabel: {
            type: String,
            required: false,
            default: '',
        },
        resetLabel: {
            type: String,
            required: false,
            default: '',
        },
        nevermindLabel: {
            type: String,
            required: false,
            default: '',
        },
        forceLoadingWhen:{
            type: Boolean,
            required: false,
            default: false,
        }
    },
    emits: ['canceled','reset'],
    computed: {
        submitText(){
            return this.submitLabel || 'Save';
        },
        resetText(){
            return this.resetLabel || 'Reset';
        },
        nevermindText(){
            return this.nevermindLabel || 'Nevermind';
        },
    },
    methods:{
        reset(){
            this.form.reset();
            this.$emit('reset');
        }
    }
}
</script>
