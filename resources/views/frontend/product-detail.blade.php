@extends('frontend.layouts.master')

@section('title', $product['name'] . ' | ' . (get_setting('com_name') ?: 'Mini Mama'))

@section('content')
<div class="shein-container" style="padding-top: 20px; padding-bottom: 80px; max-width: 1440px; margin: 0 auto; padding-left: 20px; padding-right: 20px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 20px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <a href="{{ route('frontend.category', $product['category']) }}" style="color: #444; text-transform: capitalize;">{{ $product['category_name'] ?? $product['category'] }}</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">{{ $product['name'] }}</span>
    </div>

    <!-- Product Details Main Layout -->
    <div style="display: grid; grid-template-columns: 55% 45%; gap: 40px; margin-bottom: 50px;" class="product-detail-grid">
        <!-- Left: Image Gallery -->
        <div>
            <div class="product-gallery-grid" style="display: grid; grid-template-columns: 84px 1fr; gap: 16px;">
                <!-- Thumbnail Column -->
                <div class="product-gallery-thumbs" style="display: flex; flex-direction: column; gap: 10px;">
                    <img src="{{ $product['image_primary'] }}" alt="Thumb 1" class="p-thumb active" style="width: 84px; height: 112px; object-fit: cover; border: 2px solid #000; cursor: pointer; border-radius: 2px;" onclick="changeMainImg(this.src, this)">
                    <img src="{{ $product['image_hover'] }}" alt="Thumb 2" class="p-thumb" style="width: 84px; height: 112px; object-fit: cover; border: 1px solid #ddd; cursor: pointer; border-radius: 2px;" onclick="changeMainImg(this.src, this)">
                    <img src="{{ $product['image_primary'] }}" alt="Thumb 3" class="p-thumb" style="width: 84px; height: 112px; object-fit: cover; border: 1px solid #ddd; cursor: pointer; border-radius: 2px; filter: brightness(0.95);" onclick="changeMainImg(this.src, this)">
                </div>

                <!-- Main Display Image with Zoom -->
                <div style="position: relative; background: #f9f9f9; border-radius: 4px; overflow: hidden;">
                    <img id="detailMainImg" src="{{ $product['image_primary'] }}" alt="{{ $product['name'] }}" style="width: 100%; height: 620px; object-fit: cover; transition: transform 0.3s ease;">
                    @if(isset($product['discount']) && $product['discount'] > 0)
                        <span class="discount-badge" style="font-size: 13px; padding: 4px 10px; top: 12px; left: 12px; position: absolute; background: #FA2C19; color: #fff; font-weight: 800; border-radius: 2px;">
                            -{{ $product['discount'] }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Purchase Panel & Info -->
        <div style="display: flex; flex-direction: column;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 11px; font-weight: 800; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $product['brand'] ?? (get_setting('com_name') ?: 'Mini Mama') }}
                </span>
                
                <!-- Stock Availability Badge -->
                @if($product['in_stock'])
                    <span style="font-size: 11px; font-weight: 800; color: #10B981; background: #ECFDF5; padding: 3px 8px; border-radius: 12px; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-circle-check"></i> In Stock ({{ (int)$product['stock_qty'] }} available)
                    </span>
                @else
                    <span style="font-size: 11px; font-weight: 800; color: #EF4444; background: #FEF2F2; padding: 3px 8px; border-radius: 12px;">
                        Out of Stock
                    </span>
                @endif
            </div>

            <h1 style="font-size: 22px; font-weight: 800; color: #222; margin: 6px 0 10px; line-height: 1.35;">{{ $product['name'] }}</h1>
            
            <!-- SKU & Sales Social Proof -->
            <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; color: #767676; margin-bottom: 12px; flex-wrap: wrap;">
                <span>SKU: <strong id="productSkuText">{{ $product['sku'] }}</strong></span>
                <button type="button" onclick="copySku()" style="background: none; border: none; color: #FA2C19; font-size: 11px; font-weight: 700; cursor: pointer; text-decoration: underline; padding: 0;">
                    Copy SKU
                </button>
                <span>•</span>
                <span>🔥 {{ $product['sold_count'] ?? '2,500+' }} sold</span>
            </div>

            <!-- Rating & Reviews Counter -->
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; font-size: 12px;">
                <span style="color: #FFB800; font-size: 13px; font-weight: 800;">
                    <i class="fa-solid fa-star"></i> {{ $product['rating'] }}
                </span>
                <span style="color: #666; text-decoration: underline; cursor: pointer;" onclick="scrollToReviews()">
                    {{ number_format($product['reviews_count']) }} Reviews
                </span>
                <span style="color: #ddd;">|</span>
                <span style="color: #10B981; font-weight: 600;">
                    <i class="fa-solid fa-shield-check"></i> 100% Quality Guaranteed
                </span>
            </div>

            <!-- Flash Sale Price Strip -->
            <div style="background: #FFF7F5; padding: 14px 18px; border-radius: 4px; border: 1px solid #FFE4DE; margin-bottom: 18px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div style="display: flex; align-items: baseline; gap: 12px;">
                        <span style="font-size: 28px; font-weight: 900; color: #FA2C19;">RM {{ number_format($product['price'], 2) }}</span>
                        <span style="font-size: 15px; color: #999; text-decoration: line-through;">RM {{ number_format($product['original_price'], 2) }}</span>
                        <span style="background: #FA2C19; color: #fff; font-size: 11px; font-weight: 800; padding: 2px 6px; border-radius: 2px;">
                            -{{ $product['discount'] }}% OFF
                        </span>
                    </div>
                    <div style="font-size: 11px; font-weight: 800; color: #FA2C19; text-transform: uppercase;">
                        ⚡ SPECIAL OFFER
                    </div>
                </div>
                <div style="font-size: 11px; color: #9A6700; font-weight: 600;">
                    🪙 Buy now and earn <strong>+{{ floor($product['price']) }} Reward Points</strong>
                </div>
            </div>

            <!-- 1. Color Variations -->
            <div style="margin-bottom: 18px;">
                <div style="font-size: 12px; font-weight: 700; margin-bottom: 8px;">
                    Color: <span id="chosenColorLabel" style="font-weight: 600; color: #FA2C19;">Black</span>
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                    @php
                        $colorNames = ['#111111' => 'Classic Black', '#E8DFD8' => 'Warm Beige', '#FA2C19' => 'Ruby Red', '#2B547E' => 'Ocean Blue'];
                    @endphp
                    @foreach($product['colors'] as $c)
                        <span class="color-dot" data-name="{{ $colorNames[$c] ?? 'Selected Shade' }}" style="width: 26px; height: 26px; border-radius: 50%; background-color: {{ $c }}; border: 2px solid {{ $loop->first ? '#000' : '#ddd' }}; cursor: pointer; transition: transform 0.15s;" onclick="selectProductColor('{{ $c }}', '{{ $colorNames[$c] ?? 'Shade' }}', this)" title="{{ $colorNames[$c] ?? 'Color' }}"></span>
                    @endforeach
                </div>
            </div>

            <!-- 2. Size Variations -->
            <div style="margin-bottom: 18px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 12px; font-weight: 700;">Size: <strong id="chosenSizeLabel" style="color: #111;">{{ $product['sizes'][0] ?? 'M' }}</strong></span>
                    <a href="javascript:void(0)" onclick="openSizeGuideModal()" style="font-size: 11px; text-decoration: underline; color: #666;">
                        <i class="fa-solid fa-ruler-horizontal"></i> Size Guide
                    </a>
                </div>
                <div class="size-pills" id="detailSizePills" style="display: flex; gap: 8px; flex-wrap: wrap;">
                    @foreach($product['sizes'] as $sz)
                        <button type="button" class="size-pill-btn {{ $loop->first ? 'active' : '' }}" onclick="selectDetailSize('{{ $sz }}', this)" style="padding: 6px 14px; font-size: 12px; font-weight: 700; border: 1px solid {{ $loop->first ? '#000' : '#ddd' }}; background: {{ $loop->first ? '#000' : '#fff' }}; color: {{ $loop->first ? '#fff' : '#000' }}; border-radius: 2px; cursor: pointer;">
                            {{ $sz }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- 3. Design / Style Variation (Where applicable) -->
            @if(!empty($product['designs']))
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 12px; font-weight: 700; margin-bottom: 8px;">
                        Design / Fit: <strong id="chosenDesignLabel" style="color: #111;">{{ $product['designs'][0] }}</strong>
                    </div>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;" id="designPills">
                        @foreach($product['designs'] as $des)
                            <button type="button" onclick="selectDesignFit('{{ $des }}', this)" style="padding: 6px 14px; font-size: 11px; font-weight: 700; border: 1px solid {{ $loop->first ? '#000' : '#ddd' }}; background: {{ $loop->first ? '#000' : '#fff' }}; color: {{ $loop->first ? '#fff' : '#000' }}; border-radius: 2px; cursor: pointer;">
                                {{ $des }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quantity, Add to Cart & Buy Now Buttons -->
            <div style="margin-bottom: 24px;">
                <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                    <!-- Quantity Stepper -->
                    <div class="cart-qty-ctrl" style="height: 48px; display: flex; align-items: center; border: 1px solid #ccc; border-radius: 3px;">
                        <button class="qty-btn" style="width: 38px; height: 100%; border: none; background: transparent; font-size: 16px; cursor: pointer;" onclick="adjustDetailQty(-1)">-</button>
                        <span class="qty-val" id="detailQtyVal" style="width: 44px; text-align: center; font-size: 14px; font-weight: 800;">1</span>
                        <button class="qty-btn" style="width: 38px; height: 100%; border: none; background: transparent; font-size: 16px; cursor: pointer;" onclick="adjustDetailQty(1)">+</button>
                    </div>

                    <!-- Add to Bag Button -->
                    <button type="button" class="shein-btn-primary" style="flex: 1; height: 48px; font-size: 13px; font-weight: 800; letter-spacing: 0.5px; background: #000; color: #fff; border: none; border-radius: 3px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; text-transform: uppercase;" onclick="addDetailToBag()">
                        <i class="fa-solid fa-bag-shopping"></i> ADD TO BAG
                    </button>

                    <!-- Wishlist Button -->
                    <button type="button" class="shein-heart-btn" style="position: static; width: 48px; height: 48px; font-size: 20px; border: 1px solid #ccc; border-radius: 3px; display: flex; align-items: center; justify-content: center; cursor: pointer; background: #fff;" data-id="{{ $product['id'] }}" onclick="toggleWishlist({{ json_encode($product) }})" title="Save to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </div>

                <!-- Buy Now Button (Instant Checkout) -->
                <button type="button" onclick="buyNowAction()" style="width: 100%; height: 46px; background: #FA2C19; color: #ffffff; font-size: 14px; font-weight: 900; letter-spacing: 0.5px; border: none; border-radius: 3px; cursor: pointer; text-transform: uppercase; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(250,44,25,0.3); transition: background 0.2s;" onmouseover="this.style.background='#d62000'" onmouseout="this.style.background='#FA2C19'">
                    <i class="fa-solid fa-bolt"></i> BUY NOW • INSTANT CHECKOUT
                </button>
            </div>

            <!-- Share Product Option -->
            <div style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 14px 0; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <span style="font-size: 12px; font-weight: 800; color: #222; text-transform: uppercase;">
                    <i class="fa-solid fa-share-nodes" style="margin-right: 6px;"></i> Share This Product:
                </span>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($product['name'] . ' ' . url()->current()) }}" target="_blank" style="width: 32px; height: 32px; border-radius: 50%; background: #25D366; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 15px; text-decoration: none;" title="Share on WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" style="width: 32px; height: 32px; border-radius: 50%; background: #1877F2; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 15px; text-decoration: none;" title="Share on Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($product['name']) }}&url={{ urlencode(url()->current()) }}" target="_blank" style="width: 32px; height: 32px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px; text-decoration: none;" title="Share on Twitter / X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <button type="button" onclick="copyProductLink()" style="background: #f0f0f0; border: 1px solid #ddd; padding: 6px 12px; border-radius: 16px; font-size: 11px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-regular fa-copy"></i> Copy Link
                    </button>
                </div>
            </div>

            <!-- Guarantee Perks Box -->
            <div style="background: #fafafa; border: 1px solid #eee; padding: 16px; border-radius: 4px; font-size: 12px; line-height: 1.8; color: #444; margin-bottom: 24px;">
                <div>🚚 <strong>Free Shipping:</strong> On orders RM 120.00+ (Est. delivery 3-5 business days)</div>
                <div>🔄 <strong>Easy 20-Day Return:</strong> Return for free if sizing or fit is unsuitable</div>
                <div>💵 <strong>Cash on Delivery:</strong> Doorstep payment available in Malaysia & Bangladesh</div>
                <div>🛡️ <strong>100% Genuine Quality:</strong> Official standard inspection verified</div>
            </div>

            <!-- Description & Specifications Accordion -->
            <div style="border-top: 1px solid #eee; padding-top: 16px;">
                <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 10px;">PRODUCT DESCRIPTION</h4>
                <p style="font-size: 13px; color: #555; line-height: 1.6; margin: 0 0 16px;">
                    {{ $product['description'] }}
                </p>

                <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 10px;">SPECIFICATIONS</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 11px; color: #666;">
                    <div>Style: <strong style="color: #222;">Casual / Commute</strong></div>
                    <div>Pattern: <strong style="color: #222;">Solid / Classic</strong></div>
                    <div>Length: <strong style="color: #222;">Regular</strong></div>
                    <div>Fit Type: <strong style="color: #222;">Regular Fit</strong></div>
                    <div>Fabric: <strong style="color: #222;">Premium Breathable</strong></div>
                    <div>Composition: <strong style="color: #222;">100% Quality Material</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div id="reviewsSection" style="margin-top: 40px; border-top: 2px solid #222; padding-top: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
            <div>
                <h3 style="font-size: 20px; font-weight: 900; text-transform: uppercase; margin: 0;">
                    CUSTOMER REVIEWS ({{ number_format($product['reviews_count']) }})
                </h3>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 6px;">
                    <span style="font-size: 24px; font-weight: 900; color: #222;">{{ $product['rating'] }}</span>
                    <div style="color: #FFB800; font-size: 14px;">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span style="font-size: 12px; color: #666;">Overall Rating from verified buyers</span>
                </div>
            </div>
            <button type="button" class="shein-btn-primary" style="padding: 10px 24px; background: #000; color: #fff; font-size: 12px; font-weight: 800; border: none; cursor: pointer; border-radius: 2px;" onclick="openReviewModal()">
                WRITE A REVIEW
            </button>
        </div>

        <!-- Customer Reviews Grid -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;" class="reviews-grid">
            @if(isset($productReviews) && $productReviews->isNotEmpty())
                @foreach($productReviews as $rev)
                    <div style="background: #fafafa; padding: 18px; border-radius: 4px; border: 1px solid #eee;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="font-weight: 700; font-size: 12px;">{{ $rev->customer_name }}
                                @if($rev->is_verified_buyer)
                                    <span style="color: #10B981; font-size: 10px;">✓ Verified Purchase</span>
                                @endif
                            </span>
                            <span style="color: #FFB800; font-size: 11px;">
                                @for($s = 0; $s < $rev->rating; $s++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </span>
                        </div>
                        <div style="font-size: 11px; color: #888; margin-bottom: 6px;">{{ $rev->created_at->format('M d, Y') }}</div>
                        <p style="font-size: 12px; color: #333; line-height: 1.5; margin: 0;">{{ $rev->comment }}</p>
                    </div>
                @endforeach
            @else
                <div style="grid-column: 1 / -1; text-align: center; padding: 24px; background: #fafafa; border-radius: 4px; border: 1px dashed #ddd; color: #777; font-size: 13px;">
                    Be the first to review this product! Click "WRITE A REVIEW" above to share your experience.
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products Showcase -->
    <div style="margin-top: 60px;">
        <h3 style="font-size: 20px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px;">
            YOU MAY ALSO LIKE (RELATED PRODUCTS)
        </h3>
        <div class="shein-product-grid" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px;" class="related-grid">
            @foreach($relatedProducts as $rel)
                <div class="product-card" style="display: flex; flex-direction: column; background: #fff;">
                    <div style="position: relative; width: 100%; aspect-ratio: 3/4; overflow: hidden; background: #f6f6f6; cursor: pointer;" onclick="window.location='{{ route('frontend.product', $rel['id']) }}'">
                        <img src="{{ $rel['image_primary'] }}" alt="{{ $rel['name'] }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                        @if(isset($rel['discount']) && $rel['discount'] > 0)
                            <span style="position: absolute; top: 6px; left: 6px; background: #FA2C19; color: #fff; font-size: 9px; font-weight: 800; padding: 2px 5px; border-radius: 2px;">
                                -{{ $rel['discount'] }}%
                            </span>
                        @endif
                    </div>
                    <div style="padding: 6px 2px;">
                        <a href="{{ route('frontend.product', $rel['id']) }}" style="font-size: 11px; color: #222; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $rel['name'] }}
                        </a>
                        <div style="font-size: 13px; font-weight: 800; color: #FA2C19; margin-top: 2px;">
                            RM {{ number_format($rel['price'], 2) }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Size Guide Modal -->
<div id="sizeGuideModal" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); z-index: 2800; display: none; align-items: center; justify-content: center;" onclick="if(event.target === this) closeSizeGuideModal()">
    <div style="background: #fff; width: 600px; max-width: 90vw; padding: 30px; border-radius: 4px; position: relative;">
        <button onclick="closeSizeGuideModal()" style="position: absolute; top: 16px; right: 16px; font-size: 20px; background: none; border: none; cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
        <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin-bottom: 16px;">SIZE GUIDE (CM)</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: center;">
            <tr style="background: #f5f5f5; font-weight: 800;">
                <th style="padding: 10px; border: 1px solid #ddd;">Size</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Bust (cm)</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Waist (cm)</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Hip (cm)</th>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: 700;">XS</td>
                <td style="padding: 10px; border: 1px solid #ddd;">82-86</td>
                <td style="padding: 10px; border: 1px solid #ddd;">62-66</td>
                <td style="padding: 10px; border: 1px solid #ddd;">87-91</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: 700;">S</td>
                <td style="padding: 10px; border: 1px solid #ddd;">86-90</td>
                <td style="padding: 10px; border: 1px solid #ddd;">66-70</td>
                <td style="padding: 10px; border: 1px solid #ddd;">91-95</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: 700;">M</td>
                <td style="padding: 10px; border: 1px solid #ddd;">90-94</td>
                <td style="padding: 10px; border: 1px solid #ddd;">70-74</td>
                <td style="padding: 10px; border: 1px solid #ddd;">95-99</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: 700;">L</td>
                <td style="padding: 10px; border: 1px solid #ddd;">94-100</td>
                <td style="padding: 10px; border: 1px solid #ddd;">74-80</td>
                <td style="padding: 10px; border: 1px solid #ddd;">99-105</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: 700;">XL</td>
                <td style="padding: 10px; border: 1px solid #ddd;">100-106</td>
                <td style="padding: 10px; border: 1px solid #ddd;">80-86</td>
                <td style="padding: 10px; border: 1px solid #ddd;">105-111</td>
            </tr>
        </table>
    </div>
</div>

<!-- Write Review Modal -->
<div id="reviewModal" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); z-index: 2800; display: none; align-items: center; justify-content: center;" onclick="if(event.target === this) closeReviewModal()">
    <div style="background: #fff; width: 500px; max-width: 90vw; padding: 26px; border-radius: 4px; position: relative;">
        <button onclick="closeReviewModal()" style="position: absolute; top: 16px; right: 16px; font-size: 20px; background: none; border: none; cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
        <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin-bottom: 6px;">WRITE A REVIEW</h3>
        <p style="font-size: 12px; color: #767676; margin-bottom: 16px;">Share your experience with other shoppers</p>

        <form onsubmit="event.preventDefault(); submitReview();">
            <div style="margin-bottom: 12px;">
                <label style="font-size: 12px; font-weight: 700; display: block; margin-bottom: 4px;">Your Rating:</label>
                <div id="reviewModalStars" style="color: #FFB800; font-size: 20px; cursor: pointer; display: flex; gap: 4px;">
                    <i class="fa-solid fa-star" onclick="setRating(1)"></i>
                    <i class="fa-solid fa-star" onclick="setRating(2)"></i>
                    <i class="fa-solid fa-star" onclick="setRating(3)"></i>
                    <i class="fa-solid fa-star" onclick="setRating(4)"></i>
                    <i class="fa-solid fa-star" onclick="setRating(5)"></i>
                </div>
            </div>
            <div style="margin-bottom: 12px;">
                <input type="text" id="reviewNameInput" placeholder="Your Name" value="{{ session('customer_auth.name') ?? '' }}" required style="width: 100%; height: 38px; border: 1px solid #ddd; padding: 0 12px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 12px;">
                <input type="email" id="reviewEmailInput" placeholder="Your Email (Optional)" value="{{ session('customer_auth.email') ?? '' }}" style="width: 100%; height: 38px; border: 1px solid #ddd; padding: 0 12px; font-size: 13px; border-radius: 3px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 14px;">
                <textarea id="reviewCommentInput" rows="4" placeholder="How was the quality, fit, and delivery?" required style="width: 100%; border: 1px solid #ddd; padding: 10px 12px; font-size: 13px; border-radius: 3px; font-family: inherit; box-sizing: border-box;"></textarea>
            </div>
            <button type="submit" id="submitReviewBtn" style="width: 100%; height: 42px; background: #000; color: #fff; font-size: 13px; font-weight: 800; text-transform: uppercase; border: none; border-radius: 3px; cursor: pointer;">
                SUBMIT REVIEW
            </button>
        </form>
    </div>
</div>

<!-- Sticky Mobile Bottom Purchase Action Bar -->
<div class="mobile-sticky-buy-bar" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; background: #ffffff; border-top: 1px solid #e0e0e0; padding: 10px 14px; z-index: 1010; box-shadow: 0 -4px 16px rgba(0,0,0,0.08);">
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
        <div>
            <div style="font-size: 16px; font-weight: 900; color: #FA2C19; line-height: 1;">RM {{ number_format($product['price'], 2) }}</div>
            <div style="font-size: 10px; color: #888;">{{ $product['in_stock'] ? 'In Stock' : 'Out of Stock' }}</div>
        </div>
        <div style="display: flex; gap: 8px; flex: 1; max-width: 250px;">
            <button type="button" onclick="addDetailToBag()" style="flex: 1; height: 42px; background: #000; color: #fff; font-size: 11px; font-weight: 800; border-radius: 3px; text-transform: uppercase; cursor: pointer;">
                ADD TO BAG
            </button>
            <button type="button" onclick="buyNowAction()" style="flex: 1; height: 42px; background: #FA2C19; color: #fff; font-size: 11px; font-weight: 800; border-radius: 3px; text-transform: uppercase; cursor: pointer;">
                BUY NOW
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    @media (max-width: 900px) {
        .product-detail-grid {
            grid-template-columns: 1fr !important;
            gap: 24px !important;
        }
        .reviews-grid {
            grid-template-columns: 1fr !important;
        }
        .related-grid {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
    @media (max-width: 768px) {
        .mobile-sticky-buy-bar {
            display: block !important;
        }
        body {
            padding-bottom: 72px !important;
        }
    }
    @media (max-width: 640px) {
        .product-gallery-grid {
            display: flex !important;
            flex-direction: column-reverse !important;
            gap: 12px !important;
        }
        .product-gallery-thumbs {
            flex-direction: row !important;
            overflow-x: auto !important;
            padding-bottom: 4px !important;
        }
        .product-gallery-thumbs .p-thumb {
            width: 64px !important;
            height: 84px !important;
            flex-shrink: 0 !important;
        }
        #detailMainImg {
            height: 380px !important;
        }
        .related-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px 8px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let selectedSize = "{{ $product['sizes'][0] ?? 'M' }}";
    let selectedColor = "{{ $product['colors'][0] ?? '#111111' }}";
    let selectedDesign = "{{ $product['designs'][0] ?? 'Standard Fit' }}";
    let detailQty = 1;

    function changeMainImg(src, thumb) {
        document.getElementById('detailMainImg').src = src;
        document.querySelectorAll('.p-thumb').forEach(t => t.style.border = '1px solid #ddd');
        thumb.style.border = '2px solid #000';
    }

    function selectDetailSize(sz, btn) {
        selectedSize = sz;
        document.getElementById('chosenSizeLabel').innerText = sz;
        document.querySelectorAll('#detailSizePills .size-pill-btn').forEach(b => {
            b.style.background = '#fff';
            b.style.color = '#000';
            b.style.border = '1px solid #ddd';
        });
        btn.style.background = '#000';
        btn.style.color = '#fff';
        btn.style.border = '1px solid #000';
    }

    function selectProductColor(color, name, dot) {
        selectedColor = color;
        document.getElementById('chosenColorLabel').innerText = name;
        document.querySelectorAll('.color-dot').forEach(d => d.style.border = '2px solid #ddd');
        dot.style.border = '2px solid #000';
        showToast('Color selected: ' + name);
    }

    function selectDesignFit(des, btn) {
        selectedDesign = des;
        const lbl = document.getElementById('chosenDesignLabel');
        if (lbl) lbl.innerText = des;
        document.querySelectorAll('#designPills button').forEach(b => {
            b.style.background = '#fff';
            b.style.color = '#000';
            b.style.border = '1px solid #ddd';
        });
        btn.style.background = '#000';
        btn.style.color = '#fff';
        btn.style.border = '1px solid #000';
    }

    function adjustDetailQty(delta) {
        detailQty = Math.max(1, detailQty + delta);
        document.getElementById('detailQtyVal').innerText = detailQty;
    }

    function addDetailToBag() {
        const item = @json($product);
        for(let i=0; i<detailQty; i++) {
            addToBag(item, selectedSize, selectedColor);
        }
    }

    // BUY NOW: Add to bag and instantly redirect to checkout
    function buyNowAction() {
        const item = @json($product);
        for(let i=0; i<detailQty; i++) {
            addToBag(item, selectedSize, selectedColor);
        }
        showToast('🚀 Redirecting to Instant Checkout...');
        setTimeout(() => {
            window.location.href = "{{ route('frontend.checkout') }}";
        }, 300);
    }

    function copySku() {
        const sku = document.getElementById('productSkuText').innerText;
        navigator.clipboard.writeText(sku).then(() => {
            showToast('📋 SKU Copied: ' + sku);
        }).catch(() => {
            showToast('SKU: ' + sku);
        });
    }

    function copyProductLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('🔗 Product link copied to clipboard!');
        }).catch(() => {
            showToast('Link: ' + window.location.href);
        });
    }

    function openSizeGuideModal() {
        document.getElementById('sizeGuideModal').style.display = 'flex';
    }

    function closeSizeGuideModal() {
        document.getElementById('sizeGuideModal').style.display = 'none';
    }

    function scrollToReviews() {
        document.getElementById('reviewsSection').scrollIntoView({ behavior: 'smooth' });
    }

    let currentReviewRating = 5;

    function setRating(r) {
        currentReviewRating = r;
        const stars = document.querySelectorAll('#reviewModalStars i');
        stars.forEach((star, idx) => {
            if (idx < r) {
                star.className = 'fa-solid fa-star';
            } else {
                star.className = 'fa-regular fa-star';
            }
        });
    }

    function openReviewModal() {
        document.getElementById('reviewModal').style.display = 'flex';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }

    async function submitReview() {
        const name = document.getElementById('reviewNameInput').value.trim();
        const email = document.getElementById('reviewEmailInput').value.trim();
        const comment = document.getElementById('reviewCommentInput').value.trim();
        const btn = document.getElementById('submitReviewBtn');

        if (!name || !comment) {
            showToast('Please enter your name and comment.');
            return;
        }

        btn.disabled = true;
        btn.innerText = 'SUBMITTING...';

        try {
            const res = await fetch("{{ route('frontend.submit_review') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: "{{ $product['id'] }}",
                    customer_name: name,
                    customer_email: email,
                    rating: currentReviewRating,
                    comment: comment
                })
            });
            const data = await res.json();
            closeReviewModal();
            if (data.success) {
                showToast(data.message);
                document.getElementById('reviewCommentInput').value = '';
            } else {
                showToast('❌ ' + (data.message || 'Error submitting review.'));
            }
        } catch (e) {
            closeReviewModal();
            showToast('⭐ Thank you! Your review has been submitted for moderation.');
        } finally {
            btn.disabled = false;
            btn.innerText = 'SUBMIT REVIEW';
        }
    }
</script>
@endpush
