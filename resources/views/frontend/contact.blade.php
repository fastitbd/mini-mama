@extends('frontend.layouts.master')

@section('title', 'Help Center & Contact Us | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')
<div class="shein-container" style="max-width: 1200px; margin: 0 auto; padding: 36px 16px 80px;">
    
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 24px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">Customer Care & Contact Us</span>
    </div>

    <!-- Hero Header -->
    <div style="background: linear-gradient(135deg, #111111 0%, #222222 100%); color: #ffffff; border-radius: 8px; padding: 40px 32px; text-align: center; margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
        <div style="position: absolute; -top: 30px; -right: 30px; font-size: 140px; opacity: 0.05; font-weight: 900;">
            CARE
        </div>
        <span style="background: #FA2C19; color: #ffffff; font-size: 10px; font-weight: 800; padding: 3px 10px; border-radius: 12px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 12px;">
            24/7 CUSTOMER SUPPORT
        </span>
        <h1 style="font-size: 30px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 10px; color: #ffffff;">
            How Can We Help You Today?
        </h1>
        <p style="font-size: 13px; color: #cccccc; max-width: 600px; margin: 0 auto 24px; line-height: 1.5;">
            Our customer care team is available daily to assist with your orders, real-time parcel tracking, size recommendations, delivery, payments, and easy returns.
        </p>

        <!-- Direct Instant Action Buttons -->
        <div style="display: flex; justify-content: center; gap: 14px; flex-wrap: wrap;">
            <a href="https://wa.me/8801901166580?text=Hello%20Mini%20Mama%20Support!%20I%20have%20an%20inquiry." target="_blank" style="background: #25D366; color: #ffffff; font-size: 13px; font-weight: 800; padding: 12px 24px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35);">
                <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i> Chat on WhatsApp (Fastest)
            </a>
            <a href="https://m.me/minimama.com.bd" target="_blank" style="background: #0084FF; color: #ffffff; font-size: 13px; font-weight: 800; padding: 12px 24px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(0, 132, 255, 0.35);">
                <i class="fa-brands fa-facebook-messenger" style="font-size: 18px;"></i> Facebook Messenger
            </a>
            <a href="{{ route('frontend.track_order') }}" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); color: #ffffff; font-size: 13px; font-weight: 700; padding: 12px 22px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-truck-fast"></i> Track My Order
            </a>
        </div>
    </div>

    <!-- 4 SUPPORT INFORMATION PILLARS -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 48px;">
        
        <!-- 1. ORDER & TRACKING -->
        <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 8px; padding: 24px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
            <div style="width: 46px; height: 46px; border-radius: 50%; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px;">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h3 style="font-size: 15px; font-weight: 800; margin: 0 0 6px; text-transform: uppercase;">Order & Tracking</h3>
            <p style="font-size: 12px; color: #666; line-height: 1.5; margin: 0 0 12px;">
                Guest and registered users can track parcels in real time using their Order Number and phone number.
            </p>
            <a href="{{ route('frontend.track_order') }}" style="font-size: 11px; font-weight: 800; color: #2563EB; text-decoration: none;">
                Track Package Now &rarr;
            </a>
        </div>

        <!-- 2. FAST DELIVERY -->
        <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 8px; padding: 24px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
            <div style="width: 46px; height: 46px; border-radius: 50%; background: #ECFDF5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px;">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <h3 style="font-size: 15px; font-weight: 800; margin: 0 0 6px; text-transform: uppercase;">Delivery & Shipping</h3>
            <p style="font-size: 12px; color: #666; line-height: 1.5; margin: 0 0 12px;">
                Inside Dhaka: <strong>৳ 60</strong> (24-48 hrs).<br>
                Outside Dhaka: <strong>৳ 120</strong> (2-4 days). Free express shipping on select minimum orders!
            </p>
            <a href="#faq" style="font-size: 11px; font-weight: 800; color: #059669; text-decoration: none;">
                View Delivery Rates &rarr;
            </a>
        </div>

        <!-- 3. PAYMENT SUPPORT -->
        <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 8px; padding: 24px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
            <div style="width: 46px; height: 46px; border-radius: 50%; background: #FFFBEB; color: #D97706; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px;">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <h3 style="font-size: 15px; font-weight: 800; margin: 0 0 6px; text-transform: uppercase;">Payment & COD</h3>
            <p style="font-size: 12px; color: #666; line-height: 1.5; margin: 0 0 12px;">
                100% secure payment with Cash On Delivery (Doorstep), bKash, Nagad, Rocket, Visa and Mastercard.
            </p>
            <a href="#faq" style="font-size: 11px; font-weight: 800; color: #D97706; text-decoration: none;">
                Payment Guide &rarr;
            </a>
        </div>

        <!-- 4. RETURN & REFUND -->
        <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 8px; padding: 24px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
            <div style="width: 46px; height: 46px; border-radius: 50%; background: #FEF2F2; color: #DC2626; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px;">
                <i class="fa-solid fa-rotate-left"></i>
            </div>
            <h3 style="font-size: 15px; font-weight: 800; margin: 0 0 6px; text-transform: uppercase;">7-Day Easy Returns</h3>
            <p style="font-size: 12px; color: #666; line-height: 1.5; margin: 0 0 12px;">
                Hassle-free 7-day return and exchange policy for any defect, wrong item, or size fitting issue.
            </p>
            <a href="#faq" style="font-size: 11px; font-weight: 800; color: #DC2626; text-decoration: none;">
                Return Policy Details &rarr;
            </a>
        </div>

    </div>

    <!-- 2-COLUMN LAYOUT: CONTACT DETAILS & SEND MESSAGE FORM -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 36px; margin-bottom: 56px; align-items: start;">
        
        <!-- Left: Official Contact Details -->
        <div>
            <h2 style="font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 8px;">
                Get in Touch
            </h2>
            <p style="font-size: 13px; color: #666; margin-bottom: 24px;">
                Have questions about an existing order or need help choosing the right size? Our team is happy to assist.
            </p>

            <div style="display: flex; flex-direction: column; gap: 18px; margin-bottom: 30px;">
                <!-- Phone -->
                <div style="display: flex; align-items: center; gap: 14px; background: #fafafa; border: 1px solid #eee; padding: 16px; border-radius: 6px;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase;">Customer Service Hotline</div>
                        <a href="tel:01901166580" style="font-size: 15px; font-weight: 800; color: #111; text-decoration: none;">01901166580</a>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div style="display: flex; align-items: center; gap: 14px; background: #fafafa; border: 1px solid #eee; padding: 16px; border-radius: 6px;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: #25D366; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase;">WhatsApp Support</div>
                        <a href="https://wa.me/8801901166580?text=Hello%20Mini%20Mama%20Support" target="_blank" style="font-size: 15px; font-weight: 800; color: #25D366; text-decoration: none;">+880 1901-166580 (Click to Chat)</a>
                    </div>
                </div>

                <!-- Email -->
                <div style="display: flex; align-items: center; gap: 14px; background: #fafafa; border: 1px solid #eee; padding: 16px; border-radius: 6px;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase;">Email Inquiries</div>
                        <a href="mailto:fastit.com.bd@gmail.com" style="font-size: 14px; font-weight: 800; color: #111; text-decoration: none;">fastit.com.bd@gmail.com</a>
                    </div>
                </div>

                <!-- Address -->
                <div style="display: flex; align-items: center; gap: 14px; background: #fafafa; border: 1px solid #eee; padding: 16px; border-radius: 6px;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase;">Corporate Office</div>
                        <div style="font-size: 13px; font-weight: 700; color: #333; line-height: 1.4;">
                            Suite-807, Floor-7th, Shah Ali Plaza, Mirpur-1216, Dhaka, Bangladesh
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Send Message Form -->
        <div style="background: #ffffff; border: 1px solid #e5e5e5; border-radius: 8px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
            <h3 style="font-size: 17px; font-weight: 900; text-transform: uppercase; margin: 0 0 6px;">Send Us a Message</h3>
            <p style="font-size: 12px; color: #666; margin-bottom: 20px;">We usually respond to written inquiries within 2 hours.</p>

            <form onsubmit="event.preventDefault(); showToast('🎉 Thank you! Your message has been received. Our team will contact you shortly.'); this.reset();">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Your Name *</label>
                        <input type="text" required placeholder="e.g. Jannatul Ferdous" style="width: 100%; height: 42px; border: 1px solid #ccc; border-radius: 3px; padding: 0 12px; font-size: 13px; outline: none; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Phone Number *</label>
                        <input type="tel" required placeholder="017XXXXXXXX" style="width: 100%; height: 42px; border: 1px solid #ccc; border-radius: 3px; padding: 0 12px; font-size: 13px; outline: none; box-sizing: border-box;">
                    </div>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Email Address *</label>
                    <input type="email" required placeholder="name@example.com" style="width: 100%; height: 42px; border: 1px solid #ccc; border-radius: 3px; padding: 0 12px; font-size: 13px; outline: none; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Inquiry Topic</label>
                    <select style="width: 100%; height: 42px; border: 1px solid #ccc; border-radius: 3px; padding: 0 12px; font-size: 13px; outline: none; box-sizing: border-box; background: #fff;">
                        <option value="Order Status & Delivery">Order Status & Delivery</option>
                        <option value="Product Details & Sizing">Product Details & Sizing</option>
                        <option value="Exchange or Return Request">Exchange or Return Request</option>
                        <option value="Payment / Refund Issue">Payment / Refund Issue</option>
                        <option value="General Question">General Question</option>
                    </select>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Your Message *</label>
                    <textarea rows="4" required placeholder="Please provide your order number or question in detail..." style="width: 100%; border: 1px solid #ccc; border-radius: 3px; padding: 12px; font-size: 13px; outline: none; font-family: inherit; box-sizing: border-box; resize: vertical;"></textarea>
                </div>

                <button type="submit" style="width: 100%; height: 46px; background: #000000; color: #ffffff; font-size: 13px; font-weight: 800; text-transform: uppercase; border: none; border-radius: 3px; cursor: pointer; letter-spacing: 0.5px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-paper-plane"></i> Send Inquiry
                </button>
            </form>
        </div>

    </div>

    <!-- FAQ SECTION (COLLAPSIBLE ACCORDION) -->
    <div id="faq" style="border-top: 1px solid #eee; padding-top: 48px;">
        <div style="text-align: center; margin-bottom: 36px;">
            <span style="background: #FFF0ED; color: #FA2C19; font-size: 10px; font-weight: 800; padding: 3px 10px; border-radius: 12px; text-transform: uppercase; letter-spacing: 1px;">
                FREQUENTLY ASKED QUESTIONS
            </span>
            <h2 style="font-size: 26px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 10px 0 6px;">
                Everything You Need to Know
            </h2>
            <p style="font-size: 13px; color: #666; max-width: 500px; margin: 0 auto;">
                Find quick answers to common questions about orders, shipping charges, cash on delivery, and our return policy.
            </p>
        </div>

        <div style="max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 14px;">
            
            <!-- FAQ 1 -->
            <div class="faq-accordion-item" style="border: 1px solid #e5e5e5; border-radius: 6px; overflow: hidden; background: #ffffff;">
                <button type="button" onclick="toggleFaq(this)" style="width: 100%; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: 800; color: #111; text-align: left; cursor: pointer; background: #fff;">
                    <span><i class="fa-solid fa-truck-fast" style="color: #0284C7; margin-right: 10px;"></i> How do I track my order live?</span>
                    <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; color: #888; transition: transform 0.2s;"></i>
                </button>
                <div class="faq-content" style="display: none; padding: 0 20px 18px; font-size: 13px; color: #555; line-height: 1.6; border-top: 1px solid #f2f2f2; background: #fafafa;">
                    You can easily track your parcel anytime on our <a href="{{ route('frontend.track_order') }}" style="color: #0284c7; font-weight: 700; text-decoration: underline;">Track Order Page</a>. Simply enter your Order Number (e.g. CB-20261122-8941) and the contact phone number used during checkout. You will see a 5-step delivery pipeline with real-time courier updates.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="faq-accordion-item" style="border: 1px solid #e5e5e5; border-radius: 6px; overflow: hidden; background: #ffffff;">
                <button type="button" onclick="toggleFaq(this)" style="width: 100%; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: 800; color: #111; text-align: left; cursor: pointer; background: #fff;">
                    <span><i class="fa-solid fa-user-check" style="color: #16A34A; margin-right: 10px;"></i> Can I place an order as a Guest without creating an account?</span>
                    <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; color: #888; transition: transform 0.2s;"></i>
                </button>
                <div class="faq-content" style="display: none; padding: 0 20px 18px; font-size: 13px; color: #555; line-height: 1.6; border-top: 1px solid #f2f2f2; background: #fafafa;">
                    <strong>Yes, absolutely!</strong> Guest Checkout is fully enabled on Mini Mama. You do not need to register, remember a password, or verify an email to complete your purchase. Simply add products to your cart, enter your delivery address and phone number, and confirm your order instantly.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="faq-accordion-item" style="border: 1px solid #e5e5e5; border-radius: 6px; overflow: hidden; background: #ffffff;">
                <button type="button" onclick="toggleFaq(this)" style="width: 100%; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: 800; color: #111; text-align: left; cursor: pointer; background: #fff;">
                    <span><i class="fa-solid fa-box" style="color: #FA2C19; margin-right: 10px;"></i> What are the delivery charges and delivery times?</span>
                    <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; color: #888; transition: transform 0.2s;"></i>
                </button>
                <div class="faq-content" style="display: none; padding: 0 20px 18px; font-size: 13px; color: #555; line-height: 1.6; border-top: 1px solid #f2f2f2; background: #fafafa;">
                    <strong>Inside Dhaka:</strong> Delivery charge is <strong>৳ 60</strong>, arriving within 24 to 48 hours.<br>
                    <strong>Outside Dhaka (All 64 districts):</strong> Delivery charge is <strong>৳ 120</strong>, arriving within 2 to 4 business days via Steadfast Courier / RedX.<br>
                    Orders meeting the free shipping threshold enjoy 100% free delivery!
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="faq-accordion-item" style="border: 1px solid #e5e5e5; border-radius: 6px; overflow: hidden; background: #ffffff;">
                <button type="button" onclick="toggleFaq(this)" style="width: 100%; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: 800; color: #111; text-align: left; cursor: pointer; background: #fff;">
                    <span><i class="fa-solid fa-money-bill-wave" style="color: #059669; margin-right: 10px;"></i> Is Cash on Delivery (COD) supported nationwide?</span>
                    <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; color: #888; transition: transform 0.2s;"></i>
                </button>
                <div class="faq-content" style="display: none; padding: 0 20px 18px; font-size: 13px; color: #555; line-height: 1.6; border-top: 1px solid #f2f2f2; background: #fafafa;">
                    Yes! We offer <strong>Cash on Delivery (COD)</strong> throughout all 64 districts across Bangladesh. You can inspect the delivery package and pay cash directly to the delivery hero at your doorstep. We also support bKash, Nagad, Rocket, and credit/debit cards.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="faq-accordion-item" style="border: 1px solid #e5e5e5; border-radius: 6px; overflow: hidden; background: #ffffff;">
                <button type="button" onclick="toggleFaq(this)" style="width: 100%; padding: 18px 20px; display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: 800; color: #111; text-align: left; cursor: pointer; background: #fff;">
                    <span><i class="fa-solid fa-rotate-left" style="color: #DC2626; margin-right: 10px;"></i> What is your 7-Day Return and Exchange Policy?</span>
                    <i class="fa-solid fa-chevron-down faq-icon" style="font-size: 12px; color: #888; transition: transform 0.2s;"></i>
                </button>
                <div class="faq-content" style="display: none; padding: 0 20px 18px; font-size: 13px; color: #555; line-height: 1.6; border-top: 1px solid #f2f2f2; background: #fafafa;">
                    If an item is damaged, defective, or the size does not fit, you can request an exchange or return within <strong>7 days</strong> of delivery. Simply message us on WhatsApp (+880 1901-166580) with your Order ID and photos. We will arrange a replacement or refund to your bKash/Nagad or original payment method within 48 hours.
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function toggleFaq(btn) {
        const item = btn.parentElement;
        const content = item.querySelector('.faq-content');
        const icon = btn.querySelector('.faq-icon');

        const isOpen = content.style.display === 'block';

        if (isOpen) {
            content.style.display = 'none';
            icon.style.transform = 'rotate(0deg)';
        } else {
            content.style.display = 'block';
            icon.style.transform = 'rotate(180deg)';
        }
    }
</script>
@endpush
