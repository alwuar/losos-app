<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('label')->nullable();         // "Categoría", "Industrial"
            $table->string('card_title')->nullable();    // título en la tarjeta de Inicio
            $table->string('summary')->nullable();       // "Excavadoras · Cargadores · …"
            $table->string('excerpt', 500)->nullable();  // texto de la tarjeta de Inicio
            $table->text('description')->nullable();     // texto de "Beneficios"
            $table->string('image')->nullable();
            $table->json('benefits')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category_id', 'slug']);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_type_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand')->nullable();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->json('card_specs')->nullable();   // 4 datos de la tarjeta
            $table->json('highlights')->nullable();   // datos destacados del detalle
            $table->json('features')->nullable();     // ventajas
            $table->json('spec_groups')->nullable();  // ficha técnica
            $table->string('brochure')->nullable();   // PDF
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('site_images', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // home.hero, about.history, services.renta…
            $table->string('label');
            $table->string('help')->nullable();
            $table->string('path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_images');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_types');
        Schema::dropIfExists('categories');
    }
};
