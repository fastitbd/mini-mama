@extends('frontend.layouts.master')

@section('title', 'Order Confirmation | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')
<div class="shein-container" style="max-width: 1040px; margin: 0 auto; padding: 36px 20px 80px;">
    
    <!-- Step Indicator (All Steps Completed) -->
    <div class="confirm-steps-bar" style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-bottom: 36px; font-size: 13px;">
        <div style="display: flex; align-items: center; gap: 8px; color: #888888;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #222222; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">✓</span>
            <span style="font-weight: 600;">1. Shopping Bag</span>
        </div>
        <div style="width: 40px; height: 1px; background: #000000;"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: #888888;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #222222; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">✓</span>
            <span style="font-weight: 600;">2. Place Order</span>
        </div>
        <div style="width: 40px; height: 1px; background: #000000;"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: #00A65A; font-weight: 800;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #00A65A; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px;">✓</span>
            <span>3. Order Confirmed</span>
        </div>
    </div>

    <!-- 1. BIG SUCCESS HEADER BANNER -->
    <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 40px 30px; text-align: center; margin-bottom: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
        <div style="width: 68px; height: 68px; border-radius: 50%; background: #E8F5E9; color: #2E7D32; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; font-size: 32px;">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 style="font-size: 26px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; color: #222222; margin: 0 0 10px;">
            ORDER PLACED SUCCESSFULLY!
        </h1>
        <p style="font-size: 14px; color: #666666; max-width: 600px; margin: 0 auto 18px; line-height: 1.5;">
            Thank you for shopping with <strong>{{ get_setting('com_name') ?: 'FAST IT' }}</strong>. We have received your order and our logistics center is currently packing your items.
        </p>
        <div style="display: inline-flex; align-items: center; gap: 8px; background: #F6F6F6; padding: 8px 18px; border-radius: 20px; font-size: 12px; color: #444;">
            <i class="fa-regular fa-envelope" style="color: #FA2C19;"></i>
            <span>Order confirmation details have been sent to <strong>{{ $order['email'] ?? (get_setting('com_email') ?: 'customer@fastit.com') }}</strong></span>
        </div>
    </div>

    <!-- 2. ORDER DETAILS & META SUMMARY CARD -->
    <div class="order-meta-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px;">
        
        <!-- Order Meta Details -->
        <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 22px;">
            <h3 style="font-size: 13px; font-weight: 800; text-transform: uppercase; color: #000; margin: 0 0 16px; border-bottom: 1px solid #eee; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-receipt"></i>
                <span>Order Information</span>
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #777;">Order Number:</span>
                    <span style="font-weight: 800; color: #000; font-family: monospace; font-size: 14px;">
                        {{ $order['order_number'] ?? 'MY-SH20261012-89412' }}
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $order['order_number'] ?? 'MY-SH20261012-89412' }}'); showToast('Order number copied!')" style="border: none; background: transparent; cursor: pointer; color: #888; margin-left: 6px;" title="Copy">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #777;">Order Date:</span>
                    <span style="font-weight: 600; color: #222;">{{ $order['created_at'] ?? now()->format('d M Y, h:i A') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #777;">Estimated Delivery:</span>
                    <span style="font-weight: 800; color: #00A65A;">{{ $order['est_delivery'] ?? (now()->addDays(5)->format('d M') . ' - ' . now()->addDays(8)->format('d M Y')) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #777;">Payment Method:</span>
                    <span style="font-weight: 700; color: #222;">{{ $order['payment_method'] ?? 'Cash On Delivery (COD)' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #777;">Payment Status:</span>
                    <span style="background: #E8F5E9; color: #2E7D32; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 2px;">
                        {{ str_contains(strtolower($order['payment_method'] ?? ''), 'cash') ? 'Payment Due upon Delivery' : 'Paid' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Shipping Address Details -->
        <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 22px;">
            <h3 style="font-size: 13px; font-weight: 800; text-transform: uppercase; color: #000; margin: 0 0 16px; border-bottom: 1px solid #eee; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-location-dot"></i>
                <span>Shipping Address</span>
            </h3>

            <div style="font-size: 13px; color: #333; line-height: 1.7;">
                <div style="font-weight: 800; font-size: 14px; color: #000;">{{ $order['name'] ?? 'Siti Aisyah Binti Abdullah' }}</div>
                <div style="color: #666;"><i class="fa-solid fa-phone" style="font-size: 11px; margin-right: 6px;"></i>{{ $order['phone'] ?? '+60 18-987 6543' }}</div>
                <div style="margin-top: 4px;">{{ $order['address'] ?? 'No. 45, Jalan Ampang Hilir 2, Taman Ampang' }}</div>
                <div>{{ $order['city'] ?? 'Kuala Lumpur' }}, {{ $order['postcode'] ?? '55000' }}</div>
                <div>{{ $order['state'] ?? 'Wilayah Persekutuan Kuala Lumpur' }}, Malaysia</div>
                <div style="margin-top: 8px; font-size: 12px; color: #00A65A; font-weight: 600;">
                    <i class="fa-solid fa-truck-fast"></i> {{ $order['shipping_method'] ?? 'Standard Express Delivery' }}
                </div>
            </div>
        </div>

    </div>

    <!-- 3. ORDERED PRODUCTS ITEMS TABLE -->
    <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 24px; margin-bottom: 28px;">
        <h3 style="font-size: 14px; font-weight: 800; text-transform: uppercase; color: #000; margin: 0 0 18px; border-bottom: 1px solid #eee; padding-bottom: 12px;">
            Package Items ({{ count($order['items'] ?? []) }} {{ count($order['items'] ?? []) > 1 ? 'Items' : 'Item' }})
        </h3>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($order['items'] ?? [] as $item)
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 14px; border-bottom: 1px solid #f5f5f5; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 16px; flex: 1;">
                        <img src="{{ $item['image'] ?? '//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_405x552.jpg' }}" alt="{{ $item['name'] ?? 'Product' }}" style="width: 58px; height: 76px; object-fit: cover; border-radius: 2px;">
                        <div>
                            <div style="font-size: 13px; font-weight: 700; color: #222; margin-bottom: 4px;">{{ $item['name'] ?? 'Fashion Product' }}</div>
                            <div style="font-size: 12px; color: #777;">Size: <strong>{{ $item['size'] ?? 'M' }}</strong> | Qty: <strong>{{ $item['qty'] ?? 1 }}</strong></div>
                            <div style="font-size: 11px; color: #00A65A; font-weight: 600; margin-top: 2px;">✓ 20-Day Return Guarantee</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 14px; font-weight: 800; color: #000;">RM {{ number_format(($item['price'] ?? 54.00) * ($item['qty'] ?? 1), 2) }}</div>
                        <div style="font-size: 11px; color: #999;">RM {{ number_format($item['price'] ?? 54.00, 2) }} each</div>
                    </div>
                </div>
            @empty
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 14px; border-bottom: 1px solid #f5f5f5; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 16px; flex: 1;">
                        <img src="//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_405x552.jpg" alt="Blouse" style="width: 58px; height: 76px; object-fit: cover; border-radius: 2px;">
                        <div>
                            <div style="font-size: 13px; font-weight: 700; color: #222; margin-bottom: 4px;">Aloruh Women's Elegant Chiffon Contrast Lace Blouse White</div>
                            <div style="font-size: 12px; color: #777;">Size: <strong>M</strong> | Qty: <strong>1</strong></div>
                            <div style="font-size: 11px; color: #00A65A; font-weight: 600; margin-top: 2px;">✓ 20-Day Return Guarantee</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 14px; font-weight: 800; color: #000;">RM 54.00</div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Financial Price Breakdown Card -->
        <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #eee; display: flex; justify-content: flex-end;">
            <div class="order-breakdown-box" style="width: 320px; display: flex; flex-direction: column; gap: 8px; font-size: 13px; color: #555;">
                <div style="display: flex; justify-content: space-between;">
                    <span>Retail Price Subtotal:</span>
                    <span style="font-weight: 700; color: #222;">RM {{ number_format($order['subtotal'] ?? 91.00, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; color: #FA2C19;">
                    <span>Discount Savings:</span>
                    <span style="font-weight: 700;">-RM {{ number_format($order['discount'] ?? 10.00, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Shipping Fee:</span>
                    <span style="font-weight: 700; color: #222;">{{ ($order['shipping_fee'] ?? 0) == 0 ? 'FREE' : ('RM ' . number_format($order['shipping_fee'], 2)) }}</span>
                </div>
                <div style="border-top: 2px solid #222; padding-top: 10px; margin-top: 4px; display: flex; justify-content: space-between; font-size: 16px; font-weight: 900; color: #000;">
                    <span>Order Total:</span>
                    <span style="color: #FA2C19; font-size: 20px;">RM {{ number_format($order['total'] ?? 81.00, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. ACTION BUTTONS ROW -->
    <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; margin-bottom: 48px;">
        <button type="button" onclick="window.print()" style="padding: 14px 28px; background: #ffffff; border: 1px solid #000000; color: #000000; font-weight: 800; font-size: 13px; text-transform: uppercase; cursor: pointer; display: flex; align-items: center; gap: 8px; border-radius: 2px;">
            <i class="fa-solid fa-print"></i>
            <span>PRINT RECEIPT</span>
        </button>
        <a href="{{ route('frontend.track_order', ['order_number' => $order['order_number'] ?? '', 'phone' => $order['phone'] ?? '']) }}" style="padding: 14px 28px; background: #ffffff; border: 1px solid #000000; color: #000000; font-weight: 800; font-size: 13px; text-transform: uppercase; text-decoration: none; display: flex; align-items: center; gap: 8px; border-radius: 2px;">
            <i class="fa-solid fa-location-crosshairs"></i>
            <span>TRACK PACKAGE</span>
        </a>
        <a href="{{ route('frontend.home') }}" style="padding: 14px 32px; background: #000000; color: #ffffff; font-weight: 800; font-size: 13px; text-transform: uppercase; text-decoration: none; display: flex; align-items: center; gap: 8px; border-radius: 2px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>CONTINUE SHOPPING</span>
        </a>
    </div>

    <!-- 5. YOU MIGHT ALSO LIKE (RECOMMENDED NEXT PICKS) -->
    @if(isset($recommendedProducts) && count($recommendedProducts) > 0)
    <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 36px;">
        <h3 style="font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; text-align: center; margin-bottom: 24px;">
            YOU MIGHT ALSO LIKE
        </h3>
        <div class="order-recommended-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
            @foreach($recommendedProducts as $prod)
                <div class="product-card" style="cursor: pointer;" onclick="window.location='{{ route('frontend.product', $prod['id'] ?? 101) }}'">
                    <div style="position: relative; padding-bottom: 133%; overflow: hidden; background: #f7f7f7; border-radius: 2px;">
                        <img src="{{ $prod['image_primary'] ?? $prod['image'] ?? '//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_405x552.jpg' }}" alt="{{ $prod['name'] ?? 'Product' }}" style="position: absolute; top:0; left:0; width:100%; height:100%; object-fit: cover;">
                    </div>
                    <div style="padding: 8px 0;">
                        <div style="font-size: 12px; color: #222; font-weight: 500; height: 32px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.3;">
                            {{ $prod['name'] }}
                        </div>
                        <div style="font-size: 14px; font-weight: 900; color: #000; margin-top: 4px;">
                            RM {{ number_format($prod['price'], 2) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    @media (max-width: 768px) {
        .order-meta-grid {
            grid-template-columns: 1fr !important;
            gap: 16px !important;
        }
        .order-recommended-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
        }
        .confirm-steps-bar {
            font-size: 11px !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
        }
        .confirm-steps-bar > div[style*="width: 40px"] {
            width: 15px !important;
        }
    }
    @media (max-width: 480px) {
        .order-breakdown-box {
            width: 100% !important;
        }
    }
</style>
@endpush
