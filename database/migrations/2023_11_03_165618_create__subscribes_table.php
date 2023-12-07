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
        Schema::create('subscribes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('offer_id')->unsigned();
            $table->bigInteger('donor_id')->unsigned();
            $table->integer('coast')->default(1)->unsigned();
            $table->string('status')->nullable()->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_subscribes');
    }
};
