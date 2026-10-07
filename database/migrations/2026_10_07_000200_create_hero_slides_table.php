<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('primary_label')->nullable();
            $table->string('primary_url')->nullable();
            $table->string('secondary_label')->nullable();
            $table->string('secondary_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Primera diapositiva con el contenido que ya tenía el encabezado de Inicio
        // (y la imagen que se haya subido en "Imágenes del sitio", si existe).
        $image = Schema::hasTable('site_images')
            ? DB::table('site_images')->where('key', 'home.hero')->value('path')
            : null;

        DB::table('hero_slides')->insert([
            'image' => $image ?: 'images/home/hero.jpg',
            'title' => "Donde la confianza se\nconvierte en construcción.",
            'text' => 'Maquinaria de construcción nueva, de las marcas líderes del mundo, respaldada por una empresa familiar mexicana que te acompaña más allá de la venta.',
            'primary_label' => 'Ver catálogo',
            'primary_url' => '/productos',
            'secondary_label' => 'Contáctanos',
            'secondary_url' => '/contacto',
            'is_active' => true,
            'sort_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
