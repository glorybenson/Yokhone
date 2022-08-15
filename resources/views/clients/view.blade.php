@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item"><a href="{{ route('clients') }}">{{ __('Clients') }}</a></li>
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

            table,
            th,
            td {
                padding: 0 0 10px 0;
            }

            td:last-child {
                text-align: left;
                padding-left: 1rem;
            }
        </style>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __("Client's Data") }}</h4>
                        <div class="text-right">
                            <a href="{{ route('clients') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Clients') }}</a>
                        </div>
                    </div>

                                <div class="card-body">
                                    <div class="table table-bordered table-striped">
                                        <table>
                                            <tr>
                                                <td>{{ __('Client Name') }}:</td>
                                                <td>{{ $client->client_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Full Address') }}:</td>
                                                <td>{{ $client->full_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Contact Full Name') }}:</td>
                                                <td>{{ $client->contact_full_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Contact Phone') }}:</td>
                                                <td>{{ $client->contact_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Email') }}:</td>
                                                <td>{{ $client->contact_email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Date Become Client') }}:</td>
                                                <td>{{ $client->date_become_client }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Referred By') }}:</td>
                                                <td>
                                                    @if ($client->referred_by == 'other')
                                                        {{ $client->note }}
                                                    @elseif($client->referred_by == 'employee')
                                                        {{ $client->employee->first_name }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
