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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
             // Relationship to users
            $table->integer('user_id');
            $table->text('product_id');
            $table->text('quantity');
            $table->string('address');
            $table->string('postcode');
            $table->string('phone');
            

            // Order details
            $table->string('payment_id')->nullable();
            $table->decimal('total_price', 10, 2)->default(0); // total order price
            $table->string('status')->nullable(); // pending, paid, shipped, completed, cancelled


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};