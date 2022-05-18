<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('visiting_card_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('sex');
            $table->date('date_of_birth');
            $table->tinyInteger('role_id');
            $table->string('phone');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('status');
            $table->tinyInteger('is_deleted');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
