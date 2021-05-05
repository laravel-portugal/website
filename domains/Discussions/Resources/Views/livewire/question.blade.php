<div class="w-full flex justify-between p-4 sm:p-8 rounded bg-white shadow hover:shadow-lg transition-all duration-300">
    <div class="max-w-xl">
        @if ($editMode)
            <x-form-field label="Título" for="title">
                <textarea id="title" rows="3"
                          class="form-textarea block w-full transition duration-150 ease-in-out text-xl"
                          wire:model.defer="$question->title"></textarea>
            </x-form-field>

            <x-form-field label="Descrição" for="description">
            <textarea id="description" rows="3"
                      class="form-textarea block w-full transition duration-150 ease-in-out text-xl"
                      wire:model.defer="$question->description"></textarea>
            </x-form-field>
        @else
            <div class="text-2xl font-medium">{{ Str::limit($question->title, 50) }}</div>
            <div class="mt-8">{{ $question->description }}</div>
        @endif

        @if ($editMode)
            <x-button wire:loading.attr="disabled" wire:click="save">
                Save
            </x-button>
        @endif
    </div>

    <div class="text-right">
        @if ($question->author->is(Auth::user()))
            <span class="cursor-pointer" wire:click="edit">edit</span>
        @endif

        <div class="text-md text-gray-600">{{ $question->author->name }}</div>
        <div class="text-sm mt-1 text-gray-600">{{ trans_choice(':count answer|:count answers', $question->answers_count) }}</div>
    </div>
</div>
