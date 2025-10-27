@props([
    'product',
    'imageUrl',
    'isFavorite' => false,
    'addFavoriteAction' => null,
    'removeFavoriteAction' => null,
])

<div {{ $attributes->class('grid gap-16 items-start lg:grid-cols-[minmax(0,480px)_minmax(0,1fr)] lg:items-center') }}>
    <x-detail.product-gallery
        :src="$imageUrl"
        :alt="$product->name"
        />

    <x-detail.product-information
        :product="$product"
        :is-favorite="$isFavorite"
        :add-favorite-action="$addFavoriteAction"
        :remove-favorite-action="$removeFavoriteAction"
    />
</div>
