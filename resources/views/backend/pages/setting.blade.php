@extends('backend.layouts.master')

@section('content')
<div class="setting-page">
    <div class="setting-tabs">
        <button onclick="switchTab('business')" id="tab-btn-business" class="tab-btn active-tab">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="16" x="4" y="4" rx="2"/><path d="M9 22V2h6v20"/><path d="M8 12h8"/></svg>
            {{ __('Identity & branding') }}
        </button>
        <button onclick="switchTab('operational')" id="tab-btn-operational" class="tab-btn inactive-tab">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
            {{ __('Operational') }}
        </button>
        <button onclick="switchTab('policies')" id="tab-btn-policies" class="tab-btn inactive-tab">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            {{ __('Website Policies') }}
        </button>
    </div> 

    <div class="setting-card">

        {{-- Identity Tab --}}
        <div id="tab-business" class="tab-content block">
            <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                @csrf

                <p class="section-label">{{ __('Branding assets') }}</p>

                <div class="upload-row flex flex-col md:flex-row gap-6 md:gap-8">
                    <div class="upload-item">
                        <div class="upload-preview">
                            <img id="image_icon" src="{{ !empty(get_setting('system_icon')) ? url('uploads/logo/' . get_setting('system_icon')) : url('backend/images/favicon.png') }}">
                        </div>
                        <div class="upload-info">
                            <div class="upload-name">{{ __('System icon') }}</div>
                            <div class="upload-hint">{{ __('32×32 recommended') }}</div>
                            <label class="upload-btn">{{ __('Change icon') }}
                                <input type="file" name="system_icon" style="display:none" onchange="readURLIcon(this);">
                            </label>
                        </div>
                    </div>
                    <div class="upload-item">
                        <div class="upload-preview wide">
                            <img id="image_logo" src="{{ !empty(get_setting('system_logo')) ? url('uploads/logo/' . get_setting('system_logo')) : url('backend/images/no_images.png') }}">
                        </div>
                        <div class="upload-info">
                            <div class="upload-name">{{ __('System logo') }}</div>
                            <div class="upload-hint">{{ __('SVG or PNG, wide format') }}</div>
                            <label class="upload-btn">{{ __('Upload logo') }}
                                <input type="file" name="system_logo" style="display:none" onchange="readURLLogo(this);">
                            </label>
                        </div>
                    </div>
                    <div class="upload-item">
                        <div class="upload-preview wide">
                            <img id="image_login_bg" src="{{ !empty(get_setting('login_bg')) ? url('uploads/logo/' . get_setting('login_bg')) : url('backend/images/multishop_bg.png') }}">
                        </div>
                        <div class="upload-info">
                            <div class="upload-name">{{ __('Login Background') }}</div>
                            <div class="upload-hint">{{ __('1920×1080 recommended') }}</div>
                            <label class="upload-btn">{{ __('Upload BG') }}
                                <input type="file" name="login_bg" style="display:none" onchange="readURLLoginBg(this);">
                            </label>
                        </div>
                    </div>
                </div>

                <p class="section-label">{{ __('Store details') }}</p>

                <div class="field-grid grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="field">
                        <label>{{ __('Store name') }}</label>
                        <input type="hidden" name="types[]" value="com_name">
                        <input type="text" name="com_name" value="{{ get_setting('com_name') }}" placeholder="{{ __('e.g. My Store') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('Email') }}</label>
                        <input type="hidden" name="types[]" value="com_email">
                        <input type="email" name="com_email" value="{{ get_setting('com_email') }}" placeholder="{{ __('contact@store.com') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('Phone') }}</label>
                        <input type="hidden" name="types[]" value="com_phone">
                        <input type="text" name="com_phone" value="{{ get_setting('com_phone') }}" placeholder="+880...">
                    </div>
                    <div class="field">
                        <label>{{ __('Currency') }}</label>
                        <input type="hidden" name="types[]" value="com_currency">
                        <input type="text" name="com_currency" value="{{ get_setting('com_currency') }}" placeholder="{{ __('BDT') }}">
                    </div>
                    <div class="field col-span-1 md:col-span-2">
                        <label>{{ __('Address') }}</label>
                        <input type="hidden" name="types[]" value="com_address">
                        <textarea name="com_address" rows="2" placeholder="{{ __('Street, city, country') }}">{{ get_setting('com_address') }}</textarea>
                    </div>
                </div>

                <p class="section-label mt-6">{{ __('Special Deals Welcome Popup') }}</p>

                <div class="field-grid grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div class="field">
                        <label>{{ __('Popup Title') }}</label>
                        <input type="hidden" name="types[]" value="welcome_popup_title">
                        <input type="text" name="welcome_popup_title" value="{{ get_setting('welcome_popup_title') ?: 'Special Deals Just for You' }}" placeholder="Special Deals Just for You">
                    </div>
                    <div class="field">
                        <label>{{ __('Popup Subtitle / Notice') }}</label>
                        <input type="hidden" name="types[]" value="welcome_popup_subtitle">
                        <input type="text" name="welcome_popup_subtitle" value="{{ get_setting('welcome_popup_subtitle') ?: 'Coupons confirmed after login' }}" placeholder="Coupons confirmed after login">
                    </div>
                    <div class="field col-span-1 md:col-span-2">
                        <label>{{ __('Popup Display Status') }}</label>
                        <input type="hidden" name="types[]" value="welcome_popup_status">
                        <select name="welcome_popup_status" class="select2">
                            <option value="enabled" {{ get_setting('welcome_popup_status') != 'disabled' ? 'selected' : '' }}>{{ __('Enabled (Show 1:1 Special Deals Popup to Visitors)') }}</option>
                            <option value="disabled" {{ get_setting('welcome_popup_status') == 'disabled' ? 'selected' : '' }}>{{ __('Disabled') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Live Coupon Cards Repeater Manager -->
                <div class="border border-slate-200 dark:border-slate-700/60 rounded-xl p-5 bg-slate-50/50 dark:bg-slate-800/40 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="font-bold text-sm text-slate-800 dark:text-white flex items-center gap-2">
                                <span>🎟️</span>
                                <span>{{ __('Popup Coupon Deals List') }}</span>
                            </h4>
                            <p class="text-xs text-slate-500 mt-0.5">{{ __('Customize the discount coupons displayed inside the popup.') }}</p>
                        </div>
                        <button type="button" onclick="addCouponRow()" class="px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-colors">
                            <span>+</span> {{ __('Add Coupon') }}
                        </button>
                    </div>

                    <input type="hidden" name="types[]" value="welcome_popup_deals">
                    <input type="hidden" name="welcome_popup_deals" id="welcome_popup_deals_input" value="{{ json_encode(get_welcome_popup_deals()) }}">

                    <div id="couponListContainer" class="space-y-3">
                        @foreach(get_welcome_popup_deals() as $idx => $c)
                            <div class="coupon-item-row bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-4 relative grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Badge Tag</label>
                                    <input type="text" class="c-tag w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="{{ $c['tag'] ?? 'New User' }}" placeholder="New User" oninput="syncCouponsJson()">
                                </div>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Discount %</label>
                                    <input type="number" class="c-discount w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="{{ $c['discount'] ?? 20 }}" placeholder="29" oninput="syncCouponsJson()">
                                </div>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Coupon Code</label>
                                    <input type="text" class="c-code w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent uppercase font-mono font-bold" value="{{ $c['code'] ?? 'NEW20' }}" placeholder="NEW29" oninput="syncCouponsJson()">
                                </div>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Min. Order / Condition</label>
                                    <input type="text" class="c-condition w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="{{ $c['condition'] ?? 'No Min. Buy' }}" placeholder="No Min. Buy" oninput="syncCouponsJson()">
                                </div>
                                <div>
                                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Cap / Max Limit</label>
                                    <input type="text" class="c-cap w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="{{ $c['cap'] ?? 'Capped at RM16.35' }}" placeholder="Capped at RM16.35" oninput="syncCouponsJson()">
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1">
                                        <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Title</label>
                                        <input type="text" class="c-title w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="{{ $c['title'] ?? 'Product Coupon' }}" placeholder="Product Coupon" oninput="syncCouponsJson()">
                                    </div>
                                    <button type="button" onclick="this.closest('.coupon-item-row').remove(); syncCouponsJson();" class="p-2 text-rose-500 hover:bg-rose-50 rounded text-sm transition-colors" title="Delete Coupon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18m-2 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="footer-row">
                    <button type="submit" class="save-btn flex items-center justify-center gap-2">
                        <span class="btn-text">{{ __('Save identity') }}</span>
                        <span class="btn-loader hidden">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Operational Tab --}}
        <div id="tab-operational" class="tab-content hidden">
            <form method="POST" action="{{ route('setting.update') }}">
                @csrf

                <p class="section-label">{{ __('Print & display options') }}</p>

                <div class="field-grid grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="field">
                        <label>{{ __('Barcode style') }}</label>
                        <input type="hidden" name="types[]" value="pro_barcode">
                        <select name="pro_barcode" class="select2">
                            <option value="a4" {{ get_setting('pro_barcode') == 'a4' ? 'selected' : '' }}>{{ __('A4 sheet') }}</option>
                            <option value="single" {{ get_setting('pro_barcode') == 'single' ? 'selected' : '' }}>{{ __('Single thermal') }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>{{ __('Invoice branding') }}</label>
                        <input type="hidden" name="types[]" value="inv_logo">
                        <select name="inv_logo" class="select2">
                            <option value="name" {{ get_setting('inv_logo') == 'name' ? 'selected' : '' }}>{{ __('Name only') }}</option>
                            <option value="logo" {{ get_setting('inv_logo') == 'logo' ? 'selected' : '' }}>{{ __('Logo only') }}</option>
                            <option value="both" {{ get_setting('inv_logo') == 'both' ? 'selected' : '' }}>{{ __('Both') }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>{{ __('Invoice layout') }}</label>
                        <input type="hidden" name="types[]" value="inv_design">
                        <select name="inv_design" class="select2">
                            <option value="a4" {{ get_setting('inv_design') == 'a4' ? 'selected' : '' }}>{{ __('Standard A4') }}</option>
                            <option value="a5" {{ get_setting('inv_design') == 'a5' ? 'selected' : '' }}>{{ __('Standard A5') }}</option>
                            <option value="pos" {{ get_setting('inv_design') == 'pos' ? 'selected' : '' }}>{{ __('POS 80mm') }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>{{ __('Stock detail') }}</label>
                        <input type="hidden" name="types[]" value="inv_details">
                        <select name="inv_details" class="select2">
                            <option value="single" {{ get_setting('inv_details') == 'single' ? 'selected' : '' }}>{{ __('Single shop') }}</option>
                            <option value="branch" {{ get_setting('inv_details') == 'branch' ? 'selected' : '' }}>{{ __('Branch wise') }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>{{ __('VAT / Tax Status (VAT Include)') }}</label>
                        <input type="hidden" name="types[]" value="vat_include">
                        <select name="vat_include" class="select2">
                            <option value="no" {{ !is_vat_enabled() ? 'selected' : '' }}>{{ __('Exclude / Disabled (Hide VAT)') }}</option>
                            <option value="yes" {{ is_vat_enabled() ? 'selected' : '' }}>{{ __('Include / Enabled (Show VAT)') }}</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>{{ __('Invoice QR Code') }}</label>
                        <input type="hidden" name="types[]" value="inv_qr_code">
                        <select name="inv_qr_code" class="select2">
                            <option value="yes" {{ get_setting('inv_qr_code', 'yes') == 'yes' ? 'selected' : '' }}>{{ __('Show / Enabled') }}</option>
                            <option value="no" {{ get_setting('inv_qr_code', 'yes') == 'no' ? 'selected' : '' }}>{{ __('Hide / Disabled') }}</option>
                        </select>
                    </div>
                </div>

                @if(env('APP_COURIER_FRAUD_CHECK') == 'yes' && auth()->check() && auth()->user()->isSuperAdmin())
                <p class="section-label mt-6">{{ __('Steadfast Courier API Settings') }}</p>

                <div class="field-grid grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="field">
                        <label>{{ __('Steadfast API Key') }}</label>
                        <input type="hidden" name="types[]" value="steadfast_api_key">
                        <input type="text" name="steadfast_api_key" value="{{ get_setting('steadfast_api_key') ?: env('STEADFAST_API_KEY') }}" placeholder="{{ __('API Key') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('Steadfast Secret Key') }}</label>
                        <input type="hidden" name="types[]" value="steadfast_secret_key">
                        <input type="password" name="steadfast_secret_key" value="{{ get_setting('steadfast_secret_key') ?: env('STEADFAST_SECRET_KEY') }}" placeholder="{{ __('Secret Key') }}">
                    </div>
                </div>

                <p class="section-label mt-6">{{ __('Pathao Courier API Settings') }}</p>

                <div class="field-grid grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="field">
                        <label>{{ __('Pathao Client ID') }}</label>
                        <input type="hidden" name="types[]" value="pathao_client_id">
                        <input type="text" name="pathao_client_id" value="{{ get_setting('pathao_client_id') ?: (env('PATHAO_CLIENT_ID') ?: 'jnegkRrewZ') }}" placeholder="{{ __('Client ID') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('Pathao Client Secret') }}</label>
                        <input type="hidden" name="types[]" value="pathao_client_secret">
                        <input type="password" name="pathao_client_secret" value="{{ get_setting('pathao_client_secret') ?: env('PATHAO_CLIENT_SECRET') }}" placeholder="{{ __('Client Secret') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('Pathao Username / Email') }}</label>
                        <input type="hidden" name="types[]" value="pathao_username">
                        <input type="text" name="pathao_username" value="{{ get_setting('pathao_username') ?: env('PATHAO_USERNAME') }}" placeholder="{{ __('Registered Email or Phone') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('Pathao Password') }}</label>
                        <input type="hidden" name="types[]" value="pathao_password">
                        <input type="password" name="pathao_password" value="{{ get_setting('pathao_password') ?: env('PATHAO_PASSWORD') }}" placeholder="{{ __('Account Password') }}">
                    </div>
                    <div class="field col-span-1 md:col-span-2">
                        <label>{{ __('Pathao Secret Token (Optional)') }}</label>
                        <input type="hidden" name="types[]" value="pathao_secret_token">
                        <input type="text" name="pathao_secret_token" value="{{ get_setting('pathao_secret_token') ?: env('PATHAO_SECRET_TOKEN') }}" placeholder="{{ __('Secret Bearer Token if issued directly') }}">
                    </div>
                </div>

                <p class="section-label mt-6">{{ __('Custom Courier Fraud Checker API Settings') }}</p>

                <div class="field-grid grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="field">
                        <label>{{ __('Fraud API Base URL') }}</label>
                        <input type="hidden" name="types[]" value="courier_fraud_api_url">
                        <input type="text" name="courier_fraud_api_url" value="{{ get_setting('courier_fraud_api_url') }}" placeholder="{{ __('e.g. https://api.fraudchecker.xyz') }}">
                    </div>
                    <div class="field">
                        <label>{{ __('Fraud API Key') }}</label>
                        <input type="hidden" name="types[]" value="courier_fraud_api_key">
                        <input type="password" name="courier_fraud_api_key" value="{{ get_setting('courier_fraud_api_key') }}" placeholder="{{ __('API Authorization Key') }}">
                    </div>
                </div>
                @endif

                <div class="footer-row">
                    <button type="submit" class="save-btn flex items-center justify-center gap-2">
                        <span class="btn-text">{{ __('Apply settings') }}</span>
                        <span class="btn-loader hidden">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        {{-- Website Policies Tab --}}
        <div id="tab-policies" class="tab-content hidden">
            <form method="POST" action="{{ route('setting.policies.update') }}">
                @csrf
                <p class="section-label">{{ __('Customer Policy Pages (Editable Content)') }}</p>

                <!-- Privacy Policy -->
                <div class="field-group mb-6">
                    <label class="field-label flex justify-between items-center mb-1.5">
                        <span class="font-bold text-slate-800">{{ __('Privacy Policy') }}</span>
                        <a href="{{ route('frontend.privacy') }}" target="_blank" class="text-xs text-blue-600 underline">{{ __('Preview') }} &rarr;</a>
                    </label>
                    <textarea name="policy_privacy" rows="7" class="field-input w-full font-mono text-xs leading-relaxed" placeholder="Enter privacy policy text or HTML...">{{ get_setting('policy_privacy') }}</textarea>
                </div>

                <!-- Return & Refund Policy -->
                <div class="field-group mb-6">
                    <label class="field-label flex justify-between items-center mb-1.5">
                        <span class="font-bold text-slate-800">{{ __('Return & Refund Policy') }}</span>
                        <a href="{{ route('frontend.returns') }}" target="_blank" class="text-xs text-blue-600 underline">{{ __('Preview') }} &rarr;</a>
                    </label>
                    <textarea name="policy_returns" rows="7" class="field-input w-full font-mono text-xs leading-relaxed" placeholder="Enter return & refund policy text or HTML...">{{ get_setting('policy_returns') }}</textarea>
                </div>

                <!-- Shipping & Delivery Policy -->
                <div class="field-group mb-6">
                    <label class="field-label flex justify-between items-center mb-1.5">
                        <span class="font-bold text-slate-800">{{ __('Shipping & Delivery Policy') }}</span>
                        <a href="{{ route('frontend.shipping') }}" target="_blank" class="text-xs text-blue-600 underline">{{ __('Preview') }} &rarr;</a>
                    </label>
                    <textarea name="policy_shipping" rows="7" class="field-input w-full font-mono text-xs leading-relaxed" placeholder="Enter shipping & delivery policy text or HTML...">{{ get_setting('policy_shipping') }}</textarea>
                </div>

                <!-- Terms & Conditions -->
                <div class="field-group mb-6">
                    <label class="field-label flex justify-between items-center mb-1.5">
                        <span class="font-bold text-slate-800">{{ __('Terms & Conditions') }}</span>
                        <a href="{{ route('frontend.terms') }}" target="_blank" class="text-xs text-blue-600 underline">{{ __('Preview') }} &rarr;</a>
                    </label>
                    <textarea name="policy_terms" rows="7" class="field-input w-full font-mono text-xs leading-relaxed" placeholder="Enter terms & conditions text or HTML...">{{ get_setting('policy_terms') }}</textarea>
                </div>

                <!-- Payment Policy -->
                <div class="field-group mb-6">
                    <label class="field-label flex justify-between items-center mb-1.5">
                        <span class="font-bold text-slate-800">{{ __('Payment Policy') }}</span>
                        <a href="{{ route('frontend.payment_policy') }}" target="_blank" class="text-xs text-blue-600 underline">{{ __('Preview') }} &rarr;</a>
                    </label>
                    <textarea name="policy_payment" rows="7" class="field-input w-full font-mono text-xs leading-relaxed" placeholder="Enter payment policy text or HTML...">{{ get_setting('policy_payment') }}</textarea>
                </div>

                <div class="form-actions mt-6">
                    <button type="submit" class="save-btn">
                        <span class="btn-text">{{ __('Save Policy Changes') }}</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@push('js')
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(function(c) {
            c.classList.add('hidden');
            c.classList.remove('block');
        });
        document.getElementById('tab-' + tabId).classList.replace('hidden', 'block');

        document.querySelectorAll('.tab-btn').forEach(function(b) {
            b.classList.remove('active-tab');
            b.classList.add('inactive-tab');
        });
        document.getElementById('tab-btn-' + tabId).classList.add('active-tab');
        document.getElementById('tab-btn-' + tabId).classList.remove('inactive-tab');
    }

    function readURLIcon(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image_icon').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURLLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image_logo').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURLLoginBg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image_login_bg').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ==========================================
    // WELCOME POPUP COUPONS REPEATER SYNC
    // ==========================================
    function syncCouponsJson() {
        const rows = document.querySelectorAll('.coupon-item-row');
        const list = [];
        rows.forEach((row, i) => {
            const tag = row.querySelector('.c-tag').value.trim() || 'New User';
            const disc = row.querySelector('.c-discount').value.trim() || '20';
            const code = row.querySelector('.c-code').value.trim().toUpperCase() || ('NEW' + disc);
            const cond = row.querySelector('.c-condition').value.trim() || 'No Min. Buy';
            const cap = row.querySelector('.c-cap').value.trim() || 'Capped at RM16.35';
            const title = row.querySelector('.c-title').value.trim() || 'Product Coupon';
            
            list.push({
                id: 'deal_' + (i + 1),
                tag: tag,
                discount: disc,
                unit: '%OFF',
                condition: cond,
                title: title,
                cap: cap,
                timer: 'Time-limited',
                code: code,
                rate: parseFloat(disc) / 100
            });
        });
        const input = document.getElementById('welcome_popup_deals_input');
        if (input) {
            input.value = JSON.stringify(list);
        }
    }

    function addCouponRow() {
        const container = document.getElementById('couponListContainer');
        if (!container) return;
        const newIdx = container.children.length + 1;
        const div = document.createElement('div');
        div.className = 'coupon-item-row bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-4 relative grid grid-cols-1 md:grid-cols-6 gap-3 items-end';
        div.innerHTML = `
            <div>
                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Badge Tag</label>
                <input type="text" class="c-tag w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="New User" placeholder="New User" oninput="syncCouponsJson()">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Discount %</label>
                <input type="number" class="c-discount w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="40" placeholder="40" oninput="syncCouponsJson()">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Coupon Code</label>
                <input type="text" class="c-code w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent uppercase font-mono font-bold" value="NEW40" placeholder="NEW40" oninput="syncCouponsJson()">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Min. Order / Condition</label>
                <input type="text" class="c-condition w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="Orders RM50+" placeholder="Orders RM50+" oninput="syncCouponsJson()">
            </div>
            <div>
                <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Cap / Max Limit</label>
                <input type="text" class="c-cap w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="Capped at RM40.00" placeholder="Capped at RM40.00" oninput="syncCouponsJson()">
            </div>
            <div class="flex items-center gap-2">
                <div class="flex-1">
                    <label class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 block mb-1">Title</label>
                    <input type="text" class="c-title w-full text-xs p-2 border border-slate-200 dark:border-slate-700 rounded bg-transparent" value="Product Coupon" placeholder="Product Coupon" oninput="syncCouponsJson()">
                </div>
                <button type="button" onclick="this.closest('.coupon-item-row').remove(); syncCouponsJson();" class="p-2 text-rose-500 hover:bg-rose-50 rounded text-sm transition-colors" title="Delete Coupon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18m-2 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                </button>
            </div>
        `;
        container.appendChild(div);
        syncCouponsJson();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('#tab-business form');
        if (form) {
            form.addEventListener('submit', () => {
                syncCouponsJson();
            });
        }
    });
</script>
@endpush
