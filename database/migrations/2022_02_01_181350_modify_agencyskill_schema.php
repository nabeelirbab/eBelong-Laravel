<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAgencyskillSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agency_user_skill', function (Blueprint $table) {
            $table->renameColumn('agency_id', 'agency_user_id');
            $table->renameColumn('skills_id', 'skill_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agency_user_skill', function (Blueprint $table) {
            //
        });
    }
}
