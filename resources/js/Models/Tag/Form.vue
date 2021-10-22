<template>
  <form @submit.prevent="submit()">
    <x-card
      :title="editing ? $t('app.tags-edit-title') : $t('app.tags-create-title')"
      :subtitle="editing ? $t('app.tags-edit-subtitle') : $t('app.tags-create-subtitle')"
    >
      <template #actions>
        <div
          v-if="editing"
          class="inline-flex"
        >
          <inertia-link
            v-if="tag.deleted_at === null"
            :href="deleteRoute"
            as="button"
            class="btn"
            method="delete"
          >
            {{ $t('app.delete') }}
          </inertia-link>
          <inertia-link
            v-if="tag.deleted_at !== null"
            :href="restoreRoute"
            as="button"
            class="btn"
            method="delete"
          >
            {{ $t('app.delete') }}
          </inertia-link>
        </div>
      </template>

      <input
        v-model="form.id"
        class="hidden"
        readonly
        type="hidden"
      >

      <x-form-container>
        <x-input-text
          v-model="form.name"
          :label="$t('app.tags.name')"
          :placeholder="$t('placeholders.name')"
          :errors="form.errors.name"
          name="name"
          autocomplete="name"
          required
        />

        <x-input-text
          v-model="form.slug"
          :label="$t('app.tags.slug')"
          :placeholder="$t('placeholders.slug')"
          :errors="form.errors.slug"
          name="slug"
          autocomplete="slug"
          required
        />

        <x-input-text-area
          v-model="form.description"
          :label="$t('app.tags.description')"
          :placeholder="$t('placeholders.tag_description')"
          :errors="form.errors.description"
          name="description"
          autocomplete="description"
          required
        />

        <x-select
          v-model="form.color"
          :label="$t('app.tags.color')"
          :options="$page.props.guidelines.tags.color_options"
          name="color"
          :show-empty="true"
        />
      </x-form-container>

      <template #footer>
        <x-form-action-buttons
          :form="form"
        />
      </template>
    </x-card>
  </form>
</template>

<script>
import XFormContainer from "@/Components/Forms/Container";
import XFormActionButtons from "@/Components/Forms/ActionButtons";
import XInputText from "@/Components/Inputs/Text";
import {useForm} from "@inertiajs/inertia-vue3";
import XCard from "@/Components/Cards/Card";
import XInputTextArea from "@/Components/Inputs/Textarea";
import XSelect from "@/Components/Inputs/Select";
import slugify from "slugify";

export default {
    components: {
        XSelect,
        XInputTextArea,
        XCard,
        XInputText,
        XFormActionButtons,
        XFormContainer,
    },
    props: {
        tag: {
            type: [Object, Array],
            required: true,
        },
        deleteRoute: {
            type: [URL, String],
            required: false,
            default: (props) => props.tag.id ? route('admin.tags.destroy',{tag: props.tag}) : ''
        },
        restoreRoute: {
            type: [URL, String],
            required: false,
            default: (props) => props.tag.id ? route('admin.tags.restore',{tag: props.tag}) : ''
        },
        updateRoute: {
            type: [URL, String],
            required: false,
            default: (props) => props.tag.id ? route('admin.tags.update',{tag: props.tag}) : ''
        },
        storeRoute: {
            type: [URL, String],
            required: false,
            default: () => route('admin.tags.store')
        }
    },
    data() {
        return {
            form: useForm({
                '_method': 'POST',
                id: this.tag.id || null,
                name: this.tag.name,
                slug: this.tag.slug,
                description: this.tag.description,
                color: this.tag.color || 'indigo',
            }),
        }
    },
    computed: {
        editing() {
            return this.form.id !== null;
        },
    },
    watch: {
        'form.name': {
            immediate: false,
            handler(value) {
                if(value && value !== ''){
                    this.form.slug = slugify(value,'-').toLowerCase();
                }
            }
        },
    },
    methods: {
        submit() {
            if (this.editing) {
                this.form._method = 'PUT';
                this.form.post(this.updateRoute, {
                    preserveScroll: true,
                });
            } else {
                this.form.post(this.storeRoute, {
                    onSuccess: () => {
                        this.form.reset();
                    },
                });
            }
        },
    }
}
</script>
