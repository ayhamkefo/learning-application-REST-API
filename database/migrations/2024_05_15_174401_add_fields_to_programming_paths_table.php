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
        Schema::table('programming_paths', function (Blueprint $table) {
            
            $table->string('roles'); // Adding roles field
            $table->text('challenges'); // Adding challenges field
            $table->text('interests'); // Adding interests field
            $table->text('frameworks')->nullable(); // Adding frameworks field
            $table->text('steps_to_learn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programming_paths');
    }
};
