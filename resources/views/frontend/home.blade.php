@extends('frontend.layouts.master')

@section('title', 'Shop The Latest Styles | Fashion Clothes for Women, Men & Kids Online | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')

    <!-- 1. OFFICIAL TRENDS CAROUSEL, CATEGORIES & SUPER DEALS -->
    @php
        $heroBanners = \App\Models\Banner::where('status', 1)
            ->where(function($q) {
                $q->whereNull('banner_type')
                  ->orWhereIn('banner_type', ['slider', 'image', 'trend', 'promo']);
            })
            ->orderBy('order_num', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    @endphp

    <div class="cccx-comp-container home-index__ccc-content home-index__1" style="max-width: 1440px; margin: 0 auto; padding: 0 16px;">
        <div class="cccx-comp-container home-index__ccc-content home-index__1 home-index__ccc-content home-index__1" id="main" role="main" data-v-49c16825>
            <div class="new-h1-carousel" style="--crop-img-fit:cover;">
                <swiper-container navigation="true" pagination="true" loop="true" autoplay-delay="4500" class="new-h1-carousel__swiper-container">
                    @forelse($heroBanners as $banner)
                        <swiper-slide class="new-h1-carousel__swiper-slide home-a11y-focus__overflow" role="link" tabindex="0" aria-label="{{ $banner->title ?: 'Banner' }}">
                            @if(($banner->banner_type == 'image' || (empty($banner->title) && empty($banner->subtitle))) && $banner->image)
                                {{-- Full Graphic Hero Banner Image Mode --}}
                                <div class="new-trends-frame hero-graphic-banner" style="--new-trends-frame-max-height:340px; height: 25vw; max-height: 340px; min-height: 180px; background: {{ $banner->bg_color ?: '#111111' }}; overflow:hidden; border-radius:4px; position:relative; display:flex; align-items:center; justify-content:center;">
                                    {{-- Ambient blur backdrop for seamless aspect-ratio fitting --}}
                                    <div style="position: absolute; inset: -20px; background-image: url('{{ $banner->image_url }}'); background-size: cover; background-position: center; filter: blur(25px) brightness(0.45); opacity: 0.75; z-index: 1; pointer-events: none;"></div>
                                    <a href="{{ $banner->btn_url ?: 'javascript:void(0)' }}" style="position: relative; z-index: 2; display:flex; align-items:center; justify-content:center; width:100%; height:100%; text-decoration: none;">
                                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?: 'Banner' }}" style="max-width:100%; max-height:100%; width:100%; height:100%; object-fit:contain; display:block;">
                                    </a>
                                </div>
                            @else
                                {{-- Official Fashion & Trend Promo Frame Mode --}}
                                <div class="new-trends-frame" style="--new-trends-frame-max-height:340px; background: {{ $banner->bg_color ?: 'linear-gradient(135deg, #111111 0%, #2a0808 100%)' }};">
                                    @if($banner->image)
                                    <div class="new-trends-frame__bg not-fsp-element">
                                        <div class="base-img new-trends-frame__bg_product-mask">
                                            <a href="{{ $banner->btn_url ?: 'javascript:;' }}" style="padding-bottom:100.00%;" class="base-img__href" aria-hidden="true" tabindex="-1">
                                                <img style="object-position:initial;" class="base-img__initial fsp__h1-carousel-trends-product-mask base-img__inner fsp-element" src="{{ $banner->image_url }}" alt="{{ $banner->title }}" fetchpriority="auto">
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="new-trends-frame__main-content">
                                        <div class="new-trends-frame__content" style="padding-left: {{ $banner->image ? '40px' : '60px' }};">
                                            @if($banner->title)
                                                <div style="font-size: 34px; font-weight: 900; color: #FA2C19; letter-spacing: 1.5px; text-transform: uppercase; line-height: 1.1;">
                                                    {{ $banner->title }}
                                                </div>
                                            @endif
                                            @if($banner->subtitle)
                                                <div style="font-size: 15px; font-weight: 700; color: #ffffff; margin: 8px 0 16px; text-transform: uppercase; letter-spacing: 0.8px;">
                                                    {{ $banner->subtitle }}
                                                </div>
                                            @endif
                                            @if($banner->btn_text)
                                                <a href="{{ $banner->btn_url ?: route('frontend.category', 'sale') }}" style="background: #FA2C19; color: #fff; font-size: 12px; font-weight: 800; padding: 10px 24px; border-radius: 2px; display: inline-block; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none;">
                                                    {{ $banner->btn_text }}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="new-trends-frame__products">
                                            <div class="new-trends-frame__product">
                                                <div class="new-trends-frame__product_wrapper">
                                                    <div class="product-card home-product home-a11y-focus__overflow" role="link" tabindex="0" onclick="window.location='{{ route('frontend.product', 101) }}'" style="cursor:pointer;">
                                                        <div class="product-card__top-wrapper">
                                                            <a class="S-product-card__img-container j-expose__product-item-img" target="_self">
                                                                <div class="crop-image-container" style="padding-bottom:calc(1.33 * 100%);">
                                                                    <img class="crop-image-container__img" src="//img.ltwebstatic.com/v4/j/pi/2026/05/15/8e/1778816995e36d114cb0fcff5c38094ed34b3bdbc8_thumbnail_336x.jpg" alt="Item">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="product-card__bottom-wrapper">
                                                            <div class="bottom-wrapper__price-wrapper">
                                                                <div class="bff-price-container">
                                                                    <p class="product-item__camecase-wrap prices-info__sale-price"><span style="color:#FA2C19;" class="product-item__camecase-price fs-12">RM<span style="margin-left:1px;" class="product-item__price-integer fs-26">17</span><span class="product-item__price-decimal">.00</span></span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="new-trends-frame__product">
                                                <div class="new-trends-frame__product_wrapper">
                                                    <div class="product-card home-product home-a11y-focus__overflow" role="link" tabindex="0" onclick="window.location='{{ route('frontend.product', 106) }}'" style="cursor:pointer;">
                                                        <div class="product-card__top-wrapper">
                                                            <a class="S-product-card__img-container j-expose__product-item-img" target="_self">
                                                                <div class="crop-image-container" style="padding-bottom:calc(1.33 * 100%);">
                                                                    <img class="crop-image-container__img" src="//img.ltwebstatic.com/v4/j/pi/2026/07/13/ef/1783914564d3354215598b114b225c0b8381537a2c_thumbnail_336x.jpg" alt="Item">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="product-card__bottom-wrapper">
                                                            <div class="bottom-wrapper__price-wrapper">
                                                                <div class="bff-price-container">
                                                                    <p class="product-item__camecase-wrap prices-info__sale-price"><span style="color:#FA2C19;" class="product-item__camecase-price fs-12">RM<span style="margin-left:1px;" class="product-item__price-integer fs-26">74</span><span class="product-item__price-decimal">.88</span></span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="new-trends-frame__product">
                                                <div class="new-trends-frame__product_wrapper">
                                                    <div class="product-card home-product home-a11y-focus__overflow" role="link" tabindex="0" onclick="window.location='{{ route('frontend.product', 102) }}'" style="cursor:pointer;">
                                                        <div class="product-card__top-wrapper">
                                                            <a class="S-product-card__img-container j-expose__product-item-img" target="_self">
                                                                <div class="crop-image-container" style="padding-bottom:calc(1.33 * 100%);">
                                                                    <img class="crop-image-container__img" src="//img.ltwebstatic.com/v4/j/dps/PS202608294371/6a38d702b96c559955be23591e86147f17d0c7fa4a710b6af11d7fed64000c4e_thumbnail_336x.jpg" alt="Item">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="product-card__bottom-wrapper">
                                                            <div class="bottom-wrapper__price-wrapper">
                                                                <div class="bff-price-container">
                                                                    <p class="product-item__camecase-wrap prices-info__sale-price"><span style="color:#000000;" class="product-item__camecase-price fs-12">RM<span style="margin-left:1px;" class="product-item__price-integer fs-26">28</span><span class="product-item__price-decimal">.00</span></span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </swiper-slide>
                    @empty
                        <swiper-slide class="new-h1-carousel__swiper-slide home-a11y-focus__overflow" role="link" tabindex="0" aria-label="10.10 SALE">
                            <div class="new-trends-frame" style="--new-trends-frame-max-height:340px; background:linear-gradient(135deg, #111 0%, #2a0808 100%);">
                                <div class="new-trends-frame__bg not-fsp-element">
                                    <div class="base-img new-trends-frame__bg_product-mask">
                                        <a href="{{ route('frontend.category', 'sale') }}" style="padding-bottom:100.00%;" class="base-img__href">
                                            <img class="base-img__initial base-img__inner" src="//img.ltwebstatic.com/v4/p/ccc/2025/07/22/ca/1753167507387a524d78a380f1105ff2cdcba09dcb_thumbnail_432x.webp" alt="sale">
                                        </a>
                                    </div>
                                </div>
                                <div class="new-trends-frame__main-content">
                                    <div class="new-trends-frame__content" style="padding-left:40px;">
                                        <div style="font-size:38px; font-weight:900; color:#FA2C19; letter-spacing:2px; text-transform:uppercase; line-height:1;">10.10 BIG SALE</div>
                                        <div style="font-size:16px; font-weight:700; color:#ffffff; margin:6px 0 16px; text-transform:uppercase; letter-spacing:1px;">UP TO 85% OFF EVERYTHING</div>
                                        <a href="{{ route('frontend.category', 'sale') }}" style="background:#FA2C19; color:#fff; font-size:12px; font-weight:800; padding:10px 24px; border-radius:2px; display:inline-block; text-transform:uppercase; letter-spacing:0.5px;">SHOP DEALS NOW</a>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    @endforelse
                </swiper-container>
            </div>
        </div>
    </div>@php
    $homeCategories = \App\Models\Category::where('name', '!=', 'General')
        ->whereNotNull('image')
        ->orderBy('order_num', 'asc')
        ->orderBy('id', 'asc')
        ->get();
    if ($homeCategories->isEmpty()) {
        $homeCategories = \App\Models\Category::where('name', '!=', 'General')->orderBy('order_num', 'asc')->orderBy('id', 'asc')->get();
    }
    
    // Fallback safeguard: if total categories is ever less than 24 (8 columns x 3 rows),
    // automatically complement with circular image subcategories so the 8 columns are always 100% full without empty gaps!
    $displayItems = $homeCategories;
    if ($displayItems->count() < 24) {
        $needed = 24 - $displayItems->count();
        $extraSubs = \App\Models\SubCategory::whereNotNull('image')
            ->orderBy('order_num', 'asc')
            ->orderBy('id', 'asc')
            ->take($needed)
            ->get();
        if ($extraSubs->isNotEmpty()) {
            $displayItems = $displayItems->concat($extraSubs);
        }
    }
@endphp

<div class="category-recommend-wrapper" style="background:#F6F6F6; padding: 16px 0;" data-component-name="CATEGORY_RECOMMEND_COMPONENT_1" data-v-327bff7f>
    <div style="position:relative;">
        <button type="button" class="category-swiper-btn-prev" onclick="document.querySelector('.category-recommend-dynamic__swiper').swiper.slidePrev()" style="position:absolute; left:0; top:50%; transform:translateY(-50%); width:32px; height:32px; background:#fff; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.15); z-index:10; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fa-solid fa-chevron-left" style="font-size:12px;"></i></button>
        <button type="button" class="category-swiper-btn-next" onclick="document.querySelector('.category-recommend-dynamic__swiper').swiper.slideNext()" style="position:absolute; right:0; top:50%; transform:translateY(-50%); width:32px; height:32px; background:#fff; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.15); z-index:10; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fa-solid fa-chevron-right" style="font-size:12px;"></i></button>
        
        <swiper-container class-name="linear-mode" class="category-recommend-dynamic__swiper" slides-per-view="auto" space-between="12" observer="true" data-v-327bff7f>
            @foreach($displayItems->chunk(3) as $catChunk)
                <swiper-slide class="category-recommend-dynamic__slide" data-v-327bff7f>
                    @foreach($catChunk as $index => $cItem)
                        @php
                            $targetUrl = ($cItem instanceof \App\Models\SubCategory)
                                ? (route('frontend.category', $cItem->category_id) . '?subcategory=' . $cItem->id)
                                : route('frontend.category', $cItem->slug ?: $cItem->id);
                        @endphp
                        <div class="category-recommend-dynamic__img_wrapper a11y-focus" da-rid="category_{{ $index }}" role="link" tabindex="0" aria-label="{{ $cItem->name }}" data-v-327bff7f>
                            <div class="base-img category-recommend-dynamic__img" style="background-color:#F0EEEC;" data-v-327bff7f>
                                <a href="{{ $targetUrl }}" style="padding-bottom:100.00%;" class="base-img__href" aria-hidden="true" tabindex="-1">
                                    <img style="object-position:initial;" class="base-img__cover fsp__category-recommend-placeholder base-img__inner fsp-element" src="{{ $cItem->image_url }}" alt="{{ $cItem->name }}" fetchpriority="auto">
                                </a>
                            </div>
                            <div style="color:#000000;" class="category-recommend-dynamic__name" data-v-327bff7f>{{ $cItem->name }}</div>
                        </div>
                    @endforeach
                </swiper-slide>
            @endforeach
        </swiper-container>
    </div>
</div>
    <!-- 2. DYNAMIC SUPER DEALS & TRENDS SPLIT SECTIONS -->
    <div class="shein-container" style="max-width: 1440px; margin: 16px auto 0; padding: 0 16px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 14px;">
            {{-- Left Block: SuperDeals / Dynamic Left Section --}}
            <div style="background: #ffffff; border-radius: 6px; padding: 12px 14px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
                <div style="margin-bottom: 10px;">
                    <a href="{{ route('frontend.category', 'sale') }}" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none; width: 100%;">
                        <span style="font-size: 19px; font-weight: 900; font-style: italic; color: #111111; letter-spacing: -0.5px;">
                            {{ $storeSections['super_deals']->name ?? 'SuperDeals' }}
                        </span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #222222;"></i>
                    </a>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    @foreach($superDeals->take(3) as $sd)
                        <div class="super-deal-card" onclick="window.location='{{ route('frontend.product', $sd->id) }}'" style="cursor: pointer; display: flex; flex-direction: column;">
                            <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 2px; overflow: hidden; background: #f6f6f6;">
                                <img src="{{ $sd->image_url }}" alt="{{ $sd->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                            </div>
                            <div style="margin-top: 5px;">
                                <div style="color: #FA2C19; font-size: 14.5px; font-weight: 800; line-height: 1.1;">
                                    <span style="font-size: 10px; font-weight: 700; margin-right: 1px;">RM</span>{{ number_format($sd->selling_price, 2) }}
                                </div>
                                <div style="color: #FA2C19; font-size: 10.5px; font-weight: 700; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $sd->badge ?: ($sd->discount > 0 ? round(($sd->discount / ($sd->dis_selling_price ?: $sd->selling_price)) * 100) . '% OFF' : ($storeSections['super_deals']->badge_text ?? 'Flash Sale')) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Block: trends / Dynamic Right Section --}}
            <div style="background: #ffffff; border-radius: 6px; padding: 12px 14px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
                <div style="margin-bottom: 10px;">
                    <a href="{{ route('frontend.category', 'all') }}" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none; width: 100%;">
                        <span style="font-size: 19px; font-weight: 900; font-style: italic; color: #111111; letter-spacing: -0.5px;">
                            {{ $storeSections['trends']->name ?? 'trends' }}
                        </span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 12px; color: #222222;"></i>
                    </a>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    @foreach($trends->take(3) as $tr)
                        <div class="trend-deal-card" onclick="window.location='{{ route('frontend.product', $tr->id) }}'" style="cursor: pointer; display: flex; flex-direction: column;">
                            <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 2px; overflow: hidden; background: #f6f6f6;">
                                <img src="{{ $tr->image_url }}" alt="{{ $tr->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                            </div>
                            <div style="margin-top: 5px;">
                                <div style="color: #FA2C19; font-size: 14.5px; font-weight: 800; line-height: 1.1;">
                                    <span style="font-size: 10px; font-weight: 700; margin-right: 1px;">RM</span>{{ number_format($tr->selling_price, 2) }}
                                </div>
                                <div style="color: #7952b3; font-size: 10.5px; font-weight: 700; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $tr->badge ?: '#SummerOutfit' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 3. CATEGORY TABS & 5-COLUMN PRODUCT GRID -->
    <section class="shein-product-showcase-section" style="max-width: 1440px; margin: 26px auto 30px; padding: 0 16px;">
        {{-- Category Tabs Bar --}}
        <div class="shein-tab-nav-bar" style="display: flex; justify-content: center; align-items: center; gap: 26px; border-bottom: 1px solid #ebebeb; overflow-x: auto; white-space: nowrap; margin-bottom: 18px; padding-bottom: 0;">
            <button type="button" class="shein-tab-pill active" onclick="switchCategoryTab('women', this)">Women</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('men', this)">Men</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('plus', this)">Plus</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('kids', this)">Kids</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('home', this)">Home & Living</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('beauty', this)">Beauty & Health</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('shoes', this)">Shoes & Bags</button>
        </div>

        {{-- 5-Column Responsive Product Grid --}}
        <div class="shein-card-grid" id="sheinMainProductGrid" style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 14px 10px;">
            @foreach($dbProducts as $prod)
                @php
                    $nameLower = strtolower($prod->name);
                    $catLower = strtolower($prod->category?->name ?? '');

                    $tab = 'women';
                    if (str_contains($nameLower, 'plus') || str_contains($nameLower, 'curve') || str_contains($catLower, 'plus')) {
                        $tab = 'plus';
                    } elseif (str_contains($nameLower, 'kid') || str_contains($nameLower, 'baby') || str_contains($catLower, 'kid')) {
                        $tab = 'kids';
                    } elseif (str_contains($nameLower, 'shoe') || str_contains($nameLower, 'bag') || str_contains($nameLower, 'heel') || str_contains($nameLower, 'mule') || str_contains($catLower, 'shoe') || str_contains($catLower, 'bag') || str_contains($catLower, 'footwear')) {
                        $tab = 'shoes';
                    } elseif (str_contains($nameLower, 'beauty') || str_contains($nameLower, 'makeup') || str_contains($catLower, 'beauty')) {
                        $tab = 'beauty';
                    } elseif (str_contains($nameLower, 'home') || str_contains($nameLower, 'living') || str_contains($catLower, 'home')) {
                        $tab = 'home';
                    } elseif (preg_match('/\bmen(\'s)?\b/i', $nameLower) && !str_contains($nameLower, 'women')) {
                        $tab = 'men';
                    } else {
                        $tab = 'women';
                    }

                    $isSale = ($prod->discount > 0) || !empty($prod->badge) || ($prod->selling_price < $prod->dis_selling_price);
                    $cartItem = [
                        'id' => $prod->id,
                        'name' => $prod->name,
                        'price' => (float)$prod->selling_price,
                        'image' => $prod->image_url,
                    ];
                @endphp
                <div class="shein-product-item" data-tab-group="{{ $tab }}" style="display: flex; flex-direction: column;">
                    {{-- Image --}}
                    <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 2px; overflow: hidden; background: #f6f6f6; cursor: pointer;" onclick="window.location='{{ route('frontend.product', $prod->id) }}'">
                        <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: opacity 0.15s ease;" onmouseover="this.style.opacity='0.92'" onmouseout="this.style.opacity='1'">
                    </div>

                    {{-- Title (1-line truncated with ellipsis) --}}
                    <a href="{{ route('frontend.product', $prod->id) }}" style="font-size: 11px; color: #222222; text-decoration: none; margin-top: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; line-height: 1.3;" title="{{ $prod->name }}">
                        {{ $prod->name }}
                    </a>

                    {{-- Price & Circular Cart Button Row --}}
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 3px;">
                        <div style="font-size: 14.5px; font-weight: 800; color: {{ $isSale ? '#FA2C19' : '#111111' }}; line-height: 1.1;">
                            <span style="font-size: 10px; font-weight: 700; margin-right: 1px;">RM</span>{{ number_format($prod->selling_price, 2) }}
                        </div>

                        {{-- Circular Cart Button --}}
                        <button type="button" class="shein-circle-cart-btn" onclick="event.stopPropagation(); addToBag({{ json_encode($cartItem) }})" style="width: 26px; height: 26px; border-radius: 50%; border: 1.2px solid #222222; background: #ffffff; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0; transition: all 0.2s ease; flex-shrink: 0;" title="{{ __('Add to Bag') }}" onmouseover="this.style.background='#111'; this.querySelector('svg').style.stroke='#fff';" onmouseout="this.style.background='#fff'; this.querySelector('svg').style.stroke='#111';">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#111111" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Load More Link --}}
        <div style="text-align: center; margin-top: 32px;">
            <a href="{{ route('frontend.category', 'all') }}" class="btn-shein-outline" style="display: inline-block; width: auto; padding: 10px 40px; font-weight: 800; font-size: 12.5px; border-radius: 2px;">
                EXPLORE ALL STYLES
            </a>
        </div>
    </section>

    <!-- 4. INTERACTIVE VOUCHERS STRIP -->
    <section class="voucher-strip" style="margin-top: 10px;">
        <div class="shein-container">
            <div class="voucher-grid">
                @foreach($vouchers as $voucher)
                    <div class="voucher-card">
                        <div class="voucher-info">
                            <div class="v-discount">{{ $voucher['discount'] }}</div>
                            <div class="v-cond">{{ $voucher['condition'] }}</div>
                            <div class="v-code">CODE: {{ $voucher['code'] }} • {{ $voucher['expiry'] }}</div>
                        </div>
                        <button type="button" class="voucher-collect-btn" onclick="collectVoucher('{{ $voucher['code'] }}', this)">
                            COLLECT
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. PROMOTIONAL 4-GRID CARDS -->
    <section class="promo-quad-section">
        <div class="shein-container">
            <div class="promo-quad-grid">
                @foreach($promoCards as $card)
                    <a href="{{ $card['link'] }}" class="quad-card">
                        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" loading="lazy">
                        <div class="quad-card-overlay">
                            <span class="quad-tag">{{ $card['tag'] }}</span>
                            <h3 class="quad-title">{{ $card['title'] }}</h3>
                            <p class="quad-sub">{{ $card['subtitle'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. INSTAGRAM GALLERY -->
    <section class="ugc-section">
        <div class="shein-container">
            <div class="section-header" style="justify-content:center; text-align:center; flex-direction:column; gap:4px; margin-bottom:24px;">
                <h3 style="font-size:22px; font-weight:900; letter-spacing:1px; text-transform:uppercase;">#{{ strtoupper(str_replace(' ', '', get_setting('com_name') ?: 'FASTIT')) }}style INSPIRATION</h3>
                <p style="color:#767676; font-size:13px;">Tag @{{ strtolower(str_replace(' ', '', get_setting('com_name') ?: 'fastit')) }}_official on Instagram for a chance to be featured</p>
            </div>

            <div class="ugc-grid">
                @foreach($instagramLooks as $look)
                    <a href="https://instagram.com" target="_blank" class="ugc-card">
                        <img src="{{ $look['image'] }}" alt="{{ $look['author'] }}" loading="lazy">
                        <div class="ugc-hover-overlay">
                            <span><i class="fa-brands fa-instagram"></i> {{ $look['author'] }}</span>
                            <span><i class="fa-solid fa-heart text-red-500"></i> {{ $look['likes'] }}</span>
                            <span style="font-size:10px; text-transform:uppercase; background:rgba(255,255,255,0.2); padding:2px 8px; border-radius:10px;">Shop The Look</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. FLOATING BACK TO TOP BUTTON -->
    <div class="j-up-to-top_container" onclick="window.scrollTo({top:0, behavior:'smooth'})" style="position:fixed; bottom:70px; right:24px; width:44px; height:44px; background:#fff; border-radius:50%; box-shadow:0 4px 14px rgba(0,0,0,0.15); display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:990; border:1px solid #eee; transition:all 0.2s;" title="Back to Top">
        <i class="fa-solid fa-chevron-up" style="color:#000; font-size:16px;"></i>
    </div>

@endsection

@push('styles')
<style>
    .shein-card-grid {
        display: grid !important;
        grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
        gap: 14px 10px !important;
    }
    @media (max-width: 768px) {
        .shein-card-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px 8px !important;
        }
    }
    .shein-tab-nav-bar::-webkit-scrollbar {
        display: none;
    }
    .shein-tab-pill {
        background: none;
        border: none;
        font-size: 13.5px;
        font-weight: 600;
        color: #666;
        padding: 8px 6px 10px;
        cursor: pointer;
        border-bottom: 2.5px solid transparent;
        transition: all 0.15s ease;
        margin-bottom: -1px;
    }
    .shein-tab-pill:hover {
        color: #111;
    }
    .shein-tab-pill.active {
        font-weight: 800;
        color: #111;
        border-bottom: 2.5px solid #111;
    }
</style>
@endpush

@push('scripts')
<script>
    // Category Tabs Filter (SHEIN 5-column grid)
    function switchCategoryTab(tab, btn) {
        document.querySelectorAll('.shein-tab-pill').forEach(b => {
            b.classList.remove('active');
            b.style.fontWeight = '600';
            b.style.color = '#666';
            b.style.borderBottom = '2.5px solid transparent';
        });
        btn.classList.add('active');
        btn.style.fontWeight = '800';
        btn.style.color = '#111';
        btn.style.borderBottom = '2.5px solid #111';

        const items = document.querySelectorAll('.shein-product-item');
        let matchCount = 0;
        items.forEach(item => {
            const itemTab = item.getAttribute('data-tab-group');
            if (tab === 'all' || itemTab === tab) {
                item.style.display = 'flex';
                matchCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Fallback: if category has 0 items, reveal all so grid stays filled
        if (matchCount === 0) {
            items.forEach(item => item.style.display = 'flex');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const defaultTab = document.querySelector('.shein-tab-pill.active');
        if (defaultTab) {
            switchCategoryTab('women', defaultTab);
        }
    });

    // Feed Tabs Filter
    function filterFeed(category, btn) {
        document.querySelectorAll('.feed-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const items = document.querySelectorAll('.feed-item');
        items.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Voucher Collection Helper
    function collectVoucher(code, btn) {
        if (typeof collectCoupon === 'function') {
            collectCoupon(code, btn);
        } else {
            btn.style.background = '#E8F5E9';
            btn.style.color = '#2E7D32';
            btn.innerText = 'COLLECTED ✓';
            showToast(`🎉 Coupon "${code}" collected!`);
        }
    }
</script>
@endpush
