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
        if (!Schema::hasTable('website_orders')) {
            Schema::create('website_orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_no', 60)->unique();
                $table->string('customer_name', 150);
                $table->string('customer_phone', 50)->index();
                $table->string('customer_email', 100)->nullable();
                $table->text('customer_address')->nullable();
                $table->string('customer_city', 100)->nullable();
                $table->string('customer_state', 100)->nullable();
                $table->string('customer_postcode', 30)->nullable();
                $table->string('customer_country', 100)->default('Bangladesh');
                $table->string('status', 40)->default('processing')->index();
                $table->string('courier_service', 100)->default('Steadfast Courier');
                $table->string('stock_transfer_mode', 100)->default('Without Manage Stock (Direct Transfer)');
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->decimal('shipping_fee', 12, 2)->default(0);
                $table->decimal('discount', 12, 2)->default(0);
                $table->decimal('total_amount', 12, 2)->default(0);
                $table->string('payment_method', 100)->default('Cash On Delivery (COD)');
                $table->text('note')->nullable();
                $table->timestamp('note_updated_at')->nullable();
                $table->string('tags', 150)->nullable();
                $table->string('site', 50)->default('Website');
                $table->unsignedBigInteger('invoice_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('website_order_items')) {
            Schema::create('website_order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('website_order_id')->index();
                $table->unsignedBigInteger('product_id')->nullable()->index();
                $table->unsignedBigInteger('product_variation_id')->nullable();
                $table->string('product_name', 255);
                $table->string('product_code', 100)->nullable();
                $table->string('product_image', 255)->nullable();
                $table->string('size', 50)->nullable();
                $table->string('color', 50)->nullable();
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 12, 2)->default(0);
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->timestamps();

                $table->foreign('website_order_id')->references('id')->on('website_orders')->onDelete('cascade');
            });

            // Seed initial sample website orders matching user screenshot
            $prod = DB::table('products')->first();
            $prodId = $prod ? $prod->id : null;
            $prodName = $prod ? $prod->name : 'Action Camera 4K Ultra HD';
            $prodImage = $prod ? ($prod->images ?: null) : null;
            $prodCode = $prod ? ($prod->barcode ?: '128176') : '128176';

            $now = now();
            $order1Id = DB::table('website_orders')->insertGetId([
                'order_no' => 'CB-' . date('Ymd') . '-29D7',
                'customer_name' => 'মিমো আক্তার মনোয়ারা',
                'customer_phone' => '01910-405112',
                'customer_email' => 'mimo.akhtar@gmail.com',
                'customer_address' => 'Dhaka - রেল কলোনি, শাজাহানপুর, ঢাকা',
                'customer_city' => 'Dhaka',
                'customer_state' => 'Dhaka',
                'customer_postcode' => '1217',
                'customer_country' => 'Bangladesh',
                'status' => 'processing',
                'courier_service' => 'Steadfast Courier',
                'stock_transfer_mode' => 'Without Manage Stock (Direct Transfer)',
                'subtotal' => 8500.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total_amount' => 8500.00,
                'payment_method' => 'Cash On Delivery (COD)',
                'note' => 'Customer requested delivery before weekend.',
                'note_updated_at' => $now->copy()->subHours(4),
                'tags' => 'Urgent',
                'site' => 'Website',
                'created_at' => $now->copy()->subHours(3),
                'updated_at' => $now->copy()->subHours(3),
            ]);

            DB::table('website_order_items')->insert([
                'website_order_id' => $order1Id,
                'product_id' => $prodId,
                'product_name' => $prodName,
                'product_code' => $prodCode,
                'product_image' => $prodImage,
                'size' => 'Default',
                'color' => 'Black',
                'quantity' => 1,
                'unit_price' => 8500.00,
                'subtotal' => 8500.00,
                'created_at' => $now->copy()->subHours(3),
                'updated_at' => $now->copy()->subHours(3),
            ]);

            $order2Id = DB::table('website_orders')->insertGetId([
                'order_no' => 'CB-' . date('Ymd') . '-88B2',
                'customer_name' => 'কামরুজ্জামান',
                'customer_phone' => '01570-262517',
                'customer_email' => 'kamruzzaman@gmail.com',
                'customer_address' => 'House 14, Road 5, Mirpur-10, Dhaka',
                'customer_city' => 'Dhaka',
                'customer_state' => 'Dhaka',
                'customer_postcode' => '1216',
                'customer_country' => 'Bangladesh',
                'status' => 'processing',
                'courier_service' => 'Steadfast Courier',
                'stock_transfer_mode' => 'Without Manage Stock (Direct Transfer)',
                'subtotal' => 2650.00,
                'shipping_fee' => 100.00,
                'discount' => 50.00,
                'total_amount' => 2700.00,
                'payment_method' => 'Cash On Delivery (COD)',
                'note' => 'Call before delivery.',
                'note_updated_at' => $now->copy()->subHours(2),
                'tags' => 'COD',
                'site' => 'Website',
                'created_at' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ]);

            DB::table('website_order_items')->insert([
                'website_order_id' => $order2Id,
                'product_id' => $prodId,
                'product_name' => '4K Sports Ultra HD Action Camera',
                'product_code' => '128177',
                'product_image' => $prodImage,
                'size' => 'Standard',
                'color' => 'Silver',
                'quantity' => 1,
                'unit_price' => 2650.00,
                'subtotal' => 2650.00,
                'created_at' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_order_items');
        Schema::dropIfExists('website_orders');
    }
};
