@props([
    'product',
    'imageUrl',
    'removeFavoriteAction' => null,
])

<div {{ $attributes->class('grid gap-16 lg:grid-cols-[minmax(0,480px)_minmax(0,1fr)] items-start') }}>
    <x-detail.product-gallery
        :src="$imageUrl"
        :alt="$product->name"
        />

    <x-detail.product-information
        :product="$product"
        :remove-favorite-action="$removeFavoriteAction"
    />
</div>
