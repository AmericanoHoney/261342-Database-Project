@props([
    'image',
    'category',
    'name',
    'price',
])

@php
    $formattedPrice = is_numeric($price) ? '$' . number_format((float) $price, 2) : $price;
@endphp

<article class="bg-white rounded-[40px] shadow-md overflow-hidden transition hover:shadow-lg w-full h-full items-center justify-center">
    <div class="relative">
        <img
            src="{{ $image }}"
            alt="{{ $name }}"
            class="w-full h-[260px] object-contain"
        />
        <div class="absolute top-3 right-3">
            @isset($favoriteAction)
                {{ $favoriteAction }}
            @else
                <div class="w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('images/fav.svg') }}" alt="Favorite" class="w-10 h-10">
                </div>
            @endisset
        </div>
    </div>

    <div class="px-6 py-4">
        <p class="text-sm text-[#626262]">{{ $category }}</p>
        <h3 class="text-lg font-semibold text-gray-900">{{ $name }}</h3>
        <p class="text-sm font-semibold text-[#B6487B]">{{ $formattedPrice }}</p>
    </div>
</article>
