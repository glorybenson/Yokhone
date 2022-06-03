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
                        <li class="breadcrumb-item">{{__('Finance')}}</li>
                        <li class="breadcrumb-item"><a href="{{ route('invoices') }}">{{__('Invoice')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Update Invoice')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Update Invoice Data')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('invoices') }}" class="btn btn-dark p-2">{{__('Back to Invoices')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit.invoice',  $invoice->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $invoice->id }}">
                        <div class="row">
                            <label for="client_name" class="col-md-2 col-form-label text-md-end">{{__('Client Name')}}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10 mb-3">
                                <select class="form-control select @error('client_name') is-invalid @enderror" name="client_name" required>
                                    <option value="">{{__('Select a Client')}}</option>
                                    @if(isset($clients))
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>{{$client->client_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('client_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date" class="col-md-2 col-form-label text-md-end">{{ __('Date') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" required name="date" value="{{ $invoice->date }}">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="desc" required>{{ $invoice->desc }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="quantity" class="col-md-2 col-form-label text-md-end">{{ __('Quantity') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="quantity" type="number" oninput="firstFunction()" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ $invoice->quantity }}" autocomplete="" required>
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="unit_price" class="col-md-2 col-form-label text-md-end">{{ __('Unit Price') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="unit_price" type="number" oninput="firstFunction()" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" value="{{ $invoice->unit_price }}" autocomplete="date" required>
                                @error('unit_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="total_price_before_discount" class="col-md-2 col-form-label text-md-end">{{ __('Total Price before discount') }}</label>
                            <div class="col-md-10">
                                <input id="total_price_before_discount" type="number" readonly class="form-control @error('total_price_before_discount') is-invalid @enderror">
                                @error('total_price_before_discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="discount" class="col-md-2 col-form-label text-md-end">{{ __('Discount') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="discount" type="number" oninput="secondFunction()" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ $invoice->discount }}" autocomplete="date" required>
                                @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="total_price_after_discount" class="col-md-2 col-form-label text-md-end">{{ __('Total Price after discount') }}</label>
                            <div class="col-md-10">
                                <input id="total_price_after_discount" type="number" readonly class="form-control @error('total_price_after_discount') is-invalid @enderror">
                                @error('total_price_after_discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="row">
                            <label for="crop" class="col-md-2 col-form-label text-md-end">{{__('Crop')}}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10 mb-3">
                                <select onchange="loadFarm(this, '{{csrf_token()}}')" id="crop_id" class="form-control select @error('crop') is-invalid @enderror" name="crop" required>
                                    <option value="">Select an crop</option>
                                    @if(isset($crops))
                                    @foreach($crops as $crop)
                                    <option value="{{$crop->id}}" {{ $invoice->crop_id == $crop->id ? 'selected' : '' }}>{{$crop->date}} - {{$crop->type_of_crop}} - {{$crop->desc}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('crop')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="farm" class="col-md-2 col-form-label text-md-end">{{__('Farm')}}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10 mb-3">
                                <input readonly type="hidden" id="farm_id" name="farm" value="{{ $invoice->farm }}" class="form-control" placeholder="Farm ID" required>
                                <input readonly type="text" id="farm_value" class="form-control" placeholder="Farm Name">
                                @error('farm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary p-2" onclick="return confirm('{{__('Are you sure you want to submit this form?')}}')">
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
                        <li class="breadcrumb-item">{{__('Finance')}}</li>
                        <li class="breadcrumb-item"><a hrer="{{ route('invoices') }}">{{__('Invoices')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Create New Invoice')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Create Invoice')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('invoices') }}" class="btn btn-dark p-2">{{__('Back to Invoices')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create.invoice') }}">
                        @csrf
                        <div class="row">
                            <label for="client_name" class="col-md-2 col-form-label text-md-end">{{__('Client Name')}}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10 mb-3">
                                <select class="form-control select @error('client_name') is-invalid @enderror" name="client_name" required>
                                    <option value="">{{__('Select a Client')}}</option>
                                    @if(isset($clients))
                                    @foreach($clients as $client)
                                    <option value="{{$client->id}}" {{ old('client_name') == $client->id ? 'selected' : '' }}>{{$client->client_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('client_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date" class="col-md-2 col-form-label text-md-end">{{ __('Date') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="desc" class="col-md-2 col-form-label text-md-end">{{ __('Description') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <textarea id="desc" class="form-control @error('desc') is-invalid @enderror" name="desc" required>{{ old('desc') }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="quantity" class="col-md-2 col-form-label text-md-end">{{ __('Quantity') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="quantity" type="number" oninput="firstFunction()" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" autocomplete="" required>
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="unit_price" class="col-md-2 col-form-label text-md-end">{{ __('Unit Price') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="unit_price" type="number" oninput="firstFunction()" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" value="{{ old('unit_price') }}" required>
                                @error('unit_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="total_price_before_discount" class="col-md-2 col-form-label text-md-end">{{ __('Total Price before discount') }}</label>
                            <div class="col-md-10">
                                <input id="total_price_before_discount" type="number" readonly class="form-control @error('total_price_before_discount') is-invalid @enderror">
                                @error('total_price_before_discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="discount" class="col-md-2 col-form-label text-md-end">{{ __('Discount') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="discount" type="number" oninput="secondFunction()" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') }}" required>
                                @error('discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="total_price_after_discount" class="col-md-2 col-form-label text-md-end">{{ __('Total Price after discount') }}</label>
                            <div class="col-md-10">
                                <input id="total_price_after_discount" type="number" readonly class="form-control @error('total_price_after_discount') is-invalid @enderror">
                                @error('total_price_after_discount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="crop" class="col-md-2 col-form-label text-md-end">{{__('Crop')}}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10 mb-3">
                                <select onchange="loadFarm(this, '{{csrf_token()}}')" id="crop_id" class="form-control select @error('crop') is-invalid @enderror" name="crop" required>
                                    <option value="">{{__('Select a crop')}}</option>
                                    @if(isset($crops))
                                    @foreach($crops as $crop)
                                    <option value="{{$crop->id}}" {{ old('crop') == $crop->id ? 'selected' : '' }}>{{$crop->date}} - {{$crop->type_of_crop}} - {{$crop->desc}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('crop')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="farm" class="col-md-2 col-form-label text-md-end">{{__('Farm')}}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10 mb-3">
                                <input readonly type="hidden" id="farm_id" name="farm" value="{{old('farm')}}" class="form-control" placeholder="Farm ID" required>
                                <input readonly type="text" id="farm_value" class="form-control" placeholder="Farm Name">
                                @error('farm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary p-2" onclick="return confirm('{{__('Are you sure you want to submit this form?')}}')">
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

<script type="text/javascript">
    function loadFarm(data, token) {
        if (data.value != '') {
            $.ajax({
                url: "{{ route('get.crop.farm') }}",
                type: "POST",
                data: {
                    _token: token,
                    crop_id: data.value
                },
                success: function(data) {
                    if (data.status) {
                        document.getElementById('farm_id').value = data.farm_id
                        document.getElementById('farm_value').value = data.farm_name
                    } else {
                        document.getElementById('farm_id').value = ''
                        document.getElementById('farm_value').value = ''
                    }
                },
            });
        } else {
            document.getElementById('farm_id').value = ''
            document.getElementById('farm_value').value = ''
        }
    }

    function firstFunction() {
        quantity = document.getElementById('quantity').value
        unit = document.getElementById('unit_price').value
        if (quantity >= 0 && unit >= 0) {
            document.getElementById('total_price_before_discount').value = quantity * unit
        } else {
            document.getElementById('total_price_before_discount').value = 0
        }
    }

    function secondFunction() {
        discount = document.getElementById('discount').value
        before_discount = document.getElementById('total_price_before_discount').value
        if (discount >= 0 && before_discount >= 0) {
            document.getElementById('total_price_after_discount').value = before_discount - discount
        } else {
            document.getElementById('total_price_after_discount').value = 0
        }
    }

    document.onreadystatechange = function() {
        data = document.getElementById('crop_id')
        loadFarm(data, '{{csrf_token()}}')
        firstFunction()
        secondFunction()
    }
</script>
@endsection
