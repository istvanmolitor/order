<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_shipping_id')->nullable()->after('order_payment_id');
            $table->foreign('order_shipping_id')->references('id')->on('order_shippings');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['order_shipping_id']);
            $table->dropColumn('order_shipping_id');
        });
    }
};
