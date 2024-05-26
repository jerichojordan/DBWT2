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
        Schema::create('ab_article_has_articlecategory',function (Blueprint $table){
            $table->id();
            $table->foreignId('ab_articlecategory_id')->nullable(false)->references('id')->on('ab_articlecategory');
            $table->foreignId('ab_article_id')->nullable(false)->references('id')->on('ab_article');
            $table->unique(['ab_article_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
};
