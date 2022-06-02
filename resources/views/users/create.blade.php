@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    @if(isset($mode) && $mode == "edit")
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('User')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Update User')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Update User')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('home') }}" class="btn btn-dark p-2">{{__('Back to Users')}}</a>
                    </div>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('edit.user', $user->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="row mb-3">
                            <label for="first_name" class="col-md-2 col-form-label text-md-end">{{ __('First Name') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" autocomplete="first name" required>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-2 col-form-label text-md-end">{{ __('Last Name') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last name">

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('E-Mail Address') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('User Role') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <select multiple class="select select2-hidden-accessible @error('role') is-invalid @enderror" name="role[]" required>
                                    <option value="">Select Role</option>
                                    @if(isset($roles))
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id, $user->roles) ? 'selected' : ''}}>{{$role->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary p-2" onclick="return confirm('Are you sure you want to submit this form?')">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(isset($mode) && $mode == "create")
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('User')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Create User')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Create User')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('home') }}" class="btn btn-dark p-2">{{__('Back to Users')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create.user') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="first_name" class="col-md-2 col-form-label text-md-end">{{ __('First Name') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="name" required>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-2 col-form-label text-md-end">{{ __('Last Name') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('E-Mail Address') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-2 col-form-label text-md-end">{{ __('User Role') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <select multiple class="select @error('role') is-invalid @enderror" name="role[]" required aria-label=".form-select-lg example">
                                    <option>Select Role</option>
                                    @if(isset($roles))
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{ collect(old('role'))->contains($role->id) ? 'selected' : '' }}>{{$role->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-2 col-form-label text-md-end">{{ __('Password') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-2 col-form-label text-md-end">{{ __('Confirm Password') }}<span style="color:#ff0000">*</span></label>

                            <div class="col-md-10">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary p-2" onclick="return confirm('Are you sure you want to submit this form?')">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    //  $(document).ready(function () {
    //     $('.selectpicker').selectpicker();
    // })
    // $('select').selectpicker();
</script>
@endsection
