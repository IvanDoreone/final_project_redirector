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
            $table->dropColumn('offer_uri');
            $table->dropColumn('donor_uri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transitions', function (Blueprint $table) {
            $table->string('offer_uri')->default(null);
            $table->string('donor_uri')->default(null);
        });
    }
};
