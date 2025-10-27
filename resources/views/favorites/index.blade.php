<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-12 space-y-8">
        @if (session('status'))
            <div class="rounded-full bg-green-100 text-green-700 px-4 py-2 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 text-center">Favorite Collection</h1>
            </div>

            <x-filter.filter-button />
        </div>

        <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($favorites as $favorite)
                @php
                    $product = $favorite->product;
                    $imagePath = $product?->image_url;
                    $imageUrl = $imagePath
                        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : asset($imagePath))
                        : asset('images/flowers/ex1.webp');
                    $formId = $product ? 'remove-favorite-' . $product->getKey() : null;
                @endphp

                @if ($product)
                    <x-cards.flower
                        :image="$imageUrl"
                        :category="$product->category?->name ?? 'Uncategorized'"
                        :name="$product->name"
                        :price="$product->price"
                        :href="route('detail', $product)"
                    >
                        <x-slot name="favoriteAction">
                            <x-dialog.confirm-delete
                                :form-id="$formId"
                                title="Remove From Favorites?"
                                :message="__('Are you sure you want to remove :name from your favorites?', ['name' => $product->name])"
                                confirm-text="Yes"
                                cancel-text="No"
                            >
                                <x-slot name="trigger">
                                    <button
                                        type="button"
                                        class="w-10 h-10 flex items-center justify-center transition focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#B6487B]"
                                    >
                                        <img src="{{ asset('images/fav.svg') }}" alt="Remove from favorites" class="w-10 h-10">
                                    </button>
                                </x-slot>
                            </x-dialog.confirm-delete>
                        </x-slot>
                    </x-cards.flower>

                    <form
                        id="{{ $formId }}"
                        method="POST"
                        action="{{ route('favorites.destroy', $product) }}"
                        class="hidden"
                    >
                        @csrf
                        @method('DELETE')
                    </form>
                @else
                    <x-cards.flower
                        :image="$imageUrl"
                        :category="$product?->category?->name ?? 'Uncategorized'"
                        :name="$product?->name ?? 'Unknown Product'"
                        :price="$product?->price ?? 'N/A'"
                    />
                @endif
            @empty
                <p class="col-span-full text-center text-gray-500">No favorites yet. Start adding products to your favorites!</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
