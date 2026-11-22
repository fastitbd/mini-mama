<!DOCTYPE html>
<html lang="en" mir="ltr" brd="sh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Shop The Latest Styles | Fashion Clothes for Women, Men & Kids Online | ' . (get_setting('com_name') ?: 'FAST IT'))</title>
    <meta name="description" content="Shop affordable and fashionable items on Women, Men, Kids, Home & more! ✓Get RM10 Off Your First Order ✓Cash On Delivery ✓Free Shipping On Orders RM120+ ✓Secured Checkout ✓20-Day Easy Return ✓1000+ New Arrivals Dropped Daily, Types: Dresses, Tops, Pants, Skirts, Shoes, and Accessories.">
    <link rel="icon" type="image/png" href="{{ !empty(get_setting('system_icon')) && file_exists(public_path('uploads/logo/' . get_setting('system_icon'))) ? url('uploads/logo/' . get_setting('system_icon')) : 'https://sc.ltwebstatic.com/she_dist/images/touch-icon-ipad-144-47ceee2d97.png' }}">
    
    <!-- Shein Fonts: Muli and Jost -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Official Shein SUI Core Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/shein-all.css') }}">
    <!-- Custom Shein Components Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/shein-components.css') }}">
    <!-- Swiper Web Components Bundle for Shein Carousels -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>

    <style>
        /* Exact SHEIN Design System Tokens */
        :root {
            --shein-black: #000000;
            --shein-dark: #222222;
            --shein-red: #FA2C19;
            --shein-red-dark: #D62000;
            --shein-orange: #FA6338;
            --shein-gold: #FFB800;
            --shein-bg: #FFFFFF;
            --shein-light-bg: #F7F7F7;
            --shein-border: #EEEEEE;
            --shein-border-dark: #DDDDDD;
            --shein-text: #222222;
            --shein-text-muted: #767676;
            --shein-font: 'Jost', 'Mulish', -apple-system, system-ui, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            font-family: var(--shein-font) !important;
            color: var(--shein-text);
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 13px;
            line-height: 1.4;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        a:hover { color: var(--shein-red); text-decoration: none; }
        button { font-family: inherit; cursor: pointer; border: none; outline: none; background: transparent; }
        img { max-width: 100%; height: auto; display: block; }

        .shein-wrap {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* --- 1. SHEIN TOP ANNOUNCEMENT TICKER --- */
        .shein-top-ticker {
            background-color: #000000;
            color: #ffffff;
            font-size: 12px;
            font-weight: 500;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            letter-spacing: 0.2px;
            z-index: 1001;
            position: relative;
        }

        .ticker-pill-tag {
            background: #FA2C19;
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 2px;
            margin-right: 8px;
            text-transform: uppercase;
        }

        .ticker-right-tools {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 11px;
            color: #cccccc;
        }

        .ticker-right-tools a, .ticker-right-tools span {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            color: #cccccc;
            transition: color 0.15s;
        }

        .ticker-right-tools a:hover, .ticker-right-tools span:hover {
            color: #ffffff;
        }

        /* --- 2. SHEIN MAIN HEADER --- */
        .shein-main-header {
            background: #ffffff;
            border-bottom: 1px solid var(--shein-border);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        .shein-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
            gap: 24px;
        }

        .shein-logo-svg {
            display: flex;
            align-items: center;
        }

        .shein-search-container {
            flex: 1;
            max-width: 640px;
            position: relative;
        }

        .shein-search-bar {
            display: flex;
            align-items: center;
            border: 2px solid #000000;
            height: 40px;
            background: #ffffff;
        }

        .shein-search-bar input {
            flex: 1;
            border: none;
            padding: 0 16px;
            font-size: 13px;
            font-family: inherit;
            outline: none;
            color: #222222;
        }

        .shein-search-bar input::placeholder {
            color: #999999;
        }

        .shein-camera-btn {
            padding: 0 12px;
            color: #666666;
            font-size: 17px;
            cursor: pointer;
            transition: color 0.15s;
        }

        .shein-camera-btn:hover {
            color: #000000;
        }

        .shein-search-btn {
            background: #000000;
            color: #ffffff;
            width: 48px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            transition: background 0.15s;
        }

        .shein-search-btn:hover {
            background: #333333;
        }

        /* Search Autocomplete Overlay */
        .shein-search-popup {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #ffffff;
            border: 1px solid var(--shein-border);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            margin-top: 4px;
            padding: 16px;
            display: none;
            z-index: 1002;
        }

        .shein-search-popup.active { display: block; }

        .search-chips-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .search-chip {
            background: #f7f7f7;
            padding: 5px 12px;
            font-size: 12px;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .search-chip:hover {
            background: #000000;
            color: #ffffff;
        }

        .search-chip.hot {
            color: var(--shein-red);
            background: #FFF1F0;
        }

        /* Header Right Action Icons */
        .shein-header-tools {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .shein-tool-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 11px;
            font-weight: 600;
            color: #222222;
            position: relative;
            cursor: pointer;
            padding: 2px;
        }

        .shein-tool-btn svg, .shein-tool-btn i {
            font-size: 20px;
            margin-bottom: 2px;
        }

        .shein-badge-num {
            position: absolute;
            top: -3px;
            right: -6px;
            background: var(--shein-red);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        /* User Menu Flyout */
        .user-flyout-box {
            position: absolute;
            top: 100%;
            right: 0;
            width: 250px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid var(--shein-border);
            padding: 16px;
            display: none;
            z-index: 1003;
            margin-top: 8px;
        }

        .user-parent:hover .user-flyout-box {
            display: block;
        }

        .btn-shein-black {
            display: block;
            width: 100%;
            background: #000000;
            color: #ffffff;
            text-align: center;
            padding: 11px 0;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            transition: background 0.15s;
        }

        .btn-shein-black:hover { background: #333333; color: #ffffff; }

        .btn-shein-outline {
            display: block;
            width: 100%;
            border: 1px solid #000000;
            color: #000000;
            text-align: center;
            padding: 10px 0;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .user-flyout-links a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 0;
            border-top: 1px solid #f2f2f2;
            font-size: 12px;
            color: #444444;
        }

        .user-flyout-links a:hover {
            color: var(--shein-red);
        }

        /* --- 3. SHEIN CHANNELS & SECONDARY NAV BAR --- */
        .shein-channels-strip {
            background: #ffffff;
            border-bottom: 1px solid var(--shein-border);
        }

        .channels-row {
            display: flex;
            align-items: center;
            list-style: none;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .channels-row::-webkit-scrollbar { display: none; }

        .ch-item {
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            color: #666666;
            position: relative;
            cursor: pointer;
        }

        .ch-item:hover, .ch-item.active {
            color: #000000;
        }

        .ch-item.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            right: 20px;
            height: 3px;
            background: #000000;
        }

        .ch-item.sale-highlight {
            color: var(--shein-red);
        }

        /* Sub-Categories Navigation Bar */
        .shein-subnav-strip {
            background: #ffffff;
            border-bottom: 1px solid var(--shein-border);
            position: relative;
        }

        .subnav-row {
            display: flex;
            align-items: center;
            list-style: none;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .subnav-row::-webkit-scrollbar { display: none; }

        .subnav-item {
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
            color: #222222;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .subnav-item:hover { color: var(--shein-red); }
        .subnav-item.is-sale { color: var(--shein-red); font-weight: 900; }

        .subnav-tag-badge {
            font-size: 9px;
            font-weight: 800;
            padding: 1px 4px;
            border-radius: 2px;
            color: #ffffff;
            background: var(--shein-red);
            line-height: 1;
        }

        /* SHEIN MEGA MENU DROPDOWN */
        .shein-mega-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #ffffff;
            box-shadow: 0 16px 36px rgba(0,0,0,0.12);
            border-top: 1px solid var(--shein-border);
            padding: 30px 40px;
            display: none;
            z-index: 998;
        }

        .subnav-item:hover .shein-mega-menu {
            display: block;
        }

        .mega-menu-inner-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr) 260px;
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .mega-column h4 {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 12px;
            color: #000000;
            border-bottom: 1px solid #f2f2f2;
            padding-bottom: 6px;
        }

        .mega-column ul { list-style: none; }
        .mega-column ul li { margin-bottom: 8px; }
        .mega-column ul li a { color: #666666; font-size: 12px; }
        .mega-column ul li a:hover { color: var(--shein-red); padding-left: 3px; }

        .mega-banner-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* --- 4. SHEIN PRODUCT CARD (EXACT 5-COLUMN RATIO & HOVER) --- */
        .shein-card-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px 12px;
        }

        .shein-prod-card {
            background: #ffffff;
            position: relative;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s ease;
        }

        .shein-prod-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .shein-img-container {
            position: relative;
            width: 100%;
            padding-top: 133.33%; /* Exact Shein 3:4 aspect ratio */
            overflow: hidden;
            background: #f7f7f7;
        }

        .shein-img-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease, transform 0.4s ease;
        }

        .shein-img-container .img-hover { opacity: 0; }
        .shein-prod-card:hover .shein-img-container .img-primary { opacity: 0; }
        .shein-prod-card:hover .shein-img-container .img-hover { opacity: 1; transform: scale(1.02); }

        .shein-heart-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333333;
            font-size: 15px;
            z-index: 5;
            transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .shein-heart-btn:hover, .shein-heart-btn.active {
            background: #ffffff;
            color: var(--shein-red);
        }

        .shein-discount-tag {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--shein-red);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 6px;
            border-radius: 2px;
            z-index: 5;
            line-height: 1;
        }

        .shein-quick-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.85);
            color: #ffffff;
            padding: 9px 0;
            text-align: center;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0;
            transform: translateY(100%);
            transition: all 0.2s ease;
            z-index: 6;
            cursor: pointer;
        }

        .shein-prod-card:hover .shein-quick-bar {
            opacity: 1;
            transform: translateY(0);
        }

        .shein-card-body {
            padding: 10px 4px 6px;
        }

        .shein-color-dots {
            display: flex;
            gap: 6px;
            margin-bottom: 6px;
        }

        .color-bubble {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 1px solid #cccccc;
            cursor: pointer;
            transition: transform 0.15s;
        }

        .color-bubble:hover { transform: scale(1.3); }

        .shein-card-brand {
            font-size: 10px;
            font-weight: 800;
            color: #999999;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .shein-card-title {
            font-size: 12px;
            font-weight: 500;
            color: #222222;
            line-height: 1.35;
            height: 32px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 6px;
        }

        .shein-card-title:hover { color: var(--shein-red); }

        .shein-price-strip {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin-bottom: 4px;
        }

        .sale-price {
            font-size: 15px;
            font-weight: 800;
            color: var(--shein-red);
        }

        .orig-price {
            font-size: 11px;
            color: #999999;
            text-decoration: line-through;
        }

        .disc-pct {
            font-size: 11px;
            font-weight: 700;
            color: var(--shein-red);
        }

        .shein-reviews-info {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #767676;
        }

        .rating-stars {
            color: #FFB800;
            font-size: 10px;
        }

        /* --- 5. SLIDE-OUT CART BAG DRAWER --- */
        .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s;
        }

        .drawer-overlay.active { opacity: 1; visibility: visible; }

        .shein-cart-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 440px;
            max-width: 90vw;
            height: 100vh;
            background: #ffffff;
            z-index: 2001;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: -5px 0 25px rgba(0,0,0,0.15);
        }

        .shein-cart-drawer.active { transform: translateX(0); }

        .cart-header-row {
            padding: 18px 20px;
            border-bottom: 1px solid var(--shein-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-shipping-banner {
            background: #FFF7F5;
            padding: 12px 20px;
            border-bottom: 1px solid #FFE4DE;
            font-size: 12px;
            font-weight: 600;
            color: var(--shein-red);
        }

        .shipping-meter-bg {
            height: 6px;
            background: #FFE4DE;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 6px;
        }

        .shipping-meter-fill {
            height: 100%;
            background: var(--shein-red);
            border-radius: 3px;
            transition: width 0.3s;
        }

        .cart-items-container {
            flex: 1;
            overflow-y: auto;
            padding: 16px 20px;
        }

        .cart-item-card {
            display: flex;
            gap: 14px;
            padding-bottom: 16px;
            margin-bottom: 16px;
            border-bottom: 1px solid #f2f2f2;
            position: relative;
        }

        .cart-item-card img {
            width: 75px;
            height: 100px;
            object-fit: cover;
            border-radius: 2px;
        }

        .cart-footer-box {
            padding: 20px;
            border-top: 1px solid var(--shein-border);
            background: #ffffff;
        }

        /* --- 6. QUICK VIEW MODAL --- */
        .quick-view-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.6);
            z-index: 2500;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            padding: 20px;
        }

        .quick-view-backdrop.active { opacity: 1; visibility: visible; }

        .quick-modal-inner {
            background: #ffffff;
            width: 860px;
            max-width: 95vw;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 4px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
        }

        .modal-close-x {
            position: absolute;
            top: 14px;
            right: 16px;
            font-size: 24px;
            color: #333333;
            cursor: pointer;
            z-index: 10;
        }

        /* --- 7. TOAST NOTIFICATION --- */
        .shein-toast-box {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: rgba(0,0,0,0.92);
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 24px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 3000;
            transition: transform 0.3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }

        .shein-toast-box.show { transform: translateX(-50%) translateY(0); }

        /* --- 8. MOBILE BOTTOM APP BAR --- */
        .shein-mobile-bar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #ffffff;
            border-top: 1px solid var(--shein-border);
            z-index: 1500;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        }

        .mobile-tab-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 10px;
            font-weight: 700;
            color: #666666;
            position: relative;
        }

        .mobile-tab-item.active { color: #000000; }
        .mobile-tab-item i { font-size: 18px; margin-bottom: 2px; }

        @media (max-width: 900px) {
            .shein-top-ticker .ticker-center, .shein-top-ticker .ticker-right-tools { display: none; }
            .shein-channels-strip, .shein-subnav-strip { display: none; }
            .shein-mobile-bar { display: flex; }
            body { padding-bottom: 56px; }
            .quick-modal-inner { grid-template-columns: 1fr; }
            .trust-badges-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 16px !important; }
            .shein-product-grid { grid-template-columns: repeat(3, 1fr) !important; gap: 12px 10px !important; }
        }

        @media (max-width: 640px) {
            .shein-wrap, .shein-container { padding-left: 12px !important; padding-right: 12px !important; }
            .shein-card-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; gap: 10px 8px !important; }
            .shein-product-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 10px 8px !important; }
            .trust-badges-grid { grid-template-columns: 1fr !important; gap: 14px !important; }
            .shein-top-ticker { padding: 0 12px !important; font-size: 10px !important; height: 28px !important; }
            .shein-top-ticker span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90vw; }
            .j-up-to-top_container { bottom: 64px !important; right: 14px !important; width: 38px !important; height: 38px !important; }
        }
    </style>
    @stack('styles')
    @stack('css')
</head>
<body>

    <!-- OFFICIAL SHEIN FULL HEADER -->
    @include('frontend.layouts.header')

    <!-- CONTENT WRAPPER -->
    <main id="main">
        @yield('content')
    </main>

    <!-- 5. TRUST & SERVICE BADGES -->
    <section style="background:#ffffff; border-top:1px solid #eee; border-bottom:1px solid #eee; padding:24px 0;">
        <div class="shein-wrap">
            <div class="trust-badges-grid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <i class="fa-solid fa-truck-fast" style="font-size:24px; color:#000;"></i>
                    <div>
                        <div style="font-size:12px; font-weight:800; text-transform:uppercase;">FREE SHIPPING</div>
                        <div style="font-size:11px; color:#666;">On all orders over RM 120.00 / ৳1500</div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <i class="fa-solid fa-rotate-left" style="font-size:24px; color:#000;"></i>
                    <div>
                        <div style="font-size:12px; font-weight:800; text-transform:uppercase;">20-DAY RETURN</div>
                        <div style="font-size:11px; color:#666;">Hassle-free online returns</div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <i class="fa-solid fa-money-bill-wave" style="font-size:24px; color:#000;"></i>
                    <div>
                        <div style="font-size:12px; font-weight:800; text-transform:uppercase;">CASH ON DELIVERY</div>
                        <div style="font-size:11px; color:#666;">Doorstep payment available</div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <i class="fa-solid fa-shield-halved" style="font-size:24px; color:#000;"></i>
                    <div>
                        <div style="font-size:12px; font-weight:800; text-transform:uppercase;">100% SECURE CHECKOUT</div>
                        <div style="font-size:11px; color:#666;">Encrypted SSL payment security</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- 7. OFFICIAL SHEIN FOOTER -->
    @include('frontend.layouts.footer')

    <!-- 8. SLIDE-OUT CART BAG DRAWER -->
    <div class="drawer-overlay" id="drawerOverlay" onclick="closeCartDrawer()"></div>
    <div class="shein-cart-drawer" id="sheinCartDrawer">
        <div class="cart-header-row">
            <div style="font-size:15px; font-weight:800; text-transform:uppercase;">Shopping Bag (<span id="drawerBagCount">0</span>)</div>
            <button onclick="closeCartDrawer()" style="font-size:20px; color:#666;"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="cart-shipping-banner">
            <div id="drawerMeterText">🚚 Add RM 120.00 more to unlock FREE SHIPPING!</div>
            <div class="shipping-meter-bg">
                <div class="shipping-meter-fill" id="drawerMeterFill" style="width:0%;"></div>
            </div>
        </div>

        <div class="cart-items-container" id="drawerCartList">
            <!-- Populated via JS -->
        </div>

        <div class="cart-footer-box">
            <div style="display:flex; gap:8px; margin-bottom:12px;">
                <input type="text" id="drawerPromoInput" placeholder="Promo Code (NEW15)" style="flex:1; height:36px; border:1px solid #ccc; padding:0 12px; font-size:12px; text-transform:uppercase;">
                <button type="button" onclick="applyDrawerPromo()" style="background:#000; color:#fff; font-size:11px; font-weight:800; padding:0 14px; text-transform:uppercase;">APPLY</button>
            </div>

            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px; color:#666;">
                <span>Subtotal</span>
                <span id="drawerSubtotalText">RM 0.00</span>
            </div>
            <div id="drawerDiscountRow" style="display:none; justify-content:space-between; font-size:12px; margin-bottom:5px; color:var(--shein-red);">
                <span>Discount (<span id="drawerDiscountCode"></span>)</span>
                <span id="drawerDiscountVal">-RM 0.00</span>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px; color:#666;">
                <span>Shipping</span>
                <span id="drawerShippingVal">RM 15.00</span>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:15px; font-weight:900; color:#000; border-top:1px solid #f2f2f2; padding-top:8px; margin-top:8px;">
                <span>Estimated Total</span>
                <span id="drawerTotalText">RM 0.00</span>
            </div>

            <div style="display:flex; gap:10px; margin-top:12px;">
                <a href="{{ route('frontend.cart') }}" class="btn-shein-outline" style="margin-bottom:0; flex:1; padding:12px 0;">VIEW BAG</a>
                <button type="button" class="btn-shein-black" style="margin-bottom:0; flex:1; padding:12px 0;" onclick="checkoutAction()">CHECKOUT</button>
            </div>
        </div>
    </div>

    <!-- 9. QUICK VIEW PRODUCT MODAL -->
    <div class="quick-view-backdrop" id="quickViewBackdrop" onclick="if(event.target === this) closeQuickModal()">
        <div class="quick-modal-inner">
            <button class="modal-close-x" onclick="closeQuickModal()"><i class="fa-solid fa-xmark"></i></button>
            <div style="padding:24px; background:#fbfbfb;">
                <img id="qModalImg" src="" alt="View" style="width:100%; height:400px; object-fit:cover; border-radius:2px;">
            </div>
            <div style="padding:28px; display:flex; flex-direction:column;">
                <span id="qModalBrand" style="font-size:11px; font-weight:800; color:#999; text-transform:uppercase;"></span>
                <h3 id="qModalTitle" style="font-size:17px; font-weight:700; margin:4px 0 10px; line-height:1.35;"></h3>
                <div style="display:flex; align-items:baseline; gap:10px; margin-bottom:14px;">
                    <span id="qModalPrice" style="font-size:22px; font-weight:900; color:var(--shein-red);"></span>
                    <span id="qModalOrigPrice" style="font-size:13px; color:#999; text-decoration:line-through;"></span>
                    <span id="qModalDisc" style="font-size:12px; font-weight:800; color:var(--shein-red);"></span>
                </div>

                <div style="margin-bottom:14px;">
                    <div style="font-size:12px; font-weight:700; margin-bottom:6px;">Select Size:</div>
                    <div style="display:flex; gap:6px; flex-wrap:wrap;" id="qModalSizes"></div>
                </div>

                <div style="margin-bottom:18px;">
                    <div style="font-size:12px; font-weight:700; margin-bottom:6px;">Quantity:</div>
                    <div style="display:flex; align-items:center; border:1px solid #ccc; width:fit-content;">
                        <button style="width:30px; height:30px;" onclick="adjustQModalQty(-1)">-</button>
                        <span id="qModalQtyVal" style="width:36px; text-align:center; font-weight:700;">1</span>
                        <button style="width:30px; height:30px;" onclick="adjustQModalQty(1)">+</button>
                    </div>
                </div>

                <button type="button" class="btn-shein-black" onclick="submitQModalToBag()" style="padding:14px 0; margin-bottom:10px;">
                    <i class="fa-solid fa-bag-shopping"></i> ADD TO BAG
                </button>

                <div style="font-size:11px; color:#666; line-height:1.6; margin-top:10px;">
                    ✓ Free Shipping on orders over RM120<br>
                    ✓ 20-Day Easy Return Policy<br>
                    ✓ Cash on Delivery Available
                </div>
            </div>
        </div>
    </div>

    <!-- 10. SPECIAL DEALS POPUP (1:1 SHEIN OFFICIAL) -->
    @include('frontend.partials.welcome-popup')

    <!-- 11. TOAST NOTIFICATION -->
    <div class="shein-toast-box" id="sheinToast">
        <i class="fa-solid fa-circle-check" style="color:#4ADE80;"></i>
        <span id="toastText">Item added to bag!</span>
    </div>

    <!-- 11. MOBILE BOTTOM APP BAR -->
    <div class="shein-mobile-bar">
        <a href="{{ route('frontend.home') }}" class="mobile-tab-item active">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('frontend.category', 'all') }}" class="mobile-tab-item">
            <i class="fa-solid fa-table-cells-large"></i>
            <span>Category</span>
        </a>
        <a href="{{ route('frontend.category', 'new-in') }}" class="mobile-tab-item">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
            <span>New In</span>
        </a>
        <a href="{{ route('frontend.wishlist') }}" class="mobile-tab-item">
            <i class="fa-regular fa-heart"></i>
            <span>Wishlist</span>
        </a>
        <div class="mobile-tab-item" onclick="openCartDrawer()">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>Bag</span>
            <span class="shein-badge-num" id="mobileCartNum" style="position:absolute; top:-2px; right:14px; font-size:9px; width:15px; height:15px;">0</span>
        </div>
        <a href="{{ route('frontend.login') }}" class="mobile-tab-item">
            <i class="fa-regular fa-user"></i>
            <span>Me</span>
        </a>
    </div>

    <!-- JAVASCRIPT GLOBAL STATE -->
    <script>
        let sheinCart = JSON.parse(localStorage.getItem('shein_cart') || '[]');
        let sheinWishlist = JSON.parse(localStorage.getItem('shein_wishlist') || '[]');
        let discountRate = 0;
        let discountCodeName = '';
        let currentModalItem = null;
        let currentModalChosenSize = 'M';
        let currentModalQty = 1;

        document.addEventListener('DOMContentLoaded', () => {
            refreshCartUI();
            refreshWishlistUI();
            setupSearchUI();

            // Setup User Dropdown
            const userContainer = document.querySelector('.bsc-user-container');
            const userDropdown = document.getElementById('sheinUserDropdown');
            if (userContainer && userDropdown) {
                userContainer.style.position = 'relative';
                userContainer.addEventListener('mouseenter', () => userDropdown.style.display = 'block');
                userContainer.addEventListener('mouseleave', () => userDropdown.style.display = 'none');
            }

            // Close categories flyout on outside click
            document.addEventListener('click', (e) => {
                const flyout = document.getElementById('sheinCategoriesFlyout');
                const btn = document.querySelector('.first-cate');
                if (flyout && btn && !flyout.contains(e.target) && !btn.contains(e.target)) {
                    flyout.style.display = 'none';
                }
            });

            // Initialize all swiper containers
            setTimeout(() => {
                document.querySelectorAll('swiper-container').forEach(sw => {
                    if (typeof sw.initialize === 'function') {
                        try { sw.initialize(); } catch(e) {}
                    }
                });
            }, 100);
        });

        function toggleCategoriesMenu(forceState) {
            const el = document.getElementById('sheinCategoriesFlyout');
            const chevron = document.getElementById('sheinCatChevron');
            if (!el) return;
            const isOpen = (typeof forceState === 'boolean') ? !forceState : (el.style.display === 'block');
            if (isOpen) {
                el.style.display = 'none';
                if (chevron) chevron.style.transform = 'rotate(0deg)';
            } else {
                el.style.display = 'block';
                if (chevron) chevron.style.transform = 'rotate(180deg)';
            }
        }

        function showMegaTab(tabId, linkEl) {
            document.querySelectorAll('.mega-cat-panel').forEach(p => p.style.display = 'none');
            const target = document.getElementById('tab-' + tabId);
            if (target) target.style.display = 'block';

            document.querySelectorAll('.mega-cat-link').forEach(l => {
                l.classList.remove('active');
                l.style.background = '#ffffff';
                l.style.fontWeight = '500';
                l.style.borderLeftColor = 'transparent';
                const icon = l.querySelector('i');
                if (icon) icon.style.color = '#cccccc';
            });
            if (linkEl) {
                linkEl.classList.add('active');
                linkEl.style.background = '#f0f0f0';
                linkEl.style.fontWeight = '700';
                linkEl.style.borderLeftColor = '#000000';
                const icon = linkEl.querySelector('i');
                if (icon) icon.style.color = '#888888';
            }
        }

        document.addEventListener('click', function(e) {
            const flyout = document.getElementById('sheinCategoriesFlyout');
            const btn = document.getElementById('sheinCatBtn');
            if (flyout && btn && !flyout.contains(e.target) && !btn.contains(e.target)) {
                toggleCategoriesMenu(false);
            }
        });

        // Categories Mega Menu hover listeners
        document.addEventListener('DOMContentLoaded', function() {
            let catMenuTimer = null;
            const catBtn = document.getElementById('sheinCatBtn');
            const flyout = document.getElementById('sheinCategoriesFlyout');

            if (catBtn && flyout) {
                catBtn.addEventListener('mouseenter', () => {
                    if (catMenuTimer) clearTimeout(catMenuTimer);
                    toggleCategoriesMenu(true);
                });
                catBtn.addEventListener('mouseleave', () => {
                    catMenuTimer = setTimeout(() => {
                        toggleCategoriesMenu(false);
                    }, 300);
                });
                flyout.addEventListener('mouseenter', () => {
                    if (catMenuTimer) clearTimeout(catMenuTimer);
                });
                flyout.addEventListener('mouseleave', () => {
                    catMenuTimer = setTimeout(() => {
                        toggleCategoriesMenu(false);
                    }, 300);
                });
            }
        });

        function scrollCatNav(distance) {
            const nav = document.getElementById('categoryNavInner');
            if (nav) {
                nav.scrollBy({ left: distance, behavior: 'smooth' });
            }
        }

        function setupSearchUI() {
            const input = document.getElementById('headerSearchBox');
            const popup = document.getElementById('search-suggestions');
            if (!input || !popup) return;
            input.addEventListener('focus', () => popup.style.display = 'block');
            input.addEventListener('blur', () => setTimeout(() => popup.style.display = 'none', 300));
        }

        function runSearch(term) {
            const input = document.getElementById('headerSearchBox');
            if (input) {
                input.value = term;
                input.form.submit();
            }
        }

        // Cart Drawer
        function openCartDrawer() {
            renderDrawerItems();
            document.getElementById('sheinCartDrawer').classList.add('active');
            document.getElementById('drawerOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCartDrawer() {
            document.getElementById('sheinCartDrawer').classList.remove('active');
            document.getElementById('drawerOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function addToBag(item, size = 'M', color = 'Standard') {
            const matchIndex = sheinCart.findIndex(c => c.id === item.id && c.size === size);
            if (matchIndex > -1) {
                sheinCart[matchIndex].qty += 1;
            } else {
                sheinCart.push({
                    id: item.id,
                    name: item.name,
                    price: parseFloat(item.price),
                    image: item.image_primary || item.image || item.img,
                    size: size,
                    color: color,
                    qty: 1
                });
            }
            saveSheinCart();
            showToast(`🛍️ Added "${item.name.substring(0, 24)}..." (${size}) to Bag!`);
            openCartDrawer();
        }

        function saveSheinCart() {
            localStorage.setItem('shein_cart', JSON.stringify(sheinCart));
            refreshCartUI();
            renderDrawerItems();
        }

        function refreshCartUI() {
            const total = sheinCart.reduce((sum, item) => sum + item.qty, 0);
            const b1 = document.getElementById('navCartBadge');
            const b2 = document.getElementById('mobileCartNum');
            const b3 = document.getElementById('drawerBagCount');
            if (b1) b1.innerText = total;
            if (b2) b2.innerText = total;
            if (b3) b3.innerText = total;
        }

        function renderDrawerItems() {
            const list = document.getElementById('drawerCartList');
            if (!list) return;

            if (sheinCart.length === 0) {
                list.innerHTML = `
                    <div style="text-align:center; padding:60px 20px;">
                        <i class="fa-solid fa-bag-shopping" style="font-size:48px; color:#ddd; margin-bottom:12px;"></i>
                        <h4 style="font-size:15px; font-weight:800; margin-bottom:4px;">Your Bag is empty</h4>
                        <p style="color:#767676; font-size:12px; margin-bottom:16px;">Shop 10,000+ top trending items on sale!</p>
                        <a href="{{ route('frontend.category', 'sale') }}" class="btn-shein-black" style="display:inline-block; padding:10px 24px; width:auto;" onclick="closeCartDrawer()">SHOP NOW</a>
                    </div>
                `;
                calculateDrawerTotals(0);
                return;
            }

            let subtotal = 0;
            let html = '';
            sheinCart.forEach((item, idx) => {
                const rowTotal = item.price * item.qty;
                subtotal += rowTotal;
                html += `
                    <div class="cart-item-card">
                        <img src="${item.image}" alt="${item.name}">
                        <div style="flex:1;">
                            <div style="font-size:12px; font-weight:600; line-height:1.3; margin-bottom:4px;">${item.name}</div>
                            <div style="font-size:11px; color:#767676; margin-bottom:6px;">Size: <strong>${item.size}</strong></div>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-size:13px; font-weight:800; color:var(--shein-red);">RM ${item.price.toFixed(2)}</span>
                                <div style="display:flex; align-items:center; border:1px solid #ddd; border-radius:2px;">
                                    <button style="width:22px; height:22px;" onclick="alterCartQty(${idx}, -1)">-</button>
                                    <span style="width:26px; text-align:center; font-size:11px; font-weight:700;">${item.qty}</span>
                                    <button style="width:22px; height:22px;" onclick="alterCartQty(${idx}, 1)">+</button>
                                </div>
                            </div>
                        </div>
                        <button onclick="deleteCartRow(${idx})" style="position:absolute; top:0; right:0; color:#999; font-size:14px;"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                `;
            });
            list.innerHTML = html;
            calculateDrawerTotals(subtotal);
        }

        function alterCartQty(idx, d) {
            if (!sheinCart[idx]) return;
            sheinCart[idx].qty += d;
            if (sheinCart[idx].qty <= 0) sheinCart.splice(idx, 1);
            saveSheinCart();
        }

        function deleteCartRow(idx) {
            sheinCart.splice(idx, 1);
            saveSheinCart();
            showToast('Item removed from shopping bag');
        }

        function calculateDrawerTotals(subtotal) {
            const freeThresh = 120.00;
            const meterText = document.getElementById('drawerMeterText');
            const meterFill = document.getElementById('drawerMeterFill');

            if (subtotal >= freeThresh) {
                meterText.innerHTML = `🎉 Congratulations! You unlocked <strong>FREE SHIPPING!</strong>`;
                meterFill.style.width = '100%';
            } else {
                const diff = (freeThresh - subtotal).toFixed(2);
                const pct = Math.min(100, (subtotal / freeThresh) * 100);
                meterText.innerHTML = `🚚 Add <strong>RM ${diff}</strong> more to unlock FREE SHIPPING!`;
                meterFill.style.width = `${pct}%`;
            }

            const discount = subtotal * discountRate;
            const shipping = (subtotal >= freeThresh || subtotal === 0) ? 0.00 : 15.00;
            const finalTotal = Math.max(0, subtotal - discount + shipping);

            document.getElementById('drawerSubtotalText').innerText = `RM ${subtotal.toFixed(2)}`;
            if (discountRate > 0) {
                document.getElementById('drawerDiscountRow').style.display = 'flex';
                document.getElementById('drawerDiscountCode').innerText = discountCodeName;
                document.getElementById('drawerDiscountVal').innerText = `-RM ${discount.toFixed(2)}`;
            } else {
                document.getElementById('drawerDiscountRow').style.display = 'none';
            }

            document.getElementById('drawerShippingVal').innerText = shipping === 0 ? 'FREE' : `RM ${shipping.toFixed(2)}`;
            document.getElementById('drawerTotalText').innerText = `RM ${finalTotal.toFixed(2)}`;
        }

        function applyDrawerPromo() {
            const input = document.getElementById('drawerPromoInput');
            const code = input.value.trim().toUpperCase();
            if (!code) return;

            if (code === 'NEW15') {
                discountRate = 0.15;
                discountCodeName = code;
                showToast(`🎉 15% OFF applied via code ${code}!`);
            } else if (code === 'NEW29') {
                discountRate = 0.29;
                discountCodeName = code;
                showToast(`🎉 29% OFF Welcome Deal applied via code ${code}!`);
            } else if (code === 'NEW36') {
                discountRate = 0.36;
                discountCodeName = code;
                showToast(`🎉 36% OFF Welcome Deal applied via code ${code}!`);
            } else if (code === 'NEW38') {
                discountRate = 0.38;
                discountCodeName = code;
                showToast(`🎉 38% OFF Super Welcome Deal applied via code ${code}!`);
            } else if (code === 'MY10' || code === 'SHEIN10') {
                discountRate = 0.10;
                discountCodeName = code;
                showToast(`🎉 10% OFF applied via code ${code}!`);
            } else if (code === 'MY25') {
                discountRate = 0.20;
                discountCodeName = code;
                showToast(`🎉 20% OFF applied via code ${code}!`);
            } else if (code === 'MY50') {
                discountRate = 0.25;
                discountCodeName = code;
                showToast(`🎉 25% OFF applied via code ${code}!`);
            } else {
                showToast(`❌ Invalid or expired coupon: ${code}`);
                return;
            }
            renderDrawerItems();
        }

        function checkoutAction() {
            if (sheinCart.length === 0) {
                showToast('Your shopping bag is empty.');
                return;
            }
            showToast('🚀 Proceeding to ' + {!! json_encode(get_setting('com_name') ?: 'FAST IT') !!} + ' Secured Checkout...');
            setTimeout(() => {
                window.location.href = "{{ route('frontend.checkout') }}";
            }, 400);
        }

        // Wishlist
        function toggleWishlist(item) {
            const idx = sheinWishlist.findIndex(w => w.id === item.id);
            if (idx > -1) {
                sheinWishlist.splice(idx, 1);
                showToast('Removed from Wishlist');
            } else {
                sheinWishlist.push(item);
                showToast('❤️ Added to Wishlist!');
            }
            localStorage.setItem('shein_wishlist', JSON.stringify(sheinWishlist));
            refreshWishlistUI();
        }

        function refreshWishlistUI() {
            const total = sheinWishlist.length;
            const b = document.getElementById('navWishlistBadge');
            if (b) b.innerText = total;

            document.querySelectorAll('.shein-heart-btn').forEach(btn => {
                const pid = parseInt(btn.dataset.id);
                if (sheinWishlist.some(w => w.id === pid)) {
                    btn.classList.add('active');
                    btn.innerHTML = '<i class="fa-solid fa-heart" style="color:var(--shein-red);"></i>';
                } else {
                    btn.classList.remove('active');
                    btn.innerHTML = '<i class="fa-regular fa-heart"></i>';
                }
            });
        }

        // Voucher Coupon Collection
        function collectCoupon(code, btn) {
            btn.style.background = '#E8F5E9';
            btn.style.color = '#2E7D32';
            btn.innerText = 'COLLECTED ✓';
            showToast(`🎉 Coupon "${code}" collected and applied to your account!`);
            document.getElementById('drawerPromoInput').value = code;
            applyDrawerPromo();
        }

        // Quick View Modal
        function openQuickModal(item) {
            currentModalItem = item;
            currentModalQty = 1;
            currentModalChosenSize = (item.sizes && item.sizes.length > 0) ? item.sizes[0] : 'One Size';

            document.getElementById('qModalImg').src = item.image_primary || item.image || item.img;
            document.getElementById('qModalBrand').innerText = item.brand || {!! json_encode(get_setting('com_name') ?: 'FAST IT') !!};
            document.getElementById('qModalTitle').innerText = item.name;
            document.getElementById('qModalPrice').innerText = `RM ${parseFloat(item.price).toFixed(2)}`;
            document.getElementById('qModalOrigPrice').innerText = `RM ${parseFloat(item.original_price || item.orig_price || item.price * 1.8).toFixed(2)}`;
            document.getElementById('qModalDisc').innerText = item.discount ? `-${item.discount}%` : '-50%';
            document.getElementById('qModalQtyVal').innerText = currentModalQty;

            const box = document.getElementById('qModalSizes');
            box.innerHTML = '';
            (item.sizes || ['XS', 'S', 'M', 'L']).forEach(sz => {
                const b = document.createElement('button');
                b.style.cssText = `border:1px solid ${sz === currentModalChosenSize ? '#000' : '#ddd'}; background:${sz === currentModalChosenSize ? '#000' : '#fff'}; color:${sz === currentModalChosenSize ? '#fff' : '#000'}; padding:5px 10px; font-size:11px; font-weight:700; border-radius:2px;`;
                b.innerText = sz;
                b.onclick = () => {
                    currentModalChosenSize = sz;
                    box.querySelectorAll('button').forEach(btn => {
                        btn.style.border = '1px solid #ddd';
                        btn.style.background = '#fff';
                        btn.style.color = '#000';
                    });
                    b.style.border = '1px solid #000';
                    b.style.background = '#000';
                    b.style.color = '#fff';
                };
                box.appendChild(b);
            });

            document.getElementById('quickViewBackdrop').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeQuickModal() {
            document.getElementById('quickViewBackdrop').classList.remove('active');
            document.body.style.overflow = '';
        }

        function adjustQModalQty(d) {
            currentModalQty = Math.max(1, currentModalQty + d);
            document.getElementById('qModalQtyVal').innerText = currentModalQty;
        }

        function submitQModalToBag() {
            if (!currentModalItem) return;
            for(let i=0; i<currentModalQty; i++) {
                addToBag(currentModalItem, currentModalChosenSize);
            }
            closeQuickModal();
        }

        function showToast(msg) {
            const toast = document.getElementById('sheinToast');
            document.getElementById('toastText').innerText = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }
    </script>
    @include('frontend.partials.floating-chat')
    @stack('scripts')
</body>
</html>
