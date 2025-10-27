@props([
    'product',
    'isFavorite' => false,
    'addFavoriteAction' => null,
    'removeFavoriteAction' => null,
])

@php
    $categoryName = $product->category->name ?? __('Flower Bouquets');
    $description = $product->description
        ?? __('No description available for this product yet. Check back soon for more details.');
    $price = number_format((float) $product->price, 2);
    $isInStock = (int) ($product->stock ?? 0) > 0;
    $badgeLabel = $isInStock ? __('In Stock') : __('Out of Stock');
    $maxQuantity = max(1, (int) ($product->stock ?? 1));
    $favoriteButtonClasses = 'inline-flex h-14 w-14 items-center justify-center rounded-full border border-[#B6487B] transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#B6487B] focus-visible:ring-offset-2';
    $favoriteButtonClasses .= $isFavorite ? ' bg-[#B6487B]/10 hover:bg-[#B6487B]/20' : ' hover:bg-[#B6487B]/10';
@endphp

<div {{ $attributes->class('space-y-8') }}>
    <div class="flex flex-wrap items-center gap-3">
        <span class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1 text-xs font-semibold text-emerald-600">
            {{ $badgeLabel }}
        </span>
        <span class="text-sm font-medium text-gray-400">{{ $categoryName }}</span>
    </div>

    <div>
        <h1 class="text-5xl font-semibold text-gray-900">{{ $product->name }}</h1>
        <p class="mt-4 text-3xl font-semibold text-gray-800">${{ $price }}</p>
    </div>

    <p class="text-sm leading-7 text-gray-500">
        {{ $description }}
    </p>

    <div class="pt-4">
        <div
            x-data="{
                quantity: 1,
                increase() {
                    if (this.quantity < {{ $maxQuantity }}) {
                        this.quantity++;
                    }
                },
                decrease() {
                    if (this.quantity > 1) {
                        this.quantity--;
                    }
                }
            }"
            class="flex flex-wrap items-center gap-4"
        >
            <div class="inline-flex h-14 items-center gap-6 rounded-full bg-[#B6487B] px-8 text-white shadow-[0_20px_30px_rgba(182,72,123,0.25)]">
                <button
                    type="button"
                    @click="decrease()"
                    class="text-xl font-semibold transition hover:text-white/80"
                >
                    &minus;
                </button>
                <span class="w-8 text-center text-lg font-semibold" x-text="quantity"></span>
                <button
                    type="button"
                    @click="increase()"
                    class="text-xl font-semibold transition hover:text-white/80"
                >
                    +
                </button>
            </div>

            <a
                href="{{ route('cart') }}"
                class="inline-flex h-14 items-center rounded-full bg-[#B6487B] px-10 text-sm font-semibold text-white shadow-[0_18px_35px_rgba(182,72,123,0.22)] transition hover:bg-[#9d3a68]"
            >
                {{ __('Add to cart') }}
            </a>

            @if ($addFavoriteAction)
                <form method="POST" action="{{ $addFavoriteAction }}">
                    @csrf
                    <button
                        type="submit"
                        class="{{ $favoriteButtonClasses }}"
                        title="{{ __('Add to favorites') }}"
                        aria-label="{{ __('Add to favorites') }}"
                    >
                        <img src="{{ asset('images/fav.svg') }}" alt="Favorite icon" class="h-8 w-8">
                    </button>
                </form>
            @elseif ($removeFavoriteAction)
                <form method="POST" action="{{ $removeFavoriteAction }}">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="{{ $favoriteButtonClasses }}"
                        title="{{ __('Remove from favorites') }}"
                        aria-label="{{ __('Remove from favorites') }}"
                    >
                        <img src="{{ asset('images/fav.svg') }}" alt="Favorite icon" class="h-8 w-8">
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
