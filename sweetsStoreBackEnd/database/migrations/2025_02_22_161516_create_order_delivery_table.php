<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_delivery', function (Blueprint $table) {
            $table->id();
            $table->string('user_ip')->nullable()->unique();
            $table->integer('user_id')->nullable()->unique();
            $table->string('checkout_num'); 
            $table->decimal('total_price', 8, 2);
            $table->string('name'); 
            $table->string('email'); 
            $table->string('phone');
            $table->string('address'); 
            $table->string('city'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_delivery');
    }
};
