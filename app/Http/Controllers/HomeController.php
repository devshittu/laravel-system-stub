<?php

namespace App\Http\Controllers;

use App\AcademicClass;
use App\AcademicSession;
use App\AcademicSubject;
use App\AcademicTerm;
use App\ClassStaff;
use App\ClassSubject;
use App\ClassTerm;
use App\StudentTerminalLog;
use App\StudentTerminalLogSubject;
use App\User;
use App\UserAdminProfile;
use App\UserCandidateProfile;
use App\UserStaffProfile;
use App\UserStudentProfile;
use App\Utils\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //for authentication
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $student = User::all();

        $data = [];

        if (Auth::user()->type === 'admin') {
            $profile = UserAdminProfile::where('user_id', Auth::id())->first();
            $data['profile'] = $profile;
            $data['users'] = $student;
            $data['user'] = $user;
            $data['staffs'] = UserStaffProfile::all();
//            $data['academic_classes'] = AcademicClass::all();
            $data['academic_sessions'] = AcademicSession::all();
//            $data['academic_terms'] = AcademicTerm::all();
        }
        elseif (Auth::user()->type === 'candidate') {
            $profile = UserCandidateProfile::where('user_id', Auth::id())->first();
            $data['profile'] = $profile;
        }

        elseif (Auth::user()->type === Constants::DBCV_USER_TYPE_STUDENT) {
            $profile = UserStudentProfile::where('user_id', Auth::id())->first();
            $data['profile'] = $profile;

            $studentTerminalLog = StudentTerminalLog::where(Constants::RQ_USER_ID, Auth::id())->latest('id')->first();
            $data['subjects'] = $studentTerminalLog->student_terminal_log_subjects;

        }

        elseif (Auth::user()->type === Constants::DBCV_USER_TYPE_STAFF) {
            $profile = UserStaffProfile::where('user_id', Auth::id())->first();
            $data['profile'] = $profile;

            $data['classes'] = ClassStaff::where('user_id', Auth::id())->get();//->pluck(Constants::DBC_ACAD_CLASS_ID);


//            foreach ($data['classes'] as $class) {
//                dump($class, $class->academic_class->title);
//            }

//            dd($data['classes']);

        }


        $path = '/dashboard_' . Auth::user()->type . '.home';
        return view($path, $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showClass(Request $request)
    {
        $academicClassId = isset($request->query()[Constants::DBC_ACAD_CLASS_ID ]) ? $request->query()[Constants::DBC_ACAD_CLASS_ID ] : null;
        $academicSessionId = isset($request->query()[Constants::DBC_ACAD_SESS_ID ]) ? $request->query()[Constants::DBC_ACAD_SESS_ID ] : null;

        $getClassById = AcademicClass::whereId($academicClassId)->first();


//        dd($getClassById, $getClassById->user_student_profiles);
//        $studentTerminalLog = StudentTerminalLog::where(Constants::DBC_ACAD_SESS_ID, $academicSessionId)->first();
//        $classTerm = ClassTerm::where(Constants::DBC_ACAD_CLASS_ID, $academicClassId)->get();
//        dd($classTerm->student_terminal_log);
//        get class of staff from ClassStaff and then

        $data['class'] = $getClassById;
        $data['class_students'] = $getClassById->user_student_profiles;


        $path = '/dashboard_' . Auth::user()->type . '.class_student';
        return view($path, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showStudentResult(Request $request, $student_id)
    {

/*
        $allStudentTerminalLogIds = \App\StudentTerminalLog::all()->pluck(Constants::DBC_REF_ID);

        for ($i = 0; $i < count($allStudentTerminalLogIds); $i++) {
            $allStudentTerminalLogs = \App\StudentTerminalLog::whereId($allStudentTerminalLogIds[$i])->first();
//            dd($allStudentTerminalLogIds);
            $allClassSubjectIds = ClassSubject::where(Constants::DBC_ACAD_CLASS_ID, $allStudentTerminalLogs->class_term->academic_class_id)
                ->get()
                ->pluck(Constants::DBC_ACAD_SUBJECT_ID);
            for ($j = 0; $j < count($allClassSubjectIds); $j++) {
                echo '$allStudentTerminalLogId: ' . $allStudentTerminalLogIds[$i] . ' $allClassSubjectId: ' . $allClassSubjectIds[$j] . ' <br>';
            }
        }*/

        $studentTerminalLog = StudentTerminalLog::where(Constants::RQ_USER_ID, $student_id)->latest('id')->first();
//        dd($studentTerminalLog->student_terminal_log_subjects);
        $data['subjects'] = $studentTerminalLog->student_terminal_log_subjects;
        $data['result_owner'] = User::whereId($student_id)->whereType(Constants::DBCV_USER_TYPE_STUDENT)->first();


        $path = '/dashboard_' . Auth::user()->type . '.result';
        return view($path, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateStudentResultStaff(Request $request, $student_id, $stl_subject_id)
    {
//        dd($student_id, $stl_subject_id, $request);
//        $download = isset($request->query()['download']) ? $request->query()['download'] : null;

//        $studentTerminalLog = StudentTerminalLog::whereId($stl_subject_id)->first();

        $studentTerminalLog = StudentTerminalLog::where(Constants::RQ_USER_ID, $student_id)->latest('id')->first();
        $studentTerminalLogSubject = StudentTerminalLogSubject::where('student_terminal_log_id', $studentTerminalLog->id)
            ->where(Constants::DBC_ACAD_SUBJECT_ID, $stl_subject_id)->first();
        $studentTerminalLogSubject->ca_test_score = $request->ca_test_score;
        $studentTerminalLogSubject->ca_exam_score = $request->ca_exam_score;
        $studentTerminalLogSubject->save();

        return redirect()->back()->with('success_message', 'Result updated!');
        /*
//        dd($studentTerminalLog->student_terminal_log_subjects);
        $data['subjects'] = $studentTerminalLog->student_terminal_log_subjects;
        $data['result_owner'] = User::whereId($student_id)->whereType(Constants::DBCV_USER_TYPE_STUDENT)->first();


        $path = '/dashboard_' . Auth::user()->type . '.result';
        return view($path, $data);*/
    }
}
