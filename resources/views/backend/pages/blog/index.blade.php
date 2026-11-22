@extends('backend.layouts.master')

@section('title', 'Manage Blog Posts & Style Guides')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-orange-500 mb-1">
                <i class="feather icon-book-open"></i> Content Management
            </div>
            <h1 class="text-2xl font-black text-slate-800">Blog Posts & Gift Guides</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                Publish articles, trend alerts, style recommendations, and gift shopping guides for your customers.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('frontend.blog') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-slate-50 transition">
                <i class="feather icon-external-link"></i> View Live Blog
            </a>
            <a href="{{ route('blog-posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold text-white bg-slate-900 rounded-lg shadow hover:bg-orange-600 transition">
                <i class="feather icon-plus"></i> Write New Post
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-emerald-800 text-sm font-semibold">
            <div class="flex items-center gap-2">
                <i class="feather icon-check-circle text-lg text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- Posts Grid / List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col hover:shadow-md transition">
                <div class="h-44 bg-slate-100 overflow-hidden relative">
                    <img src="{{ $post->image ?: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                        {{ $post->category }}
                    </span>
                    <span class="absolute top-3 right-3 text-[10px] font-bold px-2 py-0.5 rounded uppercase {{ $post->status === 'published' ? 'bg-emerald-500 text-white' : 'bg-amber-500 text-white' }}">
                        {{ ucfirst($post->status) }}
                    </span>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-[11px] text-slate-400 font-semibold mb-1 flex items-center gap-2">
                            <span><i class="feather icon-user"></i> {{ $post->author }}</span>
                            <span>•</span>
                            <span><i class="feather icon-calendar"></i> {{ $post->created_at ? $post->created_at->format('d M Y') : 'Recent' }}</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 leading-snug mb-2 line-clamp-2">
                            {{ $post->title }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4 leading-relaxed">
                            {{ $post->summary ?: strip_tags($post->content) }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 mt-2">
                        <span class="text-[11px] text-slate-400 font-medium">
                            <i class="feather icon-eye"></i> {{ $post->views_count }} reads
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('blog-posts.edit', $post->id) }}" class="p-1.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded transition" title="Edit Article">
                                <i class="feather icon-edit text-sm"></i>
                            </a>
                            <form action="{{ route('blog-posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Delete this blog post?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded transition" title="Delete">
                                    <i class="feather icon-trash-2 text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white border border-slate-200 rounded-xl p-12 text-center text-slate-400">
                <i class="feather icon-book-open text-4xl block mb-2 text-slate-300"></i>
                <h3 class="text-base font-bold text-slate-700 mb-1">No Blog Articles Published Yet</h3>
                <p class="text-xs text-slate-500 mb-4">Start engaging your shoppers with trend alerts and fashion advice.</p>
                <a href="{{ route('blog-posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-slate-900 rounded-lg hover:bg-orange-600">
                    <i class="feather icon-plus"></i> Write First Article
                </a>
            </div>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
