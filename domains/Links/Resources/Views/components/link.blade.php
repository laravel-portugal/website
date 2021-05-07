<div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
    <div class="flex-shrink-0">
        <img
                class="h-48 w-full object-cover"
                src="{{ $link['cover_image'] }}"
                alt=""
        >
    </div>
    <div class="flex-1 bg-white p-6 flex flex-col justify-between">
        <div class="flex-1">
            <p class="text-sm leading-5 font-medium text-red-600">
                @foreach($link->tags as $tag)
                    <a href="{{ route('tags::tag.links', [ 'tag' => $tag->id]) }}" class="hover:underline">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </p>
            <a target="_blank" href="{{ $link->link }}" class="block">
                <h3 class="mt-2 text-xl leading-7 font-semibold text-gray-900">
                    {{ $link['title'] }}
                </h3>
                <p class="mt-3 text-base leading-6 text-gray-500">
                    {{ $link['description']}}
                </p>
            </a>
        </div>
        <div class="mt-6 flex items-center">
            <div class="flex-shrink-0">
                <a href="{{ route('accounts::user.links', [ 'username' => urlencode($link->author_email)]) }}">
                    <img
                            class="h-10 w-10 rounded-full"
                            src="{{ ($gravatar) ?? Avatar::create( $link['author_name'] )->toBase64() }}"
                            alt="{{ $link['author_name']  }}"/>
                </a>
            </div>
            <div class="ml-3">
                <p class="text-sm leading-5 font-medium text-gray-900">
                    <a href="{{ route('accounts::user.links', [ 'username' => urlencode($link->author_email)]) }}"
                       class="hover:underline">
                        {{ $link['author_name']}}
                    </a>
                </p>
                <div class="flex text-sm leading-5 text-gray-500">
                    <time datetime="2020-03-16">
                        {{ Carbon\Carbon::make($link['created_at'])->format('m/d/Y')}}
                    </time>
                </div>
            </div>
        </div>
    </div>
</div>

