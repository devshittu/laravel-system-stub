@extends('layouts.report')



@section('content')

    <div class="container">
        <h1 class="text-center">{{ $settings->school_name }}</h1>
        <br>
        <h3 class="text-center">Terminal Report</h3>
        <br>
        <h3 class="text-center">{{ $student_terminal_log->class_term->academic_class->title }}  ({{ $student_terminal_log->class_term->academic_class->code_name }})</h3>
        <br>
        <div class="card">
            <div class="card-header">
                <div>Academic Session
                <strong> {{ $student_terminal_log->academic_session->title }}</strong></div>
                <div class="text-center" style="display: block; margin: 0 auto; width: 200px"> Position: <strong>3rd</strong></div>
                <div class="float-right"> <strong>{{ $student_terminal_log->class_term->academic_term->title }}</strong> Term</div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div>
                            <img src="{{  !is_null(Auth::user()->avatar) ? asset('storage/'.Auth::user()->avatar) : asset('img/default-avatar.png') }}" width="120px" height="120px">
                        </div>

                    </div>

                    <div class="col-sm-6">
                        <h6 class="mb-3">Student Profile: </h6>
                        <div>
                            Name: <strong>{{ Auth::user()->full_name }}</strong>
                        </div>
                        <div>
                            REG CODE: <strong>{{ Auth::user()->reg_code }}</strong>
                        </div>
                        <div>
                            Email : <strong>{{ Auth::user()->email }}</strong>
                        </div>
                        <div>
                            Gender : <strong>{{ Auth::user()->gender }}</strong>
                        </div>
                    </div>



                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">C.A. Test (30)</th>
                            <th scope="col">Exam (70)</th>
                            <th scope="col">Total</th>
                            <th scope="col">Grade</th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach ($subjects as $key => $subject )
                            @if (!is_null($subject->ca_test_score))
                            <tr>
                                <th scope="row" class="text-center">
                                    {{--{{ $subject->id }} --}}
                                    {{ ++ $key }}
                                </th>
                                <td class="left">{{ $subject->academic_subject->title }}</td>
                                <td class="right">{{ $subject->ca_test_score ?? '-' }}</td>
                                <td class="right">{{ $subject->ca_exam_score ?? '-' }}</td>
                                <td>{{ $subject->ca_total ?? '-' }}</td>
                                <td class="right">{{ score_grade($subject->ca_total) }}</td>
                            </tr>
                            @endif
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">

                    </div>

                    <div class="col-lg-4 col-sm-5 ml-auto">
                        {{--<table class="table table-clear">
                            <tbody>
                            <tr>
                                <td class="left">
                                    <strong>Position</strong>
                                </td>
                                <td class="right">9th</td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong>Recommendation </strong>
                                </td>
                                <td class="right">Good moral</td>
                            </tr>
                            </tbody>
                        </table>--}}

                    </div>

                </div>

            </div>
        </div>
    </div>




@endsection
