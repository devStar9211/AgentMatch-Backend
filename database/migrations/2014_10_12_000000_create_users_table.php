<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::defaultStringLength(191);
      Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('firstName');
        $table->string('firstNameFuri');
        $table->string('lastName');
        $table->string('lastNameFuri');
        $table->datetime('birthday');
        $table->boolean('gender');
        $table->integer('schoolType');
        $table->string('schoolName');
        $table->integer('literaryType');
        $table->string('faculty');
        $table->string('subject');
        $table->string('gradDate');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
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
