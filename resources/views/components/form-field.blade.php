<div class="pb-6">
    <label @isset($id) for="{{ $id }}" @endisset class="block m-0.5 text-gray-700 uppercase">
        {{ $label }}
    </label>
    <div class="rounded-md shadow-sm">
        {{ $slot }}
    </div>
    @isset($id)
        @error($id) <div class="mx-0.5 my-1 text-red-600"> {{ $message }} </div> @enderror
    @endisset
</div>
