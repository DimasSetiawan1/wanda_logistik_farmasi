<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eoq_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->foreignId('eoq_parameter_id')->constrained('eoq_parameters')->onDelete('cascade');
            $table->decimal('eoq_value', 15, 2)->comment('EOQ* = sqrt(2DS/H)');
            $table->decimal('frekuensi_pesan', 10, 2)->comment('F = D/EOQ*');
            $table->decimal('total_cost', 15, 2)->comment('TC = biaya total');
            $table->decimal('safety_stock', 15, 2)->comment('SS = Z * d * sqrt(LT)');
            $table->decimal('reorder_point', 15, 2)->comment('ROP = (d * LT) + SS');
            $table->decimal('stok_minimum', 15, 2)->comment('Min = SS + (d * LT)');
            $table->decimal('stok_maksimum', 15, 2)->comment('Max = Min + EOQ*');
            $table->enum('status', ['normal', 'perlu_pesan', 'overstock'])->default('normal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eoq_calculations');
    }
};
