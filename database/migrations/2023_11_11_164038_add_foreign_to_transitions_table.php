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
        Schema::table('transitions', function (Blueprint $table) {
            $table->foreign('subscribes_id')->references('id')->on('subscribes')->onUpdate('restrict')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transitions', function (Blueprint $table) {
            $table->dropForeign('subscribes_id');
        });
    }
};
