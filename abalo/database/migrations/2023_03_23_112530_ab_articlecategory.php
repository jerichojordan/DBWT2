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
        Schema::create('ab_articlecategory',function(Blueprint $table){
            $table->id();
            $table->string('ab_name',100)->nullable(false);
            $table->string('ab_description',1000)->nullable(true);
            $table->foreignId('ab_parent')->nullable(true)->references('id')->on('ab_articlecategory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_articlecategory');
    }
};
