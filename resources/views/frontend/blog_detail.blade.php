@extends('frontend.layouts.master')
@section('title', $post->title . ' | ' . (get_setting('com_name') ?: 'Mini Mama'))

@push('css')
<style>
    .article-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px 16px 60px;
    }
    .article-header {
        margin-bottom: 24px;
    }
    .article-title {
        font-size: 32px;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.3;
        margin-bottom: 14px;
    }
    @media (max-width: 768px) {
        .article-title {
            font-size: 24px;
        }
    }
    .article-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 13px;
        color: #64748b;
        flex-wrap: wrap;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .article-hero-img {
        width: 100%;
        max-height: 480px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    .article-content {
        font-size: 15px;
        line-height: 1.8;
        color: #334155;
    }
    .article-content p {
        margin-bottom: 16px;
    }
    .article-content h2, .article-content h3 {
        color: #0f172a;
        font-weight: 800;
        margin-top: 28px;
        margin-bottom: 12px;
    }
    .article-content img {
        max-width: 100%;
        border-radius: 12px;
        margin: 16px 0;
    }
    .recent-post-card {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        transition: background-color 0.2s ease;
    }
    .recent-post-card:hover .recent-post-title {
        color: #fa2c19;
    }
    .recent-post-img {
        width: 64px;
        height: 64px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        background: #f1f5f9;
    }
    .recent-post-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="article-wrap">
    <!-- Breadcrumbs -->
    <nav style="font-size: 12px; margin-bottom: 20px; color: #94a3b8;">
        <a href="{{ route('frontend.home') }}" style="color: #64748b; text-decoration: none;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <a href="{{ route('frontend.blog') }}" style="color: #64748b; text-decoration: none;">Blog</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #1e293b; font-weight: 600;">{{ Str::limit($post->title, 40) }}</span>
    </nav>

    <div class="row g-4">
        <!-- Main Article Content -->
        <div class="col-lg-8">
            <header class="article-header">
                <h1 class="article-title">{{ $post->title }}</h1>
                <div class="article-meta">
                    <span><i class="fas fa-user-circle me-1 text-primary"></i> {{ $post->author_name ?: 'Mini Mama Editorial' }}</span>
                    <span>&bull;</span>
                    <span><i class="far fa-calendar-alt me-1"></i> {{ $post->created_at->format('F d, Y') }}</span>
                    <span>&bull;</span>
                    <span><i class="far fa-eye me-1"></i> {{ number_format($post->views_count) }} views</span>
                </div>
            </header>

            @if($post->image)
                <img src="{{ Str::startsWith($post->image, ['http://', 'https://']) ? $post->image : asset($post->image) }}" class="article-hero-img" alt="{{ $post->title }}">
            @endif

            @if($post->excerpt)
                <div style="font-size: 16px; font-weight: 500; color: #475569; border-left: 4px solid #fa2c19; padding-left: 16px; margin-bottom: 24px; line-height: 1.6; background: #fff5f5; padding: 14px 16px; border-radius: 0 8px 8px 0;">
                    {{ $post->excerpt }}
                </div>
            @endif

            <div class="article-content">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Share & Return -->
            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: gap: 14px;">
                <a href="{{ route('frontend.blog') }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #475569; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to all articles
                </a>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 12px; font-weight: 700; color: #64748b;">SHARE:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" style="width: 32px; height: 32px; border-radius: 50%; background: #1877f2; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px;"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" style="width: 32px; height: 32px; border-radius: 50%; background: #25d366; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-size: 14px;"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <!-- Sidebar / Recent Posts -->
        <div class="col-lg-4">
            <div style="background: #ffffff; border: 1px solid #f1f5f9; border-radius: 14px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); position: sticky; top: 100px;">
                <h4 style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9;">
                    <i class="fas fa-fire-alt text-danger me-1"></i> Recent Guides & Stories
                </h4>
                @if(isset($recentPosts) && $recentPosts->count() > 0)
                    @foreach($recentPosts as $rPost)
                    <a href="{{ route('frontend.blog.detail', $rPost->slug) }}" class="recent-post-card">
                        @if($rPost->image)
                            <img src="{{ Str::startsWith($rPost->image, ['http://', 'https://']) ? $rPost->image : asset($rPost->image) }}" class="recent-post-img" alt="{{ $rPost->title }}">
                        @else
                            <div class="recent-post-img d-flex align-items-center justify-content-center text-muted" style="background:#fce7f3; color:#f43f5e;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        @endif
                        <div>
                            <div class="recent-post-title">{{ $rPost->title }}</div>
                            <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">
                                <i class="far fa-calendar-alt"></i> {{ $rPost->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </a>
                    @endforeach
                @else
                    <p class="text-muted small mb-0">No other articles available.</p>
                @endif

                <div style="margin-top: 24px; padding: 16px; background: #fff5f5; border-radius: 10px; text-align: center;">
                    <div style="font-size: 13px; font-weight: 800; color: #fa2c19; margin-bottom: 4px;">Exclusive Discounts</div>
                    <p style="font-size: 12px; color: #64748b; margin-bottom: 10px;">Use code <strong>NEW15</strong> for 15% off your first online order!</p>
                    <a href="{{ route('frontend.home') }}" style="display: block; background: #fa2c19; color: #fff; font-size: 12px; font-weight: 700; padding: 7px; border-radius: 20px; text-decoration: none;">Shop New Arrivals</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
