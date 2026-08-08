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
        Schema::table('perfumes', function (Blueprint $table) {
            $table->foreignId('dupe_id')->nullable()->constrained('perfumes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perfumes', function (Blueprint $table) {
            $table->dropForeign(['dupe_id']);
            $table->dropColumn('dupe_id');
        });
    }
};
