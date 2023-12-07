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
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name')->nullable()->default(null);
            $table->string('uri')->nullable()->default(null);
            $table->string('theme')->nullable()->default(null);
            $table->integer('coast')->default(1)->unsigned();
            $table->integer('subscribs_amount')->default(0)->unsigned();
            $table->string('status')->nullable()->default('approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
