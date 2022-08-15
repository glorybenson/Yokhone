@extends('layouts.app')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                        <ul class="breadcrumb ml-2">
                            <li class="breadcrumb-item"><a href="{{ route('employees') }}">{{ __('Employees') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Employee Payment History') }}</li>
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
                        <h4 class="card-title float-left">{{ __('Employee\'s Payment History') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('employees') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Employees') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4 mobile-tab">
                            <div class="col-xm-2" style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('view.employee', $employee->id) }}"
                                        class="btn btn-light active p-2 mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">{{ $employee->first_name }}
                                        {{ $employee->last_name }}</a>
                                </div>
                            </div>

                            <div class="col-xm-2" style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('absence.employee', $employee->id) }}"
                                        class="btn btn-light active mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Absence') }}
                                    </a>
                                </div>
                            </div>

                            <div class="col-xm-2" style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('record.employee', $employee->id) }}"
                                        class="btn btn-light active mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">{{ __('Employee Record') }}</a>
                                </div>
                            </div>
                            <div class="col-xm-2" style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('salary.employee', $employee->id) }}"
                                        class="btn btn-light active mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">{{ __('Salary History') }}</a>
                                </div>
                            </div>
                            <div class="col-xm-2" style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">{{ __('Payment') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddNewPayment">
                                {{ __('Add New Payment') }}
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="AddNewPayment" tabindex="-1" aria-labelledby="AddNewPaymentLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add New Payment') }}</h5>
                                    </div>
                                    <form method="POST" action="{{ route('add.payment') }}" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                            <div class="row mb-3">
                                                <label for="amount"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Amount') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="amount" type="number" required
                                                        class="form-control @error('amount') is-invalid @enderror"
                                                        name="amount" value="{{ old('amount') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('amount')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="date"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Date of salary payment') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="date" type="date" required
                                                        class="form-control @error('date') is-invalid @enderror"
                                                        name="date" value="{{ old('date') }}"
                                                        autocomplete="first name" autofocus>

                                                    @error('date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="details"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Details') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea required class="form-control @error('details') is-invalid @enderror" name="details">{{ old('details') }}</textarea>
                                                    @error('details')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="payment_method"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Payment method') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <select
                                                        class="select form-control @error('payment_method') is-invalid @enderror"
                                                        name="payment_method" required>
                                                        <option value="">{{ __('Select Option') }}</option>
                                                        <option value="Orange money"
                                                            {{ old('payment_method') == 'Orange money' ? 'selected' : '' }}>
                                                            {{ __('Orange money') }}</option>
                                                        <option value="Cash"
                                                            {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>
                                                            {{ __('Cash') }}</option>
                                                        <option value="Wave"
                                                            {{ old('payment_method') == 'Wave' ? 'selected' : '' }}>
                                                            {{ __('Wave') }}</option>
                                                        <option value="Cheque"
                                                            {{ old('payment_method') == 'Cheque' ? 'selected' : '' }}>
                                                            {{ __('Cheque') }}</option>
                                                    </select>
                                                    @error('payment_method')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="payment_proof"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Payment proof') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="file" accept=""
                                                        class="form-control @error('payment_proof') is-invalid @enderror"
                                                        name="payment_proof" required>
                                                    @error('payment_proof')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                            <button type="submit" class="btn btn-primary"
                                                onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">{{ __('Add') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Details') }}</th>
                                        <th>{{ __('Payment Method') }}</th>
                                        <th>{{ __('Payment Proof') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($payments))
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $payment->amount }}</td>
                                                <td>{{ $payment->date }}</td>
                                                <td>{{ $payment->details }}</td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td>
                                                    <div class="documents-card d-flex mb-1" style="padding: 10px;">
                                                        <div class="documennts d-flex">
                                                            <i class="far fa-file-pdf pdf-icon"></i>
                                                            <p>{{ __('Payment Proof') }}</p>
                                                        </div>
                                                        <div class="actions d-flex">
                                                            <a download="" target="blank"
                                                                href="{{ asset('PAYMENT_PROOF/' . $payment->payment_proof) }}"><i
                                                                    class="far fa-arrow-alt-circle-down"></i></a>
                                                            <a target="blank"
                                                                href="{{ asset('PAYMENT_PROOF/' . $payment->payment_proof) }}"><i
                                                                    class="far fa-eye"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#AddNewPayment{{ $payment->id }}"
                                                        class="btn btn-sm p-2" title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a href="{{ route('destroy.payment', $payment->id) }}"
                                                        class="btn btn-sm p-2" title="Delete"><i class="fa fa-trash"
                                                            onclick="return confirm('Are you sure you want to delete this record?')"></i></a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="AddNewPayment{{ $payment->id }}" tabindex="-1"
                                                aria-labelledby="AddNewPaymentLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('Edit Payment') }}</h5>
                                                        </div>
                                                        <form method="POST" action="{{ route('add.payment') }}"
                                                            enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $payment->id }}">
                                                                <input type="hidden" name="employee_id"
                                                                    value="{{ $employee->id }}">
                                                                <div class="row mb-3">
                                                                    <label for="amount"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Amount') }}</label>
                                                                    <div class="col-md-8">
                                                                        <input id="amount" type="number" required
                                                                            class="form-control @error('amount') is-invalid @enderror"
                                                                            name="amount" value="{{ $payment->amount }}"
                                                                            autocomplete="first name" autofocus>
                                                                        @error('amount')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="date"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Date of salary payment') }}</label>
                                                                    <div class="col-md-8">
                                                                        <input id="date" type="date" required
                                                                            class="form-control @error('date') is-invalid @enderror"
                                                                            name="date" value="{{ $payment->date }}"
                                                                            autocomplete="first name" autofocus>

                                                                        @error('date')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="details"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Details') }}</label>
                                                                    <div class="col-md-8">
                                                                        <textarea required class="form-control @error('details') is-invalid @enderror" name="details">{{ $payment->details }}</textarea>
                                                                        @error('details')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="payment_method"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Payment method') }}</label>
                                                                    <div class="col-md-8">
                                                                        <select
                                                                            class="select form-control @error('payment_method') is-invalid @enderror"
                                                                            name="payment_method" required>
                                                                            <option value="">
                                                                                {{ __('Select Option') }}</option>
                                                                            <option value="Orange money"
                                                                                {{ $payment->payment_method == 'Orange money' ? 'selected' : '' }}>
                                                                                {{ __('Orange money') }}</option>
                                                                            <option value="Cash"
                                                                                {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>
                                                                                {{ __('Cash') }}</option>
                                                                            <option value="Wave"
                                                                                {{ $payment->payment_method == 'Wave' ? 'selected' : '' }}>
                                                                                {{ __('Wave') }}</option>
                                                                            <option value="Cheque"
                                                                                {{ $payment->payment_method == 'Cheque' ? 'selected' : '' }}>
                                                                                {{ __('Cheque') }}</option>
                                                                        </select>
                                                                        @error('payment_method')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="payment_proof"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Payment proof') }}</label>
                                                                    <div class="col-md-8">
                                                                        <div class="input-group">
                                                                            <input type="file" accept=""
                                                                                class="form-control @error('payment_proof') is-invalid @enderror"
                                                                                name="payment_proof">
                                                                            <span class="input-group-btn">
                                                                                <a target="blank"
                                                                                    href="{{ asset('PAYMENT_PROOF/' . $payment->payment_proof) }}"
                                                                                    class="btn btn-dark" type="button"><i
                                                                                        class="far fa-eye"></i></a>
                                                                            </span>
                                                                            @error('payment_proof')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    {{ __('Close') }}</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('{{ __('Are you sure you want to submit this form?') }}')">{{ __('Update') }}</button>
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
