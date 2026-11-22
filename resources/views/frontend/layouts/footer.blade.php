<!-- ==========================================
     OFFICIAL FOOTER
     ========================================== -->
<footer class="shein-official-footer" style="background: #ffffff; padding: 48px 0 32px; border-top: 1px solid #eeeeee; font-family: var(--shein-font), -apple-system, sans-serif; position: relative;">
    <div class="shein-wrap" style="max-width: 1440px; margin: 0 auto; padding: 0 24px;">
        
        <!-- MAIN FOOTER TOP ROW (LEFT 3 COLUMNS + RIGHT FORMS & SOCIALS) -->
        <div style="display: flex; justify-content: space-between; gap: 40px; flex-wrap: wrap;">
            
            <!-- LEFT 3 COLUMNS: NAVIGATION LINKS -->
            <div style="display: flex; gap: 75px; flex-wrap: wrap;">
                
                <!-- 1. COMPANY INFO -->
                <div style="min-width: 140px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 16px; letter-spacing: 0.3px;">COMPANY INFO</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #333333; line-height: 2.15;">
                        <li><a href="{{ route('frontend.category', 'all') }}" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">About {{ get_setting('com_name') ?: 'FAST IT' }}</a></li>
                        <li><a href="#" onclick="showToast('{{ get_setting('com_name') ?: 'FAST IT' }} Fashion Blogger Program: Earn rewards by sharing outfits')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Fashion Blogger</a></li>
                        <li><a href="#" onclick="showToast('{{ get_setting('com_name') ?: 'FAST IT' }} Social Responsibility: Committed to green supply chain & sustainability')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Social Responsibility</a></li>
                        <li><a href="#" onclick="showToast('Careers at {{ get_setting('com_name') ?: 'FAST IT' }}: Join our global team')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Careers</a></li>
                    </ul>
                </div>

                <!-- 2. HELP & SUPPORT -->
                <div style="min-width: 140px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 16px; letter-spacing: 0.3px;">HELP & SUPPORT</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #333333; line-height: 2.15;">
                        <li><a href="#" onclick="showToast('Free Express Shipping across Malaysia on orders RM120+')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Shipping Info</a></li>
                        <li><a href="#" onclick="showToast('20-Day Easy Returns policy for Malaysia')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Returns</a></li>
                        <li><a href="#" onclick="showToast('Fast refund directly to your original payment method')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Refund</a></li>
                        <li><a href="#" onclick="showToast('How To Order: Choose style, pick size, and checkout securely')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">How To Order</a></li>
                        <li><a href="#" onclick="showToast('Track your package with real-time tracking updates')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">How To Track</a></li>
                        <li><a href="#" onclick="showToast('Size Guide: Find your perfect fit with our body measurement chart')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Size Guide</a></li>
                        <li><a href="#" onclick="showToast('{{ get_setting('com_name') ?: 'FAST IT' }} VIP: Earn tiered points and exclusive VIP discounts')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">{{ get_setting('com_name') ?: 'FAST IT' }} VIP</a></li>
                    </ul>
                </div>

                <!-- 3. CUSTOMER CARE -->
                <div style="min-width: 140px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 16px; letter-spacing: 0.3px;">CUSTOMER CARE</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px; color: #333333; line-height: 2.15;">
                        <li><a href="#" onclick="showToast('Contact Us: 24/7 Virtual Assistant & Customer Support')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Contact us</a></li>
                        <li><a href="#" onclick="showToast('Payment Methods: Credit Cards, Online Banking (FPX), GrabPay, Touch n Go, Cash on Delivery')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Payment Method</a></li>
                        <li><a href="#" onclick="showToast('Bonus Points: 100 Points = RM 4.50 off your order')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">Bonus Point</a></li>
                        <li><a href="#" onclick="showToast('FAQ: Frequently Asked Questions & Delivery info')" style="color: #333333; text-decoration: none;" onmouseover="this.style.color='#FA2C19'" onmouseout="this.style.color='#333333'">FAQ</a></li>
                    </ul>
                </div>

            </div>

            <!-- RIGHT SECTION: SOCIALS, APP, NEWSLETTER, PAYMENTS -->
            <div style="flex: 1; min-width: 320px; max-width: 580px;">
                
                <!-- TOP ROW: FIND US ON & APP -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 22px; flex-wrap: wrap; gap: 20px;">
                    <!-- FIND US ON -->
                    <div>
                        <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">FIND US ON</h4>
                        <div style="display: flex; align-items: center; gap: 16px; font-size: 18px; color: #000000;">
                            <a href="https://facebook.com" target="_blank" title="Facebook" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://instagram.com" target="_blank" title="Instagram" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://x.com" target="_blank" title="Twitter / X" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="https://youtube.com" target="_blank" title="YouTube" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-youtube"></i></a>
                            <a href="https://pinterest.com" target="_blank" title="Pinterest" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-pinterest-p"></i></a>
                            <a href="https://snapchat.com" target="_blank" title="Snapchat" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-snapchat"></i></a>
                            <a href="https://tiktok.com" target="_blank" title="TikTok" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-tiktok"></i></a>
                            <a href="https://linkedin.com" target="_blank" title="LinkedIn" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- APP -->
                    <div>
                        <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">APP</h4>
                        <div style="display: flex; align-items: center; gap: 14px; font-size: 20px; color: #000000;">
                            <a href="#" onclick="showToast('{{ get_setting('com_name') ?: 'FAST IT' }} App on iOS App Store')" title="Download iOS App" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-apple"></i></a>
                            <a href="#" onclick="showToast('{{ get_setting('com_name') ?: 'FAST IT' }} App on Google Play Store')" title="Download Android App" style="color: #000000; text-decoration: none;"><i class="fa-brands fa-android"></i></a>
                        </div>
                    </div>
                </div>

                <!-- SIGN UP FOR STYLE NEWS -->
                <div style="margin-bottom: 24px;">
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">SIGN UP FOR {{ strtoupper(get_setting('com_name') ?: 'FAST IT') }} STYLE NEWS</h4>
                    
                    <!-- Form 1: Email Address -->
                    <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing to {{ get_setting('com_name') ?: 'FAST IT' }} Style News!'); this.reset();" style="display: flex; height: 38px; margin-bottom: 10px; width: 100%;">
                        <input type="email" placeholder="Your Email Address" required style="flex: 1; height: 100%; border: 1px solid #e0e0e0; border-right: none; padding: 0 14px; font-size: 13px; font-family: inherit; color: #222222; outline: none; background: #ffffff;">
                        <button type="submit" style="width: 125px; height: 100%; background: #000000; color: #ffffff; font-weight: 800; font-size: 13px; border: none; cursor: pointer; text-transform: capitalize; letter-spacing: 0.2px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">Subscribe</button>
                    </form>

                    <!-- Form 2: Phone number for SMS -->
                    <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing to {{ get_setting('com_name') ?: 'FAST IT' }} SMS Alerts!'); this.reset();" style="display: flex; height: 38px; margin-bottom: 10px; width: 100%;">
                        <div style="display: flex; align-items: center; gap: 6px; padding: 0 12px; background: #ffffff; border: 1px solid #e0e0e0; border-right: none; font-size: 12px; font-weight: 600; color: #222222; cursor: pointer;">
                            <span>MY + 60</span>
                            <i class="fa-solid fa-caret-down" style="font-size: 10px; color: #666666;"></i>
                        </div>
                        <input type="tel" placeholder="Your phone number for SMS" required style="flex: 1; height: 100%; border: 1px solid #e0e0e0; border-right: none; border-left: none; padding: 0 14px; font-size: 13px; font-family: inherit; color: #222222; outline: none; background: #ffffff;">
                        <button type="submit" style="width: 125px; height: 100%; background: #000000; color: #ffffff; font-weight: 800; font-size: 13px; border: none; cursor: pointer; text-transform: capitalize; letter-spacing: 0.2px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">Subscribe</button>
                    </form>

                    <!-- Form 3: WhatsApp Account -->
                    <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing to {{ get_setting('com_name') ?: 'FAST IT' }} WhatsApp Updates!'); this.reset();" style="display: flex; height: 38px; width: 100%;">
                        <div style="display: flex; align-items: center; gap: 6px; padding: 0 12px; background: #ffffff; border: 1px solid #e0e0e0; border-right: none; font-size: 12px; font-weight: 600; color: #222222; cursor: pointer;">
                            <span>MY + 60</span>
                            <i class="fa-solid fa-caret-down" style="font-size: 10px; color: #666666;"></i>
                        </div>
                        <input type="tel" placeholder="WhatsApp Account" required style="flex: 1; height: 100%; border: 1px solid #e0e0e0; border-right: none; border-left: none; padding: 0 14px; font-size: 13px; font-family: inherit; color: #222222; outline: none; background: #ffffff;">
                        <button type="submit" style="width: 125px; height: 100%; background: #000000; color: #ffffff; font-weight: 800; font-size: 13px; border: none; cursor: pointer; text-transform: capitalize; letter-spacing: 0.2px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">Subscribe</button>
                    </form>
                </div>

                <!-- WE ACCEPT (PAYMENT BADGES) -->
                <div>
                    <h4 style="font-size: 13px; font-weight: 800; color: #000000; text-transform: uppercase; margin: 0 0 12px; letter-spacing: 0.3px;">WE ACCEPT</h4>
                    
                    <!-- Row of 15 Official Payment Badges -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 7px; margin-bottom: 12px;">
                        
                        <!-- 1. CASH ON DELIVERY -->
                        <div title="Cash On Delivery" style="height: 24px; padding: 0 6px; background: #4DB6AC; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 800; letter-spacing: -0.2px;">
                            <i class="fa-solid fa-money-bill-wave" style="font-size: 11px;"></i>
                            <span>CASH</span>
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

                        <!-- 6. DINERS CLUB -->
                        <div title="Diners Club" style="height: 24px; width: 42px; background: #004A97; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 800; letter-spacing: -0.2px;">
                            Diners Club
                        </div>

                        <!-- 7. DISCOVER -->
                        <div title="Discover" style="height: 24px; width: 44px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800; color: #FF6600;">
                            DISCOVER
                        </div>

                        <!-- 8. UNIONPAY -->
                        <div title="UnionPay" style="height: 24px; width: 38px; background: #D91D2A; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 800;">
                            UnionPay
                        </div>

                        <!-- 9. PAYPAL -->
                        <div title="PayPal" style="height: 24px; width: 40px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; color: #003087; font-size: 13px; font-weight: 800;">
                            <i class="fa-brands fa-paypal"></i>
                        </div>

                        <!-- 10. GrabPay -->
                        <div title="GrabPay Malaysia" style="height: 24px; padding: 0 6px; background: #ffffff; border: 1px solid #e0e0e0; color: #00B14F; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800;">
                            GrabPay
                        </div>

                        <!-- 11. FPX (Online Banking Malaysia) -->
                        <div title="FPX Online Banking" style="height: 24px; padding: 0 6px; background: #ffffff; border: 1px solid #e0e0e0; color: #002244; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 900; letter-spacing: 0.5px;">
                            FPX
                        </div>

                        <!-- 12. atome -->
                        <div title="Atome Buy Now Pay Later" style="height: 24px; padding: 0 6px; background: #F8E71C; color: #000000; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800;">
                            atome
                        </div>

                        <!-- 13. Touch 'n Go eWallet -->
                        <div title="Touch 'n Go eWallet" style="height: 24px; padding: 0 6px; background: #005BAA; color: #ffffff; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800;">
                            Touch 'n Go
                        </div>

                        <!-- 14. Google Pay -->
                        <div title="Google Pay" style="height: 24px; padding: 0 6px; background: #ffffff; border: 1px solid #e0e0e0; color: #333333; border-radius: 2px; display: inline-flex; align-items: center; gap: 2px; font-size: 10px; font-weight: 700;">
                            <i class="fa-brands fa-google-pay" style="font-size: 17px;"></i>
                        </div>

                        <!-- 15. Apple Pay -->
                        <div title="Apple Pay" style="height: 24px; padding: 0 6px; background: #ffffff; border: 1px solid #e0e0e0; color: #000000; border-radius: 2px; display: inline-flex; align-items: center; gap: 2px; font-size: 10px; font-weight: 700;">
                            <i class="fa-brands fa-apple-pay" style="font-size: 18px;"></i>
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

        <!-- BOTTOM LEGAL & COPYRIGHT ROW -->
        <div style="margin-top: 45px; font-size: 11px; color: #666666; line-height: 1.8;">
            <div>©2009-{{ date('Y') }} {{ get_setting('com_name') ?: 'FAST IT' }} All Rights Reserved</div>
            <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 6px; margin-top: 4px;">
                <a href="#" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Privacy Center</a>
                <span style="color: #cccccc;">|</span>
                <a href="#" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Privacy & Cookie Policy</a>
                <span style="color: #cccccc;">|</span>
                <a href="#" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Terms & Conditions</a>
                <span style="color: #cccccc;">|</span>
                <a href="#" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Marketplace IP Rules</a>
                <span style="color: #cccccc;">|</span>
                <a href="#" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">IP Notice</a>
                <span style="color: #cccccc;">|</span>
                <a href="#" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Imprint</a>
                <span style="color: #cccccc;">|</span>
                <a href="#" style="color: #666666; text-decoration: underline;" onmouseover="this.style.color='#000'" onmouseout="this.style.color='#666'">Ad Choice</a>
                <i class="fa-solid fa-location-dot" style="margin-left: 4px; color: #000000; font-size: 12px;" title="Malaysia"></i>
            </div>
        </div>

    </div>

    <!-- FLOATING RIGHT-SIDE ACTION BUTTONS (FEEDBACK & SCROLL TO TOP) -->
    <div style="position: fixed; right: 20px; bottom: 30px; display: flex; flex-direction: column; gap: 8px; z-index: 999;">
        <!-- Survey / Feedback Button -->
        <button type="button" onclick="showToast('Customer Feedback Survey: We value your experience!')" title="Feedback" style="width: 40px; height: 40px; background: #ffffff; border: 1px solid #e0e0e0; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333333; font-size: 16px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fa-regular fa-comment-dots"></i>
        </button>

        <!-- Back to Top Button -->
        <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="Back to top" style="width: 40px; height: 40px; background: #ffffff; border: 1px solid #e0e0e0; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333333; font-size: 16px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
    </div>
</footer>
