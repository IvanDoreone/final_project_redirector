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
        Schema::table('contact_models', function (Blueprint $table) {
            $table -> dropColumn('likes');
            $table -> dropColumn('comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_models', function (Blueprint $table) {
            //$table->integer('likes')->default(0);
            //$table->string('comments')->default('NULL');
        });
    }
};
