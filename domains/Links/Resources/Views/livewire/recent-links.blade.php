<div class="mt-12 flex flex-wrap justify-around items-top max-w-lg mx-auto lg:max-w-none">
    @foreach($links ?? [] as $link)
        <div class="p-4">
            <x-links::link :key="$link['id']" :link="$link"/>
        </div>
    @endforeach
</div>

