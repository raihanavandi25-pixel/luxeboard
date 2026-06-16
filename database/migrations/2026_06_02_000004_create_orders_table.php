<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->string('status')->default('Created'); // Created, Paid, Shipped, Completed, Cancelled
            $table->decimal('total_amount', 10, 2);
            $table->string('shipping_tier'); // Regular, Same Day, Instant Next Day, Instant Priority Next Day
            $table->decimal('shipping_fee', 10, 2)->default(0.00);
            $table->string('payment_method'); // QRIS, Bank Transfer, COD, Debit Card, E-Wallet
            $table->string('payment_status')->default('Pending'); // Pending, Paid, Cancelled
            $table->text('shipping_address');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->timestamp('payment_expires_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
