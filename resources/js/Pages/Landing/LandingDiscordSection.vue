<template>
  <section class="relative w-full bg-gray-100">
    <curve class="-rotate-180 text-white" />
    <div class="max-w-7xl mx-auto mt-20 py-20">
      <page-heading
        title="Join us on Discord"
        subtitle="Want to follow along? Check our roadmap, and what we have planned for you folks on the next weeks/month. We should be as transparent as possible"
      />
      <div class="my-10 max-w-lg mx-auto grid gap-5 lg:grid-cols-4 lg:max-w-none">
        <div>testy</div>
      </div>
    </div>
    <curve class="text-white relative" />
  </section>
</template>

<script>
import PageHeading from "@/Components/Shared/PageHeading";
import Curve from "@/Components/Shared/Curve";
export default {
    components: {
        Curve,
        PageHeading
    }
}
</script>
