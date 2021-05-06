<x-app-layout>
    <x-hero>
        <x-slot name="title">
            <span class="text-red-600">Links</span>
            <br class="xl:hidden">
            Recentes
        </x-slot>
        As dicas mais inovadoras, criadas pela comunidade, para a comunidade.
    </x-hero>

    <div class="relative text-center mx-auto max-w-screen-2xl mt-10 px-2 sm:mt-12 sm:px-4 md:mt-24 md:px-8 lg:mt-32">
        <livewire:links::recent-links/>
    </div>
</x-app-layout>
