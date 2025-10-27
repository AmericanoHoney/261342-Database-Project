<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-3xl text-[#3D3D3D] text-center leading-tight">
      My Shopping Cart
    </h2>
  </x-slot>

  <div class="bg-[#F7F6F8] min-h-screen">
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
        <table class="w-full border-collapse text-gray-700">
          <thead>
            <tr class="bg-pink-600 text-white text-center">
              <th class="py-3 px-5 rounded-tl-lg">Product</th>
              <th class="py-3 px-5">Price</th>
              <th class="py-3 px-5">Quantity</th>
              <th class="py-3 px-5">Subtotal</th>
              <th class="py-3 px-5 rounded-tr-lg">Action</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-[#E2E2E2]">
            @foreach ($cart->items as $item)
              <tr data-item="{{ $item->cart_id }}-{{ $item->product_id }}" class="hover:bg-pink-50 transition">
                <td class="py-4 px-5 flex items-center space-x-3">
                  <img src="{{ asset($item->product->image_url ?? 'images/default.png') }}"
                                    <img src="{{ $item->product->image_url ?? asset('images/default.png') }}"
                       class="w-12 h-12 object-cover rounded-md border border-pink-100"
                       loading="lazy">
                  <div>
                    <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-500">{{ $item->product->description }}</p>
                  </div>
                </td>

                <td class="py-4 px-5 text-center">${{ number_format($item->product->price, 2) }}</td>

                <td class="py-4 px-5 text-center">
                  <div class="inline-flex items-center border border-pink-300 rounded-full bg-white shadow-sm">
                    <button type="button"
                            class="px-3 py-1 text-pink-600 font-bold hover:bg-pink-100 transition"
                            onclick="updateQuantity({{ $item->cart_id }}, {{ $item->product_id }}, -1)">−</button>

                    <span id="qty-{{ $item->cart_id }}-{{ $item->product_id }}"
                          class="w-8 inline-block text-center font-medium text-gray-700">
                      {{ $item->quantity }}
                    </span>

                    <button type="button"
                            class="px-3 py-1 text-pink-600 font-bold hover:bg-pink-100 transition"
                            onclick="updateQuantity({{ $item->cart_id }}, {{ $item->product_id }}, 1)">+</button>
                  </div>
                </td>

                <td class="py-4 px-5 text-center font-medium text-gray-700"
                    id="subtotal-{{ $item->cart_id }}-{{ $item->product_id }}"
                    data-price="{{ $item->product->price }}">
                  ${{ number_format($item->subtotal(), 2) }}
                </td>

                <td class="py-4 px-5 text-center">
                  <button class="text-red-500 hover:text-red-700 font-semibold"
                          onclick="removeItem({{ $item->cart_id }}, {{ $item->product_id }})">
                    Remove
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="flex justify-between items-center mt-6">
          <p class="text-lg font-semibold text-gray-800">
            Total: <span id="cart-total">${{ number_format($cart->total(), 2) }}</span>
          </p>
          <a href="/checkout"
             class="px-6 py-2 bg-pink-600 text-white rounded-full font-semibold shadow hover:bg-pink-700 transition">
            Proceed to Checkout
          </a>
        </div>
      @endif
    </div>
  </div>

  {{-- SweetAlert2 + JS --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  async function updateQuantity(cartId, productId, change) {
    const qty = document.getElementById(`qty-${cartId}-${productId}`);
    const subtotal = document.getElementById(`subtotal-${cartId}-${productId}`);
    const total = document.getElementById('cart-total');
    const newQty = Math.max(1, parseInt(qty.textContent) + change);
    const price = parseFloat(subtotal.dataset.price);

    try {
      const res = await fetch(`/cart/update/${cartId}/${productId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: newQty })
      });

      if (!res.ok) throw new Error();
      const data = await res.json();

      // ✅ Update quantity + subtotal
      qty.textContent = data.quantity;
      subtotal.textContent = `$${(price * data.quantity).toFixed(2)}`;

      // ✅ Update total (sum of all subtotals)
      let sum = 0;
      document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
        sum += parseFloat(el.textContent.replace('$', '')) || 0;
      });
      total.textContent = `$${sum.toFixed(2)}`;

    } catch {
      Swal.fire('Error', 'Unable to update quantity', 'error');
    }
  }

  async function removeItem(cartId, productId) {
    Swal.fire({
      title: 'Remove this item?',
      text: 'Are you sure you want to delete this product?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e85a8e',
      cancelButtonColor: '#aaa',
      confirmButtonText: 'Yes, remove it'
    }).then(async (result) => {
      if (!result.isConfirmed) return;

      try {
        const res = await fetch(`/cart/remove/${cartId}/${productId}`, {
          method: 'DELETE',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        if (!res.ok) throw new Error();

        // ✅ ลบแถวสินค้าออกจาก DOM
        document.querySelector(`tr[data-item="${cartId}-${productId}"]`)?.remove();

        // ✅ คำนวณราคารวมใหม่
        let sum = 0;
        document.querySelectorAll('[id^="subtotal-"]').forEach(el => {
          sum += parseFloat(el.textContent.replace('$', '')) || 0;
        });
        document.getElementById('cart-total').textContent = `$${sum.toFixed(2)}`;

        // ✅ ถ้าไม่มีสินค้าคงเหลือ reload เพื่อโชว์ข้อความ "empty"
        if (sum === 0) location.reload();

        Swal.fire('Removed!', 'Item removed successfully.', 'success');
      } catch {
        Swal.fire('Error', 'Something went wrong', 'error');
      }
    });
  }
  </script>
                <div class="flex justify-between items-center mt-6">
                    <p class="text-lg font-semibold text-gray-800">
                        Total: ${{ number_format($cart->total(), 2) }}
                    </p>
                    <a href="/checkout"
                       class="px-6 py-2 bg-pink-600 text-white rounded-full font-semibold hover:bg-[#b25d7d] transition">
                       Proceed to Checkout
                    </a>
                </div>
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
