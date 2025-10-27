<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-3xl text-[#3D3D3D] text-center leading-tight">
      Order History
    </h2>
  </x-slot>

  <div class="bg-white min-h-screen">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-2xl p-4 border border-[#E2E2E2]">
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-pink-600 text-white text-center">
            <th class="px-4 py-3 rounded-tl-lg">Order Date</th>
            <th class="px-4 py-3 ">Order ID</th>
            <th class="px-4 py-3 ">Total Amount</th>
            <th class="px-4 py-3 ">Order Status</th>
            <th class="px-4 py-3 rounded-tr-lg">Details</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-pink-100">
          @foreach ($orders as $order)
            <tr class="hover:bg-pink-50 transition duration-200">
              <td class="px-4 py-3 text-center text-gray-700">{{ $order->order_date->format('d M Y') }}</td>
              <td class="px-4 py-3 text-center font-medium text-gray-800">#{{ $order->order_id }}</td>
              <td class="px-4 py-3 text-center text-gray-700">${{ number_format($order->total_price, 2) }}</td>
              <td class="px-4 py-3 text-center">
                @php
                  $color = match($order->status) {
                      'Pending' => 'bg-gray-300 text-gray-700',
                      'Processing' => 'bg-yellow-200 text-yellow-800',
                      'Out for Delivery' => 'bg-blue-200 text-blue-800',
                      'Delivered' => 'bg-green-200 text-green-800',
                      'Completed' => 'bg-green-300 text-green-900',
                      'Cancelled' => 'bg-red-200 text-red-700',
                      default => 'bg-gray-100 text-gray-600'
                  };
                @endphp
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                  {{ $order->status }}
                </span>
              </td>
              <td class="px-4 py-3 text-center">
                <button
                  onclick="showOrderDetails({{ $order->order_id }})"
                  class="px-4 py-1 bg-pink-600 text-white rounded-full font-medium shadow-sm hover:shadow-md transition">
                  Show Details
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- SweetAlert2 Popup --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  async function showOrderDetails(orderId) {
    try {
      const response = await fetch(`/orders/${orderId}`);
      const order = await response.json();

      const fmt = (v) => Number(v ?? 0).toFixed(2);
      const orderDate = new Date(order.order_date).toLocaleString('en-US', {
        day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
      });
      const deliveryDate = order.delivery_date
        ? new Date(order.delivery_date).toLocaleString('en-US', {
            day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
          })
        : '-';

      // สีของสถานะ
      const statusColors = {
        'Pending': 'background:#e5e7eb;color:#374151;',
        'Processing': 'background:#fef3c7;color:#92400e;',
        'Out for Delivery': 'background:#dbeafe;color:#1e40af;',
        'Delivered': 'background:#bbf7d0;color:#065f46;',
        'Completed': 'background:#86efac;color:#14532d;',
        'Cancelled': 'background:#fecaca;color:#7f1d1d;',
        'default': 'background:#f3f4f6;color:#4b5563;'
      };
      const statusStyle = statusColors[order.status] || statusColors.default;

      const promoText = order.promotions?.length
        ? order.promotions.map(p => `${p.name} (${p.discount_percent}% off)`).join(', ')
        : 'No Promotion Applied';

      const productRows = order.details.map(d => `
        <div style="display:flex;align-items:center;justify-content:space-between;margin:6px 0;">
          <div style="display:flex;align-items:center;gap:10px;">
            <img src="${d.image_url ?? '/images/default-product.png'}"
                style="width:45px;height:45px;border-radius:10px;border:1px solid #fbd3de;object-fit:cover;">
            <div>
              <div style="font-weight:600;font-size:0.9rem;color:#444;">${d.product_name}</div>
              <div style="font-size:0.8rem;color:#999;">x${d.quantity} • $${fmt(d.unit_price)}</div>
            </div>
          </div>
          <div style="font-weight:500;font-size:0.9rem;color:#444;">$${fmt(d.subtotal)}</div>
        </div>
      `).join('');

      Swal.fire({
        html: `
          <div style="font-family:'Poppins','Kanit',sans-serif;color:#333;text-align:left;max-width:600px;">
            <h2 style="text-align:center;margin-bottom:14px;color:#B6487B;font-weight:700;font-size:1.3rem;">
              Order Details
            </h2>

            <div style="
              background:#ffffff;
              border:1px solid #fbd3de;
              border-radius:12px;
              padding:14px 18px;
              margin-bottom:14px;
              line-height:1.6;
              font-size:0.9rem;
            ">
              <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:6px;">
                <p style="margin:0;"><b>Order ID:</b> #${order.order_id}</p>
                <span style="padding:2px 10px;border-radius:9999px;font-weight:600;font-size:0.85rem;${statusStyle}">
                  ${order.status}
                </span>
              </div>
              <p style="margin:2px 0;"><b>Order Date:</b> ${orderDate}</p>
              <p style="margin:2px 0;"><b>Delivery Date:</b> ${deliveryDate}</p>
              <p style="margin:2px 0;"><b>Address:</b> ${order.address || '-'}</p>
            </div>

            <div style="border:1px solid #fbd3de;border-radius:12px;padding:10px 14px;background:#fff;">
              ${productRows}
            </div>

            <div style="margin-top:10px;border-top:1px solid #f2c8d5;padding-top:8px;">
              <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin:3px 0;">
                <span>Items</span><span>${order.details.length}</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin:3px 0;">
                <span>Subtotal</span><span>$${fmt(order.subtotal)}</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin:3px 0;color:#999;">
                <span>Discount</span>
                <span>${order.discount_percent > 0 
                    ? `-${order.discount_percent}% ($${fmt(order.final_total - order.subtotal)})` 
                    : '$0.00'}</span>
              </div>
              <hr style="border-color:#fbd3de;margin:6px 0;">
              <div style="display:flex;justify-content:space-between;font-size:1rem;font-weight:600;">
                <span>Total</span><span style="color:#B6487B;">$${fmt(order.final_total)}</span>
              </div>
            </div>

            <div style="margin-top:6px;font-size:0.8rem;color:#888;text-align:center;">
              ${promoText}
            </div>
          </div>
        `,
        confirmButtonText: 'Close',
        confirmButtonColor: '#B6487B',
        background: '#ffffff',
        width: 640,
        padding: '1.5rem',
        customClass: {
          popup: 'rounded-2xl shadow-md border border-pink-200',
          confirmButton: 'text-white font-semibold px-5 py-2 rounded-full hover:opacity-90 transition'
        },
        showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
        hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' },
      });
    } catch (error) {
      console.error(error);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Unable to load order details 💔',
        confirmButtonColor: '#B6487B',
      });
    }
  }
  </script>
</x-app-layout>
