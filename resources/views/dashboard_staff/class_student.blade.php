@extends('layouts.app')



@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="text-center">{{ $class->title }}</h3>

                <br>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col">Names</th>
                        <th scope="col">Reg Code</th>
                        <th scope="col">Action</th>
                        {{--<th scope="col">Exam (70)</th>--}}
                        {{--<th scope="col">Total</th>--}}
                        {{--<th scope="col">Grade</th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @if(count($class_students) > 0)
                    @foreach ($class_students as $key => $student )
                        <tr>
                            <th scope="row">
                                {{ ++$key }}
                            </th>
                            <td>{{ $student->user->full_name }}</td>
                            <td>{{ $student->user->reg_code ?? '-' }}</td>
                            <td>
                                {{--<a class="btn btn-dark btn-sm" href="{{ route('show_class', [\App\Utils\Constants::DBC_ACAD_CLASS_ID => $student->user->id]) }}">
                                    View
                                </a>--}}
                                <a class="btn btn-primary btn-sm" href="{{ route('show_student_result_staff', ['student_id' => $student->user->id]) }}">
                                    Result
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @else

                        <tr>
                            <th scope="row" colspan="4">
                                No student in this class.
                            </th>
                        </tr>
                    @endif

                    </tbody>
                </table>


            </div>
        </div>
    </div>
@endsection
