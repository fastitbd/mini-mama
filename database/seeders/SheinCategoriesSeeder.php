<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Branch;
use App\Models\BranchCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SheinCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();

        $data = [
            [
                'name' => 'Just for You',
                'badge' => 'HOT',
                'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz260330232098723513800/4c972a6dc26b4600687733c68b676b62_square_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Men Sweatshirts', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/16/de/177634559252166f7d708bdb97192f6415e77c7a46_thumbnail_240x.png'],
                    ['name' => 'False Eyelashes & Kits', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/e4/17796845646659de028d2b8e578b3b3e88f084df6b_thumbnail_240x.png'],
                    ['name' => 'Men Hoodies', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25042532213621765/7fe7b9ddba437cd13887d28b0a896dc0_square_thumbnail_240x.png'],
                    ['name' => 'Men Beach Sets', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                    ['name' => 'Men Shirt Co-ords', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz251112957086312380/319778cd197cf278d5fd3c3d7104daeb_square_thumbnail_240x.png'],
                    ['name' => 'Men Polo Shirts', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/16/de/177634559252166f7d708bdb97192f6415e77c7a46_thumbnail_240x.png'],
                    ['name' => 'Baju Kebaya', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz260330232098723513800/4c972a6dc26b4600687733c68b676b62_square_thumbnail_240x.png'],
                    ['name' => 'Men Sweatpants', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25042532213621765/7fe7b9ddba437cd13887d28b0a896dc0_square_thumbnail_240x.png'],
                    ['name' => 'Men Pants', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sw2208013981724119/3b7e449064622bb22f81d26afac070a8_square_thumbnail_240x.png'],
                    ['name' => 'Party & Dresses', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz2304180648932784/27afb52dc9c5d1e658eef10275e6222f_square_thumbnail_240x.png'],
                    ['name' => 'Tops & Blouses', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/20/d4/17872350397b0f2aaf00a8cdcd6153f7cf00a9dd42_thumbnail_240x.png'],
                    ['name' => 'Heels & Sandals', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Women Clothing',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz2304180648932784/27afb52dc9c5d1e658eef10275e6222f_square_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Dresses', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz2304180648932784/27afb52dc9c5d1e658eef10275e6222f_square_thumbnail_240x.png'],
                    ['name' => 'Tops & Blouses', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/20/d4/17872350397b0f2aaf00a8cdcd6153f7cf00a9dd42_thumbnail_240x.png'],
                    ['name' => 'Pants & Bottoms', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25042532213621765/7fe7b9ddba437cd13887d28b0a896dc0_square_thumbnail_240x.png'],
                    ['name' => 'Co-ords & Sets', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz251112957086312380/319778cd197cf278d5fd3c3d7104daeb_square_thumbnail_240x.png'],
                    ['name' => 'Denim & Jeans', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sw2208013981724119/3b7e449064622bb22f81d26afac070a8_square_thumbnail_240x.png'],
                    ['name' => 'Swim & Beachwear', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                    ['name' => 'Outerwear & Suits', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/06/15/17/1781526351f510a50f3c401c874f8c2c6684174d96_thumbnail_240x.png'],
                    ['name' => 'Knitwear', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz251117770548441517/df1456bd7e7cc528769b49342d93a022_square_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Men Clothing',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/16/de/177634559252166f7d708bdb97192f6415e77c7a46_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Men Sweatshirts', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/16/de/177634559252166f7d708bdb97192f6415e77c7a46_thumbnail_240x.png'],
                    ['name' => 'Men Hoodies', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25042532213621765/7fe7b9ddba437cd13887d28b0a896dc0_square_thumbnail_240x.png'],
                    ['name' => 'Men Beach Sets', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                    ['name' => 'Men Co-ords', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz251112957086312380/319778cd197cf278d5fd3c3d7104daeb_square_thumbnail_240x.png'],
                    ['name' => 'Men Pants', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sw2208013981724119/3b7e449064622bb22f81d26afac070a8_square_thumbnail_240x.png'],
                    ['name' => 'Jackets & Coats', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/06/15/17/1781526351f510a50f3c401c874f8c2c6684174d96_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Sale 🔥',
                'badge' => 'HOT',
                'image' => 'https://img.ltwebstatic.com/v4/p/ccc/2025/07/22/ca/1753167507387a524d78a380f1105ff2cdcba09dcb_thumbnail_432x.webp',
                'subs' => [
                    ['name' => 'Dresses under RM30', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz2304180648932784/27afb52dc9c5d1e658eef10275e6222f_square_thumbnail_240x.png'],
                    ['name' => 'Tops under RM20', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/20/d4/17872350397b0f2aaf00a8cdcd6153f7cf00a9dd42_thumbnail_240x.png'],
                    ['name' => 'Shoes under RM35', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e_thumbnail_240x.png'],
                    ['name' => 'Men under RM25', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/16/de/177634559252166f7d708bdb97192f6415e77c7a46_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Curve & Plus Size',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25081445475968138/76af6eee33235080040fb6ad85c56d3d_square_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Curve Dresses', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25081445475968138/76af6eee33235080040fb6ad85c56d3d_square_thumbnail_240x.png'],
                    ['name' => 'Curve Tops', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/20/d4/17872350397b0f2aaf00a8cdcd6153f7cf00a9dd42_thumbnail_240x.png'],
                    ['name' => 'Curve Bottoms', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25042532213621765/7fe7b9ddba437cd13887d28b0a896dc0_square_thumbnail_240x.png'],
                    ['name' => 'Curve Swimwear', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Kids & Baby',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/08/05/c1/17858976987d88a71a4713528a97cd7f4336a03a21_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Baby Girl (0-3Y)', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/08/05/c1/17858976987d88a71a4713528a97cd7f4336a03a21_thumbnail_240x.png'],
                    ['name' => 'Baby Boy (0-3Y)', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/08/05/85/17858976516842e537bb505daa1b3175567222f079_thumbnail_240x.png'],
                    ['name' => 'Girls (4-12Y)', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/08/05/c1/17858976987d88a71a4713528a97cd7f4336a03a21_thumbnail_240x.png'],
                    ['name' => 'Boys (4-12Y)', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/08/05/85/17858976516842e537bb505daa1b3175567222f079_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Shoes & Footwear',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Heels & Pumps', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e_thumbnail_240x.png'],
                    ['name' => 'Sandals & Slides', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e_thumbnail_240x.png'],
                    ['name' => 'Sneakers', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e_thumbnail_240x.png'],
                    ['name' => 'Flats & Loafers', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/4b/177641592183a38085080f4b277609fa204a05906e_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Beauty & Health',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/e4/17796845646659de028d2b8e578b3b3e88f084df6b_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'False Eyelashes & Kits', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/e4/17796845646659de028d2b8e578b3b3e88f084df6b_thumbnail_240x.png'],
                    ['name' => 'Makeup & Cosmetics', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/e4/17796845646659de028d2b8e578b3b3e88f084df6b_thumbnail_240x.png'],
                    ['name' => 'Skin Care Tools', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/e4/17796845646659de028d2b8e578b3b3e88f084df6b_thumbnail_240x.png'],
                    ['name' => 'Hair Styling', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/e4/17796845646659de028d2b8e578b3b3e88f084df6b_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Jewelry & Accessories',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/18/6e/1787024681e512d4992a41811a8ebf7be85a9d8236_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Necklaces & Rings', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/18/6e/1787024681e512d4992a41811a8ebf7be85a9d8236_thumbnail_240x.png'],
                    ['name' => 'Hair Accessories', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/18/6e/1787024681e512d4992a41811a8ebf7be85a9d8236_thumbnail_240x.png'],
                    ['name' => 'Phone Cases', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/b6/17796970859bcf7fec1a6b858fd5d362cbd1293c59_thumbnail_240x.png'],
                    ['name' => 'Belts & Scarves', 'image' => 'https://img.ltwebstatic.com/v4/p/aiapiimg/2026/08/18/6e/1787024681e512d4992a41811a8ebf7be85a9d8236_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Bags & Luggage',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/8b/17764147052b6836ac6c87ccff7cd3f77563ce3a06_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Shoulder Bags', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/8b/17764147052b6836ac6c87ccff7cd3f77563ce3a06_thumbnail_240x.png'],
                    ['name' => 'Crossbody Bags', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/8b/17764147052b6836ac6c87ccff7cd3f77563ce3a06_thumbnail_240x.png'],
                    ['name' => 'Backpacks', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/8b/17764147052b6836ac6c87ccff7cd3f77563ce3a06_thumbnail_240x.png'],
                    ['name' => 'Wallets & Clutches', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/8b/17764147052b6836ac6c87ccff7cd3f77563ce3a06_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Home & Living',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/a5/1779713729f38fb9fbebe6c78c47f9d37788348b10_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Home Decor', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/a5/1779713729f38fb9fbebe6c78c47f9d37788348b10_thumbnail_240x.png'],
                    ['name' => 'Bedding & Pillows', 'image' => 'https://img.ltwebstatic.com/v4/p/abccv/2026/04/17/22/1776429728b057a22a834c8f948342563547a4bc14.png'],
                    ['name' => 'Appliances', 'image' => 'https://img.ltwebstatic.com/v4/p/pics1/2026/04/16/d6/177635046572b5d147b128c73519593e9f5a3b09c4.png'],
                    ['name' => 'Storage & Organizers', 'image' => 'https://img.ltwebstatic.com/v4/p/abc/2026/05/25/a5/1779713729f38fb9fbebe6c78c47f9d37788348b10_thumbnail_240x.png'],
                ]
            ],
            [
                'name' => 'Swim & Beachwear',
                'badge' => '',
                'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png',
                'subs' => [
                    ['name' => 'Bikinis & Sets', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                    ['name' => 'One-Piece Swimsuits', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                    ['name' => 'Cover-ups & Kimonos', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                    ['name' => 'Men Beach Shorts', 'image' => 'https://img.ltwebstatic.com/v4/p/dps/sbc-cutout-task/sz25041742594383237/fa67d410cf2434b97a641e5ac5a3357e_square_thumbnail_240x.png'],
                ]
            ],
        ];

        $order = 1;
        foreach ($data as $catData) {
            $cat = Category::firstOrNew(['name' => $catData['name']]);
            $cat->slug = Str::slug($catData['name']);
            $cat->badge = $catData['badge'] ?? null;
            $cat->image = $catData['image'] ?? null;
            $cat->order_num = $order++;
            $cat->save();

            // Link to branches
            foreach ($branches as $branch) {
                BranchCategory::firstOrCreate([
                    'category_id' => $cat->id,
                    'branch_id' => $branch->id,
                ]);
            }

            // Subcategories
            $subOrder = 1;
            foreach ($catData['subs'] as $sub) {
                $subCat = SubCategory::firstOrNew([
                    'category_id' => $cat->id,
                    'name' => $sub['name']
                ]);
                $subCat->slug = Str::slug($sub['name']);
                $subCat->image = $sub['image'] ?? null;
                $subCat->order_num = $subOrder++;
                $subCat->save();
            }
        }
    }
}
