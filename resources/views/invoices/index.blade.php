@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item">Finance</li>
                        <li class="breadcrumb-item active">Invoices</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">Invoices</h4>
                    <div class="text-right">
                        <a href="{{ route('create.invoice') }}" class="btn btn-dark p-2">Add New Invoice</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped border-0 data-table" id="datatable">
                            <thead class="thead-light">
                                <th>#</th>
                                <th>Client Name</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price before discount</th>
                                <th>Discount</th>
                                <th>Total Price after discount</th>
                                <th>Crop</th>
                                <th>Farm</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if(isset($invoices))
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{$sn++}}</td>
                                    <td>{{$invoice->client->client_name}}</td>
                                    <td>{{$invoice->date}}</td>
                                    <td>{{$invoice->desc}}</td>
                                    <td>{{$invoice->quantity}}</td>
                                    <td>{{$invoice->unit_price}}</td>
                                    <td>{{$invoice->total_price_before_discount}}</td>
                                    <td>{{$invoice->discount}}</td>
                                    <td>{{$invoice->total_price_after_discount}}</td>
                                    <td>{{$invoice->crop->date}} - {{$invoice->crop->type_of_crop}} - {{$invoice->crop->desc}}</td>
                                    <td>{{$invoice->farm->farm_name}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('edit.invoice', $invoice->id) }}" class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
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
