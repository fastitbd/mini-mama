@extends('frontend.layouts.master')

@section('title', 'Shop The Latest Styles | Fashion Clothes for Women, Men & Kids Online | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')

    <!-- ========================================================
         1. PROMOTIONAL ANNOUNCEMENT BAR (HOMEPAGE TICKER BANNER)
         ======================================================== -->
    <div style="background: linear-gradient(90deg, #FA2C19 0%, #FF5722 50%, #FA2C19 100%); color: #ffffff; padding: 10px 16px; text-align: center; font-size: 13px; font-weight: 700; letter-spacing: 0.5px; box-shadow: 0 2px 8px rgba(250,44,25,0.2);">
        <div class="shein-wrap" style="display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap;">
            <span style="background: #ffffff; color: #FA2C19; font-size: 11px; font-weight: 900; padding: 2px 8px; border-radius: 12px; text-transform: uppercase;">LIMITED TIME</span>
            <span>🔥 <strong>FLASH SALE:</strong> UP TO 85% OFF EVERYTHING + EXTRA 15% OFF USE CODE: <strong>NEW15</strong></span>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(0,0,0,0.25); padding: 3px 10px; border-radius: 4px; font-size: 11px; font-family: monospace;">
                <i class="fa-regular fa-clock"></i>
                <span id="homePromoCountdown">08 : 45 : 12</span>
            </div>
            <a href="{{ route('frontend.category', 'sale') }}" style="background: #000000; color: #ffffff; padding: 4px 14px; border-radius: 2px; font-size: 11px; font-weight: 800; text-transform: uppercase; text-decoration: none; margin-left: 6px;">SHOP SALE →</a>
        </div>
    </div>

    <!-- ========================================================
         2. HERO BANNER WITH SWIPER & SHOP NOW BUTTON
         ======================================================== -->
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

    <div class="cccx-comp-container home-index__ccc-content home-index__1" style="max-width: 1440px; margin: 12px auto 0; padding: 0 16px;">
        <div class="cccx-comp-container home-index__ccc-content home-index__1" id="main" role="main" data-v-49c16825>
            <div class="new-h1-carousel" style="--crop-img-fit:cover;">
                <swiper-container navigation="true" pagination="true" loop="true" autoplay-delay="4500" class="new-h1-carousel__swiper-container">
                    @forelse($heroBanners as $banner)
                        <swiper-slide class="new-h1-carousel__swiper-slide home-a11y-focus__overflow" role="link" tabindex="0" aria-label="{{ $banner->title ?: 'Banner' }}">
                            @if(($banner->banner_type == 'image' || (empty($banner->title) && empty($banner->subtitle))) && $banner->image)
                                <div class="new-trends-frame hero-graphic-banner" style="--new-trends-frame-max-height:360px; height: 26vw; max-height: 360px; min-height: 200px; background: {{ $banner->bg_color ?: '#111111' }}; overflow:hidden; border-radius:4px; position:relative; display:flex; align-items:center; justify-content:center;">
                                    <div style="position: absolute; inset: -20px; background-image: url('{{ $banner->image_url }}'); background-size: cover; background-position: center; filter: blur(25px) brightness(0.45); opacity: 0.75; z-index: 1; pointer-events: none;"></div>
                                    <a href="{{ $banner->btn_url ?: route('frontend.category', 'all') }}" style="position: relative; z-index: 2; display:flex; align-items:center; justify-content:center; width:100%; height:100%; text-decoration: none;">
                                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?: 'Banner' }}" style="max-width:100%; max-height:100%; width:100%; height:100%; object-fit:contain; display:block;">
                                    </a>
                                </div>
                            @else
                                <div class="new-trends-frame" style="--new-trends-frame-max-height:360px; min-height: 220px; background: {{ $banner->bg_color ?: 'linear-gradient(135deg, #111111 0%, #2a0808 100%)' }}; border-radius: 4px; overflow: hidden;">
                                    @if($banner->image)
                                    <div class="new-trends-frame__bg not-fsp-element">
                                        <div class="base-img new-trends-frame__bg_product-mask">
                                            <a href="{{ $banner->btn_url ?: route('frontend.category', 'all') }}" style="padding-bottom:100.00%;" class="base-img__href" aria-hidden="true" tabindex="-1">
                                                <img style="object-position:initial;" class="base-img__initial fsp__h1-carousel-trends-product-mask base-img__inner fsp-element" src="{{ $banner->image_url }}" alt="{{ $banner->title }}" fetchpriority="auto">
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="new-trends-frame__main-content">
                                        <div class="new-trends-frame__content" style="padding-left: {{ $banner->image ? '40px' : '60px' }};">
                                            <span style="background: #FA2C19; color: #ffffff; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 2px; text-transform: uppercase; letter-spacing: 0.8px; display: inline-block; margin-bottom: 8px;">SEASON SPECIAL</span>
                                            @if($banner->title)
                                                <div style="font-size: 36px; font-weight: 900; color: #FA2C19; letter-spacing: 1.5px; text-transform: uppercase; line-height: 1.1;">
                                                    {{ $banner->title }}
                                                </div>
                                            @endif
                                            @if($banner->subtitle)
                                                <div style="font-size: 16px; font-weight: 700; color: #ffffff; margin: 8px 0 18px; text-transform: uppercase; letter-spacing: 0.8px;">
                                                    {{ $banner->subtitle }}
                                                </div>
                                            @endif
                                            <a href="{{ $banner->btn_url ?: route('frontend.category', 'all') }}" style="background: #FA2C19; color: #fff; font-size: 13px; font-weight: 800; padding: 12px 28px; border-radius: 2px; display: inline-flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none; box-shadow: 0 4px 15px rgba(250,44,25,0.4); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                                <span>{{ $banner->btn_text ?: 'SHOP NOW' }}</span>
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </swiper-slide>
                    @empty
                        <swiper-slide class="new-h1-carousel__swiper-slide home-a11y-focus__overflow" role="link" tabindex="0" aria-label="MEGA SALE">
                            <div class="new-trends-frame" style="--new-trends-frame-max-height:360px; min-height: 220px; background:linear-gradient(135deg, #111 0%, #2a0808 100%); border-radius: 4px; overflow: hidden;">
                                <div class="new-trends-frame__main-content">
                                    <div class="new-trends-frame__content" style="padding-left:50px;">
                                        <span style="background: #FA2C19; color: #ffffff; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 2px; text-transform: uppercase; letter-spacing: 0.8px; display: inline-block; margin-bottom: 8px;">HOT COLLECTION</span>
                                        <div style="font-size:42px; font-weight:900; color:#FA2C19; letter-spacing:2px; text-transform:uppercase; line-height:1;">SEASON BIG SALE</div>
                                        <div style="font-size:17px; font-weight:700; color:#ffffff; margin:8px 0 18px; text-transform:uppercase; letter-spacing:1px;">UP TO 85% OFF EVERYTHING</div>
                                        <a href="{{ route('frontend.category', 'sale') }}" style="background:#FA2C19; color:#fff; font-size:13px; font-weight:800; padding:12px 28px; border-radius:2px; display:inline-flex; align-items:center; gap:8px; text-transform:uppercase; letter-spacing:0.5px; box-shadow: 0 4px 15px rgba(250,44,25,0.4);">
                                            <span>SHOP NOW</span>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    @endforelse
                </swiper-container>
            </div>
        </div>
    </div>

    <!-- ========================================================
         3. FEATURED CATEGORIES (CIRCULAR THUMBNAILS CAROUSEL)
         ======================================================== -->
    @php
        $homeCategories = \App\Models\Category::where('name', '!=', 'General')
            ->whereNotNull('image')
            ->orderBy('order_num', 'asc')
            ->orderBy('id', 'asc')
            ->get();
        if ($homeCategories->isEmpty()) {
            $homeCategories = \App\Models\Category::where('name', '!=', 'General')->orderBy('order_num', 'asc')->orderBy('id', 'asc')->get();
        }
        
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

    <div class="category-recommend-wrapper" style="background:#F6F6F6; padding: 22px 0 16px; margin-top: 14px;" data-component-name="CATEGORY_RECOMMEND_COMPONENT_1">
        <div class="shein-wrap" style="max-width: 1440px; margin: 0 auto; padding: 0 16px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                <div>
                    <h2 style="font-size: 19px; font-weight: 900; text-transform: uppercase; color: #111111; letter-spacing: 0.5px; margin: 0;">
                        🔥 Featured Categories
                    </h2>
                    <p style="font-size: 12px; color: #767676; margin: 2px 0 0;">Explore our top curated styles & collections</p>
                </div>
                <a href="{{ route('frontend.category', 'all') }}" style="font-size: 12px; font-weight: 700; color: #FA2C19; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    View All Categories <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                </a>
            </div>

            <div style="position:relative;">
                <button type="button" class="category-swiper-btn-prev" onclick="document.querySelector('.category-recommend-dynamic__swiper').swiper.slidePrev()" style="position:absolute; left:-12px; top:50%; transform:translateY(-50%); width:32px; height:32px; background:#fff; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.15); z-index:10; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fa-solid fa-chevron-left" style="font-size:12px;"></i></button>
                <button type="button" class="category-swiper-btn-next" onclick="document.querySelector('.category-recommend-dynamic__swiper').swiper.slideNext()" style="position:absolute; right:-12px; top:50%; transform:translateY(-50%); width:32px; height:32px; background:#fff; border-radius:50%; box-shadow:0 2px 8px rgba(0,0,0,0.15); z-index:10; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fa-solid fa-chevron-right" style="font-size:12px;"></i></button>
                
                <swiper-container class-name="linear-mode" class="category-recommend-dynamic__swiper" slides-per-view="auto" space-between="12" observer="true">
                    @foreach($displayItems->chunk(3) as $catChunk)
                        <swiper-slide class="category-recommend-dynamic__slide">
                            @foreach($catChunk as $index => $cItem)
                                @php
                                    $targetUrl = ($cItem instanceof \App\Models\SubCategory)
                                        ? (route('frontend.category', $cItem->category_id) . '?subcategory=' . $cItem->id)
                                        : route('frontend.category', $cItem->slug ?: $cItem->id);
                                @endphp
                                <div class="category-recommend-dynamic__img_wrapper a11y-focus" da-rid="category_{{ $index }}" role="link" tabindex="0" aria-label="{{ $cItem->name }}">
                                    <div class="base-img category-recommend-dynamic__img" style="background-color:#F0EEEC;">
                                        <a href="{{ $targetUrl }}" style="padding-bottom:100.00%;" class="base-img__href" aria-hidden="true" tabindex="-1">
                                            <img style="object-position:initial;" class="base-img__cover fsp__category-recommend-placeholder base-img__inner fsp-element" src="{{ $cItem->image_url }}" alt="{{ $cItem->name }}" fetchpriority="auto">
                                        </a>
                                    </div>
                                    <div style="color:#000000;" class="category-recommend-dynamic__name">{{ $cItem->name }}</div>
                                </div>
                            @endforeach
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            </div>
        </div>
    </div>

    <!-- ========================================================
         4. SPECIAL OFFERS / FLASH SALE & SUPER DEALS
         ======================================================== -->
    <div class="shein-container" style="max-width: 1440px; margin: 24px auto 0; padding: 0 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <h2 style="font-size: 20px; font-weight: 900; text-transform: uppercase; color: #FA2C19; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-bolt"></i> Special Offers & Flash Deals
                </h2>
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #000000; color: #ffffff; padding: 4px 10px; border-radius: 3px; font-size: 11px; font-weight: 800;">
                    <span>ENDS IN:</span>
                    <span id="flashTimer" style="color: #FFB800;">04:18:36</span>
                </div>
            </div>
            <a href="{{ route('frontend.category', 'sale') }}" style="font-size: 12px; font-weight: 700; color: #FA2C19; text-decoration: none;">
                View All Deals <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
            </a>
        </div>

        <div class="super-deals-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 16px;">
            {{-- Left Block: SuperDeals --}}
            <div style="background: #ffffff; border-radius: 6px; padding: 14px 16px; box-shadow: 0 1px 6px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 17px; font-weight: 900; font-style: italic; color: #111111;">
                        🔥 {{ $storeSections['super_deals']->name ?? 'SuperDeals' }}
                    </span>
                    <span style="font-size: 10px; font-weight: 800; background: #FFF1F0; color: #FA2C19; padding: 2px 8px; border-radius: 10px;">UP TO 70% OFF</span>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    @foreach($superDeals->take(3) as $sd)
                        <div class="super-deal-card" onclick="window.location='{{ route('frontend.product', $sd->id) }}'" style="cursor: pointer; display: flex; flex-direction: column;">
                            <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 3px; overflow: hidden; background: #f6f6f6;">
                                <img src="{{ $sd->image_url }}" alt="{{ $sd->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                                <span style="position: absolute; top: 6px; left: 6px; background: #FA2C19; color: #ffffff; font-size: 9px; font-weight: 800; padding: 2px 5px; border-radius: 2px;">
                                    {{ $sd->badge ?: 'HOT' }}
                                </span>
                            </div>
                            <div style="margin-top: 6px;">
                                <div style="color: #FA2C19; font-size: 15px; font-weight: 800; line-height: 1.1;">
                                    <span style="font-size: 10px; font-weight: 700; margin-right: 1px;">RM</span>{{ number_format($sd->selling_price, 2) }}
                                </div>
                                <div style="color: #767676; font-size: 10px; text-decoration: line-through;">
                                    RM {{ number_format($sd->dis_selling_price ?: $sd->selling_price * 1.4, 2) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Block: Top Trends Deals --}}
            <div style="background: #ffffff; border-radius: 6px; padding: 14px 16px; box-shadow: 0 1px 6px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 17px; font-weight: 900; font-style: italic; color: #111111;">
                        ✨ {{ $storeSections['trends']->name ?? 'Top Trending Deals' }}
                    </span>
                    <span style="font-size: 10px; font-weight: 800; background: #F3E8FF; color: #7952b3; padding: 2px 8px; border-radius: 10px;">TRENDING</span>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                    @foreach($trends->take(3) as $tr)
                        <div class="trend-deal-card" onclick="window.location='{{ route('frontend.product', $tr->id) }}'" style="cursor: pointer; display: flex; flex-direction: column;">
                            <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 3px; overflow: hidden; background: #f6f6f6;">
                                <img src="{{ $tr->image_url }}" alt="{{ $tr->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                                <span style="position: absolute; top: 6px; left: 6px; background: #000000; color: #ffffff; font-size: 9px; font-weight: 800; padding: 2px 5px; border-radius: 2px;">
                                    TREND
                                </span>
                            </div>
                            <div style="margin-top: 6px;">
                                <div style="color: #FA2C19; font-size: 15px; font-weight: 800; line-height: 1.1;">
                                    <span style="font-size: 10px; font-weight: 700; margin-right: 1px;">RM</span>{{ number_format($tr->selling_price, 2) }}
                                </div>
                                <div style="color: #7952b3; font-size: 10px; font-weight: 700; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $tr->badge ?: '#SummerVibes' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================
         5. NEW ARRIVALS (DEDICATED CAROUSEL / GRID)
         ======================================================== -->
    <section style="max-width: 1440px; margin: 34px auto 0; padding: 0 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <div>
                <h2 style="font-size: 20px; font-weight: 900; text-transform: uppercase; color: #111111; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <span style="color: #10B981;">🆕</span> New Arrivals
                </h2>
                <p style="font-size: 12px; color: #767676; margin: 2px 0 0;">Fresh drops, latest season styles added daily</p>
            </div>
            <a href="{{ route('frontend.category', 'new-in') }}" style="font-size: 12px; font-weight: 700; color: #111111; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                Explore All New In <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 14px 10px;" class="shein-card-grid">
            @foreach($newArrivals->take(5) as $item)
                @php
                    $cItem = [
                        'id' => $item->id,
                        'name' => $item->name,
                        'price' => (float)$item->selling_price,
                        'image' => $item->image_url,
                    ];
                @endphp
                <div style="display: flex; flex-direction: column; background: #fff; border-radius: 4px; overflow: hidden; position: relative;">
                    <div style="position: relative; width: 100%; aspect-ratio: 3/4; background: #f6f6f6; cursor: pointer;" onclick="window.location='{{ route('frontend.product', $item->id) }}'">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 8px; left: 8px; background: #10B981; color: #fff; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 2px; text-transform: uppercase;">NEW</span>
                    </div>
                    <div style="padding: 8px 4px 4px;">
                        <a href="{{ route('frontend.product', $item->id) }}" style="font-size: 12px; font-weight: 500; color: #222; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $item->name }}
                        </a>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                            <span style="font-size: 14px; font-weight: 800; color: #111;">
                                <span style="font-size: 10px;">RM</span>{{ number_format($item->selling_price, 2) }}
                            </span>
                            <button type="button" onclick="addToBag({{ json_encode($cItem) }})" style="width: 26px; height: 26px; border-radius: 50%; border: 1.2px solid #222; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Add to Bag">
                                <i class="fa-solid fa-plus" style="font-size: 11px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================================
         6. BEST SELLERS SECTION
         ======================================================== -->
    <section style="max-width: 1440px; margin: 34px auto 0; padding: 0 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <div>
                <h2 style="font-size: 20px; font-weight: 900; text-transform: uppercase; color: #111111; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <span style="color: #FFB800;">🏆</span> Best Sellers Ranking
                </h2>
                <p style="font-size: 12px; color: #767676; margin: 2px 0 0;">Customer favorites loved by thousands of shoppers</p>
            </div>
            <a href="{{ route('frontend.category', 'best-sellers') }}" style="font-size: 12px; font-weight: 700; color: #111111; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                See Full Ranking <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 14px 10px;" class="shein-card-grid">
            @foreach($bestSellers->take(5) as $rank => $bItem)
                @php
                    $cItem = [
                        'id' => $bItem->id,
                        'name' => $bItem->name,
                        'price' => (float)$bItem->selling_price,
                        'image' => $bItem->image_url,
                    ];
                @endphp
                <div style="display: flex; flex-direction: column; background: #fff; border-radius: 4px; overflow: hidden; position: relative;">
                    <div style="position: relative; width: 100%; aspect-ratio: 3/4; background: #f6f6f6; cursor: pointer;" onclick="window.location='{{ route('frontend.product', $bItem->id) }}'">
                        <img src="{{ $bItem->image_url }}" alt="{{ $bItem->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                        <span style="position: absolute; top: 8px; left: 8px; background: #000000; color: #FFB800; font-size: 10px; font-weight: 900; padding: 2px 8px; border-radius: 2px;">
                            #{{ $rank + 1 }}
                        </span>
                    </div>
                    <div style="padding: 8px 4px 4px;">
                        <a href="{{ route('frontend.product', $bItem->id) }}" style="font-size: 12px; font-weight: 500; color: #222; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $bItem->name }}
                        </a>
                        <div style="display: flex; align-items: center; gap: 4px; margin-top: 2px; font-size: 10px; color: #767676;">
                            <span style="color: #FFB800;"><i class="fa-solid fa-star"></i> 4.9</span>
                            <span>• 1.5k+ sold</span>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                            <span style="font-size: 14px; font-weight: 800; color: #FA2C19;">
                                <span style="font-size: 10px;">RM</span>{{ number_format($bItem->selling_price, 2) }}
                            </span>
                            <button type="button" onclick="addToBag({{ json_encode($cItem) }})" style="width: 26px; height: 26px; border-radius: 50%; border: 1.2px solid #222; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer;" title="Add to Bag">
                                <i class="fa-solid fa-bag-shopping" style="font-size: 11px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================================
         7. FEATURED PRODUCTS (CATEGORY TABS 5-COLUMN GRID)
         ======================================================== -->
    <section class="shein-product-showcase-section" style="max-width: 1440px; margin: 38px auto 0; padding: 0 16px;">
        <div style="text-align: center; margin-bottom: 16px;">
            <h2 style="font-size: 22px; font-weight: 900; text-transform: uppercase; color: #111111; letter-spacing: 1px; margin: 0 0 6px;">
                ✨ Featured Products
            </h2>
            <p style="font-size: 13px; color: #767676; margin: 0;">Shop by category — carefully chosen daily trend highlights</p>
        </div>

        {{-- Category Tabs Bar --}}
        <div class="shein-tab-nav-bar" style="display: flex; justify-content: center; align-items: center; gap: 26px; border-bottom: 1px solid #ebebeb; overflow-x: auto; white-space: nowrap; margin-bottom: 20px; padding-bottom: 0;">
            <button type="button" class="shein-tab-pill active" onclick="switchCategoryTab('women', this)">Women</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('men', this)">Men</button>
            <button type="button" class="shein-tab-pill" onclick="switchCategoryTab('plus', this)">Plus Size</button>
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
                    <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 2px; overflow: hidden; background: #f6f6f6; cursor: pointer;" onclick="window.location='{{ route('frontend.product', $prod->id) }}'">
                        <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: opacity 0.15s ease;" onmouseover="this.style.opacity='0.92'" onmouseout="this.style.opacity='1'">
                    </div>

                    <a href="{{ route('frontend.product', $prod->id) }}" style="font-size: 11px; color: #222222; text-decoration: none; margin-top: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; line-height: 1.3;" title="{{ $prod->name }}">
                        {{ $prod->name }}
                    </a>

                    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 3px;">
                        <div style="font-size: 14.5px; font-weight: 800; color: {{ $isSale ? '#FA2C19' : '#111111' }}; line-height: 1.1;">
                            <span style="font-size: 10px; font-weight: 700; margin-right: 1px;">RM</span>{{ number_format($prod->selling_price, 2) }}
                        </div>

                        <button type="button" class="shein-circle-cart-btn" onclick="event.stopPropagation(); addToBag({{ json_encode($cartItem) }})" style="width: 26px; height: 26px; border-radius: 50%; border: 1.2px solid #222222; background: #ffffff; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0; transition: all 0.2s ease; flex-shrink: 0;" title="{{ __('Add to Bag') }}">
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

        <div style="text-align: center; margin-top: 32px;">
            <a href="{{ route('frontend.category', 'all') }}" class="btn-shein-outline" style="display: inline-block; width: auto; padding: 12px 48px; font-weight: 800; font-size: 13px; border-radius: 2px;">
                EXPLORE ALL STYLES →
            </a>
        </div>
    </section>

    <!-- ========================================================
         8. GIFT IDEAS & RECOMMENDED PRODUCTS
         ======================================================== -->
    <section style="background: #fafafa; padding: 36px 0; margin-top: 36px; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
        <div class="shein-wrap" style="max-width: 1440px; margin: 0 auto; padding: 0 16px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 20px; font-weight: 900; text-transform: uppercase; color: #111111; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <span>🎁</span> Gift Ideas & Recommended For You
                    </h2>
                    <p style="font-size: 12px; color: #767676; margin: 2px 0 0;">Curated picks for every budget, season & celebration</p>
                </div>
                <div style="display: flex; gap: 8px;">
                    <span style="font-size: 11px; font-weight: 700; background: #fff; padding: 4px 10px; border-radius: 12px; border: 1px solid #ddd; cursor: pointer;">Under RM50</span>
                    <span style="font-size: 11px; font-weight: 700; background: #fff; padding: 4px 10px; border-radius: 12px; border: 1px solid #ddd; cursor: pointer;">Under RM100</span>
                    <span style="font-size: 11px; font-weight: 700; background: #000; color: #fff; padding: 4px 10px; border-radius: 12px; cursor: pointer;">Luxury Picks</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px;" class="gift-grid">
                @php
                    $giftProducts = $dbProducts->slice(5, 4);
                    if ($giftProducts->count() < 4) $giftProducts = $dbProducts->take(4);
                @endphp
                @foreach($giftProducts as $gIdx => $gItem)
                    @php
                        $cItem = [
                            'id' => $gItem->id,
                            'name' => $gItem->name,
                            'price' => (float)$gItem->selling_price,
                            'image' => $gItem->image_url,
                        ];
                    @endphp
                    <div style="background: #ffffff; border-radius: 6px; padding: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column;">
                        <div style="position: relative; width: 100%; aspect-ratio: 3/4; border-radius: 4px; overflow: hidden; background: #f6f6f6; cursor: pointer;" onclick="window.location='{{ route('frontend.product', $gItem->id) }}'">
                            <img src="{{ $gItem->image_url }}" alt="{{ $gItem->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                            <span style="position: absolute; top: 8px; left: 8px; background: #FA2C19; color: #fff; font-size: 9px; font-weight: 800; padding: 2px 7px; border-radius: 2px;">
                                🎁 GIFT PICK
                            </span>
                        </div>
                        <div style="margin-top: 10px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <a href="{{ route('frontend.product', $gItem->id) }}" style="font-size: 12px; font-weight: 600; color: #222; text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.35;">
                                    {{ $gItem->name }}
                                </a>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 8px;">
                                <div>
                                    <div style="font-size: 15px; font-weight: 900; color: #111;">
                                        <span style="font-size: 11px;">RM</span>{{ number_format($gItem->selling_price, 2) }}
                                    </div>
                                </div>
                                <button type="button" onclick="addToBag({{ json_encode($cItem) }})" style="background: #000; color: #fff; font-size: 11px; font-weight: 800; padding: 6px 12px; border-radius: 3px; cursor: pointer; text-transform: uppercase;">
                                    Add to Bag
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================================
         9. CUSTOMER REVIEWS & EXPERIENCES
         ======================================================== -->
    <section style="max-width: 1440px; margin: 40px auto 0; padding: 0 16px;">
        <div style="text-align: center; margin-bottom: 24px;">
            <div style="color: #FFB800; font-size: 18px; margin-bottom: 4px;">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
            <h2 style="font-size: 22px; font-weight: 900; text-transform: uppercase; color: #111111; letter-spacing: 0.5px; margin: 0 0 6px;">
                Customer Reviews & Experiences
            </h2>
            <p style="font-size: 13px; color: #767676; margin: 0;">Trusted by over 50,000+ happy customers worldwide</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;" class="reviews-grid">
            @php
                $dbReviews = \App\Models\ProductReview::with('product')->approved()->latest()->take(6)->get();
                $fallbackReviews = [
                    ['name' => 'Sarah M.', 'rating' => 5, 'text' => 'The fabric quality exceeded my expectations! Delivered within 3 days and fits perfectly. Will definitely order again.', 'product' => 'Summer Floral Maxi Dress', 'verified' => true],
                    ['name' => 'Aisyah K.', 'rating' => 5, 'text' => 'Super fast delivery and cash on delivery made it completely worry-free. Customer support was also very helpful!', 'product' => 'Ribbed Knit Casual Top', 'verified' => true],
                    ['name' => 'Farhana Z.', 'rating' => 5, 'text' => 'Great value for money! I got the 15% discount on my first order. 10/10 recommend to all fashion lovers.', 'product' => 'High Waist Wide Leg Pants', 'verified' => true],
                ];
            @endphp
            @if($dbReviews->isNotEmpty())
                @foreach($dbReviews as $rev)
                    <div style="background: #ffffff; border: 1px solid #eeeeee; border-radius: 6px; padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                    {{ substr($rev->customer_name, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-size: 13px; font-weight: 800; color: #111;">{{ $rev->customer_name }}</div>
                                    @if($rev->is_verified_buyer)
                                        <div style="font-size: 10px; color: #10B981; font-weight: 700;">
                                            <i class="fa-solid fa-circle-check"></i> Verified Buyer
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div style="color: #FFB800; font-size: 12px;">
                                @for($s = 0; $s < $rev->rating; $s++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <p style="font-size: 13px; color: #444; line-height: 1.5; margin: 0 0 14px; font-style: italic;">
                            "{{ $rev->comment }}"
                        </p>
                        @if($rev->product)
                            <div style="border-top: 1px solid #f5f5f5; padding-top: 10px; font-size: 11px; color: #888;">
                                <i class="fa-solid fa-tag" style="margin-right: 4px;"></i> Purchased: <strong>{{ $rev->product->name }}</strong>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                @foreach($fallbackReviews as $rev)
                    <div style="background: #ffffff; border: 1px solid #eeeeee; border-radius: 6px; padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 38px; height: 38px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                    {{ substr($rev['name'], 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-size: 13px; font-weight: 800; color: #111;">{{ $rev['name'] }}</div>
                                    @if($rev['verified'])
                                        <div style="font-size: 10px; color: #10B981; font-weight: 700;">
                                            <i class="fa-solid fa-circle-check"></i> Verified Buyer
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div style="color: #FFB800; font-size: 12px;">
                                @for($s = 0; $s < $rev['rating']; $s++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <p style="font-size: 13px; color: #444; line-height: 1.5; margin: 0 0 14px; font-style: italic;">
                            "{{ $rev['text'] }}"
                        </p>
                        <div style="border-top: 1px solid #f5f5f5; padding-top: 10px; font-size: 11px; color: #888;">
                            <i class="fa-solid fa-tag" style="margin-right: 4px;"></i> Purchased: <strong>{{ $rev['product'] }}</strong>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- ========================================================
         10. BLOG & STYLE / GIFT GUIDES
         ======================================================== -->
    <section style="max-width: 1440px; margin: 44px auto 0; padding: 0 16px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <div>
                <h2 style="font-size: 20px; font-weight: 900; text-transform: uppercase; color: #111111; letter-spacing: 0.5px; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <span>📰</span> From Our Blog & Style Guides
                </h2>
                <p style="font-size: 12px; color: #767676; margin: 2px 0 0;">Tips, tricks, and fashion inspiration to elevate your wardrobe</p>
            </div>
            <a href="{{ route('frontend.blog') }}" style="font-size: 12px; font-weight: 700; color: #FA2C19; text-decoration: none;">
                Read All Articles <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;" class="blog-grid">
            @php
                $dbBlogPosts = \App\Models\BlogPost::published()->latest()->take(3)->get();
                $fallbackBlogPosts = [
                    [
                        'title' => 'Top 10 Fashion Trends You Need to Try This Season',
                        'desc' => 'Discover the essential pieces making waves in global fashion runways and street style.',
                        'tag' => 'TRENDS',
                        'date' => 'Oct 2026',
                        'img' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=500&auto=format&fit=crop&q=60',
                        'url' => route('frontend.blog')
                    ],
                    [
                        'title' => 'The Ultimate Gift Guide: Fashion Finds Under RM100',
                        'desc' => 'Stuck on gift ideas? Check out our budget-friendly yet chic fashion gift recommendations.',
                        'tag' => 'GIFT GUIDE',
                        'date' => 'Oct 2026',
                        'img' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=500&auto=format&fit=crop&q=60',
                        'url' => route('frontend.blog')
                    ],
                    [
                        'title' => 'How to Build an Effortless Capsule Wardrobe in 5 Steps',
                        'desc' => 'Simplify your morning routine with versatile essentials that mix and match effortlessly.',
                        'tag' => 'STYLE TIPS',
                        'date' => 'Oct 2026',
                        'img' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=500&auto=format&fit=crop&q=60',
                        'url' => route('frontend.blog')
                    ],
                ];
            @endphp
            @if($dbBlogPosts->isNotEmpty())
                @foreach($dbBlogPosts as $post)
                    <div style="background: #ffffff; border: 1px solid #eee; border-radius: 6px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div style="height: 180px; overflow: hidden; position: relative; background: #222;">
                            <img src="{{ Str::startsWith($post->image, ['http://', 'https://']) ? $post->image : asset($post->image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <span style="position: absolute; top: 10px; left: 10px; background: #000; color: #fff; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 2px;">
                                {{ $post->tags ? trim(explode(',', $post->tags)[0]) : 'GUIDE' }}
                            </span>
                        </div>
                        <div style="padding: 16px;">
                            <div style="font-size: 11px; color: #999; margin-bottom: 6px;">
                                <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> {{ $post->created_at->format('M Y') }}
                            </div>
                            <h3 style="font-size: 15px; font-weight: 800; color: #111; margin: 0 0 8px; line-height: 1.35;">
                                <a href="{{ route('frontend.blog.detail', $post->slug) }}" style="color: inherit; text-decoration: none;">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p style="font-size: 12px; color: #666; line-height: 1.5; margin: 0 0 14px;">
                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 90) }}
                            </p>
                            <a href="{{ route('frontend.blog.detail', $post->slug) }}" style="font-size: 12px; font-weight: 800; color: #FA2C19; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                Read Guide <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                @foreach($fallbackBlogPosts as $post)
                    <div style="background: #ffffff; border: 1px solid #eee; border-radius: 6px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='none'; this.style.boxShadow='none';">
                        <div style="height: 180px; overflow: hidden; position: relative; background: #222;">
                            <img src="{{ $post['img'] }}" alt="{{ $post['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <span style="position: absolute; top: 10px; left: 10px; background: #000; color: #fff; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 2px;">
                                {{ $post['tag'] }}
                            </span>
                        </div>
                        <div style="padding: 16px;">
                            <div style="font-size: 11px; color: #999; margin-bottom: 6px;">
                                <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> {{ $post['date'] }}
                            </div>
                            <h3 style="font-size: 15px; font-weight: 800; color: #111; margin: 0 0 8px; line-height: 1.35;">
                                {{ $post['title'] }}
                            </h3>
                            <p style="font-size: 12px; color: #666; line-height: 1.5; margin: 0 0 14px;">
                                {{ $post['desc'] }}
                            </p>
                            <a href="{{ $post['url'] }}" style="font-size: 12px; font-weight: 800; color: #FA2C19; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                Read Guide <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- ========================================================
         11. NEWSLETTER SUBSCRIPTION (HOMEPAGE BANNER)
         ======================================================== -->
    <section style="background: #000000; color: #ffffff; padding: 48px 16px; margin-top: 48px; position: relative; overflow: hidden;">
        <div style="position: absolute; right: -50px; top: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(250,44,25,0.15); filter: blur(40px);"></div>
        <div class="shein-wrap" style="max-width: 800px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <span style="background: #FA2C19; color: #fff; font-size: 11px; font-weight: 900; padding: 3px 10px; border-radius: 12px; text-transform: uppercase; letter-spacing: 1px;">JOIN THE VIP CLUB</span>
            <h2 style="font-size: 32px; font-weight: 900; text-transform: uppercase; margin: 12px 0 8px; letter-spacing: 1px;">
                Get 15% Off Your First Order
            </h2>
            <p style="font-size: 14px; color: #cccccc; margin: 0 0 24px;">
                Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.
            </p>

            <form class="home-newsletter-form" onsubmit="event.preventDefault(); const email = this.querySelector('input').value; if(email){ showToast('🎉 Welcome! Promo code NEW15 applied to your bag!'); this.reset(); }" style="display: flex; max-width: 520px; margin: 0 auto; gap: 8px;">
                <input type="email" placeholder="Enter your email address..." required style="flex: 1; height: 46px; border: 1px solid #444; border-radius: 3px; padding: 0 16px; font-size: 14px; background: #1a1a1a; color: #fff; outline: none;">
                <button type="submit" style="background: #FA2C19; color: #fff; font-weight: 800; font-size: 13px; text-transform: uppercase; padding: 0 24px; border: none; border-radius: 3px; cursor: pointer; letter-spacing: 0.5px;">
                    SUBSCRIBE
                </button>
            </form>
            <div style="font-size: 11px; color: #888; margin-top: 12px;">
                🔒 We respect your privacy. Unsubscribe at any time.
            </div>
        </div>
    </section>

    <!-- Floating Back to Top -->
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
    @media (max-width: 992px) {
        .shein-card-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
        .gift-grid, .reviews-grid, .blog-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        .super-deals-grid {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 768px) {
        .category-swiper-btn-prev, .category-swiper-btn-next {
            display: none !important;
        }
        .new-trends-frame__content {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
        .new-trends-frame__content div:nth-child(2) {
            font-size: 24px !important;
        }
    }
    @media (max-width: 640px) {
        .shein-card-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px 8px !important;
        }
        .gift-grid, .reviews-grid, .blog-grid {
            grid-template-columns: 1fr !important;
        }
        .home-newsletter-form {
            flex-direction: column !important;
            gap: 10px !important;
        }
        .home-newsletter-form button {
            height: 44px !important;
            width: 100% !important;
        }
        .hero-graphic-banner {
            height: 200px !important;
            min-height: 180px !important;
        }
    }
    .shein-tab-nav-bar {
        -webkit-overflow-scrolling: touch;
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
    // Live countdown timer for Flash Sales & Ticker
    function startTimer(duration, display1, display2) {
        let timer = duration, hours, minutes, seconds;
        setInterval(function () {
            hours = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            if (display1) display1.textContent = hours + " : " + minutes + " : " + seconds;
            if (display2) display2.textContent = hours + ":" + minutes + ":" + seconds;

            if (--timer < 0) {
                timer = duration;
            }
        }, 1000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const d1 = document.getElementById('homePromoCountdown');
        const d2 = document.getElementById('flashTimer');
        startTimer(31512, d1, d2);
    });

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
</script>
@endpush
