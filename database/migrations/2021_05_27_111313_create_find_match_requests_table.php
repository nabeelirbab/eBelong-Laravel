<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFindMatchRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('find_match_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('phone_number');
            $table->string('full_name');
            $table->string('positions');
            $table->string('collaborative');
            $table->string('agile_approach');
            $table->string('creative');
            $table->string('follower');
            $table->string('initiator');
            $table->string('instructions_follower');
            $table->string('product_focus');
            $table->string('project_focused');
            $table->string('silent_shy');
            $table->string('structed_methodical');
            $table->string('vocal_blunt');
            $table->string('waterfall_approach');
            $table->string('selected_categories');
            $table->string('selected_skills');
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
        Schema::dropIfExists('find_match_requests');
    }
}
