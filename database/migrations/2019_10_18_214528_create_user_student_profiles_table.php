<?php

use App\Utils\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_student_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger(Constants::DBC_USER_ID)->index();
            $table->unsignedInteger(Constants::DBC_ENROLL_SESS_ID)->index();
//            $table->unsignedInteger(Constants::DBC_ENROLL_CLASS_ID)->index();
//has_transit
            $table->string(Constants::DBC_ADDRESS)->nullable();
            $table->string(Constants::DBC_PARENT_ADDRESS)->nullable();
            $table->boolean(Constants::DBC_HAS_TRANSIT)->index()->default(1);


            $table->foreign(Constants::DBC_USER_ID)
                ->references(Constants::DBC_REF_ID)
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

//            $table->foreign(Constants::DBC_ENROLL_CLASS_ID)
//                ->references(Constants::DBC_REF_ID)
//                ->on('academic_classes')
//                ->onUpdate('restrict')
//                ->onDelete('restrict');

            $table->foreign(Constants::DBC_ENROLL_SESS_ID)
                ->references(Constants::DBC_REF_ID)
                ->on('academic_sessions')
                ->onUpdate('restrict')
                ->onDelete('restrict');
            $table->boolean('has_paid')->default(false);
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
        Schema::dropIfExists('user_student_profiles');
    }
}
