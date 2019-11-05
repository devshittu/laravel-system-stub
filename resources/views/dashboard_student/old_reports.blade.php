@extends('layouts.app')



@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Session</th>
                        <th scope="col">Class</th>
                        <th scope="col">Term</th>
                        <th scope="col">Action</th>
                        {{--<th scope="col">Total</th>--}}
                        {{--<th scope="col">Grade</th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($terminal_logs as $key => $terminal_log )
                        <tr>
                            <th scope="row">
                                {{--{{ $subject->id }} --}}
                                {{ $key + 1 }}
                            </th>
                            <td>{{ $terminal_log->academic_session->title }}</td>
                            <td>{{ $terminal_log->class_term->academic_class->code_name ?? '-' }}</td>
                            <td>{{ $terminal_log->class_term->academic_term->code_name ?? '-' }}</td>
                            <td>

                                <a href="{{ route('show_student_old_result', [
                                'academic_session_id' => $terminal_log->academic_session_id,
                                'class_term_id' => $terminal_log->class_term_id,
                                ]) }}" class="btn btn-primary btn-sm pull-left">
                                    Show Detailed Result</a>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
