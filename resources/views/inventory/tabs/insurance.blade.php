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
                            <li class="breadcrumb-item active">{{ __('insurance') }}</li>
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
                        <h4 class="card-title float-left">{{ __('Insurance') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('inventory.index') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Inventories') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('inventory.tabs.index')
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddNewInsurance">
                                {{ __('Add Insurance') }}
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="AddNewInsurance" tabindex="-1" aria-labelledby="AddNewInsuranceLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Insurance') }}</h5>
                                    </div>
                                    <form method="POST" action="{{ route('insurance.store') }}">
                                        <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="company_name"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="company_name" type="text" required2
                                                        class="form-control @error('company_name') is-invalid @enderror"
                                                        name="company_name" value="{{ old('company_name') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('company_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="date_started"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date Started') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="date_started" type="date" required2
                                                        class="form-control @error('date_started') is-invalid @enderror"
                                                        name="date_started" value="{{ old('date_started') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('date_started')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="date_ending"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date Ending') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="date_ending" type="date" required2
                                                        class="form-control @error('date_ending') is-invalid @enderror"
                                                        name="date_ending" value="{{ old('date_ending') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('date_ending')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="company_contact_name"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Company Contact Name') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="company_contact_name" type="text"
                                                        value="{{ old('company_contact_name') }}"
                                                        name="company_contact_name"
                                                        class="form-control @error('company_contact_name') is-invalid @enderror">
                                                    @error('company_contact_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="company_contact_tel_no"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Company Contact Tel N0') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="company_contact_tel_no" type="text"
                                                        name="company_contact_tel_no"
                                                        value="{{ old('company_contact_tel_no') }}"
                                                        class="form-control @error('company_contact_tel_no') is-invalid @enderror">
                                                    @error('company_contact_tel_no')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="company_email"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Company Email') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="company_email" type="email"
                                                        value="{{ old('company_email') }}" name="company_email"
                                                        class="form-control @error('company_email') is-invalid @enderror">
                                                    @error('company_email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="other_details"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('other_details') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea id="other_details" required2 class="form-control @error('other_details') is-invalid @enderror"
                                                        name="other_details">{{ old('other_details') }}</textarea>
                                                    @error('other_details')
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
                                        <th>{{ __('Company Name') }}</th>
                                        <th>{{ __('Date Started') }}</th>
                                        <th>{{ __('Date Ending') }}</th>
                                        <th>{{ __('Company Contact Name') }}</th>
                                        <th>{{ __('Company Contact Tel N0') }}</th>
                                        <th>{{ __('Company Email') }}</th>
                                        <th>{{ __('Other Details') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($insurance_array))
                                        @foreach ($insurance_array as $insurance)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $insurance->company_name }}</td>
                                                <td>{{ $insurance->date_started }}</td>
                                                <td>{{ $insurance->date_ending }}</td>
                                                <td>{{ $insurance->company_contact_name }}</td>
                                                <td>{{ $insurance->company_contact_tel_no }}</td>
                                                <td>{{ $insurance->company_email }}</td>
                                                <td>{{ $insurance->other_details }}</td>
                                                <td>
                                                   <div class="d-flex">
                                                    <a data-bs-toggle="modal"
                                                    data-bs-target="#EditRecord{{ $insurance->id }}"
                                                    class="btn btn-sm p-2" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                        <form action="{{ route('insurance.destroy')}}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id" value="{{$insurance->id}}">
                                                            <input type="hidden" name="inventory_id" value="{{$inventory->id}}">
                                                            <button type="submit" class="btn btn-sm p-2" onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}')" title="Delete"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                   </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="EditRecord{{ $insurance->id }}" tabindex="-1"
                                                aria-labelledby="AddNewSuityyu7" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('Edit insurance') }}</h5>
                                                        </div>
                                                        <form method="POST" action="{{ route('insurance.store') }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $insurance->id }}">
                                                            <input type="hidden" name="inventory_id"
                                                                value="{{ $inventory->id }}">

                                                            <div class="modal-body">
                                                                @csrf
                                                                <div class="row mb-3">
                                                                    <label for="company_name"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="company_name" type="text" required2
                                                                            class="form-control @error('company_name') is-invalid @enderror"
                                                                            name="company_name"
                                                                            value="{{ $insurance->company_name }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('company_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="date_started"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Date Started') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="date_started" type="date" required2
                                                                            class="form-control @error('date_started') is-invalid @enderror"
                                                                            name="date_started"
                                                                            value="{{ $insurance->date_started }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('date_started')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="date_ending"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Date Ending') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="date_ending" type="date" required2
                                                                            class="form-control @error('date_ending') is-invalid @enderror"
                                                                            name="date_ending"
                                                                            value="{{ $insurance->date_ending }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('date_ending')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="company_contact_name"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Company Contact Name') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="company_contact_name" type="text"
                                                                            value="{{ $insurance->company_contact_name }}"
                                                                            name="company_contact_name"
                                                                            class="form-control @error('company_contact_name') is-invalid @enderror">
                                                                        @error('company_contact_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="company_contact_tel_no"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Company Contact Tel N0') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="company_contact_tel_no" type="text"
                                                                            name="company_contact_tel_no"
                                                                            value="{{ $insurance->company_contact_tel_no }}"
                                                                            class="form-control @error('company_contact_tel_no') is-invalid @enderror">
                                                                        @error('company_contact_tel_no')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="company_email"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Company Email') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="company_email" type="email"
                                                                            value="{{ $insurance->company_email }}"
                                                                            name="company_email"
                                                                            class="form-control @error('company_email') is-invalid @enderror">
                                                                        @error('company_email')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="other_details"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('other_details') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <textarea id="other_details" required2 class="form-control @error('other_details') is-invalid @enderror"
                                                                            name="other_details">{{ $insurance->other_details }}</textarea>
                                                                        @error('other_details')
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
