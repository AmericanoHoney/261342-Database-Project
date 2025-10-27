<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-3xl text-[#000000] text-center leading-tight">
      Order Summary
    </h2>
  </x-slot>

  <div class="bg-white min-h-screen">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-2xl p-4 border border-[#E2E2E2]">

      {{-- ตารางสินค้า --}}
      <table class="w-full border-collapse text-black">
        <thead>
          <tr class="bg-pink-600 text-white text-center">
            <th class="py-3 px-5 rounded-tl-2xl">Product</th>
            <th class="py-3 px-5">Qty</th>
            <th class="py-3 px-5 rounded-tr-2xl">Price</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-[#E2E2E2]">
          @foreach ($cart->items as $item)
            <tr>
              <td class="py-3 px-4 text-left">{{ $item->product->name }}</td>
              <td class="text-center">{{ $item->quantity }}</td>
              <td class="text-right">${{ number_format($item->subtotal(), 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {{-- ฟอร์มข้อมูลจัดส่ง --}}
      <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" class="mt-10 space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-6">
          <div>
            <label class="block text-black mb-1 text-sm font-medium">Delivery Date</label>
            <input type="date" name="delivery_date"
              class="w-full border border-pink-200 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition"
              required>
          </div>

          <div>
            <label class="block text-black mb-1 text-sm font-medium">Delivery Time</label>
            <input type="time" name="delivery_time"
              class="w-full border border-pink-200 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition"
              required>
          </div>
        </div>

        <div>
          <label class="block text-black mb-1 text-sm font-medium">Address</label>
          <textarea name="address" rows="2"
            class="w-full border border-pink-200 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition"
            required></textarea>
        </div>

        <div>
          <label class="block text-black mb-1 text-sm font-medium">Promotion</label>
          <select name="promotion_id"
            class="w-full border border-pink-200 rounded-lg p-2.5 bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition">
            <option value="">None</option>
            @foreach ($promotions as $promo)
              <option value="{{ $promo->promotion_id }}">
                {{ $promo->name }} ({{ $promo->discount_percent }}% OFF)
              </option>
            @endforeach
          </select>
        </div>

        <div class="text-right mt-4 text-lg">
          <p class="font-semibold text-gray-700">
            Subtotal:
            <span class="text-pink-600">${{ number_format($subtotal, 2) }}</span>
          </p>
        </div>

        {{-- ปุ่มยืนยัน + กลับ --}}
        <div class="flex justify-end gap-4 mt-8">
          <a href="{{ route('cart.index') }}"
            class="px-6 py-2.5 rounded-full font-semibold border border-pink-400 text-pink-600 hover:bg-pink-700 hover:shadow transition">
            ← Back to Cart
          </a>

          <button type="button" id="confirmCheckout"
            class="px-8 py-2.5 bg-pink-600 text-white rounded-full font-semibold shadow-md hover:bg-pink-700 hover:shadow-lg transition">
            Confirm Order
          </button>
        </div>
      </form>
    </div>
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
        title: '<span style="color:#B6487B;font-weight:600;">Confirm Your Order 🌸</span>',
        html: `
          <div style="font-size:15px;text-align:left;line-height:1.6;color:#444;">
            <p><b>Subtotal:</b> $${subtotal.toFixed(2)}</p>
            <p><b>Discount:</b> -$${discount.toFixed(2)} (${promo ? promo.name : 'None'})</p>
            <hr style="margin:10px 0;border-color:#f4c2d7;">
            <p style="font-size:16px"><b>Total:</b>
              <span style="color:#B6487B;font-weight:bold">$${total.toFixed(2)}</span>
            </p>
            <p style="color:#999;font-size:13px;margin-top:10px;">Confirm and place your order?</p>
          </div>
        `,
        icon: 'info',
        confirmButtonText: 'Yes, Confirm',
        cancelButtonText: 'Cancel',
        showCancelButton: true,
        confirmButtonColor: '#B6487B',
        cancelButtonColor: '#bbb',
        background: '#ffffff',
        border: '1px solid #f4c2d7',
        customClass: {
          popup: 'rounded-2xl shadow-lg',
          confirmButton: 'px-5 py-2 font-semibold rounded-full',
          cancelButton: 'px-5 py-2 font-semibold rounded-full',
        }
      }).then((result) => {
        if (result.isConfirmed) form.submit();
      });
    });
  </script>
</x-app-layout>
