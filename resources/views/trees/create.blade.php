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
                        <li class="breadcrumb-item"><a href="{{ route('trees') }}">{{__('Trees')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Update Tree Data')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Update Tree Data')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('trees') }}" class="btn btn-dark p-2">{{__('Back to Trees')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit.tree', $tree->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$tree->id}}">
                        <div class="row mb-3">
                            <label for="farm_id" class="col-md-2 col-form-label text-md-end">{{ __('Farm Name') }}</label>
                            <div class="col-md-10">
                                <select id="farm_id" class="select form-control @error('farm_id') is-invalid @enderror" name="farm_id" required>
                                    <option value="">{{__('Select Farm')}}</option>
                                    @if(isset($farms))
                                    @foreach($farms as $farm)
                                    <option value="{{$farm->id}}" {{ $tree->farm_id == $farm->id ? 'selected' : '' }}>{{$farm->farm_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('farm_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" required name="desc">{{ $tree->desc }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="reason" class="col-md-2 col-form-label text-md-end">{{ __('Reason') }}</label>
                            <div class="col-md-10">
                                <select id="reason" class="select form-control @error('reason') is-invalid @enderror" name="reason" required>
                                    <option value="">Select Reason</option>
                                    <option value="Plantation" {{ $tree->reason == "Plantation" ? 'selected' : '' }}>Plantation</option>
                                    <option value="Death" {{ $tree->reason == "Death" ? 'selected' : '' }}>Death</option>
                                </select>
                                @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="quantity" class="col-md-2 col-form-label text-md-end">{{ __('Quantity') }}</label>
                            <div class="col-md-10">
                                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" required name="quantity" value="{{ $tree->quantity }}" autocomplete="date">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_planted" class="col-md-2 col-form-label text-md-end">{{ __('Date Planted') }}</label>
                            <div class="col-md-10">
                                <input id="date_planted" type="date" class="form-control @error('date_planted') is-invalid @enderror" name="date_planted" value="{{ $tree->date_planted }}" required>
                                @error('date_planted')
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
                        <li class="breadcrumb-item"><a href="{{ route('trees') }}">{{__('Trees')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Create New Tree')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Create New Tree')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('trees') }}" class="btn btn-dark p-2">{{__('Back to Trees')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create.tree') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="farm_id" class="col-md-2 col-form-label text-md-end">{{ __('Farm Name') }}</label>
                            <div class="col-md-10">
                                <select id="farm_id" class="select @error('farm_id') is-invalid @enderror" name="farm_id" required>
                                    <option value="">{{__('Select Farm')}}</option>
                                    @if(isset($farms))
                                    @foreach($farms as $farm)
                                    <option value="{{$farm->id}}" {{ old('farm_id') == $farm->id ? 'selected' : '' }}>{{$farm->farm_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('farm_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" required name="desc">{{ old('desc') }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="reason" class="col-md-2 col-form-label text-md-end">{{ __('Reason') }}</label>
                            <div class="col-md-10">
                                <select id="reason" class="form-control select @error('reason') is-invalid @enderror" name="reason" required>
                                    <option value="">Select Reason</option>
                                    <option value="Plantation" {{ old('reason') == "Plantation" ? 'selected' : '' }}>Plantation</option>
                                    <option value="Death" {{ old('reason') == "Death" ? 'selected' : '' }}>Death</option>
                                </select>
                                @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="quantity" class="col-md-2 col-form-label text-md-end">{{ __('Quantity') }}</label>
                            <div class="col-md-10">
                                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" required name="quantity" value="{{ old('quantity') }}" autocomplete="date">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_planted" class="col-md-2 col-form-label text-md-end">{{ __('Date Planted') }}</label>
                            <div class="col-md-10">
                                <input id="date_planted" type="date" class="form-control @error('date_planted') is-invalid @enderror" name="date_planted" value="{{ old('date_planted') }}" required>
                                @error('date_planted')
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
