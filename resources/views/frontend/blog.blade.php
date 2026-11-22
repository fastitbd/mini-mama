@extends('frontend.layouts.master')
@section('title', 'Blog | ' . (get_setting('com_name') ?: 'Mini Mama'))
@section('content')
<div class="shein-wrap" style="padding: 40px 16px; max-width: 1200px;">
    <h1 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 8px;">📝 Our Blog</h1>
    <p style="color: #767676; font-size: 14px; margin-bottom: 30px;">Fashion tips, style guides, and the latest trends.</p>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
        @php
            $posts = [
                ['title' => 'Top 10 Summer Fashion Trends 2026', 'desc' => 'Discover the hottest styles for this summer season. From flowy dresses to bold accessories.', 'icon' => '☀️'],
                ['title' => 'How to Style Your Wardrobe on a Budget', 'desc' => 'Look fabulous without breaking the bank. Smart shopping tips and outfit ideas.', 'icon' => '💡'],
                ['title' => 'New Arrivals: What\'s Trending This Week', 'desc' => 'Check out the latest drops and must-have pieces from our newest collection.', 'icon' => '🆕'],
            ];
        @endphp
        @foreach($posts as $post)
            <div style="background: #f7f7f7; border-radius: 8px; overflow: hidden; transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='none'">
                <div style="background: #000; color: #fff; height: 180px; display: flex; align-items: center; justify-content: center; font-size: 48px;">
                    {{ $post['icon'] }}
                </div>
                <div style="padding: 20px;">
                    <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 8px;">{{ $post['title'] }}</h3>
                    <p style="font-size: 13px; color: #666; line-height: 1.5; margin-bottom: 12px;">{{ $post['desc'] }}</p>
                    <span style="font-size: 12px; font-weight: 700; color: #FA2C19; cursor: pointer;">Read More →</span>
                </div>
            </div>
        @endforeach
    </div>

    <div style="text-align: center; padding: 40px 0; color: #999; font-size: 14px;">
        <i class="fa-regular fa-clock" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
        More blog posts coming soon! Stay tuned.
    </div>
</div>
@endsection
