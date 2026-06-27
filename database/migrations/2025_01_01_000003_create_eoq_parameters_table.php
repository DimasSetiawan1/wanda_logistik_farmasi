<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eoq_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->decimal('rata_rata_permintaan', 15, 2)->comment('D - rata-rata permintaan per periode');
            $table->decimal('biaya_pesan', 15, 2)->comment('S - ordering cost');
            $table->decimal('biaya_simpan', 15, 2)->comment('H - holding cost');
            $table->decimal('faktor_biaya_simpan', 5, 4)->default(0.1)->comment('I - carrying cost factor');
            $table->integer('lead_time')->comment('LT dalam hari');
            $table->decimal('service_level_z', 5, 2)->default(1.65)->comment('Z - faktor safety 95%');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eoq_parameters');
    }
};
