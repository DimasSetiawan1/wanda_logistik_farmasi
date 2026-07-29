<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('medicines', 'tanggal_kadaluarsa')) {
            Schema::table('medicines', function (Blueprint $table) {
                $table->date('tanggal_kadaluarsa')->nullable()->after('stok_aktual');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('medicines', 'tanggal_kadaluarsa')) {
            Schema::table('medicines', function (Blueprint $table) {
                $table->dropColumn('tanggal_kadaluarsa');
            });
        }
    }
};
