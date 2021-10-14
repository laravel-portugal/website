<template>
  <x-input-layout :layout="'naked'">
    <div class="relative flex items-start">
      <div class="flex items-center h-5">
        <input
          :id="name"
          ref="input"
          :checked="isChecked"
          :class="[classVariants]"
          :name="name"
          :value="value"
          class="form-checkbox h-5 w-5"
          type="checkbox"
          v-bind="$attrs"
          @change="updateInput"
        >
      </div>
      <div class="ml-3 text-sm">
        <label
          :for="name"
          class="block text-sm text-gray-900 dark:text-white"
          v-bind="$attrs"
          @click="onClickLabel"
        >
          <slot name="label">
            <div v-html="label" />
          </slot>
        </label>
      </div>
    </div>
    <x-form-errors
      v-if="hasErrors && showErrors"
      :error="errors"
    />
    <x-form-helper
      v-if="help"
      :text="help"
    />
  </x-input-layout>
</template>
<script>
import UseFormInputs from "@/Utils/Mixins/FormInput";
import XInputLayout from "@/Components/Inputs/Layout";
import XFormErrors from "@/Components/Forms/Errors";
import XFormHelper from "@/Components/Forms/Helper";

export default {
    name: 'XInputCheckbox',
    components: {
        XFormHelper,
        XFormErrors,
        XInputLayout
    },
    mixins: [UseFormInputs],
    model: {
        prop: "modelValue",
        event: "change",
    },
    props: {
        value: {},
        modelValue: {
            default: false,
        },
        trueValue: {
            default: true,
        },
        falseValue: {
            default: false,
        },
        searchUsing: {
            type: [String,Number],
            default: 'id'
        }
    },
    emits: ['update:modelValue'],
    computed: {
        isChecked() {
            if (this.modelValue instanceof Array) {
                // Array includes the value
                if(this.modelValue.includes(this.value)){
                    return true;
                }

                // Some item in the model value having the "id" has the value
                if(this.modelValue.some(item => item[this.searchUsing] === this.value)){
                    return true;
                }

                // Value is also an array, lets compare
                if(this.value instanceof Array  && this.modelValue.some(item => item[this.searchUsing] === this.value[this.searchUsing])){
                    return true;
                }
            }

            return this.modelValue === this.trueValue;
        },
        classVariants() {
            return this.hasErrors ? 'danger' : '';
        }
    },
    methods: {
        updateInput(event) {
            let isChecked = event.target.checked;

            if (this.modelValue instanceof Array) {
                let newValue = [...this.modelValue];

                if (isChecked) {
                    newValue.push(this.value);
                } else {
                    newValue.splice(newValue.indexOf(this.value), 1);
                }

                this.$emit("update:modelValue", newValue);
                return;
            }

            this.$emit(
                "update:modelValue",
                isChecked ? this.trueValue : this.falseValue
            );
        },
    },
};
</script>
