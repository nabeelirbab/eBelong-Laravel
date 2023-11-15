<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skills', function (Blueprint $table) {
            // Assuming 'category_id' is an integer
            $table->unsignedBigInteger('category_id')->after('slug')->nullable();

            // If you want to add a foreign key constraint, uncomment the following line
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skills', function (Blueprint $table) {
            // If you have added a foreign key constraint, uncomment the following line
            // $table->dropForeign(['category_id']);

            $table->dropColumn('category_id');
        });
    }
}
