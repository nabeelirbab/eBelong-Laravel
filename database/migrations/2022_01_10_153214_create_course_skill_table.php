<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('cource_skill', function (Blueprint $table){
            
                $table->increments('id');
                $table->integer('cource_id');
                $table->integer('skill_id');
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
        Schema::table('cource_skill', function (Blueprint $table) {
            //
        });
    }
}
