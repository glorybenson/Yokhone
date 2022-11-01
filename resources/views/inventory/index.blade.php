@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item active">{{ __('Inventories') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Inventories') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('inventory.create') }}"
                                class="btn btn-dark p-2">{{ __('Add New Inventory') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead class="thead-light">
                                    <th>ID</th>
                                    <th>{{ __('Immatriculation Number') }}</th>
                                    <th>{{ __('Date of Acquisition') }}</th>
                                    <th>{{ __('Acquisition cost') }}</th>
                                    <th>{{ __('Millage on Acquisition') }}</th>
                                    <th>{{ __('Make') }}</th>
                                    <th>{{ __('Model') }}</th>
                                    <th>{{ __('Serie') }}</th>
                                    <th>{{ __('Year') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </thead>
                                <tbody>
                                    @if (isset($inventories))
                                        @foreach ($inventories as $inventory)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $inventory->immatriculation_number }}</td>
                                                <td>{{ $inventory->date_of_acquisition }}</td>
                                                <td>{{ $inventory->acquisition_cost }}</td>
                                                <td>{{ $inventory->millage_on_acquisition }}</td>
                                                <td>{{ $inventory->make }}</td>
                                                <td>{{ $inventory->model }}</td>
                                                <td>{{ $inventory->serie }}</td>
                                                <td>{{ $inventory->year }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('inventory.edit', $inventory->id) }}"
                                                            class="btn btn-sm p-2" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('inventory.show', $inventory->id) }}"
                                                            class="btn btn-sm p-2" title="View"><i class="fa fa-eye"></i></a>
                                                            <form action="{{ route('inventory.destroy' , $inventory->id)}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm p-2" onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}')" title="Delete"><i class="fa fa-trash"></i></button>
                                                            </form>
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
