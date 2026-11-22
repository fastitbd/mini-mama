@extends('frontend.layouts.master')

@section('title', 'Sign In or Register | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')
<div style="background: #F7F7F7; min-height: 80vh; padding: 40px 16px 80px;">
    <!-- Top Welcome Gift Banner -->
    <div class="shein-container" style="max-width: 520px; margin-bottom: 20px;">
        <div style="background: #FFF0ED; border: 1px dashed #FA2C19; padding: 14px 20px; border-radius: 4px; display: flex; align-items: center; gap: 14px;">
            <div style="font-size: 28px;">🎁</div>
            <div>
                <div style="font-size: 13px; font-weight: 800; color: #FA2C19; text-transform: uppercase;">NEW USER WELCOME GIFT</div>
                <div style="font-size: 11px; color: #555;">Get <strong>RM 15.00 OFF</strong> voucher + <strong>FREE SHIPPING</strong> on your first order!</div>
            </div>
        </div>
    </div>

    <!-- Centered Auth Card -->
    <div class="auth-card-box" style="max-width: 520px; margin: 0 auto; background: #ffffff; border: 1px solid #eeeeee; border-radius: 4px; padding: 36px 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
        <!-- Alert Messages -->
        @if(session('success'))
            <div style="background: #E8F5E9; border: 1px solid #C8E6C9; color: #2E7D32; padding: 12px 16px; border-radius: 4px; font-size: 13px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #FFEBEE; border: 1px solid #FFCDD2; color: #C62828; padding: 12px 16px; border-radius: 4px; font-size: 13px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Tabs Header -->
        <div style="display: flex; border-bottom: 2px solid #f2f2f2; margin-bottom: 28px;">
            <button type="button" id="tabBtnSignIn" onclick="switchAuthTab('signin')" style="flex: 1; padding: 12px 0; font-size: 15px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #000; margin-bottom: -2px; color: #000;">
                SIGN IN
            </button>
            <button type="button" id="tabBtnRegister" onclick="switchAuthTab('register')" style="flex: 1; padding: 12px 0; font-size: 15px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid transparent; margin-bottom: -2px; color: #999;">
                REGISTER
            </button>
        </div>

        <!-- SIGN IN FORM -->
        <form id="signInForm" action="{{ route('frontend.customer_login') }}" method="POST">
            @csrf
            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; color: #333;">
                    Email Address or Mobile Number
                </label>
                <input type="text" name="email" id="loginEmail" required placeholder="name@example.com / 017XXXXXXXX" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; box-sizing: border-box; outline: none; border-radius: 2px;">
            </div>

            <div style="margin-bottom: 14px; position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #333;">
                        Password
                    </label>
                    <a href="javascript:void(0)" onclick="showToast('Password reset instructions will be sent to your email.');" style="font-size: 11px; color: #666; text-decoration: underline;">
                        Forgot Password?
                    </a>
                </div>
                <input type="password" name="password" id="loginPassword" required placeholder="Enter your password" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; box-sizing: border-box; outline: none; border-radius: 2px;">
            </div>

            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 22px; font-size: 12px; color: #555;">
                <input type="checkbox" id="rememberMe" checked style="width: 16px; height: 16px;">
                <label for="rememberMe" style="cursor: pointer;">Remember me on this browser</label>
            </div>

            <button type="submit" class="shein-btn-primary" style="width: 100%; height: 46px; font-size: 13px; letter-spacing: 1px;">
                SIGN IN
            </button>
        </form>

        <!-- REGISTER FORM -->
        <form id="registerForm" action="{{ route('frontend.customer_register') }}" method="POST" style="display: none;">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; color: #333;">
                    Full Name
                </label>
                <input type="text" name="name" required placeholder="e.g. Jannatul Ferdous" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; box-sizing: border-box; outline: none; border-radius: 2px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; color: #333;">
                    Email Address
                </label>
                <input type="email" name="email" id="regEmail" required placeholder="name@example.com" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; box-sizing: border-box; outline: none; border-radius: 2px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; color: #333;">
                    Mobile Phone Number
                </label>
                <input type="tel" name="phone" placeholder="017XXXXXXXX" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; box-sizing: border-box; outline: none; border-radius: 2px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px; color: #333;">
                    Create Password
                </label>
                <input type="password" name="password" id="regPassword" required placeholder="At least 6 characters" style="width: 100%; height: 44px; border: 1px solid #ccc; padding: 0 14px; font-size: 13px; box-sizing: border-box; outline: none; border-radius: 2px;">
            </div>

            <div style="margin-bottom: 18px; font-size: 11px; color: #666; line-height: 1.5;">
                By clicking "REGISTER", you agree to {{ get_setting('com_name') ?: 'Mini Mama' }}'s <a href="#" style="text-decoration: underline;">Terms & Conditions</a> and acknowledge our <a href="#" style="text-decoration: underline;">Privacy Policy</a>.
            </div>

            <button type="submit" class="shein-btn-primary" style="width: 100%; height: 46px; font-size: 13px; letter-spacing: 1px; background: #FA2C19;">
                REGISTER & CLAIM BONUS POINTS
            </button>
        </form>

        <!-- Guest Checkout & Track Notice -->
        <div style="background: #F0F9FF; border: 1px solid #BAE6FD; padding: 14px; border-radius: 4px; margin-top: 24px; text-align: center;">
            <div style="font-size: 12px; font-weight: 800; color: #0284C7; margin-bottom: 4px;">
                <i class="fa-solid fa-truck-fast"></i> Placed an order as a Guest?
            </div>
            <p style="font-size: 11px; color: #555; margin: 0 0 8px;">You don't need to log in to check your order status or download invoices.</p>
            <a href="{{ route('frontend.track_order') }}" style="display: inline-block; background: #0284C7; color: #fff; font-size: 11px; font-weight: 800; padding: 6px 14px; border-radius: 3px; text-decoration: none;">
                Track Guest Order Now
            </a>
        </div>

        <!-- Social Separator -->
        <div style="display: flex; align-items: center; margin: 26px 0 20px;">
            <div style="flex: 1; height: 1px; background: #eee;"></div>
            <span style="padding: 0 14px; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase;">Or Quick Sign In With</span>
            <div style="flex: 1; height: 1px; background: #eee;"></div>
        </div>

        <!-- Social Buttons -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px;">
            <button type="button" onclick="showToast('Connecting to Google SSO...')" style="height: 40px; border: 1px solid #ddd; border-radius: 2px; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 12px; font-weight: 700; background: #fff; cursor: pointer;">
                <i class="fa-brands fa-google" style="color: #EA4335; font-size: 16px;"></i> Google
            </button>
            <button type="button" onclick="showToast('Connecting to Facebook SSO...')" style="height: 40px; border: 1px solid #ddd; border-radius: 2px; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 12px; font-weight: 700; background: #fff; cursor: pointer;">
                <i class="fa-brands fa-facebook-f" style="color: #1877F2; font-size: 16px;"></i> Facebook
            </button>
            <button type="button" onclick="showToast('Connecting to Apple SSO...')" style="height: 40px; border: 1px solid #ddd; border-radius: 2px; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 12px; font-weight: 700; background: #fff; cursor: pointer;">
                <i class="fa-brands fa-apple" style="font-size: 18px;"></i> Apple
            </button>
        </div>

        <!-- Staff ERP / POS Login Link -->
        <div style="background: #F8F9FA; border: 1px solid #E9ECEF; padding: 14px; border-radius: 4px; text-align: center;">
            <div style="font-size: 11px; font-weight: 800; color: #495057; text-transform: uppercase; margin-bottom: 4px;">Internal Team & Staff Access</div>
            <a href="{{ url('/login') }}" style="font-size: 12px; font-weight: 700; color: #000; text-decoration: underline; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-lock"></i> Go to Admin / POS Management Portal <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchAuthTab(tab) {
        const btnIn = document.getElementById('tabBtnSignIn');
        const btnReg = document.getElementById('tabBtnRegister');
        const formIn = document.getElementById('signInForm');
        const formReg = document.getElementById('registerForm');

        if (tab === 'signin') {
            btnIn.style.borderBottom = '2px solid #000';
            btnIn.style.color = '#000';
            btnReg.style.borderBottom = '2px solid transparent';
            btnReg.style.color = '#999';
            formIn.style.display = 'block';
            formReg.style.display = 'none';
        } else {
            btnReg.style.borderBottom = '2px solid #000';
            btnReg.style.color = '#000';
            btnIn.style.borderBottom = '2px solid transparent';
            btnIn.style.color = '#999';
            formReg.style.display = 'block';
            formIn.style.display = 'none';
        }
    }

    function handleCustomerAuth(type) {
        if (type === 'signin') {
            showToast('🎉 Welcome back! Signed in successfully.');
        } else {
            showToast('🎉 Account registered! RM15 coupon added to your wallet.');
        }
        setTimeout(() => {
            window.location.href = "{{ route('frontend.home') }}";
        }, 1200);
    }
</script>
@endpush

@push('styles')
<style>
    @media (max-width: 520px) {
        .auth-card-box {
            padding: 24px 16px !important;
        }
    }
</style>
@endpush
