<!-- ==========================================
     OFFICIAL FAST IT 1:1 HEADER (DARK THEME)
     ========================================== -->
<header class="shein-official-header" id="sheinHeader" style="width: 100%; position: sticky; top: 0; z-index: 1000; background: #000000; box-shadow: 0 4px 15px rgba(0,0,0,0.25);">
    <!-- 1. TOP ANNOUNCEMENT TICKER -->
    <div class="shein-top-ticker" style="background: #000000; color: #ffffff; font-size: 11px; font-weight: 600; height: 32px; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; letter-spacing: 0.3px; border-bottom: 1px solid rgba(255,255,255,0.12);">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="background: #FA2C19; color: #ffffff; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 2px; text-transform: uppercase;">HOT</span>
            <span>FREE SHIPPING ON ORDERS OVER RM120 • 20-DAY EASY RETURNS • CASH ON DELIVERY</span>
        </div>
        <div style="display: flex; align-items: center; gap: 20px; font-size: 11px; color: #cccccc;">
            <a href="{{ route('frontend.track_order') }}" style="display: flex; align-items: center; gap: 4px; color: #ffffff; text-decoration: none;">
                <i class="fa-solid fa-truck-fast" style="color: #FA2C19;"></i> Track Order
            </a>
            <span style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #ffffff;" onclick="showToast('Shipping to: Bangladesh & Malaysia')">🇧🇩 BD / 🇲🇾 MY</span>
            <span style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #cccccc;" onclick="showToast('24/7 Customer Help Center')"><i class="fa-regular fa-circle-question"></i> Help</span>
        </div>
    </div>

    <!-- 2. MAIN HEADER BAR (BLACK BACKGROUND & WHITE ICONS/LOGO) -->
    <div style="background: #000000; border-bottom: 1px solid rgba(255,255,255,0.12);">
        <div class="shein-wrap" style="max-width: 1440px; margin: 0 auto; padding: 0 20px; height: 60px; display: flex; align-items: center; justify-content: space-between; gap: 24px;">
            <!-- Mobile Hamburger Menu Button -->
            <button type="button" class="mobile-hamburger-btn" onclick="toggleMobileMenu()" style="display: none; background: transparent; border: none; color: #ffffff; font-size: 22px; cursor: pointer; padding: 4px; flex-shrink: 0;">
                <i class="fa-solid fa-bars" id="hamburgerIcon"></i>
            </button>

            <!-- Brand Logo (Dynamic System Logo) -->
            <div style="display: flex; align-items: center; flex-shrink: 0;">
                @php
                    $sysLogo = get_setting('system_logo');
                    $invLogo = get_setting('inv_logo');
                    $logoFile = null;
                    if (!empty($sysLogo) && file_exists(public_path('uploads/logo/' . $sysLogo))) {
                        $logoFile = $sysLogo;
                    } elseif (!empty($invLogo) && file_exists(public_path('uploads/logo/' . $invLogo))) {
                        $logoFile = $invLogo;
                    }
                    $companyName = get_setting('com_name') ?: 'FAST IT';
                @endphp

                @if($logoFile)
                    <a href="{{ route('frontend.home') }}" title="{{ $companyName }}" style="display: inline-flex; align-items: center; text-decoration: none;">
                        <img src="{{ asset('uploads/logo/' . $logoFile) }}" 
                             alt="{{ $companyName }}" 
                             style="max-height: 38px; max-width: 150px; height: auto; width: auto; object-fit: contain; vertical-align: middle; background: #ffffff; padding: 3px 8px; border-radius: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                    </a>
                @else
                    <a href="{{ route('frontend.home') }}" title="{{ $companyName }}" style="display: inline-flex; align-items: center; text-decoration: none; font-size: 24px; font-weight: 900; letter-spacing: 2.5px; color: #ffffff; text-transform: uppercase;">
                        <span>{{ $companyName }}</span>
                    </a>
                @endif
            </div>

            <!-- Search Form (Desktop) -->
            <div class="desktop-search-container" style="flex: 1; max-width: 620px; position: relative;">
                <form action="{{ route('frontend.search') }}" method="GET" style="display: flex; align-items: center; border: 1px solid #444444; border-radius: 4px; height: 38px; background: #ffffff; overflow: hidden; width: 100%;">
                    <input type="search" id="headerSearchBox" name="q" value="{{ request('q') }}" placeholder="Search dresses, tops, swimwear, shoes..." autocomplete="off" style="flex: 1; height: 100%; border: none; outline: none; padding: 0 16px; font-size: 13px; font-family: inherit; color: #222222; background: transparent;">
                    
                    <button type="button" onclick="showToast('Visual Search: Upload an outfit photo to find similar styles')" title="Search by image" style="border: none; background: transparent; padding: 0 12px; color: #666666; cursor: pointer; font-size: 15px;">
                        <i class="fa-solid fa-camera"></i>
                    </button>

                    <button type="submit" style="width: 46px; height: 100%; background: #222222; color: #ffffff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <!-- Search Suggestions Dropdown -->
                <div id="search-suggestions" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #ffffff; border: 1px solid #eeeeee; box-shadow: 0 10px 25px rgba(0,0,0,0.3); padding: 16px; border-radius: 4px; z-index: 1005; margin-top: 4px;">
                    <div style="font-size: 11px; font-weight: 800; color: #999999; text-transform: uppercase; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                        <span>🔥 Trending Searches</span>
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        <a href="{{ route('frontend.search', ['q' => 'dress']) }}" style="background: #FFF1F0; color: #FA2C19; font-weight: 700; font-size: 12px; padding: 6px 14px; border-radius: 14px; border: 1px solid #FFE4DE;">👗 Dresses</a>
                        <a href="{{ route('frontend.search', ['q' => 'blouse']) }}" style="background: #f7f7f7; color: #333333; font-size: 12px; padding: 6px 14px; border-radius: 14px;">Tops & Blouses</a>
                        <a href="{{ route('frontend.search', ['q' => 'beachwear']) }}" style="background: #f7f7f7; color: #333333; font-size: 12px; padding: 6px 14px; border-radius: 14px;">Swimwear</a>
                        <a href="{{ route('frontend.search', ['q' => 'y2k']) }}" style="background: #FFF1F0; color: #FA2C19; font-weight: 700; font-size: 12px; padding: 6px 14px; border-radius: 14px; border: 1px solid #FFE4DE;">✨ Y2K Chic</a>
                        <a href="{{ route('frontend.search', ['q' => 'jeans']) }}" style="background: #f7f7f7; color: #333333; font-size: 12px; padding: 6px 14px; border-radius: 14px;">Wide Leg Jeans</a>
                        <a href="{{ route('frontend.search', ['q' => 'shoes']) }}" style="background: #f7f7f7; color: #333333; font-size: 12px; padding: 6px 14px; border-radius: 14px;">Heels & Sandals</a>
                        <a href="{{ route('frontend.search', ['q' => 'jewelry']) }}" style="background: #f7f7f7; color: #333333; font-size: 12px; padding: 6px 14px; border-radius: 14px;">Jewelry</a>
                    </div>
                </div>
            </div>

            <!-- Action Tools Icons (White Color) -->
            <div style="display: flex; align-items: center; gap: 20px; color: #ffffff;">
                <!-- User Account -->
                <div class="bsc-user-container" style="position: relative; cursor: pointer;">
                    @php
                        $isCustomerLoggedIn = session()->has('customer_auth');
                        $cust = session('customer_auth');
                    @endphp
                    <a href="{{ $isCustomerLoggedIn ? route('frontend.account') : route('frontend.login') }}" style="color: #ffffff; display: flex; align-items: center; gap: 6px; font-size: 20px;" title="Account">
                        <i class="fa-regular fa-user"></i>
                        @if($isCustomerLoggedIn)
                            <span style="font-size: 11px; font-weight: 800; max-width: 90px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ explode(' ', $cust['name'] ?? 'User')[0] }}</span>
                        @endif
                    </a>
                    <!-- Flyout Dropdown -->
                    <div class="bsc-user-container__dropdown" id="sheinUserDropdown" style="display: none; position: absolute; top: 100%; right: 0; width: 240px; background: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,0.25); border: 1px solid #eeeeee; padding: 16px; z-index: 1003; margin-top: 10px; border-radius: 4px;">
                        @if($isCustomerLoggedIn)
                            <div style="margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #f2f2f2;">
                                <div style="font-size: 13px; font-weight: 800; color: #111;">{{ $cust['name'] ?? 'Customer' }}</div>
                                <div style="font-size: 11px; color: #777;">{{ $cust['email'] ?? '' }}</div>
                                <div style="margin-top: 6px;">
                                    <span style="background: #FFF0ED; color: #FA2C19; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px;">{{ $cust['tier'] ?? 'VIP Member' }}</span>
                                </div>
                            </div>
                            <a href="{{ route('frontend.account') }}" style="display: block; background: #000000; color: #ffffff; text-align: center; padding: 9px 0; font-weight: 800; font-size: 11px; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px; border-radius: 2px;">
                                <i class="fa-solid fa-chart-pie" style="margin-right: 4px;"></i> MY ACCOUNT DASHBOARD
                            </a>
                        @else
                            <a href="{{ route('frontend.login') }}" style="display: block; background: #000000; color: #ffffff; text-align: center; padding: 10px 0; font-weight: 800; font-size: 12px; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">SIGN IN / REGISTER</a>
                        @endif

                        <div style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #333333;">
                            @if($isCustomerLoggedIn)
                                <a href="{{ route('frontend.account', ['tab' => 'orders']) }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-solid fa-box" style="margin-right: 8px;"></i> My Orders</span> <i class="fa-solid fa-angle-right"></i></a>
                                <a href="{{ route('frontend.account', ['tab' => 'profile']) }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-regular fa-id-card" style="margin-right: 8px;"></i> My Profile</span> <i class="fa-solid fa-angle-right"></i></a>
                                <a href="{{ route('frontend.account', ['tab' => 'addresses']) }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-solid fa-location-dot" style="margin-right: 8px;"></i> My Addresses</span> <i class="fa-solid fa-angle-right"></i></a>
                            @endif
                            <a href="{{ route('frontend.track_order') }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5; color: #0284c7; font-weight: 700;"><span><i class="fa-solid fa-truck-fast" style="margin-right: 8px;"></i> Track Order</span> <i class="fa-solid fa-angle-right"></i></a>
                            <a href="{{ route('frontend.wishlist') }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-regular fa-heart" style="margin-right: 8px;"></i> My Wishlist</span> <span style="color: #FA2C19; font-weight: 700;">❤️</span></a>
                            <a href="{{ route('frontend.cart') }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-solid fa-bag-shopping" style="margin-right: 8px;"></i> Shopping Bag</span></a>
                            @if($isCustomerLoggedIn)
                                <a href="{{ route('frontend.account', ['tab' => 'password']) }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-solid fa-lock" style="margin-right: 8px;"></i> Change Password</span> <i class="fa-solid fa-angle-right"></i></a>
                                <a href="{{ route('frontend.customer_logout') }}" style="padding: 7px 0; display: flex; justify-content: space-between; align-items: center; color: #FA2C19; font-weight: 700; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-solid fa-arrow-right-from-bracket" style="margin-right: 8px;"></i> Logout</span></a>
                            @else
                                <a href="{{ route('frontend.account', ['tab' => 'guest']) }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5; color: #0284C7; font-weight: 700;"><span><i class="fa-solid fa-magnifying-glass" style="margin-right: 8px;"></i> Guest Order Lookup</span></a>
                            @endif
                            <a href="{{ url('/login') }}" style="padding: 8px 0; display: flex; justify-content: space-between; align-items: center; color: #666666; font-size: 11px; font-weight: 700;"><span><i class="fa-solid fa-lock" style="margin-right: 8px;"></i> Staff ERP Portal</span> <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Bag / Cart -->
                <div style="position: relative; cursor: pointer;" onclick="openCartDrawer()" title="Shopping Bag">
                    <span style="font-size: 22px; color: #ffffff; display: flex; align-items: center;">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </span>
                    <span class="bsc-cart-num" id="navCartBadge" style="position: absolute; top: -6px; right: -8px; background: #FA2C19; color: #ffffff; font-size: 10px; font-weight: 800; width: 17px; height: 17px; border-radius: 50%; display: flex; align-items: center; justify-content: center; line-height: 1;">0</span>
                </div>

                <!-- Wishlist -->
                <a href="{{ route('frontend.wishlist') }}" style="position: relative; color: #ffffff; display: flex; align-items: center; font-size: 22px;" title="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                    <span id="navWishlistBadge" style="position: absolute; top: -6px; right: -8px; background: #FA2C19; color: #ffffff; font-size: 10px; font-weight: 800; width: 17px; height: 17px; border-radius: 50%; display: flex; align-items: center; justify-content: center; line-height: 1;">0</span>
                </a>

                <!-- Virtual Support Robot -->
                <div style="cursor: pointer; font-size: 22px; color: #ffffff; display: flex; align-items: center;" onclick="showToast({!! json_encode((get_setting('com_name') ?: 'FAST IT') . ' 24/7 Virtual Support: How can we assist you today?') !!})" title="Customer Support">
                    <i class="fa-solid fa-robot"></i>
                </div>

                <!-- Region / Language Selector -->
                <div style="cursor: pointer; font-size: 22px; color: #ffffff; display: flex; align-items: center;" onclick="showToast('Region: 🇲🇾 Malaysia | Currency: RM / MYR | English')" title="Language and Currency">
                    <i class="fa-solid fa-globe"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Dedicated Mobile Search Bar Row (Visible only on mobile screens <= 900px) -->
    <div class="mobile-search-row" style="display: none; background: #000000; padding: 8px 16px 10px; border-bottom: 1px solid rgba(255,255,255,0.12);">
        <form action="{{ route('frontend.search') }}" method="GET" style="display: flex; align-items: center; border: 1px solid #444444; border-radius: 4px; height: 38px; background: #ffffff; overflow: hidden; width: 100%;">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products, styles, categories..." autocomplete="off" style="flex: 1; height: 100%; border: none; outline: none; padding: 0 14px; font-size: 13px; font-family: inherit; color: #222222; background: transparent;">
            <button type="submit" style="width: 44px; height: 100%; background: #222222; color: #ffffff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <!-- 3. SECONDARY CATEGORY NAVIGATION STRIP (BLACK BACKGROUND & WHITE FONT) -->
    <div style="background: #000000; border-bottom: 1px solid rgba(255,255,255,0.15); position: relative;">
        <div class="shein-wrap" style="max-width: 1440px; margin: 0 auto; padding: 0 20px; height: 42px; display: flex; align-items: center; justify-content: space-between;">
            <!-- Categories Dropdown Button -->
            <button type="button" class="first-cate" id="sheinCatBtn" onclick="toggleCategoriesMenu()" style="display: flex; align-items: center; gap: 6px; font-weight: 800; font-size: 13px; text-transform: uppercase; color: #ffffff; padding: 8px 14px 8px 0; border: none; background: transparent; cursor: pointer; flex-shrink: 0;">
                <span style="color: #ffffff;">Categories</span>
                <i class="fa-solid fa-chevron-down" id="sheinCatChevron" style="font-size: 11px; color: #ffffff; transition: transform 0.2s;"></i>
            </button>

            @php
                $navCategories = \App\Models\Category::where('name', '!=', 'General')
                    ->with(['subCategories' => function($q) {
                        $q->orderBy('order_num', 'asc')->orderBy('id', 'asc');
                    }])
                    ->orderBy('order_num', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
            @endphp

            <!-- Categories Mega Menu Flyout (2-Tier with Circular Subcategory Thumbnails) -->
            <div id="sheinCategoriesFlyout" style="display: {{ request('show_menu') ? 'block' : 'none' }}; position: absolute; top: 100%; left: 20px; width: 940px; max-width: calc(100vw - 40px); height: 530px; background: #ffffff; box-shadow: 0 16px 45px rgba(0,0,0,0.35); border: 1px solid #e5e5e5; z-index: 1100; border-radius: 0 0 6px 6px; overflow: hidden;">
                <div style="display: flex; height: 100%; width: 100%;">
                    
                    <!-- Left Column: Primary Categories List -->
                    <div class="mega-cat-sidebar" style="width: 220px; flex-shrink: 0; background: #ffffff; border-right: 1px solid #eeeeee; overflow-y: auto; padding: 6px 0;">
                        @foreach($navCategories as $catIndex => $navCat)
                            @php
                                $isFirst = ($catIndex === 0);
                                $isHot = ($navCat->badge || \Illuminate\Support\Str::contains(strtolower($navCat->name), 'sale'));
                            @endphp
                            <a href="javascript:void(0)" 
                               class="mega-cat-link {{ $isFirst ? 'active' : '' }}" 
                               onmouseenter="showMegaTab('{{ $navCat->id }}', this)" 
                               onclick="showMegaTab('{{ $navCat->id }}', this)" 
                               style="display: flex; align-items: center; justify-content: space-between; padding: 11px 18px; font-size: 13px; font-weight: {{ $isFirst ? '700' : '500' }}; color: {{ $isHot ? '#FA2C19' : '#333333' }}; background: {{ $isFirst ? '#f0f0f0' : 'transparent' }}; text-decoration: none; border-left: 3px solid {{ $isFirst ? '#000000' : 'transparent' }};">
                                <span style="display: flex; align-items: center; gap: 6px;">
                                    {{ $navCat->name }}
                                    @if($navCat->badge)
                                        <span style="font-size: 9px; font-weight: 800; background: #FA2C19; color: #ffffff; padding: 1px 4px; border-radius: 2px;">{{ $navCat->badge }}</span>
                                    @endif
                                </span>
                                <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: {{ $isHot ? '#FA2C19' : ($isFirst ? '#888888' : '#cccccc') }};"></i>
                            </a>
                        @endforeach
                    </div>

                    <!-- Right Column: Subcategories Grid Panels -->
                    <div style="flex: 1; overflow-y: auto; padding: 22px 28px; background: #ffffff;">
                        @foreach($navCategories as $catIndex => $navCat)
                            @php
                                $isFirst = ($catIndex === 0);
                                $isHot = ($navCat->badge || \Illuminate\Support\Str::contains(strtolower($navCat->name), 'sale'));
                            @endphp
                            <div id="tab-{{ $navCat->id }}" class="mega-cat-panel" style="display: {{ $isFirst ? 'block' : 'none' }};">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 1px solid #f2f2f2; padding-bottom: 10px;">
                                    <div style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 800; color: {{ $isHot ? '#FA2C19' : '#111111' }}; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <i class="fa-solid {{ $isHot ? 'fa-fire' : 'fa-grip' }}" style="font-size: 14px;"></i>
                                        <span>{{ $navCat->name }}</span>
                                    </div>
                                    <a href="{{ route('frontend.category', $navCat->slug ?: $navCat->id) }}" style="font-size: 12px; color: #666666; text-decoration: none; font-weight: 600;">
                                        View All <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                                    </a>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px 16px;">
                                    @forelse($navCat->subCategories as $subItem)
                                        <a href="{{ route('frontend.category', $navCat->slug ?: $navCat->id) }}?subcategory={{ $subItem->id }}" style="display: flex; flex-direction: column; align-items: center; text-decoration: none; text-align: center;">
                                            <div style="width: 78px; height: 78px; border-radius: 50%; overflow: hidden; background: #F0EEEC; margin-bottom: 8px; border: 1px solid #f2f2f2; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                                                <img src="{{ $subItem->image_url }}" alt="{{ $subItem->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <span style="font-size: 12px; font-weight: 500; color: #222222; line-height: 1.25; max-width: 110px;">{{ $subItem->name }}</span>
                                        </a>
                                    @empty
                                        <div style="grid-column: span 4; text-align: center; color: #999999; padding: 40px 0; font-size: 13px;">
                                            <i class="fa-regular fa-folder-open" style="font-size: 28px; margin-bottom: 8px; display: block;"></i>
                                            No subcategories available yet
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Horizontal Scrollable Navigation Strip (White Links) -->
            <div style="flex: 1; overflow: hidden; display: flex; align-items: center; position: relative; margin: 0 10px;">
                <div class="bs-nav__content-inner" id="categoryNavInner" style="display: flex; align-items: center; gap: 20px; overflow-x: auto; scrollbar-width: none; white-space: nowrap; scroll-behavior: smooth;">
                    <!-- Fixed Navigation Links -->
                    <a href="{{ route('frontend.home') }}" style="font-size: 12px; font-weight: 900; color: #ffffff; text-decoration: none; padding: 4px 0; flex-shrink: 0; border-bottom: 2px solid #FA2C19;">
                        <i class="fa-solid fa-house" style="margin-right: 3px; font-size: 10px;"></i> Home
                    </a>
                    <a href="{{ route('frontend.category', 'all') }}" style="font-size: 12px; font-weight: 700; color: #ffffff; text-decoration: none; padding: 4px 0; flex-shrink: 0;">
                        Shop All
                    </a>
                    <a href="{{ route('frontend.category', 'new-in') }}" style="font-size: 12px; font-weight: 900; color: #4ADE80; text-decoration: none; padding: 4px 0; flex-shrink: 0;">
                        🆕 New Arrivals
                    </a>
                    <a href="{{ route('frontend.category', 'best-sellers') }}" style="font-size: 12px; font-weight: 700; color: #FFB800; text-decoration: none; padding: 4px 0; flex-shrink: 0;">
                        🔥 Best Sellers
                    </a>
                    <a href="{{ route('frontend.category', 'sale') }}" style="font-size: 12px; font-weight: 900; color: #FA2C19; text-decoration: none; padding: 4px 0; flex-shrink: 0; animation: salePulse 1.5s ease-in-out infinite;">
                        💥 Offers / Sale
                    </a>

                    <span style="color: rgba(255,255,255,0.3); font-size: 10px; flex-shrink: 0;">|</span>

                    <!-- Dynamic Category Links -->
                    @foreach($navCategories as $cat)
                        @php
                            $isHot = ($cat->badge || \Illuminate\Support\Str::contains(strtolower($cat->name), 'sale'));
                        @endphp
                        <a href="{{ route('frontend.category', $cat->slug ?: $cat->id) }}" style="font-size: 12px; font-weight: {{ $isHot ? '900' : '700' }}; color: {{ $isHot ? '#FA2C19' : '#ffffff' }}; text-decoration: none; padding: 4px 0; flex-shrink: 0;">
                            {{ $cat->name }}
                        </a>
                    @endforeach

                    <span style="color: rgba(255,255,255,0.3); font-size: 10px; flex-shrink: 0;">|</span>

                    <!-- Blog & Contact Links -->
                    <a href="{{ url('/blog') }}" style="font-size: 12px; font-weight: 700; color: #ffffff; text-decoration: none; padding: 4px 0; flex-shrink: 0;">
                        <i class="fa-regular fa-newspaper" style="margin-right: 3px; font-size: 10px;"></i> Blog
                    </a>
                    <a href="{{ url('/contact') }}" style="font-size: 12px; font-weight: 700; color: #ffffff; text-decoration: none; padding: 4px 0; flex-shrink: 0;">
                        <i class="fa-regular fa-envelope" style="margin-right: 3px; font-size: 10px;"></i> Contact Us
                    </a>
                </div>
            </div>

            <!-- Left / Right Scroll Controls (Translucent Dark Badges with White Icons) -->
            <div style="display: flex; align-items: center; gap: 4px; flex-shrink: 0;">
                <button type="button" aria-label="Scroll left" onclick="scrollCatNav(-260)" style="width: 24px; height: 24px; border: none; background: rgba(255,255,255,0.18); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #ffffff; font-size: 11px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button type="button" aria-label="Scroll right" onclick="scrollCatNav(260)" style="width: 24px; height: 24px; border: none; background: rgba(255,255,255,0.18); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #ffffff; font-size: 11px;">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- MOBILE SLIDE-OUT NAVIGATION MENU -->
<div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="toggleMobileMenu()" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); z-index: 2000;"></div>
<div class="mobile-nav-drawer" id="mobileNavDrawer" style="position: fixed; top: 0; left: -320px; width: 300px; max-width: 85vw; height: 100vh; background: #ffffff; z-index: 2001; transition: left 0.35s cubic-bezier(0.16, 1, 0.3, 1); overflow-y: auto; box-shadow: 5px 0 25px rgba(0,0,0,0.15);">
    <!-- Mobile Menu Header -->
    <div style="background: #000000; color: #ffffff; padding: 20px 16px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fa-regular fa-user" style="font-size: 28px;"></i>
            <div>
                @if(session()->has('customer_auth'))
                    <div style="font-size: 14px; font-weight: 800;">Hi, {{ explode(' ', session('customer_auth.name'))[0] }}</div>
                    <a href="{{ route('frontend.account') }}" style="font-size: 11px; color: #4ADE80; text-decoration: underline;">View Account Dashboard</a>
                @else
                    <div style="font-size: 14px; font-weight: 800;">Welcome!</div>
                    <a href="{{ route('frontend.login') }}" style="font-size: 11px; color: #cccccc; text-decoration: underline;">Sign In / Register</a>
                @endif
            </div>
        </div>
        <button onclick="toggleMobileMenu()" style="background: none; border: none; color: #ffffff; font-size: 20px; cursor: pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Mobile Nav Links -->
    <div style="padding: 8px 0;">
        <a href="{{ route('frontend.home') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 600; color: #222222; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-solid fa-house" style="width: 20px; text-align: center; color: #666;"></i> Home
        </a>
        <a href="{{ route('frontend.category', 'all') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 600; color: #222222; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-solid fa-store" style="width: 20px; text-align: center; color: #666;"></i> Shop All
        </a>
        <a href="{{ route('frontend.category', 'new-in') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 700; color: #4ADE80; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-solid fa-sparkles" style="width: 20px; text-align: center;"></i> 🆕 New Arrivals
        </a>
        <a href="{{ route('frontend.category', 'best-sellers') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 700; color: #FFB800; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-solid fa-fire" style="width: 20px; text-align: center;"></i> 🔥 Best Sellers
        </a>
        <a href="{{ route('frontend.category', 'sale') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 800; color: #FA2C19; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-solid fa-tags" style="width: 20px; text-align: center;"></i> 💥 Offers / Sale
        </a>

        <!-- Divider -->
        <div style="padding: 8px 20px; font-size: 10px; font-weight: 800; color: #999999; text-transform: uppercase; letter-spacing: 1px; background: #f7f7f7;">Categories</div>

        @foreach($navCategories as $cat)
            <a href="{{ route('frontend.category', $cat->slug ?: $cat->id) }}" class="mobile-nav-link" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; font-size: 13px; font-weight: 500; color: #333333; border-bottom: 1px solid #f5f5f5; text-decoration: none;">
                <span>{{ $cat->name }}</span>
                @if($cat->badge)
                    <span style="font-size: 9px; font-weight: 800; background: #FA2C19; color: #fff; padding: 1px 5px; border-radius: 2px;">{{ $cat->badge }}</span>
                @else
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
                @endif
            </a>
        @endforeach

        <!-- Divider -->
        <div style="padding: 8px 20px; font-size: 10px; font-weight: 800; color: #999999; text-transform: uppercase; letter-spacing: 1px; background: #f7f7f7;">More</div>

        <a href="{{ url('/blog') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 600; color: #222222; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-regular fa-newspaper" style="width: 20px; text-align: center; color: #666;"></i> Blog
        </a>
        <a href="{{ url('/contact') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 600; color: #222222; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-regular fa-envelope" style="width: 20px; text-align: center; color: #666;"></i> Contact Us
        </a>
        <a href="{{ route('frontend.track_order') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 700; color: #0284c7; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-solid fa-truck-fast" style="width: 20px; text-align: center; color: #0284c7;"></i> Track Order
        </a>
        <a href="{{ route('frontend.wishlist') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 600; color: #222222; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-regular fa-heart" style="width: 20px; text-align: center; color: #FA2C19;"></i> My Wishlist
        </a>
        <a href="{{ route('frontend.login') }}" class="mobile-nav-link" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 600; color: #222222; border-bottom: 1px solid #f2f2f2; text-decoration: none;">
            <i class="fa-regular fa-user" style="width: 20px; text-align: center; color: #666;"></i> My Account
        </a>
        <div class="mobile-nav-link" onclick="openCartDrawer(); toggleMobileMenu();" style="display: flex; align-items: center; gap: 12px; padding: 13px 20px; font-size: 14px; font-weight: 600; color: #222222; border-bottom: 1px solid #f2f2f2; cursor: pointer;">
            <i class="fa-solid fa-bag-shopping" style="width: 20px; text-align: center; color: #666;"></i> Shopping Cart
        </div>
    </div>
</div>

<style>
    /* Mobile hamburger button - only show on mobile */
    @media (max-width: 900px) {
        .mobile-hamburger-btn { display: flex !important; }
        .desktop-search-container { display: none !important; }
        .mobile-search-row { display: block !important; }
        .first-cate { font-size: 12px !important; }
    }
    /* Mobile nav link hover */
    .mobile-nav-link:hover { background: #f7f7f7; color: #FA2C19 !important; }
    /* Sale pulse animation */
    @keyframes salePulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
</style>

<script>
function toggleMobileMenu() {
    const drawer = document.getElementById('mobileNavDrawer');
    const overlay = document.getElementById('mobileNavOverlay');
    const icon = document.getElementById('hamburgerIcon');
    const isOpen = drawer.style.left === '0px';

    if (isOpen) {
        drawer.style.left = '-320px';
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    } else {
        drawer.style.left = '0px';
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}
</script>