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
        Schema::table('profiles', function (Blueprint $table) {
        // Si existe FK previa, primero habría que dropearla.
        // Si no sabes el nombre, lo normal es: profiles_usuario_id_foreign
        $table->dropForeign(['usuario_id']);
    });

    Schema::table('profiles', function (Blueprint $table) {
        // Renombrar columna
        $table->renameColumn('usuario_id', 'user_id');
    });

    Schema::table('profiles', function (Blueprint $table) {
        // Añadir FK y unique para 1:1 real
        $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        $table->unique('user_id');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
};
