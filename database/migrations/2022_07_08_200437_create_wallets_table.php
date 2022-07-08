<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->increments('id');
                $table->enum(
                    'type',
                    ['credit', 'debit']
                );
                $table->integer('job_id');
                $table->integer('employer_id');
                $table->integer('freelancer_id');
                $table->string('description');
                $table->double('amount');
                $table->enum(
                    'wallet_type',
                    ['employer', 'freelancer']
                );
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
        // Schema::dropIfExists('cources');
    }
}
