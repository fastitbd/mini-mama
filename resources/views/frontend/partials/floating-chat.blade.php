<!-- ==========================================
     PREMIUM & CUTE FLOATING SUPPORT & CHAT WIDGET
     ========================================== -->
@php
    $siteHotline = get_setting('com_phone') ?: '01910-405112';
    $siteWhatsapp = get_setting('whatsapp_number') ?: preg_replace('/[^0-9]/', '', $siteHotline);
    if (!str_starts_with($siteWhatsapp, '88') && strlen($siteWhatsapp) === 11) {
        $siteWhatsappFull = '88' . $siteWhatsapp;
    } else {
        $siteWhatsappFull = $siteWhatsapp;
    }
    $siteMessenger = get_setting('messenger_url') ?: 'https://m.me/minimama.com.bd';
@endphp
<div id="miniMamaSupportWidget" style="position: fixed; bottom: 24px; right: 24px; z-index: 9995; font-family: var(--shein-font), -apple-system, sans-serif;">

    <!-- FLOATING EXPANDED CHAT POPUP WINDOW -->
    <div id="supportChatPopup" style="display: none; position: absolute; bottom: 72px; right: 0; width: 360px; max-width: calc(100vw - 36px); height: 530px; max-height: calc(100vh - 120px); background: #ffffff; border-radius: 16px; box-shadow: 0 16px 45px rgba(0,0,0,0.18); border: 1px solid #f0f0f0; overflow: hidden; flex-direction: column; animation: popUpSlide 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <!-- POPUP HEADER (Cute Gradient with Agent Profile) -->
        <div style="background: linear-gradient(135deg, #FA2C19 0%, #FF4370 100%); color: #ffffff; padding: 18px 20px; position: relative;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="position: relative;">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=120&auto=format&fit=crop" alt="Support Specialist" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        <span style="position: absolute; bottom: 1px; right: 1px; width: 12px; height: 12px; background: #10B981; border: 2px solid #ffffff; border-radius: 50%;" title="Online"></span>
                    </div>
                    <div>
                        <div style="font-size: 15px; font-weight: 900; letter-spacing: 0.3px; line-height: 1.2;">
                            {{ get_setting('com_name') ?: 'Mini Mama' }} Care 🎀
                        </div>
                        <div style="font-size: 11px; opacity: 0.95; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                            <span style="width: 6px; height: 6px; background: #10B981; border-radius: 50%;"></span>
                            <span>Online | Replies instantly</span>
                        </div>
                    </div>
                </div>

                <!-- Close Button -->
                <button type="button" onclick="toggleSupportChat()" style="width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.22); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 15px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.22)'">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Tab Switcher (Channels vs Live Chat) -->
            <div style="display: flex; gap: 8px; margin-top: 14px; background: rgba(0,0,0,0.15); padding: 3px; border-radius: 8px;">
                <button type="button" id="btnSupportTabChannels" onclick="switchSupportTab('channels')" style="flex: 1; padding: 6px 0; font-size: 11px; font-weight: 800; text-transform: uppercase; border-radius: 6px; background: #ffffff; color: #FA2C19; transition: all 0.2s;">
                    <i class="fa-solid fa-bolt" style="margin-right: 4px;"></i> Quick Support
                </button>
                <button type="button" id="btnSupportTabLive" onclick="switchSupportTab('live')" style="flex: 1; padding: 6px 0; font-size: 11px; font-weight: 800; text-transform: uppercase; border-radius: 6px; background: transparent; color: #ffffff; transition: all 0.2s;">
                    <i class="fa-solid fa-comments" style="margin-right: 4px;"></i> Live Chat
                </button>
            </div>
        </div>

        <!-- TAB 1: QUICK SUPPORT CHANNELS (WhatsApp, Messenger, Phone, FAQ) -->
        <div id="supportChannelsTab" style="flex: 1; overflow-y: auto; padding: 18px 20px; background: #fafafa;">
            
            <div style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">
                Connect Directly With Us
            </div>

            <!-- WHATSAPP INTEGRATION BUTTON -->
            <a href="https://wa.me/{{ $siteWhatsappFull }}?text=Hello%20{{ urlencode(get_setting('com_name') ?: 'Mini Mama') }}%20Support!%20I%20have%20an%20inquiry%20regarding%20products%20or%20an%20order." target="_blank" style="display: flex; align-items: center; justify-content: space-between; background: #ffffff; border: 1.5px solid #25D366; padding: 12px 16px; border-radius: 12px; margin-bottom: 12px; text-decoration: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.12); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 18px rgba(37,211,102,0.22)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(37,211,102,0.12)'">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: #25D366; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 800; color: #111;">Chat on WhatsApp</div>
                        <div style="font-size: 11px; color: #666;">Instant reply on {{ $siteWhatsapp }}</div>
                    </div>
                </div>
                <span style="background: #E8F5E9; color: #2E7D32; font-size: 10px; font-weight: 800; padding: 4px 8px; border-radius: 10px;">
                    FASTEST <i class="fa-solid fa-arrow-right"></i>
                </span>
            </a>

            <!-- FACEBOOK MESSENGER INTEGRATION BUTTON -->
            <a href="{{ $siteMessenger }}" target="_blank" style="display: flex; align-items: center; justify-content: space-between; background: #ffffff; border: 1.5px solid #0084FF; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; text-decoration: none; box-shadow: 0 4px 12px rgba(0, 132, 255, 0.12); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 18px rgba(0,132,255,0.22)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 12px rgba(0,132,255,0.12)'">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, #00B2FF, #006AFF); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                        <i class="fa-brands fa-facebook-messenger"></i>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 800; color: #111;">Facebook Messenger</div>
                        <div style="font-size: 11px; color: #666;">Chat via Facebook page inbox</div>
                    </div>
                </div>
                <span style="background: #E1F5FE; color: #0288D1; font-size: 10px; font-weight: 800; padding: 4px 8px; border-radius: 10px;">
                    OPEN <i class="fa-solid fa-arrow-right"></i>
                </span>
            </a>

            <div style="font-size: 11px; font-weight: 800; color: #888; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">
                Self-Service & Help Topics
            </div>

            <!-- Quick Action Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px;">
                <a href="{{ route('frontend.track_order') }}" style="background: #ffffff; border: 1px solid #e5e5e5; padding: 12px; border-radius: 8px; text-decoration: none; display: flex; flex-direction: column; gap: 6px; transition: border-color 0.2s;" onmouseover="this.style.borderColor='#FA2C19'" onmouseout="this.style.borderColor='#e5e5e5'">
                    <i class="fa-solid fa-truck-fast" style="font-size: 18px; color: #0284C7;"></i>
                    <div style="font-size: 12px; font-weight: 800; color: #222;">Track Order</div>
                    <div style="font-size: 10px; color: #777;">Live courier status</div>
                </a>

                <a href="{{ route('frontend.contact') }}#faq" style="background: #ffffff; border: 1px solid #e5e5e5; padding: 12px; border-radius: 8px; text-decoration: none; display: flex; flex-direction: column; gap: 6px; transition: border-color 0.2s;" onmouseover="this.style.borderColor='#FA2C19'" onmouseout="this.style.borderColor='#e5e5e5'">
                    <i class="fa-solid fa-circle-question" style="font-size: 18px; color: #FA2C19;"></i>
                    <div style="font-size: 12px; font-weight: 800; color: #222;">FAQs & Help</div>
                    <div style="font-size: 10px; color: #777;">Return, payment, size</div>
                </a>

                <a href="tel:01901166580" style="background: #ffffff; border: 1px solid #e5e5e5; padding: 12px; border-radius: 8px; text-decoration: none; display: flex; flex-direction: column; gap: 6px; transition: border-color 0.2s;" onmouseover="this.style.borderColor='#FA2C19'" onmouseout="this.style.borderColor='#e5e5e5'">
                    <i class="fa-solid fa-phone" style="font-size: 18px; color: #16A34A;"></i>
                    <div style="font-size: 12px; font-weight: 800; color: #222;">Call Hotline</div>
                    <div style="font-size: 10px; color: #777;">01901166580</div>
                </a>

                <a href="{{ route('frontend.account') }}" style="background: #ffffff; border: 1px solid #e5e5e5; padding: 12px; border-radius: 8px; text-decoration: none; display: flex; flex-direction: column; gap: 6px; transition: border-color 0.2s;" onmouseover="this.style.borderColor='#FA2C19'" onmouseout="this.style.borderColor='#e5e5e5'">
                    <i class="fa-regular fa-user" style="font-size: 18px; color: #9333EA;"></i>
                    <div style="font-size: 12px; font-weight: 800; color: #222;">My Account</div>
                    <div style="font-size: 10px; color: #777;">Orders & profile</div>
                </a>
            </div>

            <!-- Operating Hours Notice -->
            <div style="background: #FFF7ED; border: 1px solid #FFEDD5; padding: 10px 14px; border-radius: 6px; font-size: 11px; color: #9A3412; display: flex; align-items: center; gap: 8px;">
                <i class="fa-regular fa-clock" style="font-size: 14px;"></i>
                <span>Support Hours: <strong>9:00 AM - 10:00 PM</strong> (Everyday)</span>
            </div>
        </div>

        <!-- TAB 2: INTERACTIVE LIVE CHAT -->
        <div id="supportLiveTab" style="display: none; flex: 1; flex-direction: column; background: #ffffff;">
            <!-- Chat Message Feed -->
            <div id="liveChatMessages" style="flex: 1; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 12px;">
                <!-- Bot Intro Message -->
                <div style="display: flex; gap: 8px; align-items: flex-end;">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=120&auto=format&fit=crop" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                    <div style="background: #F1F5F9; border-radius: 12px 12px 12px 2px; padding: 10px 14px; font-size: 12px; color: #1E293B; max-width: 80%; line-height: 1.4;">
                        Hello and welcome to <strong>{{ get_setting('com_name') ?: 'Mini Mama' }}</strong>! 🌸 How may I assist you today?
                    </div>
                </div>

                <!-- Suggested Quick Query Chips -->
                <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-left: 36px;">
                    <button type="button" onclick="sendChatChip('Where is my order?')" style="background: #ffffff; border: 1px solid #CBD5E1; color: #334155; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 16px; cursor: pointer;">
                        🚚 Track Order
                    </button>
                    <button type="button" onclick="sendChatChip('What are delivery charges?')" style="background: #ffffff; border: 1px solid #CBD5E1; color: #334155; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 16px; cursor: pointer;">
                        📦 Delivery Fees
                    </button>
                    <button type="button" onclick="sendChatChip('How do I return an item?')" style="background: #ffffff; border: 1px solid #CBD5E1; color: #334155; font-size: 11px; font-weight: 600; padding: 5px 10px; border-radius: 16px; cursor: pointer;">
                        🔄 Return Policy
                    </button>
                    <button type="button" onclick="sendChatChip('Connect to human agent on WhatsApp')" style="background: #E8F5E9; border: 1px solid #A5D6A7; color: #2E7D32; font-size: 11px; font-weight: 700; padding: 5px 10px; border-radius: 16px; cursor: pointer;">
                        💬 Agent on WhatsApp
                    </button>
                </div>
            </div>

            <!-- Typing Input Bar -->
            <form id="liveChatInputForm" onsubmit="event.preventDefault(); submitLiveChatMsg();" style="display: flex; align-items: center; padding: 10px 14px; border-top: 1px solid #e2e8f0; background: #ffffff; gap: 8px;">
                <input type="text" id="liveChatUserInput" placeholder="Type a message or question..." required style="flex: 1; height: 38px; border: 1px solid #e2e8f0; border-radius: 20px; padding: 0 14px; font-size: 12px; outline: none; font-family: inherit; box-sizing: border-box;">
                <button type="submit" style="width: 38px; height: 38px; border-radius: 50%; background: #FA2C19; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 14px; border: none; cursor: pointer; flex-shrink: 0;">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>

    </div>

    <!-- CUTE FLOATING TRIGGER BUTTON & CALLOUT PILL -->
    <div style="display: flex; align-items: center; gap: 10px;">
        
        <!-- CUTE INVITATION PILL (Auto-dismisses or clicks to open) -->
        <div id="supportFloatingPill" onclick="toggleSupportChat()" style="background: #ffffff; color: #111111; font-size: 12px; font-weight: 800; padding: 8px 14px; border-radius: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.14); border: 1px solid #f0f0f0; cursor: pointer; display: flex; align-items: center; gap: 6px; animation: bounceGently 2s infinite ease-in-out;">
            <span style="font-size: 14px;">💬</span>
            <span>Need Help? <strong>Chat with us</strong></span>
        </div>

        <!-- MAIN FLOATING CIRCULAR BUTTON -->
        <button type="button" id="supportFabBtn" onclick="toggleSupportChat()" aria-label="Open Customer Support Chat" style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #FA2C19 0%, #FF3D71 100%); color: #ffffff; font-size: 24px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(250, 44, 25, 0.45); cursor: pointer; border: none; outline: none; position: relative; transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fa-solid fa-comments" id="supportFabIcon"></i>
            
            <!-- Animated Green Online Status Dot -->
            <span style="position: absolute; top: 3px; right: 3px; width: 14px; height: 14px; background: #10B981; border: 2px solid #ffffff; border-radius: 50%;"></span>
        </button>

    </div>

</div>

<style>
    @keyframes popUpSlide {
        from { opacity: 0; transform: translateY(20px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes bounceGently {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    @media (max-width: 600px) {
        #supportFloatingPill { display: none !important; }
        #miniMamaSupportWidget { bottom: 16px; right: 16px; }
        #supportChatPopup { width: calc(100vw - 32px); right: 0; }
    }
</style>

<script>
    let isSupportChatOpen = false;

    function toggleSupportChat() {
        const popup = document.getElementById('supportChatPopup');
        const icon = document.getElementById('supportFabIcon');
        const pill = document.getElementById('supportFloatingPill');

        isSupportChatOpen = !isSupportChatOpen;

        if (isSupportChatOpen) {
            popup.style.display = 'flex';
            icon.className = 'fa-solid fa-xmark';
            if (pill) pill.style.display = 'none';
        } else {
            popup.style.display = 'none';
            icon.className = 'fa-solid fa-comments';
        }
    }

    function switchSupportTab(tab) {
        const chanTab = document.getElementById('supportChannelsTab');
        const liveTab = document.getElementById('supportLiveTab');
        const btnChan = document.getElementById('btnSupportTabChannels');
        const btnLive = document.getElementById('btnSupportTabLive');

        if (tab === 'channels') {
            chanTab.style.display = 'block';
            liveTab.style.display = 'none';
            btnChan.style.background = '#ffffff';
            btnChan.style.color = '#FA2C19';
            btnLive.style.background = 'transparent';
            btnLive.style.color = '#ffffff';
        } else {
            chanTab.style.display = 'none';
            liveTab.style.display = 'flex';
            btnLive.style.background = '#ffffff';
            btnLive.style.color = '#FA2C19';
            btnChan.style.background = 'transparent';
            btnChan.style.color = '#ffffff';
        }
    }

    function sendChatChip(text) {
        document.getElementById('liveChatUserInput').value = text;
        submitLiveChatMsg();
    }

    function submitLiveChatMsg() {
        const input = document.getElementById('liveChatUserInput');
        const msg = input.value.trim();
        if (!msg) return;

        const container = document.getElementById('liveChatMessages');

        // Customer message bubble
        const userDiv = document.createElement('div');
        userDiv.style.cssText = "display: flex; justify-content: flex-end;";
        userDiv.innerHTML = `<div style="background: #000000; color: #ffffff; border-radius: 12px 12px 2px 12px; padding: 10px 14px; font-size: 12px; max-width: 80%; line-height: 1.4;">${escapeHtml(msg)}</div>`;
        container.appendChild(userDiv);
        input.value = '';
        container.scrollTop = container.scrollHeight;

        // Auto-reply Bot
        setTimeout(() => {
            let reply = "Thank you for reaching out! Our team is on standby to assist you.";
            const lower = msg.toLowerCase();

            if (lower.includes('track') || lower.includes('order')) {
                reply = `You can easily track your parcel live anytime by visiting our <a href="{{ route('frontend.track_order') }}" style="color: #0284c7; text-decoration: underline; font-weight: 700;">Order Tracking Page</a>. Just enter your Order Number and Mobile Number!`;
            } else if (lower.includes('delivery') || lower.includes('shipping') || lower.includes('charge')) {
                reply = `Standard delivery fee is <strong>৳ 60</strong> inside Dhaka (24-48 hours) and <strong>৳ 120</strong> outside Dhaka (2-4 days). Free Delivery on orders over threshold!`;
            } else if (lower.includes('return') || lower.includes('refund')) {
                reply = `We provide a <strong>7-Day Easy Return & Exchange policy</strong> for damaged, incorrect or size-fitting issues. You can initiate a return on WhatsApp at {{ $siteWhatsapp }}.`;
            } else if (lower.includes('whatsapp') || lower.includes('agent') || lower.includes('human')) {
                reply = `Sure thing! You can chat directly with a live human representative on WhatsApp: <br><a href="https://wa.me/{{ $siteWhatsappFull }}?text=Hello%20{{ urlencode(get_setting('com_name') ?: 'Mini Mama') }}%20Support" target="_blank" style="display:inline-block; margin-top:6px; background:#25D366; color:#fff; font-weight:800; padding:6px 12px; border-radius:4px; font-size:11px; text-decoration:none;"><i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp Now</a>`;
            }

            const botDiv = document.createElement('div');
            botDiv.style.cssText = "display: flex; gap: 8px; align-items: flex-end;";
            botDiv.innerHTML = `
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=120&auto=format&fit=crop" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                <div style="background: #F1F5F9; border-radius: 12px 12px 12px 2px; padding: 10px 14px; font-size: 12px; color: #1E293B; max-width: 80%; line-height: 1.4;">
                    ${reply}
                </div>
            `;
            container.appendChild(botDiv);
            container.scrollTop = container.scrollHeight;
        }, 600);
    }

    function escapeHtml(str) {
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
    }
</script>

<style>
    @media (max-width: 600px) {
        #miniMamaSupportWidget {
            bottom: 68px !important;
            right: 12px !important;
        }
        #supportChatPopup {
            width: calc(100vw - 24px) !important;
            max-width: calc(100vw - 24px) !important;
            right: 0 !important;
            height: 480px !important;
            max-height: calc(100vh - 140px) !important;
        }
    }
</style>
