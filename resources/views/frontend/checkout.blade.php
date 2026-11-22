@extends('frontend.layouts.master')

@section('title', 'Secure Checkout | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')
<div class="shein-container" style="max-width: 1240px; margin: 0 auto; padding: 24px 20px 80px;">
    
    <!-- Top Step Breadcrumbs Indicator -->
    <div style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-bottom: 28px; font-size: 13px;">
        <a href="{{ route('frontend.cart') }}" style="display: flex; align-items: center; gap: 8px; color: #888888; text-decoration: none;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #222222; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">✓</span>
            <span style="font-weight: 600;">1. Shopping Bag</span>
        </a>
        <div style="width: 40px; height: 1px; background: #000000;"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: #000000; font-weight: 800;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #000000; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 11px;">2</span>
            <span>2. Place Order (Guest Checkout)</span>
        </div>
        <div style="width: 40px; height: 1px; background: #e0e0e0;"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: #aaaaaa;">
            <span style="width: 22px; height: 22px; border-radius: 50%; background: #f0f0f0; color: #aaaaaa; display: flex; align-items: center; justify-content: center; font-size: 11px;">3</span>
            <span>3. Order Confirmation</span>
        </div>
    </div>

    <!-- Guest Checkout Notice Banner -->
    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; padding: 14px 20px; border-radius: 4px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 700; color: #166534;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #16A34A;"></i>
            <span><strong>Guest Checkout Enabled:</strong> No account or password required to place your order!</span>
        </div>
        <span style="font-size: 12px; color: #15803D;">🔒 100% Secure 256-Bit SSL Checkout</span>
    </div>

    <!-- Main Checkout Form Layout -->
    <form action="{{ route('frontend.place_order') }}" method="POST" id="sheinCheckoutForm" onsubmit="return handleCheckoutSubmit(event)">
        @csrf
        <input type="hidden" name="cart_items_json" id="inputCartItemsJson" value="">
        <input type="hidden" name="order_subtotal" id="inputOrderSubtotal" value="0">
        <input type="hidden" name="order_discount" id="inputOrderDiscount" value="0">
        <input type="hidden" name="shipping_fee" id="inputShippingFee" value="0">
        <input type="hidden" name="order_total" id="inputOrderTotal" value="0">

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 36px; align-items: start;" class="checkout-grid">
            
            <!-- LEFT COLUMN: ADDRESS, SHIPPING & PAYMENT -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <!-- 1. CUSTOMER & SHIPPING ADDRESS SECTION -->
                <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #eeeeee; padding-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                        <h2 style="font-size: 15px; font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-location-dot" style="color: #000000;"></i>
                            <span>1. Delivery Information</span>
                        </h2>
                        <!-- Country Switcher -->
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <span style="font-size: 11px; font-weight: 700; color: #666;">Delivery Region:</span>
                            <select name="country" id="countrySelector" onchange="switchCountry(this.value)" style="height: 30px; border: 1px solid #ccc; font-size: 12px; font-weight: 700; border-radius: 3px; padding: 0 6px; outline: none; background: #fff; cursor: pointer;">
                                <option value="Bangladesh" selected>🇧🇩 Bangladesh</option>
                                <option value="Malaysia">🇲🇾 Malaysia</option>
                            </select>
                        </div>
                    </div>

                    <!-- Customer Names -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">First Name *</label>
                            <input type="text" name="first_name" required placeholder="e.g. Shakil" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Last Name *</label>
                            <input type="text" name="last_name" required placeholder="e.g. Ahmed" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <!-- Phone Number & Email -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Mobile Phone Number *</label>
                            <div style="display: flex;">
                                <span id="phonePrefix" style="height: 42px; background: #f5f5f5; border: 1px solid #d5d5d5; border-right: none; display: flex; align-items: center; padding: 0 10px; font-size: 12px; font-weight: 700; color: #444;">+880</span>
                                <input type="tel" name="phone" required placeholder="1XXXXXXXXX" style="flex: 1; height: 42px; border: 1px solid #d5d5d5; border-radius: 0 2px 2px 0; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Email Address *</label>
                            <input type="email" name="email" required placeholder="customer@gmail.com" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <!-- Street / House Address -->
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Full Delivery Address (House/Road/Area) *</label>
                        <input type="text" name="address" required placeholder="House No, Road No, Sector / Village / Apartment" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                    </div>

                    <!-- BANGLADESH REGION: Division, District, Area -->
                    <div id="bdRegionFields" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Division *</label>
                            <select name="state" id="bdDivision" onchange="updateBdDivision(this.value)" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 8px; font-size: 12px; font-family: inherit; outline: none; background: #fff; box-sizing: border-box;">
                                <option value="Dhaka" selected>Dhaka</option>
                                <option value="Chattogram">Chattogram</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Mymensingh">Mymensingh</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">District *</label>
                            <select name="city" id="bdDistrict" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 8px; font-size: 12px; font-family: inherit; outline: none; background: #fff; box-sizing: border-box;">
                                <option value="Dhaka" selected>Dhaka</option>
                                <option value="Gazipur">Gazipur</option>
                                <option value="Narayanganj">Narayanganj</option>
                                <option value="Chattogram">Chattogram</option>
                                <option value="Cox's Bazar">Cox's Bazar</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Cumilla">Cumilla</option>
                                <option value="Bogura">Bogura</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Mymensingh">Mymensingh</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Area / Thana / Postcode *</label>
                            <input type="text" name="postcode" id="bdAreaPostcode" required value="Dhanmondi, 1205" placeholder="e.g. Dhanmondi / Mirpur / 1205" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <!-- MALAYSIA REGION (Hidden by default) -->
                    <div id="myRegionFields" style="display: none; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">State / Territory *</label>
                            <select name="my_state" id="myState" onchange="updateMyState(this.value)" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 8px; font-size: 12px; font-family: inherit; outline: none; background: #fff; box-sizing: border-box;">
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
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">City / Town *</label>
                            <input type="text" name="my_city" value="Kuala Lumpur" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 6px;">Postal Code *</label>
                            <input type="text" name="my_postcode" value="55000" style="width: 100%; height: 42px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; font-family: inherit; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <!-- Optional Account Creation Toggle -->
                    <div style="border-top: 1px solid #f2f2f2; padding-top: 14px; margin-top: 10px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; color: #444; cursor: pointer;">
                            <input type="checkbox" id="createAccountCheck" onchange="toggleAccountPassword(this)" style="width: 16px; height: 16px; accent-color: #000;">
                            <span>Create an account for faster re-orders next time (Optional)</span>
                        </label>
                        <div id="accountPasswordBox" style="display: none; margin-top: 12px;">
                            <label style="display: block; font-size: 12px; font-weight: 700; color: #222; margin-bottom: 4px;">Choose Account Password</label>
                            <input type="password" name="password" placeholder="Create a secure password" style="width: 100%; max-width: 320px; height: 38px; border: 1px solid #d5d5d5; border-radius: 2px; padding: 0 12px; font-size: 13px; outline: none;">
                        </div>
                    </div>
                </div>

                <!-- 2. DELIVERY & SHIPPING METHOD SECTION -->
                <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 4px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #eeeeee; padding-bottom: 12px;">
                        <h2 style="font-size: 15px; font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-truck" style="color: #000000;"></i>
                            <span>2. Delivery Method & Charges</span>
                        </h2>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px;" id="shippingMethodsList">
                        <!-- Option 1: Standard Home Delivery -->
                        <label style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border: 2px solid #000000; border-radius: 4px; cursor: pointer; background: #fafafa;" id="shipCardStd">
                            <input type="radio" name="shipping_method" value="Standard Home Delivery" checked onchange="selectShippingMethod('standard')" style="margin-top: 3px; accent-color: #000000;">
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Standard Home Delivery</span>
                                    <span style="font-size: 13px; font-weight: 800; color: #FA2C19;" id="shipCostLabel">RM 8.00 / ৳70</span>
                                </div>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;" id="shipEstimateText">Estimated Delivery: 2-4 Days</div>
                                <div style="font-size: 11px; color: #10B981; font-weight: 600; margin-top: 2px;">✓ Real-time SMS & courier tracking updates</div>
                            </div>
                        </label>

                        <!-- Option 2: Express Fast Delivery -->
                        <label style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;" id="shipCardExp">
                            <input type="radio" name="shipping_method" value="Express Priority Delivery" onchange="selectShippingMethod('express')" style="margin-top: 3px; accent-color: #000000;">
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Priority Fast Delivery</span>
                                    <span style="font-size: 13px; font-weight: 800; color: #222;" id="shipExpCostLabel">RM 16.00 / ৳150</span>
                                </div>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;">Estimated Delivery: 24-48 Hours Express</div>
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
                        <span style="font-size: 11px; color: #10B981; font-weight: 700;"><i class="fa-solid fa-lock"></i> 100% Secured Payment</span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <!-- COD -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 2px solid #000; border-radius: 4px; cursor: pointer; background: #fafafa;" id="payOptCOD">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="Cash On Delivery (COD)" checked onchange="selectPaymentBox('payOptCOD')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Cash On Delivery (COD)</span>
                                    <div style="font-size: 11px; color: #666;">Pay cash upon delivery at your doorstep</div>
                                </div>
                            </div>
                            <span style="background: #10B981; color: #fff; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 2px;">CASH</span>
                        </label>

                        <!-- Mobile Banking (bKash / Nagad) / FPX -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;" id="payOptMobile">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="Mobile Banking / Online Payment" onchange="selectPaymentBox('payOptMobile')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Mobile Banking / Online Payment</span>
                                    <div style="font-size: 11px; color: #666;">bKash, Nagad, Rocket, FPX Online Banking</div>
                                </div>
                            </div>
                            <span style="border: 1px solid #E2136E; color: #E2136E; font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 2px;">bKash / FPX</span>
                        </label>

                        <!-- Credit / Debit Card -->
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer;" id="payOptCard">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="radio" name="payment_method" value="Credit / Debit Card" onchange="selectPaymentBox('payOptCard')" style="accent-color: #000;">
                                <div>
                                    <span style="font-size: 13px; font-weight: 800; color: #000;">Credit / Debit Card</span>
                                    <div style="font-size: 11px; color: #666;">Visa, Mastercard, UnionPay</div>
                                </div>
                            </div>
                            <div style="display: flex; gap: 6px;">
                                <span style="background: #0D2B82; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 2px;">VISA</span>
                                <span style="background: #EB001B; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 2px;">MC</span>
                            </div>
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
                        <input type="text" id="checkoutCouponInput" placeholder="Code (e.g. NEW15)" style="flex: 1; height: 38px; border: 1px solid #ccc; padding: 0 12px; font-size: 12px; font-weight: 700; text-transform: uppercase; outline: none; border-radius: 2px;">
                        <button type="button" onclick="applyCheckoutCoupon()" style="background: #000; color: #fff; font-weight: 800; font-size: 11px; padding: 0 16px; border: none; cursor: pointer; text-transform: uppercase; border-radius: 2px;">APPLY</button>
                    </div>
                    <div style="font-size: 11px; color: #888; margin-top: 4px;">Popular: <strong>NEW15</strong> (15% OFF) | <strong>FREESHIP</strong></div>
                </div>

                <!-- Financial Calculation Breakdown -->
                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: #555; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Retail Price Subtotal</span>
                        <span id="coSubtotalText" style="font-weight: 700; color: #222;">RM 0.00</span>
                    </div>
                    <div id="coCouponRow" style="display: none; justify-content: space-between; color: #FA2C19;">
                        <span>Coupon Discount (<span id="coCouponCodeName"></span>)</span>
                        <span id="coCouponDiscountText" style="font-weight: 700;">-RM 0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Delivery Fee</span>
                        <span id="coShippingText" style="font-weight: 700; color: #222;">RM 8.00</span>
                    </div>
                </div>

                <!-- Grand Total -->
                <div style="border-top: 2px solid #222; padding-top: 14px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: baseline;">
                    <span style="font-size: 16px; font-weight: 900; text-transform: uppercase;">Total</span>
                    <div style="text-align: right;">
                        <div style="font-size: 26px; font-weight: 900; color: #FA2C19;" id="coTotalText">RM 0.00</div>
                        <div style="font-size: 10px; color: #888;">All Taxes & Duties Included</div>
                    </div>
                </div>

                <!-- Place Order Button -->
                <button type="submit" id="btnPlaceOrder" style="width: 100%; height: 50px; background: #000000; color: #ffffff; font-weight: 800; font-size: 15px; letter-spacing: 0.5px; border: none; border-radius: 3px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; text-transform: uppercase; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">
                    <i class="fa-solid fa-lock"></i>
                    <span>CONFIRM & PLACE ORDER</span>
                </button>

                <!-- Guarantee -->
                <div style="margin-top: 18px; text-align: center; font-size: 11px; color: #767676; line-height: 1.6;">
                    <div>🛡️ <strong>100% Safe & Secure Checkout</strong></div>
                    <div>20-Day Easy Returns • Cash On Delivery Supported</div>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection

@push('styles')
<style>
    @media (max-width: 900px) {
        .checkout-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let checkoutCart = [];
    let checkoutDiscountRate = 0;
    let checkoutCouponCode = '';
    let selectedCountry = 'Bangladesh';
    let baseDeliveryFee = 8.00;
    let shippingTier = 'standard'; // 'standard' or 'express'

    document.addEventListener('DOMContentLoaded', () => {
        loadCheckoutData();
    });

    function loadCheckoutData() {
        try {
            checkoutCart = JSON.parse(localStorage.getItem('shein_cart') || '[]');
        } catch(e) {
            checkoutCart = [];
        }

        if (checkoutCart.length === 0) {
            checkoutCart = [
                {
                    id: 101,
                    name: "Aloruh Women's Elegant Chiffon Contrast Lace Blouse White",
                    price: 54.00,
                    size: 'M',
                    qty: 1,
                    image: '//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_405x552.jpg'
                }
            ];
            localStorage.setItem('shein_cart', JSON.stringify(checkoutCart));
        }

        calculateDeliveryFee();
        renderCheckoutPreview();
    }

    function switchCountry(country) {
        selectedCountry = country;
        const bdFields = document.getElementById('bdRegionFields');
        const myFields = document.getElementById('myRegionFields');
        const prefix = document.getElementById('phonePrefix');

        if (country === 'Bangladesh') {
            bdFields.style.display = 'grid';
            myFields.style.display = 'none';
            prefix.innerText = '+880';
            baseDeliveryFee = 8.00; // ৳70
        } else {
            bdFields.style.display = 'none';
            myFields.style.display = 'grid';
            prefix.innerText = '+60';
            baseDeliveryFee = 10.00;
        }

        calculateDeliveryFee();
        renderCheckoutPreview();
    }

    function updateBdDivision(div) {
        // Inside Dhaka = RM 8.00; Outside Dhaka = RM 13.00
        if (div === 'Dhaka') {
            baseDeliveryFee = 8.00;
            showToast('🚚 Delivery Charge for Dhaka: RM 8.00 / ৳70');
        } else {
            baseDeliveryFee = 13.00;
            showToast('🚚 Delivery Charge outside Dhaka: RM 13.00 / ৳130');
        }
        calculateDeliveryFee();
        renderCheckoutPreview();
    }

    function updateMyState(state) {
        if (state === 'Sabah' || state === 'Sarawak') {
            baseDeliveryFee = 18.00;
            showToast('🚚 Delivery Charge for East Malaysia: RM 18.00');
        } else {
            baseDeliveryFee = 10.00;
            showToast('🚚 Delivery Charge for West Malaysia: RM 10.00');
        }
        calculateDeliveryFee();
        renderCheckoutPreview();
    }

    function selectShippingMethod(type) {
        shippingTier = type;
        const stdCard = document.getElementById('shipCardStd');
        const expCard = document.getElementById('shipCardExp');

        if (type === 'standard') {
            stdCard.style.border = '2px solid #000';
            stdCard.style.background = '#fafafa';
            expCard.style.border = '1px solid #e0e0e0';
            expCard.style.background = '#fff';
        } else {
            expCard.style.border = '2px solid #000';
            expCard.style.background = '#fafafa';
            stdCard.style.border = '1px solid #e0e0e0';
            stdCard.style.background = '#fff';
        }

        calculateDeliveryFee();
        renderCheckoutPreview();
    }

    function calculateDeliveryFee() {
        let subtotal = checkoutCart.reduce((sum, it) => sum + (it.price * it.qty), 0);
        let actualFee = baseDeliveryFee;

        if (shippingTier === 'express') {
            actualFee = baseDeliveryFee + 8.00;
        }

        // Free delivery threshold: RM 120
        if (subtotal >= 120.00 || checkoutCouponCode === 'FREESHIP') {
            actualFee = 0.00;
        }

        document.getElementById('shipCostLabel').innerText = (subtotal >= 120.00 || checkoutCouponCode === 'FREESHIP') ? 'FREE (Orders > RM120)' : `RM ${baseDeliveryFee.toFixed(2)}`;
        return actualFee;
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
                <div style="display: flex; gap: 12px; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #f2f2f2; align-items: center;">
                    <img src="${item.image}" alt="${item.name}" style="width: 48px; height: 64px; object-fit: cover; border-radius: 2px;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 12px; font-weight: 600; color: #222; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.name}</div>
                        <div style="font-size: 11px; color: #777; margin: 2px 0;">Size: <strong>${item.size || 'M'}</strong> | Qty: <strong>${item.qty}</strong></div>
                        <div style="font-size: 13px; font-weight: 800; color: #000;">RM ${(item.price * item.qty).toFixed(2)}</div>
                    </div>
                </div>
            `;
        });

        box.innerHTML = html;

        const actualShipping = calculateDeliveryFee();
        const discVal = subtotal * checkoutDiscountRate;
        const grandTotal = Math.max(0, subtotal - discVal + actualShipping);

        // Update UI
        document.getElementById('coSubtotalText').innerText = `RM ${subtotal.toFixed(2)}`;
        
        const cpRow = document.getElementById('coCouponRow');
        if (checkoutDiscountRate > 0) {
            cpRow.style.display = 'flex';
            document.getElementById('coCouponCodeName').innerText = checkoutCouponCode;
            document.getElementById('coCouponDiscountText').innerText = `-RM ${discVal.toFixed(2)}`;
        } else {
            cpRow.style.display = 'none';
        }

        document.getElementById('coShippingText').innerText = actualShipping === 0 ? 'FREE' : `RM ${actualShipping.toFixed(2)}`;
        document.getElementById('coTotalText').innerText = `RM ${grandTotal.toFixed(2)}`;

        // Sync hidden form inputs
        document.getElementById('inputCartItemsJson').value = JSON.stringify(checkoutCart);
        document.getElementById('inputOrderSubtotal').value = subtotal.toFixed(2);
        document.getElementById('inputOrderDiscount').value = discVal.toFixed(2);
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
        } else if (code === 'NEW20') {
            checkoutDiscountRate = 0.20;
            checkoutCouponCode = 'NEW20';
            showToast('🎉 20% OFF Coupon Applied!');
        } else if (code === 'FREESHIP') {
            checkoutDiscountRate = 0;
            checkoutCouponCode = 'FREESHIP';
            showToast('🚚 Free Shipping Coupon Applied!');
        } else {
            showToast(`❌ Coupon "${code}" is invalid or expired.`);
            return;
        }
        renderCheckoutPreview();
    }

    function toggleAccountPassword(cb) {
        document.getElementById('accountPasswordBox').style.display = cb.checked ? 'block' : 'none';
    }

    function selectPaymentBox(selectedId) {
        ['payOptCOD', 'payOptMobile', 'payOptCard'].forEach(id => {
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
        localStorage.removeItem('shein_cart');
        return true;
    }
</script>
@endpush
