<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('to_user_id');
            $table->foreign('to_user_id')->references('id')->on('users');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('status')->default(0);
            $table->timestamp('transfer_at');
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
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_user_id_foreign');
            $table->dropForeign('transfers_to_user_id_foreign');
            $table->dropIfExists();
        });
    }
}
