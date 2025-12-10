<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_payment_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_payment_id');
            $table->foreign('order_payment_id')->references('id')->on('order_payments');

            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages');

            $table->string('name');
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payment_translations');
    }
};
