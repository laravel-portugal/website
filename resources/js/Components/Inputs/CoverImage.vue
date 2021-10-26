<template>
  <x-input-layout :layout="layout">
    <template #label>
      <slot
        v-if="$slots.label || label"
        name="label"
      >
        <x-form-label
          :label-for="name"
          :value="label"
          @click.prevent="selectNewPhoto"
        />
      </slot>
    </template>

    <div class="mt-1 sm:mt-0 sm:col-span-2">
      <div
        class="h-64 flex justify-center px-6 pt-5 pb-6 rounded-md relative cursor-pointer group flex items-center"
        :class="{
          'border-2 border-gray-300 border-dashed': !preview,
          'shadow-md': preview
        }"
        :style="backgroundStyle"
      >
        <input
          :id="name"
          ref="photo"
          name="file-upload"
          type="file"
          class="absolute inset-0 z-50 m-0 p-0 w-full h-full opacity-0 cursor-pointer"
          @change="updatePhotoPreview"
        >
        <!-- Blank State Not Loading -->
        <div
          v-show="!loading"
          class="space-y-1 text-center p-4"
          :class="{'bg-white rounded-lg opacity-0 group-hover:opacity-100 group-hover:shadow-lg': preview}"
        >
          <upload-icon class="mx-auto h-12 w-12 text-gray-400" />

          <div class="flex text-sm text-gray-600">
            <label
              for="file-upload"
              class="relative cursor-pointer bg-transparent rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
            >
              <span>Upload a file a image file</span>
            </label>
            <p class="pl-1">
              or drag and drop
            </p>
          </div>
          <p class="text-xs text-gray-500">
            PNG, JPG, GIF up to 2MB
          </p>
        </div>

        <!-- Blank State Loading -->
        <div
          v-show="loading"
          class="space-y-1 text-center p-4 rounded-lg"
        >
          <refresh-icon class="mx-auto h-12 w-12 text-gray-400 animate-spin" />

          <div class="flex text-sm text-gray-600">
            <label
              for="file-upload"
              class="relative cursor-pointer bg-transparent rounded-md font-medium text-gray-400"
            >
              <span>🤞 Please Wait, we are attempting to grab your stuff</span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-2 flex items-center mx-auto space-x-2">
      <button-primary
        v-if="preview"
        variant="danger"
        @click.prevent="onDeletePhoto"
      >
        Delete Photo
      </button-primary>
      <button-primary
        v-if="hasOpenGraph"
        variant="secondary"
        @click.prevent="onSwitchToOpenGraph"
      >
        Use from OpenGraph
      </button-primary>
    </div>

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
import XFormErrors from "@/Components/Forms/Errors";
import XFormHelper from "@/Components/Forms/Helper";
import XFormLabel from "@/Components/Forms/FormLabel";
import {UploadIcon, RefreshIcon} from '@heroicons/vue/outline';
import useFiles from "@/Utils/useFileInputs";
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";

export default {
    name: "XCoverPhoto",
    components: {
        ButtonPrimary,
        XFormLabel,
        XFormHelper,
        XFormErrors,
        XInputLayout,
        UploadIcon,
        RefreshIcon
    },
    mixins: [UseFormInputs],
    model: {
        prop: "modelValue",
        event: "change",
    },
    props: {
        photoPreviewRaw: {
            default: null,
        },
        photoPreviewUrl: {
            type: [String],
            default: null,
        },
        hasOpenGraph:{
            type: Boolean,
            default: false
        },
        loading:{
            type: Boolean,
            default: false
        }
    },
    emits: [
        'update:modelValue',
        'opengraph',
        'delete',
    ],
    data() {
        return {
            preview: null,
        }
    },
    computed: {
        backgroundStyle(){
            if(this.preview){
                return 'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\''+this.preview +'\');'
            }
            return '';
        }
    },
    watch: {
        'photoPreviewRaw': {
            immediate: true,
            handler: function (value) {
                if(value === null){
                    this.preview = null;
                    return;
                }
                this.$refs.photo.files = useFiles.filesToFileList([value])
                this.updatePhotoPreview();
            }
        },
        'photoPreviewUrl': {
            immediate: true,
            handler: function (value) {
                if(value !== null){
                    this.preview = value;
                }
            }
        },
    },
    methods: {
        selectNewPhoto() {
            this.$refs.photo.click();
        },
        onDeletePhoto(){
            this.preview = null;
            this.$refs.photo.value = null;
            this.$emit('delete')
        },
        onSwitchToOpenGraph(){
            this.preview = null;
            this.$refs.photo.value = null;
            this.$emit('opengraph')
        },
        updatePhotoPreview() {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.preview = e.target.result;
            };
            this.$emit("update:modelValue", this.$refs.photo.files[0]);
            reader.readAsDataURL(this.$refs.photo.files[0]);
        },
    }
}
</script>
