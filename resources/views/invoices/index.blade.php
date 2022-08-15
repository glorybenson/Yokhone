@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item">{{ __('Finance') }}</li>
                            <li class="breadcrumb-item active">{{ __('Invoices') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Invoices') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('create.invoice') }}" class="btn btn-dark p-2">{{ __('Add New Invoice') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead class="thead-light">
                                    <th>ID</th>
                                    <th>{{ __('Client Name') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Unit Price') }}</th>
                                    <th>{{ __('Total Price before discount') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Total Price after discount') }}</th>
                                    <th>{{ __('Crop') }}</th>
                                    <th>{{ __('Farm') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </thead>
                                <tbody>
                                    @if (isset($invoices))
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $invoice->client->client_name ?? '' }}</td>
                                                <td>{{ $invoice->date }}</td>
                                                <td>{{ $invoice->desc }}</td>
                                                <td>{{ $invoice->quantity }}</td>
                                                <td>{{ $invoice->unit_price }}</td>
                                                <td>{{ $invoice->total_price_before_discount }}</td>
                                                <td>{{ $invoice->discount }}</td>
                                                <td>{{ $invoice->total_price_after_discount }}</td>
                                                <td>{{ $invoice->crop->date }} - {{ $invoice->crop->type_of_crop }} -
                                                    {{ $invoice->crop->desc }}</td>
                                                <td>{{ $invoice->farm->farm_name }}</td>
                                                <td>
                                                    <a href="{{ route('edit.invoice', $invoice->id) }}"
                                                        class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('destroy.invoice', $invoice->id) }}"
                                                        class="btn btn-sm p-2" title="Delete"><i class="fa fa-trash"
                                                            onclick="return confirm('Are you sure you want to delete this record?')"></i></a>
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
