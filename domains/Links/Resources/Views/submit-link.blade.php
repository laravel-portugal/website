<x-app-layout>
    <x-hero>
        <x-slot name="title">
            Submeter
            <br class="xl:hidden">
            <span class="text-red-600">
                    Link
                </span>
        </x-slot>
        Partilha a tua "dica" com a comunidade. A tua informação é importante para todos. Constrói a
        comunidade LaravelPT enviando as tuas dicas mais inovadoras.
    </x-hero>

    <div class="relative text-center mt-10 sm:mt-12 md:mt-24 lg:mt-32">
        <livewire:links::submit-link/>
    </div>
</x-app-layout>
