<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogoToAgencyUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agency_user', function (Blueprint $table) {
            $table->text('description')->nullable()->after('contact_email');
            $table->string('slug')->nullable()->after('description');
            $table->string('agency_logo')->nullable()->after('description');
            $table->string('founded_in')->nullable()->after('agency_logo');
            $table->smallInteger('is_verified')->default(0)->after('founded_in');
            $table->decimal('hourly_rates_min')->nullable()->after('founded_in');
            $table->decimal('hourly_rates_max')->nullable()->after('hourly_rates_min');
            $table->string('agency_size')->nullable()->after('hourly_rates_max');
            $table->decimal('total_earnings')->default(0)->after('agency_size');
            $table->string('total_hours')->default(0)->after('total_earnings');
            $table->string('total_jobs')->default(0)->after('total_hours');
            $table->string('last_work_date')->nullable()->after('total_jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agency_user', function (Blueprint $table) {
            //
        });
    }
}
