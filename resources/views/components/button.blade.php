<button {{ $attributes->merge([
    'class' => 'inline-flex justify-center py-2 px-4 border border-transparent
                text-sm leading-5 font-medium rounded-md text-white bg-red-600
                hover:bg-red-500 focus:outline-none focus:border-red-700
                focus:shadow-outline-red active:bg-indigo-700 transition duration-150
                ease-in-out disabled:bg-red-300 disabled:cursor-not-allowed'
]) }}>
    {{ $slot }}
</button>
