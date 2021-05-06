@if (session()->has('message'))
    <div class="mx-auto p-4 mabg-gray-700 text-gray-200">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            {{ session('message') }}
        </div>
    </div>
@endif
