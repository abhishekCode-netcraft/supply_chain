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
        Schema::create('orders_extra_payments', function (Blueprint $table) {
            $table->id();
            
            $table->string('order_id', 50)->index();
            $table->decimal('requested_amount', 10, 2);
            $table->unsignedBigInteger('requested_by');
            $table->decimal('recovered_amount', 10, 2)->nullable();
            $table->timestamp('recovery_date')->nullable();
            $table->unsignedBigInteger('recovered_by')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_removed')->default(0);
            $table->unsignedBigInteger('settlement_id')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_extra_payments');
    }
};
