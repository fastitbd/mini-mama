@extends('frontend.layouts.master')
@section('title', 'Contact Us | ' . (get_setting('com_name') ?: 'Mini Mama'))
@section('content')
<div class="shein-wrap" style="padding: 40px 16px; max-width: 900px;">
    <h1 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 8px;">📞 Contact Us</h1>
    <p style="color: #767676; font-size: 14px; margin-bottom: 30px;">We'd love to hear from you! Reach out to us anytime.</p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Contact Info -->
        <div>
            <div style="margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 44px; height: 44px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 800;">Address</div>
                        <div style="font-size: 12px; color: #666;">{{ get_setting('com_address') ?: 'Dhaka, Bangladesh' }}</div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 44px; height: 44px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 800;">Phone</div>
                        <div style="font-size: 12px; color: #666;">{{ get_setting('com_phone') ?: '+880 1XXXXXXXXX' }}</div>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 44px; height: 44px; background: #000; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight: 800;">Email</div>
                        <div style="font-size: 12px; color: #666;">{{ get_setting('com_email') ?: 'info@minimama.com.bd' }}</div>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <a href="#" style="width: 36px; height: 36px; background: #1877F2; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px;"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" style="width: 36px; height: 36px; background: #E4405F; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px;"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" style="width: 36px; height: 36px; background: #25D366; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px;"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>

        <!-- Contact Form -->
        <div style="background: #f7f7f7; padding: 24px; border-radius: 8px;">
            <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px;">Send us a message</h3>
            <form onsubmit="event.preventDefault(); showToast('✅ Message sent! We\'ll get back to you soon.'); this.reset();">
                <div style="margin-bottom: 12px;">
                    <input type="text" placeholder="Your Name" required style="width: 100%; height: 40px; border: 1px solid #ddd; padding: 0 12px; font-size: 13px; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 12px;">
                    <input type="email" placeholder="Your Email" required style="width: 100%; height: 40px; border: 1px solid #ddd; padding: 0 12px; font-size: 13px; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 12px;">
                    <input type="text" placeholder="Subject" style="width: 100%; height: 40px; border: 1px solid #ddd; padding: 0 12px; font-size: 13px; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 16px;">
                    <textarea placeholder="Your Message" rows="5" required style="width: 100%; border: 1px solid #ddd; padding: 12px; font-size: 13px; border-radius: 4px; resize: vertical; font-family: inherit; box-sizing: border-box;"></textarea>
                </div>
                <button type="submit" style="width: 100%; background: #000; color: #fff; height: 44px; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; border: none; border-radius: 4px; cursor: pointer;">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> Send Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
