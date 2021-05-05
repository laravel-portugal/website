<button {{ $attributes->merge([
    'type' => 'button',
    'class' => 'py-2 px-4 border border-gray-300 rounded-md text-sm leading-5
               font-medium text-gray-700 hover:text-gray-500 focus:outline-none
               focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50
               active:text-gray-800 transition duration-150 ease-in-out'
]) }}>
    {{ $slot }}
</button>
