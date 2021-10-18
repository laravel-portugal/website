<template>
  <x-card
    :subtitle="$t('users.two-factor-subtitle')"
    :title="$t('users.two-factor-title')"
    body-classes="bg-gray-50 dark:bg-gray-800"
  >
    <div class="px-4 py-5 sm:p-6">
      <!-- Two factor Title when Disabled/Enable -->
      <h3 class="text-lg font-medium text-gray-900 dark:text-white">
        <span
          v-if="twoFactorEnabled"
          class="flex items-center"
        >
          <x-status-indicator
            class="flex-shrink-0"
            color="green"
          />
          <span class="ml-3 leading-snug">{{ $t('users.two-factor-on') }}</span>
        </span>
        <span
          v-else
          class="flex items-center"
        >
          <x-status-indicator
            class="flex-shrink-0"
            color="red"
          />
          <span class="ml-3 leading-snug">{{ $t('users.two-factor-off') }}</span>
        </span>
      </h3>

      <!-- General Description -->
      <p class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
        {{ $t('users.two-factor-description') }}
      </p>

      <!-- Two factor is enable description -->
      <div v-if="twoFactorEnabled">
        <div v-if="qrCode">
          <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-white">
            <p class="font-semibold">
              {{ $t('users.two-factor-on-description') }}
            </p>
          </div>

          <div
            class="mt-4 p-5 bg-white rounded max-w-sm flex items-center justify-center"
            v-html="qrCode"
          />
        </div>

        <div v-if="recoveryCodes.length > 0">
          <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-white">
            <p class="font-semibold">
              {{ $t('users.two-factor-recovery-codes') }}
            </p>
          </div>

          <div
            class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg dark:bg-gray-900 dark:text-white"
          >
            <div
              v-for="code in recoveryCodes"
              :key="code"
            >
              {{ code }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <template #footer>
      <div class="space-x-2 flex-shrink flex items-center">
        <x-modal-confirm-password
          v-if="!twoFactorEnabled"
          class="inline-flex"
          @confirmed="enableTwoFactorAuthentication"
        >
          <button-loading
            :loading="enabling"
            type="button"
          >
            {{ $t('app.enable') }}
          </button-loading>
        </x-modal-confirm-password>

        <x-modal-confirm-password
          v-if="twoFactorEnabled && recoveryCodes.length > 0"
          class="inline-flex"
          @confirmed="regenerateRecoveryCodes"
        >
          <button-primary variant="secondary">
            {{ $t('users.two-factor-generate') }}
          </button-primary>
        </x-modal-confirm-password>

        <x-modal-confirm-password
          v-if="twoFactorEnabled && recoveryCodes.length === 0"
          class="inline-flex"
          @confirmed="showRecoveryCodes"
        >
          <button-primary variant="secondary">
            {{ $t('users.two-factor-show-codes') }}
          </button-primary>
        </x-modal-confirm-password>

        <x-modal-confirm-password
          v-if="twoFactorEnabled"
          class="inline-flex"
          @confirmed="disableTwoFactorAuthentication"
        >
          <button-loading
            :loading="disabling"
            variant="danger"
          >
            {{ $t('app.disable') }}
          </button-loading>
        </x-modal-confirm-password>
      </div>
    </template>
  </x-card>
</template>

<script>
import ButtonLoading from "@/Components/Buttons/ButtonLoading";
import ButtonPrimary from "@/Components/Buttons/ButtonPrimary";
import XStatusIndicator from "@/Components/Animations/StatusIndicator";
import XModalConfirmPassword from "@/Components/Modals/ConfirmPassword";
import XCard from "@/Components/Cards/Card";

export default {
    components: {
        XCard,
        XModalConfirmPassword,
        XStatusIndicator,
        ButtonPrimary,
        ButtonLoading,
    },

    data() {
        return {
            enabling: false,
            disabling: false,
            qrCode: null,
            recoveryCodes: [],
        }
    },
    computed: {
        twoFactorEnabled() {
            return !this.enabling && this.$page.props.user.two_factor_enabled
        },
    },

    methods: {
        enableTwoFactorAuthentication() {
            this.enabling = true
            this.$inertia.post('/user/two-factor-authentication', {}, {
                preserveScroll: true,
                onSuccess: () => Promise.all([
                    this.showQrCode(),
                    this.showRecoveryCodes()
                ]),
                onFinish: () => {
                    this.enabling = false
                },
            })
        },

        showQrCode() {
            return this
                .axios
                .get('/user/two-factor-qr-code')
                .then(response => {
                    this.qrCode = response.data.svg
                })
        },

        showRecoveryCodes() {
            return this.axios.get('/user/two-factor-recovery-codes').then(response => {
                this.recoveryCodes = response.data
            })
        },

        regenerateRecoveryCodes() {
            this.axios.post('/user/two-factor-recovery-codes').then(response => {
                this.showRecoveryCodes()
            })
        },
        disableTwoFactorAuthentication() {
            this.disabling = true;
            this.$inertia.delete('/user/two-factor-authentication', {
                preserveScroll: true,
                preserveState: true,
                onFinish: () => {
                    this.disabling = false
                },
            });
        },
    },
}
</script>
