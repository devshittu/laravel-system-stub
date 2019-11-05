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
//            'academic_terms' => AcademicTerm::all(),
//            'academic_classes' => AcademicClass::all(),
//            'academic_classes' => AcademicClass::where(Constants::DBC_CAN_APPLY, true)->get(),
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

        $settings->system_name = $request->system_name;
        $settings->academic_session_id = $request->academic_session;

        $settings->save();


        UserStudentProfile::where('deleted_at', null)->update(['has_transit' => false]);


        return redirect('settings')->with('success_message', 'Settings Saved!');


    }

}
