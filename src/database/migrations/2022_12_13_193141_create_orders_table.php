<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_closed');
            $table->string('code', 20);

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->unsignedBigInteger('order_status_id');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');

            $table->unsignedBigInteger('invoice_address_id');
            $table->foreign('invoice_address_id')->references('id')->on('addresses');

            $table->unsignedBigInteger('shipping_address_id');
            $table->foreign('shipping_address_id')->references('id')->on('addresses');

            $table->string('phone', 64)->nullable();
            $table->string('referer', 255)->nullable();
            $table->string('invoice', 255)->nullable();

            $table->text('comment')->nullable();
            $table->text('internal_comment')->nullable();

            $table->unsignedBigInteger('order_payment_id');
            $table->foreign('order_payment_id')->references('id')->on('order_payments');

            $table->unsignedBigInteger('order_shipping_id');
            $table->foreign('order_shipping_id')->references('id')->on('order_shippings');

            $table->json('shipping_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
