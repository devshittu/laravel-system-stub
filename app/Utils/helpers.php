<?php
/**
 * Created by PhpStorm.
 * User: devshittu
 * Date: 10/18/19
 * Time: 9:24 PM
 */
if (! function_exists('auto_increment')) {
    function auto_increment(){
        for ($i = 0; $i < 1000; $i++) {
            yield $i;
        }
    }
}

if (! function_exists('get_reg_code_prefix')) {

    function get_reg_code_prefix($userType) {
        $prefix = '';
        switch ($userType) {
            case \App\Utils\Constants::DBCV_USER_TYPE_ADMIN:
                $prefix = 'ADM';
                break;
            case \App\Utils\Constants::DBCV_USER_TYPE_CANDIDATE:
                $prefix = 'CND';
                break;
            case \App\Utils\Constants::DBCV_USER_TYPE_STAFF:
                $prefix = 'STF';
                break;
            case \App\Utils\Constants::DBCV_USER_TYPE_STUDENT:
                $prefix = 'STD';
                break;

        }
        return $prefix . '_';
    }

}
if (! function_exists('get_reg_code_code')) {

    function get_reg_code_code($userRegCode) {
        $code = '';
        $rc = explode('_', $userRegCode);
        return $rc[1];

    }

}

if (! function_exists('random_chars')) {

    function random_chars($length = 10, $randomLowerCase = FALSE, $randomUpperCase = FALSE, $includeDigits = FALSE)
    {
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';
        //$special = '~@$^*(){}[]|=';
        $chars = ($randomLowerCase ? $lower : '').($randomUpperCase ? $upper : '').($includeDigits ? $digits : '');
        $str = '';
        $last_index = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++)
        {
            mt_srand(hexdec(uniqid()));
            $str .= $chars[mt_rand(0, $last_index)];
        }

        return $str;

    }
}
if (! function_exists('score_grade')) {

    function score_grade($score = null)
    {
        $grade = null;
        if ($score < 45)
        {
            $grade = 'F';
        }
        elseif ($score<= 49 && $score >=45)
        {
            $grade = 'D';
        }
        elseif ($score <= 59 && $score >=50)
        {
            $grade = 'C';
        }
        elseif ($score <= 69 && $score >=60)
        {
            $grade = 'B';
        }
        else if ($score >= 70)
        {
            $grade = 'A';
        }
        return $grade;

    }
}