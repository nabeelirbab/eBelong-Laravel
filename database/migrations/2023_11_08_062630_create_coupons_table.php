<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id'); // Primary key with auto-increment
            $table->string('code')->unique();
            $table->string('type')->default('fixed'); // 'fixed' or 'percentage'
            $table->decimal('value', 8, 2); // Discount value
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
