@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link active show" id="v-pills-home-tab" data-toggle="pill"
                               href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                               aria-selected="true">Users</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                               role="tab" aria-controls="v-pills-profile" aria-selected="false">Staff Duties</a>
                            <a class="nav-link" id="v-pills-classes-tab" data-toggle="pill" href="#v-pills-classes"
                               role="tab" aria-controls="v-pills-classes" aria-selected="false">Classes</a>
                            <a class="nav-link" id="v-pills-sessions-tab" data-toggle="pill" href="#v-pills-sessions"
                               role="tab" aria-controls="v-pills-sessions" aria-selected="false">Sessions</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">SN</th>
                                        <th scope="col">REG CODE</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($users) == 0)
                                        <p>No user exist {{ $user->id }}</p>
                                    @else
                                        @foreach ($users as $u)
                                            <tr>
                                                <th scope="row">{{ $u->id }}</th>
                                                <td>{{ $u->reg_code }}</td>
                                                <td> {{ $u->full_name }}</td>
                                                <td>

                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#deleteUserModal{{ $u->id }}"
                                                            @if(($u->id === Auth::id()) || $u->type === \App\Utils\Constants::DBCV_USER_TYPE_ADMIN) disabled @endif>
                                                        Delete
                                                    </button>
                                                    <div class="modal fade" id="deleteUserModal{{ $u->id }}"
                                                         tabindex="-1" role="dialog"
                                                         aria-labelledby="deleteUserModalTitle{{ $u->id }}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable"
                                                             role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteUserModalTitle{{ $u->id }}">
                                                                        Confirm</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>This operation cannot be undone. <br> Are you
                                                                        sure to delete
                                                                        <strong> {{ $u->full_name }}</strong>?</p>
                                                                    <form id="delete-user-form-{{ $u->id }}"
                                                                          action="{{ route('delete_user', ['user_id' => $u->id]) }}"
                                                                          method="POST">
                                                                        @csrf
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger"
                                                                            onclick="event.preventDefault();
                                                                                    document.getElementById('delete-user-form-{{ $u->id }}' ).submit();">
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                @if ($u->type === 'candidate')
                                                    {{--<a href="{{ $u->id }}" class="btn btn-dark btn-sm"> View</a>--}}
                                                    <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-dark btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#candidateModal{{ $u->id }}">
                                                            Update Score
                                                        </button>
                                                        <!-- Modal For adding score -->
                                                        <div class="modal fade" id="candidateModal{{ $u->id }}"
                                                             tabindex="-1" role="dialog"
                                                             aria-labelledby="candidateModalTitle{{ $u->id }}"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="candidateModalTitle{{ $u->id }}"> {{ $u->full_name }}</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="update-score-form-{{ $u->id }}"
                                                                              action="{{ route('update_candidate_score', ['user_id' => $u->id]) }}"
                                                                              method="POST">
                                                                            @csrf

                                                                            <div class="form-group">
                                                                                <label for="score">Score</label>
                                                                                <input type="number" name="score"
                                                                                       value="{{ $u->candidate_profile->exam_score }}"
                                                                                       oninput="checkScore(this, {{ $u->id }})"
                                                                                       class="form-control" id="score"
                                                                                       placeholder="0-100">
                                                                                <input type="hidden"
                                                                                       name="{{ \App\Utils\Constants::DBC_IS_ADMITTED }}"
                                                                                       value="0" class="form-control"
                                                                                       id="is_admitted{{$u->id}}">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                        <button type="button" class="btn btn-primary"
                                                                                onclick="event.preventDefault();
                                                                                        document.getElementById('update-score-form-{{ $u->id }}' ).submit();">
                                                                            Save
                                                                        </button>
                                                                        <button id="saveAndOfferAdmission{{$u->id}}"
                                                                                type="button" class="btn btn-success"
                                                                                style="display: none"
                                                                                onclick="event.preventDefault();
                                                                                        document.getElementById('update-score-form-{{ $u->id }}' ).action = '{{ route('update_candidate_score', ['user_id' => $u->id, 'offer' => 1]) }}';
                                                                                        document.getElementById('update-score-form-{{ $u->id }}' ).submit();">
                                                                            Save & Offer Admission
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif


                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif
                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">SN</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Class</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($staffs) == 0)
                                        <p>No staff exist</p>
                                    @else
                                        @foreach ($staffs as $key => $staff)
                                            <tr>
                                                <th scope="row">{{ ++$key }}</th>
                                                <td>{{ $staff->user->full_name }}</td>
                                                <td>
                                                    {{--@foreach($staff->staff_classes as $class)--}}
                                                        {{--{{ $class->academic_class->code_name. ', ' }}--}}
                                                    {{--@endforeach--}}
                                                </td>
                                                <td>

                                                    <button type="button" class="btn btn-primary btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#assignDutyModal{{ $staff->id }}">
                                                        Assign duty
                                                    </button>
                                                    <div class="modal fade" id="assignDutyModal{{ $staff->id }}"
                                                         tabindex="-1" role="dialog"
                                                         aria-labelledby="assignDutyModalTitle{{ $staff->id }}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable"
                                                             role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="assignDutyModalTitle{{ $staff->id }}">
                                                                        Assign Duty
                                                                        to {{ $staff->user->full_name }}</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="assign-duty-form-{{ $staff->id }}"
                                                                          action="{{ route('assign_duty_to_staff_admin', ['user_id' => $staff->user->id]) }}"
                                                                          method="POST">
                                                                        @csrf

                                                                        <div class="form-group">
                                                                            <label for="duty1">Duty 1 (Required)</label>

                                                                            <select class="form-control"
                                                                                    name="duty[]"
                                                                                    id="duty1" required>
                                                                                {{--@foreach ($academic_classes as $c)--}}
                                                                                    {{--<option value="{{ $c->id }}">{{ $c->title }}</option>--}}
                                                                                {{--@endforeach--}}
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="duty2">Duty 2 (Optional)</label>

                                                                            <select class="form-control"
                                                                                    name="duty[]"
                                                                                    id="duty2" required>
                                                                                <option value="">Select</option>
                                                                                {{--@foreach ($academic_classes as $c)--}}
                                                                                    {{--<option value="{{ $c->id }}">{{ $c->title }}</option>--}}
                                                                                {{--@endforeach--}}
                                                                            </select>
                                                                        </div>

                                                                    </form>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                    <button type="button" class="btn btn-primary"
                                                                            onclick="event.preventDefault();
                                                                                    document.getElementById('assign-duty-form-{{ $staff->id }}' ).submit();">
                                                                        Assign & Save
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>


                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="v-pills-classes" role="tabpanel"
                                 aria-labelledby="v-pills-classes-tab">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">SN</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Code Name</th>
                                        {{--<th scope="col">Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--@if (count($academic_classes) == 0)--}}
                                        <p>No user exist </p>
                                    {{--@else--}}
                                        {{--@foreach ($academic_classes as $c)--}}
                                            {{--<tr>--}}
                                                {{--<th scope="row">{{ $c->id }}</th>--}}
                                                {{--<td>{{ $c->title }}</td>--}}
                                                {{--<td> {{ $c->code_name }}</td>--}}
                                            {{--</tr>--}}
                                        {{--@endforeach--}}
                                        <p>Classes exist</p>

                                    {{--@endif--}}
                                    </tbody>
                                </table>

                            </div>
                            <div class="tab-pane fade" id="v-pills-sessions" role="tabpanel"
                                 aria-labelledby="v-pills-sessions-tab">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">SN</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Code Name</th>
                                        {{--<th scope="col">Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($academic_sessions) == 0)
                                        <p>No user exist </p>
                                    @else
                                        @foreach ($academic_sessions as $s)
                                            <tr>
                                                <th scope="row">{{ $s->id }}</th>
                                                <td>{{ $s->title }}</td>
                                                <td> {{ $s->code_name }}</td>
                                                {{--<td>

                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#deleteUserModal{{ $u->id }}"
                                                            @if(($u->id === Auth::id()) || $u->type === \App\Utils\Constants::DBCV_USER_TYPE_ADMIN) disabled @endif>
                                                        Delete
                                                    </button>
                                                    <div class="modal fade" id="deleteUserModal{{ $u->id }}"
                                                         tabindex="-1" role="dialog"
                                                         aria-labelledby="deleteUserModalTitle{{ $u->id }}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable"
                                                             role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteUserModalTitle{{ $u->id }}">
                                                                        Confirm</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>This operation cannot be undone. <br> Are you
                                                                        sure to delete
                                                                        <strong> {{ $u->full_name }}</strong>?</p>
                                                                    <form id="delete-user-form-{{ $u->id }}"
                                                                          action="{{ route('delete_user', ['user_id' => $u->id]) }}"
                                                                          method="POST">
                                                                        @csrf
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger"
                                                                            onclick="event.preventDefault();
                                                                                    document.getElementById('delete-user-form-{{ $u->id }}' ).submit();">
                                                                        Delete
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                @if ($u->type === 'candidate')
                                                    --}}{{--<a href="{{ $u->id }}" class="btn btn-dark btn-sm"> View</a>--}}{{--
                                                    <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-dark btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#candidateModal{{ $u->id }}">
                                                            Update Score
                                                        </button>
                                                        <!-- Modal For adding score -->
                                                        <div class="modal fade" id="candidateModal{{ $u->id }}"
                                                             tabindex="-1" role="dialog"
                                                             aria-labelledby="candidateModalTitle{{ $u->id }}"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="candidateModalTitle{{ $u->id }}"> {{ $u->full_name }}</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="update-score-form-{{ $u->id }}"
                                                                              action="{{ route('update_candidate_score', ['user_id' => $u->id]) }}"
                                                                              method="POST">
                                                                            @csrf

                                                                            <div class="form-group">
                                                                                <label for="score">Score</label>
                                                                                <input type="number" name="score"
                                                                                       value="{{ $u->candidate_profile->exam_score }}"
                                                                                       oninput="checkScore(this, {{ $u->id }})"
                                                                                       class="form-control" id="score"
                                                                                       placeholder="0-100">
                                                                                <input type="hidden"
                                                                                       name="{{ \App\Utils\Constants::DBC_IS_ADMITTED }}"
                                                                                       value="0" class="form-control"
                                                                                       id="is_admitted{{$u->id}}">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                        <button type="button" class="btn btn-primary"
                                                                                onclick="event.preventDefault();
                                                                                        document.getElementById('update-score-form-{{ $u->id }}' ).submit();">
                                                                            Save
                                                                        </button>
                                                                        <button id="saveAndOfferAdmission{{$u->id}}"
                                                                                type="button" class="btn btn-success"
                                                                                style="display: none"
                                                                                onclick="event.preventDefault();
                                                                                        document.getElementById('update-score-form-{{ $u->id }}' ).action = '{{ route('update_candidate_score', ['user_id' => $u->id, 'offer' => 1]) }}';
                                                                                        document.getElementById('update-score-form-{{ $u->id }}' ).submit();">
                                                                            Save & Offer Admission
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif


                                                </td>--}}
                                            </tr>
                                        @endforeach

                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
        </div>
    </div>
@endsection
