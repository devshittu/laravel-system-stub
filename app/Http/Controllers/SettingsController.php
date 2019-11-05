<?php

namespace App\Http\Controllers;

use App\AcademicClass;
use App\AcademicSession;
use App\AcademicTerm;
use App\SystemSetting;
use App\UserCandidateProfile;
use App\UserStudentProfile;
use App\Utils\Constants;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'academic_sessions' => AcademicSession::all(),
            'academic_terms' => AcademicTerm::all(),
//            'academic_classes' => AcademicClass::all(),
            'academic_classes' => AcademicClass::where(Constants::DBC_CAN_APPLY, true)->get(),
            'settings' => SystemSetting::find(1),
        ];
        return view('dashboard_admin.settings', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 1)
    {
//        dd($request);
        $settings = SystemSetting::find($id);

        $oldAcadTerm = $settings->academic_term_id;
        $oldAcadSess = $settings->academic_session_id;
        $newAcadTerm = (int)$request->academic_term;
        $newAcadSess = (int)$request->academic_session;

        if ($oldAcadSess == $newAcadSess or $oldAcadSess < $newAcadSess) {
            if ($oldAcadTerm < $newAcadTerm) {
                $settings->school_name = $request->school_name;
                $settings->academic_session_id = $request->academic_session;
                $settings->academic_term_id = $request->academic_term;

                $settings->save();


                UserStudentProfile::where('deleted_at', null)->update(['has_transit' => false]);


                return redirect('settings')->with('success_message', 'Settings Saved!');
            } else return redirect('settings')->with('failure_message', 'Oops! Only a more recent term is allowed.');
        } else return redirect('settings')->with('failure_message', 'Oops! Only the same session or a more recent session is allowed. This is for progressive movement of the terminal log');


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function exam_update(Request $request, $id = 1)
    {
        // session applied for is the current session from settings
        //single entry
//        $user = User::whereEmail($email)->first(); //for multiple entries user ->get();
//        $systemSettings = SystemSetting::where('academic_session_id', $request->academic_session_id)->first();
        $systemSettings = SystemSetting::find($id);

        UserCandidateProfile::where('academic_class_id', $request->academic_class_id)
            ->where('academic_session_id', $systemSettings->academic_session_id)
            ->update(['exam_datetime' => $request->exam_datetime]);

        return redirect('settings')->with('success_message', 'Settings Saved! All applicants are all aware of the change.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
