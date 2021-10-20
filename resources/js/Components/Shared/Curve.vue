<template>
  <div
    class="absolute inset-x-0 left-0 w-full overflow-hidden leading-none"
    aria-hidden="true"
  >
    <svg
      v-if="waveStyle === 'regular'"
      aria-hidden="true"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1200 120"
      preserveAspectRatio="none"
      fill="currentColor"
    >
      <path
        d="M741,116.23C291,117.43,0,27.57,0,6V120H1200V6C1200,27.93,1186.4,119.83,741,116.23Z"
        class="shape-fill"
      />
    </svg>
    <svg
      v-else
      aria-hidden="true"
      fill="currentColor"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1200 120"
      preserveAspectRatio="none"
    >
      <path
        d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
        class="shape-fill"
      />
    </svg>
  </div>
</template>

<script>
export default {
    name: "Curve",
    props: {
        waveStyle: {
            type: [String],
            default: 'regular',
            required: false
        }
    }
}
</script>
