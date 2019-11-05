@extends('layouts.app')



@section('content')



    <div class="container">
        @if (Auth::user()->candidate_profile->is_admitted)
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Congratulations</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You have been offered admission in to {{ $settings->school_name }}
                    </div>
                    <div class="card-footer">

                        <form id="accept-admission-form" action="{{ route('accept_admission') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                        <button type="button" class="btn btn-success"
                                onclick="event.preventDefault();
                                        document.getElementById('accept-admission-form' ).submit();">
                            Accept Admission</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile" aria-selected="false">Candidate Profile</a>
                    </li>
                    {{--@if (!is_null($profile['exam_datetime']))--}}

                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                               aria-controls="contact" aria-selected="false">Exam Schedule</a>
                        </li>
                    {{--@endif--}}
                    {{--@if (!is_null($profile['exam_score']))--}}
                        <li class="nav-item">
                            <a class="nav-link" id="report-tab" data-toggle="tab" href="#report" role="tab"
                               aria-controls="report" aria-selected="false">Exam Report</a>
                        </li>
                    {{--@endif--}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        {{--Profile Tab...--}}
                        <br>

                        @if (is_null(Auth::user()->avatar))
                        <form id="file-upload-form" class="uploader" action="{{route('update_avatar')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            @csrf
                            <input id="file-upload" type="file" name="{{ \App\Utils\Constants::DBC_AVATAR }}" accept="image/*" onchange="readURL(this);">
                            <label for="file-upload" id="file-drag">
                                <img id="file-image" src="#" alt="Preview" class="hidden">
                                <div id="start" >
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    <div>Select a file or drag here</div>
                                    <div id="notimage" class="hidden">Please select an image</div>
                                    <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                    <br>
                                    <span class="text-danger">{{ $errors->first( \App\Utils\Constants::DBC_AVATAR ) }}</span>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </label>
                        </form>
                        @else
                            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" width="120px" height="120px">
                        @endif
                        <br>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col" colspan="2" class="text-center">Personal Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">REG NO</th>
                                <td>{{ Auth::user()->reg_code ?? '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{ Auth::user()->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Full Name</th>
                                <td>{{ (Auth::user()->first_name . ' ' . Auth::user()->last_name) ??  ('Unknown User') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Gender</th>
                                <td>{{ Auth::user()->gender ?? ''}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Birth</th>
                                <td>{{ (Auth::user()->date_of_birth)->format('jS M, Y') ?? ''}}
                                    {{--{{ ($profile['exam_datetime'])->format('l, jS M, Y') ?? 'Unavailable at the moment check back later.'}}--}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">User Type</th>
                                <td>{{ Auth::user()->type ?? '' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <br>
                        @if (!is_null($profile['exam_datetime']))
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col" colspan="2" class="text-center">Exam Schedule</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Exam Date</th>
                                <td>

                                    {{ ($profile['exam_datetime'])->format('l, jS M, Y') ?? 'Unavailable at the moment check back later.'}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Time</th>
                                <td>
                                    {{ ($profile['exam_datetime'])->format('H:i A') ?? 'Unavailable at the moment check back later.'}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        @else
                            Unavailable at the moment check back later.
                        @endif
                    </div>

                    <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col" colspan="2" class="text-center">Exam Result</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Exam Score</th>
                                <td>

                                    {{ $profile['exam_score'] ?? 'Unavailable at the moment check back later.'}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
