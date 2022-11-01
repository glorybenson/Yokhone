@extends('layouts.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">{{__('Inventories')}}
                        </a></li>
                        <li class="breadcrumb-item active">{{__('Update Inventory')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Edit Inventory')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('inventory.index') }}" class="btn btn-dark p-2">{{__('Back to Inventories')}}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('inventory.update', $inventory->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label for="immatriculation_number" class="col-md-2 col-form-label text-md-end">{{ __('Immatriculation Number') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="immatriculation_number" type="text" class="form-control @error('immatriculation_number') is-invalid @enderror" name="immatriculation_number" value="{{ $inventory->immatriculation_number }}" autocomplete="first name" required2 autofocus>
                                @error('immatriculation_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_of_acquisition" class="col-md-2 col-form-label text-md-end">{{ __('Date of Acquisition') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="date_of_acquisition" type="date" class="form-control @error('date_of_acquisition') is-invalid @enderror" name="date_of_acquisition" value="{{ $inventory->date_of_acquisition }}" autocomplete="last name" required2 autofocus>
                                @error('date_of_acquisition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="acquisition_cost" class="col-md-2 col-form-label text-md-end">{{ __('Acquisition cost') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="acquisition_cost" type="number" class="form-control @error('acquisition_cost') is-invalid @enderror" required2 name="acquisition_cost" value="{{ $inventory->acquisition_cost }}">
                                @error('acquisition_cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="millage_on_acquisition" class="col-md-2 col-form-label text-md-end">{{ __('Millage on Acquisition') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="millage_on_acquisition" type="number" class="form-control @error('millage_on_acquisition') is-invalid @enderror" required2 name="millage_on_acquisition" value="{{ $inventory->millage_on_acquisition }}">
                                @error('millage_on_acquisition')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="make" class="col-md-2 col-form-label text-md-end">{{ __('Make') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="make" type="text" class="form-control @error('make') is-invalid @enderror" name="make" value="{{ $inventory->make }}" required2>
                                @error('make')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="model" class="col-md-2 col-form-label text-md-end">{{ __('Model') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="model" type="text" class="form-control @error('model') is-invalid @enderror" name="model" value="{{ $inventory->model }}" required2>
                                @error('model')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="serie" class="col-md-2 col-form-label text-md-end">{{ __('Serie') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="serie" type="text" class="form-control @error('serie') is-invalid @enderror" name="serie" value="{{ $inventory->serie }}" required2>
                                @error('serie')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="year" class="col-md-2 col-form-label text-md-end">{{ __('Year') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="date" type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ $inventory->year }}">
                                @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary p-3" onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
