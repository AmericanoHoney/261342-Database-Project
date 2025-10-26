@props([
    'image',
    'category',
    'name',
    'price',
])

@php
    $formattedPrice = is_numeric($price) ? '$' . number_format((float) $price, 2) : $price;
@endphp

<article class="bg-white rounded-[40px] shadow-md overflow-hidden transition hover:shadow-lg w-[260px]">
    <div class="relative">
        <img
            src="{{ $image }}"
            alt="{{ $name }}"
            class="w-[260px] h-[260px] object-cover"
        />
        <div class="absolute top-3 right-3">

                <img src="/images/fav.svg" alt="">
        </div>
    </div>

    <div class="px-6 py-4">
        <p class="text-sm text-[#626262]">Category</p>
        <h3 class="text-lg font-semibold text-gray-900">{{ $name }}</h3>
        <p class="text-sm font-semibold text-[#B6487B]">{{ $formattedPrice }}</p>
    </div>
</article>
