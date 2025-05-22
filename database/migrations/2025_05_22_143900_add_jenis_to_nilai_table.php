<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisToNilaiTable extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->enum('jenis', ['harian', 'ujian'])->default('harian')->after('nilai');
        });
    }
    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
}
