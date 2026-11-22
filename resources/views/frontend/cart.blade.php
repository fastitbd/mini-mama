@extends('frontend.layouts.master')

@section('title', 'Shopping Bag | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')
<div class="shein-container" style="padding-top: 24px; padding-bottom: 80px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 20px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 600;">Shopping Bag</span>
    </div>

    <!-- Free Shipping Progress Notice -->
    <div style="background: #FFF7F5; border: 1px solid #FFE4DE; padding: 16px 24px; border-radius: 4px; margin-bottom: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <div style="font-size: 13px; font-weight: 700; color: var(--shein-red); display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-truck-fast"></i>
                <span id="pageMeterText">Add RM 120.00 more to unlock FREE STANDARD SHIPPING!</span>
            </div>
            <span style="font-size: 12px; font-weight: 800; color: #222;">Standard Shipping: RM 15.00</span>
        </div>
        <div style="background: #FFE4DE; height: 7px; border-radius: 4px; overflow: hidden;">
            <div id="pageMeterFill" style="background: var(--shein-red); height: 100%; width: 0%; transition: width 0.3s ease;"></div>
        </div>
    </div>

    <!-- Main 2-Column Cart Layout -->
    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 36px; align-items: start;" id="cartPageLayout">
        <!-- Left: Items Table / List -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 14px; border-bottom: 2px solid #222; margin-bottom: 20px;">
                <h1 style="font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                    SHOPPING BAG (<span id="cartCountTitle">0</span>)
                </h1>
                <button type="button" onclick="clearFullCart()" style="font-size: 12px; color: #888; text-decoration: underline; cursor: pointer;">
                    Clear All Items
                </button>
            </div>

            <!-- Cart Items Container -->
            <div id="fullCartList">
                <!-- Injected via JavaScript -->
            </div>

            <!-- Empty Cart Notice (Hidden by default) -->
            <div id="emptyCartView" style="display: none; text-align: center; padding: 60px 20px; background: #fafafa; border-radius: 4px; border: 1px dashed #ddd;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 56px; color: #ccc; margin-bottom: 16px;"></i>
                <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 6px;">Your Shopping Bag is empty</h2>
                <p style="color: #767676; font-size: 13px; margin-bottom: 24px;">Don't let your fashion favorites wait! Explore over 10,000+ trending new drops today.</p>
                <a href="{{ route('frontend.category', 'sale') }}" class="shein-btn-primary" style="display: inline-block; padding: 12px 32px; font-size: 13px; text-decoration: none;">
                    CONTINUE SHOPPING
                </a>
            </div>

            <!-- Trust Badges & Guarantee -->
            <div class="cart-trust-grid" style="margin-top: 36px; background: #fbfbfb; border: 1px solid #eee; border-radius: 4px; padding: 20px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; font-size: 12px; text-align: center;">
                <div>
                    <i class="fa-solid fa-rotate-left" style="font-size: 20px; color: #222; margin-bottom: 6px;"></i>
                    <div style="font-weight: 700;">20-Day Easy Return</div>
                    <div style="color: #767676; font-size: 11px;">Hassle-free return policy</div>
                </div>
                <div>
                    <i class="fa-solid fa-shield-halved" style="font-size: 20px; color: #222; margin-bottom: 6px;"></i>
                    <div style="font-weight: 700;">100% Secured Payment</div>
                    <div style="color: #767676; font-size: 11px;">Encrypted 256-bit checkout</div>
                </div>
                <div>
                    <i class="fa-solid fa-money-bill-wave" style="font-size: 20px; color: #222; margin-bottom: 6px;"></i>
                    <div style="font-weight: 700;">Cash On Delivery</div>
                    <div style="color: #767676; font-size: 11px;">Available across Malaysia</div>
                </div>
            </div>
        </div>

        <!-- Right: Order Summary Sidebar -->
        <div class="cart-summary-box" style="position: sticky; top: 90px; background: #ffffff; border: 1px solid #eeeeee; border-radius: 4px; padding: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
            <h3 style="font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                ORDER SUMMARY
            </h3>

            <!-- Promo Coupon Input -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 11px; font-weight: 800; color: #444; text-transform: uppercase; margin-bottom: 6px;">
                    <i class="fa-solid fa-ticket"></i> Coupon / Promo Code
                </label>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="cartPageCouponInput" placeholder="Enter code (e.g. NEW15)" style="flex: 1; height: 38px; border: 1px solid #ccc; padding: 0 12px; font-size: 12px; text-transform: uppercase; font-weight: 700; outline: none;">
                    <button type="button" onclick="applyCartPageCoupon()" style="background: #000; color: #fff; font-weight: 800; font-size: 11px; padding: 0 18px; text-transform: uppercase; letter-spacing: 0.5px;">
                        APPLY
                    </button>
                </div>
                <div style="font-size: 11px; color: #888; margin-top: 4px;">Popular: <strong>NEW15</strong> (15% off), <strong>MY10</strong> (RM10 off), <strong>MY25</strong> (RM25 off)</div>
            </div>

            <!-- Points Redemption Box -->
            <div style="background: #FFFBF0; border: 1px solid #FFE8A3; padding: 12px; border-radius: 4px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 12px; font-weight: 700; color: #9A6700;">🎁 {{ get_setting('com_name') ?: 'FAST IT' }} Bonus Points</div>
                    <div style="font-size: 11px; color: #666;">You have <strong>350 Points</strong> (Save RM 15.75)</div>
                </div>
                <input type="checkbox" id="pointsToggle" onchange="togglePointsDiscount(this)" style="width: 18px; height: 18px; cursor: pointer;">
            </div>

            <!-- Price Breakdown Rows -->
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 10px; color: #555;">
                <span>Retail Price Subtotal</span>
                <span id="summarySubtotal" style="font-weight: 700; color: #222;">RM 0.00</span>
            </div>

            <div id="summaryCouponRow" style="display: none; justify-content: space-between; font-size: 13px; margin-bottom: 10px; color: var(--shein-red);">
                <span>Coupon Discount (<span id="summaryCouponName"></span>)</span>
                <span id="summaryCouponVal" style="font-weight: 700;">-RM 0.00</span>
            </div>

            <div id="summaryPointsRow" style="display: none; justify-content: space-between; font-size: 13px; margin-bottom: 10px; color: #9A6700;">
                <span>Points Discount</span>
                <span style="font-weight: 700;">-RM 15.75</span>
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 14px; color: #555;">
                <span>Estimated Shipping</span>
                <span id="summaryShipping" style="font-weight: 700; color: #222;">RM 15.00</span>
            </div>

            <!-- Grand Total -->
            <div style="border-top: 2px solid #222; padding-top: 14px; margin-top: 10px; display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 20px;">
                <span style="font-size: 16px; font-weight: 900; text-transform: uppercase;">Total</span>
                <div style="text-align: right;">
                    <div style="font-size: 24px; font-weight: 900; color: var(--shein-red);" id="summaryTotal">RM 0.00</div>
                    <div style="font-size: 10px; color: #999;">All import duties & taxes included</div>
                </div>
            </div>

            <!-- Checkout Action -->
            <button type="button" class="shein-btn-primary" style="width: 100%; padding: 16px 0; font-size: 14px; letter-spacing: 1px; display: flex; align-items: center; justify-content: center; gap: 10px;" onclick="proceedToCheckoutOrder()">
                <i class="fa-solid fa-lock"></i> CHECKOUT NOW
            </button>

            <!-- Payment Badges -->
            <div style="margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 16px;">
                <div style="font-size: 11px; font-weight: 800; color: #767676; text-transform: uppercase; margin-bottom: 10px;">ACCEPTED PAYMENT METHODS</div>
                <div style="display: flex; justify-content: center; gap: 12px; font-size: 24px; color: #555;">
                    <i class="fa-brands fa-cc-visa" title="Visa"></i>
                    <i class="fa-brands fa-cc-mastercard" title="Mastercard"></i>
                    <i class="fa-brands fa-cc-paypal" title="PayPal"></i>
                    <i class="fa-brands fa-cc-apple-pay" title="Apple Pay"></i>
                    <i class="fa-solid fa-money-bill-wave" title="Cash On Delivery"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 900px) {
        #cartPageLayout {
            grid-template-columns: 1fr !important;
            gap: 24px !important;
        }
        .cart-summary-box {
            position: static !important;
            padding: 18px !important;
        }
    }
    @media (max-width: 600px) {
        .cart-trust-grid {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }
        .cart-item-row {
            gap: 12px !important;
            padding: 14px 0 !important;
        }
        .cart-item-img {
            width: 76px !important;
            height: 102px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let usePoints = false;

    document.addEventListener('DOMContentLoaded', () => {
        renderFullCartPage();
    });

    function renderFullCartPage() {
        const container = document.getElementById('fullCartList');
        const emptyView = document.getElementById('emptyCartView');
        const countTitle = document.getElementById('cartCountTitle');

        if (!container || !emptyView) return;

        const totalItemsCount = sheinCart.reduce((sum, it) => sum + it.qty, 0);
        countTitle.innerText = totalItemsCount;

        if (sheinCart.length === 0) {
            container.innerHTML = '';
            container.style.display = 'none';
            emptyView.style.display = 'block';
            calculatePageTotals(0);
            return;
        }

        container.style.display = 'block';
        emptyView.style.display = 'none';

        let subtotal = 0;
        let html = '';

        sheinCart.forEach((item, idx) => {
            const lineTotal = item.price * item.qty;
            subtotal += lineTotal;

            html += `
                <div class="cart-item-row" style="display: flex; gap: 18px; padding: 20px 0; border-bottom: 1px solid #eee; position: relative;">
                    <a href="{{ url('/product') }}/${item.id}">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-img" style="width: 100px; height: 133px; object-fit: cover; border-radius: 2px;">
                    </a>
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                                <a href="{{ url('/product') }}/${item.id}" style="font-size: 14px; font-weight: 600; color: #222; line-height: 1.35; max-width: 80%;">
                                    ${item.name}
                                </a>
                                <button type="button" onclick="deleteFullCartItem(${idx})" style="color: #999; font-size: 16px; cursor: pointer;" title="Remove Item">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                            <div style="display: flex; gap: 14px; font-size: 12px; color: #666; margin-top: 6px;">
                                <span>Size: <strong style="color: #111;">${item.size}</strong></span>
                                <span>Color: <strong style="color: #111;">${item.color || 'Standard'}</strong></span>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px;">
                            <div style="display: flex; align-items: baseline; gap: 8px;">
                                <span style="font-size: 18px; font-weight: 900; color: var(--shein-red);">RM ${item.price.toFixed(2)}</span>
                                <span style="font-size: 12px; color: #999; text-decoration: line-through;">RM ${(item.price * 1.8).toFixed(2)}</span>
                            </div>

                            <div style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 2px;">
                                <button type="button" style="width: 32px; height: 32px; font-size: 16px; background: none; border: none; cursor: pointer;" onclick="alterFullCartQty(${idx}, -1)">-</button>
                                <span style="width: 40px; text-align: center; font-weight: 700; font-size: 13px;">${item.qty}</span>
                                <button type="button" style="width: 32px; height: 32px; font-size: 16px; background: none; border: none; cursor: pointer;" onclick="alterFullCartQty(${idx}, 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        calculatePageTotals(subtotal);
    }

    function alterFullCartQty(idx, delta) {
        if (!sheinCart[idx]) return;
        sheinCart[idx].qty += delta;
        if (sheinCart[idx].qty <= 0) {
            sheinCart.splice(idx, 1);
        }
        saveSheinCart();
        renderFullCartPage();
    }

    function deleteFullCartItem(idx) {
        sheinCart.splice(idx, 1);
        saveSheinCart();
        renderFullCartPage();
        showToast('Item removed from shopping bag');
    }

    function clearFullCart() {
        if (!confirm('Are you sure you want to remove all items from your shopping bag?')) return;
        sheinCart = [];
        saveSheinCart();
        renderFullCartPage();
        showToast('Shopping bag cleared.');
    }

    function calculatePageTotals(subtotal) {
        const freeShippingThreshold = 120.00;
        const meterText = document.getElementById('pageMeterText');
        const meterFill = document.getElementById('pageMeterFill');

        if (subtotal >= freeShippingThreshold) {
            meterText.innerHTML = `🎉 Congratulations! You have unlocked <strong>FREE STANDARD SHIPPING!</strong>`;
            meterFill.style.width = '100%';
        } else {
            const gap = (freeShippingThreshold - subtotal).toFixed(2);
            const pct = Math.min(100, (subtotal / freeShippingThreshold) * 100);
            meterText.innerHTML = `Add <strong>RM ${gap}</strong> more to unlock FREE STANDARD SHIPPING!`;
            meterFill.style.width = `${pct}%`;
        }

        const discountVal = subtotal * discountRate;
        const pointsVal = (usePoints && subtotal > 30) ? 15.75 : 0.00;
        const shippingVal = (subtotal >= freeShippingThreshold || subtotal === 0) ? 0.00 : 15.00;
        const grandTotal = Math.max(0, subtotal - discountVal - pointsVal + shippingVal);

        document.getElementById('summarySubtotal').innerText = `RM ${subtotal.toFixed(2)}`;

        const couponRow = document.getElementById('summaryCouponRow');
        if (discountRate > 0) {
            couponRow.style.display = 'flex';
            document.getElementById('summaryCouponName').innerText = discountCodeName;
            document.getElementById('summaryCouponVal').innerText = `-RM ${discountVal.toFixed(2)}`;
        } else {
            couponRow.style.display = 'none';
        }

        const pointsRow = document.getElementById('summaryPointsRow');
        pointsRow.style.display = pointsVal > 0 ? 'flex' : 'none';

        document.getElementById('summaryShipping').innerText = shippingVal === 0 ? 'FREE' : `RM ${shippingVal.toFixed(2)}`;
        document.getElementById('summaryTotal').innerText = `RM ${grandTotal.toFixed(2)}`;
    }

    function applyCartPageCoupon() {
        const input = document.getElementById('cartPageCouponInput');
        const code = input.value.trim().toUpperCase();
        if (!code) return;

        if (code === 'NEW15') {
            discountRate = 0.15;
            discountCodeName = code;
            showToast('🎉 15% OFF coupon applied successfully!');
        } else if (code === 'NEW29') {
            discountRate = 0.29;
            discountCodeName = code;
            showToast('🎉 29% OFF Special Deal coupon applied!');
        } else if (code === 'NEW36') {
            discountRate = 0.36;
            discountCodeName = code;
            showToast('🎉 36% OFF Special Deal coupon applied!');
        } else if (code === 'NEW38') {
            discountRate = 0.38;
            discountCodeName = code;
            showToast('🎉 38% OFF Special Deal coupon applied!');
        } else if (code === 'MY10' || code === 'SHEIN10') {
            discountRate = 0.10;
            discountCodeName = code;
            showToast('🎉 10% OFF coupon applied successfully!');
        } else if (code === 'MY25') {
            discountRate = 0.20;
            discountCodeName = code;
            showToast('🎉 20% OFF coupon applied successfully!');
        } else if (code === 'MY50') {
            discountRate = 0.25;
            discountCodeName = code;
            showToast('🎉 25% OFF coupon applied successfully!');
        } else {
            showToast(`❌ Coupon "${code}" is invalid or expired.`);
            return;
        }

        renderFullCartPage();
    }

    function togglePointsDiscount(checkbox) {
        usePoints = checkbox.checked;
        if (usePoints) {
            showToast('🎁 350 ' + {!! json_encode(get_setting('com_name') ?: 'FAST IT') !!} + ' points applied (-RM 15.75)');
        }
        renderFullCartPage();
    }

    function proceedToCheckoutOrder() {
        if (sheinCart.length === 0) {
            showToast('Your shopping bag is empty.');
            return;
        }
        showToast('🚀 Proceeding to ' + {!! json_encode(get_setting('com_name') ?: 'FAST IT') !!} + ' Secure Checkout...');
        setTimeout(() => {
            window.location.href = "{{ route('frontend.checkout') }}";
        }, 400);
    }
</script>
@endpush
