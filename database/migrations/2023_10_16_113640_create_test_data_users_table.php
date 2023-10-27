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
        Schema::create('test_data_users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('');
            $table->string('email')->unique()->nullable()->comment('');
            $table->timestamp('email_verified_at')->nullable()->nullable()->comment('');
            $table->string('password')->nullable()->comment('');
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
        Schema::dropIfExists('test_data_users');
    }
};
