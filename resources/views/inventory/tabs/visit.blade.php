@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">{{ __('Inventories') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Technical visit') }}</li>
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
                        <h4 class="card-title float-left">{{ __('Technical visit') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('inventory.index') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Inventories') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('inventory.tabs.index')
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddNewvisit">
                                {{ __('Add Technical visit') }}
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="AddNewvisit" tabindex="-1" aria-labelledby="AddNewvisitLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Technical visit') }}</h5>
                                    </div>
                                    <form method="POST" action="{{ route('visit.store') }}">
                                        <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="row mb-3">
                                                <label for="date_of_visit"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date of visit') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="date_of_visit" type="date" required2
                                                        class="form-control @error('date_of_visit') is-invalid @enderror"
                                                        name="date_of_visit" value="{{ old('date_of_visit') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('date_of_visit')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="visit_expiration"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Visit expiration date') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="visit_expiration" type="date" required2
                                                        class="form-control @error('visit_expiration') is-invalid @enderror"
                                                        name="visit_expiration" value="{{ old('visit_expiration') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('visit_expiration')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>        
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                {{ __('Close') }}
                                            </button>
                                            <button type="submit" class="btn btn-primary"
                                                onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                                {{ __('Add') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Date of visit') }}</th>
                                        <th>{{ __('Visit expiration date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($visit_array))
                                        @foreach ($visit_array as $visit)
                                            <tr>
                                                <td>{{ $sn++ }}</td>                                
                                                <td>{{ $visit->date_of_visit }}</td>
                                                <td>{{ $visit->visit_expiration }}</td>
                                                <td>
                                                   <div class="d-flex">
                                                    <a data-bs-toggle="modal"
                                                    data-bs-target="#EditRecord{{ $visit->id }}"
                                                    class="btn btn-sm p-2" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                        <form action="{{ route('visit.destroy') }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id" value="{{$visit->id}}">
                                                            <input type="hidden" name="inventory_id" value="{{$inventory->id}}">
                                                            <button type="submit" class="btn btn-sm p-2" onclick="return confirm('{{ __('Are you sure you want to delete this record?') }}')" title="Delete"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                   </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="EditRecord{{ $visit->id }}" tabindex="-1"
                                                aria-labelledby="AddNewSuityyu7" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('Edit visit') }}</h5>
                                                        </div>
                                                        <form method="POST" action="{{ route('visit.store') }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $visit->id }}">
                                                            <input type="hidden" name="inventory_id"
                                                                value="{{ $inventory->id }}">

                                                            <div class="modal-body">
                                                                @csrf
                                                                

                                                                <div class="row mb-3">
                                                                    <label for="date_of_visit"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Date of visit') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="date_of_visit" type="date" required2
                                                                            class="form-control @error('date_of_visit') is-invalid @enderror"
                                                                            name="date_of_visit"
                                                                            value="{{ $visit->date_of_visit }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('date_of_visit')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="visit_expiration"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Visit expiration date') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="visit_expiration" type="date" required2
                                                                            class="form-control @error('visit_expiration') is-invalid @enderror"
                                                                            name="visit_expiration"
                                                                            value="{{ $visit->visit_expiration }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('visit_expiration')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                

                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    {{ __('Close') }}</button>
                                                                <button type="submit" class="btn btn-success"
                                                                    onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                                                    {{ __('Update') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
