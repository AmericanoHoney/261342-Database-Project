<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-[#3D3D3D] text-center leading-tight ">
            My Shopping Cart
        </h2>
    </x-slot>

    <div class=" bg-[#F7F6F8] min-h-screen">
        <div class="max-w-5xl mx-auto space-y-4 py-6">
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-6 py-4 text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-2xl p-4 border border-[#E2E2E2]">
            @if ($cart->items->isEmpty())
                <div class="text-center py-20 text-gray-500 italic text-lg">
                    Your cart is empty 💔
                </div>
            @else
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-[#C46A8A] text-white text-left">
                            <th class="py-3 px-5 rounded-tl-lg">Product</th>
                            <th class="py-3 px-5">Price</th>
                            <th class="py-3 px-5">Quantity</th>
                            <th class="py-3 px-5 text-right rounded-tr-lg">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E2E2E2]">
                        @foreach ($cart->items as $item)
                            <tr class="hover:bg-[#F7F6F8] transition">
                                <td class="py-4 px-5 flex items-center space-x-3">
                                    <img src="{{ $item->product->image_url ?? asset('images/default.png') }}"
                                         class="w-12 h-12 object-cover rounded-md border">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->product->description }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-gray-700">
                                    ${{ number_format($item->product->price, 2) }}
                                </td>
                                <td class="py-4 px-5 text-gray-700">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-4 px-5 text-right text-gray-700">
                                    ${{ number_format($item->subtotal(), 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-between items-center mt-6">
                    <p class="text-lg font-semibold text-gray-800">
                        Total: ${{ number_format($cart->total(), 2) }}
                    </p>
                    <a href="/checkout"
                       class="px-6 py-2 bg-[#C46A8A] text-white rounded-full font-semibold hover:bg-[#b25d7d] transition">
                       Proceed to Checkout
                    </a>
                </div>
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
