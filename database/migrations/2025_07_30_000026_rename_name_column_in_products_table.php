<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_name')->nullable(); // geçici olarak nullable ekliyoruz
        });

        // Veriyi taşı
        DB::statement('UPDATE products SET product_name = name');

        // Eski sütunu kaldır
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        // Yeni sütunu NOT NULL yapmak istersen:
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_name')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        DB::statement('UPDATE products SET name = product_name');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_name');
        });
    }

};
