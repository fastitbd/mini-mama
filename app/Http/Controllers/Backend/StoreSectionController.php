<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StoreSection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreSectionController extends Controller
{
    /**
     * Display listing of store sections or return JSON for AJAX.
     */
    public function index(Request $request)
    {
        $sections = StoreSection::ordered()->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'sections' => $sections,
            ]);
        }

        return view('backend.pages.store_section.index', compact('sections'));
    }

    /**
     * Store a newly created section.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'subtitle' => 'nullable|string|max:150',
            'icon' => 'nullable|string|max:50',
            'badge_text' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:30',
            'key' => 'nullable|string|max:50',
        ]);

        $rawKey = $request->filled('key') ? $request->key : Str::slug($request->name, '_');
        $key = Str::snake(strtolower(trim($rawKey)));

        // Ensure key is unique
        $originalKey = $key;
        $counter = 1;
        while (StoreSection::where('key', $key)->exists()) {
            $key = $originalKey . '_' . $counter++;
        }

        $maxOrder = StoreSection::max('order_num') ?? 0;

        $section = StoreSection::create([
            'key' => $key,
            'name' => trim($request->name),
            'subtitle' => $request->subtitle ? trim($request->subtitle) : null,
            'icon' => $request->icon ? trim($request->icon) : '🏷️',
            'badge_text' => $request->badge_text ? trim($request->badge_text) : null,
            'color' => $request->color ? trim($request->color) : '#FA2C19',
            'order_num' => $maxOrder + 1,
            'status' => true,
            'is_system' => false,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Section ":name" created successfully!', ['name' => $section->name]),
                'section' => $section,
                'sections' => StoreSection::ordered()->get(),
            ]);
        }

        session()->flash('success', __('Store section created successfully!'));
        return back();
    }

    /**
     * Update the specified section.
     */
    public function update(Request $request, $id)
    {
        $section = StoreSection::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'subtitle' => 'nullable|string|max:150',
            'icon' => 'nullable|string|max:50',
            'badge_text' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:30',
            'order_num' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $section->name = trim($request->name);
        $section->subtitle = $request->has('subtitle') ? trim($request->subtitle) : $section->subtitle;
        $section->icon = $request->has('icon') ? trim($request->icon) : $section->icon;
        $section->badge_text = $request->has('badge_text') ? trim($request->badge_text) : $section->badge_text;
        $section->color = $request->has('color') ? trim($request->color) : $section->color;
        
        if ($request->has('order_num')) {
            $section->order_num = (int)$request->order_num;
        }
        if ($request->has('status')) {
            $section->status = (bool)$request->status;
        }

        $section->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Section ":name" updated successfully!', ['name' => $section->name]),
                'section' => $section,
                'sections' => StoreSection::ordered()->get(),
            ]);
        }

        session()->flash('success', __('Store section updated successfully!'));
        return back();
    }

    /**
     * Remove the specified section.
     */
    public function destroy(Request $request, $id)
    {
        $section = StoreSection::findOrFail($id);

        if ($section->is_system) {
            $msg = __('System sections (Super Deals / Trends) cannot be deleted, but you can edit their names.');
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
            }
            session()->flash('error', $msg);
            return back();
        }

        // Reset products with this section to null
        Product::where('section', $section->key)->update(['section' => null]);

        $name = $section->name;
        $section->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Section ":name" removed successfully.', ['name' => $name]),
                'sections' => StoreSection::ordered()->get(),
            ]);
        }

        session()->flash('success', __('Store section removed successfully.'));
        return back();
    }

    /**
     * Run Demo Data Seeder via Web Request
     */
    public function seedDemoData(Request $request)
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('app:seed-demo');
            session()->flash('success', __('Demo data (Products, Categories, Banners, Store Sections) installed successfully!'));
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to install demo data: ') . $e->getMessage());
        }

        return redirect()->back();
    }
}
