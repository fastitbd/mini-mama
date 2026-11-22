<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = __DIR__ . '/data/demo_products.json';
        if (!File::exists($jsonPath)) {
            return;
        }

        // 1. Ensure default Unit exists
        $unit = Unit::firstOrCreate(
            ['id' => 1],
            ['name' => 'Pcs', 'status' => 1]
        );

        // 2. Ensure default Supplier exists
        $supplier = Supplier::firstOrCreate(
            ['id' => 1],
            ['name' => 'General Supplier', 'phone' => '01700000000', 'status' => 1]
        );

        // 3. Branches
        $branches = Branch::all();
        if ($branches->isEmpty()) {
            $branches = collect([
                Branch::firstOrCreate(['id' => 1], ['name' => 'Admin Branch', 'phone' => '01234567890', 'address' => 'All Address', 'status' => 1, 'created_by' => 1])
            ]);
        }

        // 4. Category mappings by name
        $womenCategory = Category::where('name', 'Women Clothing')->first();
        $curveCategory = Category::where('name', 'Curve & Plus Size')->first();
        $shoesCategory = Category::where('name', 'Shoes & Footwear')->first();
        $fallbackCategory = Category::first();

        $catMap = [
            3 => $womenCategory?->id ?? $fallbackCategory?->id ?? 1,
            6 => $curveCategory?->id ?? $fallbackCategory?->id ?? 1,
            8 => $shoesCategory?->id ?? $fallbackCategory?->id ?? 1,
        ];

        // 5. Ensure Demo Opening Purchase Header
        $demoPurchase = Purchase::firstOrCreate(
            ['purchase_no' => 'PUR-DEMO-OPENING'],
            [
                'date' => date('Y-m-d'),
                'branch_id' => 1,
                'supplier_id' => $supplier->id,
                'total_amount' => 50000.00,
                'total_paid' => 50000.00,
                'total_due' => 0.00,
                'created_by' => 1,
                'status' => 0,
            ]
        );

        $productsData = json_decode(File::get($jsonPath), true);
        if (!is_array($productsData)) {
            return;
        }

        foreach ($productsData as $item) {
            $catId = $catMap[$item['category_id']] ?? ($fallbackCategory?->id ?? 1);

            $product = Product::updateOrCreate(
                ['barcode' => $item['barcode']],
                [
                    'name' => $item['name'],
                    'date' => $item['date'] ?? date('Y-m-d'),
                    'category_id' => $catId,
                    'sub_category_id' => $item['sub_category_id'] ?? null,
                    'brand_id' => $item['brand_id'] ?? null,
                    'unit_id' => $item['unit_id'] ?? $unit->id,
                    'main_qty' => $item['main_qty'] ?? 150.00,
                    'sub_qty' => $item['sub_qty'] ?? null,
                    'purchase_price' => $item['purchase_price'] ?? 20.00,
                    'dis_selling_price' => $item['dis_selling_price'] ?? 45.00,
                    'discount' => $item['discount'] ?? 0.00,
                    'selling_price' => $item['selling_price'] ?? 35.00,
                    'is_service' => $item['is_service'] ?? '0',
                    'images' => $item['images'] ?? null,
                    'status' => $item['status'] ?? '1',
                    'section' => $item['section'] ?? 'featured',
                    'badge' => $item['badge'] ?? null,
                    'created_by' => $item['created_by'] ?? 1,
                ]
            );

            // Link to branches
            foreach ($branches as $branch) {
                BranchProduct::firstOrCreate([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                ]);
            }

            // Ensure stock in PurchaseItem
            $hasPurchaseItem = PurchaseItem::where('product_id', $product->id)->exists();
            if (!$hasPurchaseItem) {
                $qty = (float)($item['main_qty'] ?? 150.00);
                $rate = (float)($item['purchase_price'] ?? 20.00);
                PurchaseItem::create([
                    'date' => date('Y-m-d'),
                    'branch_id' => 1,
                    'purchase_id' => $demoPurchase->id,
                    'product_id' => $product->id,
                    'rate' => $rate,
                    'main_qty' => $qty,
                    'sub_qty' => 0.00,
                    'subtotal' => $qty * $rate,
                    'stock_qty' => $qty,
                    'actual_main' => $qty,
                    'actual_sub' => 0.00,
                    'actual_total' => 0.00,
                    'is_return' => '0',
                ]);
            }
        }
    }
}
