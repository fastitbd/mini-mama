<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * SHEIN Malaysia Homepage
     */
    public function index()
    {
        $categories = $this->getCategories();
        $circularCategories = $this->getCircularCategories();
        $heroBanners = $this->getHeroBanners();
        $banners = $heroBanners;
        $vouchers = $this->getVouchers();
        $flashSales = $this->getFlashSaleProducts();
        $promoCards = $this->getPromoCards();
        $recommendedProducts = $this->getRecommendedProducts();
        $instagramLooks = $this->getInstagramLooks();

        // Dynamic Store Sections & Products from Database
        $storeSections = \App\Models\StoreSection::active()->get()->keyBy('key');

        $superDeals = \App\Models\Product::active()->where('section', 'super_deals')->orderBy('id', 'asc')->take(6)->get();
        if ($superDeals->count() < 3) {
            $extra = \App\Models\Product::active()->where('section', '!=', 'trends')->orderBy('id', 'asc')->take(3 - $superDeals->count())->get();
            $superDeals = $superDeals->concat($extra);
        }

        $trends = \App\Models\Product::active()->where('section', 'trends')->orderBy('id', 'asc')->take(6)->get();
        if ($trends->count() < 3) {
            $extra = \App\Models\Product::active()->where('section', '!=', 'super_deals')->orderBy('id', 'asc')->take(3 - $trends->count())->get();
            $trends = $trends->concat($extra);
        }

        $dbProducts = \App\Models\Product::active()->with(['category', 'subCategory'])
            ->where(function($q) {
                $q->whereNull('section')
                  ->orWhere('section', 'featured')
                  ->orWhere('section', 'none')
                  ->orWhere('section', '');
            })
            ->orderBy('id', 'asc')
            ->take(50)
            ->get();
        if ($dbProducts->isEmpty()) {
            $dbProducts = \App\Models\Product::active()->with(['category', 'subCategory'])->orderBy('id', 'asc')->take(50)->get();
        }

        return view('frontend.home', compact(
            'categories',
            'circularCategories',
            'heroBanners',
            'banners',
            'vouchers',
            'flashSales',
            'promoCards',
            'recommendedProducts',
            'instagramLooks',
            'superDeals',
            'trends',
            'storeSections',
            'dbProducts'
        ));
    }

    /**
     * Category / Product Listing Page
     */
    /**
     * Map a Database Product model to array format for views
     */
    protected function formatProductModel($dbProduct)
    {
        $catSlug = $dbProduct->category ? ($dbProduct->category->slug ?: strtolower(str_replace(' ', '-', $dbProduct->category->name))) : 'clothing';
        $brandName = $dbProduct->brand?->name ?: (function_exists('get_setting') && get_setting('com_name') ? get_setting('com_name') : 'FAST IT');
        
        return [
            'id' => $dbProduct->id,
            'name' => $dbProduct->name,
            'category' => $catSlug,
            'category_id' => $dbProduct->category_id,
            'brand' => $brandName,
            'price' => (float)$dbProduct->selling_price,
            'original_price' => (float)($dbProduct->dis_selling_price ?: round($dbProduct->selling_price * 1.35, 2)),
            'discount' => $dbProduct->discount ? (int)$dbProduct->discount : 20,
            'rating' => 4.90,
            'reviews_count' => 1250,
            'sold_count' => '5.2k',
            'claimed_pct' => 65,
            'image_primary' => $dbProduct->image_url,
            'image_hover' => $dbProduct->image_url,
            'colors' => ['#111111', '#e8dfd8'],
            'sizes' => ['S', 'M', 'L', 'XL'],
            'description' => $dbProduct->description ?: 'Premium quality stylish apparel designed for modern fashion elegance.',
        ];
    }

    /**
     * Category / Product Listing Page
     */
    public function category(Request $request, $slug = null)
    {
        $categories = $this->getCategories();
        
        $dbProducts = \App\Models\Product::active()->with(['category', 'subCategory', 'brand'])->get()->map(function($p) {
            return $this->formatProductModel($p);
        })->toArray();

        $allProducts = array_merge($dbProducts, $this->getRecommendedProducts(), $this->getFlashSaleProducts());
        
        $dbCategory = null;
        if ($slug && $slug !== 'all') {
            $dbCategory = \App\Models\Category::where('slug', $slug)->orWhere('id', $slug)->first();
        }

        $currentCategory = $dbCategory ? $dbCategory->name : ($slug ? ucwords(str_replace('-', ' ', $slug)) : 'All Women Clothing');
        
        $filtered = collect($allProducts);
        if ($slug && $slug !== 'all') {
            $filtered = $filtered->filter(function($p) use ($slug, $currentCategory, $dbCategory) {
                if ($dbCategory && isset($p['category_id']) && $p['category_id'] == $dbCategory->id) {
                    return true;
                }
                return strtolower($p['category']) === strtolower($slug) || 
                       str_contains(strtolower($p['name']), strtolower(str_replace('-', ' ', $slug))) ||
                       str_contains(strtolower($p['name']), strtolower($currentCategory));
            });
            if ($filtered->isEmpty()) {
                $filtered = collect($allProducts);
            }
        }

        $sort = $request->get('sort', 'recommend');
        if ($sort === 'price_asc') {
            $filtered = $filtered->sortBy('price');
        } elseif ($sort === 'price_desc') {
            $filtered = $filtered->sortByDesc('price');
        } elseif ($sort === 'rating') {
            $filtered = $filtered->sortByDesc('rating');
        }

        $products = $filtered->values()->all();

        return view('frontend.category', compact('categories', 'products', 'currentCategory', 'slug', 'sort'));
    }

    /**
     * Product Details Page
     */
    public function product($id)
    {
        $categories = $this->getCategories();
        $dbProduct = \App\Models\Product::with(['category', 'brand'])->find($id);

        if ($dbProduct) {
            $product = $this->formatProductModel($dbProduct);
            $relatedProducts = \App\Models\Product::active()
                ->where('id', '!=', $dbProduct->id)
                ->take(6)
                ->get()
                ->map(fn($p) => $this->formatProductModel($p))
                ->toArray();
            if (empty($relatedProducts)) {
                $allRec = $this->getRecommendedProducts();
                $relatedProducts = array_slice($allRec, 0, 6);
            }
        } else {
            $allProducts = array_merge($this->getRecommendedProducts(), $this->getFlashSaleProducts());
            $product = collect($allProducts)->firstWhere('id', (int)$id) ?: $allProducts[0];
            $relatedProducts = collect($allProducts)->where('id', '!=', $product['id'])->take(6)->values()->all();
        }

        return view('frontend.product-detail', compact('categories', 'product', 'relatedProducts'));
    }

    /**
     * Search Products
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $categories = $this->getCategories();

        $dbProducts = \App\Models\Product::active()->with(['category', 'subCategory', 'brand'])->get()->map(function($p) {
            return $this->formatProductModel($p);
        })->toArray();

        $allProducts = array_merge($dbProducts, $this->getRecommendedProducts(), $this->getFlashSaleProducts());

        $filtered = collect($allProducts)->filter(function($p) use ($query) {
            return str_contains(strtolower($p['name']), strtolower($query)) ||
                   str_contains(strtolower($p['category']), strtolower($query)) ||
                   str_contains(strtolower($p['brand']), strtolower($query));
        })->values()->all();

        $currentCategory = 'Search results for "' . htmlspecialchars($query) . '" (' . count($filtered) . ' items)';
        $products = $filtered;
        $slug = 'search';
        $sort = 'recommend';

        return view('frontend.category', compact('categories', 'products', 'currentCategory', 'slug', 'sort', 'query'));
    }

    /**
     * Dedicated Shopping Bag Page
     */
    public function cart()
    {
        $categories = $this->getCategories();
        return view('frontend.cart', compact('categories'));
    }

    /**
     * Dedicated Wishlist Page
     */
    public function wishlist()
    {
        $categories = $this->getCategories();
        return view('frontend.wishlist', compact('categories'));
    }

    /**
     * Shein-styled Login / Register Page
     */
    public function authPage()
    {
        $categories = $this->getCategories();
        return view('frontend.auth.login', compact('categories'));
    }

    /**
     * Blog Page
     */
    public function blog()
    {
        return view('frontend.blog');
    }

    /**
     * Contact Us Page
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * SHEIN Malaysia 1:1 Checkout Page
     */
    public function checkout()
    {
        $categories = $this->getCategories();
        $sampleProducts = $this->getRecommendedProducts();
        return view('frontend.checkout', compact('categories', 'sampleProducts'));
    }

    /**
     * Process Order Placement
     */
    public function placeOrder(Request $request)
    {
        $orderNumber = 'CB-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        
        $fullName = trim(($request->input('first_name', '') . ' ' . $request->input('last_name', '')));
        if (empty($fullName)) {
            $fullName = 'Website Customer';
        }

        $cartItems = json_decode($request->input('cart_items_json', '[]'), true) ?: [];
        $subtotal = (float)$request->input('order_subtotal', 85.00);
        $shippingFee = (float)$request->input('shipping_fee', 0.00);
        $discount = (float)$request->input('order_discount', 0.00);
        $total = (float)$request->input('order_total', ($subtotal + $shippingFee - $discount));

        $webOrder = \App\Models\WebsiteOrder::create([
            'order_no' => $orderNumber,
            'customer_name' => $fullName,
            'customer_email' => $request->input('email', function_exists('get_setting') && get_setting('com_email') ? get_setting('com_email') : 'customer@fastit.com'),
            'customer_phone' => $request->input('phone', '01910-405112'),
            'customer_address' => $request->input('address', 'No. 45, Jalan Ampang Hilir 2'),
            'customer_city' => $request->input('city', 'Kuala Lumpur'),
            'customer_state' => $request->input('state', 'Wilayah Persekutuan Kuala Lumpur'),
            'customer_postcode' => $request->input('postcode', '55000'),
            'customer_country' => $request->input('country', 'Malaysia'),
            'status' => 'processing',
            'courier_service' => 'Steadfast Courier',
            'stock_transfer_mode' => 'Without Manage Stock (Direct Transfer)',
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'discount' => $discount,
            'total_amount' => $total,
            'payment_method' => $request->input('payment_method', 'Cash On Delivery (COD)'),
            'note' => $request->input('order_note', 'Order placed via Online Website Checkout'),
            'note_updated_at' => now(),
            'tags' => 'Website',
            'site' => 'Website',
            'ip_address' => $request->ip(),
        ]);

        if (!empty($cartItems)) {
            foreach ($cartItems as $item) {
                $prodId = isset($item['id']) ? (int)$item['id'] : null;
                $dbProduct = $prodId ? \App\Models\Product::find($prodId) : null;
                $qty = max(1, (int)($item['qty'] ?? 1));
                $price = (float)($item['price'] ?? ($dbProduct ? $dbProduct->selling_price : 0));
                
                \App\Models\WebsiteOrderItem::create([
                    'website_order_id' => $webOrder->id,
                    'product_id' => $dbProduct ? $dbProduct->id : $prodId,
                    'product_name' => $item['name'] ?? ($dbProduct ? $dbProduct->name : 'Product'),
                    'product_code' => $dbProduct ? ($dbProduct->barcode ?: (string)$dbProduct->id) : ($item['sku'] ?? 'SKU-001'),
                    'product_image' => $dbProduct ? ($dbProduct->images ?: null) : ($item['image'] ?? null),
                    'size' => $item['size'] ?? 'M',
                    'color' => $item['color'] ?? 'Standard',
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $price * $qty,
                ]);
            }
        } else {
            // Seed sample item for order if cart was empty
            $dbProduct = \App\Models\Product::first();
            \App\Models\WebsiteOrderItem::create([
                'website_order_id' => $webOrder->id,
                'product_id' => $dbProduct ? $dbProduct->id : null,
                'product_name' => $dbProduct ? $dbProduct->name : 'Action Camera 4K Ultra HD',
                'product_code' => $dbProduct ? $dbProduct->barcode : '128176',
                'product_image' => $dbProduct ? $dbProduct->images : null,
                'size' => 'M',
                'color' => 'Black',
                'quantity' => 1,
                'unit_price' => $total,
                'subtotal' => $total,
            ]);
        }

        $orderData = [
            'order_number' => $orderNumber,
            'name' => $fullName,
            'email' => $webOrder->customer_email,
            'phone' => $webOrder->customer_phone,
            'address' => $webOrder->customer_address,
            'city' => $webOrder->customer_city,
            'state' => $webOrder->customer_state,
            'postcode' => $webOrder->customer_postcode,
            'country' => $webOrder->customer_country,
            'shipping_method' => $request->input('shipping_method', 'Standard Shipping (5-8 Business Days)'),
            'shipping_fee' => $shippingFee,
            'payment_method' => $webOrder->payment_method,
            'items' => $cartItems,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'created_at' => now()->format('d M Y, h:i A'),
            'est_delivery' => now()->addDays(5)->format('d M Y') . ' - ' . now()->addDays(8)->format('d M Y'),
        ];

        session(['latest_order' => $orderData]);

        return redirect()->route('frontend.order_confirmation', ['order_number' => $orderNumber]);
    }

    /**
     * SHEIN Order Confirmation Page
     */
    public function orderConfirmation($order_number = null)
    {
        $categories = $this->getCategories();
        $order = session('latest_order');

        if (!$order || ($order_number && $order['order_number'] !== $order_number)) {
            // Default sample order data for preview or direct navigation
            $order = [
                'order_number' => $order_number ?: ('MY-SH' . date('Ymd') . '-89412'),
                'name' => 'Siti Aisyah Binti Abdullah',
                'email' => 'siti.aisyah@gmail.com',
                'phone' => '+60 18-987 6543',
                'address' => 'No. 45, Jalan Ampang Hilir 2, Taman Ampang',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan Kuala Lumpur',
                'postcode' => '55000',
                'country' => 'Malaysia',
                'shipping_method' => 'Standard Express Shipping (5-8 Days)',
                'shipping_fee' => 0.00,
                'payment_method' => 'Cash On Delivery (Doorstep Payment)',
                'items' => [
                    [
                        'id' => 101,
                        'name' => "Aloruh Women's Elegant Chiffon Contrast Lace Blouse White",
                        'price' => 54.00,
                        'size' => 'M',
                        'qty' => 1,
                        'image' => '//img.ltwebstatic.com/v4/j/pi/2025/08/20/a7/175567516072f9ba261241443373b007e93789199a_thumbnail_405x552.jpg'
                    ],
                    [
                        'id' => 102,
                        'name' => "Siren Gaze Casual Polka Dot Puff Sleeve Blouse",
                        'price' => 37.00,
                        'size' => 'S',
                        'qty' => 1,
                        'image' => '//img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_405x552.jpg'
                    ]
                ],
                'subtotal' => 91.00,
                'discount' => 10.00,
                'total' => 81.00,
                'created_at' => now()->format('d M Y, h:i A'),
                'est_delivery' => now()->addDays(5)->format('d M Y') . ' - ' . now()->addDays(7)->format('d M Y'),
            ];
        }

        $recommendedProducts = collect($this->getRecommendedProducts())->take(4)->all();

        return view('frontend.order-confirmation', compact('categories', 'order', 'recommendedProducts'));
    }

    /**
     * 31 Authentic Shein Categories with Real CDN Icons
     */
    public function getCircularCategories()
    {
        return [
            ['name' => 'Women', 'slug' => 'women', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz260330232098723513800/4c972a6dc26b4600687733c68b676b62_square.png'],
            ['name' => 'Jewelry & Accessories', 'slug' => 'jewelry-accessories', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/18/6e/1787024681e512d4992a41811a8ebf7be85a9d8236.png'],
            ['name' => 'Shoes', 'slug' => 'shoes', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e.png'],
            ['name' => 'Curve', 'slug' => 'curve', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25081445475968138/76af6eee33235080040fb6ad85c56d3d_square.png'],
            ['name' => 'Cell Phones', 'slug' => 'cell-phones-accessories', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/b6/17796970859bcf7fec1a6b858fd5d362cbd1293c59.png'],
            ['name' => 'Beachwear', 'slug' => 'beachwear', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square.png'],
            ['name' => 'Kids', 'slug' => 'kids', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/08/05/c1/17858976987d88a71a4713528a97cd7f4336a03a21.png'],
            ['name' => 'Beauty & Health', 'slug' => 'beauty-health', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/e4/17796845646659de028d2b8e578b3b3e88f084df6b.png'],
            ['name' => 'Home & Living', 'slug' => 'home-living', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/a5/1779713729f38fb9fbebe6c78c47f9d37788348b10.png'],
            ['name' => 'Men', 'slug' => 'men', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/16/de/177634559252166f7d708bdb97192f6415e77c7a46.png'],
            ['name' => 'Underwear & Sleep', 'slug' => 'underwear-sleepwear', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/16/29/1776343747e796e46a67953920a0804ee6be38dafb.png'],
            ['name' => 'Bags & Luggage', 'slug' => 'bags-luggage', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/17/8b/17764147052b6836ac6c87ccff7cd3f77563ce3a06.png'],
            ['name' => 'Outerwear', 'slug' => 'outerwear-suits', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/06/15/17/1781526351f510a50f3c401c874f8c2c6684174d96.png'],
            ['name' => 'Toys & Games', 'slug' => 'toys-games', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/26/38/177973662973874f7418b41bd3d1370bf9a219e3d7.png'],
            ['name' => 'Sports & Outdoor', 'slug' => 'sports-outdoor', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/22/bc/17768517739d1a9c0a323e7f5a5090fc27fecbdc19.png'],
            ['name' => 'Tops', 'slug' => 'tops', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/20/d4/17872350397b0f2aaf00a8cdcd6153f7cf00a9dd42.png'],
            ['name' => 'Baby & Maternity', 'slug' => 'baby-maternity', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/08/05/85/17858976516842e537bb505daa1b3175567222f079.png'],
            ['name' => 'Dresses', 'slug' => 'dresses', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz2304180648932784/27afb52dc9c5d1e658eef10275e6222f_square.png'],
            ['name' => 'Bottoms', 'slug' => 'bottoms', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25042532213621765/7fe7b9ddba437cd13887d28b0a896dc0_square.png'],
            ['name' => 'Knitwear', 'slug' => 'knitwear', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz251117770548441517/df1456bd7e7cc528769b49342d93a022_square.png'],
            ['name' => 'Co-ords', 'slug' => 'co-ords', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz251112957086312380/319778cd197cf278d5fd3c3d7104daeb_square.png'],
            ['name' => 'Denim', 'slug' => 'denim', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sw2208013981724119/3b7e449064622bb22f81d26afac070a8_square.png'],
            ['name' => 'Office Supplies', 'slug' => 'office-school-supplies', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/21/e0/17767701646568e0a18ac3ec0d6dcbdbdf0a280e37.png'],
            ['name' => 'Customization', 'slug' => 'customization', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/05/27/24/17798683068de1a624adb6da40dd63340ed7a832a0.png'],
            ['name' => 'Automotive', 'slug' => 'automotive', 'image' => 'http://img.ltwebstatic.com/v4/p/pics1/2026/04/16/59/1776349463b4452b2dca8a834ab755b4ec1e0fe0cd.png'],
            ['name' => 'Electronics', 'slug' => 'electronics', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/9b/17797041723d3e0cc190ef8fd747b4c770e098900e.png'],
            ['name' => 'Pet Supplies', 'slug' => 'pet-supplies', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/04/17/2a/17764292970b8a8c66b1a1dba53f505a16a06f8a40.png'],
            ['name' => 'Bodysuits', 'slug' => 'jumpsuits-bodysuits', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25100907851752215/7a91389e83faaaf313bf425efd35eef6_square.png'],
            ['name' => 'Tools & Home', 'slug' => 'tools-home-improvement', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/26/3f/17797805547b79d66d12151d7d1a01e7eaaef62296.png'],
            ['name' => 'Home Textile', 'slug' => 'home-textile', 'image' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/17/22/1776429728b057a22a834c8f948342563547a4bc14.png'],
            ['name' => 'Appliances', 'slug' => 'home-appliances', 'image' => 'http://img.ltwebstatic.com/v4/p/pics1/2026/04/16/d6/177635046572b5d147b128c73519593e9f5a3b09c4.png'],
        ];
    }

    /**
     * Shein Categories & Mega Menu Dictionary
     */
    public function getCategories()
    {
        return [
            [
                'name' => 'NEW IN',
                'slug' => 'new-in',
                'badge' => 'NEW',
                'mega_menu' => [
                    'Trending' => ['Daily Drops', 'Best Sellers', 'Autumn Edit', 'Vacation Shop', 'Festival Chic'],
                    'Clothing' => ['Dresses', 'Tops & Tees', 'Blouses & Shirts', 'Two-Piece Outfits', 'Cargo Pants'],
                    'Accessories' => ['Jewelry', 'Bags', 'Footwear', 'Hats & Belts', 'Sunglasses'],
                    'Featured' => ['FAST IT Exclusive', 'MOTF Premium', 'DAZY Asian Chic', 'ROMWE Streetwear'],
                    'banner' => 'https://img.ltwebstatic.com/images3_pi/2025/03/20/82/1742462671a1240a0a25a837d2e0819b6910605858_thumbnail_405x552.jpg'
                ]
            ],
            [
                'name' => 'SALE',
                'slug' => 'sale',
                'badge' => '85% OFF',
                'is_sale' => true,
                'mega_menu' => [
                    'Special Offers' => ['Flash Deals', 'Under RM 10.00', 'Under RM 20.00', 'Clearance Outlet'],
                    'Discounts' => ['Up to 85% Off', 'Buy 2 Get 1 Free', 'Half Price Steals', 'Final Sale'],
                    'Categories' => ['Dresses on Sale', 'Tops on Sale', 'Bags & Shoes Sale', 'Plus Size Deals'],
                    'Brands' => ['DAZY Sale', 'ROMWE Deals', 'MOTF Outlet', 'SHEGLAM Specials'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/ccc/2025/07/22/ca/1753167507387a524d78a380f1105ff2cdcba09dcb_thumbnail_432x.webp'
                ]
            ],
            [
                'name' => 'DRESSES',
                'slug' => 'dresses',
                'mega_menu' => [
                    'By Length' => ['Maxi Dresses', 'Midi Dresses', 'Mini Dresses', 'Floor Length Gowns'],
                    'By Style' => ['Bodycon Dresses', 'A-Line & Swing', 'Floral Sundresses', 'Slip & Cami Dresses', 'Wrap Dresses'],
                    'Occasions' => ['Party & Cocktail', 'Wedding Guest', 'Office & Work', 'Vacation & Beach', 'Date Night'],
                    'Trending' => ['Cutout Dresses', 'Ruched Dresses', 'Polka Dot Dresses', 'Linen Blend'],
                    'banner' => 'https://img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_405x552.jpg'
                ]
            ],
            [
                'name' => 'TOPS',
                'slug' => 'tops',
                'mega_menu' => [
                    'Categories' => ['T-Shirts & Graphic Tees', 'Blouses & Shirts', 'Crop Tops', 'Camis & Tank Tops'],
                    'Knitwear' => ['Cardigans', 'Sweaters & Jumpers', 'Vests', 'Boleros & Shrugs'],
                    'Sleeve Length' => ['Long Sleeve', 'Short Sleeve', 'Sleeveless', 'Puff Sleeve'],
                    'Style Edit' => ['Lace & Mesh', 'Off Shoulder', 'Corset Tops', 'Oversized Fit'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/20/d4/17872350397b0f2aaf00a8cdcd6153f7cf00a9dd42.png'
                ]
            ],
            [
                'name' => 'BOTTOMS',
                'slug' => 'bottoms',
                'mega_menu' => [
                    'Pants' => ['Wide Leg Trousers', 'Cargo Pants', 'High Waist Pants', 'Flared Pants', 'Leggings'],
                    'Jeans' => ['Straight Leg Jeans', 'Mom Jeans', 'Wide Leg Jeans', 'Skinny Jeans', 'Ripped Denim'],
                    'Skirts' => ['Pleated Skirts', 'Mini Skirts', 'Denim Skirts', 'Midi Slit Skirts'],
                    'Shorts' => ['Denim Shorts', 'Tailored Shorts', 'Linen Shorts', 'Biker Shorts'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25042532213621765/7fe7b9ddba437cd13887d28b0a896dc0_square.png'
                ]
            ],
            [
                'name' => 'CO-ORDS',
                'slug' => 'co-ords',
                'mega_menu' => [
                    'Matching Sets' => ['Skirt Sets', 'Pant Sets', 'Shorts Sets', 'Blazer & Trouser Sets'],
                    'Occasions' => ['Vacation Sets', 'Casual Lounge Sets', 'Party Two-Piece', 'Workwear Sets'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz251112957086312380/319778cd197cf278d5fd3c3d7104daeb_square.png'
                ]
            ],
            [
                'name' => 'CURVE + PLUS',
                'slug' => 'curve-plus',
                'badge' => 'PLUS',
                'mega_menu' => [
                    'Plus Clothing' => ['Plus Dresses', 'Plus Tops', 'Plus Jeans & Pants', 'Plus Co-Ords'],
                    'Plus Intimates' => ['Plus Lingerie', 'Plus Sleepwear', 'Plus Swimwear', 'Plus Shapewear'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25081445475968138/76af6eee33235080040fb6ad85c56d3d_square.png'
                ]
            ],
            [
                'name' => 'BEACHWEAR',
                'slug' => 'beachwear',
                'mega_menu' => [
                    'Swim' => ['Bikini Sets', 'One-Piece Swimsuits', 'Tankinis', 'High Waist Swimwear'],
                    'Cover-ups' => ['Kimonos & Kaftans', 'Sarongs & Wraps', 'Beach Dresses', 'Crochet Tops'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square.png'
                ]
            ],
            [
                'name' => 'SHOES & BAGS',
                'slug' => 'shoes-bags',
                'mega_menu' => [
                    'Shoes' => ['Heels & Pumps', 'Sandals & Slides', 'Sneakers & Trainers', 'Boots & Ankle Boots', 'Flats & Loafers'],
                    'Bags' => ['Shoulder Bags', 'Tote Bags', 'Crossbody Bags', 'Backpacks', 'Clutches & Wallets'],
                    'banner' => 'http://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e.png'
                ]
            ],
            [
                'name' => 'ACCESSORIES',
                'slug' => 'accessories',
                'mega_menu' => [
                    'Jewelry' => ['Necklaces & Pendants', 'Earrings', 'Rings & Bracelets', 'Body Jewelry', 'Fine Jewelry'],
                    'Fashion Accessories' => ['Belts & Suspenders', 'Sunglasses', 'Hair Accessories', 'Hats & Beanies', 'Scarves & Bandanas'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/18/6e/1787024681e512d4992a41811a8ebf7be85a9d8236.png'
                ]
            ],
            [
                'name' => '#' . (function_exists('get_setting') && get_setting('com_name') ? strtoupper(str_replace(' ', '', get_setting('com_name'))) : 'FASTIT') . 'style',
                'slug' => 'trending',
                'mega_menu' => [
                    'Community' => ['Customer Gallery', 'Influencer Looks', 'Weekly Best Outfits', 'Style Guide'],
                    'banner' => 'https://img.ltwebstatic.com/v4/p/ccc/2025/07/22/ca/1753167507387a524d78a380f1105ff2cdcba09dcb_thumbnail_432x.webp'
                ]
            ]
        ];
    }

    /**
     * Hero Trends Frame Carousel Data
     */
    public function getHeroBanners()
    {
        return [
            [
                'id' => 1,
                'tag' => '#SummerOutfit',
                'trend_tag' => '#SummerOutfit',
                'title' => 'SUMMER CHIC REVOLUTION',
                'subtitle' => 'UP TO 85% OFF • 10,000+ FRESH DROPS DAILY',
                'code' => 'NEW15',
                'cta' => 'SHOP THE EDIT',
                'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1600&auto=format&fit=crop',
                'bg_mask' => '//img.ltwebstatic.com/v4/p/ccc/2025/07/22/ca/1753167507387a524d78a380f1105ff2cdcba09dcb_thumbnail_432x.webp',
                'title_img' => '//img.ltwebstatic.com/v4/p/ccc/2025/05/14/5e/1747189579912ec4f275f4a8aea2cfbebfee3d61eb_thumbnail_240x.png',
                'link' => route('frontend.category', 'sale'),
                'highlight_product' => [
                    'id' => 1,
                    'name' => "Siren Gaze Women's Polka Dot Puff Sleeve Blouse Elegant",
                    'price' => 37.00,
                    'orig_price' => 74.00,
                    'img' => '//img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_405x552.jpg'
                ]
            ],
            [
                'id' => 2,
                'tag' => '#AutumnTrends',
                'trend_tag' => '#AutumnTrends',
                'title' => 'ELEVATED ELEGANCE 2026',
                'subtitle' => 'TIMELESS TAILORING & CHIC KNITWEAR',
                'code' => 'FAST10',
                'cta' => 'EXPLORE AUTUMN',
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1600&auto=format&fit=crop',
                'bg_mask' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200&auto=format&fit=crop',
                'title_img' => '//img.ltwebstatic.com/v4/p/ccc/2025/05/14/5e/1747189579912ec4f275f4a8aea2cfbebfee3d61eb_thumbnail_240x.png',
                'link' => route('frontend.category', 'dresses'),
                'highlight_product' => [
                    'id' => 2,
                    'name' => 'DAZY Ruched Bust High Split Cami Floral Dress',
                    'price' => 28.50,
                    'orig_price' => 65.00,
                    'img' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=600&auto=format&fit=crop'
                ]
            ],
            [
                'id' => 3,
                'tag' => '#BigSaleMania',
                'trend_tag' => '#BigSaleMania',
                'title' => '10.10 MEGA VOUCHER FIESTA',
                'subtitle' => 'CLAIM RM 50 OFF • FREE SHIPPING SITEWIDE',
                'code' => 'MY50',
                'cta' => 'CLAIM VOUCHERS',
                'image' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=1600&auto=format&fit=crop',
                'bg_mask' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1200&auto=format&fit=crop',
                'title_img' => '//img.ltwebstatic.com/v4/p/ccc/2025/05/14/5e/1747189579912ec4f275f4a8aea2cfbebfee3d61eb_thumbnail_240x.png',
                'link' => route('frontend.category', 'sale'),
                'highlight_product' => [
                    'id' => 3,
                    'name' => 'SHEGLAM Bold Booster Lip Plumper Lip Combo Makeup',
                    'price' => 21.00,
                    'orig_price' => 32.00,
                    'img' => '//img.ltwebstatic.com/images3_pi/2025/03/20/82/1742462671a1240a0a25a837d2e0819b6910605858_thumbnail_405x552.jpg'
                ]
            ]
        ];
    }

    /**
     * Shein Claimable Voucher Coupons
     */
    public function getVouchers()
    {
        return [
            ['id' => 'v1', 'discount' => 'RM 10 OFF', 'condition' => 'Orders RM70+', 'code' => 'MY10', 'expiry' => 'Expires in 2 days'],
            ['id' => 'v2', 'discount' => 'RM 25 OFF', 'condition' => 'Orders RM140+', 'code' => 'MY25', 'expiry' => 'Expires in 3 days'],
            ['id' => 'v3', 'discount' => 'RM 50 OFF', 'condition' => 'Orders RM260+', 'code' => 'MY50', 'expiry' => 'Expires in 4 days'],
            ['id' => 'v4', 'discount' => '15% OFF', 'condition' => 'First Order Sitewide', 'code' => 'NEW15', 'expiry' => 'No Minimum Spend'],
        ];
    }

    /**
     * Flash Sale & Super Deals Products
     */
    public function getFlashSaleProducts()
    {
        return [
            [
                'id' => 101,
                'name' => 'SHEGLAM Bold Booster Lip Plumper Lip Combo Brand Beauty Makeup',
                'brand' => 'SHEGLAM',
                'category' => 'beauty-health',
                'price' => 21.00,
                'original_price' => 32.00,
                'discount' => 34,
                'rating' => 4.95,
                'reviews_count' => 8420,
                'sold_count' => '18k',
                'claimed_pct' => 92,
                'image_primary' => '//img.ltwebstatic.com/images3_pi/2025/03/20/82/1742462671a1240a0a25a837d2e0819b6910605858_thumbnail_405x552.jpg',
                'image_hover' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#d96b6b', '#c24b5a', '#a3333d'],
                'sizes' => ['One Size']
            ],
            [
                'id' => 102,
                'name' => 'Siren Gaze Women Polka Dot Puff Sleeve Elegant French Blouse',
                'brand' => 'DAZY',
                'category' => 'tops',
                'price' => 37.00,
                'original_price' => 74.00,
                'discount' => 50,
                'rating' => 4.91,
                'reviews_count' => 4120,
                'sold_count' => '9.8k',
                'claimed_pct' => 84,
                'image_primary' => '//img.ltwebstatic.com/v4/j/pi/2026/03/16/66/177362915988faee9b44a22773360a55cb6e92d2cb_thumbnail_405x552.jpg',
                'image_hover' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#111111', '#ffffff', '#e0d2c7'],
                'sizes' => ['XS', 'S', 'M', 'L']
            ],
            [
                'id' => 103,
                'name' => 'High Waist Straight Leg Vintage Washed Classic Denim Jeans',
                'brand' => 'ROMWE',
                'category' => 'bottoms',
                'price' => 26.00,
                'original_price' => 68.00,
                'discount' => 62,
                'rating' => 4.88,
                'reviews_count' => 9320,
                'sold_count' => '24k',
                'claimed_pct' => 95,
                'image_primary' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1584370848010-d7fe6bc767ec?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#5d7a96', '#324b61', '#1a1a1a'],
                'sizes' => ['S', 'M', 'L', 'XL']
            ],
            [
                'id' => 104,
                'name' => 'Minimalist Crocodile Embossed Shoulder Chain Flap Bag',
                'brand' => 'FAST IT BAGS',
                'category' => 'bags-luggage',
                'price' => 14.50,
                'original_price' => 45.00,
                'discount' => 68,
                'rating' => 4.93,
                'reviews_count' => 12400,
                'sold_count' => '32k',
                'claimed_pct' => 88,
                'image_primary' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#000000', '#f4ede6', '#8b5a2b'],
                'sizes' => ['One Size']
            ],
            [
                'id' => 105,
                'name' => 'Faux Pearl Strap Chunky Low Heel Ankle Strap Sandals',
                'brand' => 'CUCCOO',
                'category' => 'shoes',
                'price' => 28.00,
                'original_price' => 78.00,
                'discount' => 64,
                'rating' => 4.89,
                'reviews_count' => 3510,
                'sold_count' => '8.2k',
                'claimed_pct' => 78,
                'image_primary' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#ffffff', '#000000', '#f7d6d0'],
                'sizes' => ['36', '37', '38', '39', '40']
            ],
            [
                'id' => 106,
                'name' => 'Ruched Drawstring Waist Split Hem Midi Bodycon Dress',
                'brand' => 'MOTF',
                'category' => 'dresses',
                'price' => 23.50,
                'original_price' => 59.00,
                'discount' => 60,
                'rating' => 4.96,
                'reviews_count' => 5640,
                'sold_count' => '14k',
                'claimed_pct' => 91,
                'image_primary' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#7a2021', '#1f1f1f', '#d5c4a1'],
                'sizes' => ['XS', 'S', 'M', 'L']
            ]
        ];
    }

    /**
     * 4 Promotional Campaign Feature Cards
     */
    public function getPromoCards()
    {
        return [
            [
                'title' => 'UNDER RM 19.99',
                'subtitle' => 'Trendy Chic On A Budget',
                'tag' => 'BEST VALUE',
                'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=600&auto=format&fit=crop',
                'link' => route('frontend.category', 'sale')
            ],
            [
                'title' => 'BEST SELLERS 100',
                'subtitle' => 'Ranked #1 Across Malaysia',
                'tag' => 'HOT 100',
                'image' => 'https://images.unsplash.com/photo-1485230895905-ec40ba36b9bc?q=80&w=600&auto=format&fit=crop',
                'link' => route('frontend.category', 'trending')
            ],
            [
                'title' => 'MATCHING TWO-PIECE',
                'subtitle' => 'Effortless Co-Ords Styling',
                'tag' => 'CO-ORDS',
                'image' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?q=80&w=600&auto=format&fit=crop',
                'link' => route('frontend.category', 'co-ords')
            ],
            [
                'title' => 'DRESS REVOLUTION',
                'subtitle' => 'Over 1,000 New Arrivals',
                'tag' => 'NEW IN',
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600&auto=format&fit=crop',
                'link' => route('frontend.category', 'dresses')
            ]
        ];
    }

    /**
     * Shein Product Feed ("Daily Drops / Just For You")
     */
    public function getRecommendedProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'DAZY Floral Print Sweetheart Neck Lantern Sleeve Swing Dress',
                'brand' => 'DAZY',
                'category' => 'dresses',
                'price' => 32.00,
                'original_price' => 64.00,
                'discount' => 50,
                'rating' => 4.95,
                'reviews_count' => 4520,
                'sold_count' => '12k',
                'badge' => 'TOP RATED',
                'image_primary' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#e8a598', '#f3eed9', '#1a1a1a'],
                'sizes' => ['XS', 'S', 'M', 'L']
            ],
            [
                'id' => 2,
                'name' => 'Solid Asymmetrical Hem Wrap Top & Wide Leg Trousers Two-Piece Set',
                'brand' => 'FAST IT BAE',
                'category' => 'co-ords',
                'price' => 38.50,
                'original_price' => 78.00,
                'discount' => 51,
                'rating' => 4.88,
                'reviews_count' => 3120,
                'sold_count' => '8.9k',
                'badge' => 'BESTSELLER',
                'image_primary' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1485230895905-ec40ba36b9bc?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#2b2b2b', '#c2a68c', '#e7dfd5'],
                'sizes' => ['S', 'M', 'L', 'XL']
            ],
            [
                'id' => 3,
                'name' => 'French Vintage Square Collar Puff Sleeve White Blouse',
                'brand' => 'MOTF',
                'category' => 'tops',
                'price' => 22.00,
                'original_price' => 49.00,
                'discount' => 55,
                'rating' => 4.91,
                'reviews_count' => 5910,
                'sold_count' => '18k',
                'badge' => 'HOT',
                'image_primary' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#ffffff', '#f4dcd6', '#000000'],
                'sizes' => ['XS', 'S', 'M', 'L']
            ],
            [
                'id' => 4,
                'name' => 'High Waist Cargo Parachute Pants With Toggle Drawstring',
                'brand' => 'ROMWE',
                'category' => 'bottoms',
                'price' => 28.00,
                'original_price' => 60.00,
                'discount' => 53,
                'rating' => 4.84,
                'reviews_count' => 7420,
                'sold_count' => '25k',
                'badge' => 'TRENDING',
                'image_primary' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1584370848010-d7fe6bc767ec?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#4a5043', '#111111', '#c7b198', '#909fa6'],
                'sizes' => ['S', 'M', 'L', 'XL']
            ],
            [
                'id' => 5,
                'name' => 'Curve + Plus Sweetheart Neck Belted A-Line Midi Dress',
                'brand' => 'FAST IT CURVE',
                'category' => 'curve',
                'price' => 36.00,
                'original_price' => 72.00,
                'discount' => 50,
                'rating' => 4.96,
                'reviews_count' => 3890,
                'sold_count' => '9.5k',
                'badge' => 'PLUS FIT',
                'image_primary' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#800020', '#1c1c1c', '#2e4057'],
                'sizes' => ['0XL', '1XL', '2XL', '3XL', '4XL']
            ],
            [
                'id' => 6,
                'name' => 'Ribbed Knit Zip Up Collar Long Sleeve Fitted Cardigan',
                'brand' => 'DAZY',
                'category' => 'knitwear',
                'price' => 24.50,
                'original_price' => 54.00,
                'discount' => 55,
                'rating' => 4.87,
                'reviews_count' => 2630,
                'sold_count' => '6.4k',
                'badge' => 'NEW',
                'image_primary' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#eae5dc', '#1a1a1a', '#8a9a86', '#b38867'],
                'sizes' => ['S', 'M', 'L']
            ],
            [
                'id' => 7,
                'name' => 'Cross Wrap Cut Out Ring Halterneck Bikini Swimsuit Set',
                'brand' => 'FAST IT SWIM',
                'category' => 'beachwear',
                'price' => 19.90,
                'original_price' => 45.00,
                'discount' => 56,
                'rating' => 4.9,
                'reviews_count' => 5120,
                'sold_count' => '14k',
                'badge' => 'HOT',
                'image_primary' => 'https://images.unsplash.com/photo-1582639510494-c80b5de9f148?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#ff5964', '#111111', '#35a7ff'],
                'sizes' => ['XS', 'S', 'M', 'L']
            ],
            [
                'id' => 8,
                'name' => 'Vintage Multi-Layer Gold Plated Butterfly Pendant Necklace',
                'brand' => 'FAST IT ACCS',
                'category' => 'jewelry-accessories',
                'price' => 5.50,
                'original_price' => 18.00,
                'discount' => 69,
                'rating' => 4.89,
                'reviews_count' => 14200,
                'sold_count' => '42k',
                'badge' => 'BEST VALUE',
                'image_primary' => 'https://images.unsplash.com/photo-1611591475152-4735d388e945?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#ffd700', '#c0c0c0'],
                'sizes' => ['One Size']
            ],
            [
                'id' => 9,
                'name' => 'Retro Corduroy Button Front A-Line High Waist Mini Skirt',
                'brand' => 'DAZY',
                'category' => 'bottoms',
                'price' => 21.90,
                'original_price' => 48.00,
                'discount' => 54,
                'rating' => 4.93,
                'reviews_count' => 3810,
                'sold_count' => '11k',
                'badge' => 'TOP PICK',
                'image_primary' => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aaaa?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#9e5740', '#252525', '#4d6059'],
                'sizes' => ['XS', 'S', 'M', 'L']
            ],
            [
                'id' => 10,
                'name' => 'Square Toe Low Chunky Heel Slip On Mule Slides',
                'brand' => 'CUCCOO',
                'category' => 'shoes',
                'price' => 27.00,
                'original_price' => 58.00,
                'discount' => 53,
                'rating' => 4.86,
                'reviews_count' => 4180,
                'sold_count' => '9k',
                'badge' => 'POPULAR',
                'image_primary' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1562273138-f46be4ebdf33?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#eae2b7', '#111111', '#bc6c25'],
                'sizes' => ['36', '37', '38', '39', '40']
            ],
            [
                'id' => 11,
                'name' => 'Boho Floral Print Lantern Sleeve Tie Neck Swing Smock Dress',
                'brand' => 'EMERY ROSE',
                'category' => 'dresses',
                'price' => 29.90,
                'original_price' => 65.00,
                'discount' => 54,
                'rating' => 4.94,
                'reviews_count' => 5230,
                'sold_count' => '13k',
                'badge' => 'EDITOR PICK',
                'image_primary' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#d4a373', '#606c38', '#283618'],
                'sizes' => ['S', 'M', 'L', 'XL']
            ],
            [
                'id' => 12,
                'name' => 'Quilted Pattern Chain Strap Cloud Flap Shoulder Bag',
                'brand' => 'FAST IT BAGS',
                'category' => 'bags-luggage',
                'price' => 16.50,
                'original_price' => 45.00,
                'discount' => 63,
                'rating' => 4.97,
                'reviews_count' => 8410,
                'sold_count' => '21k',
                'badge' => 'MUST HAVE',
                'image_primary' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=600&auto=format&fit=crop',
                'image_hover' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=600&auto=format&fit=crop',
                'colors' => ['#ffffff', '#000000', '#f4a261', '#2a9d8f'],
                'sizes' => ['One Size']
            ]
        ];
    }

    /**
     * Customer Instagram #SHEINstyle Gallery
     */
    public function getInstagramLooks()
    {
        return [
            ['author' => '@chloe_styles', 'likes' => '4.2k', 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=400&auto=format&fit=crop'],
            ['author' => '@fashion_bella', 'likes' => '3.8k', 'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=400&auto=format&fit=crop'],
            ['author' => '@sarah_ootd', 'likes' => '6.1k', 'image' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=400&auto=format&fit=crop'],
            ['author' => '@maya_chic', 'likes' => '2.9k', 'image' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?q=80&w=400&auto=format&fit=crop'],
            ['author' => '@emily_trends', 'likes' => '5.4k', 'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=400&auto=format&fit=crop'],
            ['author' => '@jessica_vogue', 'likes' => '7.3k', 'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=400&auto=format&fit=crop'],
        ];
    }
}
