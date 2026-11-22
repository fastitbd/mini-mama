<!-- ==========================================
     OFFICIAL FOOTER
     ========================================== -->
<footer class="shein-official-footer" style="background: #ffffff; padding: 48px 0 32px; border-top: 1px solid #eeeeee; font-family: var(--shein-font), -apple-system, sans-serif; position: relative;">
    <div class="shein-wrap" style="max-width: 1440px; margin: 0 auto; padding: 0 24px;">
        
        <!-- MAIN FOOTER TOP ROW (LEFT 4 COLUMNS + RIGHT FORMS & SOCIALS) -->
        <div style="display: flex; justify-content: space-between; gap: 40px; flex-wrap: wrap;">
            
            <!-- LEFT 4 COLUMNS: NAVIGATION LINKS -->
            <div style="display: flex; gap: 50px; flex-wrap: wrap; flex: 1; min-width: 300px;">
                
                <!-- 1. CUSTOMER SERVICE -->
                <div style="min-width: 135px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 16px; letter-spacing: 0.3px;">CUSTOMER SERVICE</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #333333; line-height: 2.15;">
                        <li><a href="{{ route('frontend.contact') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Contact Us</a></li>
                        <li><a href="{{ route('frontend.contact') }}#faq" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">FAQ</a></li>
                        <li><a href="{{ route('frontend.track_order') }}" style="color: #0284c7; font-weight: 700; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#0284c7'"><i class="fa-solid fa-truck-fast" style="margin-right: 4px;"></i> Track Order</a></li>
                        <li><a href="{{ route('frontend.shipping') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Shipping & Delivery</a></li>
                        <li><a href="#" onclick="showToast('How To Order: Choose style, pick size, and checkout securely')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">How To Order</a></li>
                        <li><a href="#" onclick="showToast('Size Guide: Find your perfect fit with our measurement chart')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Size Guide</a></li>
                    </ul>
                </div>

                <!-- 2. POLICIES -->
                <div style="min-width: 135px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 16px; letter-spacing: 0.3px;">POLICIES</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #333333; line-height: 2.15;">
                        <li><a href="{{ route('frontend.privacy') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Privacy Policy</a></li>
                        <li><a href="{{ route('frontend.returns') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Return & Refund Policy</a></li>
                        <li><a href="{{ route('frontend.shipping') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Shipping & Delivery Policy</a></li>
                        <li><a href="{{ route('frontend.terms') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Terms & Conditions</a></li>
                        <li><a href="{{ route('frontend.payment_policy') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Payment Policy</a></li>
                    </ul>
                </div>

                <!-- 3. ABOUT US -->
                <div style="min-width: 135px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 16px; letter-spacing: 0.3px;">ABOUT US</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #333333; line-height: 2.15;">
                        <li><a href="{{ route('frontend.about') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">About the Shop</a></li>
                        <li><a href="{{ route('frontend.about') }}#our-story" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Our Story</a></li>
                        <li><a href="{{ route('frontend.about') }}#store-location" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Store Location</a></li>
                        <li><a href="#" onclick="showToast('Fashion Blogger Program: Earn rewards by sharing outfits')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Fashion Blogger</a></li>
                        <li><a href="#" onclick="showToast('Social Responsibility: Committed to green supply chain & sustainability')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Social Responsibility</a></li>
                    </ul>
                </div>

                <!-- 4. EXPLORE -->
                <div style="min-width: 135px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 16px; letter-spacing: 0.3px;">EXPLORE</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #333333; line-height: 2.15;">
                        <li><a href="{{ route('frontend.blog') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Blog</a></li>
                        <li><a href="{{ route('frontend.category', 'all') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Gift Guides</a></li>
                        <li><a href="{{ route('frontend.blog') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Shopping Tips</a></li>
                        <li><a href="{{ route('frontend.category', 'new-in') }}" style="color: #4ADE80; font-weight: 700; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#4ADE80'">New Arrivals</a></li>
                        <li><a href="{{ route('frontend.category', 'sale') }}" style="color: #FA2C19; font-weight: 800; text-decoration: none;" onmouseover="this.style.color='#111'" onmouseout="this.style.color='#FA2C19'">Flash Sale</a></li>
                    </ul>
                </div>

            </div>

            <!-- RIGHT SECTION: SOCIALS, APP, NEWSLETTER, PAYMENTS -->
            <div style="flex: 1; min-width: 320px; max-width: 540px;">
                
                <!-- TOP ROW: FOLLOW US & APP -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 22px; flex-wrap: wrap; gap: 20px;">
                    <!-- FOLLOW US -->
                    <div>
                        <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">FOLLOW US</h4>
                        <div style="display: flex; align-items: center; gap: 14px; font-size: 19px; color: #000000;">
                            <!-- Facebook -->
                            <a href="https://facebook.com" target="_blank" title="Facebook" style="color: #1877F2; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='none'">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            <!-- Instagram -->
                            <a href="https://instagram.com" target="_blank" title="Instagram" style="color: #E4405F; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='none'">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <!-- WhatsApp -->
                            <a href="https://wa.me/8801901166580?text=Hello%20Mini%20Mama%20Support" target="_blank" title="WhatsApp" style="color: #25D366; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='none'">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <!-- TikTok -->
                            <a href="https://tiktok.com" target="_blank" title="TikTok" style="color: #000000; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='none'">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                            <!-- YouTube -->
                            <a href="https://youtube.com" target="_blank" title="YouTube" style="color: #FF0000; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='none'">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                            <!-- Twitter / X -->
                            <a href="https://x.com" target="_blank" title="Twitter / X" style="color: #000000; text-decoration: none; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='none'">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                        </div>
                    </div>

                    <!-- APP -->
                    <div>
                        <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">APP</h4>
                        <div style="display: flex; align-items: center; gap: 14px; font-size: 20px; color: #000000;">
                            <a href="#" onclick="showToast('{{ get_setting('com_name') ?: 'Mini Mama' }} App on iOS App Store')" title="Download iOS App" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-apple"></i></a>
                            <a href="#" onclick="showToast('{{ get_setting('com_name') ?: 'Mini Mama' }} App on Google Play Store')" title="Download Android App" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-android"></i></a>
                        </div>
                    </div>
                </div>

                <!-- SIGN UP FOR STYLE NEWS -->
                <div style="margin-bottom: 24px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">SIGN UP FOR {{ strtoupper(get_setting('com_name') ?: 'MINI MAMA') }} STYLE NEWS</h4>
                    
                    <!-- Form 1: Email Address -->
                    <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing to {{ get_setting('com_name') ?: 'Mini Mama' }} Style News!'); this.reset();" style="display: flex; height: 38px; margin-bottom: 10px; width: 100%;">
                        <input type="email" placeholder="Your Email Address" required style="flex: 1; height: 100%; border: 1px solid #e0e0e0; border-right: none; padding: 0 14px; font-size: 13px; font-family: inherit; color: #222222; outline: none; background: #ffffff;">
                        <button type="submit" style="width: 125px; height: 100%; background: #000000; color: #ffffff; font-weight: 800; font-size: 13px; border: none; cursor: pointer; text-transform: capitalize; letter-spacing: 0.2px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">Subscribe</button>
                    </form>

                    <!-- Form 2: Phone number for SMS -->
                    <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing to {{ get_setting('com_name') ?: 'Mini Mama' }} SMS Alerts!'); this.reset();" style="display: flex; height: 38px; margin-bottom: 10px; width: 100%;">
                        <div style="display: flex; align-items: center; gap: 6px; padding: 0 12px; background: #ffffff; border: 1px solid #e0e0e0; border-right: none; font-size: 12px; font-weight: 600; color: #222222; cursor: pointer;">
                            <span>BD +880</span>
                            <i class="fa-solid fa-caret-down" style="font-size: 10px; color: #666666;"></i>
                        </div>
                        <input type="tel" placeholder="Your phone number for SMS" required style="flex: 1; height: 100%; border: 1px solid #e0e0e0; border-right: none; border-left: none; padding: 0 14px; font-size: 13px; font-family: inherit; color: #222222; outline: none; background: #ffffff;">
                        <button type="submit" style="width: 125px; height: 100%; background: #000000; color: #ffffff; font-weight: 800; font-size: 13px; border: none; cursor: pointer; text-transform: capitalize; letter-spacing: 0.2px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">Subscribe</button>
                    </form>

                    <!-- Form 3: WhatsApp Account -->
                    <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing to {{ get_setting('com_name') ?: 'Mini Mama' }} WhatsApp Updates!'); this.reset();" style="display: flex; height: 38px; width: 100%;">
                        <div style="display: flex; align-items: center; gap: 6px; padding: 0 12px; background: #ffffff; border: 1px solid #e0e0e0; border-right: none; font-size: 12px; font-weight: 600; color: #222222; cursor: pointer;">
                            <span>BD +880</span>
                            <i class="fa-solid fa-caret-down" style="font-size: 10px; color: #666666;"></i>
                        </div>
                        <input type="tel" placeholder="WhatsApp Account" required style="flex: 1; height: 100%; border: 1px solid #e0e0e0; border-right: none; border-left: none; padding: 0 14px; font-size: 13px; font-family: inherit; color: #222222; outline: none; background: #ffffff;">
                        <button type="submit" style="width: 125px; height: 100%; background: #000000; color: #ffffff; font-weight: 800; font-size: 13px; border: none; cursor: pointer; text-transform: capitalize; letter-spacing: 0.2px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">Subscribe</button>
                    </form>
                </div>

                <!-- WE ACCEPT (PAYMENT BADGES) -->
                <div>
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">WE ACCEPT</h4>
                    
                    <!-- Row of Payment Badges -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 7px; margin-bottom: 12px;">
                        
                        <!-- 1. CASH ON DELIVERY -->
                        <div title="Cash On Delivery" style="height: 24px; padding: 0 6px; background: #10B981; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 800;">
                            <i class="fa-solid fa-money-bill-wave" style="font-size: 11px;"></i>
                            <span>COD CASH</span>
                        </div>

                        <!-- 2. VISA -->
                        <div title="Visa" style="height: 24px; width: 38px; background: #0D2B82; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900; font-style: italic; letter-spacing: 0.5px;">
                            VISA
                        </div>

                        <!-- 3. MASTERCARD -->
                        <div title="Mastercard" style="height: 24px; width: 36px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center;">
                            <svg width="24" height="15" viewBox="0 0 24 15">
                                <circle cx="8" cy="7.5" r="6.5" fill="#EB001B"/>
                                <circle cx="16" cy="7.5" r="6.5" fill="#F79E1B"/>
                                <path d="M12 2.6a6.5 6.5 0 0 1 0 9.8 6.5 6.5 0 0 1 0-9.8z" fill="#FF5F00"/>
                            </svg>
                        </div>

                        <!-- 4. MAESTRO -->
                        <div title="Maestro" style="height: 24px; width: 36px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center;">
                            <svg width="24" height="15" viewBox="0 0 24 15">
                                <circle cx="8" cy="7.5" r="6.5" fill="#00A2E5"/>
                                <circle cx="16" cy="7.5" r="6.5" fill="#EB001B"/>
                            </svg>
                        </div>

                        <!-- 5. AMERICAN EXPRESS -->
                        <div title="American Express" style="height: 24px; width: 44px; background: #0070CE; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 800; letter-spacing: -0.3px; line-height: 1; text-align: center;">
                            AMERICAN<br>EXPRESS
                        </div>

                        <!-- 6. BKASH / MOBILE BANKING -->
                        <div title="bKash Mobile Banking" style="height: 24px; padding: 0 7px; background: #E2136E; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; font-size: 10px; font-weight: 900;">
                            bKash
                        </div>

                        <!-- 7. NAGAD -->
                        <div title="Nagad" style="height: 24px; padding: 0 7px; background: #F7941D; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; font-size: 10px; font-weight: 900;">
                            Nagad
                        </div>

                        <!-- 8. PAYPAL -->
                        <div title="PayPal" style="height: 24px; width: 40px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; color: #003087; font-size: 13px; font-weight: 800;">
                            <i class="fa-brands fa-paypal"></i>
                        </div>

                        <!-- 9. Apple Pay -->
                        <div title="Apple Pay" style="height: 24px; padding: 0 6px; background: #ffffff; border: 1px solid #e0e0e0; color: #000000; border-radius: 2px; display: inline-flex; align-items: center; gap: 2px; font-size: 10px; font-weight: 700;">
                            <i class="fa-brands fa-apple-pay" style="font-size: 18px;"></i>
                        </div>

                        <!-- 10. Google Pay -->
                        <div title="Google Pay" style="height: 24px; padding: 0 6px; background: #ffffff; border: 1px solid #e0e0e0; color: #333333; border-radius: 2px; display: inline-flex; align-items: center; gap: 2px; font-size: 10px; font-weight: 700;">
                            <i class="fa-brands fa-google-pay" style="font-size: 17px;"></i>
                        </div>

                    </div>

                    <!-- TRUST & SECURITY BADGES (TRUSTe & DMCA) -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <!-- TRUSTe Badge -->
                        <div style="height: 18px; padding: 0 6px; border: 1px solid #00509d; border-radius: 2px; background: #00509d; color: #ffffff; font-size: 9px; font-weight: 800; display: inline-flex; align-items: center; gap: 3px;">
                            <i class="fa-solid fa-check" style="font-size: 9px;"></i>
                            <span>TRUSTe</span>
                        </div>

                        <!-- DMCA Protected Badge -->
                        <div style="height: 18px; padding: 0 6px; border: 1px solid #333333; border-radius: 2px; background: #111111; color: #ffffff; font-size: 9px; font-weight: 800; display: inline-flex; align-items: center; gap: 3px;">
                            <i class="fa-solid fa-shield-halved" style="font-size: 9px; color: #FA2C19;"></i>
                            <span>DMCA</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- CONTACT DETAILS STRIP (HOTLINE, WHATSAPP, EMAIL, ADDRESS) -->
        <div style="margin-top: 40px; padding: 20px 24px; background: #fafafa; border: 1px solid #eeeeee; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 18px; font-size: 12px; color: #444;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-phone" style="color: #000; font-size: 14px;"></i>
                <span>Hotline: <a href="tel:01901166580" style="font-weight: 800; color: #111; text-decoration: none;">01901166580</a></span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-brands fa-whatsapp" style="color: #25D366; font-size: 16px;"></i>
                <span>WhatsApp: <a href="https://wa.me/8801901166580" target="_blank" style="font-weight: 800; color: #25D366; text-decoration: none;">+880 1901-166580</a></span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-regular fa-envelope" style="color: #000; font-size: 14px;"></i>
                <span>Email: <a href="mailto:fastit.com.bd@gmail.com" style="font-weight: 700; color: #111; text-decoration: none;">fastit.com.bd@gmail.com</a></span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-location-dot" style="color: #FA2C19; font-size: 14px;"></i>
                <span>Store: <strong>Shah Ali Plaza, Mirpur-1216, Dhaka</strong></span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-regular fa-clock" style="color: #666; font-size: 14px;"></i>
                <span>Hours: <strong>9:00 AM - 10:00 PM (Daily)</strong></span>
            </div>
        </div>

        <!-- BOTTOM LEGAL & COPYRIGHT ROW -->
        <div style="margin-top: 30px; font-size: 11px; color: #666666; line-height: 1.8; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; border-top: 1px solid #f2f2f2; padding-top: 20px;">
            <div>
                ©2009-{{ date('Y') }} {{ get_setting('com_name') ?: 'Mini Mama' }}. All Rights Reserved.
            </div>
            <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 8px;">
                <a href="{{ route('frontend.privacy') }}" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Privacy Policy</a>
                <span style="color: #cccccc;">|</span>
                <a href="{{ route('frontend.returns') }}" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Return & Refund Policy</a>
                <span style="color: #cccccc;">|</span>
                <a href="{{ route('frontend.terms') }}" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Terms & Conditions</a>
                <span style="color: #cccccc;">|</span>
                <a href="{{ route('frontend.payment_policy') }}" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Payment Policy</a>
                <span style="color: #cccccc;">|</span>
                <a href="{{ route('frontend.about') }}" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">About Us</a>
                <span style="color: #cccccc;">|</span>
                <a href="{{ route('frontend.contact') }}" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Contact Support</a>
            </div>
        </div>

    </div>

    <!-- FLOATING RIGHT-SIDE ACTION BUTTONS (FEEDBACK & SCROLL TO TOP) - Positioned neatly above the chat widget -->
    <div style="position: fixed; right: 24px; bottom: 100px; display: flex; flex-direction: column; gap: 8px; z-index: 999;">
        <!-- Survey / Feedback Button -->
        <button type="button" onclick="showToast('Customer Feedback Survey: We value your experience!')" title="Feedback" style="width: 38px; height: 38px; background: #ffffff; border: 1px solid #e0e0e0; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333333; font-size: 15px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fa-regular fa-comment-dots"></i>
        </button>

        <!-- Back to Top Button -->
        <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="Back to top" style="width: 38px; height: 38px; background: #ffffff; border: 1px solid #e0e0e0; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333333; font-size: 15px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
    </div>
</footer>
