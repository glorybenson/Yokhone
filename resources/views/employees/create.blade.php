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
                        <li class="breadcrumb-item"><a href="{{ route('employees') }}">{{__('Employees')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Update Employee Data')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Update Employee Data')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('employees') }}" class="btn btn-dark p-2">{{__('Back to Employees')}}</a>
                    </div>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('edit.employee', $employee->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $employee->id }}">

                        <div class="row mb-3">
                            <label for="first_name" class="col-md-2 col-form-label text-md-end">{{ __('First Name') }}</label>
                            <div class="col-md-10">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $employee->first_name }}" autocomplete="first name" required autofocus>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-2 col-form-label text-md-end">{{ __('Last Name') }}</label>
                            <div class="col-md-10">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $employee->last_name }}" required autocomplete="last name" required autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $employee->email }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="employee_id" class="col-md-2 col-form-label text-md-end">{{ __('Employee ID') }}</label>
                            <div class="col-md-10">
                                <input id="employee_id" type="number" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" required value="{{ $employee->employee_id }}">
                                @error('employee_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hiring_date" class="col-md-2 col-form-label text-md-end">{{ __('Hiring Date') }}</label>
                            <div class="col-md-10">
                                <input id="hiring_date" type="date" class="form-control @error('hiring_date') is-invalid @enderror" name="hiring_date" required value="{{ $employee->hiring_date }}">
                                @error('hiring_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end_date" class="col-md-2 col-form-label text-md-end">{{ __('End Date') }}</label>
                            <div class="col-md-10">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ $employee->end_date }}">
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="CIN" class="col-md-2 col-form-label text-md-end">{{ __('CIN') }}</label>
                            <div class="col-md-10">
                                <input id="CIN" type="text" class="form-control @error('CIN') is-invalid @enderror" name="CIN" required value="{{ $employee->CIN }}">

                                @error('CIN')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="CIN_proof" class="col-md-2 col-form-label text-md-end">{{ __('CIN Proof') }}</label>

                            <div class="col-md-10">
                                <div class="input-group">
                                    <input id="CIN_proof" type="file" accept="image/*,.doc, .docx, .pdf" class="form-control @error('CIN_proof') is-invalid @enderror" name="CIN_proof" value="{{ $employee->CIN_proof }}">
                                    @error('CIN_proof')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <span class="input-group-btn">
                                        <a target="blank" href="{{ asset('CIN_PROOF/'.$employee->CIN_proof) }}" class="btn btn-dark" type="button"><i class="far fa-eye"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cell_1" class="col-md-2 col-form-label text-md-end">{{ __('Cell1') }}</label>
                            <div class="col-md-10">
                                <input id="cell_1" type="text" class="form-control @error('cell_1') is-invalid @enderror" required name="cell_1" value="{{ $employee->cell_1 }}">
                                @error('cell_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cell_2" class="col-md-2 col-form-label text-md-end">{{ __('Cell2') }}</label>
                            <div class="col-md-10">
                                <input id="cell_2" type="text" class="form-control @error('cell_2') is-invalid @enderror" name="cell_2" value="{{ $employee->cell_2 }}">
                                @error('cell_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-2 col-form-label text-md-end">{{ __('Address') }}</label>

                            <div class="col-md-10">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" required name="address">{{ $employee->address }}</textarea>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_full_name" class="col-md-2 col-form-label text-md-end">{{ __('Contact 1 Full Name') }}</label>
                            <div class="col-md-10">
                                <input id="contact_full_name" type="text" class="form-control @error('contact_full_name') is-invalid @enderror" required name="contact_full_name" value="{{ $employee->contact_full_name }}">
                                @error('contact_full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_1_cell" class="col-md-2 col-form-label text-md-end">{{ __('Contact 1 Cell') }}</label>
                            <div class="col-md-10">
                                <input id="contact_1_cell" type="text" class="form-control @error('contact_1_cell') is-invalid @enderror" required name="contact_1_cell" value="{{ $employee->contact_1_cell }}">
                                @error('contact_1_cell')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_1_cell2" class="col-md-2 col-form-label text-md-end">{{ __('Contact 1 Cell2') }}</label>
                            <div class="col-md-10">
                                <input id="contact_1_cell2" type="text" class="form-control @error('contact_1_cell2') is-invalid @enderror" required name="contact_1_cell2" value="{{ $employee->contact_1_cell2 }}">
                                @error('contact_1_cell2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                                <button type="submit" class="btn btn-primary p-3" onclick="return confirm('Are you sure you want to submit this form?')">
                                    {{ __('Update') }}
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
                        <li class="breadcrumb-item"><a href="{{ route('employees') }}">Employees</a></li>
                        <li class="breadcrumb-item active">Add New Employee</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">Create Employee</h4>
                    <div class="text-right">
                        <a href="{{ route('employees') }}" class="btn btn-dark p-2">Back to Employees</a>
                    </div>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('create.employee') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="first_name" class="col-md-2 col-form-label text-md-end">{{ __('First Name') }}</label>
                            <div class="col-md-10">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="first name" required autofocus>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-2 col-form-label text-md-end">{{ __('Last Name') }}</label>
                            <div class="col-md-10">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last name" required autofocus>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" required name="email" value="{{ old('email') }}" autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="employee_id" class="col-md-2 col-form-label text-md-end">{{ __('Employee ID') }}</label>
                            <div class="col-md-10">
                                <input id="employee_id" type="number" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}" required>
                                @error('employee_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hiring_date" class="col-md-2 col-form-label text-md-end">{{ __('Hiring Date') }}</label>
                            <div class="col-md-10">
                                <input id="hiring_date" type="date" class="form-control @error('hiring_date') is-invalid @enderror" name="hiring_date" value="{{ old('hiring_date') }}" required>
                                @error('hiring_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="end_date" class="col-md-2 col-form-label text-md-end">{{ __('End Date') }}</label>
                            <div class="col-md-10">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="CIN" class="col-md-2 col-form-label text-md-end">{{ __('CIN') }}</label>
                            <div class="col-md-10">
                                <input id="CIN" type="text" class="form-control @error('CIN') is-invalid @enderror" name="CIN" value="{{ old('CIN') }}" required>
                                @error('CIN')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="CIN_proof" class="col-md-2 col-form-label text-md-end">{{ __('CIN Proof') }}</label>
                            <div class="col-md-10">
                                <input id="CIN_proof" type="file" accept="image/*,.doc, .docx, .pdf" class="form-control @error('CIN_proof') is-invalid @enderror" name="CIN_proof" value="{{ old('CIN_proof') }}" required>
                                @error('CIN_proof')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cell_1" class="col-md-2 col-form-label text-md-end">{{ __('Cell1') }}</label>
                            <div class="col-md-10">
                                <input id="cell_1" type="text" class="form-control @error('cell_1') is-invalid @enderror" name="cell_1" value="{{ old('cell_1') }}" required>
                                @error('cell_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cell_2" class="col-md-2 col-form-label text-md-end">{{ __('Cell2') }}</label>
                            <div class="col-md-10">
                                <input id="cell_2" type="text" class="form-control @error('cell_2') is-invalid @enderror" name="cell_2" value="{{ old('cell_2') }}">
                                @error('cell_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-2 col-form-label text-md-end">{{ __('Address') }}</label>
                            <div class="col-md-10">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" required name="address">{{ old('address') }}</textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_full_name" class="col-md-2 col-form-label text-md-end">{{ __('Contact 1 Full Name') }}</label>
                            <div class="col-md-10">
                                <input id="contact_full_name" type="text" class="form-control @error('contact_full_name') is-invalid @enderror" name="contact_full_name" value="{{ old('contact_full_name') }}" required>
                                @error('contact_full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_1_cell" class="col-md-2 col-form-label text-md-end">{{ __('Contact 1 Cell') }}</label>
                            <div class="col-md-10">
                                <input id="contact_1_cell" type="text" class="form-control @error('contact_1_cell') is-invalid @enderror" required name="contact_1_cell" value="{{ old('contact_1_cell') }}">
                                @error('contact_1_cell')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_1_cell2" class="col-md-2 col-form-label text-md-end">{{ __('Contact 1 Cell2') }}</label>
                            <div class="col-md-10">
                                <input id="contact_1_cell2" type="text" class="form-control @error('contact_1_cell2') is-invalid @enderror" required name="contact_1_cell2" value="{{ old('contact_1_cell2') }}">
                                @error('contact_1_cell2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary p-3" onclick="return confirm('Are you sure you want to submit this form?')">
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
@endsection
