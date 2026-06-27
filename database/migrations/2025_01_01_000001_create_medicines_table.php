<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('kode_obat')->unique();
            $table->string('nama_obat');
            $table->string('satuan');
            $table->enum('kategori', ['A', 'B', 'C'])->default('C');
            $table->decimal('harga_per_unit', 15, 2);
            $table->integer('stok_aktual')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
