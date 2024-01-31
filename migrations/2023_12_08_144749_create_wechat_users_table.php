<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateWechatUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wechat_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wechat_id', 255)->unique()->nullable()->comment('微信id');
            $table->string('instance_id', 255)->nullable()->comment('实例id');
            $table->string('nick_name')->nullable()->comment('昵称');
            $table->string('device_ype')->nullable()->comment('扫码的设备类型');
            $table->string('head_url')->nullable()->comment('头像url');
            $table->integer('sex')->nullable()->comment('性别{1:男,2:女}');
            $table->string('phone')->nullable()->comment('手机');
            $table->string('status')->comment('状态');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wechat_users');
    }
}
