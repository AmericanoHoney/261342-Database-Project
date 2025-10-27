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
    $availableStock = max(0, (int) ($product->stock ?? 0));
    $isInStock = $availableStock > 0;
    $badgeLabel = $isInStock ? __('In Stock') : __('Out of Stock');
    $badgeClasses = $isInStock
        ? 'inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1 text-xs font-semibold text-emerald-600'
        : 'inline-flex items-center rounded-full border border-[#DF0404] bg-[#FFC5C5] px-4 py-1 text-xs font-semibold text-[#DF0404]';
    $maxQuantity = $availableStock;
    $minQuantity = $isInStock ? 1 : 0;
    $initialQuantity = $isInStock ? 1 : 0;
    $favoriteButtonClasses = 'inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#B6487B] text-white transition hover:bg-[#9d3a68] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#B6487B] focus-visible:ring-offset-2';
@endphp

<div {{ $attributes->class('space-y-8') }}>
    <div class="flex flex-wrap items-center gap-3">
        <span class="{{ $badgeClasses }}">
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
                quantity: {{ $initialQuantity }},
                increase() {
                    if (this.quantity < {{ $maxQuantity }}) {
                        this.quantity++;
                    }
                },
                decrease() {
                    if (this.quantity > {{ $minQuantity }}) {
                        this.quantity--;
                    }
                }
            }"
            class="flex flex-wrap items-center gap-6"
        >
            <div class="inline-flex h-14 items-center gap-6 rounded-full bg-[#B6487B] px-6 text-white">
                <button
                    type="button"
                    @click="decrease()"
                    class="inline-flex h-10 w-10 items-center justify-center text-2xl font-light leading-none transition hover:text-white/80 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#B6487B]"
                >
                    &minus;
                </button>
                <span class="min-w-[24px] text-center text-lg font-semibold" x-text="quantity"></span>
                <button
                    type="button"
                    @click="increase()"
                    class="inline-flex h-10 w-10 items-center justify-center text-2xl font-light leading-none transition hover:text-white/80 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/80 focus-visible:ring-offset-2 focus-visible:ring-offset-[#B6487B]"
                >
                    +
                </button>
            </div>

            <form method="POST" action="{{ route('cart.store') }}" class="inline-block">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->getKey() }}">
                <input type="hidden" name="quantity" :value="quantity">
                <button
                    type="submit"
                    class="inline-flex h-14 min-w-[200px] items-center justify-center rounded-full bg-[#B6487B] px-10 text-base font-semibold text-white transition hover:bg-[#9d3a68] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#B6487B] focus-visible:ring-offset-2 {{ $isInStock ? '' : 'cursor-not-allowed opacity-60 hover:bg-[#B6487B]' }}"
                    @if (!$isInStock) disabled @endif
                >
                    {{ $isInStock ? __('Add to cart') : __('Out of stock') }}
                </button>
            </form>

            @if ($addFavoriteAction)
                <form method="POST" action="{{ $addFavoriteAction }}">
                    @csrf
                    <button
                        type="submit"
                        class="{{ $favoriteButtonClasses }}"
                        title="{{ __('Add to favorites') }}"
                        aria-label="{{ __('Add to favorites') }}"
                    >
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M21 8.25c0 4.5-5.25 7.5-9 12-3.75-4.5-9-7.5-9-12A5.25 5.25 0 0 1 7.5 3a5.235 5.235 0 0 1 4.5 2.25A5.235 5.235 0 0 1 16.5 3 5.25 5.25 0 0 1 21 8.25Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
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
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M21 8.25c0 4.5-5.25 7.5-9 12-3.75-4.5-9-7.5-9-12A5.25 5.25 0 0 1 7.5 3a5.235 5.235 0 0 1 4.5 2.25A5.235 5.235 0 0 1 16.5 3 5.25 5.25 0 0 1 21 8.25Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
