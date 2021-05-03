<div class="max-w-screen-xl mx-auto px-4 sm:px-6">
    <nav class="relative flex items-center justify-between sm:h-10 md:justify-center">
        <div class="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
            <div class="flex items-center justify-between w-full md:w-auto">
                <a href="/" aria-label="Home">
                    <img class="h-8 w-auto sm:h-10" src="images/logomark-pt.svg" alt="Logo">
                </a>
                <div class="-mr-2 flex items-center md:hidden">
                    <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            id="main-menu" aria-label="Main menu" aria-haspopup="true">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <x-navbar-menu></x-navbar-menu>
        <div class="hidden md:absolute md:flex md:items-center md:justify-end md:inset-y-0 md:right-0">
          <span class="inline-flex rounded-md shadow">
            <a href="/login"
               class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-red-600 bg-white hover:text-indigo-500 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-gray-50 active:text-indigo-700 transition duration-150 ease-in-out">
              Log in
            </a>
          </span>
        </div>
    </nav>
</div>
<!--
  Mobile menu, show/hide based on menu open state.

  Entering: "duration-150 ease-out"
    From: "opacity-0 scale-95"
    To: "opacity-100 scale-100"
  Leaving: "duration-100 ease-in"
    From: "opacity-100 scale-100"
    To: "opacity-0 scale-95"
-->
<div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
    <div class="rounded-lg shadow-md">
        <div class="rounded-lg bg-white shadow-xs overflow-hidden" role="menu" aria-orientation="vertical"
             aria-labelledby="main-menu">
            <div class="px-5 pt-4 flex items-center justify-between">
                <div>
                </div>
                <div class="-mr-2">
                    <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            aria-label="Close menu">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="px-2 pt-2 pb-3 hidden">
                <a href="#"
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out"
                   role="menuitem">Product</a>
                <a href="#"
                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out"
                   role="menuitem">Features</a>
                <a href="#"
                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out"
                   role="menuitem">Marketplace</a>
                <a href="#"
                   class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out"
                   role="menuitem">Company</a>
            </div>
            <div>
                <a href="#"
                   class="block w-full px-5 py-3 text-center font-medium text-red-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out"
                   role="menuitem">
                    Log in
                </a>
            </div>
        </div>
    </div>
</div>
