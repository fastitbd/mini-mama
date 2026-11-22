<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed all demo products, categories, subcategories, banners, and store sections in one run.
     */
    public function run(): void
    {
        $this->command?->info('Seeding Store Sections...');
        $this->call(StoreSectionsTableSeeder::class);

        $this->command?->info('Seeding Shein Categories & Subcategories...');
        $this->call(SheinCategoriesSeeder::class);

        $this->command?->info('Seeding Banners...');
        $this->call(BannersTableSeeder::class);

        $this->command?->info('Seeding Demo Products with Stock & Branch Links...');
        $this->call(ProductsTableSeeder::class);

        $this->command?->info('All Demo Data successfully seeded!');
    }
}
