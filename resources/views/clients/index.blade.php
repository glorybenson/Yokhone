@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item active">{{__('Clients')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Clients')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('create.client') }}" class="btn btn-dark p-2">{{__('Add New Client')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped border-0 data-table" id="datatable">
                            <thead class="thead-light">
                                <th>#</th>
                                <th>{{__('Client Name')}}</th>
                                <th>{{__('Full Address')}}</th>
                                <th>{{__('Contact Full Name')}}</th>
                                <th>{{__('Contact Phone')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Date Become Client')}}</th>
                                <th>{{__('Referred By')}}</th>
                                <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                                @if(isset($clients))
                                @foreach($clients as $client)
                                <tr>
                                    <td>{{$sn++}}</td>
                                    <td>{{$client->client_name}}</td>
                                    <td>{{$client->full_address}}</td>
                                    <td>{{$client->contact_full_name}}</td>
                                    <td>{{$client->contact_phone}}</td>
                                    <td>{{$client->contact_email}}</td>
                                    <td>{{$client->date_become_client}}</td>
                                    <td>
                                        @if($client->referred_by == "other")
                                        {{$client->note}}
                                        @elseif($client->referred_by == "employee")
                                        {{$client->employee->first_name}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('edit.client', $client->id) }}" class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
                                        </div>
                                    </td>
                                </tr>
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
