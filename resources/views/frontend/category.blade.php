@extends('frontend.layouts.master')

@section('title', $currentCategory . ' | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')
<div class="shein-container" style="padding-top: 20px; padding-bottom: 70px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 16px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <a href="{{ route('frontend.category', 'all') }}" style="color: #444;">Clothing</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">{{ $currentCategory }}</span>
    </div>

    <!-- Category Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; border-bottom: 1px solid var(--shein-border); padding-bottom: 16px; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">{{ $currentCategory }}</h1>
            <p style="color: #767676; font-size: 12px; margin-top: 4px;">{{ count($products) }} items found • Updated every hour</p>
        </div>

        <!-- Sort Filter -->
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 12px; font-weight: 700; color: #666;">SORT BY:</span>
            <select onchange="location = this.value;" style="padding: 7px 14px; border: 1px solid #ccc; font-family: inherit; font-size: 12px; font-weight: 700; outline: none; cursor: pointer; background: #fff;">
                <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'recommend']) }}" {{ $sort === 'recommend' ? 'selected' : '' }}>Most Recommended</option>
                <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'price_asc']) }}" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'price_desc']) }}" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'rating']) }}" {{ $sort === 'rating' ? 'selected' : '' }}>Customer Rating</option>
            </select>
        </div>
    </div>

    <!-- Category Content Grid with Sidebar -->
    <div style="display: grid; grid-template-columns: 240px 1fr; gap: 32px;">
        <!-- Left Filter Sidebar -->
        <aside style="font-size: 12px;">
            <!-- Categories Accordion -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">Category</h4>
                <ul style="list-style: none; line-height: 2.1; padding: 0; margin: 0;">
                    <li><a href="{{ route('frontend.category', 'all') }}" style="font-weight: {{ empty($slug) || $slug === 'all' ? '800' : '500' }}; color: {{ empty($slug) || $slug === 'all' ? 'var(--shein-red)' : '#444' }};">All Categories</a></li>
                    @php
                        $sidebarCategories = \App\Models\Category::where('name', '!=', 'General')->orderBy('order_num', 'asc')->get();
                    @endphp
                    @foreach($sidebarCategories as $sCat)
                        <li>
                            <a href="{{ route('frontend.category', $sCat->slug ?: $sCat->id) }}" style="font-weight: {{ ($slug == $sCat->slug || $slug == $sCat->id) ? '800' : '500' }}; color: {{ ($slug == $sCat->slug || $slug == $sCat->id) ? 'var(--shein-red)' : '#444' }};">
                                {{ $sCat->name }}
                                @if($sCat->badge)
                                    <span style="font-size: 9px; padding: 1px 4px; background: #FA2C19; color: #fff; border-radius: 2px; font-weight: 800; margin-left: 4px;">{{ $sCat->badge }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Price Filters -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">Price Range</h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" checked> Under RM 20.00</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" checked> RM 20.00 - RM 40.00</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" checked> RM 40.00 - RM 80.00</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox"> RM 80.00 & Above</label>
                </div>
            </div>

            <!-- Size Filter -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">Sizes</h4>
                <div class="size-pills">
                    <button type="button" class="size-pill-btn active" onclick="this.classList.toggle('active')">XS</button>
                    <button type="button" class="size-pill-btn active" onclick="this.classList.toggle('active')">S</button>
                    <button type="button" class="size-pill-btn active" onclick="this.classList.toggle('active')">M</button>
                    <button type="button" class="size-pill-btn active" onclick="this.classList.toggle('active')">L</button>
                    <button type="button" class="size-pill-btn" onclick="this.classList.toggle('active')">XL</button>
                    <button type="button" class="size-pill-btn" onclick="this.classList.toggle('active')">Plus</button>
                </div>
            </div>

            <!-- Color Palette Filter -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">Colors</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <span class="color-dot" style="width: 22px; height: 22px; background: #000000; border: 1px solid #999;" title="Black"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; background: #ffffff; border: 1px solid #ccc;" title="White"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; background: #FA2C19; border: 1px solid #ccc;" title="Red"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; background: #2B547E; border: 1px solid #ccc;" title="Blue"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; background: #F4C2C2; border: 1px solid #ccc;" title="Pink"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; background: #E8DCC4; border: 1px solid #ccc;" title="Beige"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; background: #2E8B57; border: 1px solid #ccc;" title="Green"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; background: #FFDB58; border: 1px solid #ccc;" title="Yellow"></span>
                </div>
            </div>

            <!-- Style Tags -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">Style</h4>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" checked> Casual Commute</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox" checked> Elegant French</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox"> Bohemian Beach</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox"> Y2K Streetwear</label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;"><input type="checkbox"> Minimalist Chic</label>
                </div>
            </div>
        </aside>

        <!-- Right Products Grid -->
        <div>
            <!-- Active Filter Chips -->
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #f2f2f2;">
                <span style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase;">Active Filters:</span>
                <span style="background: #f2f2f2; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    {{ $currentCategory }} <i class="fa-solid fa-xmark" style="cursor: pointer;"></i>
                </span>
                <span style="background: #f2f2f2; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    Under RM 80 <i class="fa-solid fa-xmark" style="cursor: pointer;"></i>
                </span>
                <span style="background: #f2f2f2; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    In Stock <i class="fa-solid fa-xmark" style="cursor: pointer;"></i>
                </span>
                <a href="{{ route('frontend.category', 'all') }}" style="font-size: 11px; color: var(--shein-red); font-weight: 700; text-decoration: underline; margin-left: 6px;">Clear All</a>
            </div>

            @if(count($products) === 0)
                <div style="text-align: center; padding: 60px 20px;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 48px; color: #ccc; margin-bottom: 16px;"></i>
                    <h3 style="font-size: 18px; font-weight: 700;">No items found matching your filter</h3>
                    <p style="color: #767676; margin-top: 6px;">Try browsing our popular categories or clearing filters.</p>
                    <a href="{{ route('frontend.category', 'all') }}" class="shein-btn-primary" style="display: inline-block; margin-top: 16px; padding: 10px 24px;">VIEW ALL ITEMS</a>
                </div>
            @else
                <div class="shein-product-grid" style="grid-template-columns: repeat(4, 1fr);">
                    @foreach($products as $prod)
                        <div class="product-card">
                            <div class="product-image-box">
                                <a href="{{ route('frontend.product', $prod['id']) }}">
                                    <img src="{{ $prod['image_primary'] }}" alt="{{ $prod['name'] }}" class="img-primary" loading="lazy">
                                    <img src="{{ $prod['image_hover'] }}" alt="{{ $prod['name'] }}" class="img-hover" loading="lazy">
                                </a>

                                <!-- Wishlist Button -->
                                <button type="button" class="wishlist-btn" data-id="{{ $prod['id'] }}" onclick="toggleWishlist({{ json_encode($prod) }})">
                                    <i class="fa-regular fa-heart"></i>
                                </button>

                                <!-- Discount Tag -->
                                @if(isset($prod['discount']) && $prod['discount'] > 0)
                                    <span class="discount-badge">-{{ $prod['discount'] }}%</span>
                                @endif

                                <!-- Quick Add -->
                                <div class="quick-add-trigger" onclick="openQuickModal({{ json_encode($prod) }})">
                                    <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                                </div>
                            </div>

                            <div class="product-info-box">
                                <div class="color-swatches">
                                    @foreach($prod['colors'] as $color)
                                        <span class="color-dot" style="background-color: {{ $color }};"></span>
                                    @endforeach
                                </div>

                                <div class="product-brand">{{ $prod['brand'] }}</div>

                                <a href="{{ route('frontend.product', $prod['id']) }}" class="product-title">
                                    {{ $prod['name'] }}
                                </a>

                                <div class="product-pricing">
                                    <span class="current-price is-sale-price">RM {{ number_format($prod['price'], 2) }}</span>
                                    <span class="original-price">RM {{ number_format($prod['original_price'], 2) }}</span>
                                    <span class="pct-discount">-{{ $prod['discount'] }}%</span>
                                </div>

                                <div class="product-social-proof">
                                    <span class="star-rating"><i class="fa-solid fa-star"></i> {{ $prod['rating'] }}</span>
                                    <span>({{ number_format($prod['reviews_count']) }})</span>
                                    <span>•</span>
                                    <span>{{ $prod['sold_count'] }} sold</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination / Load More -->
                <div style="text-align: center; margin-top: 50px;">
                    <button type="button" class="shein-btn-primary" style="padding: 12px 40px; font-size: 13px; background: #fff; color: #000; border: 2px solid #000;" onclick="showToast('Loading next 40 items...')">
                        LOAD MORE ITEMS
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
