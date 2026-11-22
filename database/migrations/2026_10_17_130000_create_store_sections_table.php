<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('store_sections')) {
            Schema::create('store_sections', function (Blueprint $table) {
                $table->id();
                $table->string('key', 50)->unique();
                $table->string('name', 100);
                $table->string('subtitle', 150)->nullable();
                $table->string('icon', 50)->nullable();
                $table->string('badge_text', 100)->nullable();
                $table->string('color', 30)->nullable();
                $table->integer('order_num')->default(0);
                $table->boolean('status')->default(true);
                $table->boolean('is_system')->default(false);
                $table->timestamps();
            });

            // Seed default 3 sections
            $now = now();
            DB::table('store_sections')->insert([
                [
                    'key' => 'super_deals',
                    'name' => 'Super Deals',
                    'subtitle' => 'Home Left Block',
                    'icon' => '🔥',
                    'badge_text' => 'Flash Sale',
                    'color' => '#FA2C19',
                    'order_num' => 1,
                    'status' => true,
                    'is_system' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
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
                    'created_at' => $now,
                    'updated_at' => $now,
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
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_sections');
    }
};
