@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item active">{{ __('Farms') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Farms') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('create.farm') }}" class="btn btn-dark p-2">{{ __('Add New Farm') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead class="thead-light">
                                    <th>#</th>
                                    <th>{{ __('Farm Name') }}</th>
                                    <th>{{ __('Farm Description') }}</th>
                                    <th>{{ __('Acquisition Date') }}</th>
                                    <th>{{ __('Surface') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Latitude') }}</th>
                                    <th>{{ __('Longitude') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </thead>
                                <tbody>
                                    @if (isset($farms))
                                        @foreach ($farms as $farm)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $farm->farm_name }}</td>
                                                <td>{{ $farm->farm_desc }}</td>
                                                <td>{{ $farm->acquisition_date }}</td>
                                                <td>{{ $farm->surface }}</td>
                                                <td>{{ $farm->amount }}</td>
                                                <td>{{ $farm->latitude }}</td>
                                                <td>{{ $farm->longitude }}</td>
                                                <td>
                                                    <a href="{{ route('edit.farm', $farm->id) }}" class="btn btn-sm p-2"
                                                        title="Edit"><i class="fa fa-edit"></i></a>
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
