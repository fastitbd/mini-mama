@extends('frontend.layouts.master')

@section('title', 'Secure Checkout | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')
<div class="shein-container" style="max-width: 1240px; margin: 0 auto; padding: 24px 20px 80px;">
    
    <!-- Top Step Breadcrumbs Indicator -->
    <div style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-bottom: 32px; font-size: 13px;">
        <a href="{{ route('frontend.cart') }}" style="display: flex; align-items: center; gap: 8px; color: #888888; text-decoration: none;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #222222; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">✓</span>
            <span style="font-weight: 600;">1. Shopping Bag</span>
        </a>
        <div style="width: 40px; height: 1px; background: #000000;"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: #000000; font-weight: 800;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #000000; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px;">2</span>
            <span>2. Place Order</span>
        </div>
        <div style="width: 40px; height: 1px; background: #e0e0e0;"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: #aaaaaa;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #f0f0f0; color: #aaaaaa; display: flex; align-items: center; justify-content: center; font-size: 11px;">3</span>
            <span>3. Order Confirmation</span>
        </div>
    </div>

    <!-- Free Shipping Alert Banner -->
    <div style="background: #FFF7F5; border: 1px solid #FFE4DE; padding: 12px 20px; border-radius: 4px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
        <div style="font-size: 12px; font-weight: 700; color: #FA2C19; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-truck-fast"></i>
            <span>{{ strtoupper(get_setting('com_name') ?: 'FAST IT') }}: FREE STANDARD SHIPPING ON ORDERS OVER RM 120.00!</span>
        </div>
        <span style="font-size: 11px; color: #666;">20-Day Easy Returns • Cash On Delivery Available</span>
    </div>

    <!-- Main Checkout Form Layout -->
    <form action="{{ route('frontend.place_order') }}" method="POST" id="sheinCheckoutForm" onsubmit="return handleCheckoutSubmit(event)">
        @csrf
        <input type="hidden" name="cart_items_json" id="inputCartItemsJson" value="">
        <input type="hidden" name="order_subtotal" id="inputOrderSubtotal" value="0">
        <input type="hidden" name="order_discount" id="inputOrderDiscount" value="0">
        <input type="hidden" name="shipping_fee" id="inputShippingFee" value="0">
        <input type="hidden" name="order_total" id="inputOrderTotal" value="0">

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 36px; align-items: start;">
            
            <!-- LEFT COLUMN: ADDRESS, SHIPPING & PAYMENT -->
            <div style="display: flex; flex-direction: column; gap: 28px;">
                
                <!-- 1. SHIPPING ADDRESS SECTION -->
                <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #eeeeee; padding-bottom: 12px;">
                        <h2 style="font-size: 15px; font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-location-dot" style="color: #000000;"></i>
                            <span>1. Shipping Address</span>
                        </h2>
                        <span style="font-size: 11px; color: #888888;">Ship to: 🇲🇾 Malaysia</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">First Name *</label>
                            <input type="text" name="first_name" required value="Siti" style="width: 100%; height: 40px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Last Name *</label>
                            <input type="text" name="last_name" required value="Aisyah" style="width: 100%; height: 40px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Phone Number (+60) *</label>
                            <div style="display: flex;">
                                <span style="height: 40px; background: #f5f5f5; border: 1px solid #d5d5d5; border-right: none; display: flex; align-items: center; padding: 0 10px; font-size: 12px; font-weight: 700; color: #444;">+60</span>
                                <input type="tel" name="phone" required value="189876543" placeholder="123456789" style="flex: 1; height: 40px; border: 1px solid #d5d5d5; border-radius: 0 2px 2px 0; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Email Address *</label>
                            <input type="email" name="email" required value="siti.aisyah@gmail.com" style="width: 100%; height: 40px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Street Address / Unit / Building *</label>
                        <input type="text" name="address" required value="No. 45, Jalan Ampang Hilir 2, Taman Ampang" placeholder="House/Unit No., Street name" style="width: 100%; height: 40px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">State / Territory *</label>
                            <select name="state" required style="width: 100%; height: 40px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 8px; font-size: 12px; font-family: inherit; outline: none; background: #fff; box-sizing: border-box;">
                                <option value="Kuala Lumpur" selected>Kuala Lumpur</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Johor">Johor</option>
                                <option value="Penang">Penang</option>
                                <option value="Perak">Perak</option>
                                <option value="Melaka">Melaka</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Terengganu">Terengganu</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Putrajaya">Putrajaya</option>
                                <option value="Labuan">Labuan</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">City / Town *</label>
                            <input type="text" name="city" required value="Kuala Lumpur" style="width: 100%; height: 40px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Postal Code *</label>
                            <input type="text" name="postcode" required value="55000" style="width: 100%; height: 40px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #555; cursor: pointer;">
                        <input type="checkbox" checked style="width: 16px; height: 16px;">
                        <span>Save this as my default delivery address</span>
                    </label>
                </div>

                <!-- 2. SHIPPING METHOD SECTION -->
                <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #eeeeee; padding-bottom: 12px;">
                        <h2 style="font-size: 15px; font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-truck" style="color: #000000;"></i>
                            <span>2. Shipping Method</span>
                        </h2>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <!-- Option A: Standard Shipping -->
                        <label style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border: 2px solid #000000; border-radius: 4px; cursor: pointer; background: #fafafa;">
                            <input type="radio" name="shipping_method" value="Standard Shipping (5-8 Business Days)" checked onchange="updateShippingOption(0)" style="margin-top: 3px; accent-color: #000000;">
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Standard Express Shipping</span>
                                    <span style="font-size: 13px; font-weight: 800; color: #FA2C19;" id="shippingOptLabel">FREE (Orders > RM120)</span>
                                </div>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;">Estimated Delivery: {{ now()->addDays(5)->format('d M') }} - {{ now()->addDays(8)->format('d M Y') }}</div>
                                <div style="font-size: 11px; color: #00A65A; font-weight: 600; margin-top: 2px;">✓ Delivered directly to your door with real-time SMS tracking</div>
                            </div>
                        </label>

                        <!-- Option B: Express Fast Delivery -->
                        <label style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;">
                            <input type="radio" name="shipping_method" value="Priority Express Delivery (2-4 Business Days)" onchange="updateShippingOption(25)" style="margin-top: 3px; accent-color: #000000;">
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Priority Fast Delivery</span>
                                    <span style="font-size: 13px; font-weight: 800; color: #222;">RM 25.00</span>
                                </div>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;">Estimated Delivery: {{ now()->addDays(2)->format('d M') }} - {{ now()->addDays(4)->format('d M Y') }}</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- 3. PAYMENT METHOD SECTION -->
                <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #eeeeee; padding-bottom: 12px;">
                        <h2 style="font-size: 15px; font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-credit-card" style="color: #000000;"></i>
                            <span>3. Payment Method</span>
                        </h2>
                        <span style="font-size: 11px; color: #008800; font-weight: 700;"><i class="fa-solid fa-lock"></i> 256-Bit SSL Encrypted</span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        
                        <!-- Option 1: Cash On Delivery (COD) -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 2px solid #000; border-radius: 4px; cursor: pointer; background: #fafafa;" id="payOptCOD">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="Cash On Delivery (COD)" checked onchange="selectPaymentBox('payOptCOD')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Cash On Delivery (COD)</span>
                                    <div style="font-size: 11px; color: #666;">Pay cash upon delivery at your doorstep across Malaysia</div>
                                </div>
                            </div>
                            <span style="background: #4DB6AC; color: #fff; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 2px;">CASH</span>
                        </label>

                        <!-- Option 2: Online Banking (FPX) -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;" id="payOptFPX">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="FPX Online Banking" onchange="selectPaymentBox('payOptFPX')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Online Banking (FPX)</span>
                                    <div style="font-size: 11px; color: #666;">Maybank2u, CIMB Clicks, Public Bank, RHB, Hong Leong & more</div>
                                </div>
                            </div>
                            <span style="border: 1px solid #002244; color: #002244; font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 2px;">FPX</span>
                        </label>

                        <!-- Option 3: Credit / Debit Card -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;" id="payOptCard">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="Credit / Debit Card" onchange="selectPaymentBox('payOptCard')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Credit / Debit Card</span>
                                    <div style="font-size: 11px; color: #666;">Visa, Mastercard, American Express</div>
                                </div>
                            </div>
                            <div style="display: flex; gap: 6px;">
                                <span style="background: #0D2B82; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 2px;">VISA</span>
                                <span style="background: #EB001B; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 2px;">MC</span>
                            </div>
                        </label>

                        <!-- Option 4: Touch 'n Go eWallet -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;" id="payOptTNG">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="Touch 'n Go eWallet" onchange="selectPaymentBox('payOptTNG')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Touch 'n Go eWallet</span>
                                    <div style="font-size: 11px; color: #666;">Scan QR or pay via Touch 'n Go app</div>
                                </div>
                            </div>
                            <span style="background: #005BAA; color: #fff; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 2px;">TNG</span>
                        </label>

                        <!-- Option 5: Atome (Buy Now Pay Later) -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;" id="payOptAtome">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="Atome (3x Interest-Free Installments)" onchange="selectPaymentBox('payOptAtome')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Atome — 3 Interest-Free Payments</span>
                                    <div style="font-size: 11px; color: #666;">Pay 1/3 today, remainder split over 2 months</div>
                                </div>
                            </div>
                            <span style="background: #F8E71C; color: #000; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 2px;">atome</span>
                        </label>

                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: STICKY ORDER SUMMARY -->
            <div style="position: sticky; top: 90px; background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                <h3 style="font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 18px; border-bottom: 2px solid #222; padding-bottom: 12px;">
                    ORDER SUMMARY
                </h3>

                <!-- Cart Items Mini Preview -->
                <div style="max-height: 260px; overflow-y: auto; margin-bottom: 20px; padding-right: 4px;" id="checkoutItemsList">
                    <!-- Injected via JavaScript from shein_cart -->
                </div>

                <!-- Coupon Promo Code Input -->
                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #444; text-transform: uppercase; margin-bottom: 6px;">
                        <i class="fa-solid fa-ticket" style="color: #FA2C19;"></i> Coupon / Promo Code
                    </label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" id="checkoutCouponInput" placeholder="Code (e.g. NEW15)" style="flex: 1; height: 38px; border: 1px solid #ccc; padding: 0 12px; font-size: 12px; font-weight: 700; text-transform: uppercase; outline: none;">
                        <button type="button" onclick="applyCheckoutCoupon()" style="background: #000; color: #fff; font-weight: 800; font-size: 11px; padding: 0 16px; border: none; cursor: pointer; text-transform: uppercase;">APPLY</button>
                    </div>
                    <div style="font-size: 11px; color: #888; margin-top: 4px;">Available: <strong>NEW15</strong> (15% OFF) | <strong>MY10</strong> (RM10 OFF)</div>
                </div>

                <!-- Points Toggle -->
                <div style="background: #FFFBF0; border: 1px solid #FFE8A3; padding: 10px 14px; border-radius: 4px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: #9A6700;">🎁 {{ get_setting('com_name') ?: 'FAST IT' }} Bonus Points</div>
                        <div style="font-size: 11px; color: #666;">Redeem 350 pts (-RM 15.75)</div>
                    </div>
                    <input type="checkbox" id="checkoutPointsToggle" onchange="toggleCheckoutPoints(this)" style="width: 17px; height: 17px; cursor: pointer;">
                </div>

                <!-- Financial Calculation Breakdown -->
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 13px; color: #555; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Retail Price Subtotal</span>
                        <span id="coSubtotalText" style="font-weight: 700; color: #222;">RM 0.00</span>
                    </div>
                    <div id="coCouponRow" style="display: none; justify-content: space-between; color: #FA2C19;">
                        <span>Coupon Discount (<span id="coCouponCodeName"></span>)</span>
                        <span id="coCouponDiscountText" style="font-weight: 700;">-RM 0.00</span>
                    </div>
                    <div id="coPointsRow" style="display: none; justify-content: space-between; color: #9A6700;">
                        <span>{{ get_setting('com_name') ?: 'FAST IT' }} Bonus Points</span>
                        <span style="font-weight: 700;">-RM 15.75</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Estimated Shipping</span>
                        <span id="coShippingText" style="font-weight: 700; color: #222;">FREE</span>
                    </div>
                </div>

                <!-- Grand Total -->
                <div style="border-top: 2px solid #222; padding-top: 14px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: baseline;">
                    <span style="font-size: 16px; font-weight: 900; text-transform: uppercase;">Total (MYR)</span>
                    <div style="text-align: right;">
                        <div style="font-size: 26px; font-weight: 900; color: #FA2C19;" id="coTotalText">RM 0.00</div>
                        <div style="font-size: 10px; color: #888;">Taxes & Duties Included</div>
                    </div>
                </div>

                <!-- Big Place Order Submit Button -->
                <button type="submit" id="btnPlaceOrder" style="width: 100%; height: 50px; background: #000000; color: #ffffff; font-weight: 800; font-size: 15px; letter-spacing: 0.5px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; text-transform: uppercase; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">
                    <i class="fa-solid fa-lock"></i>
                    <span>PLACE ORDER NOW</span>
                </button>

                <!-- Security & Returns Trust Guarantee -->
                <div style="margin-top: 18px; text-align: center; font-size: 11px; color: #767676; line-height: 1.6;">
                    <div>🛡️ <strong>100% Safe & Secure Checkout</strong></div>
                    <div>20-Day Easy Returns • Cash On Delivery Supported</div>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
    let checkoutCart = [];
    let checkoutDiscountRate = 0;
    let checkoutCouponCode = '';
    let checkoutUsePoints = false;
    let shippingCharge = 0.00;

    document.addEventListener('DOMContentLoaded', () => {
        loadCheckoutData();
    });

    function loadCheckoutData() {
        try {
            checkoutCart = JSON.parse(localStorage.getItem('shein_cart') || '[]');
        } catch(e) {
            checkoutCart = [];
        }

        // If cart is empty, populate with sample products so the checkout is fully testable!
        if (checkoutCart.length === 0) {
            checkoutCart = [
                {
                    id: 101,
                    name: "Aloruh Women's Elegant Chiffon Contrast Lace Blouse White",
                    price: 54.00,
                    size: 'M',
                    qty: 1,
                    image: '//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_405x552.jpg'
                },
                {
                    id: 102,
                    name: "Siren Gaze Casual Polka Dot Puff Sleeve Blouse",
                    price: 37.00,
                    size: 'S',
                    qty: 1,
                    image: '//img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_405x552.jpg'
                }
            ];
            // Save so subsequent actions know
            localStorage.setItem('shein_cart', JSON.stringify(checkoutCart));
        }

        renderCheckoutPreview();
    }

    function renderCheckoutPreview() {
        const box = document.getElementById('checkoutItemsList');
        if (!box) return;

        let subtotal = 0;
        let html = '';

        checkoutCart.forEach(item => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;
            html += `
                <div style="display: flex; gap: 12px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f2f2f2; align-items: center;">
                    <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 66px; object-fit: cover; border-radius: 2px;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 12px; font-weight: 600; color: #222; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.name}</div>
                        <div style="font-size: 11px; color: #777; margin: 2px 0;">Size: <strong>${item.size || 'Free Size'}</strong> | Qty: <strong>${item.qty}</strong></div>
                        <div style="font-size: 13px; font-weight: 800; color: #000;">RM ${(item.price).toFixed(2)}</div>
                    </div>
                </div>
            `;
        });

        box.innerHTML = html;

        // Shipping calculation (free over RM120)
        const freeShipLimit = 120.00;
        const actualShipping = (subtotal >= freeShipLimit || shippingCharge === 0) ? 0.00 : shippingCharge;

        const discVal = subtotal * checkoutDiscountRate;
        const ptsVal = (checkoutUsePoints && subtotal > 30) ? 15.75 : 0.00;
        const grandTotal = Math.max(0, subtotal - discVal - ptsVal + actualShipping);

        // Update UI Text
        document.getElementById('coSubtotalText').innerText = `RM ${subtotal.toFixed(2)}`;
        
        const cpRow = document.getElementById('coCouponRow');
        if (checkoutDiscountRate > 0) {
            cpRow.style.display = 'flex';
            document.getElementById('coCouponCodeName').innerText = checkoutCouponCode;
            document.getElementById('coCouponDiscountText').innerText = `-RM ${discVal.toFixed(2)}`;
        } else {
            cpRow.style.display = 'none';
        }

        const ptsRow = document.getElementById('coPointsRow');
        ptsRow.style.display = ptsVal > 0 ? 'flex' : 'none';

        document.getElementById('coShippingText').innerText = actualShipping === 0 ? 'FREE' : `RM ${actualShipping.toFixed(2)}`;
        document.getElementById('coTotalText').innerText = `RM ${grandTotal.toFixed(2)}`;

        // Sync hidden form inputs
        document.getElementById('inputCartItemsJson').value = JSON.stringify(checkoutCart);
        document.getElementById('inputOrderSubtotal').value = subtotal.toFixed(2);
        document.getElementById('inputOrderDiscount').value = (discVal + ptsVal).toFixed(2);
        document.getElementById('inputShippingFee').value = actualShipping.toFixed(2);
        document.getElementById('inputOrderTotal').value = grandTotal.toFixed(2);
    }

    function applyCheckoutCoupon() {
        const code = document.getElementById('checkoutCouponInput').value.trim().toUpperCase();
        if (!code) return;

        if (code === 'NEW15') {
            checkoutDiscountRate = 0.15;
            checkoutCouponCode = 'NEW15';
            showToast('🎉 15% OFF Coupon Applied!');
        } else if (code === 'NEW29') {
            checkoutDiscountRate = 0.29;
            checkoutCouponCode = 'NEW29';
            showToast('🎉 29% OFF Special Deal Applied!');
        } else if (code === 'NEW36') {
            checkoutDiscountRate = 0.36;
            checkoutCouponCode = 'NEW36';
            showToast('🎉 36% OFF Special Deal Applied!');
        } else if (code === 'NEW38') {
            checkoutDiscountRate = 0.38;
            checkoutCouponCode = 'NEW38';
            showToast('🎉 38% OFF Special Deal Applied!');
        } else if (code === 'MY10' || code === 'SHEIN10') {
            checkoutDiscountRate = 0.10;
            checkoutCouponCode = code;
            showToast('🎉 10% OFF Coupon Applied!');
        } else {
            showToast(`❌ Coupon "${code}" is invalid.`);
            return;
        }
        renderCheckoutPreview();
    }

    function toggleCheckoutPoints(cb) {
        checkoutUsePoints = cb.checked;
        if (checkoutUsePoints) {
            showToast('🎁 350 ' + {!! json_encode(get_setting('com_name') ?: 'FAST IT') !!} + ' points applied (-RM 15.75)');
        }
        renderCheckoutPreview();
    }

    function updateShippingOption(fee) {
        shippingCharge = fee;
        renderCheckoutPreview();
    }

    function selectPaymentBox(selectedId) {
        ['payOptCOD', 'payOptFPX', 'payOptCard', 'payOptTNG', 'payOptAtome'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                if (id === selectedId) {
                    el.style.border = '2px solid #000000';
                    el.style.background = '#fafafa';
                } else {
                    el.style.border = '1px solid #e0e0e0';
                    el.style.background = '#ffffff';
                }
            }
        });
    }

    function handleCheckoutSubmit(e) {
        // Clear cart in localStorage after placing order
        localStorage.removeItem('shein_cart');
        return true;
    }
</script>
@endpush
