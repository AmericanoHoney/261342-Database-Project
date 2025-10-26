<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white shadow-md rounded-2xl p-8 border border-pink-200">
        <h3 class="text-2xl font-semibold text-pink-600 mb-6 border-b border-pink-100 pb-3">
            Order Summary
        </h3>

        {{-- ตารางสินค้า --}}
        <table class="min-w-full text-gray-700">
            <thead class="border-b border-pink-100 text-sm uppercase text-gray-500">
                <tr>
                    <th class="text-left py-3">Product</th>
                    <th class="text-center py-3">Qty</th>
                    <th class="text-right py-3">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->items as $item)
                    <tr class="border-b border-pink-100">
                        <td class="py-3">{{ $item->product->name }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->subtotal(), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ฟอร์มข้อมูลจัดส่ง --}}
        <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" class="mt-8 space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600 mb-1 text-sm">Delivery Date</label>
                    <input type="date" name="delivery_date"
                        class="w-full border border-pink-200 rounded-lg p-2 focus:ring-1 focus:ring-pink-400 focus:border-pink-400" required>
                </div>

                <div>
                    <label class="block text-gray-600 mb-1 text-sm">Delivery Time</label>
                    <input type="time" name="delivery_time"
                        class="w-full border border-pink-200 rounded-lg p-2 focus:ring-1 focus:ring-pink-400 focus:border-pink-400" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-600 mb-1 text-sm">Address</label>
                <textarea name="address" rows="2"
                    class="w-full border border-pink-200 rounded-lg p-2 focus:ring-1 focus:ring-pink-400 focus:border-pink-400"
                    required></textarea>
            </div>

            <div>
                <label class="block text-gray-600 mb-1 text-sm">Promotion</label>
                <select name="promotion_id"
                    class="w-full border border-pink-200 rounded-lg p-2 focus:ring-1 focus:ring-pink-400 focus:border-pink-400">
                    <option value="">None</option>
                    @foreach ($promotions as $promo)
                        <option value="{{ $promo->promotion_id }}">
                            {{ $promo->name }} ({{ $promo->discount_percent }}% OFF)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-right mt-4 text-lg">
                <p class="font-semibold text-gray-700">Subtotal:
                    <span class="text-pink-600">${{ number_format($subtotal, 2) }}</span>
                </p>
            </div>

            <div class="flex justify-end gap-4 mt-8">
            

                <button type="button" id="confirmCheckout"
                    class="px-6 py-2 bg-pink-500 text-white rounded-full font-semibold hover:bg-pink-600 transition">
                    Confirm Order
                </button>
            </div>
        </form>
    </div>

    {{-- SweetAlert2 Popup --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const subtotal = {{ $subtotal }};
        const promotions = @json($promotions);

        document.getElementById('confirmCheckout').addEventListener('click', () => {
            const form = document.getElementById('checkout-form');
            const selectedPromoId = form.promotion_id.value;
            const promo = promotions.find(p => p.promotion_id == selectedPromoId);
            const discountRate = promo ? promo.discount_percent / 100 : 0;
            const discount = subtotal * discountRate;
            const total = subtotal - discount;

            Swal.fire({
                title: 'Confirm Your Order 💐',
                html: `
                    <div style="font-size:15px;text-align:left;line-height:1.6;color:#444;">
                        <p><b>Subtotal:</b> $${subtotal.toFixed(2)}</p>
                        <p><b>Discount:</b> -$${discount.toFixed(2)} (${promo ? promo.name : 'None'})</p>
                        <hr style="margin:10px 0;border-color:#f4c2d7">
                        <p style="font-size:16px"><b>Total:</b>
                            <span style="color:#ea5b91;font-weight:bold">$${total.toFixed(2)}</span>
                        </p>
                        <p style="color:#888;font-size:13px;margin-top:8px;">Confirm and place your order?</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Yes, Confirm',
                cancelButtonText: 'Cancel',
                showCancelButton: true,
                confirmButtonColor: '#ea5b91',
                cancelButtonColor: '#aaa',
                background: '#fff',
                border: '1px solid #f4c2d7',
                customClass: {
                    popup: 'rounded-2xl shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
</x-app-layout>
