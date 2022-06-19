@extends('layouts.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('employees') }}">{{__('Absence')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Absence')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__("Absence")}}</h4>
                    <div class="text-right">
                        <a href="{{ route('employees') }}" class="btn btn-outline-dark p-2">{{__('Back to Employees')
                        }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="{{ route('view.employee', $employee->id) }}" class="btn btn-light active p-2" style="border-radius: 18px 18px 0px 0px;">{{$employee->first_name}} {{$employee->last_name }}</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="#" class="btn btn-primary" style="border-radius: 18px 18px 0px 0px;">
                                    {{__('Absence')}}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="{{ route('salary.employee', $employee->id) }}" class="btn btn-light active" style="border-radius: 18px 18px 0px 0px;">
                                    {{__('Salary History')}}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <a href="{{ route('payment.employee', $employee->id) }}" class="btn btn-light active" style="border-radius: 18px 18px 0px 0px;">
                                    {{__('Payment')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddNewRecord">
                            {{__('Add New Record')}}
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="AddNewRecord" tabindex="-1" aria-labelledby="AddNewRecordLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('Add New Record')}}</h5>
                                </div>
                                <form method="POST" action="{{ route('add.record') }}">
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                        <div class="row mb-3">
                                            <label for="date" class="col-md-3 col-form-label text-md-end">{{ __('Date') }}<span style="color:#ff0000">*</span></label>
                                            <div class="col-md-8">
                                                <input id="date" type="date" required class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" autocomplete="first name" autofocus>
                                                @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="reason" class="col-md-3 col-form-label text-md-end">{{ __('Reason') }}<span style="color:#ff0000">*</span></label>
                                            <div class="col-md-8">
                                                <select class="select @error('reason') is-invalid @enderror" name="reason" required>
                                                    <option value="">{{__('Select Reason')}}</option>
                                                    <option value="Coaching" {{ old('reason') == 'Coaching' ? 'selected' : ''}}>
                                                        {{__('Coaching')}}</option>
                                                    <option value="Warning" {{ old('reason') == 'Warning' ? 'selected' : ''}}>
                                                        {{__('Warning')}}</option>
                                                    <option value="Sanction" {{ old('reason') == 'Sanction' ? 'selected' : ''}}>
                                                        {{__('Sanction')}}</option>
                                                </select>
                                                @error('reason')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="details" class="col-md-3 col-form-label text-md-end">{{__('Details') }}<span style="color:#ff0000">*</span></label>
                                            <div class="col-md-8">
                                                <textarea id="details" required class="form-control @error('details') is-invalid @enderror" name="details">{{ old('details') }}</textarea>
                                                @error('details')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            {{__('Close')}}
                                        </button>
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                            {{__('Add')}}
                                        </button>
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
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Reason')}}</th>
                                    <th>{{__('Details')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($records))
                                @foreach($records as $record)
                                <tr>
                                    <td>{{$sn++}}</td>
                                    <td>{{$record->date}}</td>
                                    <td>{{$record->reason}}</td>
                                    <td>{{$record->details}}</td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#EditRecord{{$record->id}}" class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="EditRecord{{$record->id}}" tabindex="-1" aria-labelledby="AddNewSalaryLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Salary') }}</h5>
                                            </div>
                                            <form method="POST" action="{{ route('add.record') }}">
                                                <div class="modal-body">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$record->id}}">
                                                    <input type="hidden" name="employee_id" value="{{$employee->id}}">
                                                    <div class="row mb-3">
                                                        <label for="date" class="col-md-3 col-form-label text-md-end">{{ __('Date') }}<span style="color:#ff0000">*</span></label>
                                                        <div class="col-md-8">
                                                            <input id="date" type="date" required class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $record->date }}">
                                                            @error('date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="reason" class="col-md-3 col-form-label text-md-end">{{ __('Reason') }}<span style="color:#ff0000">*</span></label>
                                                        <div class="col-md-8">
                                                            <select class="select @error('reason') is-invalid @enderror" name="reason" required>
                                                                <option value="">{{__('Select Reason')}}</option>
                                                                <option value="Coaching" {{ $record->reason == 'Coaching' ? 'selected' : ''}}>
                                                                    {{__('Coaching')}}</option>
                                                                <option value="Warning" {{ $record->reason == 'Warning' ? 'selected' : ''}}>
                                                                    {{__('Warning')}}</option>
                                                                <option value="Sanction" {{ $record->reason == 'Sanction' ? 'selected' : ''}}>
                                                                    {{__('Sanction')}}</option>
                                                            </select>
                                                            @error('reason')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="details" class="col-md-3 col-form-label text-md-end">{{ __('Details') }}<span style="color:#ff0000">*</span></label>
                                                        <div class="col-md-8">
                                                            <textarea id="details" required class="form-control @error('details') is-invalid @enderror" name="details">{{ $record->details }}</textarea>
                                                            @error('details')
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
