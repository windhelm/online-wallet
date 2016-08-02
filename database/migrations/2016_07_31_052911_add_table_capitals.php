<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableCapitals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitals', function (Blueprint $table) {
            $table->uuid('id');
            $table->enum('currency', ['RUB', 'USD', 'EUR', 'KGS']);
            $table->float('amount');
            $table->uuid('wallet_id');

            $table->foreign('wallet_id')
                ->references('id')->on('wallets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('capitals');
    }
}
