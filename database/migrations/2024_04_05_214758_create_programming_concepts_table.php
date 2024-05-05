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
        Schema::create('programming_concepts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('topic_name');
            $table->string('title');
            $table->longText('explanation');
            $table->text('sources');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programming_concepts');
    }
};
