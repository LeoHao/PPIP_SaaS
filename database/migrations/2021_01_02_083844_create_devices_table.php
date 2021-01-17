<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('label')->comment('设备名称');
            $table->string('group')->nullable()->comment('设备组');
            $table->string('mac')->unique();
            $table->string('sn')->unique()->comment('设备唯一sn码');
            $table->bigInteger('group_id')->comment('用户组');
            $table->bigInteger('dedicated_id')->comment('专线')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('devices');
    }
}
