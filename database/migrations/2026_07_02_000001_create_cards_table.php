<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->string('account_id');
            $table->string('card_id')->unique();
            $table->string('card_type');
            $table->string('expire_date');
            $table->string('owner_name');
            $table->string('currency', 3);
            $table->string('cvv');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->cascadeOnDelete();
            $table->index('account_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
