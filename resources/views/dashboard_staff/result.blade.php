@extends('layouts.app')



@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <h2>{{ $result_owner->full_name }}</h2>
            <h3>{{ $result_owner->user_student_profile }}</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                        <form method="POST" action="{{ route('update_student_result_staff', ['student_id' => $result_owner->id, 'stl_subject_id' => $subject->academic_subject_id]) }}">
                            {{--update_student_result--}}
                            @csrf


                        <tr>
                            <th scope="row" class="text-center">
                                {{--{{ $subject->id }} --}}
                                {{ ++ $key }}
                            </th>
                            <td class="left">{{ $subject->academic_subject->title }}</td>
                            <td class="right">
                                {{ $subject->ca_test_score ?? '-' }}
                                <div class="col-md-6" style="padding: 0px; margin: 0px">
                                    <input id="ca_test_score" type="number" max="30" class="form-control @error('ca_test_score') is-invalid @enderror" name="ca_test_score" value="{{ old('ca_test_score') }}" required autocomplete="ca_test_score">

                                </div>

                            </td>
                            <td class="right">
                                {{ $subject->ca_exam_score ?? '-' }}

                                <div class="col-md-6" style="padding: 0px; margin: 0px">
                                    <input id="ca_exam_score" type="number" max="70" class="form-control @error('ca_exam_score') is-invalid @enderror" name="ca_exam_score" value="{{ old('ca_exam_score') }}" autocomplete="ca_exam_score">

                                </div>
                            </td>
                            <td>{{ $subject->ca_total ?? '-' }}</td>
                            <td class="right">{{ score_grade($subject->ca_total) }}</td>
                            <td class="right">

                                <button type="submit" class="btn btn-success btn-sm">
                                    {{ __('Save Record') }}
                                </button>
                            </td>
                        </tr>
                        </form>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>




@endsection

