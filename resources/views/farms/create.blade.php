@extends('layouts.app')
@section('content')
<div class="content container-fluid">
    @if(isset($mode) && $mode == "edit")
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('farms') }}">{{__('Farms')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Update Farm Data')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Update Farm Data')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('farms') }}" class="btn btn-dark p-2">{{__('Back to Farms')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit.farm', $farm->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$farm->id}}">
                        <div class="row mb-3">
                            <label for="farm_name" class="col-md-2 col-form-label text-md-end">{{ __('Farm Name') }}</label>
                            <div class="col-md-10">
                                <input id="farm_name" type="text" class="form-control @error('farm_name') is-invalid @enderror" name="farm_name" value="{{ $farm->farm_name }}" autocomplete="name" required autofocus>
                                @error('farm_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="farm_desc" class="col-md-2 col-form-label text-md-end">{{ __('Farm Description') }}</label>
                            <div class="col-md-10">
                                <textarea id="farm_desc" class="form-control @error('farm_desc') is-invalid @enderror" required name="farm_desc">{{ $farm->farm_desc }}</textarea>
                                @error('farm_desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="acquisition_date" class="col-md-2 col-form-label text-md-end">{{ __('Acquisition Date') }}</label>
                            <div class="col-md-10">
                                <input id="acquisition_date" type="date" class="form-control @error('acquisition_date') is-invalid @enderror" required name="acquisition_date" value="{{ $farm->acquisition_date }}" autocomplete="date">
                                @error('acquisition_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="surface" class="col-md-2 col-form-label text-md-end">{{ __('Surface') }}</label>
                            <div class="col-md-10">
                                <input id="surface" title="" type="text" class="form-control @error('surface') is-invalid @enderror" name="surface" value="{{ $farm->surface }}" required>
                                @error('surface')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-2 col-form-label text-md-end">{{ __('Amount') }}</label>
                            <div class="col-md-10">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $farm->amount }}" required>
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="latitude" class="col-md-2 col-form-label text-md-end">{{ __('Latitude') }}</label>
                            <div class="col-md-10">
                                <input id="latitude" type="" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ $farm->latitude }}" required>
                                @error('latitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="longitude" class="col-md-2 col-form-label text-md-end">{{ __('Longitude') }}</label>
                            <div class="col-md-10">
                                <input id="longitude" type="" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ $farm->longitude }}" required>
                                @error('longitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                                <button type="submit" class="btn btn-primary p-2" onclick="return confirm('Are you sure you want to submit this form?')">
                                    {{ __('Submit') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(isset($mode) && $mode == "create")
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    <ul class="breadcrumb ml-2">
                        <li class="breadcrumb-item"><a href="{{ route('farms') }}">{{__('Farms')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Create New Farm')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Create New Farm')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('farms') }}" class="btn btn-dark p-2">{{__('Back to Farms')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create.farm') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="farm_name" class="col-md-2 col-form-label text-md-end">{{ __('Farm Name') }}</label>
                            <div class="col-md-10">
                                <input id="farm_name" type="text" class="form-control @error('farm_name') is-invalid @enderror" name="farm_name" value="{{ old('farm_name') }}" autocomplete="name" required autofocus>
                                @error('farm_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="farm_desc" class="col-md-2 col-form-label text-md-end">{{ __('Farm Description') }}</label>
                            <div class="col-md-10">
                                <textarea id="farm_desc" class="form-control @error('farm_desc') is-invalid @enderror" required name="farm_desc">{{ old('farm_desc') }}</textarea>
                                @error('farm_desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="acquisition_date" class="col-md-2 col-form-label text-md-end">{{ __('Acquisition Date') }}</label>
                            <div class="col-md-10">
                                <input id="acquisition_date" type="date" class="form-control @error('acquisition_date') is-invalid @enderror" required name="acquisition_date" value="{{ old('acquisition_date') }}" autocomplete="date">
                                @error('acquisition_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="surface" class="col-md-2 col-form-label text-md-end">{{ __('Surface') }}</label>
                            <div class="col-md-10">
                                <input id="surface" title="" type="text" class="form-control @error('surface') is-invalid @enderror" name="surface" value="{{ old('surface') }}" required>
                                @error('surface')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-2 col-form-label text-md-end">{{ __('Amount') }}</label>
                            <div class="col-md-10">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required>
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="latitude" class="col-md-2 col-form-label text-md-end">{{ __('Latitude') }}</label>
                            <div class="col-md-10">
                                <input id="latitude" type="" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" required>
                                @error('latitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="longitude" class="col-md-2 col-form-label text-md-end">{{ __('Longitude') }}</label>
                            <div class="col-md-10">
                                <input id="longitude" type="" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}" required>
                                @error('longitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                                <button type="submit" class="btn btn-primary p-2" onclick="return confirm('Are you sure you want to submit this form?')">
                                    {{ __('Submit') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
