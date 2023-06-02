<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyUserTable extends Migration
{
    public function up()
    {
        Schema::create('agency_user', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->string('agency_logo')->nullable();
            $table->string('founded_in')->nullable();
            $table->smallInteger('is_verified')->default(0);
            $table->decimal('hourly_rates_min', 8, 2)->nullable();
            $table->decimal('hourly_rates_max', 8, 2)->nullable();
            $table->string('agency_size')->nullable();
            $table->decimal('total_earnings', 8, 2)->default(0);
            $table->string('total_hours')->default('0');
            $table->string('total_jobs')->default('0');
            $table->string('last_work_date')->nullable();
            // Add any other columns you need

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agency_user');
    }
}

