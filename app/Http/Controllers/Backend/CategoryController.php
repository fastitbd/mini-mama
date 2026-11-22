<?php

namespace App\Http\Controllers\Backend;

use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\BranchCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $userBranchId = auth()->user()->branch_id;
        $filterBranchId = session('branch_filter_id', auth()->user()->branch_id);

        if ($userBranchId == 1) {
            if ($filterBranchId) {
                $categoryIds = BranchCategory::where('branch_id', $filterBranchId)->pluck('category_id');
                $categories = Category::whereIn('id', $categoryIds)->orderBy('order_num', 'asc')->orderBy('id', 'desc')->paginate(20);
            } else {
                $categories = Category::orderBy('order_num', 'asc')->orderBy('id', 'desc')->paginate(20);
            }
        } else {
            $categoryIds = BranchCategory::where('branch_id', $userBranchId)->pluck('category_id');
            $categories = Category::whereIn('id', $categoryIds)->orderBy('order_num', 'asc')->orderBy('id', 'desc')->paginate(20);
        }
        $categoryIds = BranchCategory::where('branch_id', $userBranchId)->pluck('category_id');

        $branchs = Branch::all();
        return view('backend.pages.category.index',  compact('categories', 'branchs', 'filterBranchId','categoryIds'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'branch_id' => auth()->user()->branch_id == 1 ? 'required|array' : 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:4096',
            'badge' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        $category->badge = $request->badge;
        $category->order_num = $request->order_num ?? 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $fileName);
            $category->image = $fileName;
        }

        DB::transaction(function () use ($request, $category) {
            if ($category->save()) {
                if(auth()->user()->branch_id == 1){
                    if (!empty($request->branch_id)) {
                        foreach ($request->branch_id as $key => $branch_id) {
                            $branch_category = new BranchCategory();
                            $branch_category->category_id = $category->id;
                            $branch_category->branch_id = $branch_id;
                            $branch_category->save();
                        }
                    }
                }else{
                    $branch_category = new BranchCategory();
                    $branch_category->category_id = $category->id;
                    $branch_category->branch_id = auth()->user()->branch_id;
                    $branch_category->save();
                }
            }
        });

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Category created successfully'),
                'category' => $category,
            ]);
        }

        session()->flash('success', __('Category created successfully'));
        return back();
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:4096',
            'badge' => 'nullable|string|max:50',
            'order_num' => 'nullable|integer',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        $category->badge = $request->badge;
        $category->order_num = $request->order_num ?? $category->order_num ?? 0;

        if ($request->hasFile('image')) {
            if (!empty($category->image) && file_exists(public_path('uploads/categories/' . $category->image))) {
                @unlink(public_path('uploads/categories/' . $category->image));
            }
            $file = $request->file('image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $fileName);
            $category->image = $fileName;
        }

        DB::transaction(function () use ($request, $category) {
            if ($category->save()) {
                if($request->branch_id != null){
                    $existingBranchIds = BranchCategory::where('category_id', $category->id)
                        ->pluck('branch_id')
                        ->toArray();
            
                    foreach ($request->branch_id as $branch_id) {
                        if (!in_array($branch_id, $existingBranchIds)) {
                            BranchCategory::create([
                                'category_id' => $category->id,
                                'branch_id' => $branch_id,
                            ]);
                        }
                    }
                    BranchCategory::where('category_id', $category->id)
                        ->whereNotIn('branch_id', $request->branch_id)
                        ->delete();
                }
            }
        });

        session()->flash('success', __('Category updated successfully'));
        return back();
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if (!empty($category->image) && file_exists(public_path('uploads/categories/' . $category->image))) {
            @unlink(public_path('uploads/categories/' . $category->image));
        }
        $category->delete();
        session()->flash('success', __('Category deleted successfully'));
        return back();
    }
}
