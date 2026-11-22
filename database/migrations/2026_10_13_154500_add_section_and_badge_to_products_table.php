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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'section')) {
                $table->string('section', 50)->nullable()->after('status')->index();
            }
            if (!Schema::hasColumn('products', 'badge')) {
                $table->string('badge', 100)->nullable()->after('section');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'section')) {
                $table->dropColumn('section');
            }
            if (Schema::hasColumn('products', 'badge')) {
                $table->dropColumn('badge');
            }
        });
    }
};
