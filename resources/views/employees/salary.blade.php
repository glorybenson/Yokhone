@extends('layouts.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('employees') }}">{{__('Employees')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Employee Salary History')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width:520px) {
            .mobile-tab .mobile-tab-text {
                font-size: 12px;
            }

            .mobile-tab .col-xm-2 {
                display: flex;
                width: inherit;
                margin: 3px;
                padding-right: 0px;
                padding-left: 0px;
            }
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__("Employee's Salary History")}}</h4>
                    <div class="text-right">
                        <a href="{{ route('employees') }}" class="btn btn-outline-dark p-2">
                            {{__('Back to Employees')}}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4 mobile-tab">
                        <div class="col-xm-2" style="justify-content: space-between;">
                            <div class="text-center">
                                <a href="{{ route('view.employee', $employee->id) }}" class="btn btn-light active p-2 mobile-tab-text" style="border-radius: 18px 18px 0px 0px;">{{$employee->first_name}} {{$employee->last_name }}</a>
                            </div>
                        </div>

                        <div class="col-xm-2" style="justify-content: space-between;">
                            <div class="text-center">
                                <a href="{{ route('absence.employee', $employee->id) }}" class="btn btn-light active mobile-tab-text" style="border-radius: 18px 18px 0px 0px;">
                                    {{__('Absence')}}
                                </a>
                            </div>
                        </div>

                        <div class="col-xm-2" style="justify-content: space-between;">
                            <div class="text-center">
                                <a href="{{ route('record.employee', $employee->id) }}" class="btn btn-light active mobile-tab-text" style="border-radius: 18px 18px 0px 0px;">
                                    {{__('Employee Record')}}
                                </a>
                            </div>
                        </div>
                        <div class="col-xm-2" style="justify-content: space-between; padding: 8px 0;">
                            <div class="text-center">
                                <a href="#" class="btn btn-primary mobile-tab-text" style="border-radius: 18px 18px 0px 0px;">{{__('Salary History')}}</a>
                            </div>
                        </div>
                        <div class="col-xm-2" style="justify-content: space-between; padding: 8px 0;">
                            <div class="text-center">
                                <a href="{{ route('payment.employee', $employee->id) }}" class="btn btn-light active mobile-tab-text" style="border-radius: 18px 18px 0px 0px;">
                                    {{__('Payment')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddNewSalary">
                            {{__('Add New Salary')}}
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="AddNewSalary" tabindex="-1" aria-labelledby="AddNewSalaryLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('Add New Salary')}}</h5>
                                </div>
                                <form method="POST" action="{{ route('add.salary') }}">
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                        <div class="row mb-3">
                                            <label for="salary_amount" class="col-md-4 col-form-label text-md-end">{{ __('Salary Amount') }}<span style="color:#ff0000">*</span></label>
                                            <div class="col-md-6">
                                                <input id="salary_amount" type="number" required class="form-control @error('salary_amount') is-invalid @enderror" name="salary_amount" value="{{ old('salary_amount') }}" autocomplete="first name" autofocus> @error('salary_amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="salary_start_date" class="col-md-4 col-form-label text-md-end">{{ __('Salary Start Date') }}<span style="color:#ff0000">*</span></label>
                                            <div class="col-md-6">
                                                <input id="salary_start_date" type="date" required class="form-control @error('salary_start_date') is-invalid @enderror" name="salary_start_date" value="{{ old('salary_start_date') }}" autocomplete="first name" autofocus>

                                                @error('salary_start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="salary_end_date" class="col-md-4 col-form-label text-md-end">{{ __('Salary End Date') }}<span style="color:#ff0000">*</span></label>
                                            <div class="col-md-6">
                                                <input id="salary_end_date" type="date" required class="form-control @error('salary_end_date') is-invalid @enderror" name="salary_end_date" value="{{ old('salary_end_date') }}" autocomplete="first name" autofocus>

                                                @error('salary_end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                            {{__('Add')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped border-0 data-table" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('Salary Amount')}}</th>
                                    <th>{{__('Salary Start Date')}}</th>
                                    <th>{{__('Salary End Date')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($salaries))
                                @foreach($salaries as $salary)
                                <tr>
                                    <td>{{$sn++}}</td>
                                    <td>{{$salary->amount}}</td>
                                    <td>{{$salary->start_date}}</td>
                                    <td>{{$salary->end_date}}</td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#AddNewSalary{{$salary->id}}" class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="AddNewSalary{{$salary->id}}" tabindex="-1" aria-labelledby="AddNewSalaryLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{__('Edit Salary')}}</h5>
                                            </div>
                                            <form method="POST" action="{{ route('add.salary') }}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$salary->id}}">
                                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                                    <div class="row mb-3">
                                                        <label for="salary_amount" class="col-md-4 col-form-label text-md-end">{{ __('Salary Amount') }}<span style="color:#ff0000">*</span></label>
                                                        <div class="col-md-6">
                                                            <input id="salary_amount" type="number" required class="form-control @error('salary_amount') is-invalid @enderror" name="salary_amount" value="{{ $salary->amount }}" autocomplete="first name" autofocus> @error('salary_amount')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="salary_start_date" class="col-md-4 col-form-label text-md-end">{{ __('Salary Start Date') }}<span style="color:#ff0000">*</span></label>
                                                        <div class="col-md-6">
                                                            <input id="salary_start_date" type="date" required class="form-control @error('salary_start_date') is-invalid @enderror" name="salary_start_date" value="{{ $salary->start_date }}" autocomplete="first name" autofocus>
                                                            @error('salary_start_date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="salary_end_date" class="col-md-4 col-form-label text-md-end">{{ __('Salary End Date') }}<span style="color:#ff0000">*</span></label>
                                                        <div class="col-md-6">
                                                            <input id="salary_end_date" type="date" required class="form-control @error('salary_end_date') is-invalid @enderror" name="salary_end_date" value="{{ $salary->end_date }}" autocomplete="first name" autofocus>
                                                            @error('salary_end_date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        {{__('Close')}}</button>
                                                    <button type="submit" class="btn btn-success" onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                                        {{__('Update')}}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
