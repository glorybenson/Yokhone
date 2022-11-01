@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item active">{{ __('Employees') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Employees') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('create.employee') }}"
                                class="btn btn-dark p-2">{{ __('Add New Employee') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead class="thead-light">
                                    <th>ID</th>
                                    <th>{{ __('First Name') }}</th>
                                    <th>{{ __('Last Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Cell 1 #') }}</th>
                                    <th>{{ __('Hiring Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </thead>
                                <tbody>
                                    @if (isset($employees))
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $employee->first_name }}</td>
                                                <td>{{ $employee->last_name }}</td>
                                                <td>{{ $employee->email }}</td>
                                                <td>{{ $employee->cell_1 }}</td>
                                                <td>{{ $employee->hiring_date ?? '' }}</td>
                                                <td>{{ $employee->end_date ?? '' }}</td>
                                                <td>
                                                    <a href="{{ route('edit.employee', $employee->id) }}"
                                                        class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('view.employee', $employee->id) }}"
                                                        class="btn btn-sm p-2" title="View"><i class="fa fa-eye"></i></a>
                                                    <a href="{{ route('destroy.employee', $employee->id) }}"
                                                        class="btn btn-sm p-2" title="Delete"><i class="fa fa-trash"
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}')"></i></a>
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
