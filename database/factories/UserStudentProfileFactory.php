<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Utils\Constants;
use Faker\Generator as Faker;
use Illuminate\Support\Str;



$autoIncrement = auto_increment();

$factory->define(\App\UserStudentProfile::class, function (Faker $faker)  use ($autoIncrement)  {


    $autoIncrement->next();
    $type = Constants::DBCV_USER_TYPE_STUDENT;

    $allowedGenderTypes = Constants::AV_GENDER_TYPE;
    $avGenderAtRand = array_rand($allowedGenderTypes);
    $selectedUserType = $type;
    $selectedGenderType = $allowedGenderTypes[$avGenderAtRand];
    $regCodePrefix = get_reg_code_prefix($selectedUserType);
    $currentSessionId = \App\SystemSetting::find(1)->academic_session_id;

    return [
        Constants::DBC_USER_ID => factory('App\User')->create([
            'first_name' => $faker->firstName($selectedGenderType),
            'type' => $selectedUserType,
            'gender' => $selectedGenderType,
            'email' => 'student'.$autoIncrement->current().'@test.com',
            'reg_code' => $regCodePrefix . strtoupper(Str::random(5)),
        ])->id,
//        Constants::DBC_ENROLL_CLASS_ID => 1,
        Constants::DBC_ENROLL_SESS_ID => $currentSessionId,
    ];
});

