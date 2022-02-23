<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReviewsTab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE `reviews` CHANGE `project_type` `project_type` ENUM('job','service','cource') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'job';");
   
        // \DB::statement("ALTER TABLE `reviews` CHANGE `rating` `rating` NULL");
        // \DB::statement("ALTER TABLE `reviews` CHANGE `project_type` `project_type` NULL");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
        });
    }
}
