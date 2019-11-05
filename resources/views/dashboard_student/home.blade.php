@extends('layouts.app')



@section('content')

    <div class="container">
        @if (!Auth::user()->student_profile->has_transit)
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header alert-info">Notification</div>

                        <div class="card-body">
                            Your term has been migrated, to update your profile click the Migrate button below to set up your profile for the next term.
                        </div>
                        <div class="card-footer">

                            <form id="accept-terminal-migration-form" action="{{ route('accept_terminal_migration') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                            <button type="button" class="btn btn-success"
                                    onclick="event.preventDefault();
                                        document.getElementById('accept-terminal-migration-form' ).submit();">
                                Migrate</button>
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
                        <a class="nav-link active" id="subjects-tab" data-toggle="tab" href="#subjects" role="tab"
                           aria-controls="subjects" aria-selected="true">Subjects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile" aria-selected="false">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="books-tab" data-toggle="tab" href="#books" role="tab"
                           aria-controls="books" aria-selected="false">Recommended Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="calender-tab" data-toggle="tab" href="#calender" role="tab"
                           aria-controls="calender" aria-selected="false">School Calender</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="results-tab" data-toggle="tab" href="#results" role="tab"
                           aria-controls="results" aria-selected="true">Results</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="subjects" role="tabpanel" aria-labelledby="subjects-tab">

                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($subjects as $key => $subject )
                                <tr>
                                    <th scope="row">
                                        {{--{{ $subject->id }} --}}
                                        {{ $key + 1 }}
                                    </th>
                                    <td>{{ $subject->academic_subject->title }}</td>
                                    <td>{{ $subject->academic_subject->category ?? '-' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="row justify-content-end">
                            <div class="col-md-6  justify-content-end">
                                <a href="{{ route('show_student_result') }}" class="btn btn-primary pull-left">
                                    Show Detailed Result</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('show_student_result_past') }}" class="btn btn-dark pull-right">
                                    Show Old Reports</a>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                <th scope="row">User Type</th>
                                <td>{{ Auth::user()->type ?? '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Birth</th>
                                <td>{{ Auth::user()->date_of_birth ?? '' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="books" role="tabpanel" aria-labelledby="books-tab">
                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Title</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Publication date</th>
                                <th scope="col">Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">MacMillian English</th>
                                <td>28-Dec-2019</td>
                                <td>28-122019</td>
                                <td>#1900</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="calender" role="tabpanel" aria-labelledby="calender-tab">
                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Event Title</th>
                                <th scope="col" class="text-right">Publication date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Inter-House Sports</th>
                                <td class="text-right">28-12-2019</td>
                            </tr>
                            <tr>
                                <th scope="row">Continous Assesment Tests (C.A)</th>
                                <td class="text-right">13-1-2020</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="results-tab">

                        <br>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">C.A. Test (30)</th>
                                <th scope="col">Exam (70)</th>
                                {{--<th scope="col">Total</th>--}}
                                {{--<th scope="col">Grade</th>--}}
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($subjects as $key => $subject )
                                @if (!is_null($subject->ca_test_score))
                                <tr>
                                    <th scope="row">
                                        {{--{{ $subject->id }} --}}
                                        {{ $key + 1 }}
                                    </th>
                                    <td>{{ $subject->academic_subject->title }}</td>
                                    <td>{{ $subject->ca_test_score ?? '-' }}</td>
                                    <td>{{ $subject->ca_exam_score ?? '-' }}</td>
                                    {{--<td>{{ $subject->ca_total ?? '-' }}</td>--}}
                                    {{--<td>{{ score_grade($subject->ca_total) }}</td>--}}
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>

                        <div class="row justify-content-end">
                            <div class="col-md-6  justify-content-end">
                                <a href="{{ route('show_student_result') }}" class="btn btn-primary pull-left">
                                    Show Detailed Result</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('show_student_result_past') }}" class="btn btn-dark pull-right">
                                    Show Old Reports</a>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
