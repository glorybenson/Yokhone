@extends('layouts.app')
@section('content')
    <style>
        #employeee-details .row {
            padding: 1rem .75rem;
            border-bottom: 1px solid #e6e6e6;
            padding-left: 0;
            padding-right: 0;
        }

        .text-responsive {
            border: 1px dotted blue;
            display: inline-block;
            max-width: 250px;
            padding: 10px;
            word-break: break-all;
        }
    </style>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item"><a href="{{ route('employees') }}">{{ __('Employees') }}</a></li>
                            <li class="breadcrumb-item active">{{ __("Employee's Data") }}</li>
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
                        <h4 class="card-title float-left">{{ __("Employee's Data") }}</h4>
                        <div class="text-right">
                            <a href="{{ route('employees') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Employees') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <div class="row mb-4 mobile-tab">
                                    <div class="col-xm-2"
                                        style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                        <div class="text-center">
                                            <a href="#" class="btn btn-primary p-2 mobile-tab-text"
                                                style="border-radius: 18px 18px 0px 0px;">{{ $employee->first_name }}
                                                {{ $employee->last_name }}</a>
                                        </div>
                                    </div>
                                    <div class="col-xm-2"
                                        style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                        <div class="text-center">
                                            <a href="{{ route('absence.employee', $employee->id) }}"
                                                class="btn btn-light active mobile-tab-text"
                                                style="border-radius: 18px 18px 0px 0px;">
                                                {{ __('Absence') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xm-2"
                                        style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                        <div class="text-center">
                                            <a href="{{ route('record.employee', $employee->id) }}"
                                                class="btn btn-light active mobile-tab-text"
                                                style="border-radius: 18px 18px 0px 0px;">
                                                {{ __('Employee Record') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xm-2"
                                        style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                        <div class="text-center">
                                            <a href="#" class="btn btn-light active mobile-tab-text"
                                                style="border-radius: 18px 18px 0px 0px;">{{ __('Salary History') }}</a>
                                        </div>
                                    </div>
                                    <div class="col-xm-2"
                                        style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                        <div class="text-center">
                                            <a href="{{ route('payment.employee', $employee->id) }}"
                                                class="btn btn-light active mobile-tab-text"
                                                style="border-radius: 18px 18px 0px 0px;">
                                                {{ __('Payment') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div id="employeee-details">
                                        <div class="row">
                                            <div class="col-4">{{ __('First Name') }}</div>
                                            <div class="col-8">{{ $employee->first_name }}</div>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Last Name') }}</div>
                                            <div class="col-8">{{ $employee->last_name }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Email Address') }}</div>
                                            <div class="col-8">{{ $employee->email }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Employee ID') }}</div>
                                            <div class="col-8">{{ $employee->employee_id }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Hiring Date') }}</div>
                                            <div class="col-8">{{ $employee->hiring_date }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('C.I.N') }}</div>
                                            <div class="col-8">{{ $employee->CIN }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('C.I.N Proof') }}</div>
                                            <div class="col-8">
                                                <div class="text-responsive documents-card d-flex mb-1">
                                                    <div class="documennts d-flex">
                                                        <i class="far fa-file-pdf pdf-icon"></i>
                                                        <p>{{ $employee->first_name }}
                                                            {{ $employee->last_name }}'s
                                                            {{ __('C.I.N Proof') }}</p>
                                                    </div>
                                                    <div class="actions d-flex">
                                                        <a download="" target="blank"
                                                            href="{{ asset('CIN_PROOF/' . $employee->CIN_proof) }}"><i
                                                                class="far fa-arrow-alt-circle-down"></i></a>
                                                        <a target="blank"
                                                            href="{{ asset('CIN_PROOF/' . $employee->CIN_proof) }}"><i
                                                                class="far fa-eye"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Cell1') }}</div>
                                            <div class="col-8">{{ $employee->cell_1 }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Cell2') }}</div>
                                            <div class="col-8">{{ $employee->cell_2 }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Address') }}</div>
                                            <div class="col-8">{{ $employee->address }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Contact 1 Full Name') }}</div>
                                            <div class="col-8">{{ $employee->contact_full_name }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Contact 1 Cell') }}</div>
                                            <div class="col-8">{{ $employee->contact_1_cell }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Contact 1 Cell2') }}</div>
                                            <div class="col-8">{{ $employee->contact_1_cell2 }}</div>
                                        </div>
                                    </div>
                                    {{-- <div class="table-responsive">
                                        <table class="table mb-0 border-0 dataTable">
                                            <tbody>
                                                <tr>
                                                    <td>{{ __('First Name') }}</td>
                                                    <td>{{ $employee->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Last Name') }}</td>
                                                    <td>{{ $employee->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Email Address') }}</td>
                                                    <td>{{ $employee->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Employee ID') }}</td>
                                                    <td>{{ $employee->employee_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Hiring Date') }}</td>
                                                    <td>{{ $employee->hiring_date }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('C.I.N') }}</td>
                                                    <td>{{ $employee->CIN }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('C.I.N Proof') }}</td>
                                                    <td>
                                                        <div class="documents-card d-flex mb-1">
                                                            <div class="documennts d-flex">
                                                                <i class="far fa-file-pdf pdf-icon"></i>
                                                                <p>{{ $employee->first_name }}
                                                                    {{ $employee->last_name }}'s
                                                                    {{ __('C.I.N Proof') }}</p>
                                                            </div>
                                                            <div class="actions d-flex">
                                                                <a download="" target="blank"
                                                                    href="{{ asset('CIN_PROOF/' . $employee->CIN_proof) }}"><i
                                                                        class="far fa-arrow-alt-circle-down"></i></a>
                                                                <a target="blank"
                                                                    href="{{ asset('CIN_PROOF/' . $employee->CIN_proof) }}"><i
                                                                        class="far fa-eye"></i></a>
                                                            </div>
                                                        </div>                                                                                                                                                                                                                                                     <a class="btn-sm btn-primary p-2" download="" target="blank" href="{{ asset('CIN_PROOF/' . $employee->CIN_proof) }}">Download C.I.N Proof</a> -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Cell1') }}</td>
                                                    <td>{{ $employee->cell_1 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Cell2') }}</td>
                                                    <td>{{ $employee->cell_2 }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Address') }}</td>
                                                    <td>{{ $employee->address }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Contact 1 Full Name') }}</td>
                                                    <td>{{ $employee->contact_full_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Contact 1 Cell') }}</td>
                                                    <td>{{ $employee->contact_1_cell }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Contact 1 Cell2') }}</td>
                                                    <td>{{ $employee->contact_1_cell2 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> --}}
                                    <div class="text-right mt-3">
                                        <a href="{{ route('edit.employee', $employee->id) }}"
                                            class="btn btn-sm p-2 btn-primary"
                                            title="Edit">{{ __('Edit Employee') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
