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
                        <li class="breadcrumb-item"><a href="{{ route('clients') }}">{{__('Clients')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Update Client Data')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">Update Client Data</h4>
                    <div class="text-right">
                        <a href="{{ route('clients') }}" class="btn btn-dark p-2">Back to Clients</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit.client', $client->id) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$client->id}}">
                        <div class="row mb-3">
                            <label for="client_name" class="col-md-2 col-form-label text-md-end">{{ __('Client Name') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="client_name" type="text" class="form-control @error('client_name') is-invalid @enderror" name="client_name" value="{{ $client->client_name }}" autocomplete="name" required>
                                @error('client_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="full_address" class="col-md-2 col-form-label text-md-end">{{ __('Full Address') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <textarea id="full_address" class="form-control @error('full_address') is-invalid @enderror" required name="full_address">{{ $client->full_address }}</textarea>
                                @error('full_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_full_name" class="col-md-2 col-form-label text-md-end">{{ __('Contact Full Name') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="contact_full_name" type="text" class="form-control @error('contact_full_name') is-invalid @enderror" required name="contact_full_name" value="{{ $client->contact_full_name }}" autocomplete="date">
                                @error('contact_full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_phone" class="col-md-2 col-form-label text-md-end">{{ __('Contact Phone') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="contact_phone" type="number" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ $client->contact_phone }}" required>
                                @error('contact_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_email" class="col-md-2 col-form-label text-md-end">{{ __('Contact Email') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ $client->contact_email }}" required>
                                @error('contact_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_become_client" class="col-md-2 col-form-label text-md-end">{{ __('Date Become Client') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="date_become_client" type="date" class="form-control @error('date_become_client') is-invalid @enderror" name="date_become_client" value="{{ $client->date_become_client }}" required>
                                @error('date_become_client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="referred_by" class="col-md-2 col-form-label text-md-end">{{ __('Referred By') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <select class="select @error('referred_by') is-invalid @enderror" onchange="referred(this.value)" id="referred_by_id" name="referred_by">
                                    <option value="">{{ __('Select an option') }}</option>
                                    <option value="employee" {{ $client->referred_by == 'employee' ? 'selected' : '' }}>{{ __('Employee') }}</option>
                                    <option value="other" {{ $client->referred_by == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                                @error('referred_by')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="employee" class="col-md-2 col-form-label text-md-end"></label>
                            <div class="col-md-10 mb-3" id="employee_div" style="display: none;">
                                <select class="select @error('employee') is-invalid @enderror" name="employee">
                                    <option value="">Select an Employee</option>
                                    @if(isset($employees))
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" {{ $client->employee_id == $employee->id ? 'selected' : '' }}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('employee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="note" class="col-md-2 col-form-label text-md-end"></label>
                            <div class="col-md-10 mb-3" id="other_div" style="display: none;">
                                <textarea id="note" class="form-control @error('note') is-invalid @enderror" placeholder="Write a shot note here..." name="note">{{ $client->note }}</textarea>
                                @error('note')
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
                        <li class="breadcrumb-item"><a href="{{ route('clients') }}">{{__('Clients')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Create New Client')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">{{__('Create New Client')}}</h4>
                    <div class="text-right">
                        <a href="{{ route('clients') }}" class="btn btn-dark p-2">{{__('Back to Clients')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create.client') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="client_name" class="col-md-2 col-form-label text-md-end">{{ __('Client Name') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="client_name" type="text" class="form-control @error('client_name') is-invalid @enderror" name="client_name" value="{{ old('client_name') }}" autocomplete="name" required>
                                @error('client_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="full_address" class="col-md-2 col-form-label text-md-end">{{ __('Full Address') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <textarea id="full_address" class="form-control @error('full_address') is-invalid @enderror" required name="full_address">{{ old('full_address') }}</textarea>
                                @error('full_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_full_name" class="col-md-2 col-form-label text-md-end">{{ __('Contact Full Name') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="contact_full_name" type="text" class="form-control @error('contact_full_name') is-invalid @enderror" required name="contact_full_name" value="{{ old('contact_full_name') }}" autocomplete="date">
                                @error('contact_full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_phone" class="col-md-2 col-form-label text-md-end">{{ __('Contact Phone') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="contact_phone" type="number" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone') }}" required>
                                @error('contact_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_email" class="col-md-2 col-form-label text-md-end">{{ __('Contact Email') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email') }}" required>
                                @error('contact_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_become_client" class="col-md-2 col-form-label text-md-end">{{ __('Date Become Client') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <input id="date_become_client" type="date" class="form-control @error('date_become_client') is-invalid @enderror" name="date_become_client" value="{{ old('date_become_client') }}" required>
                                @error('date_become_client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="referred_by" class="col-md-2 col-form-label text-md-end">{{ __('Referred By') }}<span style="color:#ff0000">*</span></label>
                            <div class="col-md-10">
                                <select class="select @error('referred_by') is-invalid @enderror" onchange="referred(this.value)" id="referred_by_id" name="referred_by">
                                    <option value="">{{ __('Select an option') }}</option>
                                    <option value="employee" {{ old('referred_by') == 'employee' ? 'selected' : '' }}>{{ __('Employee') }}</option>
                                    <option value="other" {{ old('referred_by') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                                @error('referred_by')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="employee" class="col-md-2 col-form-label text-md-end"></label>
                            <div class="col-md-10 mb-3" id="employee_div" style="display: none;">
                                <select class="select @error('employee') is-invalid @enderror" name="employee">
                                    <option value="">{{ __('Select an Employee') }}</option>
                                    @if(isset($employees))
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}" {{ old('employee') == $employee->id ? 'selected' : '' }}>{{$employee->first_name}} {{$employee->last_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('employee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="note" class="col-md-2 col-form-label text-md-end"></label>
                            <div class="col-md-10 mb-3" id="other_div" style="display: none;">
                                <textarea id="note" class="form-control @error('note') is-invalid @enderror" placeholder="Write a shot note here..." name="note">{{ old('note') }}</textarea>
                                @error('note')
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

<script type="text/javascript">
    function referred(id) {
        switch (id) {
            case "employee":
                document.getElementById('employee_div').style.display = 'block';
                document.getElementById('other_div').style.display = 'none';
                break;

            case "other":
                document.getElementById('other_div').style.display = 'block';
                document.getElementById('employee_div').style.display = 'none';
                break;

            default:
                document.getElementById('other_div').style.display = 'none';
                document.getElementById('employee_div').style.display = 'none';
                break;
        }

    }
    document.onreadystatechange = function() {
        referred_by_id = document.getElementById('referred_by_id').value
        referred(referred_by_id)
    }
    window.onload = referred(id);
</script>
@endsection
