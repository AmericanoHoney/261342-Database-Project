<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-center mb-8">All Products</h1>

        {{-- Search + Filter + Sort --}}
        <form method="GET"
            class="flex flex-wrap items-center justify-center gap-3 mb-10">

            {{-- Search: กว้างสุด ดันองค์ประกอบอื่น --}}
            <div class="relative flex-1 min-w-[220px]">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search"
                    class="w-full h-11 pl-10 pr-4 rounded-full border border-gray-300 text-sm
                        placeholder-gray-400
                        focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600"
                />
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
            </div>

            {{-- Category Filter --}}
            <div class="relative">
                <select name="category"
                    class="h-11 pl-4 pr-10 rounded-full text-sm border border-gray-300 bg-white
                        min-w-[190px] md:min-w-[220px]
                        focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600 appearance-none">
                    <option value="" {{ request()->filled('category') ? '' : 'selected' }}>Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}"
                            {{ (string)request('category') === (string)$cat->category_id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.188l3.71-3.96a.75.75 0 111.08 1.04l-4.23 4.51a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                </svg>
            </div>

            {{-- Sort --}}
            <div class="relative">
                <select name="sort"
                    class="h-11 pl-4 pr-10 rounded-full text-sm border border-gray-300 bg-white
                        min-w-[200px] md:min-w-[230px]
                        focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-pink-600 appearance-none">
                    <option value="">Sort</option>
                    <option value="price_asc"  {{ request('sort')=='price_asc'  ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                    <option value="name_asc"   {{ request('sort')=='name_asc'   ? 'selected' : '' }}>Name: A → Z</option>
                    <option value="name_desc"  {{ request('sort')=='name_desc'  ? 'selected' : '' }}>Name: Z → A</option>
                </select>
                <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-pink-600"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.188l3.71-3.96a.75.75 0 111.08 1.04l-4.23 4.51a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                </svg>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="h-11 px-6 rounded-full bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium
                    transition focus:outline-none focus:ring-2 focus:ring-pink-600 focus:ring-offset-1">
                Search
            </button>
        </form>


        {{-- Product grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                <a href="{{ route('detail', $product) }}" class="block focus:outline-none focus:ring-2 focus:ring-pink-500 rounded-[40px]">
                    <x-cards.product-card
                        :image="$product->image_url"
                        :category="$product->category->name ?? 'Unknown'"
                        :name="$product->name"
                        :price="$product->price"
                    :product-id="$product->product_id"
                    :is-favorited="(bool) ($product->is_favorited ?? false)"/>
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
