<?php

use App\Utils\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCandidateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_candidate_profiles', function (Blueprint $table) {
            $table->increments('id');
//            $table->dateTime('created_at')->index()->nullable();
            $table->dateTime(Constants::DBC_EXAM_DATETIME)->index()->nullable();
            $table->unsignedInteger(Constants::DBC_USER_ID)->index();
//            $table->unsignedInteger(Constants::DBC_ACAD_CLASS_ID)->index();
            $table->unsignedInteger(Constants::DBC_ACAD_SESS_ID)->index();
            $table->unsignedInteger(Constants::DBC_EXAM_SCORE)->index()->nullable();
            $table->boolean(Constants::DBC_IS_ADMITTED)->index()->default(0);
            $table->softDeletes();
            $table->timestamps();


            $table->foreign(Constants::DBC_USER_ID)
                ->references(Constants::DBC_REF_ID)
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('restrict');

//            $table->foreign(Constants::DBC_ACAD_CLASS_ID)
//                ->references(Constants::DBC_REF_ID)
//                ->on('academic_classes')
//                ->onUpdate('restrict')
//                ->onDelete('restrict');

            $table->foreign(Constants::DBC_ACAD_SESS_ID)
                ->references(Constants::DBC_REF_ID)
                ->on('academic_sessions')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_candidate_profiles');
    }
}
