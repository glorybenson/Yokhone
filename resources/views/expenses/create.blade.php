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
                        <li class="breadcrumb-item">Finance</li>
                        <li class="breadcrumb-item"><a href="{{ route('expenses') }}">Expenses</a></li>
                        <li class="breadcrumb-item active">Update Expense</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">Update Expense Data</h4>
                    <div class="text-right">
                        <a href="{{ route('expenses') }}" class="btn btn-dark p-2">Back to Expenses</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit.expense', $expense->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$expense->id}}">
                        <div class="row mb-3">
                            <label for="date" class="col-md-2 col-form-label text-md-end">{{ __('Date') }}</label>
                            <div class="col-md-10">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $expense->date }}" autocomplete="name" required>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" required name="desc">{{ $expense->desc }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-2 col-form-label text-md-end">{{ __('Amount') }}</label>
                            <div class="col-md-10">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $expense->amount }}" required>
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="farm" class="col-md-2 col-form-label text-md-end">Farm</label>
                            <div class="col-md-10 mb-3">
                                <select class="select form-control @error('farm') is-invalid @enderror" name="farm">
                                    <option value="">Select a Farm</option>
                                    @if(isset($farms))
                                    @foreach($farms as $farm)
                                    <option value="{{$farm->id}}" {{ $expense->farm_id == $farm->id ? 'selected' : '' }}>{{$farm->farm_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('farm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="employee" class="col-md-2 col-form-label text-md-end">Employee</label>
                            <div class="col-md-10 mb-3">
                                <select class="select form-control @error('employee') is-invalid @enderror" name="employee">
                                    <option value="">Select an Employee</option>
                                    @if(isset($employees))
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" {{ $expense->employee_id == $employee->id ? 'selected' : '' }}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('employee')
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
                        <li class="breadcrumb-item">Finance</li>
                        <li class="breadcrumb-item"><a href="{{ route('expenses') }}">Expenses</a></li>
                        <li class="breadcrumb-item active">Create New Expense</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">Create Expenses</h4>
                    <div class="text-right">
                        <a href="{{ route('expenses') }}" class="btn btn-dark p-2">Back to Expenses</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create.expense') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="date" class="col-md-2 col-form-label text-md-end">{{ __('Date') }}</label>
                            <div class="col-md-10">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" autocomplete="name" required>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" required name="desc">{{ old('desc') }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="amount" class="col-md-2 col-form-label text-md-end">{{ __('Amount') }}</label>
                            <div class="col-md-10">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="farm" class="col-md-2 col-form-label text-md-end">Farm</label>
                            <div class="col-md-10 mb-3">
                                <select class="select form-control @error('farm') is-invalid @enderror" name="farm">
                                    <option value="">Select a Farm</option>
                                    @if(isset($farms))
                                    @foreach($farms as $farm)
                                    <option value="{{$farm->id}}" {{ old('farm') == $farm->id ? 'selected' : '' }}>{{$farm->farm_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('farm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="employee" class="col-md-2 col-form-label text-md-end">Employee</label>
                            <div class="col-md-10 mb-3">
                                <select class="select form-control @error('employee') is-invalid @enderror" name="employee">
                                    <option value="">Select an Employee</option>
                                    @if(isset($employees))
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" {{ old('employee') == $employee->id ? 'selected' : '' }}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('employee')
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
</div>
@endsection
