<template>
  <form @submit.prevent="submit()">
    <x-card
      :subtitle="$t('users.profile-subtitle')"
      :title="$t('users.profile-title')"
    >
      <x-form-container>
        <x-profile-photo
          v-model="form.photo"
          :errors="form.errors.photo"
          :label="$t('users.fields.profile_photo_url')"
          :photo="$page.props.user.profile_photo_url"
          name="profile_photo_url"
        />

        <x-input-text
          v-model="form.name"
          :errors="form.errors.name"
          :label="$t('users.fields.name')"
          :placeholder="$t('placeholders.name')"
          autocomplete="name"
          autofocus
          name="name"
          required
        />

        <x-input-text
          v-model="form.email"
          :errors="form.errors.email"
          :label="$t('users.fields.email')"
          :placeholder="'canoas@gmail.com'"
          autocomplete="email"
          name="email"
          required
          type="email"
        />
      </x-form-container>
      <!-- Footer -->
      <template #footer>
        <x-form-action-buttons :form="form" />
      </template>
    </x-card>
  </form>
</template>

<script>
import XInputText from "@/Components/Inputs/Text";
import XProfilePhoto from "@/Components/Inputs/ProfilePhoto";
import XFormContainer from "@/Components/Forms/Container";
import XFormActionButtons from "@/Components/Forms/ActionButtons";
import {useForm} from "@inertiajs/inertia-vue3";
import XCard from "@/Components/Cards/Card";

export default {
    components: {
        XCard,
        XFormActionButtons,
        XFormContainer,
        XProfilePhoto,
        XInputText,
    },
    props: {
        user: {
            type: [Object, Array],
            required: true,
        },
    },
    data() {
        return {
            photoPreview: null,
            form: useForm({
                '_method': 'PUT',
                name: this.user.name,
                email: this.user.email,
                photo: null,
            }),
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('user-profile-information.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
            });
        },
    }
}
</script>
