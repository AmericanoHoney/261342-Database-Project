<nav x-data="{ openUserMenu: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Left: Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="Flortalera" class="h-8 w-8">
                <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">Flortalera</span>
            </div>

            <!-- Center: Navigation Links -->
            <div class="flex space-x-8">
                <a href="{{ route('dashboard') }}"
                   class="font-medium {{ request()->routeIs('dashboard') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-600' }}">
                    Homepage
                </a>
                <a href="{{ route('products') }}"
                   class="font-medium {{ request()->routeIs('products') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-600' }}">
                    Products
                </a>
            </div>

            <!-- Right: User Dropdown + Cart -->
<div class="flex items-center space-x-4 relative">

    <!-- 🛒 Cart Icon -->
    <a href="{{ route('cart.index') }}" 
       class="text-pink-600 hover:text-pink-700 transition relative">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 11-6 0 3 3 0 016 0zm13.5 0a3 3 0 11-6 0 3 3 0 016 0zm-13.5 0h9m0 0l2.25-8.25H6.72m0 0L5.1 5.273A.75.75 0 014.386 4.5H2.25"/>
        </svg>

        <!-- จำนวนสินค้า (badge) -->
        <span class="absolute -top-1 -right-2 bg-pink-600 text-white text-xs font-semibold px-1.5 rounded-full">
            3
        </span>
    </a>

    <!-- 👤 User Dropdown -->
    <div class="relative">
        <button @click="openUserMenu = !openUserMenu"
                class="flex items-center text-pink-600 hover:text-pink-700 transition">
            <!-- user icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
            </svg>
        </button>

        <!-- Dropdown -->
        <div x-show="openUserMenu"
             @click.outside="openUserMenu = false"
             x-transition
             class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-50">
            <div class="py-2 text-sm text-gray-700 dark:text-gray-200">

                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-pink-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
                    </svg>
                    Profile
                </a>

                <a href="{{ route('favorites') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-pink-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5A4.72 4.72 0 0012 5.632 4.72 4.72 0 007.688 3.75C5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    Favorites
                </a>

                <a href="{{ route('orders.history') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 text-pink-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    History
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</nav>
