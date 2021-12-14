<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourceUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cource_user', function (Blueprint $table) {
            $table->increments('id');
                $table->integer('cource_id');
                $table->integer('user_id');
                $table->integer('seller_id');
                $table->enum(
                    'type',
                    ['seller', 'employer']
                )->default('seller');
               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cource_user');
    }
}
