@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('System Settings') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings_update') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="school_name" class="col-md-4 col-form-label text-md-right">{{ __('School Name') }}</label>

                                <div class="col-md-6">
                                    <input id="school_name" type="text" value="{{ $settings->school_name }}" class="form-control @error('school_name') is-invalid @enderror" name="school_name" value="{{ old('school_name') }}" required autocomplete="school_name" autofocus>

                                    @error('school_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="academic_session" class="col-md-4 col-form-label text-md-right">{{ __('Current Session') }}</label>

                                <div class="col-md-6">

                                    <select class="form-control @error('academic_session') is-invalid @enderror" name="academic_session" id="academic_session" required >
                                        <option value="">Select</option>
                                        @foreach ($academic_sessions as $as)
                                                <option value="{{ $as->id }}" @if ($settings->academic_session_id == $as->id)  selected  @endif>{{ $as->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('academic_session')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="academic_term" class="col-md-4 col-form-label text-md-right">{{ __('Current Term') }}</label>

                                <div class="col-md-6">

                                    <select class="form-control @error('academic_term') is-invalid @enderror" name="academic_term" id="academic_term" required >
                                        <option value="">Select</option>
                                        @foreach ($academic_terms as $at)
                                                <option value="{{ $at->id }}" @if ($settings->academic_term_id == $at->id)  selected  @endif>{{ $at->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('academic_term')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Save Settings') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Exam Schedule For Applicants ( Candidates )') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings_exams_update') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="exam_datetime" class="col-md-4 col-form-label text-md-right">{{ __('Exam Date & Time ') }}</label>

                                <div class="col-md-6">
                                    <input id="exam_datetime" type="datetime-local" class="form-control @error('exam_datetime') is-invalid @enderror" name="exam_datetime" value="{{ old('exam_datetime') }}" required autocomplete="exam_datetime">

                                    @error('exam_datetime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="academic_session_id" class="col-md-4 col-form-label text-md-right">{{ __('For Academic Session') }}</label>

                                <div class="col-md-6">

                                    <select class="form-control @error('academic_session_id') is-invalid @enderror" name="academic_session_id" id="academic_session_id" required >
                                        <option value="">Select</option>
                                        @foreach ($academic_sessions as $as)
                                                <option value="{{ $as->id }}" @if ($settings->academic_session_id == $as->id)  selected  @endif>{{ $as->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('academic_session_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="academic_class_id" class="col-md-4 col-form-label text-md-right">{{ __('For Class') }}</label>

                                <div class="col-md-6">

                                    <select class="form-control @error('academic_class_id') is-invalid @enderror" name="academic_class_id" id="academic_class_id" required >
                                        @foreach ($academic_classes as $c)
                                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('class')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Save Settings') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
