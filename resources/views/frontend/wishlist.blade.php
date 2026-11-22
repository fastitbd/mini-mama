@extends('frontend.layouts.master')

@section('title', 'My Wishlist | ' . (get_setting('com_name') ?: 'FAST IT'))

@section('content')
<div class="shein-container" style="padding-top: 24px; padding-bottom: 80px;">
    <!-- Breadcrumb -->
    <div style="font-size: 11px; color: #767676; margin-bottom: 20px;">
        <a href="{{ route('frontend.home') }}" style="color: #444;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #111; font-weight: 600;">My Wishlist</span>
    </div>

    <!-- Wishlist Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #222; padding-bottom: 16px; margin-bottom: 28px;">
        <div>
            <h1 style="font-size: 22px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                MY WISHLIST (<span id="wishlistPageCount">0</span>)
            </h1>
            <p style="font-size: 12px; color: #767676; margin: 4px 0 0 0;">Save your favorite fashion items and get notified when prices drop.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button type="button" class="shein-btn-primary" style="padding: 10px 20px;" onclick="moveAllWishlistToBag()">
                <i class="fa-solid fa-bag-shopping"></i> MOVE ALL TO BAG
            </button>
            <button type="button" onclick="clearFullWishlist()" style="font-size: 12px; color: #888; text-decoration: underline;">
                Clear Wishlist
            </button>
        </div>
    </div>

    <!-- Wishlist Grid -->
    <div class="shein-product-grid" id="wishlistItemsGrid">
        <!-- Rendered via JavaScript -->
    </div>

    <!-- Empty Wishlist View -->
    <div id="emptyWishlistView" style="display: none; text-align: center; padding: 70px 20px; background: #fafafa; border: 1px dashed #ddd; border-radius: 4px; margin-bottom: 40px;">
        <i class="fa-regular fa-heart" style="font-size: 60px; color: #ccc; margin-bottom: 16px;"></i>
        <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 6px;">Your Wishlist is currently empty</h2>
        <p style="color: #767676; font-size: 13px; margin-bottom: 24px;">Explore our fresh arrivals, best sellers, and exclusive fashion deals!</p>
        <a href="{{ route('frontend.category', 'sale') }}" class="shein-btn-primary" style="display: inline-block; padding: 12px 32px; font-size: 13px; text-decoration: none;">
            EXPLORE BEST SELLERS
        </a>
    </div>

    <!-- Recommended for you Section -->
    <div style="margin-top: 60px;">
        <div class="section-header">
            <h3 style="font-size: 18px; font-weight: 800; text-transform: uppercase; margin: 0;">RECOMMENDED FOR YOU</h3>
            <a href="{{ route('frontend.category', 'trending') }}" class="view-all-link">View More <i class="fa-solid fa-chevron-right"></i></a>
        </div>
        <div class="shein-product-grid">
            <div class="product-card">
                <div class="product-image-box">
                    <a href="{{ url('/product/101') }}">
                        <img src="//img.ltwebstatic.com/images3_pi/2025/03/20/82/1742462671a1240a0a25a837d2e0819b6910605858_thumbnail_405x552.jpg" alt="Lip Combo" class="img-primary">
                        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?q=80&w=600&auto=format&fit=crop" alt="Lip Combo Hover" class="img-hover">
                    </a>
                    <span class="discount-badge">-34%</span>
                    <div class="quick-add-trigger" onclick="addToBag({id:101, name:'SHEGLAM Bold Booster Lip Plumper', price:21, image:'//img.ltwebstatic.com/images3_pi/2025/03/20/82/1742462671a1240a0a25a837d2e0819b6910605858_thumbnail_405x552.jpg'})">
                        <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                    </div>
                </div>
                <div class="product-info-box">
                    <div class="product-brand">SHEGLAM</div>
                    <a href="{{ url('/product/101') }}" class="product-title">SHEGLAM Bold Booster Lip Plumper Lip Combo Makeup</a>
                    <div class="product-pricing">
                        <span class="current-price is-sale-price">RM 21.00</span>
                        <span class="original-price">RM 32.00</span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-box">
                    <a href="{{ url('/product/102') }}">
                        <img src="//img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_405x552.jpg" alt="Blouse" class="img-primary">
                        <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=600&auto=format&fit=crop" alt="Blouse Hover" class="img-hover">
                    </a>
                    <span class="discount-badge">-50%</span>
                    <div class="quick-add-trigger" onclick="addToBag({id:102, name:'Siren Gaze Women Polka Dot Blouse', price:37, image:'//img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_405x552.jpg'})">
                        <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                    </div>
                </div>
                <div class="product-info-box">
                    <div class="product-brand">DAZY</div>
                    <a href="{{ url('/product/102') }}" class="product-title">Siren Gaze Women Polka Dot Puff Sleeve French Blouse</a>
                    <div class="product-pricing">
                        <span class="current-price is-sale-price">RM 37.00</span>
                        <span class="original-price">RM 74.00</span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-box">
                    <a href="{{ url('/product/103') }}">
                        <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=600&auto=format&fit=crop" alt="Jeans" class="img-primary">
                        <img src="https://images.unsplash.com/photo-1584370848010-d7fe6bc767ec?q=80&w=600&auto=format&fit=crop" alt="Jeans Hover" class="img-hover">
                    </a>
                    <span class="discount-badge">-62%</span>
                    <div class="quick-add-trigger" onclick="addToBag({id:103, name:'High Waist Straight Leg Denim Jeans', price:26, image:'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=600&auto=format&fit=crop'})">
                        <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                    </div>
                </div>
                <div class="product-info-box">
                    <div class="product-brand">ROMWE</div>
                    <a href="{{ url('/product/103') }}" class="product-title">High Waist Straight Leg Vintage Washed Classic Denim Jeans</a>
                    <div class="product-pricing">
                        <span class="current-price is-sale-price">RM 26.00</span>
                        <span class="original-price">RM 68.00</span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-box">
                    <a href="{{ url('/product/104') }}">
                        <img src="https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=600&auto=format&fit=crop" alt="Bag" class="img-primary">
                        <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=600&auto=format&fit=crop" alt="Bag Hover" class="img-hover">
                    </a>
                    <span class="discount-badge">-68%</span>
                    <div class="quick-add-trigger" onclick="addToBag({id:104, name:'Minimalist Crocodile Embossed Bag', price:14.5, image:'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=600&auto=format&fit=crop'})">
                        <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                    </div>
                </div>
                <div class="product-info-box">
                    <div class="product-brand">{{ strtoupper(get_setting('com_name') ?: 'FAST IT') }}</div>
                    <a href="{{ url('/product/104') }}" class="product-title">Minimalist Crocodile Embossed Shoulder Chain Flap Bag</a>
                    <div class="product-pricing">
                        <span class="current-price is-sale-price">RM 14.50</span>
                        <span class="original-price">RM 45.00</span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-box">
                    <a href="{{ url('/product/105') }}">
                        <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop" alt="Sandals" class="img-primary">
                        <img src="https://images.unsplash.com/photo-1562273138-f46be4ebdf33?q=80&w=600&auto=format&fit=crop" alt="Sandals Hover" class="img-hover">
                    </a>
                    <span class="discount-badge">-64%</span>
                    <div class="quick-add-trigger" onclick="addToBag({id:105, name:'Faux Pearl Strap Chunky Low Heel Sandals', price:28, image:'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop'})">
                        <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                    </div>
                </div>
                <div class="product-info-box">
                    <div class="product-brand">CUCCOO</div>
                    <a href="{{ url('/product/105') }}" class="product-title">Faux Pearl Strap Chunky Low Heel Ankle Strap Sandals</a>
                    <div class="product-pricing">
                        <span class="current-price is-sale-price">RM 28.00</span>
                        <span class="original-price">RM 78.00</span>
                    </div>
                </div>
            </div>

            <div class="product-card">
                <div class="product-image-box">
                    <a href="{{ url('/product/106') }}">
                        <img src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=600&auto=format&fit=crop" alt="Dress" class="img-primary">
                        <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=600&auto=format&fit=crop" alt="Dress Hover" class="img-hover">
                    </a>
                    <span class="discount-badge">-60%</span>
                    <div class="quick-add-trigger" onclick="addToBag({id:106, name:'Ruched Drawstring Waist Split Midi Dress', price:23.5, image:'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=600&auto=format&fit=crop'})">
                        <i class="fa-solid fa-bag-shopping"></i> QUICK ADD
                    </div>
                </div>
                <div class="product-info-box">
                    <div class="product-brand">MOTF</div>
                    <a href="{{ url('/product/106') }}" class="product-title">Ruched Drawstring Waist Split Hem Midi Bodycon Dress</a>
                    <div class="product-pricing">
                        <span class="current-price is-sale-price">RM 23.50</span>
                        <span class="original-price">RM 59.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        renderWishlistPage();
    });

    function renderWishlistPage() {
        const grid = document.getElementById('wishlistItemsGrid');
        const emptyView = document.getElementById('emptyWishlistView');
        const countSpan = document.getElementById('wishlistPageCount');

        if (!grid || !emptyView) return;

        countSpan.innerText = sheinWishlist.length;

        if (sheinWishlist.length === 0) {
            grid.innerHTML = '';
            grid.style.display = 'none';
            emptyView.style.display = 'block';
            return;
        }

        grid.style.display = 'grid';
        emptyView.style.display = 'none';

        let html = '';
        sheinWishlist.forEach((item, idx) => {
            const img = item.image_primary || item.image || item.img;
            const price = parseFloat(item.price);
            const origPrice = parseFloat(item.original_price || item.orig_price || price * 1.8);
            const disc = item.discount || Math.round((1 - price / origPrice) * 100);

            html += `
                <div class="product-card" id="wishCard_${idx}">
                    <div class="product-image-box">
                        <a href="{{ url('/product') }}/${item.id}">
                            <img src="${img}" alt="${item.name}" class="img-primary">
                        </a>
                        <button type="button" class="wishlist-btn active" onclick="removeWishlistItem(${idx})" title="Remove from Wishlist">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        ${disc > 0 ? `<span class="discount-badge">-${disc}%</span>` : ''}
                    </div>

                    <div class="product-info-box">
                        <div class="product-brand">${item.brand || {!! json_encode(get_setting('com_name') ?: 'FAST IT') !!}}</div>
                        <a href="{{ url('/product') }}/${item.id}" class="product-title">${item.name}</a>
                        
                        <div class="product-pricing">
                            <span class="current-price is-sale-price">RM ${price.toFixed(2)}</span>
                            <span class="original-price">RM ${origPrice.toFixed(2)}</span>
                        </div>

                        <button type="button" class="shein-btn-primary" style="width: 100%; margin-top: 8px; padding: 8px 0; font-size: 11px;" onclick="moveItemToBag(${idx})">
                            <i class="fa-solid fa-bag-shopping"></i> MOVE TO BAG
                        </button>
                    </div>
                </div>
            `;
        });

        grid.innerHTML = html;
    }

    function removeWishlistItem(idx) {
        sheinWishlist.splice(idx, 1);
        localStorage.setItem('shein_wishlist', JSON.stringify(sheinWishlist));
        refreshWishlistUI();
        renderWishlistPage();
        showToast('Item removed from wishlist');
    }

    function clearFullWishlist() {
        if (!confirm('Are you sure you want to clear your entire wishlist?')) return;
        sheinWishlist = [];
        localStorage.setItem('shein_wishlist', JSON.stringify(sheinWishlist));
        refreshWishlistUI();
        renderWishlistPage();
        showToast('Wishlist cleared');
    }

    function moveItemToBag(idx) {
        const item = sheinWishlist[idx];
        if (!item) return;
        addToBag(item, 'M');
        sheinWishlist.splice(idx, 1);
        localStorage.setItem('shein_wishlist', JSON.stringify(sheinWishlist));
        refreshWishlistUI();
        renderWishlistPage();
    }

    function moveAllWishlistToBag() {
        if (sheinWishlist.length === 0) {
            showToast('Wishlist is empty.');
            return;
        }
        sheinWishlist.forEach(item => {
            addToBag(item, 'M');
        });
        sheinWishlist = [];
        localStorage.setItem('shein_wishlist', JSON.stringify(sheinWishlist));
        refreshWishlistUI();
        renderWishlistPage();
        showToast('🎉 All items moved to your shopping bag!');
    }
</script>
@endpush
