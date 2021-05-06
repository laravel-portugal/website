<div class="mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
    @foreach($links ?? [] as $link)
        <x-links::link :key="$link['id']" :link="$link"/>
    @endforeach
</div>

