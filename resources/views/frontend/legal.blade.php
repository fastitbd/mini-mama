@extends('frontend.layouts.master')

@section('title', $title . ' | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')
<div class="shein-container" style="max-width: 1000px; margin: 0 auto; padding: 40px 16px 80px; font-family: var(--shein-font), -apple-system, sans-serif;">
    
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 24px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">{{ $title }}</span>
    </div>

    <!-- Title Header Banner -->
    <div style="background: linear-gradient(135deg, #111111 0%, #222222 100%); color: #ffffff; border-radius: 8px; padding: 36px 32px; margin-bottom: 36px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="font-size: 11px; font-weight: 800; color: #FA2C19; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">
                {{ get_setting('com_name') ?: 'Mini Mama' }} Customer Policies & Help
            </div>
            <h1 style="font-size: 26px; font-weight: 900; text-transform: uppercase; margin: 0; color: #ffffff; letter-spacing: 0.5px;">
                {{ $title }}
            </h1>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="https://wa.me/8801901166580?text=Hello%20Mini%20Mama%20Support!%20I%20have%20an%20inquiry%20regarding%20store%20policies." target="_blank" style="background: #25D366; color: #fff; font-size: 12px; font-weight: 800; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                <i class="fa-brands fa-whatsapp"></i> Chat Support
            </a>
            <a href="{{ route('frontend.contact') }}" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #fff; font-size: 12px; font-weight: 700; padding: 8px 16px; border-radius: 4px; text-decoration: none;">
                Contact Us
            </a>
        </div>
    </div>

    <!-- Quick Navigation Pill Bar for All 5 Policies + About Us -->
    <div style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 12px; margin-bottom: 30px; border-bottom: 1px solid #eee;">
        <a href="{{ route('frontend.privacy') }}" style="padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; white-space: nowrap; background: {{ $pageType === 'privacy' ? '#000' : '#f5f5f5' }}; color: {{ $pageType === 'privacy' ? '#fff' : '#444' }};">
            <i class="fa-solid fa-shield-halved" style="margin-right: 4px;"></i> Privacy Policy
        </a>
        <a href="{{ route('frontend.returns') }}" style="padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; white-space: nowrap; background: {{ $pageType === 'returns' ? '#000' : '#f5f5f5' }}; color: {{ $pageType === 'returns' ? '#fff' : '#444' }};">
            <i class="fa-solid fa-rotate-left" style="margin-right: 4px;"></i> Return & Refund
        </a>
        <a href="{{ route('frontend.shipping') }}" style="padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; white-space: nowrap; background: {{ $pageType === 'shipping' ? '#000' : '#f5f5f5' }}; color: {{ $pageType === 'shipping' ? '#fff' : '#444' }};">
            <i class="fa-solid fa-truck-fast" style="margin-right: 4px;"></i> Shipping & Delivery
        </a>
        <a href="{{ route('frontend.terms') }}" style="padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; white-space: nowrap; background: {{ $pageType === 'terms' ? '#000' : '#f5f5f5' }}; color: {{ $pageType === 'terms' ? '#fff' : '#444' }};">
            <i class="fa-solid fa-file-contract" style="margin-right: 4px;"></i> Terms & Conditions
        </a>
        <a href="{{ route('frontend.payment_policy') }}" style="padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; white-space: nowrap; background: {{ $pageType === 'payment' ? '#000' : '#f5f5f5' }}; color: {{ $pageType === 'payment' ? '#fff' : '#444' }};">
            <i class="fa-solid fa-credit-card" style="margin-right: 4px;"></i> Payment Policy
        </a>
        <a href="{{ route('frontend.about') }}" style="padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; white-space: nowrap; background: {{ $pageType === 'about' ? '#000' : '#f5f5f5' }}; color: {{ $pageType === 'about' ? '#fff' : '#444' }};">
            <i class="fa-solid fa-store" style="margin-right: 4px;"></i> About Us
        </a>
    </div>

    <!-- MAIN BODY CONTENT (EDITABLE FROM ADMIN PANEL) -->
    <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 8px; padding: 36px 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); line-height: 1.8; font-size: 14px; color: #333333;">

        @if($pageType === 'privacy')
            <!-- 1. PRIVACY POLICY -->
            @if(!empty(get_setting('policy_privacy')))
                <div class="policy-dynamic-content">
                    {!! get_setting('policy_privacy') !!}
                </div>
            @else
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin-top: 0; text-transform: uppercase;">
                    Privacy & Cookie Policy
                </h2>
                <p><em>Last Updated: November 2026</em></p>
                
                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">1. Information We Collect</h3>
                <p>
                    When you browse our store, place an order, or register an account, we collect necessary customer information to fulfill orders and provide support:
                </p>
                <ul>
                    <li>Contact details: Customer name, email address, mobile phone number.</li>
                    <li>Delivery address: Division, District, Thana/Area, and full street address.</li>
                    <li>Order transaction details, item selections, invoices, and payment statuses.</li>
                </ul>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">2. How We Protect Your Data</h3>
                <p>
                    Your security and privacy are paramount. We use 256-bit SSL encryption across all browsing, shopping bag, and checkout transactions. We never sell, rent, or trade your personal details to unauthorized third-party advertisers.
                </p>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">3. Cookies & Session Storage</h3>
                <p>
                    We use cookies and localStorage exclusively to maintain your active shopping cart, preserve wishlist items, and remember your regional preferences for a seamless shopping experience.
                </p>
            @endif

        @elseif($pageType === 'returns')
            <!-- 2. RETURN & REFUND POLICY -->
            @if(!empty(get_setting('policy_returns')))
                <div class="policy-dynamic-content">
                    {!! get_setting('policy_returns') !!}
                </div>
            @else
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin-top: 0; text-transform: uppercase;">
                    7-Day Return, Exchange & Refund Policy
                </h2>
                <p>
                    We stand by the quality of our collections. If you are not completely satisfied with your purchase, you can take advantage of our <strong>7-Day Easy Return & Exchange policy</strong>.
                </p>

                <div style="background: #EFF6FF; border: 1px solid #BFDBFE; padding: 18px 20px; border-radius: 6px; margin: 20px 0;">
                    <div style="font-size: 14px; font-weight: 800; color: #1E40AF; margin-bottom: 4px;">
                        <i class="fa-solid fa-rotate-left"></i> Hassle-Free Exchange Guarantee
                    </div>
                    <div style="font-size: 13px; color: #1E3A8A;">
                        Receive the wrong size, color, or a defective item? We will replace it promptly with zero restocking fees.
                    </div>
                </div>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">Conditions for Returns:</h3>
                <ul>
                    <li>Product must be unwashed, unworn, with original tags intact.</li>
                    <li>Request must be submitted within 7 calendar days of delivery.</li>
                    <li>Original packaging and proof of order (Order Number or SMS) should be provided.</li>
                </ul>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">How to Submit a Return:</h3>
                <ol>
                    <li>Send a message to our WhatsApp support at <strong>+880 1901-166580</strong> with your Order Number and photos of the item.</li>
                    <li>Our team will authorize the return and assign a courier pickup.</li>
                    <li>Once inspected, your exchange item will be dispatched or refund issued to your bKash/Nagad or original payment method within 48 hours.</li>
                </ol>
            @endif

        @elseif($pageType === 'shipping')
            <!-- 3. SHIPPING & DELIVERY POLICY -->
            @if(!empty(get_setting('policy_shipping')))
                <div class="policy-dynamic-content">
                    {!! get_setting('policy_shipping') !!}
                </div>
            @else
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin-top: 0; text-transform: uppercase;">
                    Shipping & Delivery Policy
                </h2>
                <p>
                    We provide nationwide home delivery across all 64 districts in Bangladesh through trusted courier networks including Steadfast Courier and RedX.
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 24px 0;">
                    <div style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; background: #fafafa;">
                        <div style="font-size: 14px; font-weight: 800; color: #0284C7; margin-bottom: 6px;">
                            <i class="fa-solid fa-city"></i> Inside Dhaka City
                        </div>
                        <div style="font-size: 13px; color: #333; line-height: 1.6;">
                            Delivery Charge: <strong>৳ 60</strong><br>
                            Timeline: <strong>24 to 48 Hours</strong><br>
                            Cash on Delivery & doorstep trial available.
                        </div>
                    </div>

                    <div style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; background: #fafafa;">
                        <div style="font-size: 14px; font-weight: 800; color: #16A34A; margin-bottom: 6px;">
                            <i class="fa-solid fa-map-location-dot"></i> Outside Dhaka (Nationwide)
                        </div>
                        <div style="font-size: 13px; color: #333; line-height: 1.6;">
                            Delivery Charge: <strong>৳ 120</strong><br>
                            Timeline: <strong>2 to 4 Business Days</strong><br>
                            Cash on Delivery to all 64 districts.
                        </div>
                    </div>
                </div>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">Free Shipping Threshold:</h3>
                <p>
                    Orders qualifying for promotional campaigns or exceeding our free shipping threshold enjoy 100% free delivery anywhere in Bangladesh.
                </p>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">Order Tracking:</h3>
                <p>
                    You can track your parcel in real-time on our <a href="{{ route('frontend.track_order') }}" style="color: #0284c7; font-weight: 700; text-decoration: underline;">Track Order Page</a> using your Order Number and phone number.
                </p>
            @endif

        @elseif($pageType === 'terms')
            <!-- 4. TERMS & CONDITIONS -->
            @if(!empty(get_setting('policy_terms')))
                <div class="policy-dynamic-content">
                    {!! get_setting('policy_terms') !!}
                </div>
            @else
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin-top: 0; text-transform: uppercase;">
                    Terms & Conditions of Service
                </h2>
                <p>
                    Welcome to Mini Mama. By accessing our website, browsing our collections, or placing orders, you agree to comply with and be bound by the following terms.
                </p>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">1. Orders & Pricing</h3>
                <p>
                    All orders are subject to stock availability and confirmation of order details. In the rare event an item is out of stock after order submission, our team will notify you immediately to offer an alternative or cancellation.
                </p>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">2. Guest Checkout</h3>
                <p>
                    Customers may complete orders as guests without mandatory account registration. All rights, order guarantees, and return privileges apply equally to both guest shoppers and registered members.
                </p>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">3. Intellectual Property</h3>
                <p>
                    All brand logos, images, visual assets, and content on this store are proprietary to {{ get_setting('com_name') ?: 'Mini Mama' }} and protected under copyright laws.
                </p>
            @endif

        @elseif($pageType === 'payment')
            <!-- 5. PAYMENT POLICY -->
            @if(!empty(get_setting('policy_payment')))
                <div class="policy-dynamic-content">
                    {!! get_setting('policy_payment') !!}
                </div>
            @else
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin-top: 0; text-transform: uppercase;">
                    Payment & Billing Policy
                </h2>
                <p>
                    We offer flexible, trusted, and verified payment channels so you can complete your purchase with total confidence.
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 24px 0;">
                    <div style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; background: #fafafa;">
                        <div style="font-size: 14px; font-weight: 800; color: #111; margin-bottom: 6px;">
                            <i class="fa-solid fa-money-bill-wave" style="color: #10B981; margin-right: 6px;"></i> Cash On Delivery (COD)
                        </div>
                        <div style="font-size: 13px; color: #666;">
                            Pay directly in cash to the courier representative upon receiving your parcel at your doorstep anywhere in Bangladesh.
                        </div>
                    </div>

                    <div style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; background: #fafafa;">
                        <div style="font-size: 14px; font-weight: 800; color: #111; margin-bottom: 6px;">
                            <i class="fa-solid fa-mobile-screen-button" style="color: #D91D2A; margin-right: 6px;"></i> Mobile Banking (bKash & Nagad)
                        </div>
                        <div style="font-size: 13px; color: #666;">
                            Fast, instant, and secure digital payments via bKash, Nagad, and Rocket mobile wallets.
                        </div>
                    </div>
                </div>

                <h3 style="font-size: 16px; font-weight: 800; color: #111; margin-top: 24px;">Security & Fraud Protection</h3>
                <p>
                    Every transaction processed through our payment gateway is verified with industry-standard fraud prevention algorithms and encryption. We do not store full credit card CVV numbers on our servers.
                </p>
            @endif

        @elseif($pageType === 'about')
            <!-- 6. ABOUT US & STORE LOCATION -->
            <div id="about-shop" style="margin-bottom: 32px;">
                <h2 style="font-size: 20px; font-weight: 900; color: #111; margin-top: 0; text-transform: uppercase;">
                    About {{ get_setting('com_name') ?: 'Mini Mama' }}
                </h2>
                <p>
                    Welcome to <strong>{{ get_setting('com_name') ?: 'Mini Mama' }}</strong>, your trusted premier online shopping destination. We are passionate about bringing modern, trendy, and high-quality fashion, lifestyle essentials, and premium accessories right to your fingertips at accessible prices.
                </p>
                <p>
                    Whether you are discovering the newest seasonal drops, curating a capsule wardrobe, or shopping for everyday essentials, {{ get_setting('com_name') ?: 'Mini Mama' }} provides a seamless, joyful, and completely secure shopping experience.
                </p>
            </div>

            <div id="our-story" style="margin-bottom: 32px; border-top: 1px solid #eee; padding-top: 24px;">
                <h2 style="font-size: 20px; font-weight: 900; color: #111; text-transform: uppercase;">
                    Our Story
                </h2>
                <p>
                    Founded with the vision to make global trendsetting fashion accessible to everyone across Bangladesh and Southeast Asia, Mini Mama started with a simple belief: Everyone deserves to look and feel extraordinary without breaking the bank.
                </p>
                <p>
                    Today, we collaborate directly with top manufacturers, design studios, and reliable couriers to ensure authentic products, strict quality checks, and swift nationwide deliveries to thousands of happy customers daily.
                </p>
            </div>

            <div id="store-location" style="margin-bottom: 24px; border-top: 1px solid #eee; padding-top: 24px;">
                <h2 style="font-size: 20px; font-weight: 900; color: #111; text-transform: uppercase;">
                    Store & Corporate Location
                </h2>
                <div style="background: #fafafa; border: 1px solid #e0e0e0; border-radius: 6px; padding: 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 16px;">
                    <div>
                        <div style="font-size: 12px; font-weight: 800; color: #888; text-transform: uppercase;">Corporate Headquarters</div>
                        <div style="font-size: 15px; font-weight: 800; color: #111; margin: 4px 0 8px;">Shah Ali Plaza Office</div>
                        <div style="color: #555; font-size: 13px; line-height: 1.6;">
                            <i class="fa-solid fa-location-dot" style="color: #FA2C19; margin-right: 6px;"></i>
                            Suite-807, Floor-7th, Shah Ali Plaza,<br>
                            Mirpur-1216, Dhaka, Bangladesh.
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 12px; font-weight: 800; color: #888; text-transform: uppercase;">Customer Assistance</div>
                        <div style="font-size: 13px; color: #555; margin-top: 6px; line-height: 1.6;">
                            <strong>Hotline:</strong> 01901166580<br>
                            <strong>WhatsApp:</strong> +880 1901-166580<br>
                            <strong>Email:</strong> fastit.com.bd@gmail.com<br>
                            <strong>Hours:</strong> 9:00 AM - 10:00 PM (Daily)
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>

</div>
@endsection
