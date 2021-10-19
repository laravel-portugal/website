<template>
  <form @submit.prevent="submit()">
    <x-card
      :title="editing ? $t('app.links-edit-title') : $t('app.links-create-title')"
      :subtitle="editing ? $t('app.links-edit-subtitle') : $t('app.links-create-subtitle')"
    >
      <template #actions>
        <div
          v-if="editing"
          class="inline-flex"
        >
          <inertia-link
            v-if="link.deleted_at === null"
            :href="deleteRoute"
            as="button"
            class="btn"
            method="delete"
          >
            {{ $t('app.delete') }}
          </inertia-link>
          <inertia-link
            v-if="link.deleted_at !== null"
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
          v-model="form.url"
          :label="$t('app.links.url')"
          :placeholder="$t('placeholders.url')"
          :help="$t('app.helpers.link-url')"
          :errors="form.errors.url"
          name="url"
          autocomplete="share_link"
          required
          :disabled="isCrawling"
          autofocus
          @change="hydrateWithOpenGraph"
        >
          <template #after>
            <button
              type="button"
              class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
              @click="hydrateWithOpenGraph"
            >
              <refresh-icon
                class="h-5 w-5 text-gray-400"
                aria-hidden="true"
              />
            </button>
          </template>
        </x-input-text>

        <x-cover-photo
          v-model="form.cover_image"
          :photo-preview-raw="coverPreview"
          :photo-preview-url="coverUrl"
          :has-open-graph="crawledData !== null"
          :label="$t('app.links.cover')"
          :help="$t('app.helpers.link-cover')"
          :errors="form.errors.cover_image"
          name="cover_image"
          :loading="isCrawling"
          @opengraph="useOpenGraph"
          @delete="deletePhoto"
        />

        <x-input-text
          v-model="form.title"
          :label="$t('app.links.title')"
          :placeholder="$t('placeholders.title')"
          :help="$t('app.helpers.link-title')"
          :errors="form.errors.title"
          name="title"
          autocomplete="title"
          required
          :disabled="isCrawling"
        />

        <x-input-text-area
          v-model="form.description"
          :label="$t('app.links.description')"
          :placeholder="$t('placeholders.link_description')"
          :errors="form.errors.description"
          name="description"
          autocomplete="description"
          required
          :disabled="isCrawling"
        />

        <!-- Tags -->
        <div class="form-row-default">
          <div class="form-row-default-label sm:mt-px sm:pt-2">
            <x-form-label :value="$t('app.links.tags')" />
          </div>
          <div class="form-row-default-input">
            <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
              <x-input-checkbox
                v-for="(tag) in tags"
                :key="tag.id"
                v-model="form.tags"
                :label="tag.name"
                :name="tag.name"
                :value="tag.id"
                :search-using="'id'"
                :disabled="isCrawling"
                class="flex items-center"
              />
            </div>
            <x-form-errors
              v-if="form.errors.tags"
              :error="form.errors.tags"
            />
          </div>
        </div>

        <!-- Status -->
        <x-select
          v-if="$can('moderate-links') || $hasRole('admin') || $hasRole('moderator')"
          v-model="form.status"
          :label="$t('app.links.status')"
          :options="$page.props.guidelines.links.status_options"
          name="status"
          :show-empty="true"
        />
      </x-form-container>

      <template #footer>
        <x-form-action-buttons
          :form="form"
          :force-loading-when="isCrawling"
          @reset="reset"
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
import XFormLabel from "@/Components/Forms/FormLabel";
import XInputCheckbox from "@/Components/Inputs/Checkbox";
import XCoverPhoto from "@/Components/Inputs/CoverImage";
import useFiles from "@/Utils/useFileInputs";
import debounce from 'lodash/debounce'
import map from 'lodash/map'
import {RefreshIcon} from "@heroicons/vue/solid";
import XFormErrors from "@/Components/Forms/Errors";
import XSelect from "@/Components/Inputs/Select";

export default {
    components: {
        XSelect,
        XFormErrors,
        XCoverPhoto,
        XInputCheckbox,
        XFormLabel,
        XInputTextArea,
        XCard,
        XInputText,
        XFormActionButtons,
        XFormContainer,
        RefreshIcon
    },
    props: {
        link: {
            type: [Object, Array],
            required: true,
        },
        deleteRoute: {
            type: [URL, String],
            required: false,
            default: (props) => props.link.id ? route('links.destroy',{link: props.link}) : ''
        },
        restoreRoute: {
            type: [URL, String],
            required: false,
            default: (props) => props.link.id ? route('links.restore',{link: props.link}) : ''
        },
        updateRoute: {
            type: [URL, String],
            required: false,
            default: (props) => props.link.id ? route('links.update',{link: props.link}) : ''
        },
        storeRoute: {
            type: [URL, String],
            required: false,
            default: () => route('links.store')
        }
    },
    data() {
        return {
            form: useForm({
                '_method': 'POST',
                id: this.link.id || null,
                url: this.link.url,
                title: this.link.title,
                description: this.link.description,
                tags: this.link.tags ? map(this.link.tags,'id') : [],
                cover_image: null, // Always new, either its a new image or its a URL
                status: this.link.status ?? this.$page.props.guidelines.links.status.waiting_approval
            }),
            isCrawling: false, // Store when its crawling
            coverPreview: null, // Raw data for preview
            coverUrl: this.link.cover_image_url ?? null, // Initial Cover URL
            crawledData: null, // Stores the crawled data temporary
        }
    },
    computed: {
        editing() {
            return this.form.id !== null;
        },
        tags(){
            return this.$page.props.tags;
        }
    },
    methods: {
        /**
         * Hydrates the form fields using an Internal API
         **/
        hydrateWithOpenGraph: debounce(function(){
            // Yeah, go count it. xD
            if(this.form.url.length < 8 || this.isCrawling){
                return;
            }

            this.isCrawling = true;
            this
                .axios
                .post(route('crawler.search'), {url: this.form.url})
                .then((response) => {
                    if (response.status === 200 && response.data?.success) {
                        this.form.title = response.data.title;
                        this.form.description = response.data.description;
                        this.coverPreview = useFiles.fromDataURLtoFile(response.data.image_data_url);
                        this.crawledData = response.data;
                    }
                })
                .then(() => this.isCrawling = false)
        }),

        /**
         * Submit the form that should work for both updating and creating
         **/
        submit() {
            if (this.editing) {
                this.form._method = 'PUT'; // This wasted my whole day, thanks!
                this.form.post(this.updateRoute, {
                    preserveScroll: true,
                });
            } else {
                this.form.post(this.storeRoute, {
                    onSuccess: () => {
                        this.form.reset();
                        this.reset();
                    },
                    onFinish: () => {
                    }
                });
            }
        },

        /**
         * Deletes the photo and the preview
         **/
        deletePhoto(){
            this.form.cover_image = null;
            this.coverPreview = null;
        },

        /**
         * In case the user uploaded their own photo, he can always swap back to the opengraph/browsershot image
         **/
        useOpenGraph(){
            if(this.crawledData){
                this.form.title = this.crawledData.title;
                this.form.description = this.crawledData.description;
                this.coverPreview = useFiles.fromDataURLtoFile(this.crawledData.image_data_url);
            }
        },

        /**
         * Reset the form and also wipe all temporary data
         **/
        reset(){
           this.deletePhoto();
           this.crawledData = null;
        }
    }
}
</script>
