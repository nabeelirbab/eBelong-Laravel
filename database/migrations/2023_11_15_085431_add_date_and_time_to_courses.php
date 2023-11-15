<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateAndTimeToCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cources', function (Blueprint $table) {
            $table->date('course_date')->nullable();
            $table->time('course_time')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cources', function (Blueprint $table) {
            $table->dropColumn('course_date');
            $table->dropColumn('course_time');
        });
    }
}
