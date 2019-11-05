<?php

namespace App\Http\Controllers;

use App\ClassStaff;
use App\ClassSubject;
use App\ClassTerm;
use App\StudentTerminalLog;
use App\StudentTerminalLogSubject;
use App\SystemSetting;
use App\User;
use App\UserCandidateProfile;
use App\UserStaffProfile;
use App\UserStudentProfile;
use App\UserStudentTransitionLog;
use App\Utils\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class UsersController extends Controller
{
//    candidate_score_update


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function candidate_score_update(Request $request, $id)
    {
        $offer = isset($request->query()['offer']) ? $request->query()['offer'] : null;
        $candidateProfile = UserCandidateProfile::where('user_id', $id);

        $messagePlus = '';
        if (!is_null($offer)) {
            // update score for candidate for is the current session from settings
            $candidateProfile
                ->update([
                    'exam_score' => $request->score,
                    Constants::DBC_IS_ADMITTED => $offer
                ]);
            $messagePlus = 'Has been offered admission. Tell them to log in to their account and accept admission. ';
        } else $candidateProfile->update(['exam_score' => $request->score]);

        return redirect('home')->with('success_message', 'Score updated! ' . $messagePlus);
    }

    /**
     * This is where we'll convert the authenticated candidate to full student
     * We do this by simply copying over the candidate details in to student tb
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function candidateAcceptAdmission(Request $request)
    {
        $candidateProfile = UserCandidateProfile::where('user_id', Auth::id())->first();


        DB::beginTransaction();

        $oldFileName = Auth::user()->avatar;
        $newFileName = 'avatar/' . get_reg_code_prefix(Constants::DBCV_USER_TYPE_STUDENT) . substr(Auth::user()->avatar, 11);

        if (!is_null($oldFileName)) {
            $rename = rename(storage_path('app/public/' . $oldFileName), storage_path('app/public/' . $newFileName));
            if (!$rename) DB::rollBack();

        } else $newFileName = null;

        $updateUserId = User::where('id', Auth::id())
            ->update([
                Constants::DBC_USER_TYPE => Constants::DBCV_USER_TYPE_STUDENT,
                Constants::DBC_REF_REG_CODE => get_reg_code_prefix(Constants::DBCV_USER_TYPE_STUDENT) . get_reg_code_code(Auth::user()->reg_code),
                'avatar' => $newFileName,
            ]);

        if (!$updateUserId) DB::rollBack();

        $createStudentProfile = UserStudentProfile::create([
            'user_id' => Auth::id(),
            Constants::DBC_ENROLL_SESS_ID => $candidateProfile->academic_session_id,
            Constants::DBC_ENROLL_CLASS_ID => $candidateProfile->academic_class_id,
        ]);
        if (!$createStudentProfile) DB::rollBack();
        $classTerm = ClassTerm::where('academic_class_id', $candidateProfile->academic_class_id)->first();

        $createStudentTerminalLog = StudentTerminalLog::create([
            'user_id' => Auth::id(),
            Constants::DBC_ACAD_SESS_ID => $candidateProfile->academic_session_id,
            Constants::DBC_CLASS_TERM_ID => $classTerm->id,
        ]);

        if (!$createStudentTerminalLog) DB::rollBack();

        // get the subjects belonging to a class here.

        $classSubjectIds = ClassSubject::where(Constants::DBC_ACAD_CLASS_ID, $candidateProfile->academic_class_id)->get()->pluck(Constants::DBC_ACAD_SUBJECT_ID);

        $inputData = array();

        for ($i = 0; $i < count($classSubjectIds); $i++) {
            $inputData[$i] = array(
                Constants::DBC_STD_TERMINAL_LOG_ID => $createStudentTerminalLog->id,
                Constants::DBC_ACAD_SUBJECT_ID => $classSubjectIds[$i],
                'created_at' => now(),
            );
        }

        $createStudentTerminalLogSubjects = StudentTerminalLogSubject::insert($inputData); // Eloquent approach

//        dd('$classSubjectIds:// ', $classSubjectIds);

        if (!$createStudentTerminalLogSubjects) DB::rollBack();
        $affectedRows = UserCandidateProfile::where('user_id', Auth::id())->delete();
        if (!$affectedRows) DB::rollBack();


        DB::commit();

        return redirect('home')->with('success_message', 'Great! Your account has been successfully converted to full student account.');
    }

    /**
     * This is where we'll convert the authenticated candidate to full student
     * We do this by simply copying over the candidate details in to student tb
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function studentAcceptMigration(Request $request)
    {
        $candidateProfile = UserStudentProfile::where('user_id', Auth::id())->first();


        $lastSTLog = StudentTerminalLog::where(Constants::DBC_USER_ID, Auth::id())->latest('id')->first();
        $lastClassTerm = ClassTerm::latest('id')->first();
        $settings = SystemSetting::find(1);

        if ($lastSTLog->class_term_id == $lastClassTerm->id) {
            return redirect('home')->with('success_message', 'CongratulationsThis migration won\'t be performed as you are now a graduate.');
        } else {
            DB::beginTransaction();


            $createStudentTerminalLog = StudentTerminalLog::create([
                'user_id' => Auth::id(),
                Constants::DBC_ACAD_SESS_ID => $settings->academic_session_id,
                Constants::DBC_CLASS_TERM_ID => $lastSTLog->class_term_id + 1,
            ]);

            if (!$createStudentTerminalLog) DB::rollBack();

            // get the subjects belonging to a class here.

            $classSubjectIds = ClassSubject::where(Constants::DBC_ACAD_CLASS_ID, $lastClassTerm->academic_class_id)->get()->pluck(Constants::DBC_ACAD_SUBJECT_ID);

            $inputData = array();

            for ($i = 0; $i < count($classSubjectIds); $i++) {
                $inputData[$i] = array(
                    Constants::DBC_STD_TERMINAL_LOG_ID => $createStudentTerminalLog->id,
                    Constants::DBC_ACAD_SUBJECT_ID => $classSubjectIds[$i],
                    'created_at' => now(),
                );
            }

            $createStudentTerminalLogSubjects = StudentTerminalLogSubject::insert($inputData); // Eloquent approach

            if (!$createStudentTerminalLogSubjects) DB::rollBack();


            $updateUserId = UserStudentProfile::where('user_id', Auth::id())
                ->update([
                    Constants::DBC_HAS_TRANSIT => true,
                ]);

            if (!$updateUserId) DB::rollBack();
//            dd($lastSTLog, $lastClassTerm);

            DB::commit();

            return redirect('home')->with('success_message', 'Great! Your account has been successfully migrated.');

        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function avatar_update(Request $request)
    {
        request()->validate([
            Constants::DBC_AVATAR => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $filename = '';


        if ($files = $request->file(Constants::DBC_AVATAR)) {
            $destinationPath = Constants::AVATAR_UPLOAD_PATH; // upload path
            $filename = Auth::user()->reg_code . "." . $files->getClientOriginalExtension();

            $filePath = $request->avatar->storeAs($destinationPath, $filename); // it return the path at which the file is now save

            if ($request->avatar->isValid()) {
                User::where(Constants::DBC_REF_ID, Auth::id())
                    ->update([Constants::DBC_AVATAR => Constants::AVATAR_DOWNLOAD_PATH . $filename]);
            }

        }

        return redirect('home')->with('success_message', 'Profile updated!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showResult(Request $request)
    {
        $download = isset($request->query()['download']) ? $request->query()['download'] : null;

        $studentTerminalLog = StudentTerminalLog::where(Constants::RQ_USER_ID, Auth::id())->latest('id')->first();
        $data['subjects'] = $studentTerminalLog->student_terminal_log_subjects;
        $data['student_terminal_log'] = $studentTerminalLog;


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
    public function showOldResult(Request $request)
    {
        $sessionId = isset($request->query()[Constants::DBC_ACAD_SESS_ID]) ? $request->query()[Constants::DBC_ACAD_SESS_ID] : null;
        $classTermId = isset($request->query()[Constants::DBC_CLASS_TERM_ID]) ? $request->query()[Constants::DBC_CLASS_TERM_ID] : null;

        $studentTerminalLog = StudentTerminalLog::where(Constants::RQ_USER_ID, Auth::id())
            ->where(Constants::DBC_CLASS_TERM_ID, $classTermId)
            ->first();
        $data['subjects'] = $studentTerminalLog->student_terminal_log_subjects;
        $data['student_terminal_log'] = $studentTerminalLog;


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
    public function listStudentResultPast(Request $request)
    {

        $studentTerminalLog = StudentTerminalLog::where(Constants::RQ_USER_ID, Auth::id())->get();
//        dump($studentTerminalLog);
        $data['terminal_logs'] = $studentTerminalLog;


        $path = '/dashboard_' . Auth::user()->type . '.old_reports';
        return view($path, $data);
    }


    /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUserAdmin(Request $request, $id)
    {
        $user = User::whereId($id)->first();
        $user->delete();
        return redirect()->back()->with('success_message', 'Deleted successfully!.');
    }


    /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function assignDutyToStaffAdmin(Request $request, $user_id)
    {
        $duties = $request->duty;
//        override
        ClassStaff::where('user_id', $user_id)->forceDelete();
        for ($i = 0; $i < count($duties); $i++) {
            $classStaff = ClassStaff::where('user_id', $user_id);
            $classStaff = $classStaff->where('academic_class_id', $duties[$i])->first();
            if (!is_null($classStaff)) break;
            else {
                if (!is_null($duties[$i])) {
                    ClassStaff::create([
                        Constants::DBC_USER_ID => $user_id,
                        Constants::DBC_ACAD_SESS_ID => SystemSetting::find(1)->academic_session_id,
                        Constants::DBC_ACAD_CLASS_ID => $duties[$i]
                    ]);
                }
            }
        }
        return redirect()->back()->with('success_message', 'Assigned successfully!.');
    }

}
