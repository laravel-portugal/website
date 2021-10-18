<template>
  <app-layout>
    <div>
      <update-profile-information-form :user="$page.props.user" />

      <section-border />

      <update-password-form class="mt-10 sm:mt-0" />

      <div v-if="canManageTwoFactor">
        <section-border />
        <two-factor-authentication-form class="mt-10 sm:mt-0" />
      </div>

      <section-border />

      <logout-other-browser-sessions-form
        :sessions="sessions"
        class="mt-10 sm:mt-0"
      />

      <section-border />

      <delete-user-form class="mt-10 sm:mt-0" />
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import UpdateProfileInformationForm from "@/Pages/Backend/Profile/UpdateProfileInformationForm";
import SectionBorder from "@/Components/Shared/SectionBorder";
import UpdatePasswordForm from "@/Pages/Backend/Profile/UpdatePasswordForm";
import TwoFactorAuthenticationForm from "@/Pages/Backend/Profile/TwoFactorAuthenticationForm";
import LogoutOtherBrowserSessionsForm from "@/Pages/Backend/Profile/LogoutOtherBrowserSessionsForm";
import DeleteUserForm from "@/Pages/Backend/Profile/DeleteUserForm";

export default {
    components: {
        DeleteUserForm,
        LogoutOtherBrowserSessionsForm,
        TwoFactorAuthenticationForm,
        UpdatePasswordForm,
        SectionBorder,
        UpdateProfileInformationForm,
        AppLayout
    },
    props: {
        sessions: {
            type: [Object, Array],
            required: false,
            default: () => {
                return [];
            }
        },
    },
    computed: {
        canManageTwoFactor() {
            return this.$page.props.jetstream.canManageTwoFactorAuthentication;
        }
    }
}
</script>
