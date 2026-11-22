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
            <span style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #ffffff;" onclick="showToast('🇲🇾 Shipping to: Malaysia | Currency: RM / MYR')">🇲🇾 MY / RM</span>
            <span style="display: flex; align-items: center; gap: 4px; cursor: pointer; color: #cccccc;" onclick="showToast('24/7 ' + {!! json_encode(get_setting('com_name') ?: 'FAST IT') !!} + ' Customer Help Center')"><i class="fa-regular fa-circle-question"></i> Help</span>
        </div>
    </div>

    <!-- 2. MAIN HEADER BAR (BLACK BACKGROUND & WHITE ICONS/LOGO) -->
    <div style="background: #000000; border-bottom: 1px solid rgba(255,255,255,0.12);">
        <div class="shein-wrap" style="max-width: 1440px; margin: 0 auto; padding: 0 20px; height: 60px; display: flex; align-items: center; justify-content: space-between; gap: 24px;">
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

            <!-- Search Form -->
            <div style="flex: 1; max-width: 620px; position: relative;">
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
                    <a href="{{ route('frontend.login') }}" style="color: #ffffff; display: flex; align-items: center; font-size: 22px;" title="Account">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    <!-- Flyout Dropdown -->
                    <div class="bsc-user-container__dropdown" id="sheinUserDropdown" style="display: none; position: absolute; top: 100%; right: 0; width: 230px; background: #ffffff; box-shadow: 0 10px 25px rgba(0,0,0,0.25); border: 1px solid #eeeeee; padding: 16px; z-index: 1003; margin-top: 10px; border-radius: 2px;">
                        <a href="{{ route('frontend.login') }}" style="display: block; background: #000000; color: #ffffff; text-align: center; padding: 10px 0; font-weight: 800; font-size: 12px; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">SIGN IN / REGISTER</a>
                        <div style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #333333;">
                            <a href="{{ route('frontend.wishlist') }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-regular fa-heart" style="margin-right: 8px;"></i> My Wishlist</span> <span style="color: #FA2C19; font-weight: 700;">❤️</span></a>
                            <a href="{{ route('frontend.cart') }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-solid fa-bag-shopping" style="margin-right: 8px;"></i> Shopping Bag</span></a>
                            <a href="{{ route('frontend.category', 'sale') }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5; color: #FA2C19; font-weight: 700;"><span><i class="fa-solid fa-fire" style="margin-right: 8px;"></i> Flash Sale</span></a>
                            <a href="{{ route('frontend.login') }}" style="padding: 6px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f5f5f5;"><span><i class="fa-solid fa-ticket" style="margin-right: 8px;"></i> My Coupons</span></a>
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
                    @foreach($navCategories as $cat)
                        @php
                            $isHot = ($cat->badge || \Illuminate\Support\Str::contains(strtolower($cat->name), 'sale'));
                        @endphp
                        <a href="{{ route('frontend.category', $cat->slug ?: $cat->id) }}" style="font-size: 12px; font-weight: {{ $isHot ? '900' : '700' }}; color: {{ $isHot ? '#FA2C19' : '#ffffff' }}; text-decoration: none; padding: 4px 0; flex-shrink: 0;">
                            {{ $cat->name }}
                        </a>
                    @endforeach
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