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
          @click.prevent="selectNewPhoto"
        />
      </slot>
    </template>

    <input
      :id="name"
      ref="photo"
      class="hidden"
      type="file"
      @change="updatePhotoPreview"
    >

    <!-- Current Profile Photo -->
    <div
      v-show="! photoPreview"
      class="mt-2"
    >
      <img
        v-if="$page.props.user.profile_photo_url"
        :src="$page.props.user.profile_photo_url"
        alt="Current Profile Photo"
        class="rounded-full h-20 w-20 object-cover"
      >
      <span
        v-else
        class="inline-flex items-center justify-center rounded-full h-20 w-20 rounded-full bg-indigo-100"
      >
        <span class="text-sm font-light leading-none text-indigo-800">{{ $page.props.user.name_letters }}</span>
      </span>
    </div>

    <!-- New Profile Photo Preview -->
    <div
      v-show="photoPreview"
      class="mt-2"
    >
      <span
        :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"
        class="block rounded-full w-20 h-20"
      />
    </div>

    <button-primary
      class="mt-2"
      type="button"
      variant="secondary"
      @click="selectNewPhoto"
    >
      Upload Photo
    </button-primary>

    <!-- Errors -->
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
import XInputLayout from "@/Components/Inputs/Layout";
import UseFormInputs from "@/Utils/Mixins/FormInput";
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";
import XFormErrors from "@/Components/Forms/Errors";
import XFormHelper from "@/Components/Forms/Helper";
import XFormLabel from "@/Components/Forms/FormLabel";

export default {
    name: "XProfilePhoto",
    components: {
        XFormLabel,
        XFormHelper,
        XFormErrors,
        ButtonPrimary,
        XInputLayout
    },
    mixins: [UseFormInputs],
    model: {
        prop: "modelValue",
        event: "change",
    },
    props: {
        photo: {
            type: String,
            default: () => {
                return this.$page.props.user.profile_photo_url
            }
        }
    },
    emits: [
        'update:modelValue'
    ],
    data() {
        return {
            photoPreview: null,
        }
    },
    methods: {
        selectNewPhoto() {
            this.$refs.photo.click();
        },
        updatePhotoPreview() {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            this.$emit("update:modelValue", this.$refs.photo.files[0]);

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },
    }
}
</script>
