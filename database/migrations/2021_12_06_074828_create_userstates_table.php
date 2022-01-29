<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userstates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('questionNetwork_count')->default(0);
            $table->integer('questionSoftware_count')->default(0);
            $table->integer('questionHardware_count')->default(0);
            $table->integer('responseNetwork_count')->default(0);
            $table->integer('responseSoftware_count')->default(0);
            $table->integer('responseHardware_count')->default(0);
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
        Schema::dropIfExists('userstates');
    }
}
