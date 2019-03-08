<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contact_owner_id');
            $table->string('home_address');
            $table->timestamps();

            $table->foreign('contact_owner_id')->references('id')->on('contact_owners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_addresses');
    }
}
