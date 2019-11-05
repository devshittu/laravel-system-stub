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
                                <label for="system_name" class="col-md-4 col-form-label text-md-right">{{ __('System Name') }}</label>

                                <div class="col-md-6">
                                    <input id="system_name" type="text" value="{{ $settings->system_name }}" class="form-control @error('system_name') is-invalid @enderror" name="system_name" value="{{ old('system_name') }}" required autocomplete="system_name" autofocus>

                                    @error('system_name')
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
                            {{--<div class="form-group row">
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
                            </div>--}}
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
    </div>

@endsection
