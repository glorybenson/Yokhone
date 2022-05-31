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
                        <li class="breadcrumb-item"><a href="{{ route('crops') }}">{{__('Crops')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Update Crop Data')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{('Update Crop Data')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('crops') }}" class="btn btn-dark p-2">{{__('Back to Crop')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit.crop', $crop->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$crop->id}}">
                        <div class="row mb-3">
                            <label for="farm_id" class="col-md-2 col-form-label text-md-end">{{ __('Farm Name') }}</label>
                            <div class="col-md-10">
                                <select id="farm_id" class="form-control @error('farm_id') is-invalid @enderror" name="farm_id" required>
                                    <option value="">Select Farm</option>
                                    @if(isset($farms))
                                    @foreach($farms as $farm)
                                    <option value="{{$farm->id}}" {{ $crop->farm_id == $farm->id ? 'selected' : '' }}>{{$farm->farm_name}}</option>
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
                            <label for="type_of_crop" class="col-md-2 col-form-label text-md-end">{{ __('Type Of Crop') }}</label>
                            <div class="col-md-10">
                                <select id="type_of_crop" class="form-control select @error('type_of_crop') is-invalid @enderror" name="type_of_crop" required>
                                    <option value="">Select Type</option>
                                    <option value="Fruits" {{ $crop->type_of_crop == "Fruits" ? 'selected' : '' }}>Fruits</option>
                                    <option value="Vegetables" {{ $crop->type_of_crop == "Vegetables" ? 'selected' : '' }}>Vegetables</option>
                                </select>
                                @error('type_of_crop')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <select id="desc" class="select @error('desc') is-invalid @enderror" name="desc" required>
                                    <option value="">{{('Select Description')}}</option>
                                    @if(isset($trees))
                                    @foreach($trees as $tree)
                                    <option value="{{$tree->desc}}" {{ $crop->desc == $tree->desc ? 'selected' : '' }}>{{$tree->desc}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="quantity" class="col-md-2 col-form-label text-md-end">{{ __('Quantity') }}</label>
                            <div class="col-md-10">
                                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" required name="quantity" value="{{ $crop->quantity }}" autocomplete="date">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="weight" class="col-md-2 col-form-label text-md-end">{{ __('Weight') }}</label>
                            <div class="col-md-10">
                                <select id="weight" class="form-control select @error('weight') is-invalid @enderror" name="weight" required>
                                    <option value="">Select Type</option>
                                    <option value="KG" {{ $crop->weight == "KG" ? 'selected' : '' }}>KG</option>
                                    <option value="Gr" {{ $crop->weight == "Gr" ? 'selected' : '' }}>Gr</option>
                                    <option value="To" {{ $crop->weight == "To" ? 'selected' : '' }}>To</option>
                                </select>
                                @error('weight')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date" class="col-md-2 col-form-label text-md-end">{{ __('Date Of Crop') }}</label>
                            <div class="col-md-10">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ $crop->date }}" required>
                                @error('date')
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
                        <li class="breadcrumb-item"><a href="{{ route('farms') }}">Farms</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('crops') }}">Crops</a></li>
                        <li class="breadcrumb-item active">Create New Crop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Create New Crop')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('crops') }}" class="btn btn-dark p-2">{{__('Back to Crops')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create.crop') }}">
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
                            <label for="type_of_crop" class="col-md-2 col-form-label text-md-end">{{ __('Type Of Crop') }}</label>
                            <div class="col-md-10">
                                <select id="type_of_crop" class="form-control select @error('type_of_crop') is-invalid @enderror" name="type_of_crop" required>
                                    <option value="">{{__('Select Type')}}</option>
                                    <option value="Fruits" {{ old('type_of_crop') == "Fruits" ? 'selected' : '' }}>
                                        {{__('Fruits')}}</option>
                                    <option value="Vegetables" {{ old('type_of_crop') == "Vegetables" ? 'selected' : '' }}>
                                        {{__('Vegetables')}}</option>
                                </select>
                                @error('type_of_crop')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}</label>
                            <div class="col-md-10">
                                <select id="desc" class="select @error('desc') is-invalid @enderror" name="desc" required>
                                    <option value="">{{__('Select Description')}}</option>
                                    @if(isset($trees))
                                    @foreach($trees as $tree)
                                    <option value="{{$tree->desc}}" {{ old('desc') == $tree->desc ? 'selected' : '' }}>{{$tree->desc}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('desc')
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
                            <label for="weight" class="col-md-2 col-form-label text-md-end">{{ __('Weight') }}</label>
                            <div class="col-md-10">
                                <select id="weight" class="form-control select @error('weight') is-invalid @enderror" name="weight" required>
                                    <option value="">{{__('Select Type')}}</option>
                                    <option value="KG" {{ old('weight') == "KG" ? 'selected' : '' }}>KG</option>
                                    <option value="Gr" {{ old('weight') == "Gr" ? 'selected' : '' }}>Gr</option>
                                    <option value="To" {{ old('weight') == "To" ? 'selected' : '' }}>To</option>
                                </select>
                                @error('weight')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date" class="col-md-2 col-form-label text-md-end">{{ __('Date Of Crop') }}</label>
                            <div class="col-md-10">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required>
                                @error('date')
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
