@php
    $imagePath = $product->image_url ?? null;
    $imageUrl = $imagePath
        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : asset($imagePath))
        : asset('images/flowers/ex1.webp');
    $isFavorited = $isFavorited ?? false;
    $canFavorite = auth()->check() && $product->exists;
    $addFavoriteRoute = $canFavorite && ! $isFavorited
        ? route('favorites.store', $product)
        : null;
    $removeFavoriteRoute = $canFavorite && $isFavorited
        ? route('favorites.destroy', $product)
        : null;
@endphp

<x-app-layout>
    <section class="min-h-screen bg-white py-20">
        <div class="mx-auto flex max-w-6xl flex-col gap-12 px-6 tracking-wide">
            <div class="flex flex-wrap items-center justify-between gap-4">

                @if (session('status'))
                    <div class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700 shadow">
                        {{ session('status') }}
                    </div>
                @endif
            </div>

            <div class="rounded-[56px] bg-[#FDFDFD] p-12 shadow-[0_45px_95px_rgba(0,0,0,0.08)]">
                <x-detail.product-showcase
                    :product="$product"
                    :image-url="$imageUrl"
                    :is-favorite="$isFavorited"
                    :add-favorite-action="$addFavoriteRoute"
                    :remove-favorite-action="$removeFavoriteRoute"
                />
            </div>
        </div>
    </section>
</x-app-layout>
