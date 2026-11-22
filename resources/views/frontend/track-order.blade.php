@extends('frontend.layouts.master')

@section('title', 'Track Your Order | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')
<div class="shein-container" style="max-width: 900px; margin: 0 auto; padding: 36px 20px 80px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 24px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">Track Order</span>
    </div>

    <!-- Header Section -->
    <div style="text-align: center; margin-bottom: 36px;">
        <div style="width: 60px; height: 60px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 26px;">
            <i class="fa-solid fa-truck-fast"></i>
        </div>
        <h1 style="font-size: 26px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 8px;">
            Real-Time Order Tracking
        </h1>
        <p style="font-size: 13px; color: #666; max-width: 500px; margin: 0 auto;">
            Enter your Order Number and Mobile Phone Number to check your package's live delivery status.
        </p>
    </div>

    <!-- Tracking Input Form -->
    <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-bottom: 36px;">
        <form action="{{ route('frontend.track_order_post') }}" method="POST">
            @csrf
            <div class="track-input-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #222; margin-bottom: 6px; text-transform: uppercase;">
                        Order Number *
                    </label>
                    <input type="text" name="order_number" value="{{ $orderNumber }}" required placeholder="e.g. CB-20261122-8941" style="width: 100%; height: 44px; border: 1px solid #ccc; border-radius: 3px; padding: 0 14px; font-size: 13px; outline: none; box-sizing: border-box; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #222; margin-bottom: 6px; text-transform: uppercase;">
                        Phone Number *
                    </label>
                    <input type="tel" name="phone" value="{{ $phone }}" required placeholder="e.g. 017XXXXXXXX or 0189876543" style="width: 100%; height: 44px; border: 1px solid #ccc; border-radius: 3px; padding: 0 14px; font-size: 13px; outline: none; box-sizing: border-box; font-family: inherit;">
                </div>
            </div>
            <button type="submit" style="width: 100%; height: 48px; background: #000; color: #fff; font-size: 14px; font-weight: 800; text-transform: uppercase; border: none; border-radius: 3px; cursor: pointer; letter-spacing: 0.5px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fa-solid fa-magnifying-glass"></i> Track My Order
            </button>
        </form>
    </div>

    <!-- Result Display -->
    @if($searched)
        @if($foundOrder)
            @php
                $status = strtolower($foundOrder->status ?? 'pending');
                $step = 1;
                if ($status === 'processing' || $status === 'confirmed') $step = 2;
                elseif ($status === 'shipped' || $status === 'in_transit') $step = 3;
                elseif ($status === 'out_for_delivery') $step = 4;
                elseif ($status === 'delivered' || $status === 'completed') $step = 5;
            @endphp

            <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                <!-- Order Top Badge -->
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 16px; margin-bottom: 28px; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: #999; text-transform: uppercase;">ORDER DETAILS</div>
                        <div style="font-size: 18px; font-weight: 900; color: #111;">{{ $foundOrder->order_no }}</div>
                        <div style="font-size: 12px; color: #777;">Placed on {{ $foundOrder->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <span style="background: #E8F5E9; color: #2E7D32; font-size: 12px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
                        Status: {{ ucfirst($foundOrder->status) }}
                    </span>
                </div>

                <!-- 5-Step Delivery Pipeline -->
                <div style="margin-bottom: 36px; padding: 0 10px;">
                    <div style="display: flex; justify-content: space-between; position: relative;">
                        <!-- Pipeline background line -->
                        <div style="position: absolute; top: 18px; left: 30px; right: 30px; height: 3px; background: #e0e0e0; z-index: 1;"></div>
                        <!-- Active progress line -->
                        <div style="position: absolute; top: 18px; left: 30px; width: {{ ($step - 1) * 25 }}%; height: 3px; background: #10B981; z-index: 2; transition: width 0.3s;"></div>

                        @php
                            $steps = [
                                1 => ['title' => 'Order Placed', 'desc' => 'Received'],
                                2 => ['title' => 'Processing', 'desc' => 'Packaging'],
                                3 => ['title' => 'Shipped', 'desc' => 'With Courier'],
                                4 => ['title' => 'Out for Delivery', 'desc' => 'Arriving soon'],
                                5 => ['title' => 'Delivered', 'desc' => 'Completed'],
                            ];
                        @endphp

                        @foreach($steps as $idx => $sInfo)
                            @php
                                $isDone = $step >= $idx;
                                $isCurrent = $step === $idx;
                            @endphp
                            <div style="position: relative; z-index: 3; text-align: center; width: 80px;">
                                <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $isDone ? '#10B981' : '#fff' }}; border: 3px solid {{ $isDone ? '#10B981' : '#ccc' }}; color: {{ $isDone ? '#fff' : '#888' }}; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 13px; font-weight: 800;">
                                    @if($isDone)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        {{ $idx }}
                                    @endif
                                </div>
                                <div style="font-size: 11px; font-weight: {{ $isCurrent ? '800' : '600' }}; color: {{ $isDone ? '#111' : '#999' }}; line-height: 1.2;">
                                    {{ $sInfo['title'] }}
                                </div>
                                <div style="font-size: 9px; color: #888; margin-top: 2px;">{{ $sInfo['desc'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="track-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; background: #fafafa; border-radius: 6px; padding: 20px;">
                    <div>
                        <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; margin: 0 0 10px; color: #222;">
                            <i class="fa-solid fa-location-dot" style="margin-right: 6px;"></i> Delivery Address
                        </h4>
                        <div style="font-size: 13px; color: #444; line-height: 1.6;">
                            <strong>{{ $foundOrder->customer_name }}</strong><br>
                            {{ $foundOrder->customer_phone }}<br>
                            {{ $foundOrder->customer_address }}<br>
                            {{ $foundOrder->customer_city }}, {{ $foundOrder->customer_state }} {{ $foundOrder->customer_postcode }}
                        </div>
                    </div>
                    <div>
                        <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; margin: 0 0 10px; color: #222;">
                            <i class="fa-solid fa-box" style="margin-right: 6px;"></i> Logistics & Courier Info
                        </h4>
                        <div style="font-size: 13px; color: #444; line-height: 1.6;">
                            Courier: <strong>{{ $foundOrder->courier_service ?: 'Standard Delivery' }}</strong><br>
                            Payment: <strong>{{ $foundOrder->payment_method }}</strong><br>
                            Total Payable: <strong style="color: #FA2C19; font-size: 15px;">RM {{ number_format($foundOrder->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Items in Package -->
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin: 0 0 14px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                    Package Items ({{ count($foundOrder->items) }})
                </h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($foundOrder->items as $item)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid #f5f5f5;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="{{ $item->product_image ?: '//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_405x552.jpg' }}" alt="{{ $item->product_name }}" style="width: 48px; height: 60px; object-fit: cover; border-radius: 2px;">
                                <div>
                                    <div style="font-size: 13px; font-weight: 700; color: #222;">{{ $item->product_name }}</div>
                                    <div style="font-size: 11px; color: #777;">Size: <strong>{{ $item->size }}</strong> • Qty: <strong>{{ $item->quantity }}</strong></div>
                                </div>
                            </div>
                            <div style="font-size: 14px; font-weight: 800; color: #111;">
                                RM {{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Not Found State -->
            <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 40px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                <div style="font-size: 44px; color: #FA2C19; margin-bottom: 14px;">
                    <i class="fa-regular fa-circle-question"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; margin: 0 0 8px;">No Order Found</h3>
                <p style="font-size: 13px; color: #767676; max-width: 480px; margin: 0 auto 20px; line-height: 1.5;">
                    We couldn't find an order with Order Number <strong>"{{ $orderNumber }}"</strong> and Phone Number <strong>"{{ $phone }}"</strong>. Please check your order confirmation details or contact our 24/7 support.
                </p>
                <div style="display: flex; justify-content: center; gap: 12px;">
                    <a href="{{ route('frontend.contact') }}" style="background: #000; color: #fff; font-size: 12px; font-weight: 800; padding: 10px 24px; border-radius: 2px; text-decoration: none; text-transform: uppercase;">
                        Contact Support
                    </a>
                    <a href="{{ route('frontend.category', 'all') }}" style="background: #f5f5f5; color: #222; font-size: 12px; font-weight: 800; padding: 10px 24px; border-radius: 2px; text-decoration: none; text-transform: uppercase; border: 1px solid #ddd;">
                        Continue Shopping
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 640px) {
        .track-input-grid, .track-info-grid {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
        }
    }
    @media (max-width: 480px) {
        .track-step-box {
            width: 60px !important;
        }
    }
</style>
@endpush
