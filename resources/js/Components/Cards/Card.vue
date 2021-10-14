<template>
  <div class="card">
    <div
      v-if="hasHeader"
      :class="[headerClasses]"
      class="card-header"
    >
      <div class="card-header-inner">
        <!--  Title and Subtitle -->
        <div class="card-title-holder">
          <div>
            <h3 class="card-title">
              <slot name="title">
                <span
                  v-if="title !== ''"
                  v-html="title"
                />
              </slot>
            </h3>
            <p class="card-subtitle">
              <slot name="subtitle">
                <span
                  v-if="subtitle !== ''"
                  v-html="subtitle"
                />
              </slot>
            </p>
          </div>
        </div>
        <!--  Actions -->
        <div class="card-actions ">
          <slot name="actions" />
        </div>
        <!--  End Actions -->
      </div>
    </div>

    <div :class="[bodyClasses]">
      <slot name="default" />
    </div>

    <div
      v-if="hasFooter"
      :class="[footerClasses]"
      class="card-footer"
    >
      <slot name="footer" />
    </div>
  </div>
</template>
<script>
export default {
    name: 'XCard',
    props: {
        title: {
            type: String,
            required: false,
            default: ''
        },
        subtitle: {
            type: String,
            required: false,
            default: ''
        },
        bodyClasses: {
            type: String,
            default: ''
        },
        headerClasses: {
            type: String,
            default: ''
        },
        footerClasses: {
            type: String,
            default: ''
        }
    },
    computed: {
        hasFooter() {
            return !!this.$slots.footer
        },
        hasHeader() {
            return this.$slots['title'] ||
                this.$slots['subtitle'] ||
                this.$slots['actions'] ||
                this.title !== '' ||
                this.subtitle !== ''
        }
    }
}
</script>
