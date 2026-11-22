@extends('backend.layouts.master')

@section('title', 'Edit Blog Post')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200">
        <div>
            <a href="{{ route('blog-posts.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 mb-1 inline-flex items-center gap-1">
                &larr; Back to Articles
            </a>
            <h1 class="text-2xl font-black text-slate-800">Edit Blog Article</h1>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <form method="POST" action="{{ route('blog-posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Article Title *</label>
                <input type="text" name="title" value="{{ $post->title }}" required class="w-full px-3.5 py-2.5 text-sm font-semibold border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category</label>
                    <select name="category" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 bg-white font-semibold">
                        <option value="Fashion Trends" {{ $post->category === 'Fashion Trends' ? 'selected' : '' }}>Fashion Trends</option>
                        <option value="Gift Guides" {{ $post->category === 'Gift Guides' ? 'selected' : '' }}>Gift Guides</option>
                        <option value="Shopping Tips" {{ $post->category === 'Shopping Tips' ? 'selected' : '' }}>Shopping Tips</option>
                        <option value="Seasonal Drops" {{ $post->category === 'Seasonal Drops' ? 'selected' : '' }}>Seasonal Drops</option>
                        <option value="Outfit Ideas" {{ $post->category === 'Outfit Ideas' ? 'selected' : '' }}>Outfit Ideas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Author Name</label>
                    <input type="text" name="author" value="{{ $post->author }}" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Publish Status</label>
                    <select name="status" class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 bg-white font-semibold">
                        <option value="published" {{ $post->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft (Saved)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Update Cover Image (Upload)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Or Image CDN URL</label>
                    <input type="url" name="image_url" value="{{ $post->image }}" placeholder="https://images.unsplash.com/photo-..." class="w-full px-3 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Brief Summary / Excerpt</label>
                <textarea name="summary" rows="2" class="w-full px-3.5 py-2 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500">{{ $post->summary }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Article Content (HTML / Text) *</label>
                <textarea name="content" rows="12" required class="w-full p-4 text-xs font-mono border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 bg-slate-50 leading-relaxed">{{ $post->content }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('blog-posts.index') }}" class="px-5 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200">Cancel</a>
                <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white bg-slate-900 rounded-lg hover:bg-orange-600 transition">Update Post</button>
            </div>
        </form>
    </div>
</div>
@endsection
