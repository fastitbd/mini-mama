<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $query = BlogPost::latest();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $posts = $query->paginate(12)->appends($request->all());

        return view('backend.pages.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('backend.pages.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/blog');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $imagePath = url('uploads/blog/' . $filename);
        } elseif ($request->image_url) {
            $imagePath = $request->image_url;
        }

        BlogPost::create([
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : (Str::slug($request->title) . '-' . rand(100, 999)),
            'category' => $request->category ?: 'Fashion Trends',
            'author' => $request->author ?: 'Mini Mama Editor',
            'image' => $imagePath,
            'summary' => $request->summary,
            'content' => $request->content,
            'status' => $request->status ?: 'published',
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('blog-posts.index')->with('success', 'Blog post published successfully!');
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('backend.pages.blog.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/blog');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $imagePath = url('uploads/blog/' . $filename);
        } elseif ($request->image_url) {
            $imagePath = $request->image_url;
        }

        $post->update([
            'title' => $request->title,
            'slug' => $request->slug ? Str::slug($request->slug) : $post->slug,
            'category' => $request->category ?: 'Fashion Trends',
            'author' => $request->author ?: 'Mini Mama Editor',
            'image' => $imagePath,
            'summary' => $request->summary,
            'content' => $request->content,
            'status' => $request->status ?: 'published',
        ]);

        return redirect()->route('blog-posts.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        return redirect()->route('blog-posts.index')->with('success', 'Blog post deleted successfully.');
    }
}
