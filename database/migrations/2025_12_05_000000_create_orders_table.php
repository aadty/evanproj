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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no')->unique(); // e.g., "0001"
            $table->string('kode')->unique(); // e.g., "pt-0001", "pb-0001", "p-0001"
            $table->enum('kategori', ['plat-tipis', 'plat-tebal', 'pipa']);
            $table->string('nama');
            $table->string('barang');
            $table->string('status')->default('pending'); // pending, complete
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better query performance
            $table->index('kategori');
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
