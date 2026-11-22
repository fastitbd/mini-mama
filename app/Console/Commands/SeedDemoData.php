<?php

namespace App\Console\Commands;

use Database\Seeders\DemoDataSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Banner;
use App\Models\StoreSection;

class SeedDemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-demo {--force : Force run in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed all demo products, categories, subcategories, banners, and store sections';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('====================================================');
        $this->info('   FAST IT / SYSTEM ECOMMERCE - DEMO DATA INSTALLER  ');
        $this->info('====================================================');
        $this->newLine();

        $this->info('1/4 Seeding Store Sections, Categories, Banners & Products...');
        $seeder = new DemoDataSeeder();
        $seeder->setCommand($this);
        $seeder->run();

        $this->newLine();
        $this->info('2/4 Clearing view and application cache...');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        $this->info('Cache cleared successfully.');

        $this->newLine();
        $this->info('3/4 Summary of Installed Data:');
        $this->table(
            ['Data Type', 'Total Count in DB'],
            [
                ['Categories', Category::count()],
                ['Subcategories', SubCategory::count()],
                ['Store Sections', StoreSection::count()],
                ['Hero / Promo Banners', Banner::count()],
                ['Demo Products', Product::count()],
            ]
        );

        $this->newLine();
        $this->info('====================================================');
        $this->info('   SUCCESS: Demo data installed and ready to use!   ');
        $this->info('====================================================');

        return Command::SUCCESS;
    }
}
