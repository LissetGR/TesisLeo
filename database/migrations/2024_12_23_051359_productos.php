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
        Schema::create('productos' ,function(Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('u_medida');
            $table->string('photo')->default("images/UolWXxHtQ2SZy5ihlkvBZTI5s0XtBNLkdHoJMHvw.jpg");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
