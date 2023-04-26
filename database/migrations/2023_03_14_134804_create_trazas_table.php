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
        Schema::create('trazas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permiso_id');
            $table->text('objeto_creado')->nullable();
            $table->text('objeto_antes_modificar')->nullable();
            $table->text('objeto_modificado')->nullable(); 
            $table->text('objeto_eliminado')->nullable();
            $table->string('descripcion')->nullable();   
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trazas');
    }
};
