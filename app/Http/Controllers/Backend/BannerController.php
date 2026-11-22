<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the banners.
     */
    public function index(Request $request)
    {
        $query = Banner::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('btn_text', 'like', "%{$search}%");
            });
        }

        if ($request->filled('banner_type')) {
            $query->where('banner_type', $request->banner_type);
        }

        $banners = $query->orderBy('order_num', 'asc')->orderBy('id', 'desc')->paginate(15);

        return view('backend.pages.banner.index', compact('banners'));
    }

    /**
     * Store a newly created banner in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
            'image_url_input' => 'nullable|string|max:500',
            'bg_color' => 'nullable|string|max:255',
            'btn_text' => 'nullable|string|max:100',
            'btn_url' => 'nullable|string|max:255',
            'banner_type' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer',
            'status' => 'nullable',
        ]);

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->bg_color = $request->bg_color;
        $banner->btn_text = $request->btn_text;
        $banner->btn_url = $request->btn_url;
        $banner->banner_type = $request->banner_type ?: ($request->filled('title') ? 'trend' : 'image');
        $banner->order_num = $request->order_num ?? 0;
        $banner->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banners'), $fileName);
            $banner->image = $fileName;
        } elseif ($request->filled('image_url_input')) {
            $banner->image = $request->image_url_input;
        }

        $banner->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Banner created successfully'),
                'banner' => $banner,
            ]);
        }

        session()->flash('success', __('Banner created successfully'));
        return back();
    }

    /**
     * Update the specified banner in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
            'image_url_input' => 'nullable|string|max:500',
            'bg_color' => 'nullable|string|max:255',
            'btn_text' => 'nullable|string|max:100',
            'btn_url' => 'nullable|string|max:255',
            'banner_type' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer',
            'status' => 'nullable',
        ]);

        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->bg_color = $request->bg_color;
        $banner->btn_text = $request->btn_text;
        $banner->btn_url = $request->btn_url;
        $banner->banner_type = $request->banner_type ?: ($request->filled('title') ? 'trend' : 'image');
        $banner->order_num = $request->order_num ?? 0;
        $banner->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old local file if exists
            if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {
                File::delete(public_path('uploads/banners/' . $banner->image));
            }
            $file = $request->file('image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banners'), $fileName);
            $banner->image = $fileName;
        } elseif ($request->filled('image_url_input')) {
            $banner->image = $request->image_url_input;
        }

        $banner->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Banner updated successfully'),
                'banner' => $banner,
            ]);
        }

        session()->flash('success', __('Banner updated successfully'));
        return back();
    }

    /**
     * Remove the specified banner from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {
            File::delete(public_path('uploads/banners/' . $banner->image));
        }

        $banner->delete();

        session()->flash('success', __('Banner deleted successfully'));
        return back();
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->status = !$banner->status;
        $banner->save();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $banner->status,
                'message' => __('Status updated successfully')
            ]);
        }

        session()->flash('success', __('Status updated successfully'));
        return back();
    }
}
