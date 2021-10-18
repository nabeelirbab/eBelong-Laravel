<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyAssociatedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_associated_users', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('agency_id');
            $table->smallInteger('user_id');
            $table->smallInteger('is_pending');
            $table->smallInteger('is_accepted');
            $table->string('member_role');
            $table->string('member_type');
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
        Schema::dropIfExists('agency_associated_users');
    }
}
