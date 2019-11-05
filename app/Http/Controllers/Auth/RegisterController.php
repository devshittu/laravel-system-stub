<?php

namespace App\Http\Controllers\Auth;

use App\AcademicClass;
use App\Http\Controllers\Controller;
use App\User;
use App\UserAdminProfile;
use App\UserCandidateProfile;
use App\UserStaffProfile;
use App\UserStudentProfile;
use App\Utils\Constants;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'gender' => ['required', 'string'],
            'type' => ['required', 'string'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /*
         * register user to database using Object Relational Model
         * */
        $userType = $data['type'];
        $make_reg_code = get_reg_code_prefix($userType) . strtoupper(Str::random(5));
        $currentSessionId = \App\SystemSetting::find(1)->academic_session_id;

//        dump($data);

        DB::beginTransaction();

        $insertUser = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['gender'],
            'type' => $userType,
            'reg_code' => $make_reg_code,
            'date_of_birth' => $data['dob'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $newUserId = $insertUser->id;

        if(!$insertUser) DB::rollBack();

        if ($userType == Constants::DBCV_USER_TYPE_CANDIDATE) {

            $createUserProfile = UserCandidateProfile::create([
                'user_id' => $newUserId,
                Constants::DBC_ACAD_CLASS_ID => $data[Constants::DBC_ACAD_CLASS_ID],
                Constants::DBC_ACAD_SESS_ID => $currentSessionId,
            ]);

        }

        elseif ($userType == Constants::DBCV_USER_TYPE_STUDENT) {

            $createUserProfile = UserStudentProfile::create([
                'user_id' => $newUserId,
//                Constants::DBC_CLASS_ID => 1,
//                Constants::DBC_ACAD_SESS_ID => $currentSessionId,
            ]);

        }


        elseif ($userType == Constants::DBCV_USER_TYPE_STAFF) {
            $createUserProfile = true;
            $createUserProfile = UserStaffProfile::create([
                'user_id' => $newUserId,
            ]);

        }

        elseif ($userType == Constants::DBCV_USER_TYPE_ADMIN) {

            $createUserProfile = UserAdminProfile::create([
                'user_id' => $newUserId,
//                Constants::DBC_CLASS_ID => 1,
//                Constants::DBC_ACAD_SESS_ID => $currentSessionId,
            ]);

        }


        if(!$createUserProfile) DB::rollBack();


        DB::commit();

        return  $insertUser;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {

        $data = [
//            'academic_classes' => AcademicClass::where(Constants::DBC_CAN_APPLY, true)->get(),
            'academic_classes' => [],
        ];
        return view('auth.register', $data);
    }


}
