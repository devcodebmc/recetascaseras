<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('ingredients'); // Se guardan en formato JSON
            $table->json('steps'); // Pasos de preparación en JSON
            $table->integer('prep_time'); // Minutos de preparación
            $table->integer('cook_time'); // Minutos de cocción
            $table->integer('servings')->default(1); // Número de porciones
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Categoría de la receta
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que la creó
            $table->string('image')->nullable(); // Imagen principal
            $table->string('video_url')->nullable(); // URL del video (opcional)
            $table->enum('status', ['draft', 'published'])->default('draft'); // Estado de la receta
            $table->timestamps();
            $table->softDeletes(); // Soft deletes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
