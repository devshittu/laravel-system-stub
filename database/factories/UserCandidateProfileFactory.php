<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserCandidateProfile;
use App\Utils\Constants;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


$autoIncrement = auto_increment();

$factory->define(UserCandidateProfile::class, function (Faker $faker) use ($autoIncrement) {

    $autoIncrement->next();

    $type = Constants::DBCV_USER_TYPE_CANDIDATE;

    $allowedGenderTypes = \App\Utils\Constants::AV_GENDER_TYPE;
    $avGenderAtRand = array_rand($allowedGenderTypes);
    $selectedUserType = $type;
    $selectedGenderType = $allowedGenderTypes[$avGenderAtRand];
    $regCodePrefix = get_reg_code_prefix($selectedUserType);
    $currentSessionId = \App\SystemSetting::find(1)->academic_session_id;
    return [
        Constants::DBC_USER_ID => factory('App\User')->create([
            'first_name' => $faker->firstName($selectedGenderType),
            'type' => $selectedUserType,
            'email' => 'cand' . $autoIncrement->current() . '@test.com',
            'gender' => $selectedGenderType,
            'reg_code' => $regCodePrefix . strtoupper(Str::random(5)),
        ])->id,
//        Constants::DBC_ACAD_CLASS_ID => 1,
        Constants::DBC_ACAD_SESS_ID => $currentSessionId,
    ];
});
