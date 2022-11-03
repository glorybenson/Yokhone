@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">{{ __('Inventories') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Assignment') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .bolder{
                font-weight: 600;
            }
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
                        <h4 class="card-title float-left">{{ __('Assignment') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('inventory.index') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Inventories') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('inventory.tabs.index')
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddNewAssignment">
                                {{ __('Add Assignment') }}
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="AddNewAssignment" tabindex="-1" aria-labelledby="AddNewAssignmentLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Assignment') }}</h5>
                                    </div>
                                    <form method="POST" action="{{ route('assignment.store') }}">
                                        <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="driver_id"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Name of the driver') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <select class="form-control @error('driver_id') is-invalid @enderror"
                                                        name="driver_id" required2>
                                                        <option selected value="">Select --</option>
                                                        @if (isset($employees))
                                                            @foreach ($employees as $employee)
                                                                <option value="{{ $employee->id }}" {{ old('driver_id') == $employee->id ? 'selected' : '' }}>
                                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('driver_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="assigned_date"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date Assigned') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="assigned_date" type="date" required2
                                                        class="form-control @error('assigned_date') is-invalid @enderror"
                                                        name="assigned_date" value="{{ old('assigned_date') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('assigned_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="revoked_date"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date Revoked') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="revoked_date" type="date" required2
                                                        class="form-control @error('revoked_date') is-invalid @enderror"
                                                        name="revoked_date" value="{{ old('revoked_date') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('revoked_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="details_of_revokation"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Details of revokation') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea id="details_of_revokation" required2 class="form-control @error('details_of_revokation') is-invalid @enderror"
                                                        name="details_of_revokation">{{ old('details_of_revokation') }}</textarea>
                                                    @error('details_of_revokation')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                {{ __('Close') }}
                                            </button>
                                            <button type="submit" class="btn btn-primary"
                                                onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                                {{ __('Add') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name of the driver') }}</th>
                                        <th>{{ __('Date Assigned') }}</th>
                                        <th>{{ __('Date Revoked') }}</th>
                                        <th>{{ __('Details of revokation') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($assignment_array))
                                        @foreach ($assignment_array as $assignment)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $assignment->employee->first_name }} {{ $assignment->employee->last_name }}</td>
                                                <td>{{ $assignment->assigned_date }}</td>
                                                <td>{{ $assignment->revoked_date }}</td>
                                                <td>{{ $assignment->details_of_revokation }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#EditAssignment{{ $assignment->id }}"
                                                            class="btn btn-sm p-2" title="Edit"><i
                                                                class="fa fa-edit"></i></a>
                                                        <form action="{{ route('assignment.destroy') }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id"
                                                                value="{{ $assignment->id }}">
                                                            <input type="hidden" name="inventory_id"
                                                                value="{{ $inventory->id }}">
                                                            <button type="submit" class="btn btn-sm p-2"
                                                                onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}')"
                                                                title="Delete"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="EditAssignment{{ $assignment->id }}" tabindex="-1"
                                                aria-labelledby="AddNewSuityyu7" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('Edit Assignment') }}</h5>
                                                        </div>
                                                        <form method="POST" action="{{ route('assignment.store') }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $assignment->id }}">
                                                            <input type="hidden" name="inventory_id"
                                                                value="{{ $inventory->id }}">

                                                            <div class="modal-body">
                                                                @csrf

                                                                <div class="row mb-3">
                                                                    <label for="driver_id"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Name of the driver') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <select class="form-control @error('driver_id') is-invalid @enderror"
                                                                            name="driver_id" required2>
                                                                            <option selected value="">Select --</option>
                                                                            @if (isset($employees))
                                                                                @foreach ($employees as $employee)
                                                                                    <option value="{{ $employee->id }}" {{ $assignment->driver_id == $employee->id ? 'selected' : '' }}>
                                                                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                        @error('driver_id')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="assigned_date"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Date Assigned') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="assigned_date" type="date" required2
                                                                            class="form-control @error('assigned_date') is-invalid @enderror"
                                                                            name="assigned_date"
                                                                            value="{{ $assignment->assigned_date }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('assigned_date')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="revoked_date"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Date Revoked') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="revoked_date" type="date" required2
                                                                            class="form-control @error('revoked_date') is-invalid @enderror"
                                                                            name="revoked_date"
                                                                            value="{{ $assignment->revoked_date }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('revoked_date')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="details_of_revokation"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Details of Revokation') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <textarea id="details_of_revokation" required2 class="form-control @error('details_of_revokation') is-invalid @enderror"
                                                                            name="details_of_revokation">{{ $assignment->details_of_revokation }}</textarea>
                                                                        @error('details_of_revokation')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    {{ __('Close') }}</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                                                    {{ __('Update') }}</button>
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
