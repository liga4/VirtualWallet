<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    public function up():void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->unsignedBigInteger('sender_wallet_id');
            $table->foreign('sender_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->unsignedBigInteger('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->unsignedBigInteger('receiver_wallet_id');
            $table->foreign('receiver_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->string('reference');
            $table->integer('amount');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('transfers');
    }
}
