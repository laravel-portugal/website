<div class="text-left" xmlns:wire="http://www.w3.org/1999/xhtml">
    <form
            x-data="{ adding: false, removing: false }"
            x-on:link-updated.window="$wire.generateCoverImage()"
            wire:submit.prevent="submit"
            autocomplete="off"
    >
        <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 text-base">
                <x-form-field id="link" label="Endereço URL">
                    <input id="link"
                           class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out text-xl"
                           placeholder="http://www.host.tld"
                           wire:model.lazy="link"
                    >
                </x-form-field>
                @if ($link && !$errors->get('link'))
                    <x-form-field label="Image Preview">
                        <div class="mt-1 flex-col rounded-md">
                            <div class="relative mt-2 flex justify-center items-center w-full h-64 rounded-md shadow-inner border border-gray-200">
                                <input id="file" type="file" class="hidden" accept="image/*" x-ref="photo"
                                       wire:model="photo">

                                @if ($photo)
                                    <div wire:key="photo"
                                         class="absolute inset-0 block bg-cover bg-no-repeat bg-center group">
                                        <img class="rounded-md h-full w-full object-cover"
                                             src="{{ $photo->temporaryUrl() }}"/>
                                        <div class="opacity-0 group-hover:opacity-100 flex items-center justify-center absolute top-0 right-0 rounded-full bg-red-700 shadow-lg leading-none w-8 h-8 mr-2 mt-2 cursor-pointer transition-opacity duration-300"
                                             wire:click.stop="clearPhoto()">
                                            <span class="font-black text-white">X</span>
                                        </div>
                                    </div>
                                @elseif ($generatedPhoto)
                                    <div
                                            class="absolute inset-0 bg-cover bg-no-repeat bg-center flex items-center justify-center rounded-md shadow-inner"
                                            style="background-image: url('{{ URL::to($generatedPhoto) }}');">
                                        <div wire:loading wire:target="photo" wire:key="loading">
                                            <div
                                                    class="flex items-center justify-center absolute inset-0 block bg-white bg-opacity-75 p-8">
                                                <span class="text-center">Uploading photo ...</span>
                                            </div>
                                        </div>
                                        <div wire:loading.remove wire:target="photo"
                                             x-on:drop.prevent="adding = false; @this.upload('photo', event.dataTransfer.files[0])"
                                             x-on:dragover.prevent="adding = true"
                                             x-on:dragleave.prevent="adding = false"
                                             x-bind:class="{ 'bg-opacity-100': adding }"
                                             x-on:click.prevent="$refs.photo.click()"
                                             class="text-center bg-white bg-opacity-75 rounded-md shadow p-10 cursor-pointer hover:bg-opacity-100 transition-colors duration-500">
                                            <svg class=" mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                 fill="none"
                                                 viewBox="0 0 48 48">
                                                <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-1 text-sm text-gray-600">
                                                Click or Drag to upload another cover image
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500">
                                                PNG, JPG, GIF up to 10MB
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <div wire:loading wire:target="generateCoverImage">
                                    <div class="flex items-center justify-center absolute inset-0 bg-white bg-opacity-75 m-8 p-8">
                                        <span class="text-center">Generating the cover image...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-form-field>
                @endif

                <x-form-field label="Título" id="title">
                    <input id="title"
                           class="form-input block w-full transition duration-150 ease-in-out text-xl"
                           wire:model.defer="title"
                    >
                </x-form-field>

                @guest
                    <x-form-field label="Nome" id="author_name">
                        <input id="author_name"
                               class="form-input block w-full transition duration-150 ease-in-out text-xl"
                               wire:model.defer="author_name">
                    </x-form-field>

                    <x-form-field label="e-mail" id="author_email">
                        <input id="author_email"
                               class="form-input block w-full transition duration-150 ease-in-out text-xl"
                               wire:model.defer="author_email">
                    </x-form-field>
                @endguest

                <x-form-field label="Descrição" id="description">
                    <textarea id="description" rows="3"
                              class="form-textarea block w-full transition duration-150 ease-in-out text-xl"
                              wire:model.defer="description"></textarea>
                </x-form-field>

                <div>
                    <fieldset>
                        <legend class="block m-0.5 text-gray-700 uppercase">Etiquetas / Tags</legend>
                        <div class="mt-4 grid grid-cols-1 gap-2 md:grid-cols-2">
                            @foreach($availableTags as $tag)
                                <div>
                                    <div class="flex items-center h-5">
                                        <input wire:model.defer="tags.id{{ $tag['id'] }}"
                                               value="{{ $tag['id'] }}"
                                               id="tags[{{ $loop->index }}]"
                                               name="tags[{{ $loop->index }}]"
                                               type="checkbox"
                                               class="form-checkbox h-4 w-4 text-red-600 transition duration-150 ease-in-out"
                                        >
                                        <div class="ml-3 text-sm leading-5">
                                            <label for="tags[{{ $loop->index }}]" class="font-medium text-gray-700">
                                                {{ $tag['name'] }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                </div>
                @error('tags')
                <div class="mx-0.5 my-1 text-red-600"> {{ $message }} </div> @enderror

                <div class="border-t border-gray-200 mt-10 pt-5 mx-auto">
                    <div class="flex justify-end">
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <x-button wire:loading.attr="disabled"
                                      type="submit"
                                      id="submit">
                                Save
                            </x-button>
                        </span>
                    </div>
                </div>
                <div wire:loading>
                    Em submissão
                </div>
                <pre>@isset($response['status']) {{ $response['status'] }} @endisset</pre>
                <pre>@isset($response['message']) {{ $response['message'] }} @endisset</pre>
            </div>
        </div>
    </form>
</div>
