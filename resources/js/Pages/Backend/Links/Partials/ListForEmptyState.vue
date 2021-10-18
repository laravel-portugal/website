<template>
  <div class="max-w-lg mx-auto lg:max-w-none">
    <div class="grid gap-5 lg:grid-cols-3 flex">
      <skeleton-create />
      <skeleton-card
        v-for="link in dummyLinks"
        :key="link.id"
        :link="link"
      />
    </div>
  </div>
</template>

<script>
import SkeletonCreate from "@/Models/Link/SkeletonCreate";
import SkeletonCard from "@/Models/Link/SkeletonCard";
export default {
    components: {
        SkeletonCreate,
        SkeletonCard,
    },
    computed: {
        dummyLinks() {
            return [
                {
                    id: Math.random(),
                    title: 'Inertia Pretty Routes',
                    description: 'Submit your next link to help the community, please always make sure to not submit same links twice.',
                    cover_image_url: 'img/dummy/inertia.jpg',
                    updated_at_for_humans: '3 Hours ago',
                    tags: [
                        {
                            id: Math.random(),
                            name: 'Laravel',
                            color: 'gray',
                        },
                        {
                            id: Math.random(),
                            name: 'Inertia',
                            color: 'gray',
                        }
                    ]
                },
                {
                    id: Math.random(),
                    title: 'Tailwind CSS on your projects',
                    description: 'Submit your next link to help the community, please always make sure to not submit same links twice.',
                    cover_image_url: 'img/dummy/tailwind.jpg',
                    updated_at_for_humans: '7 Hours ago',
                    tags: [
                        {
                            id: Math.random(),
                            name: 'Laravel',
                            color: 'gray',
                        },
                    ]
                }
            ]
        }
    }
}
</script>
