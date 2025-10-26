@props([
    'product',
    'removeFavoriteAction' => null,
])

@php
    $categoryName = $product->category->name ?? __('Flower Bouquets');
    $description = $product->description
        ?? __('No description available for this product yet. Check back soon for more details.');
    $price = number_format((float) $product->price, 2);
    $isInStock = (int) ($product->stock ?? 0) > 0;
    $badgeLabel = $isInStock ? __('In Stock') : __('Out of Stock');
    $favoriteFormId = $removeFavoriteAction ? 'remove-favorite-'.uniqid() : null;
    $maxQuantity = max(1, (int) ($product->stock ?? 1));
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
            <div class="inline-flex items-center gap-6 rounded-full bg-[#B6487B] px-7 py-3 text-white shadow-[0_20px_30px_rgba(182,72,123,0.25)]">
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
                class="inline-flex items-center rounded-full bg-[#B6487B] px-9 py-3 text-sm font-semibold text-white shadow-[0_18px_35px_rgba(182,72,123,0.22)] transition hover:bg-[#9d3a68]"
            >
                {{ __('Add to cart') }}
            </a>

            @if ($removeFavoriteAction)
                <form id="{{ $favoriteFormId }}" method="POST" action="{{ $removeFavoriteAction }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                <img src="images/fav.svg" alt="images/fav.svg">
            @endif
        </div>
    </div>
</div>
