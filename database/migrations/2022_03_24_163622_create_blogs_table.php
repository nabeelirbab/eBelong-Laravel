<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function(Blueprint $table)
    {
        $table->increments('id');
        $table->string('title');
        $table->string('slug');
        $table->string('content');
        $table->integer('editor_id')->nullable();
        $table->string('email')->nullable();
        $table->text('attachments')->nullable();
        $table->integer('views')->default(0);
        $table->enum(
            'status',
            ['published', 'draft']
        )->default('published');
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
        Schema::dropIfExists('blogs');
    }
}