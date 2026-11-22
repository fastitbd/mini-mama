@extends('frontend.layouts.master')

@section('title', $product['name'] . ' | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')
<div class="shein-container" style="padding-top: 20px; padding-bottom: 80px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 20px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <a href="{{ route('frontend.category', $product['category']) }}" style="color: #444; text-transform: capitalize;">{{ $product['category'] }}</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 700;">{{ $product['name'] }}</span>
    </div>

    <!-- Product Details Main Layout -->
    <div style="display: grid; grid-template-columns: 56% 44%; gap: 40px; margin-bottom: 60px;">
        <!-- Left: Image Gallery -->
        <div>
            <div style="display: grid; grid-template-columns: 84px 1fr; gap: 16px;">
                <!-- Thumbnail Column -->
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <img src="{{ $product['image_primary'] }}" alt="Thumb 1" class="p-thumb active" style="width: 84px; height: 112px; object-fit: cover; border: 2px solid var(--shein-black); cursor: pointer; border-radius: 2px;" onclick="changeMainImg(this.src, this)">
                    <img src="{{ $product['image_hover'] }}" alt="Thumb 2" class="p-thumb" style="width: 84px; height: 112px; object-fit: cover; border: 1px solid #ddd; cursor: pointer; border-radius: 2px;" onclick="changeMainImg(this.src, this)">
                    <img src="{{ $product['image_primary'] }}" alt="Thumb 3" class="p-thumb" style="width: 84px; height: 112px; object-fit: cover; border: 1px solid #ddd; cursor: pointer; border-radius: 2px; filter: brightness(0.95);" onclick="changeMainImg(this.src, this)">
                </div>

                <!-- Main Display Image with Zoom Box -->
                <div style="position: relative; background: #f9f9f9; border-radius: 4px; overflow: hidden;">
                    <img id="detailMainImg" src="{{ $product['image_primary'] }}" alt="{{ $product['name'] }}" style="width: 100%; height: 620px; object-fit: cover; transition: transform 0.3s ease;">
                    @if(isset($product['discount']) && $product['discount'] > 0)
                        <span class="discount-badge" style="font-size: 13px; padding: 4px 10px; top: 12px; left: 12px;">-{{ $product['discount'] }}%</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Purchase Panel & Info -->
        <div style="display: flex; flex-direction: column;">
            <span style="font-size: 11px; font-weight: 800; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">{{ $product['brand'] ?? (get_setting('com_name') ?: 'FAST IT') }}</span>
            <h1 style="font-size: 22px; font-weight: 800; color: #222; margin: 6px 0 10px; line-height: 1.35;">{{ $product['name'] }}</h1>
            
            <div style="font-size: 11px; color: #767676; margin-bottom: 12px;">SKU: sw24{{ $product['id'] }}89402 • 10,000+ sold</div>

            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; font-size: 12px;">
                <span class="star-rating" style="font-size: 13px;"><i class="fa-solid fa-star"></i> {{ $product['rating'] }}</span>
                <span style="color: #666; text-decoration: underline; cursor: pointer;" onclick="scrollToReviews()">{{ number_format($product['reviews_count']) }} Reviews</span>
                <span style="color: #ddd;">|</span>
                <span style="color: #2E7D32; font-weight: 700;"><i class="fa-solid fa-circle-check"></i> In Stock</span>
            </div>

            <!-- Flash Sale Price Strip -->
            <div style="background: #FFF7F5; padding: 14px 18px; border-radius: 4px; border: 1px solid #FFE4DE; margin-bottom: 18px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div style="display: flex; align-items: baseline; gap: 12px;">
                        <span style="font-size: 28px; font-weight: 900; color: var(--shein-red);">RM {{ number_format($product['price'], 2) }}</span>
                        <span style="font-size: 15px; color: #999; text-decoration: line-through;">RM {{ number_format($product['original_price'], 2) }}</span>
                        <span class="discount-badge" style="position: static;">-{{ $product['discount'] }}% OFF</span>
                    </div>
                    <div style="font-size: 11px; font-weight: 800; color: #FA2C19; text-transform: uppercase;">
                        ⚡ FLASH DEAL
                    </div>
                </div>
                <div style="font-size: 11px; color: #9A6700; font-weight: 600;">
                    🪙 Buy now and earn <strong>+{{ floor($product['price']) }} {{ get_setting('com_name') ?: 'FAST IT' }} VIP Points</strong>
                </div>
            </div>

            <!-- Color Options -->
            <div style="margin-bottom: 18px;">
                <div style="font-size: 12px; font-weight: 700; margin-bottom: 8px;">
                    Select Color: <span id="chosenColorLabel" style="font-weight: 500; color: #666;">Black & White</span>
                </div>
                <div style="display: flex; gap: 10px;">
                    @foreach($product['colors'] as $c)
                        <span class="color-dot" style="width: 24px; height: 24px; background-color: {{ $c }}; border: 2px solid {{ $loop->first ? '#000' : '#ddd' }}; cursor: pointer;" onclick="selectProductColor('{{ $c }}', this)"></span>
                    @endforeach
                </div>
            </div>

            <!-- Size Options -->
            <div style="margin-bottom: 22px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 12px; font-weight: 700;">Select Size:</span>
                    <a href="javascript:void(0)" onclick="openSizeGuideModal()" style="font-size: 11px; text-decoration: underline; color: #666;">
                        <i class="fa-solid fa-ruler-horizontal"></i> Size Guide
                    </a>
                </div>
                <div class="size-pills" id="detailSizePills">
                    @foreach($product['sizes'] as $sz)
                        <button type="button" class="size-pill-btn {{ $loop->first ? 'active' : '' }}" onclick="selectDetailSize('{{ $sz }}', this)">
                            {{ $sz }}
                        </button>
                    @endforeach
                </div>
                <div style="font-size: 11px; color: #2E7D32; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                    <i class="fa-solid fa-circle-check"></i> 95% of buyers reported this fits true to size
                </div>
            </div>

            <!-- Quantity & Actions -->
            <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 24px;">
                <div class="cart-qty-ctrl" style="height: 48px;">
                    <button class="qty-btn" style="width: 36px; font-size: 16px;" onclick="adjustDetailQty(-1)">-</button>
                    <span class="qty-val" id="detailQtyVal" style="width: 44px; font-size: 14px;">1</span>
                    <button class="qty-btn" style="width: 36px; font-size: 16px;" onclick="adjustDetailQty(1)">+</button>
                </div>

                <button type="button" class="shein-btn-primary" style="flex: 2; height: 48px; font-size: 13px; letter-spacing: 1px; display: flex; align-items: center; justify-content: center; gap: 8px;" onclick="addDetailToBag()">
                    <i class="fa-solid fa-bag-shopping"></i> ADD TO BAG
                </button>

                <button type="button" class="wishlist-btn" style="position: static; width: 48px; height: 48px; font-size: 18px; border: 1px solid #ccc; border-radius: 2px;" data-id="{{ $product['id'] }}" onclick="toggleWishlist({{ json_encode($product) }})">
                    <i class="fa-regular fa-heart"></i>
                </button>
            </div>

            <!-- Guarantee Perks Box -->
            <div style="background: #fafafa; border: 1px solid #eee; padding: 16px; border-radius: 4px; font-size: 12px; line-height: 1.8; color: #444; margin-bottom: 24px;">
                <div>🚚 <strong>Free Shipping:</strong> On orders RM 120.00+ (Est. delivery 3-5 business days)</div>
                <div>🔄 <strong>Easy 20-Day Return:</strong> Return for free if sizing or fit is unsuitable</div>
                <div>💵 <strong>Cash on Delivery:</strong> Doorstep cash payment available in Malaysia</div>
                <div>🛡️ <strong>100% Genuine Quality:</strong> Official {{ get_setting('com_name') ?: 'FAST IT' }} standard inspection verified</div>
            </div>

            <!-- Specifications Table -->
            <div style="border-top: 1px solid #eee; padding-top: 16px;">
                <h4 style="font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 10px;">SPECIFICATIONS</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 11px; color: #666;">
                    <div>Style: <strong style="color: #222;">Casual / Commute</strong></div>
                    <div>Pattern: <strong style="color: #222;">Polka Dot / Floral</strong></div>
                    <div>Length: <strong style="color: #222;">Regular</strong></div>
                    <div>Fit Type: <strong style="color: #222;">Regular Fit</strong></div>
                    <div>Fabric: <strong style="color: #222;">Non-Stretch Chiffon</strong></div>
                    <div>Composition: <strong style="color: #222;">100% Polyester</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div id="reviewsSection" style="margin-top: 40px; border-top: 2px solid #222; padding-top: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h3 style="font-size: 20px; font-weight: 900; text-transform: uppercase; margin: 0;">CUSTOMER REVIEWS ({{ number_format($product['reviews_count']) }})</h3>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 6px;">
                    <span style="font-size: 24px; font-weight: 900; color: #222;">{{ $product['rating'] }}</span>
                    <div style="color: #FFB800; font-size: 14px;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <span style="font-size: 12px; color: #666;">Overall Rating</span>
                </div>
            </div>
            <button type="button" class="shein-btn-primary" style="padding: 10px 24px;" onclick="showToast('Review form opened for verified purchasers.')">
                WRITE A REVIEW
            </button>
        </div>

        <!-- Sample Reviews -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div style="background: #fafafa; padding: 18px; border-radius: 4px; border: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-weight: 700; font-size: 12px;">Nurul A. 🇲🇾 <span style="color: #2E7D32; font-size: 10px;">✓ Verified Purchase</span></span>
                    <span style="color: #FFB800; font-size: 11px;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                </div>
                <div style="font-size: 11px; color: #888; margin-bottom: 6px;">Size: M • Fit: True to size</div>
                <p style="font-size: 12px; color: #333; line-height: 1.5; margin: 0;">Super pretty blouse! Material is lightweight and very comfortable for Malaysian weather. Received in 4 days!</p>
            </div>

            <div style="background: #fafafa; padding: 18px; border-radius: 4px; border: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-weight: 700; font-size: 12px;">Chloe T. 🇲🇾 <span style="color: #2E7D32; font-size: 10px;">✓ Verified Purchase</span></span>
                    <span style="color: #FFB800; font-size: 11px;"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                </div>
                <div style="font-size: 11px; color: #888; margin-bottom: 6px;">Size: S • Fit: True to size</div>
                <p style="font-size: 12px; color: #333; line-height: 1.5; margin: 0;">Love the puff sleeves design! Fits nicely and looks identical to the photoshoot. Worth every ringgit.</p>
            </div>
        </div>
    </div>

    <!-- Related Products Showcase -->
    <div style="margin-top: 60px;">
        <h3 style="font-size: 20px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px;">YOU MAY ALSO LIKE</h3>
        <div class="shein-product-grid" style="grid-template-columns: repeat(6, 1fr);">
            @foreach($relatedProducts as $rel)
                <div class="product-card">
                    <div class="product-image-box">
                        <a href="{{ route('frontend.product', $rel['id']) }}">
                            <img src="{{ $rel['image_primary'] }}" alt="{{ $rel['name'] }}" class="img-primary" loading="lazy">
                            <img src="{{ $rel['image_hover'] }}" alt="{{ $rel['name'] }}" class="img-hover" loading="lazy">
                        </a>
                        <button type="button" class="wishlist-btn" data-id="{{ $rel['id'] }}" onclick="toggleWishlist({{ json_encode($rel) }})">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        @if(isset($rel['discount']) && $rel['discount'] > 0)
                            <span class="discount-badge">-{{ $rel['discount'] }}%</span>
                        @endif
                        <div class="quick-add-trigger" onclick="openQuickModal({{ json_encode($rel) }})">
                            <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                        </div>
                    </div>
                    <div class="product-info-box">
                        <div class="product-brand">{{ $rel['brand'] }}</div>
                        <a href="{{ route('frontend.product', $rel['id']) }}" class="product-title">{{ $rel['name'] }}</a>
                        <div class="product-pricing">
                            <span class="current-price is-sale-price">RM {{ number_format($rel['price'], 2) }}</span>
                            <span class="original-price">RM {{ number_format($rel['original_price'], 2) }}</span>
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
        <button onclick="closeSizeGuideModal()" style="position: absolute; top: 16px; right: 16px; font-size: 20px;"><i class="fa-solid fa-xmark"></i></button>
        <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin-bottom: 16px;">{{ strtoupper(get_setting('com_name') ?: 'FAST IT') }} SIZE GUIDE (CM)</h3>
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
@endsection

@push('scripts')
<script>
    let selectedSize = "{{ $product['sizes'][0] ?? 'M' }}";
    let detailQty = 1;

    function changeMainImg(src, thumb) {
        document.getElementById('detailMainImg').src = src;
        document.querySelectorAll('.p-thumb').forEach(t => t.style.border = '1px solid #ddd');
        thumb.style.border = '2px solid var(--shein-black)';
    }

    function selectDetailSize(sz, btn) {
        selectedSize = sz;
        document.querySelectorAll('#detailSizePills .size-pill-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function adjustDetailQty(delta) {
        detailQty = Math.max(1, detailQty + delta);
        document.getElementById('detailQtyVal').innerText = detailQty;
    }

    function addDetailToBag() {
        const item = @json($product);
        for(let i=0; i<detailQty; i++) {
            addToBag(item, selectedSize);
        }
    }

    function selectProductColor(color, dot) {
        document.querySelectorAll('.color-dot').forEach(d => d.style.border = '2px solid #ddd');
        dot.style.border = '2px solid #000';
        showToast('Color variant selected: ' + color);
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
</script>
@endpush
