@extends('frontend.layouts.master')
@section('title', 'Style Blog & Fashion Guides | ' . (get_setting('com_name') ?: 'Mini Mama'))

@push('css')
<style>
    .blog-header {
        text-align: center;
        padding: 40px 16px 30px;
        background: linear-gradient(180deg, #fff5f5 0%, #ffffff 100%);
        border-radius: 16px;
        margin-bottom: 35px;
    }
    .blog-badge {
        display: inline-block;
        padding: 4px 14px;
        background: #fee2e2;
        color: #ef4444;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        border-radius: 20px;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    @media (max-width: 991px) {
        .blog-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 600px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }
    .blog-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .blog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }
    .blog-card-img-wrap {
        position: relative;
        height: 200px;
        background: #f8fafc;
        overflow: hidden;
    }
    .blog-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .blog-card:hover .blog-card-img-wrap img {
        transform: scale(1.05);
    }
    .blog-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .blog-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 10px;
    }
    .blog-card-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.4;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .blog-card-excerpt {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }
    .blog-card-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #fa2c19;
        text-decoration: none;
        transition: gap 0.2s ease;
    }
    .blog-card-link:hover {
        gap: 10px;
        color: #c91f10;
    }
</style>
@endpush

@section('content')
<div class="shein-wrap" style="padding: 20px 16px 50px; max-width: 1200px; margin: 0 auto;">
    <!-- Breadcrumb -->
    <nav style="font-size: 12px; margin-bottom: 20px; color: #94a3b8;">
        <a href="{{ route('frontend.home') }}" style="color: #64748b; text-decoration: none;">Home</a>
        <span style="margin: 0 6px;">/</span>
        <span style="color: #1e293b; font-weight: 600;">Blog & Guides</span>
    </nav>

    <!-- Header Banner -->
    <div class="blog-header">
        <span class="blog-badge"><i class="fas fa-feather-alt me-1"></i> Official Magazine & Guides</span>
        <h1 style="font-size: 32px; font-weight: 900; color: #0f172a; margin-bottom: 10px; letter-spacing: -0.5px;">Mini Mama Style & Stories</h1>
        <p style="font-size: 14px; color: #64748b; max-width: 600px; margin: 0 auto;">Discover fashion trends, newborn styling tips, maternity guides, and the latest season looks tailored for your family.</p>
    </div>

    <!-- Articles Grid -->
    @if(isset($posts) && $posts->count() > 0)
        <div class="blog-grid">
            @foreach($posts as $post)
            <article class="blog-card">
                <div class="blog-card-img-wrap">
                    @if($post->image)
                        <img src="{{ Str::startsWith($post->image, ['http://', 'https://']) ? $post->image : asset($post->image) }}" alt="{{ $post->title }}">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #fce7f3 0%, #fee2e2 100%); display: flex; align-items: center; justify-content: center; font-size: 40px; color: #f43f5e;">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    @endif
                </div>
                <div class="blog-card-body">
                    <div class="blog-meta">
                        <span><i class="far fa-calendar-alt me-1"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        <span>&bull;</span>
                        <span><i class="far fa-eye me-1"></i> {{ number_format($post->views_count) }} views</span>
                    </div>
                    <h2 class="blog-card-title">
                        <a href="{{ route('frontend.blog.detail', $post->slug) }}" style="color: inherit; text-decoration: none;">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="blog-card-excerpt">
                        {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                    </p>
                    <div>
                        <a href="{{ route('frontend.blog.detail', $post->slug) }}" class="blog-card-link">
                            Read Full Article <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $posts->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px; background: #ffffff; border-radius: 14px; border: 1px dashed #cbd5e1;">
            <i class="fas fa-newspaper" style="font-size: 42px; color: #cbd5e1; margin-bottom: 14px; display: block;"></i>
            <h3 style="font-size: 18px; font-weight: 700; color: #334155;">No blog posts published yet</h3>
            <p style="color: #64748b; font-size: 13px; margin-bottom: 20px;">Check back soon for styling guides, parenting tips, and new arrival stories!</p>
            <a href="{{ route('frontend.home') }}" style="display: inline-block; padding: 10px 24px; background: #fa2c19; color: #fff; font-weight: 700; border-radius: 25px; text-decoration: none; font-size: 13px;">Return to Shop</a>
        </div>
    @endif
</div>
@endsection
