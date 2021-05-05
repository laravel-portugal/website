<div class="hidden md:flex md:space-x-10">
    @foreach($links as $label => $url)
        <a
            href="{{ $url }}"
            class="font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out"
        >
            {{ $label }}
        </a>
    @endforeach
</div>
