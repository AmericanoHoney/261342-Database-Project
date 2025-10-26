@php
    $imagePath = $product->image_url ?? null;
    $imageUrl = $imagePath
        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : asset($imagePath))
        : asset('images/flowers/ex1.webp');
@endphp

<x-app-layout>
    <div class="max-w-5xl mx-auto px-6 py-12 space-y-8">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('favorites') }}" class="text-sm text-[#B6487B] hover:underline">&larr; Back to favorites</a>
            @if (session('status'))
                <div class="rounded-full bg-green-100 text-green-700 px-4 py-2 text-sm">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="grid gap-10 md:grid-cols-2 items-start">
            <div class="bg-white rounded-[40px] shadow-md overflow-hidden">
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover"
                />
            </div>

            <div class="space-y-6">
                <div>
                    <p class="text-sm text-gray-500">{{ $product->category?->name ?? 'Uncategorized' }}</p>
                    <h1 class="text-3xl font-semibold text-gray-900 mt-2">{{ $product->name }}</h1>
                </div>

                <p class="text-2xl font-semibold text-[#B6487B]">${{ number_format((float) $product->price, 2) }}</p>

                <div class="text-sm text-gray-600 leading-relaxed">
                    {{ $product->description ?? 'No description available for this product yet.' }}
                </div>

                <form method="POST" action="{{ route('favorites.destroy', $product) }}" class="pt-4">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-[#B6487B] text-white font-semibold shadow hover:bg-[#9d3a68] transition"
                    >
                        Remove from favorites
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
