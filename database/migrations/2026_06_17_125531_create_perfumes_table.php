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
        Schema::create('perfumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('slug')->unique();
            $table->enum('gender', ['male', 'female', 'unisex']);
            $table->enum('concentration', ['EDC', 'EDT', 'EDP', 'Parfum', 'Extrait']);
            $table->integer('size_ml');
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'pre_order'])->default('in_stock');
            $table->boolean('pre_order')->default(false);
            $table->integer('delivery_days')->default(3);
            $table->text('short_description_en');
            $table->text('short_description_ar');
            $table->text('long_description_en');
            $table->text('long_description_ar');
            $table->integer('year_launched')->nullable();
            $table->string('perfumer')->nullable();
            $table->enum('longevity', ['very_weak', 'weak', 'moderate', 'long_lasting', 'eternal'])->nullable();
            $table->enum('sillage', ['intimate', 'moderate', 'strong', 'enormous'])->nullable();
            $table->json('season')->nullable(); // e.g. ['spring', 'summer']
            $table->json('occasion')->nullable(); // e.g. ['day', 'night']
            $table->string('source_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfumes');
    }
};
