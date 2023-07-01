
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar si la tabla 'articles' existe antes de crearla nuevamente
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('subtitle');
                $table->text('body');
                $table->string('image');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('category_id');
                $table->timestamps();

                // Definir las relaciones
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Verificar si la tabla 'articles' existe antes de eliminarla
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function (Blueprint $table) {
                // Eliminar las relaciones
                $table->dropForeign(['user_id']);
                $table->dropForeign(['category_id']);
            });

            // Eliminar la tabla 'articles'
            Schema::dropIfExists('articles');
        }
    }
}

