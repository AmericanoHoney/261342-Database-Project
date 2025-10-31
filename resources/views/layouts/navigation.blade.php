<nav x-data="{ openUserMenu: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Left: Logo -->
             <a href="{{ route('dashboard') }}">
                <div class="flex items-center justify-center space-x-2 min-w-[150px]">
                    <img src="{{ asset('images/logo.png') }}" alt="Flortalera" class="h-8 w-8 object-contain">
                    <span class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Flortalera
                    </span>
                </div>
            </a>
            <!-- Center: Navigation Links -->
            <div class="flex space-x-8">
                <a href="{{ route('dashboard') }}"
                   class="font-medium {{ request()->routeIs('dashboard') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-600' }}">
                    Homepage
                </a>
                <a href="{{ route('products.index') }}"
                    class="font-medium {{ request()->routeIs('products.index') ? 'text-pink-600' : 'text-gray-400 hover:text-pink-600' }}">
                    Products
                </a>
            </div>

            <!-- Right: User Dropdown + Cart -->
            <div class="flex items-center justify-end space-x-6 relative min-w-[150px]">

                @auth
                    <!-- 🛒 Cart Icon -->
                    <a href="{{ route('cart.index') }}"
                    class="text-pink-600 hover:text-pink-700 transition relative">
                        <img src="{{ asset('images/cart.png') }}" alt="Logo" class="w-7 h-7 inline-block align-middle">

                        <!-- จำนวนสินค้า (badge) -->
                        <span id="cart-count"
                                class="absolute -top-1 -right-2 bg-pink-600 text-white text-xs font-semibold px-1.5 rounded-full">
                                {{ $cartCount ?? 0}}
                        </span>
                    </a>
                @endauth

                <!-- 👤 User Dropdown -->
                <div x-data="{ openUserMenu: false }" class="relative" x-cloak>
                    <button
                        @click="openUserMenu = !openUserMenu"
                        class="flex items-center text-pink-600 hover:text-pink-700 transition"
                        aria-haspopup="menu"
                        :aria-expanded="openUserMenu"
                    >
                        @auth
                            {{-- มีผู้ใช้ล็อกอิน --}}
                            @php($me = Auth::user())
                            @if(!empty($me->photo))
                                <img src="{{ asset('storage/' . $me->photo) }}" alt="Profile Picture"
                                    class="w-7 h-7 rounded-full" />
                            @else
                                <img src="{{ asset('images/user.png') }}" alt="Default Profile"
                                    class="w-7 h-7" />
                            @endif
                        @endauth

                        @guest
                            {{-- ยังไม่ล็อกอิน --}}
                            <img src="{{ asset('images/user.png') }}" alt="Default Profile"
                                class="w-7 h-7" />
                        @endguest
                    </button>

                    <!-- Dropdown -->
                    <div
                        x-show="openUserMenu"
                        @click.outside="openUserMenu = false"
                        x-transition.opacity.scale
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-50"
                        role="menu"
                    >
                        @guest
                            <div class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <a href="{{ route('login') }}"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                                role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-pink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                    </svg>
                                    Login
                                </a>
                                <a href="{{ route('register') }}"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                                role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-pink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 4.5v15m7.5-7.5h-15"/>
                                    </svg>
                                    Register
                                </a>
                            </div>
                        @endguest

                        @auth
                            <div class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-pink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
                                    </svg>
                                    Profile
                                </a>

                                <a href="{{ route('favorites') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-pink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5A4.72 4.72 0 0012 5.632 4.72 4.72 0 007.688 3.75C5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                    </svg>
                                    Favorites
                                </a>

                                <a href="{{ route('orders.history') }}" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-pink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    History
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600" role="menuitem">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>
