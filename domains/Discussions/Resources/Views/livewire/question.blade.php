<div class="w-full sm:flex justify-between items-stretch p-4 sm:p-8 rounded bg-white shadow hover:shadow-lg transition-all duration-300">
    <div class="flex-grow pr-16 max-w-3xl">
        @if ($editMode)
            <x-form-field label="Título" for="title" class="w-full">
                <input id="title"
                       class="block w-full transition duration-150 ease-in-out text-xl"
                       wire:model.defer="question.title"></input>
            </x-form-field>

            <x-form-field label="Descrição" for="description">
            <textarea id="description" rows="3"
                      class="form-textarea block w-full transition duration-150 ease-in-out text-xl"
                      wire:model.defer="question.description"></textarea>
            </x-form-field>
        @else
            <div class="text-2xl font-medium">{{ Str::limit($question->title, 50) }}</div>
            <div class="mt-8">{{ $question->description }}</div>
        @endif
    </div>

    <div class="flex flex-col justify-between sm:text-right mt-4 sm:mt-0">
        <div>
            <div class="ml-auto text-md text-gray-700 {{
                $question->author->is(Auth::user()) ? 'font-bold' : '' }}">
                {{ $question->author->name }}
            </div>
            <div class="text-sm mt-1 text-gray-700">{{ trans_choice(':count answer|:count answers', $question->answers_count) }}</div>
        </div>
        <div>
            <div class="text-xs mb-1 text-gray-600">{{ $question->updated_at }}</div>

            @if ($question->author->is(Auth::user()))
                @if ($editMode)
                    <x-button class="mt-2 mr-2" wire:loading.attr="disabled" wire:click="save">Save</x-button>
                    <x-button-secondary class="mt-2" wire:loading.attr="disabled" wire:click="cancelEdit">Cancel
                    </x-button-secondary>
                @else
                    <x-button-secondary class="mt-2" wire:loading.attr="disabled" wire:click="edit">Edit
                    </x-button-secondary>
                @endif
            @endif
        </div>
    </div>
</div>
