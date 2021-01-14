<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_plugins', function (Blueprint $table) {
            $table->foreignId('group_id')->references('id')->on('groups');
            $table->foreignId('plugin_id')->references('id')->on('plugins');
            $table->integer('permissions');// 二进制记录权限  1 2 4 8 (增删改查)
            $table->primary(['group_id','plugin_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_plugins');
    }
}
