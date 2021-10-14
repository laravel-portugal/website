<template>
  <div class="max-w-lg mx-auto lg:max-w-none">
    <div class="grid gap-5 lg:grid-cols-3 flex">
      <link-card-create />
      <link-card-skeleton
        v-for="link in links"
        :key="link.id"
        :link="link"
      />
    </div>
  </div>
</template>

<script>
import LinkCardCreate from "@/Pages/Links/Partials/LinkCardCreate";
import LinkCardSkeleton from "@/Pages/Links/Partials/LinkCardSkeleton";
export default {
    components: {
        LinkCardSkeleton,
        LinkCardCreate,
    },
    computed: {
        links() {
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
