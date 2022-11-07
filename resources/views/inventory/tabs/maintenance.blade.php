@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">{{ __('Inventories') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Maintenance') }}</li>
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
                        <h4 class="card-title float-left">{{ __('Maintenance') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('inventory.index') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Inventories') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('inventory.tabs.index')
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddNewMaintenance">
                                {{ __('Add maintenance') }}
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="AddNewMaintenance" tabindex="-1"
                            aria-labelledby="AddNewMaintenanceLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add maintenance') }}</h5>
                                    </div>
                                    <form method="POST" action="{{ route('maintenance.store') }}">
                                        <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="date_maintenance"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date of maintenance') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="date_maintenance" type="date" required2
                                                        class="form-control @error('date_maintenance') is-invalid @enderror"
                                                        name="date_maintenance" value="{{ old('date_maintenance') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('date_maintenance')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="reason"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Reason of maintenance') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea id="reason" required2 class="form-control @error('reason') is-invalid @enderror" name="reason">{{ old('reason') }}</textarea>
                                                    @error('reason')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="amount_paid"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Amount paid') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="amount_paid" type="number"
                                                        class="form-control @error('amount_paid') is-invalid @enderror"
                                                        required2 name="amount_paid" value="{{ old('amount_paid') }}">
                                                    @error('amount_paid')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="diagnostics"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Diagnostics') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea id="diagnostics" required2 class="form-control @error('diagnostics') is-invalid @enderror" name="diagnostics">{{ old('diagnostics') }}</textarea>
                                                    @error('diagnostics')
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
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Date of maintenance') }}</th>
                                        <th>{{ __('Reason of maintenance') }}</th>
                                        <th>{{ __('Amount paid') }}</th>
                                        <th>{{ __('Diagnostics') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($maintenance_array))
                                        @foreach ($maintenance_array as $maintenance)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $maintenance->date_maintenance }}</td>
                                                <td>{{ $maintenance->reason }}</td>
                                                <td>{{ $maintenance->amount_paid }}</td>
                                                <td>{{ $maintenance->diagnostics }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#EditRecord{{ $maintenance->id }}"
                                                            class="btn btn-sm p-2" title="Edit"><i
                                                                class="fa fa-edit"></i></a>
                                                        <form action="{{ route('maintenance.destroy') }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id"
                                                                value="{{ $maintenance->id }}">
                                                            <input type="hidden" name="inventory_id"
                                                                value="{{ $inventory->id }}">
                                                            <button type="submit" class="btn btn-sm p-2"
                                                                onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}')"
                                                                title="Delete"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="EditRecord{{ $maintenance->id }}" tabindex="-1"
                                                aria-labelledby="AddNewSuityyu7" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('Edit maintenance') }}</h5>
                                                        </div>
                                                        <form method="POST" action="{{ route('maintenance.store') }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $maintenance->id }}">
                                                            <input type="hidden" name="inventory_id"
                                                                value="{{ $inventory->id }}">

                                                            <div class="modal-body">
                                                                @csrf
                                                                <div class="row mb-3">
                                                                    <label for="date_maintenance"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Date of maintenance') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="date_maintenance" type="date"
                                                                            required2
                                                                            class="form-control @error('date_maintenance') is-invalid @enderror"
                                                                            name="date_maintenance"
                                                                            value="{{ $maintenance->date_maintenance }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('date_maintenance')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="reason"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Reason') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <textarea id="reason" required2 class="form-control @error('reason') is-invalid @enderror" name="reason">{{ $maintenance->reason }}</textarea>
                                                                        @error('reason')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="amount_paid"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Amount paid') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="amount_paid" type="number"
                                                                            class="form-control @error('amount_paid') is-invalid @enderror"
                                                                            required2 name="amount_paid"
                                                                            value="{{ $maintenance->amount_paid }}">
                                                                        @error('amount_paid')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="diagnostics"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Diagnostics') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <textarea id="diagnostics" required2 class="form-control @error('diagnostics') is-invalid @enderror"
                                                                            name="diagnostics">{{ $maintenance->diagnostics }}</textarea>
                                                                        @error('diagnostics')
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
                                                                <button type="submit" class="btn btn-success"
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
