<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => '10.10 MEGA SALE',
                'subtitle' => 'UP TO 85% OFF EVERYTHING',
                'image' => 'shein_1010_mega_sale.jpg',
                'bg_color' => '#111111',
                'btn_text' => 'SHOP NOW',
                'btn_url' => '/c/sale',
                'banner_type' => 'image',
                'order_num' => 1,
                'status' => true,
            ],
            [
                'title' => '#SummerOutfit',
                'subtitle' => 'TRENDING SUMMER COLLECTION',
                'image' => '//img.ltwebstatic.com/v4/p/ccc/2025/07/22/ca/1753167507387a524d78a380f1105ff2cdcba09dcb_thumbnail_432x.webp',
                'bg_color' => 'linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)',
                'btn_text' => 'SHOP NOW',
                'btn_url' => '/c/dresses',
                'banner_type' => 'trend',
                'order_num' => 2,
                'status' => true,
            ],
            [
                'title' => 'BIG AUTUMN SALE',
                'subtitle' => 'UP TO 80% OFF',
                'image' => 'shein_autumn_sale_banner.jpg',
                'bg_color' => '#f5ede6',
                'btn_text' => 'SHOP NOW',
                'btn_url' => '/c/women',
                'banner_type' => 'image',
                'order_num' => 3,
                'status' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                ['title' => $banner['title']],
                $banner
            );
        }
    }
}
