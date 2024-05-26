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
        Schema::create('ab_shoppingcart', function (Blueprint $table){
            $table->id();
            $table->foreignId('ab_creator_id')->nullable(false)->references('id')->on('ab_user');
            $table->timestamp("ab_createdate")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("ab_shoppingcart");
    }
};
