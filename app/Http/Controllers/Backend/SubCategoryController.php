<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        
        $query = SubCategory::with('category')->orderBy('order_num', 'asc')->orderBy('id', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $subCategories = $query->paginate(20)->appends($request->all());

        return view('backend.pages.category.subcategory', compact('subCategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:4096',
            'order_num' => 'nullable|integer',
        ]);

        $subCategory = new SubCategory();
        $subCategory->category_id = $request->category_id;
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug ? \Illuminate\Support\Str::slug($request->slug) : \Illuminate\Support\Str::slug($request->name);
        $subCategory->order_num = $request->order_num ?? 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/subcategories'), $fileName);
            $subCategory->image = $fileName;
        }

        $subCategory->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Subcategory created successfully'),
                'sub_category' => $subCategory,
            ]);
        }

        session()->flash('success', __('Subcategory created successfully'));
        return back();
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:4096',
            'order_num' => 'nullable|integer',
        ]);

        $subCategory = SubCategory::findOrFail($id);
        $subCategory->category_id = $request->category_id;
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug ? \Illuminate\Support\Str::slug($request->slug) : \Illuminate\Support\Str::slug($request->name);
        $subCategory->order_num = $request->order_num ?? $subCategory->order_num ?? 0;

        if ($request->hasFile('image')) {
            if (!empty($subCategory->image) && file_exists(public_path('uploads/subcategories/' . $subCategory->image))) {
                @unlink(public_path('uploads/subcategories/' . $subCategory->image));
            }
            $file = $request->file('image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/subcategories'), $fileName);
            $subCategory->image = $fileName;
        }

        $subCategory->save();

        session()->flash('success', __('Subcategory updated successfully'));
        return back();
    }

    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        if (!empty($subCategory->image) && file_exists(public_path('uploads/subcategories/' . $subCategory->image))) {
            @unlink(public_path('uploads/subcategories/' . $subCategory->image));
        }
        $subCategory->delete();

        session()->flash('success', __('Subcategory deleted successfully'));
        return back();
    }

    public function getByCategory(Request $request)
    {
        $categoryId = $request->category_id;
        if (!$categoryId) {
            return response()->json([]);
        }

        $subCategories = SubCategory::where('category_id', $categoryId)->orderBy('name', 'asc')->get();

        return response()->json($subCategories);
    }
}
