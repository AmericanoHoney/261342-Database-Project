<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-center mb-8">All Products</h1>

        {{-- Search + Filter + Sort --}}
        <form method="GET" class="flex flex-wrap justify-center gap-3 mb-10">
            <div class="relative w-full md:w-1/2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name or keyword..."
                    class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                />
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>

            <select name="category"
                class="px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                <option value="">Filter</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort"
                class="px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                <option value="">Sort</option>
                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Price: Low → High</option>
                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Price: High → Low</option>
                <option value="name_asc" {{ request('sort')=='name_asc'?'selected':'' }}>Name: A → Z</option>
                <option value="name_desc" {{ request('sort')=='name_desc'?'selected':'' }}>Name: Z → A</option>
            </select>

            <button type="submit"
                class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-3 rounded-full">
                Search
            </button>
        </form>

        {{-- Product grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 justify-items-center">
            @forelse($products as $product)
                <a href="{{ route('detail', $product) }}" class="block focus:outline-none focus:ring-2 focus:ring-pink-500 rounded-[40px]">
                    <x-cards.product-card
                        :image="asset($product->image_url)"
                        :category="$product->category->name ?? 'Unknown'"
                        :name="$product->name"
                        :price="$product->price"
                    />
                </a>
            @empty
                <p class="text-gray-500 col-span-full text-center">No products found.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    </section>
</x-app-layout>
