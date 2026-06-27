<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demand_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->string('periode');
            $table->integer('jumlah_permintaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demand_data');
    }
};
