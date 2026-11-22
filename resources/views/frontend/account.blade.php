@extends('frontend.layouts.master')

@section('title', 'My Account | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')
<div class="shein-container" style="max-width: 1200px; margin: 0 auto; padding: 32px 16px 80px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 24px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">Customer Account</span>
    </div>

    <!-- Flash Alert Messages -->
    @if(session('success'))
        <div style="background: #E8F5E9; border: 1px solid #C8E6C9; color: #2E7D32; padding: 14px 20px; border-radius: 4px; font-size: 13px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; color: #2E7D32; cursor: pointer;">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #FFEBEE; border: 1px solid #FFCDD2; color: #C62828; padding: 14px 20px; border-radius: 4px; font-size: 13px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; color: #C62828; cursor: pointer;">&times;</button>
        </div>
    @endif

    <!-- Profile Header Banner -->
    <div style="background: linear-gradient(135deg, #111111 0%, #2a2a2a 100%); color: #ffffff; border-radius: 8px; padding: 28px 32px; margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="position: relative;">
                <div style="width: 72px; height: 72px; border-radius: 50%; background: #ffffff; color: #111; font-size: 32px; font-weight: 900; display: flex; align-items: center; justify-content: center; border: 3px solid #FA2C19;">
                    <i class="fa-regular fa-user"></i>
                </div>
                <span style="position: absolute; bottom: 0; right: 0; width: 18px; height: 18px; background: #10B981; border: 2px solid #fff; border-radius: 50%;" title="Online"></span>
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <h1 style="font-size: 22px; font-weight: 900; margin: 0; color: #ffffff;">
                        {{ $customer['name'] ?? 'Mst. Jannatul Ferdous' }}
                    </h1>
                    <span style="background: #FA2C19; color: #ffffff; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 12px; text-transform: uppercase;">
                        {{ $customer['tier'] ?? 'VIP Member' }}
                    </span>
                </div>
                <div style="font-size: 12px; color: #cccccc; display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                    <span><i class="fa-regular fa-envelope" style="margin-right: 4px;"></i> {{ $customer['email'] ?? 'customer@minimama.com.bd' }}</span>
                    <span><i class="fa-solid fa-phone" style="margin-right: 4px;"></i> {{ $customer['phone'] ?? '+880 1712-345678' }}</span>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 16px;">
            <a href="{{ route('frontend.track_order') }}" style="background: rgba(255,255,255,0.15); color: #fff; padding: 10px 18px; font-size: 12px; font-weight: 700; border-radius: 4px; display: flex; align-items: center; gap: 6px; text-decoration: none; border: 1px solid rgba(255,255,255,0.2);">
                <i class="fa-solid fa-truck-fast"></i> Track Order
            </a>
            <a href="{{ route('frontend.customer_logout') }}" style="background: #FA2C19; color: #fff; padding: 10px 18px; font-size: 12px; font-weight: 700; border-radius: 4px; display: flex; align-items: center; gap: 6px; text-decoration: none;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>

    <!-- Account Main Grid (Sidebar + Content Pane) -->
    <div class="account-main-grid" style="display: grid; grid-template-columns: 260px 1fr; gap: 32px; align-items: start;">
        
        <!-- SIDEBAR NAVIGATION MENU -->
        <div style="background: #ffffff; border: 1px solid #eeeeee; border-radius: 6px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <div style="padding: 16px 20px; font-size: 11px; font-weight: 800; color: #999; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f2f2f2; background: #fafafa;">
                Account Navigation
            </div>
            
            <div class="account-nav-list" style="display: flex; flex-direction: column;">
                <a href="javascript:void(0)" onclick="switchTab('dashboard', this)" class="account-nav-item {{ $activeTab === 'dashboard' ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #222; text-decoration: none; border-bottom: 1px solid #f7f7f7;">
                    <span><i class="fa-solid fa-chart-pie" style="width: 22px; color: #555;"></i> Dashboard</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
                </a>

                <a href="javascript:void(0)" onclick="switchTab('orders', this)" class="account-nav-item {{ $activeTab === 'orders' ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #222; text-decoration: none; border-bottom: 1px solid #f7f7f7;">
                    <span><i class="fa-solid fa-box" style="width: 22px; color: #555;"></i> My Orders</span>
                    <span style="background: #000; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px;">{{ count($orders) }}</span>
                </a>

                <a href="javascript:void(0)" onclick="switchTab('track', this)" class="account-nav-item {{ $activeTab === 'track' ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #222; text-decoration: none; border-bottom: 1px solid #f7f7f7;">
                    <span><i class="fa-solid fa-truck-fast" style="width: 22px; color: #0284C7;"></i> Track Order</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
                </a>

                <a href="javascript:void(0)" onclick="switchTab('profile', this)" class="account-nav-item {{ $activeTab === 'profile' ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #222; text-decoration: none; border-bottom: 1px solid #f7f7f7;">
                    <span><i class="fa-regular fa-id-card" style="width: 22px; color: #555;"></i> My Profile</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
                </a>

                <a href="javascript:void(0)" onclick="switchTab('addresses', this)" class="account-nav-item {{ $activeTab === 'addresses' ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #222; text-decoration: none; border-bottom: 1px solid #f7f7f7;">
                    <span><i class="fa-solid fa-location-dot" style="width: 22px; color: #555;"></i> My Addresses</span>
                    <span style="font-size: 11px; color: #999;">{{ count($addresses) }}</span>
                </a>

                <a href="{{ route('frontend.wishlist') }}" class="account-nav-item" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #222; text-decoration: none; border-bottom: 1px solid #f7f7f7;">
                    <span><i class="fa-regular fa-heart" style="width: 22px; color: #FA2C19;"></i> Wishlist</span>
                    <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 10px; color: #ccc;"></i>
                </a>

                <a href="javascript:void(0)" onclick="switchTab('password', this)" class="account-nav-item {{ $activeTab === 'password' ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #222; text-decoration: none; border-bottom: 1px solid #f7f7f7;">
                    <span><i class="fa-solid fa-lock" style="width: 22px; color: #555;"></i> Change Password</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
                </a>

                <a href="javascript:void(0)" onclick="switchTab('guest', this)" class="account-nav-item {{ $activeTab === 'guest' ? 'active' : '' }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 13px; font-weight: 600; color: #0284C7; text-decoration: none; border-bottom: 1px solid #f7f7f7; background: #F0F9FF;">
                    <span><i class="fa-solid fa-magnifying-glass" style="width: 22px; color: #0284C7;"></i> Guest Order Lookup</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #0284C7;"></i>
                </a>

                <a href="{{ route('frontend.customer_logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 14px 20px; font-size: 13px; font-weight: 700; color: #FA2C19; text-decoration: none;">
                    <i class="fa-solid fa-arrow-right-from-bracket" style="width: 22px;"></i> Logout
                </a>
            </div>
        </div>

        <!-- MAIN CONTENT TAB PANELS -->
        <div style="background: #ffffff; border: 1px solid #eeeeee; border-radius: 6px; padding: 28px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); min-height: 480px;">
            
            <!-- 1. DASHBOARD OVERVIEW TAB -->
            <div id="tab-dashboard" class="account-tab-panel" style="display: {{ $activeTab === 'dashboard' ? 'block' : 'none' }};">
                <h2 style="font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 12px;">
                    Account Overview
                </h2>

                <!-- 4 Stat Badges -->
                <div class="account-stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 32px;">
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 18px; border-radius: 6px; text-align: center;">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 24px; color: #2563EB; margin-bottom: 8px;"></i>
                        <div style="font-size: 22px; font-weight: 900; color: #1E293B;">{{ count($orders) }}</div>
                        <div style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase;">Total Orders</div>
                    </div>

                    <div style="background: #FEF2F2; border: 1px solid #FEE2E2; padding: 18px; border-radius: 6px; text-align: center;">
                        <i class="fa-solid fa-clock-rotate-left" style="font-size: 24px; color: #DC2626; margin-bottom: 8px;"></i>
                        <div style="font-size: 22px; font-weight: 900; color: #991B1B;">{{ $orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}</div>
                        <div style="font-size: 11px; font-weight: 700; color: #B91C1C; text-transform: uppercase;">Active Orders</div>
                    </div>

                    <div style="background: #FFFBEB; border: 1px solid #FEF3C7; padding: 18px; border-radius: 6px; text-align: center;">
                        <i class="fa-solid fa-coins" style="font-size: 24px; color: #D97706; margin-bottom: 8px;"></i>
                        <div style="font-size: 22px; font-weight: 900; color: #92400E;">{{ $customer['total_point'] ?? 350 }}</div>
                        <div style="font-size: 11px; font-weight: 700; color: #B45309; text-transform: uppercase;">Bonus Points</div>
                    </div>

                    <div style="background: #F0FDF4; border: 1px solid #DCFCE7; padding: 18px; border-radius: 6px; text-align: center;">
                        <i class="fa-solid fa-location-dot" style="font-size: 24px; color: #16A34A; margin-bottom: 8px;"></i>
                        <div style="font-size: 22px; font-weight: 900; color: #166534;">{{ count($addresses) }}</div>
                        <div style="font-size: 11px; font-weight: 700; color: #15803D; text-transform: uppercase;">Saved Addresses</div>
                    </div>
                </div>

                <!-- Recent Orders Preview -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 15px; font-weight: 800; text-transform: uppercase; margin: 0;">Recent Orders</h3>
                    <a href="javascript:void(0)" onclick="switchTab('orders')" style="font-size: 12px; font-weight: 700; color: #FA2C19; text-decoration: none;">View All Orders &rarr;</a>
                </div>

                @if(count($orders) > 0)
                    <div style="border: 1px solid #eeeeee; border-radius: 6px; overflow: hidden; margin-bottom: 30px;">
                        @foreach($orders->take(3) as $ord)
                            <div style="padding: 18px 20px; border-bottom: 1px solid #f2f2f2; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                                <div>
                                    <div style="font-size: 14px; font-weight: 800; color: #111;">{{ $ord->order_no }}</div>
                                    <div style="font-size: 11px; color: #777;">Placed on {{ $ord->created_at ? $ord->created_at->format('d M Y, h:i A') : 'Recent' }}</div>
                                </div>
                                <div style="font-size: 14px; font-weight: 800; color: #FA2C19;">
                                    ৳ {{ number_format((float)$ord->total_amount, 2) }}
                                </div>
                                <div>
                                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 3px 10px; border-radius: 12px; background: {{ strtolower($ord->status) === 'delivered' ? '#DCFCE7' : '#FEF3C7' }}; color: {{ strtolower($ord->status) === 'delivered' ? '#166534' : '#92400E' }};">
                                        {{ ucfirst($ord->status ?? 'Processing') }}
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('frontend.track_order', ['order_number' => $ord->order_no, 'phone' => $ord->customer_phone]) }}" style="background: #000; color: #fff; font-size: 11px; font-weight: 700; padding: 6px 14px; border-radius: 3px; text-decoration: none;">
                                        Track Order
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 40px 20px; background: #fafafa; border-radius: 6px; border: 1px dashed #ddd; margin-bottom: 30px;">
                        <i class="fa-solid fa-box-open" style="font-size: 36px; color: #ccc; margin-bottom: 10px;"></i>
                        <div style="font-size: 14px; font-weight: 700;">No orders found yet</div>
                        <p style="font-size: 12px; color: #777; margin: 4px 0 16px;">Browse our latest products and place your first order!</p>
                        <a href="{{ route('frontend.category', 'all') }}" style="background: #000; color: #fff; font-size: 12px; font-weight: 800; padding: 8px 20px; border-radius: 3px; text-decoration: none;">Shop Now</a>
                    </div>
                @endif

                <!-- Support & Help Card -->
                <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 6px; padding: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <i class="fa-solid fa-headset" style="font-size: 30px; color: #16A34A;"></i>
                        <div>
                            <div style="font-size: 14px; font-weight: 800; color: #166534;">Need Help With Your Account or Orders?</div>
                            <div style="font-size: 12px; color: #15803D;">Our 24/7 Customer Care team is ready on WhatsApp & Live Chat!</div>
                        </div>
                    </div>
                    <a href="https://wa.me/8801901166580?text=Hello%20Mini%20Mama%20Support!%20I%20need%20assistance%20with%20my%20account." target="_blank" style="background: #16A34A; color: #fff; font-size: 12px; font-weight: 800; padding: 8px 18px; border-radius: 4px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i> WhatsApp Support
                    </a>
                </div>
            </div>

            <!-- 2. MY ORDERS TAB -->
            <div id="tab-orders" class="account-tab-panel" style="display: {{ $activeTab === 'orders' ? 'block' : 'none' }};">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                    <h2 style="font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        My Orders ({{ count($orders) }})
                    </h2>
                    <a href="{{ route('frontend.track_order') }}" style="font-size: 12px; font-weight: 700; color: #0284C7; text-decoration: none;">
                        <i class="fa-solid fa-truck-fast"></i> Real-time Order Tracking &rarr;
                    </a>
                </div>

                @forelse($orders as $orderItem)
                    <div style="border: 1px solid #e5e5e5; border-radius: 6px; margin-bottom: 20px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        <!-- Order Header -->
                        <div style="background: #fafafa; border-bottom: 1px solid #eee; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                            <div style="display: flex; gap: 24px; flex-wrap: wrap; font-size: 12px;">
                                <div>
                                    <div style="color: #888; font-size: 10px; text-transform: uppercase; font-weight: 700;">Order Placed</div>
                                    <div style="font-weight: 700; color: #222;">{{ $orderItem->created_at ? $orderItem->created_at->format('d M Y') : 'Recent' }}</div>
                                </div>
                                <div>
                                    <div style="color: #888; font-size: 10px; text-transform: uppercase; font-weight: 700;">Total Amount</div>
                                    <div style="font-weight: 900; color: #FA2C19;">৳ {{ number_format((float)$orderItem->total_amount, 2) }}</div>
                                </div>
                                <div>
                                    <div style="color: #888; font-size: 10px; text-transform: uppercase; font-weight: 700;">Order Number</div>
                                    <div style="font-weight: 800; color: #111;">{{ $orderItem->order_no }}</div>
                                </div>
                            </div>
                            <div>
                                <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 4px 12px; border-radius: 12px; background: {{ strtolower($orderItem->status) === 'delivered' ? '#DCFCE7' : '#FEF3C7' }}; color: {{ strtolower($orderItem->status) === 'delivered' ? '#166534' : '#92400E' }};">
                                    {{ ucfirst($orderItem->status ?? 'Processing') }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Items Body -->
                        <div style="padding: 20px;">
                            @if($orderItem->items && count($orderItem->items) > 0)
                                @foreach($orderItem->items as $prod)
                                    <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 14px; margin-bottom: 14px; border-bottom: 1px dashed #eee;">
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div style="width: 54px; height: 54px; border-radius: 4px; overflow: hidden; background: #f0f0f0; border: 1px solid #eee; flex-shrink: 0;">
                                                <img src="{{ $prod->product_image ?: 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=200&auto=format&fit=crop' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <div style="font-size: 13px; font-weight: 700; color: #222; margin-bottom: 3px;">
                                                    {{ $prod->product_name }}
                                                </div>
                                                <div style="font-size: 11px; color: #777;">
                                                    Qty: <strong>{{ $prod->quantity }}</strong> | Size: <strong>{{ $prod->size ?: 'Standard' }}</strong> | SKU: {{ $prod->product_code ?: 'SKU-01' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div style="font-size: 13px; font-weight: 800; color: #111;">
                                            ৳ {{ number_format((float)$prod->unit_price * (int)$prod->quantity, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div style="display: flex; align-items: center; gap: 16px; padding-bottom: 10px;">
                                    <div style="width: 50px; height: 50px; border-radius: 4px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #888;">
                                        <i class="fa-solid fa-box"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 700;">Standard Package Delivery</div>
                                        <div style="font-size: 11px; color: #777;">Steadfast Courier | Direct Website Order</div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; padding-top: 10px;">
                                <a href="{{ route('frontend.track_order', ['order_number' => $orderItem->order_no, 'phone' => $orderItem->customer_phone]) }}" style="background: #000; color: #fff; font-size: 12px; font-weight: 800; padding: 8px 18px; border-radius: 3px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-truck-fast"></i> Track Package
                                </a>
                                <a href="https://wa.me/8801901166580?text=Hello%2C%20I%20have%20an%20inquiry%20regarding%20Order%20{{ $orderItem->order_no }}" target="_blank" style="background: #25D366; color: #fff; font-size: 12px; font-weight: 800; padding: 8px 16px; border-radius: 3px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-brands fa-whatsapp"></i> Order Help
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 60px 20px; background: #fafafa; border-radius: 6px; border: 1px dashed #ddd;">
                        <i class="fa-solid fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 14px;"></i>
                        <h3 style="font-size: 16px; font-weight: 800; margin: 0 0 6px;">No Orders Placed Yet</h3>
                        <p style="font-size: 12px; color: #777; margin-bottom: 20px;">When you place orders, they will appear right here with live delivery updates.</p>
                        <a href="{{ route('frontend.category', 'all') }}" class="shein-btn-primary" style="display: inline-block; padding: 12px 28px; font-size: 13px; text-decoration: none;">START SHOPPING</a>
                    </div>
                @endforelse
            </div>

            <!-- 3. TRACK ORDER TAB -->
            <div id="tab-track" class="account-tab-panel" style="display: {{ $activeTab === 'track' ? 'block' : 'none' }};">
                <h2 style="font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 12px;">
                    Track An Order
                </h2>
                <p style="font-size: 13px; color: #666; margin-bottom: 24px;">
                    Enter your Order Number and Mobile Phone Number to check real-time courier updates.
                </p>

                <form action="{{ route('frontend.track_order_post') }}" method="POST" style="max-width: 540px; background: #fafafa; border: 1px solid #eee; padding: 24px; border-radius: 6px;">
                    @csrf
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Order Number *</label>
                        <input type="text" name="order_number" required placeholder="e.g. CB-20261122-8941" style="width: 100%; height: 42px; border: 1px solid #ccc; padding: 0 12px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Phone Number *</label>
                        <input type="tel" name="phone" value="{{ $customer['phone'] ?? '' }}" required placeholder="017XXXXXXXX" style="width: 100%; height: 42px; border: 1px solid #ccc; padding: 0 12px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <button type="submit" style="width: 100%; height: 44px; background: #000; color: #fff; font-size: 13px; font-weight: 800; text-transform: uppercase; border: none; border-radius: 3px; cursor: pointer; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-magnifying-glass"></i> Track Order Now
                    </button>
                </form>
            </div>

            <!-- 4. MY PROFILE TAB -->
            <div id="tab-profile" class="account-tab-panel" style="display: {{ $activeTab === 'profile' ? 'block' : 'none' }};">
                <h2 style="font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 12px;">
                    Personal Information
                </h2>

                <form action="{{ route('frontend.customer_update_profile') }}" method="POST" style="max-width: 600px;">
                    @csrf
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Full Name *</label>
                        <input type="text" name="name" value="{{ $customer['name'] ?? '' }}" required style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Email Address *</label>
                            <input type="email" name="email" value="{{ $customer['email'] ?? '' }}" required style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Phone Number *</label>
                            <input type="tel" name="phone" value="{{ $customer['phone'] ?? '' }}" required style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Gender</label>
                            <select name="gender" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box; background: #fff;">
                                <option value="Female" {{ ($customer['gender'] ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Male" {{ ($customer['gender'] ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Other" {{ ($customer['gender'] ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Date of Birth</label>
                            <input type="date" name="birth_date" value="{{ $customer['birth_date'] ?? '1998-05-14' }}" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box; background: #fff;">
                        </div>
                    </div>

                    <button type="submit" style="background: #000; color: #fff; height: 46px; padding: 0 28px; font-size: 13px; font-weight: 800; text-transform: uppercase; border: none; border-radius: 3px; cursor: pointer; letter-spacing: 0.5px;">
                        Save Profile Changes
                    </button>
                </form>
            </div>

            <!-- 5. MY ADDRESSES TAB -->
            <div id="tab-addresses" class="account-tab-panel" style="display: {{ $activeTab === 'addresses' ? 'block' : 'none' }};">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 12px;">
                    <h2 style="font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        Saved Addresses ({{ count($addresses) }})
                    </h2>
                    <button type="button" onclick="document.getElementById('newAddressFormBox').style.display = 'block'" style="background: #000; color: #fff; font-size: 12px; font-weight: 800; padding: 8px 16px; border-radius: 3px; cursor: pointer;">
                        + Add New Address
                    </button>
                </div>

                <!-- Add New Address Collapsible Form -->
                <div id="newAddressFormBox" style="display: none; background: #fafafa; border: 1px solid #e0e0e0; padding: 24px; border-radius: 6px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h3 style="font-size: 14px; font-weight: 800; margin: 0; text-transform: uppercase;">New Shipping Address</h3>
                        <button type="button" onclick="document.getElementById('newAddressFormBox').style.display = 'none'" style="font-size: 18px; color: #666; cursor: pointer;">&times;</button>
                    </div>

                    <form action="{{ route('frontend.customer_save_address') }}" method="POST">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 800; margin-bottom: 4px;">Address Label (e.g. Home / Office)</label>
                                <input type="text" name="title" required placeholder="Home" style="width: 100%; height: 38px; border: 1px solid #ccc; padding: 0 10px; font-size: 12px; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 800; margin-bottom: 4px;">Recipient Name</label>
                                <input type="text" name="name" value="{{ $customer['name'] ?? '' }}" required style="width: 100%; height: 38px; border: 1px solid #ccc; padding: 0 10px; font-size: 12px; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 800; margin-bottom: 4px;">Phone Number</label>
                                <input type="tel" name="phone" value="{{ $customer['phone'] ?? '' }}" required placeholder="017XXXXXXXX" style="width: 100%; height: 38px; border: 1px solid #ccc; padding: 0 10px; font-size: 12px; box-sizing: border-box;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 800; margin-bottom: 4px;">Division</label>
                                <select name="division" style="width: 100%; height: 38px; border: 1px solid #ccc; padding: 0 10px; font-size: 12px; box-sizing: border-box; background: #fff;">
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Barisal">Barisal</option>
                                    <option value="Sylhet">Sylhet</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Mymensingh">Mymensingh</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 800; margin-bottom: 4px;">District / Area</label>
                                <input type="text" name="area" placeholder="e.g. Mirpur, Gulshan, Dhanmondi" style="width: 100%; height: 38px; border: 1px solid #ccc; padding: 0 10px; font-size: 12px; box-sizing: border-box;">
                            </div>
                        </div>

                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 11px; font-weight: 800; margin-bottom: 4px;">Full Delivery Address *</label>
                            <textarea name="address" rows="3" required placeholder="House number, road number, flat/floor details..." style="width: 100%; border: 1px solid #ccc; padding: 10px; font-size: 12px; box-sizing: border-box; font-family: inherit;"></textarea>
                        </div>

                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; font-size: 12px;">
                            <input type="checkbox" name="is_default" id="setAsDefault" checked>
                            <label for="setAsDefault">Set as my default shipping address</label>
                        </div>

                        <button type="submit" style="background: #000; color: #fff; font-size: 12px; font-weight: 800; padding: 10px 24px; border: none; border-radius: 3px; cursor: pointer;">
                            Save Address
                        </button>
                    </form>
                </div>

                <!-- Addresses Cards Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    @foreach($addresses as $addr)
                        <div style="border: 1px solid {{ !empty($addr['is_default']) ? '#000' : '#e0e0e0' }}; border-radius: 6px; padding: 20px; position: relative; background: #fff;">
                            @if(!empty($addr['is_default']))
                                <span style="position: absolute; top: 16px; right: 16px; background: #000; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 2px; text-transform: uppercase;">
                                    Default Address
                                </span>
                            @endif

                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                <i class="fa-solid fa-house" style="color: #666;"></i>
                                <span style="font-size: 14px; font-weight: 800; color: #111;">{{ $addr['title'] ?? 'Address' }}</span>
                            </div>

                            <div style="font-size: 13px; font-weight: 700; color: #333; margin-bottom: 4px;">
                                {{ $addr['name'] ?? 'Recipient' }}
                            </div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 8px; line-height: 1.5;">
                                {{ $addr['address'] }}<br>
                                {{ $addr['area'] ?? '' }}, {{ $addr['division'] ?? 'Dhaka' }}
                            </div>
                            <div style="font-size: 12px; font-weight: 600; color: #444; margin-bottom: 14px;">
                                <i class="fa-solid fa-phone" style="font-size: 11px; margin-right: 4px;"></i> {{ $addr['phone'] ?? '' }}
                            </div>

                            <form action="{{ route('frontend.customer_delete_address') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                @csrf
                                <input type="hidden" name="id" value="{{ $addr['id'] }}">
                                <button type="submit" style="font-size: 11px; color: #FA2C19; font-weight: 700; background: none; border: none; cursor: pointer; text-decoration: underline;">
                                    <i class="fa-solid fa-trash" style="margin-right: 4px;"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 6. CHANGE PASSWORD TAB -->
            <div id="tab-password" class="account-tab-panel" style="display: {{ $activeTab === 'password' ? 'block' : 'none' }};">
                <h2 style="font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 20px; border-bottom: 1px solid #eee; padding-bottom: 12px;">
                    Change Password
                </h2>

                <form action="{{ route('frontend.customer_change_password') }}" method="POST" style="max-width: 480px;">
                    @csrf
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Current Password</label>
                        <input type="password" name="current_password" required placeholder="Enter current password" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">New Password</label>
                        <input type="password" name="new_password" required placeholder="At least 6 characters" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Confirm New Password</label>
                        <input type="password" name="confirm_password" required placeholder="Re-enter new password" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>

                    <button type="submit" style="background: #000; color: #fff; height: 46px; padding: 0 28px; font-size: 13px; font-weight: 800; text-transform: uppercase; border: none; border-radius: 3px; cursor: pointer; letter-spacing: 0.5px;">
                        Update Password
                    </button>
                </form>
            </div>

            <!-- 7. GUEST ORDER LOOKUP TAB -->
            <div id="tab-guest" class="account-tab-panel" style="display: {{ $activeTab === 'guest' ? 'block' : 'none' }};">
                <h2 style="font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 14px; border-bottom: 1px solid #eee; padding-bottom: 12px;">
                    Guest Customer Order Lookup
                </h2>
                <div style="background: #F0F9FF; border: 1px solid #BAE6FD; padding: 14px 18px; border-radius: 4px; font-size: 13px; color: #0369A1; margin-bottom: 24px;">
                    <i class="fa-solid fa-circle-info" style="margin-right: 6px;"></i>
                    <strong>Guest Customers:</strong> You don't need an account to place orders or track packages! Enter your Order Number and phone number below to access your order history immediately.
                </div>

                <form action="{{ route('frontend.account') }}" method="GET" style="max-width: 540px;">
                    <input type="hidden" name="tab" value="orders">
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Order Number *</label>
                        <input type="text" name="guest_order_no" required placeholder="e.g. CB-20261122-8941" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 22px;">
                        <label style="display: block; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">Contact Phone Number *</label>
                        <input type="tel" name="guest_phone" required placeholder="017XXXXXXXX" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
                    </div>
                    <button type="submit" style="width: 100%; height: 46px; background: #0284C7; color: #fff; font-size: 13px; font-weight: 800; text-transform: uppercase; border: none; border-radius: 3px; cursor: pointer; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-magnifying-glass"></i> Find My Guest Order
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchTab(tabId, el) {
        // Hide all tab panels
        document.querySelectorAll('.account-tab-panel').forEach(panel => {
            panel.style.display = 'none';
        });

        // Show target panel
        const target = document.getElementById('tab-' + tabId);
        if (target) {
            target.style.display = 'block';
        }

        // Update active class on sidebar items
        document.querySelectorAll('.account-nav-item').forEach(item => {
            item.classList.remove('active');
            item.style.borderLeft = 'none';
            item.style.background = 'transparent';
        });

        if (el) {
            el.classList.add('active');
            el.style.borderLeft = '3px solid #000';
            el.style.background = '#f7f7f7';
        }
    }
</script>
<style>
    .account-nav-item.active {
        border-left: 3px solid #000 !important;
        background: #f7f7f7 !important;
        font-weight: 800 !important;
    }
    .account-nav-item:hover {
        background: #fbfbfb;
        color: #FA2C19 !important;
    }
    @media (max-width: 900px) {
        .account-main-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
        .account-nav-list {
            flex-direction: row !important;
            overflow-x: auto !important;
            white-space: nowrap !important;
            -webkit-overflow-scrolling: touch;
            padding: 8px 10px !important;
            gap: 6px !important;
        }
        .account-nav-item {
            border-bottom: none !important;
            border: 1px solid #eee !important;
            border-radius: 4px !important;
            padding: 8px 14px !important;
            flex-shrink: 0 !important;
        }
        .account-nav-item.active {
            border: 1px solid #000 !important;
            border-left: 1px solid #000 !important;
            background: #000 !important;
            color: #fff !important;
        }
        .account-nav-item.active span, .account-nav-item.active i {
            color: #fff !important;
        }
        .account-nav-item i.fa-chevron-right {
            display: none !important;
        }
    }
    @media (max-width: 640px) {
        .account-stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
        }
    }
</style>
@endpush
