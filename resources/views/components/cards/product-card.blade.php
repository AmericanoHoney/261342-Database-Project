@props([
    'image',
    'category',
    'name',
    'price',
    'productId' => null,
    'isFavorited' => false,
])

@php
    $formattedPrice = is_numeric($price) ? '$' . number_format((float) $price, 2) : $price;
@endphp

<article class="bg-white rounded-[40px] shadow-md overflow-hidden transition hover:shadow-lg w-full h-full">
    <div class="relative">
        <img
            src="{{ $image }}"
            alt="{{ $name }}"
            class="w-full h-[260px] object-cover block"
        />

        {{-- ปุ่ม Favorite ด้านขวาบน --}}
        <div class="absolute top-3 right-3 z-10 pointer-events-auto">
            <x-buttons.favorite-button
                :product-id="$productId"
                :is-favorited="$isFavorited"
            />
        </div>
    </div>

    <div class="px-6 py-4">
        <p class="text-sm text-[#626262]">{{ $category }}</p>
        <h3 class="text-lg font-semibold text-gray-900">{{ $name }}</h3>
        <p class="text-sm font-semibold text-[#B6487B]">{{ $formattedPrice }}</p>
    </div>
</article>
