<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileAndTextToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cources', function (Blueprint $table) {
            // Assuming 'video_url' will store the path of the video file
            $table->string('course_files')->nullable();
            // 'additional_text' can be a text field
            $table->text('additional_text')->nullable();
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
            $table->dropColumn('course_files');
            $table->dropColumn('additional_text');
        });
    }
}
