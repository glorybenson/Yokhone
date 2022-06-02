@extends('layouts.app')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{__('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('farms') }}">{{__('Farms')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Crops') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Crops')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('create.crop') }}" class="btn btn-dark p-2">{{__('Add New Crop')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-striped border-0 data-table" id="datatable">
                            <thead class="thead-light">
                                <th>#</th>
                                <th>{{__('Farm Name')}}</th>
                                <th>{{__('Type Of Crop')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Weight')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                                @if(isset($crops))
                                @foreach($crops as $crop)
                                <tr>
                                    <td>{{$sn++}}</td>
                                    <td>{{$crop->farm->farm_name}}</td>
                                    <td>{{$crop->type_of_crop}}</td>
                                    <td>{{$crop->desc}}</td>
                                    <td>{{$crop->quantity}}</td>
                                    <td>{{$crop->weight}}</td>
                                    <td>{{$crop->date}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('edit.crop', $crop->id) }}" class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
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
