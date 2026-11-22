<?php

namespace Database\Seeders;

use App\Models\StoreSection;
use Illuminate\Database\Seeder;

class StoreSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'key' => 'super_deals',
                'name' => 'Super Deals',
                'subtitle' => 'Home Left Block',
                'icon' => '🔥',
                'badge_text' => 'Flash Sale',
                'color' => '#fa2c19',
                'order_num' => 1,
                'status' => true,
                'is_system' => true,
            ],
            [
                'key' => 'trends',
                'name' => 'Trends',
                'subtitle' => 'Home Right Block',
                'icon' => '✨',
                'badge_text' => '#SummerOutfit',
                'color' => '#9462FF',
                'order_num' => 2,
                'status' => true,
                'is_system' => true,
            ],
            [
                'key' => 'featured',
                'name' => 'Featured',
                'subtitle' => 'Category Tab Feed',
                'icon' => '⭐',
                'badge_text' => 'HOT',
                'color' => '#17a2b8',
                'order_num' => 3,
                'status' => true,
                'is_system' => false,
            ],
        ];

        foreach ($sections as $section) {
            StoreSection::updateOrCreate(
                ['key' => $section['key']],
                $section
            );
        }
    }
}
