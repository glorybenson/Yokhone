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
                        <h4 class="card-title float-left">{{ __("Inventory Data") }}</h4>
                        <div class="text-right">
                            <a href="{{ route('inventory.index') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Inventory') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                        @include('inventory.tabs.index')

                                <div class="card-body">
                                    <div id="employeee-details">
                                        <div class="row">
                                            <div class="col-4">{{ __('Immatriculation Number') }}</div>
                                            <div class="col-8">{{ $inventory->immatriculation_number }}</div>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Date of Acquisition') }}</div>
                                            <div class="col-8">{{ $inventory->date_of_acquisition }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Acquisition cost') }}</div>
                                            <div class="col-8">{{ $inventory->acquisition_cost }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Millage on Acquisition') }}</div>
                                            <div class="col-8">{{ $inventory->millage_on_acquisition }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Make') }}</div>
                                            <div class="col-8">{{ $inventory->make }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Model') }}</div>
                                            <div class="col-8">{{ $inventory->model }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Serie') }}</div>
                                            <div class="col-8">{{ $inventory->serie }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ __('Year') }}</div>
                                            <div class="col-8">{{ $inventory->year }}</div>
                                        </div>
                                    <div class="text-right mt-3">
                                        <a href="{{ route('inventory.edit', $inventory->id) }}"
                                            class="btn btn-sm p-2 btn-primary"
                                            title="Edit">{{ __('Edit Inventory') }}</a>
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
