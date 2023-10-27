<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pg_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_code')->comment('รหัสพนักงาน');
            $table->string('user_name')->comment('ชื่อพนักงาน');
            $table->string('nickname')->comment('ชื่อเล่นพนักงาน');
            $table->string('e_mail')->unique()->comment('อีเมล');
            $table->string('phone')->comment('เบอร์โทร');
            $table->string('position')->comment('ตำแหน่ง');
            $table->string('team')->comment('ชื่อทีม');
            $table->string('e_mail_team')->nullable()->comment('อีเมลทีม');
            $table->string('e_mail_group')->nullable()->comment('อีเมลกลุ่ม');
            $table->string('gmail')->unique()->comment('จีเมล');
            $table->string('anydesk')->nullable()->comment('รหัสแอนนี่เดส');
            $table->tinyInteger('status')->default('1')->nullable()->comment('0=ไม่ใช้งาน 1=ใช้งาน ');
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
            Schema::dropIfExists('pg_users');
    }
};
