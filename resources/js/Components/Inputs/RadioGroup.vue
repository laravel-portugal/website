<template>
  <x-input-layout :layout="layout">
    <template #label>
      <slot
        v-if="$slots.label || label"
        name="label"
      >
        <x-form-label
          :for="name"
          :value="label"
        />
      </slot>
    </template>

    <div
      class="relative flex-1"
    >
      <RadioGroup
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue',$event)"
      >
        <div
          class="rounded-lg"
          :class="{
            'space-y-2': separated,
            '-space-y-px': !separated
          }"
        >
          <RadioGroupOption
            v-for="(option,index) in options"
            :key="option.value"
            v-slot="{ active, checked }"
            as="div"
            :value="option.value"
            class="rounded-lg"
          >
            <div
              :class="{
                'ring-2 ring-offset-2 ring-offset-white dark:ring-offset-gray-900 ring-primary-600 border border-primary-200 dark:bg-primary-500 dark:border-primary-500 z-10' : active,
                'border border-gray-200 dark:border-gray-700' : !active,
                'bg-primary-100 dark:bg-primary-500 text-white border-primary-200 dark:border-primary-500 z-10' : checked,
                'bg-white dark:bg-gray-900': !checked,
                'rounded-tl-lg rounded-tr-lg': !separated && index === 0,
                'rounded-bl-lg rounded-br-lg': !separated && index === options.length - 1,
                'rounded-lg': separated
              }"
              class="relative flex px-5 py-4 cursor-pointer focus:outline-none"
            >
              <!-- If its a checkbox layout -->
              <span
                v-if="radio"
                :class="[
                  checked ? 'bg-primary-600 border-transparent dark:bg-primary-700 ring-offset-white dark:ring-offset-gray-700' : 'bg-white border-gray-300',
                  active ? 'ring-2 ring-offset-2 ring-primary-500' : '',
                  'h-4 w-4 mt-0.5 cursor-pointer rounded-full border flex items-center justify-center'
                ]"
                class="mr-3"
                aria-hidden="true"
              >
                <span class="rounded-full bg-white w-1.5 h-1.5" />
              </span>
              <!-- Main Content -->
              <div class="flex items-center justify-between w-full">
                <div class="flex items-center">
                  <div class="text-sm">
                    <RadioGroupLabel
                      as="p"
                      :class="checked ? 'font-bold text-primary-900 dark:text-white' : 'font-normal text-gray-900 dark:text-white'"
                      class="font-medium"
                      v-html="option.label"
                    />
                    <RadioGroupDescription
                      as="span"
                      :class="checked ? 'text-primary-700 dark:text-gray-200' : 'text-gray-500 dark:text-gray-400'"
                      class="inline"
                    >
                      <span
                        v-if="option?.description"
                        v-html="option?.description"
                      />
                    </RadioGroupDescription>
                  </div>
                </div>
                <!-- Checked but not radio style -->
                <div
                  v-show="checked && !radio"
                  class="flex-shrink-0"
                >
                  <svg
                    class="w-6 h-6"
                    viewBox="0 0 24 24"
                    fill="none"
                  >
                    <circle
                      cx="12"
                      cy="12"
                      r="12"
                      :fill="['#4f46e5']"
                      :fill-opacity="['0.9']"
                    />
                    <path
                      d="M7 13l3 3 7-7"
                      stroke="#fff"
                      stroke-width="1.5"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </div>
              </div>
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
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
import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupDescription,
    RadioGroupOption,
} from '@headlessui/vue'
import XInputLayout from "@/Components/Inputs/Layout";
import XFormErrors from "@/Components/Forms/Errors";
import XFormHelper from "@/Components/Forms/Helper";
import XFormLabel from "@/Components/Forms/FormLabel";

export default {
    name: 'XRadioGroup',
    components: {
      XFormLabel,
      XFormHelper,
      XFormErrors,
      XInputLayout,
      RadioGroup,
      RadioGroupLabel,
      RadioGroupDescription,
      RadioGroupOption,
    },
    mixins: [UseFormInputs],
    props: {
        options: {
            type: [Object, Array],
            required: true,
            default: () => {
                return [];
            }
        },
        modelValue: {
            default: '',
            required: true,
        },
        separated: {
            type: Boolean,
            default: false,
        },
        radio: {
            type: Boolean,
            default: false,
        }
    },
    emits: [
        'update:modelValue',
    ],
    methods: {
        isActive(option) {
            return this.selected.value === option.value
        },
        change(option) {
            if (option !== this.selected) {
                this.selected = option;
            }
        }
    }
}
</script>
