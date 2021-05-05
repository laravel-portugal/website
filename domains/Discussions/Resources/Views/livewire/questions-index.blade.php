<div>
    <div class="mx-2 my-6">
        <x-paginator :paginator="$paginator"/>
    </div>

    <div class="m-2 space-y-6">
        @foreach ($questions as $question)
            <livewire:discussions::question :wire:key="$question->id" :question="$question"/>
        @endforeach
    </div>
</div>
