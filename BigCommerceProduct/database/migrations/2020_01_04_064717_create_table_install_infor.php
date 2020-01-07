<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInstallInfor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_install_infor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("context",100);
            $table->string('access_token',100);
            $table->string('scope',1000);
            $table->string('user_id',100);
            $table->string('username',100);
            $table->string('email',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_install_infor');
    }
}
