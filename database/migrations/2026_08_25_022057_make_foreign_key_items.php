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
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable()->after('id'); 
            $table->unsignedBigInteger('category_id')->nullable()->after('brand_id'); 
            $table->integer('minimum_stock')->default(0);

            $table->foreign('brand_id')
                ->references('id')
                ->on('part_brands')
                ->nullOnDelete();

            $table->foreign('category_id')
                ->references('id')
                ->on('part_category')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['category_id']);
            
            $table->dropColumn('brand_id');
            $table->dropColumn('category_id');
            $table->dropColumn('minimum_stock');
        });
    }
};