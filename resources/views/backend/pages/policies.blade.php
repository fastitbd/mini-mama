@extends('backend.layouts.master')

@section('title', 'Website Policy Pages Management')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-500 mb-1">
                <i class="feather icon-file-text"></i> Website Legal & Information Pages
            </div>
            <h1 class="text-2xl font-black text-slate-800">Policy Pages Editor</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Edit and update your customer-facing legal policies. Content supports standard HTML tags (paragraphs, bold, bullet points, headers).
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('frontend.privacy') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 transition">
                <i class="feather icon-external-link"></i> Live Preview
            </a>
            <button type="submit" form="policiesForm" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-slate-900 rounded-lg shadow hover:bg-orange-600 transition">
                <i class="feather icon-save"></i> Save All Policies
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-emerald-800 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <i class="feather icon-check-circle text-lg text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- Policy Tabs & Form -->
    <form id="policiesForm" method="POST" action="{{ route('setting.policies.update') }}">
        @csrf

        <!-- Policy Navigation Pills -->
        <div class="flex gap-2 border-b border-slate-200 pb-2 mb-6 overflow-x-auto">
            <button type="button" onclick="switchPolicyTab('privacy', this)" class="policy-tab-btn active px-4 py-2.5 rounded-lg text-xs font-bold tracking-wide uppercase transition flex items-center gap-2 bg-slate-900 text-white">
                <i class="feather icon-shield"></i> Privacy Policy
            </button>
            <button type="button" onclick="switchPolicyTab('returns', this)" class="policy-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold tracking-wide uppercase transition flex items-center gap-2 bg-slate-100 text-slate-600 hover:bg-slate-200">
                <i class="feather icon-rotate-ccw"></i> Return & Refund
            </button>
            <button type="button" onclick="switchPolicyTab('shipping', this)" class="policy-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold tracking-wide uppercase transition flex items-center gap-2 bg-slate-100 text-slate-600 hover:bg-slate-200">
                <i class="feather icon-truck"></i> Shipping & Delivery
            </button>
            <button type="button" onclick="switchPolicyTab('terms', this)" class="policy-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold tracking-wide uppercase transition flex items-center gap-2 bg-slate-100 text-slate-600 hover:bg-slate-200">
                <i class="feather icon-file-text"></i> Terms & Conditions
            </button>
            <button type="button" onclick="switchPolicyTab('payment', this)" class="policy-tab-btn px-4 py-2.5 rounded-lg text-xs font-bold tracking-wide uppercase transition flex items-center gap-2 bg-slate-100 text-slate-600 hover:bg-slate-200">
                <i class="feather icon-credit-card"></i> Payment Policy
            </button>
        </div>

        <!-- 1. PRIVACY POLICY PANEL -->
        <div id="policy-privacy" class="policy-panel block bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Privacy & Cookie Policy</h3>
                    <p class="text-xs text-slate-500">Public URL: <a href="{{ route('frontend.privacy') }}" target="_blank" class="text-blue-600 underline">{{ route('frontend.privacy') }}</a></p>
                </div>
                <button type="button" onclick="loadDefaultTemplate('privacy')" class="text-xs text-orange-600 font-bold hover:underline">
                    Load Recommended Template
                </button>
            </div>
            <textarea name="policy_privacy" id="textarea_privacy" rows="18" class="w-full p-4 text-xs font-mono border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 text-slate-800 leading-relaxed">{{ get_setting('policy_privacy') }}</textarea>
        </div>

        <!-- 2. RETURN & REFUND POLICY PANEL -->
        <div id="policy-returns" class="policy-panel hidden bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Return, Exchange & Refund Policy</h3>
                    <p class="text-xs text-slate-500">Public URL: <a href="{{ route('frontend.returns') }}" target="_blank" class="text-blue-600 underline">{{ route('frontend.returns') }}</a></p>
                </div>
                <button type="button" onclick="loadDefaultTemplate('returns')" class="text-xs text-orange-600 font-bold hover:underline">
                    Load Recommended Template
                </button>
            </div>
            <textarea name="policy_returns" id="textarea_returns" rows="18" class="w-full p-4 text-xs font-mono border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 text-slate-800 leading-relaxed">{{ get_setting('policy_returns') }}</textarea>
        </div>

        <!-- 3. SHIPPING & DELIVERY POLICY PANEL -->
        <div id="policy-shipping" class="policy-panel hidden bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Shipping & Delivery Policy</h3>
                    <p class="text-xs text-slate-500">Public URL: <a href="{{ route('frontend.shipping') }}" target="_blank" class="text-blue-600 underline">{{ route('frontend.shipping') }}</a></p>
                </div>
                <button type="button" onclick="loadDefaultTemplate('shipping')" class="text-xs text-orange-600 font-bold hover:underline">
                    Load Recommended Template
                </button>
            </div>
            <textarea name="policy_shipping" id="textarea_shipping" rows="18" class="w-full p-4 text-xs font-mono border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 text-slate-800 leading-relaxed">{{ get_setting('policy_shipping') }}</textarea>
        </div>

        <!-- 4. TERMS & CONDITIONS PANEL -->
        <div id="policy-terms" class="policy-panel hidden bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Terms & Conditions of Service</h3>
                    <p class="text-xs text-slate-500">Public URL: <a href="{{ route('frontend.terms') }}" target="_blank" class="text-blue-600 underline">{{ route('frontend.terms') }}</a></p>
                </div>
                <button type="button" onclick="loadDefaultTemplate('terms')" class="text-xs text-orange-600 font-bold hover:underline">
                    Load Recommended Template
                </button>
            </div>
            <textarea name="policy_terms" id="textarea_terms" rows="18" class="w-full p-4 text-xs font-mono border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 text-slate-800 leading-relaxed">{{ get_setting('policy_terms') }}</textarea>
        </div>

        <!-- 5. PAYMENT POLICY PANEL -->
        <div id="policy-payment" class="policy-panel hidden bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Payment & Billing Policy</h3>
                    <p class="text-xs text-slate-500">Public URL: <a href="{{ route('frontend.payment_policy') }}" target="_blank" class="text-blue-600 underline">{{ route('frontend.payment_policy') }}</a></p>
                </div>
                <button type="button" onclick="loadDefaultTemplate('payment')" class="text-xs text-orange-600 font-bold hover:underline">
                    Load Recommended Template
                </button>
            </div>
            <textarea name="policy_payment" id="textarea_payment" rows="18" class="w-full p-4 text-xs font-mono border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none bg-slate-50 text-slate-800 leading-relaxed">{{ get_setting('policy_payment') }}</textarea>
        </div>

        <!-- Submit Button Bottom -->
        <div class="mt-6 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 text-xs font-bold text-white bg-slate-900 rounded-lg shadow-md hover:bg-orange-600 transition">
                <i class="feather icon-save text-sm"></i> Save All Policy Pages
            </button>
        </div>
    </form>
</div>

<script>
    function switchPolicyTab(tabId, btn) {
        document.querySelectorAll('.policy-panel').forEach(p => p.classList.replace('block', 'hidden'));
        document.getElementById('policy-' + tabId).classList.replace('hidden', 'block');

        document.querySelectorAll('.policy-tab-btn').forEach(b => {
            b.classList.remove('bg-slate-900', 'text-white');
            b.classList.add('bg-slate-100', 'text-slate-600');
        });

        btn.classList.remove('bg-slate-100', 'text-slate-600');
        btn.classList.add('bg-slate-900', 'text-white');
    }

    const defaultTemplates = {
        privacy: `<h3>1. Overview & Data Protection</h3>
<p>At <strong>Mini Mama</strong>, accessible from minimama.com.bd, protecting the privacy of our visitors and customers is of highest priority. We use industry-standard 256-bit SSL encryption to protect your sensitive personal details.</p>

<h3>2. Information We Collect</h3>
<ul>
  <li><strong>Contact Details:</strong> Customer full name, email address, mobile phone number.</li>
  <li><strong>Shipping Addresses:</strong> Division, District, Area, and postal address.</li>
  <li><strong>Order History:</strong> Product items ordered, quantities, invoices, and payment statuses.</li>
</ul>

<h3>3. Security & Third Parties</h3>
<p>We do not sell, rent, or trade your personally identifiable information to external third parties. Information is strictly shared only with trusted delivery couriers (such as Steadfast Courier) to fulfill your orders.</p>`,

        returns: `<h3>7-Day Easy Return & Refund Guarantee</h3>
<p>We take pride in our product quality. If your received item has defects, sizing problems, or is not as described, you can request a return or exchange within <strong>7 calendar days</strong> of receiving your parcel.</p>

<h3>Conditions for Return:</h3>
<ul>
  <li>Items must be unused, unwashed, and in original condition with all tags and protective packaging.</li>
  <li>Proof of purchase (Order Number or phone number) must be provided.</li>
</ul>

<h3>How to Request an Exchange or Refund:</h3>
<ol>
  <li>Contact our 24/7 WhatsApp Support at <strong>+880 1901-166580</strong> with your Order Number.</li>
  <li>Our team will arrange courier pickup or provide return shipment instructions.</li>
  <li>Upon receiving the package, your refund will be disbursed to your bKash/Nagad wallet or original payment method within 48 business hours.</li>
</ol>`,

        shipping: `<h3>Nationwide Shipping & Delivery Policy</h3>
<p>We deliver parcels across all 64 districts in Bangladesh with rapid delivery times.</p>

<h3>Delivery Charges & Timeframes:</h3>
<ul>
  <li><strong>Inside Dhaka City:</strong> Delivery charge is <strong>৳ 60</strong> (24 to 48 hours delivery).</li>
  <li><strong>Outside Dhaka (All Divisions & Districts):</strong> Delivery charge is <strong>৳ 120</strong> (2 to 4 business days).</li>
  <li><strong>Free Express Shipping:</strong> Orders qualifying for free shipping threshold enjoy 100% free delivery.</li>
</ul>

<h3>Order Tracking:</h3>
<p>Every parcel receives real-time tracking updates. You can track your shipment live using your Order Number and phone number on our website.</p>`,

        terms: `<h3>1. Terms of Service Acceptance</h3>
<p>By browsing or making a purchase on <strong>Mini Mama</strong>, you agree to be bound by these Terms and Conditions. Please review them carefully.</p>

<h3>2. Orders & Guest Checkout</h3>
<p>Both registered members and guest customers are welcome to place orders without creating a mandatory account. All orders placed are subject to stock availability and confirmation.</p>

<h3>3. Pricing & Billing</h3>
<p>All prices listed on the site are in Bangladeshi Taka (BDT) or Malaysian Ringgit (MYR). There are no hidden fees or undisclosed surcharges.</p>`,

        payment: `<h3>Payment & Billing Policy</h3>
<p>We offer secure and convenient payment options for all our shoppers.</p>

<h3>Accepted Payment Methods:</h3>
<ul>
  <li><strong>Cash on Delivery (COD):</strong> Pay cash at your doorstep when you receive and inspect your parcel. Available nationwide across Bangladesh.</li>
  <li><strong>Mobile Banking:</strong> bKash, Nagad, and Rocket mobile wallet payments.</li>
  <li><strong>Cards:</strong> Visa, Mastercard, American Express, and Maestro debit/credit cards.</li>
</ul>

<h3>Payment Security:</h3>
<p>All online transactions are encrypted via secure SSL payment channels. We never store credit/debit card PINs or full security CVV numbers.</p>`
    };

    function loadDefaultTemplate(type) {
        if (confirm('Load the recommended default template for ' + type + ' policy? Any unsaved edits will be replaced.')) {
            document.getElementById('textarea_' + type).value = defaultTemplates[type];
        }
    }
</script>
@endsection
