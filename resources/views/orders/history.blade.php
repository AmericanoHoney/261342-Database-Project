<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            History
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 bg-white rounded-2xl shadow-md border border-pink-200 p-6">
    

        <table class="min-w-full text-gray-700 border-collapse">
            <thead class="bg-pink-100 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Order Date</th>
                    <th class="px-4 py-3 text-center">Order ID</th>
                    <th class="px-4 py-3 text-right">Total Amount</th>
                    <th class="px-4 py-3 text-center">Order Status</th>
                    <th class="px-4 py-3 text-center">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b border-pink-100 hover:bg-pink-50 transition">
                        <td class="px-4 py-3">{{ $order->order_date->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">#{{ $order->order_id }}</td>
                        <td class="px-4 py-3 text-right">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $color = match($order->status) {
                                    'Pending' => 'bg-gray-300 text-gray-700',
                                    'Processing' => 'bg-yellow-200 text-yellow-700',
                                    'Out for Delivery' => 'bg-blue-200 text-blue-700',
                                    'Delivered' => 'bg-green-200 text-green-700',
                                    'Completed' => 'bg-green-300 text-green-800',
                                    'Cancelled' => 'bg-red-200 text-red-700',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $color }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="showOrderDetails({{ $order->order_id }})"
                                    class="px-4 py-1 border border-pink-300 rounded-full text-pink-600 hover:bg-pink-50">
                                Show Details
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- SweetAlert2 Popup --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
async function showOrderDetails(orderId) {
  try {
    const response = await fetch(`/orders/${orderId}`);
    const order = await response.json();

    const fmt = (v) => Number(v ?? 0).toFixed(2);
    const orderDate = new Date(order.order_date).toLocaleString('th-TH', {
      day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });
    const deliveryDate = order.delivery_date
      ? new Date(order.delivery_date).toLocaleDateString('th-TH')
      : '-';

    const promoText = order.promotions?.length
      ? order.promotions.map(p => `${p.name} (${p.discount_percent}% off)`).join(', ')
      : 'No Promotion Applied';

    const productRows = order.details.map(d => `
      <div style="display:flex;align-items:center;justify-content:space-between;margin:6px 0;">
        <div style="display:flex;align-items:center;gap:10px;">
          <img src="${d.image_url ?? '/images/default-product.png'}"
               style="width:42px;height:42px;border-radius:8px;border:1px solid #eee;object-fit:cover;">
          <div>
            <div style="font-weight:500;font-size:0.9rem;">${d.product_name}</div>
            <div style="font-size:0.8rem;color:#888;">x${d.quantity} • $${fmt(d.unit_price)}</div>
          </div>
        </div>
        <div style="font-weight:500;font-size:0.9rem;color:#444;">$${fmt(d.subtotal)}</div>
      </div>
    `).join('');

    Swal.fire({
      html: `
        <div style="font-family:'Poppins','Kanit',sans-serif;font-size:0.9rem;color:#333;text-align:left;max-width:580px;">
          <h2 style="text-align:center;margin-bottom:10px;color:#c45b7c;font-weight:600;font-size:1.3rem;">
            Order Details
          </h2>

          <div style="line-height:1.4;margin-bottom:10px;">
            <p><b>Order ID:</b> #${order.order_id}</p>
            <p><b>Status:</b> ${order.status}</p>
            <p><b>Order Date:</b> ${orderDate}</p>
            <p><b>Delivery Date:</b> ${deliveryDate}</p>
            <p><b>Address:</b> ${order.address || '-'}</p>
            <p><b>Note:</b> ${order.note || '-'}</p>
          </div>

          <hr style="border-color:#f2c8d5;margin:8px 0;">

          <div>${productRows}</div>

          <hr style="border-color:#f2c8d5;margin:8px 0;">

          <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin:3px 0;">
            <span>Items</span><span>${order.details.length}</span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin:3px 0;">
            <span>Subtotal</span><span>$${fmt(order.subtotal)}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin:3px 0;color:#888;">
            <span>Discount</span>
            <span>${order.discount_percent > 0 
                ? `-${order.discount_percent}% ($${fmt(order.discount_amount)})` 
                : '$0.00'}</span>
            </div>

            <hr style="border-color:#f2c8d5;margin:8px 0;">

            <div style="display:flex;justify-content:space-between;font-size:1rem;font-weight:600;">
            <span>Total</span><span style="color:#c45b7c;">$${fmt(order.final_total)}</span>
            </div>


          <div style="margin-top:5px;font-size:0.8rem;color:#999;">
            ${promoText}
          </div>
        </div>
      `,
      confirmButtonText: 'Close',
      confirmButtonColor: '#e85a8e',
      width: 600,
      background: '#fffdfd',
      showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
      hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' },
    });
  } catch (error) {
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'ไม่สามารถโหลดรายละเอียดคำสั่งซื้อได้ค่ะ 💔',
      confirmButtonColor: '#e85a8e',
    });
  }
}
</script>




</x-app-layout>
