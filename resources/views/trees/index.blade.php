@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item"><a href="{{ route('farms') }}">{{ __('Farms') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Trees') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Trees') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('create.tree') }}" class="btn btn-dark p-2">{{ __('Add New Tree') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead class="thead-light">
                                    <th>#</th>
                                    <th>{{ __('Farm Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Quality') }}</th>
                                    <th>{{ __('Date Planted') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </thead>
                                <tbody>
                                    @if (isset($trees))
                                        @foreach ($trees as $tree)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $tree->farm->farm_name }}</td>
                                                <td>{{ $tree->desc }}</td>
                                                <td>{{ $tree->reason }}</td>
                                                <td>{{ $tree->quantity }}</td>
                                                <td>{{ $tree->date_planted }}</td>
                                                <td>
                                                    <a href="{{ route('edit.tree', $tree->id) }}" class="btn btn-sm p-2"
                                                        title="Edit"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            @if (isset($users))
                                {!! $users->links('pagination::bootstrap-4') !!}
                            @endif
                        </div>
                        <!-- @if (session('status'))
    <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
    @endif

                                {{ __('You are logged in!') }} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
