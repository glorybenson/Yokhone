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
                        <li class="breadcrumb-item active">{{__("Employee's Data")}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
    @media (min-width:320px)  {
         .className{media
        }
        }
        </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__("Employee's Data")}}</h4>
                    <div class="text-right">
                        <a href="{{ route('employees') }}" class="btn btn-outline-dark p-2">{{__('Back to Employees')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="row media">
                                <div class="col-xm-2" style="display: flex; justify-content: space-between; margin: 0 auto; padding: 10px 0;">
                                    <div class="text-center">
                                        <a href="#" class="btn btn-primary p-2" style="border-radius: 18px 18px 0px 0px;">{{$employee->first_name}} {{$employee->last_name }}</a>
                                    </div>
                                </div>

                                <div class="col-xm-2" style="display: flex; justify-content: space-between; margin: 0 auto; padding: 10px 0;">
                                    <div class="text-center">
                                        <a href="{{ route('absence.employee', $employee->id) }}" class="btn btn-light active" style="border-radius: 18px 18px 0px 0px;">
                                            {{__('Absence')}}
                                        </a>
                                    </div>
                                </div>

                                <div class="col-xm-2" style="display: flex; justify-content: space-between; margin: 0 auto; padding: 10px 0;">
                                    <div class="text-center">
                                        <a href="{{ route('record.employee', $employee->id) }}" class="btn btn-light active" style="border-radius: 18px 18px 0px 0px;">
                                            {{__('Employee Record')}}
                                        </a>
                                    </div>
                                </div>

                                <div class="col-xm-2" style="display: flex; justify-content: space-between; margin: 0 auto; padding: 10px 0;">
                                    <div class="text-center">
                                        <a href="{{ route('salary.employee', $employee->id) }}" class="btn btn-light active" style="border-radius: 18px 18px 0px 0px;">
                                            {{__('Salary History')}}
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xm-2" style="display: flex; justify-content: space-between; margin: 0 auto; padding: 10px 0;">
                                    <div class="text-center">
                                        <a href="{{ route('payment.employee', $employee->id) }}" class="btn btn-light
                                         active" style="border-radius: 18px 18px 0px 0px;">{{__('Payment')}}</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0 border-0">
                                            <tbody>
                                                <tr>
                                                    <td>{{ __('First Name') }}</td>
                                                    <td>{{$employee->first_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Last Name') }}</td>
                                                    <td>{{$employee->last_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Email Address') }}</td>
                                                    <td>{{$employee->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Employee ID') }}</td>
                                                    <td>{{$employee->employee_id}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Hiring Date') }}</td>
                                                    <td>{{$employee->hiring_date}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('C.I.N') }}</td>
                                                    <td>{{$employee->CIN}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('C.I.N Proof')}}</td>
                                                    <td>
                                                        <div class="documents-card d-flex mb-1">
                                                            <div class="documennts d-flex">
                                                                <i class="far fa-file-pdf pdf-icon"></i>
                                                                <p>{{$employee->first_name}} {{$employee->last_name}}'s {{ __('C.I.N Proof') }}</p>
                                                            </div>
                                                            <div class="actions d-flex">
                                                                <a download="" target="blank" href="{{ asset('CIN_PROOF/'.$employee->CIN_proof) }}"><i class="far fa-arrow-alt-circle-down"></i></a>
                                                                <a target="blank" href="{{ asset('CIN_PROOF/'.$employee->CIN_proof) }}"><i class="far fa-eye"></i></a>
                                                            </div>
                                                        </div>
                                                        <!-- <a class="btn-sm btn-primary p-2" target="blank" href="{{ asset('CIN_PROOF/'.$employee->CIN_proof) }}">View C.I.N Proof</a>
                                                        <a class="btn-sm btn-primary p-2" download="" target="blank" href="{{ asset('CIN_PROOF/'.$employee->CIN_proof) }}">Download C.I.N Proof</a> -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Cell1')}}</td>
                                                    <td>{{$employee->cell_1}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Cell2')}}</td>
                                                    <td>{{$employee->cell_2}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Address')}}</td>
                                                    <td>{{$employee->address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Contact 1 Full Name')}}</td>
                                                    <td>{{$employee->contact_full_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Contact 1 Cell')}}</td>
                                                    <td>{{$employee->contact_1_cell}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('Contact 1 Cell2')}}</td>
                                                    <td>{{$employee->contact_1_cell2}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-right">
                                        <a href="{{ route('edit.employee', $employee->id) }}" class="btn btn-sm p-2 btn-primary" title="Edit">{{__('Edit Employee')}}</a>
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
