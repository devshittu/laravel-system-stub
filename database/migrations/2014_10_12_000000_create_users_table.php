<?php

use App\Utils\Constants;
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
            $table->increments('id');
//            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('reg_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('type', Constants::AV_USER_TYPE)->default(Constants::DBCV_USER_TYPE_CANDIDATE);
            $table->enum('gender', ['female', 'male'])->default(null)->nullable(true);
            $table->string(Constants::DBC_AVATAR)->index()->nullable();
            $table->date(Constants::DBC_USER_DOB)->nullable()->default(null);
            $table->rememberToken();
            $table->softDeletes();
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
