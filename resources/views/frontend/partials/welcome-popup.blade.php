@php
    if (function_exists('get_setting') && get_setting('welcome_popup_status') === 'disabled') {
        return;
    }
    $welcomeDeals = function_exists('get_welcome_popup_deals') ? get_welcome_popup_deals() : [];
    $popupTitle = function_exists('get_setting') && !empty(get_setting('welcome_popup_title')) ? get_setting('welcome_popup_title') : 'Special Deals Just for You';
    $popupSubtitle = function_exists('get_setting') && !empty(get_setting('welcome_popup_subtitle')) ? get_setting('welcome_popup_subtitle') : 'Coupons confirmed after login';
@endphp

<!-- ========================================================
     OFFICIAL DYNAMIC "SPECIAL DEALS" POPUP
     ======================================================== -->
<div id="sheinWelcomeModalBackdrop" class="shein-welcome-backdrop" onclick="handleWelcomeBackdropClick(event)">
    <div class="shein-welcome-wrapper" id="sheinWelcomeModalWrapper">
        
        <!-- 1. Floating Circular Close Button -->
        <button type="button" class="shein-modal-close-btn" onclick="closeWelcomePopup()" title="Close Deals">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- 2. Glowing Golden Gift Bow Ribbon & Sparkles -->
        <div class="shein-gift-ribbon-container">
            <div class="shein-sparkle sparkle-1">✦</div>
            <div class="shein-sparkle sparkle-2">✧</div>
            <div class="shein-sparkle sparkle-3">✨</div>
            <div class="shein-sparkle sparkle-4">✦</div>
            <div class="shein-sparkle sparkle-5">✨</div>
            
            <!-- 3D Golden Ribbon Bow SVG -->
            <div class="shein-golden-bow">
                <svg width="150" height="96" viewBox="0 0 150 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="goldGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#FFEAA7" />
                            <stop offset="35%" stop-color="#FDCB6E" />
                            <stop offset="70%" stop-color="#E17055" />
                            <stop offset="100%" stop-color="#D63031" />
                        </linearGradient>
                        <linearGradient id="goldGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#FFF3CD" />
                            <stop offset="40%" stop-color="#FEEAA2" />
                            <stop offset="80%" stop-color="#F39C12" />
                            <stop offset="100%" stop-color="#D35400" />
                        </linearGradient>
                        <linearGradient id="goldCenter" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#FFF9E6" />
                            <stop offset="50%" stop-color="#F1C40F" />
                            <stop offset="100%" stop-color="#B7791F" />
                        </linearGradient>
                        <filter id="goldGlow" x="-20%" y="-20%" width="140%" height="140%">
                            <feGaussianBlur stdDeviation="3" result="blur" />
                            <feComposite in="SourceGraphic" in2="blur" operator="over" />
                        </filter>
                    </defs>

                    <!-- Left Loop Back -->
                    <path d="M75 48 C45 20, 15 28, 22 56 C28 80, 65 62, 75 48 Z" fill="url(#goldGrad1)" opacity="0.9" />
                    <!-- Right Loop Back -->
                    <path d="M75 48 C105 20, 135 28, 128 56 C122 80, 85 62, 75 48 Z" fill="url(#goldGrad1)" opacity="0.9" />

                    <!-- Left Main Loop Front -->
                    <path d="M75 46 C52 16, 20 22, 28 48 C36 74, 68 56, 75 46 Z" fill="url(#goldGrad2)" filter="url(#goldGlow)" />
                    <!-- Right Main Loop Front -->
                    <path d="M75 46 C98 16, 130 22, 122 48 C114 74, 82 56, 75 46 Z" fill="url(#goldGrad2)" filter="url(#goldGlow)" />

                    <!-- Hanging Ribbon Tails -->
                    <path d="M68 52 C55 68, 38 78, 26 88 C36 86, 48 83, 56 78 C64 86, 70 65, 68 52 Z" fill="url(#goldGrad1)" />
                    <path d="M82 52 C95 68, 112 78, 124 88 C114 86, 102 83, 94 78 C86 86, 80 65, 82 52 Z" fill="url(#goldGrad1)" />

                    <!-- Central Ribbon Knot -->
                    <ellipse cx="75" cy="46" rx="14" ry="11" fill="url(#goldCenter)" filter="url(#goldGlow)" />
                    <ellipse cx="73" cy="44" rx="11" ry="8" fill="#FFF6D6" opacity="0.6" />
                </svg>
            </div>
        </div>

        <!-- 3. Main White Modal Card Body -->
        <div class="shein-welcome-card">
            
            <!-- Modal Title with Golden Gradient -->
            <h2 class="shein-welcome-title">
                {{ $popupTitle }}
            </h2>

            <!-- Dynamic Vouchers Container -->
            <div class="shein-vouchers-stack">
                @foreach($welcomeDeals as $deal)
                    <div class="shein-coupon-ticket" data-code="{{ $deal['code'] ?? 'NEW' . ($deal['discount'] ?? '20') }}" data-discount="{{ $deal['rate'] ?? 0.20 }}">
                        <!-- Top-Left Red Badge -->
                        <span class="shein-ticket-badge">{{ $deal['tag'] ?? 'New User' }}</span>

                        <!-- Left Discount Section -->
                        <div class="shein-ticket-left">
                            <!-- Circular Cutout Notches -->
                            <div class="ticket-notch notch-top"></div>
                            <div class="ticket-notch notch-bottom"></div>

                            <div class="shein-ticket-amount">
                                <span class="val">{{ $deal['discount'] }}</span>
                                <span class="unit">{{ $deal['unit'] ?? '%OFF' }}</span>
                            </div>
                            <div class="shein-ticket-condition">{{ $deal['condition'] ?? 'No Min. Buy' }}</div>
                        </div>

                        <!-- Right Coupon Details Section -->
                        <div class="shein-ticket-right">
                            <div class="shein-ticket-title">{{ $deal['title'] ?? 'Product Coupon' }}</div>
                            <div class="shein-ticket-cap">{{ $deal['cap'] ?? 'Capped at RM16.35' }}</div>
                            <div class="shein-ticket-timer">
                                <span>{{ $deal['timer'] ?? 'Time-limited' }}</span>
                                <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #999;"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- 4. Collect All CTA Action Button -->
            <button type="button" id="collectAllDealsBtn" class="shein-btn-collect-all" onclick="collectAllWelcomeDeals()">
                <span id="collectBtnText">Collect All</span>
            </button>

            <!-- Bottom Disclaimer Notice -->
            <div class="shein-welcome-subtitle">
                {{ $popupSubtitle }}
            </div>

        </div>

    </div>
</div>

<!-- 5. Floating Special Deals Launcher Badge (Allows re-opening anytime) -->
<div id="sheinFloatingDealsTrigger" class="shein-floating-deals-badge" onclick="openWelcomePopup()" title="Special Deals Just for You">
    <span class="icon">🎁</span>
    <span class="text">Special Deals</span>
    <span class="count">{{ count($welcomeDeals) }}</span>
</div>

<style>
/* ========================================================
   WELCOME POPUP MODAL STYLES (OFFICIAL SPEC)
   ======================================================== */
.shein-welcome-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.72);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    opacity: 0;
    transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.shein-welcome-backdrop.active {
    display: flex;
    opacity: 1;
}

.shein-welcome-wrapper {
    position: relative;
    max-width: 440px;
    width: 100%;
    transform: scale(0.88) translateY(20px);
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.shein-welcome-backdrop.active .shein-welcome-wrapper {
    transform: scale(1) translateY(0);
}

/* Floating Circular Close Button */
.shein-modal-close-btn {
    position: absolute;
    top: -50px;
    right: 0px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.65);
    border: 2px solid rgba(255, 255, 255, 0.85);
    color: #ffffff;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 20;
    transition: transform 0.2s, background 0.2s;
    outline: none;
}

.shein-modal-close-btn:hover {
    background: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

/* 3D Golden Ribbon Bow & Floating Sparkles */
.shein-gift-ribbon-container {
    position: absolute;
    top: -46px;
    left: 50%;
    transform: translateX(-50%);
    width: 160px;
    height: 96px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 15;
    pointer-events: none;
}

.shein-golden-bow {
    filter: drop-shadow(0 6px 12px rgba(225, 112, 85, 0.45));
    animation: ribbonFloat 3s ease-in-out infinite alternate;
}

@keyframes ribbonFloat {
    0% { transform: translateY(0); }
    100% { transform: translateY(-4px); }
}

/* Sparkles animation */
.shein-sparkle {
    position: absolute;
    color: #FFF2A3;
    font-size: 15px;
    filter: drop-shadow(0 0 6px #F1C40F);
    animation: sparkleBlink 2.2s infinite ease-in-out;
}
.sparkle-1 { top: -8px; left: -15px; font-size: 18px; animation-delay: 0.1s; }
.sparkle-2 { top: -14px; right: 0px; font-size: 14px; animation-delay: 0.7s; }
.sparkle-3 { top: 20px; left: -25px; font-size: 20px; animation-delay: 1.3s; }
.sparkle-4 { top: 16px; right: -25px; font-size: 16px; animation-delay: 0.4s; }
.sparkle-5 { top: -20px; left: 45%; font-size: 17px; animation-delay: 1.0s; }

@keyframes sparkleBlink {
    0%, 100% { opacity: 0.2; transform: scale(0.8); }
    50% { opacity: 1; transform: scale(1.25); }
}

/* Main White Card Body */
.shein-welcome-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 42px 24px 22px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45), 0 0 35px rgba(253, 203, 110, 0.2);
    position: relative;
    box-sizing: border-box;
    overflow: hidden;
}

/* Title */
.shein-welcome-title {
    font-size: 21px;
    font-weight: 900;
    text-align: center;
    background: linear-gradient(135deg, #DE5E00 0%, #FA6338 50%, #C43800 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0 0 18px;
    letter-spacing: 0.3px;
    font-family: inherit;
}

/* Stack of Coupons */
.shein-vouchers-stack {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

/* Individual Ticket */
.shein-coupon-ticket {
    background: #FFFDFC;
    border: 1px solid #FFD0C7;
    border-radius: 8px;
    position: relative;
    display: flex;
    align-items: stretch;
    min-height: 84px;
    box-shadow: 0 2px 6px rgba(250, 44, 25, 0.04);
    box-sizing: border-box;
    transition: transform 0.2s, box-shadow 0.2s;
}

.shein-coupon-ticket:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(250, 44, 25, 0.08);
}

/* Red Tag */
.shein-ticket-badge {
    position: absolute;
    top: 0;
    left: 0;
    background: #FA2C19;
    color: #ffffff;
    font-size: 10px;
    font-weight: 800;
    padding: 2px 8px;
    border-top-left-radius: 7px;
    border-bottom-right-radius: 8px;
    letter-spacing: 0.2px;
    z-index: 2;
}

/* Left side of ticket */
.shein-ticket-left {
    width: 140px;
    min-width: 130px;
    padding: 20px 8px 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-right: 1px dashed #FFBEB2;
    position: relative;
    box-sizing: border-box;
}

/* Semicircular Perforation Notches */
.ticket-notch {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #ffffff;
    border: 1px solid #FFD0C7;
    border-radius: 50%;
    z-index: 3;
}
.notch-top {
    top: -6px;
    right: -6px;
}
.notch-bottom {
    bottom: -6px;
    right: -6px;
}

.shein-ticket-amount {
    color: #FA2C19;
    font-weight: 900;
    line-height: 1;
    display: flex;
    align-items: baseline;
}
.shein-ticket-amount .val {
    font-size: 30px;
    letter-spacing: -1px;
}
.shein-ticket-amount .unit {
    font-size: 13px;
    font-weight: 900;
    margin-left: 2px;
}

.shein-ticket-condition {
    font-size: 11px;
    color: #555555;
    margin-top: 4px;
    font-weight: 600;
    text-align: center;
}

/* Right side of ticket */
.shein-ticket-right {
    flex: 1;
    padding: 12px 14px 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: left;
    box-sizing: border-box;
}

.shein-ticket-title {
    font-size: 14px;
    font-weight: 800;
    color: #FA2C19;
    line-height: 1.25;
}

.shein-ticket-cap {
    font-size: 11px;
    color: #666666;
    margin-top: 3px;
}

.shein-ticket-timer {
    font-size: 11px;
    color: #888888;
    margin-top: 5px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Collect All Button */
.shein-btn-collect-all {
    background: #000000;
    color: #ffffff;
    width: 100%;
    height: 48px;
    border-radius: 24px;
    font-size: 15px;
    font-weight: 900;
    letter-spacing: 0.5px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.22);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    outline: none;
}

.shein-btn-collect-all:hover {
    background: #222222;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.shein-btn-collect-all.collected {
    background: #00A65A !important;
    transform: scale(1.02);
}

/* Subtitle */
.shein-welcome-subtitle {
    font-size: 11px;
    color: #777777;
    text-align: center;
    margin-top: 10px;
    font-weight: 500;
}

/* Floating Deals Launcher Trigger Badge */
.shein-floating-deals-badge {
    position: fixed;
    left: 20px;
    bottom: 30px;
    background: linear-gradient(135deg, #FF6B4A 0%, #FA2C19 100%);
    color: #ffffff;
    padding: 9px 15px;
    border-radius: 22px;
    box-shadow: 0 4px 18px rgba(250, 44, 25, 0.35);
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    z-index: 998;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.3px;
    transition: transform 0.2s, box-shadow 0.2s;
    user-select: none;
}

.shein-floating-deals-badge:hover {
    transform: translateY(-3px) scale(1.04);
    box-shadow: 0 6px 22px rgba(250, 44, 25, 0.5);
}

.shein-floating-deals-badge .icon {
    font-size: 15px;
    animation: giftBounce 2s infinite ease-in-out;
}

.shein-floating-deals-badge .count {
    background: #ffffff;
    color: #FA2C19;
    font-size: 10px;
    font-weight: 900;
    padding: 1px 6px;
    border-radius: 10px;
}

@keyframes giftBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

@media (max-width: 480px) {
    .shein-welcome-card {
        padding: 38px 16px 18px;
    }
    .shein-ticket-left {
        width: 115px;
        min-width: 115px;
    }
    .shein-ticket-amount .val {
        font-size: 26px;
    }
    .shein-welcome-title {
        font-size: 19px;
    }
    .shein-floating-deals-badge {
        bottom: 75px; /* Above mobile bottom bar */
        left: 14px;
    }
}
</style>

<script>
    // ========================================================
    // WELCOME POPUP MODAL JAVASCRIPT LOGIC
    // ========================================================
    document.addEventListener('DOMContentLoaded', () => {
        // Auto trigger popup on page load if not recently collected in this session
        const isCollected = localStorage.getItem('shein_welcome_deals_collected');
        const isDismissed = sessionStorage.getItem('shein_welcome_deals_dismissed');

        // Show after a gentle 900ms delay for maximum visual impact
        setTimeout(() => {
            if (!isDismissed) {
                openWelcomePopup();
            }
        }, 900);
    });

    function openWelcomePopup() {
        const backdrop = document.getElementById('sheinWelcomeModalBackdrop');
        if (!backdrop) return;
        backdrop.style.display = 'flex';
        // Trigger CSS transition
        setTimeout(() => {
            backdrop.classList.add('active');
        }, 10);
    }

    function closeWelcomePopup() {
        const backdrop = document.getElementById('sheinWelcomeModalBackdrop');
        if (!backdrop) return;
        backdrop.classList.remove('active');
        sessionStorage.setItem('shein_welcome_deals_dismissed', 'true');
        setTimeout(() => {
            backdrop.style.display = 'none';
        }, 300);
    }

    function handleWelcomeBackdropClick(e) {
        if (e.target && e.target.id === 'sheinWelcomeModalBackdrop') {
            closeWelcomePopup();
        }
    }

    // Escape key listener to close modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const backdrop = document.getElementById('sheinWelcomeModalBackdrop');
            if (backdrop && backdrop.classList.contains('active')) {
                closeWelcomePopup();
            }
        }
    });

    // "Collect All" Action
    function collectAllWelcomeDeals() {
        const btn = document.getElementById('collectAllDealsBtn');
        const btnText = document.getElementById('collectBtnText');

        if (btn) {
            btn.classList.add('collected');
            btn.disabled = true;
            btnText.innerHTML = '<i class="fa-solid fa-check"></i> ALL COLLECTED!';
        }

        // Store collected coupons in localStorage
        const collectedCodes = ['NEW29', 'NEW36', 'NEW38'];
        localStorage.setItem('shein_welcome_deals_collected', 'true');
        localStorage.setItem('shein_collected_codes', JSON.stringify(collectedCodes));
        // Default the best promo code into user session/cart
        localStorage.setItem('shein_applied_coupon', 'NEW38');

        // Trigger confetti celebration
        spawnConfettiParticles();

        if (typeof showToast === 'function') {
            showToast('🎉 All 3 Special Deals Collected! Up to 38% OFF ready in your Bag.');
        }

        // Update badge count or text
        const badge = document.getElementById('sheinFloatingDealsTrigger');
        if (badge) {
            badge.style.background = 'linear-gradient(135deg, #10B981 0%, #059669 100%)';
            badge.querySelector('.text').innerText = 'Deals Active';
            badge.querySelector('.count').innerText = '✓';
        }

        // Close after 1.8 seconds so user sees the success state
        setTimeout(() => {
            closeWelcomePopup();
        }, 1800);
    }

    // Mini Confetti particle celebration effect
    function spawnConfettiParticles() {
        const colors = ['#FA2C19', '#F1C40F', '#FF6B4A', '#2ECC71', '#3498DB', '#9B59B6'];
        const wrapper = document.getElementById('sheinWelcomeModalWrapper');
        if (!wrapper) return;

        for (let i = 0; i < 40; i++) {
            const particle = document.createElement('div');
            particle.style.position = 'absolute';
            particle.style.width = (Math.random() * 8 + 6) + 'px';
            particle.style.height = (Math.random() * 8 + 6) + 'px';
            particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            particle.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
            particle.style.top = '50%';
            particle.style.left = '50%';
            particle.style.zIndex = '99';
            particle.style.pointerEvents = 'none';

            const angle = Math.random() * Math.PI * 2;
            const velocity = Math.random() * 180 + 80;
            const destX = Math.cos(angle) * velocity;
            const destY = Math.sin(angle) * velocity;

            particle.style.transition = 'transform 1s cubic-bezier(0.16, 1, 0.3, 1), opacity 1s';
            wrapper.appendChild(particle);

            setTimeout(() => {
                particle.style.transform = `translate(${destX}px, ${destY}px) rotate(${Math.random() * 360}deg)`;
                particle.style.opacity = '0';
            }, 20);

            setTimeout(() => {
                particle.remove();
            }, 1100);
        }
    }
</script>
