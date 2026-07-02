<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->string('transaction_type');
            $table->string('recipient_account');
            $table->string('recipient_name');
            $table->string('sender_account');
            $table->string('sender_name');
            $table->integer('model')->nullable();
            $table->string('reference_number')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3);
            $table->string('payment_purpose')->nullable();
            $table->string('payment_code')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->string('status');
            $table->string('card_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
