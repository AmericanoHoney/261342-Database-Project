@php
    $favoriteFlowers = [
        [
            'name' => 'Eternal Rose',
            'category' => 'Romantic',
            'price' => 39.49,
            'image' => asset('images/flowers/ex1.webp'),
        ],
        [
            'name' => 'Morning Dew',
            'category' => 'Classic',
            'price' => 5.90,
            'image' => asset('images/flowers/morning-dew.jpg'),
        ],
        [
            'name' => 'Blossom Charm',
            'category' => 'Celebration',
            'price' => 8.50,
            'image' => asset('images/flowers/blossom-charm.jpg'),
        ],
        [
            'name' => 'Sweet Peony',
            'category' => 'Pastel',
            'price' => 7.20,
            'image' => asset('images/flowers/sweet-peony.jpg'),
        ],
        [
            'name' => 'Lavender Dream',
            'category' => 'Relaxing',
            'price' => 6.80,
            'image' => asset('images/flowers/lavender-dream.jpg'),
        ],
        [
            'name' => 'Sunshine Bloom',
            'category' => 'Vibrant',
            'price' => 10.50,
            'image' => asset('images/flowers/sunshine-bloom.jpg'),
        ],
        [
            'name' => 'Pastel Garden',
            'category' => 'Seasonal',
            'price' => 9.90,
            'image' => asset('images/flowers/pastel-garden.jpg'),
        ],
        [
            'name' => 'White Whisper',
            'category' => 'Minimal',
            'price' => 7.80,
            'image' => asset('images/flowers/white-whisper.jpg'),
        ],
    ];
@endphp

<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 text-center">Favorite Collection</h1>
            </div>

            <button
                type="button"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-full shadow-sm text-sm text-gray-700 hover:border-gray-300"
            >
                Filter
                <span class="inline-block w-2.5 h-2.5 border-b-2 border-r-2 border-current rotate-45 translate-y-[1px]"></span>
            </button>
        </div>

        <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($favoriteFlowers as $flower)
                <x-cards.flower
                    :image="$flower['image']"
                    :category="$flower['category']"
                    :name="$flower['name']"
                    :price="$flower['price']"
                />
            @endforeach
        </div>
    </div>
</x-app-layout>
