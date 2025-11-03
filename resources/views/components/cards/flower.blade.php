@props([
    'image',
    'category',
    'name',
    'price',
    'href' => null,
])

@php
    $formattedPrice = is_numeric($price) ? '$' . number_format((float) $price, 2) : $price;
@endphp

<article {{ $attributes->merge(['class' => 'bg-white rounded-[40px] shadow-md overflow-hidden transition hover:shadow-lg w-[260px]']) }}>
    <div class="relative">
        @if ($href)
            <a
                href="{{ $href }}"
                class="block focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white rounded-[40px]"
            >
                <img
                    src="{{ $image }}"
                    alt="{{ $name }}"
                    class="w-[260px] h-[260px] object-cover"
                />
            </a>
        @else
            <img
                src="{{ $image }}"
                alt="{{ $name }}"
                class="w-[260px] h-[260px] object-cover"
            />
        @endif
        <div class="absolute top-3 right-3">
            @isset($favoriteAction)
                {{ $favoriteAction }}
            @else
                <div class="w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('images/icon/liked.png') }}" alt="Favorite" class="w-10 h-10">
                </div>
            @endisset
        </div>
    </div>

    <div class="px-6 py-4">
        @if ($href)
            <a
                href="{{ $href }}"
                class="block space-y-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-pink-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white rounded-3xl px-2 -mx-2 -my-1 py-1"
            >
                <p class="text-sm text-[#626262]">{{ $category }}</p>
                <h3 class="text-lg font-semibold text-gray-900">{{ $name }}</h3>
                <p class="text-sm font-semibold text-[#B6487B]">{{ $formattedPrice }}</p>
            </a>
        @else
            <p class="text-sm text-[#626262]">{{ $category }}</p>
            <h3 class="text-lg font-semibold text-gray-900">{{ $name }}</h3>
            <p class="text-sm font-semibold text-[#B6487B]">{{ $formattedPrice }}</p>
        @endif
    </div>
</article>
