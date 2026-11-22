<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('categories', 'badge')) {
                $table->string('badge')->nullable()->after('image');
            }
            if (!Schema::hasColumn('categories', 'order_num')) {
                $table->integer('order_num')->default(0)->after('badge');
            }
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('sub_categories', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('sub_categories', 'image')) {
                $table->string('image')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('sub_categories', 'order_num')) {
                $table->integer('order_num')->default(0)->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $cols = ['slug', 'image', 'badge', 'order_num'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('categories', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $cols = ['slug', 'image', 'order_num'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('sub_categories', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
