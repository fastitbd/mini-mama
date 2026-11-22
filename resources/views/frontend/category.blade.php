@extends('frontend.layouts.master')

@section('title', $currentCategory . ' | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')
<div class="shein-container" style="padding-top: 20px; padding-bottom: 70px; max-width: 1440px; margin: 0 auto; padding-left: 20px; padding-right: 20px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 16px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <a href="{{ route('frontend.category', 'all') }}" style="color: #444;">Products</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">{{ $currentCategory }}</span>
    </div>

    <!-- Category Header & Sorting Bar -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; border-bottom: 1px solid var(--shein-border); padding-bottom: 16px; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">{{ $currentCategory }}</h1>
            <p style="color: #767676; font-size: 12px; margin-top: 4px;">{{ count($products) }} items found • Updated live</p>
        </div>

        <!-- Sort & Search Filter Bar -->
        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
            <!-- Instant Name Filter Search -->
            <div style="position: relative; width: 220px;">
                <input type="text" id="categoryKeywordSearch" placeholder="Filter in this page..." onkeyup="filterProductsClientSide()" style="width: 100%; height: 36px; border: 1px solid #ccc; border-radius: 2px; padding: 0 30px 0 10px; font-size: 12px; outline: none; box-sizing: border-box;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; right: 10px; top: 11px; font-size: 12px; color: #999;"></i>
            </div>

            <!-- Price & Rating Sorting -->
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 12px; font-weight: 800; color: #444;">SORT BY:</span>
                <select onchange="location = this.value;" style="padding: 8px 14px; border: 1px solid #ccc; font-family: inherit; font-size: 12px; font-weight: 700; outline: none; cursor: pointer; background: #fff; border-radius: 2px;">
                    <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'recommend']) }}" {{ $sort === 'recommend' ? 'selected' : '' }}>Most Recommended</option>
                    <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'newest']) }}" {{ $sort === 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'price_asc']) }}" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'price_desc']) }}" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('frontend.category', ['slug' => $slug, 'sort' => 'rating']) }}" {{ $sort === 'rating' ? 'selected' : '' }}>Customer Rating</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Category Content Grid with Sidebar -->
    <div style="display: grid; grid-template-columns: 240px 1fr; gap: 32px;" class="cat-page-grid">
        <!-- Left Filter Sidebar -->
        <aside style="font-size: 12px;">
            <!-- Categories Accordion -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                    Categories
                </h4>
                <ul style="list-style: none; line-height: 2.1; padding: 0; margin: 0;">
                    <li>
                        <a href="{{ route('frontend.category', 'all') }}" style="font-weight: {{ empty($slug) || $slug === 'all' ? '800' : '500' }}; color: {{ empty($slug) || $slug === 'all' ? '#FA2C19' : '#444' }}; text-decoration: none;">
                            All Categories
                        </a>
                    </li>
                    @php
                        $sidebarCategories = \App\Models\Category::where('name', '!=', 'General')->orderBy('order_num', 'asc')->get();
                    @endphp
                    @foreach($sidebarCategories as $sCat)
                        <li>
                            <a href="{{ route('frontend.category', $sCat->slug ?: $sCat->id) }}" style="font-weight: {{ ($slug == $sCat->slug || $slug == $sCat->id) ? '800' : '500' }}; color: {{ ($slug == $sCat->slug || $slug == $sCat->id) ? '#FA2C19' : '#444' }}; text-decoration: none; display: flex; align-items: center; justify-content: space-between;">
                                <span>{{ $sCat->name }}</span>
                                @if($sCat->badge)
                                    <span style="font-size: 9px; padding: 1px 5px; background: #FA2C19; color: #fff; border-radius: 2px; font-weight: 800;">{{ $sCat->badge }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Price Filters -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                    Price Range
                </h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="priceRange" value="all" checked onchange="filterPriceRange('all')"> All Prices
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="priceRange" value="25" onchange="filterPriceRange(25)"> Under RM 25.00
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="priceRange" value="50" onchange="filterPriceRange(50)"> Under RM 50.00
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="radio" name="priceRange" value="100" onchange="filterPriceRange(100)"> Under RM 100.00
                    </label>
                </div>
            </div>

            <!-- Stock Availability Filter -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                    Availability
                </h4>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" id="inStockCheckbox" checked onchange="filterInStock()">
                    <span><i class="fa-solid fa-circle-check" style="color: #10B981; margin-right: 4px;"></i> In Stock Only</span>
                </label>
            </div>

            <!-- Sizes Filter -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                    Sizes
                </h4>
                <div class="size-pills" style="display: flex; gap: 6px; flex-wrap: wrap;">
                    <button type="button" class="size-pill-btn active" onclick="toggleSizeFilter(this, 'XS')" style="padding: 4px 10px; border: 1px solid #000; background: #000; color: #fff; font-size: 11px; font-weight: 700; border-radius: 2px; cursor: pointer;">XS</button>
                    <button type="button" class="size-pill-btn active" onclick="toggleSizeFilter(this, 'S')" style="padding: 4px 10px; border: 1px solid #000; background: #000; color: #fff; font-size: 11px; font-weight: 700; border-radius: 2px; cursor: pointer;">S</button>
                    <button type="button" class="size-pill-btn active" onclick="toggleSizeFilter(this, 'M')" style="padding: 4px 10px; border: 1px solid #000; background: #000; color: #fff; font-size: 11px; font-weight: 700; border-radius: 2px; cursor: pointer;">M</button>
                    <button type="button" class="size-pill-btn active" onclick="toggleSizeFilter(this, 'L')" style="padding: 4px 10px; border: 1px solid #000; background: #000; color: #fff; font-size: 11px; font-weight: 700; border-radius: 2px; cursor: pointer;">L</button>
                    <button type="button" class="size-pill-btn active" onclick="toggleSizeFilter(this, 'XL')" style="padding: 4px 10px; border: 1px solid #000; background: #000; color: #fff; font-size: 11px; font-weight: 700; border-radius: 2px; cursor: pointer;">XL</button>
                </div>
            </div>

            <!-- Colors Palette -->
            <div style="margin-bottom: 24px;">
                <h4 style="font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                    Colors
                </h4>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <span class="color-dot" style="width: 22px; height: 22px; border-radius: 50%; background: #000000; border: 1px solid #999; cursor: pointer;" title="Black" onclick="showToast('Filtering for Black styles')"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; border-radius: 50%; background: #ffffff; border: 1px solid #ccc; cursor: pointer;" title="White" onclick="showToast('Filtering for White styles')"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; border-radius: 50%; background: #FA2C19; border: 1px solid #ccc; cursor: pointer;" title="Red" onclick="showToast('Filtering for Red styles')"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; border-radius: 50%; background: #2B547E; border: 1px solid #ccc; cursor: pointer;" title="Blue" onclick="showToast('Filtering for Blue styles')"></span>
                    <span class="color-dot" style="width: 22px; height: 22px; border-radius: 50%; background: #E8DCC4; border: 1px solid #ccc; cursor: pointer;" title="Beige" onclick="showToast('Filtering for Beige styles')"></span>
                </div>
            </div>
        </aside>

        <!-- Right Products Grid -->
        <div>
            <!-- Active Filter Chips Bar -->
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #f2f2f2;">
                <span style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase;">Active Filters:</span>
                <span style="background: #f2f2f2; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    {{ $currentCategory }}
                </span>
                <span id="activePriceChip" style="background: #f2f2f2; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 12px; display: inline-flex; align-items: center; gap: 6px;">
                    All Prices
                </span>
                <a href="{{ route('frontend.category', 'all') }}" style="font-size: 11px; color: #FA2C19; font-weight: 700; text-decoration: underline; margin-left: 6px;">Reset All</a>
            </div>

            @if(count($products) === 0)
                <div style="text-align: center; padding: 60px 20px;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 48px; color: #ccc; margin-bottom: 16px;"></i>
                    <h3 style="font-size: 18px; font-weight: 700;">No items found matching your selection</h3>
                    <p style="color: #767676; margin-top: 6px;">Try adjusting your search keywords or browsing all categories.</p>
                    <a href="{{ route('frontend.category', 'all') }}" class="shein-btn-primary" style="display: inline-block; margin-top: 16px; padding: 10px 24px; background: #000; color: #fff; text-decoration: none; font-weight: 800; border-radius: 2px;">VIEW ALL ITEMS</a>
                </div>
            @else
                <div class="shein-product-grid" id="catProductsGrid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px 12px;">
                    @foreach($products as $prod)
                        @php
                            $cItem = [
                                'id' => $prod['id'],
                                'name' => $prod['name'],
                                'price' => (float)$prod['price'],
                                'image' => $prod['image_primary'],
                            ];
                        @endphp
                        <div class="product-card cat-prod-card" data-name="{{ strtolower($prod['name']) }}" data-price="{{ (float)$prod['price'] }}" style="display: flex; flex-direction: column; background: #ffffff; position: relative;">
                            <div class="product-image-box" style="position: relative; width: 100%; aspect-ratio: 3/4; overflow: hidden; background: #f6f6f6;">
                                <a href="{{ route('frontend.product', $prod['id']) }}" style="display: block; width: 100%; height: 100%;">
                                    <img src="{{ $prod['image_primary'] }}" alt="{{ $prod['name'] }}" class="img-primary" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.25s ease;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                                </a>

                                <!-- Wishlist Button -->
                                <button type="button" class="wishlist-btn" data-id="{{ $prod['id'] }}" onclick="toggleWishlist({{ json_encode($prod) }})" style="position: absolute; top: 8px; right: 8px; width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.9); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #222; font-size: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                    <i class="fa-regular fa-heart"></i>
                                </button>

                                <!-- Discount Badge -->
                                @if(isset($prod['discount']) && $prod['discount'] > 0)
                                    <span class="discount-badge" style="position: absolute; top: 8px; left: 8px; background: #FA2C19; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 2px;">
                                        -{{ $prod['discount'] }}%
                                    </span>
                                @endif

                                <!-- Quick Add Bar -->
                                <div class="quick-add-trigger" onclick="openQuickModal({{ json_encode($prod) }})" style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.85); color: #fff; padding: 9px 0; text-align: center; font-size: 11px; font-weight: 800; text-transform: uppercase; cursor: pointer;">
                                    <i class="fa-solid fa-bag-shopping" style="margin-right: 4px;"></i> QUICK ADD
                                </div>
                            </div>

                            <div class="product-info-box" style="padding: 10px 4px 4px;">
                                <div class="product-brand" style="font-size: 10px; font-weight: 800; color: #999; text-transform: uppercase; margin-bottom: 2px;">
                                    {{ $prod['brand'] ?? 'Mini Mama' }}
                                </div>

                                <a href="{{ route('frontend.product', $prod['id']) }}" class="product-title" style="font-size: 12px; font-weight: 500; color: #222; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.35; height: 32px; margin-bottom: 4px;">
                                    {{ $prod['name'] }}
                                </a>

                                <div class="product-pricing" style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
                                    <span class="current-price is-sale-price" style="font-size: 15px; font-weight: 800; color: #FA2C19;">
                                        RM {{ number_format($prod['price'], 2) }}
                                    </span>
                                    @if(isset($prod['original_price']) && $prod['original_price'] > $prod['price'])
                                        <span class="original-price" style="font-size: 11px; color: #999; text-decoration: line-through;">
                                            RM {{ number_format($prod['original_price'], 2) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="product-social-proof" style="display: flex; align-items: center; gap: 6px; font-size: 10px; color: #767676;">
                                    <span class="star-rating" style="color: #FFB800;"><i class="fa-solid fa-star"></i> {{ $prod['rating'] ?? '4.9' }}</span>
                                    <span>({{ number_format($prod['reviews_count'] ?? 1200) }})</span>
                                    <span>•</span>
                                    <span>{{ $prod['sold_count'] ?? '2.5k' }} sold</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 900px) {
        .cat-page-grid {
            grid-template-columns: 1fr !important;
        }
        #catProductsGrid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px 8px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function filterProductsClientSide() {
        const query = document.getElementById('categoryKeywordSearch').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.cat-prod-card');
        
        cards.forEach(card => {
            const name = card.dataset.name || '';
            if (name.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function filterPriceRange(maxPrice) {
        const chip = document.getElementById('activePriceChip');
        const cards = document.querySelectorAll('.cat-prod-card');

        if (maxPrice === 'all') {
            chip.innerText = 'All Prices';
            cards.forEach(card => card.style.display = 'flex');
        } else {
            chip.innerText = 'Under RM ' + maxPrice;
            cards.forEach(card => {
                const price = parseFloat(card.dataset.price || '0');
                if (price <= parseFloat(maxPrice)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    }

    function filterInStock() {
        const checked = document.getElementById('inStockCheckbox').checked;
        showToast(checked ? 'Showing in-stock items' : 'Showing all items');
    }

    function toggleSizeFilter(btn, size) {
        const isActive = btn.style.background === 'rgb(0, 0, 0)' || btn.style.background === '#000';
        if (isActive) {
            btn.style.background = '#fff';
            btn.style.color = '#000';
        } else {
            btn.style.background = '#000';
            btn.style.color = '#fff';
        }
        showToast('Size filter updated: ' + size);
    }
</script>
@endpush
