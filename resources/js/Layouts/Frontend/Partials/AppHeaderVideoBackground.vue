<template>
  <div class="absolute inset-0 z-0">
    <video
      autoplay
      loop
      muted
      class="w-full h-full object-cover"
    >
      <source
        class="w-full"
        :src="asset('img/videos/portugal.mp4')"
        type="video/mp4"
      >
      <source
        class="w-full"
        :src="asset('img/videos/portugal.webm')"
        type="video/webm"
      >
      <img
        class="h-full w-full object-cover"
        :src="asset('img/videos/portugal.jpg')"
        title="Your browser does not support the <video> tag"
        :alt="$page.props.meta.site_name"
      >
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-gray-900 via-primary-500 to-yellow-200 mix-blend-multiply" />
  </div>
</template>

<script>
import {asset} from "@/Utils/Utils";
export default {
    methods:{
        asset: asset,
    }
}
</script>
