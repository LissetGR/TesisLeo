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
        Schema::create('reals', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->double('precio');
            $table->foreignId('productos_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('anno');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reals');
    }
};
