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
        Schema::table('offers', function (Blueprint $table) {
            $table->string('site_name')->nullable()->default(null);
            $table->string('site_uri')->nullable()->default(null);
            $table->text('link_text')->nullable()->default(null);
            $table->string('site_theme')->nullable()->default('обучение');
            $table->integer('coast')->default(1)->unsigned();
            $table->bigInteger('user_id')->unsigned()->after('id');
            $table->integer('subscribs_amount')->default(0)->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('site_name');
            $table->dropColumn('site_uri');
            $table->dropColumn('link_text');
            $table->dropColumn('site_theme');
            $table->dropColumn('coast');
            $table->dropColumn('user_id');
            $table->dropColumn('subscribs_amount');
          });
    }
};
