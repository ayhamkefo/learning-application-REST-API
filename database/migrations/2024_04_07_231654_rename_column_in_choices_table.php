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
        Schema::table('choices', function (Blueprint $table) {
            $table->renameColumn('question_id', 'interview_question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('choices', function (Blueprint $table) {
            $table->renameColumn('interview_question_id', 'question_id');
        });
    }
};
