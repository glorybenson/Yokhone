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
                            <li class="breadcrumb-item active">{{ __('Absence') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Absence') }}</h4>
                        <div class="text-right">
                            <a href="{{ route('employees') }}"
                                class="btn btn-outline-dark p-2">{{ __('Back to Employees') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-2">
                                <div class="text-center">
                                    <a href="{{ route('view.employee', $employee->id) }}" class="btn btn-light active p-2"
                                        style="border-radius: 18px 18px 0px 0px;">{{ $employee->first_name }}
                                        {{ $employee->last_name }}</a>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary" style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Absence') }}
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="text-center">
                                    <a href="{{ route('record.employee', $employee->id) }}" class="btn btn-light active"
                                        style="border-radius: 18px 18px 0px 0px;">{{ __('Employee Record') }}</a>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="text-center">
                                    <a href="{{ route('salary.employee', $employee->id) }}" class="btn btn-light active"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Salary History') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="text-center">
                                    <a href="{{ route('payment.employee', $employee->id) }}" class="btn btn-light active"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Payment') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddNewAbsence">
                                {{ __('Add Absence') }}
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="AddNewAbsence" tabindex="-1" aria-labelledby="AddNewAbsenceLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Absence') }}</h5>
                                    </div>
                                    <form method="POST" action="{{ route('add.absence') }}">
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                                            <div class="row mb-3">
                                                <label for="start_date"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="start_date" type="date" oninput="firstFunction()" required
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        name="start_date" value="{{ old('start_date') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('start_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="return_date"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Return Date') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <input id="return_date" type="date" oninput="firstFunction()"
                                                        required
                                                        class="form-control @error('return_date') is-invalid @enderror"
                                                        name="return_date" value="{{ old('return_date') }}"
                                                        autocomplete="first name" autofocus>
                                                    @error('return_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="reason"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Reason') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <select id="employer_reason" onchange="secondFunction()"
                                                        class="select @error('reason') is-invalid @enderror"
                                                        name="reason" required>
                                                        <option value="">{{ __('Select Reason') }}</option>
                                                        <option value="Conges"
                                                            {{ old('reason') == 'Conges' ? 'selected' : '' }}>
                                                            {{ __('Conges') }}</option>
                                                        <option value="Absence"
                                                            {{ old('reason') == 'Absence' ? 'selected' : '' }}>
                                                            {{ __('Absence impayee') }}</option>
                                                    </select>
                                                    @error('reason')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="total_number_of_days"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Total number of days') }}</label>
                                                <div class="col-md-8">
                                                    <input id="total_number_of_days" type="number"
                                                        name="total_number_of_days" readonly
                                                        class="form-control @error('total_number_of_days') is-invalid @enderror">
                                                    @error('total_number_of_days')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="total_to_be_cut"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Total Price to be cut') }}</label>
                                                <div class="col-md-8">
                                                    <input id="total_to_be_cut" type="number" readonly
                                                        name="total_to_be_cut"
                                                        class="form-control @error('total_to_be_cut') is-invalid @enderror">
                                                    @error('total_to_be_cut')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="comment"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Comment') }}<span
                                                        style="color:#ff0000">*</span></label>
                                                <div class="col-md-8">
                                                    <textarea id="comment" required class="form-control @error('comment') is-invalid @enderror" name="comment">{{ old('comment') }}</textarea>
                                                    @error('comment')
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
                            <table class="table mb-0 table-striped border-0 data-table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Start Date') }}</th>
                                        <th>{{ __('Return Date') }}</th>
                                        <th>{{ __('Reason') }}</th>
                                        <th>{{ __('Total number of days') }}</th>
                                        <th>{{ __('Total Price to be cut') }}</th>
                                        <th>{{ __('Comment') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($absences))
                                        @foreach ($absences as $absence)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $absence->start_date }}</td>
                                                <td>{{ $absence->return_date }}</td>
                                                <td>{{ $absence->reason }}</td>
                                                <td>{{ $absence->total_number_of_days }}</td>
                                                <td>{{ $absence->total_to_be_cut }}</td>
                                                <td>{{ $absence->comment }}</td>
                                                <td>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#EditRecord{{ $absence->id }}"
                                                        class="btn btn-sm p-2" title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="EditRecord{{ $absence->id }}" tabindex="-1"
                                                aria-labelledby="AddNewSalaryLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('Edit Salary') }}</h5>
                                                        </div>
                                                        <form method="POST" action="{{ route('add.absence') }}">
                                                            <div class="modal-body">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $absence->id }}">
                                                                <input type="hidden" name="employee_id"
                                                                    value="{{ $employee->id }}">
                                                                <div class="row mb-3">
                                                                    <label for="start_date"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="start_date" type="date" oninput="firstFunction()" required
                                                                            class="form-control @error('start_date') is-invalid @enderror"
                                                                            name="start_date"
                                                                            value="{{ $absence->start_date }}">
                                                                        @error('start_date')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="return_date"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Return Date') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <input id="return_date" type="date" oninput="firstFunction()" required
                                                                            class="form-control @error('return_date') is-invalid @enderror"
                                                                            name="return_date"
                                                                            value="{{ $absence->return_date }}">
                                                                        @error('return_date')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>


                                                                <div class="row mb-3">
                                                                    <label for="reason"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Reason') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <select id="employer_reason" onchange="secondFunction()"
                                                                            class="select @error('reason') is-invalid @enderror"
                                                                            name="reason" required>
                                                                            <option value="">
                                                                                {{ __('Select Reason') }}</option>
                                                                            <option value="Conges"
                                                                                {{ $absence->reason == 'Conges' ? 'selected' : '' }}>
                                                                                {{ __('Conges') }}</option>
                                                                            <option value="Absence"
                                                                                {{ $absence->reason == 'Absence' ? 'selected' : '' }}>
                                                                                {{ __('Absence impayee') }}</option>
                                                                        </select>
                                                                        @error('reason')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="total_number_of_days"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Total number of days') }}</label>
                                                                    <div class="col-md-8">
                                                                        <input id="total_number_of_days" type="number"
                                                                        name="total_number_of_days" readonly
                                                                        class="form-control @error('total_number_of_days') is-invalid @enderror">
                                                                        @error('total_number_of_days')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="total_to_be_cut"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Total Price to be cut') }}</label>
                                                                    <div class="col-md-8">
                                                                        <input id="total_to_be_cut" type="number"
                                                                            readonly
                                                                            class="form-control @error('total_to_be_cut') is-invalid @enderror">
                                                                        @error('total_to_be_cut')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="comment"
                                                                        class="col-md-4 col-form-label text-md-end">{{ __('Comment') }}<span
                                                                            style="color:#ff0000">*</span></label>
                                                                    <div class="col-md-8">
                                                                        <textarea id="comment" required class="form-control @error('comment') is-invalid @enderror" name="comment">{{ $absence->comment }}</textarea>
                                                                        @error('comment')
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

    <script type="text/javascript">
        function getAbsDate(date1, date2) {
            dt1 = new Date(date1);
            dt2 = new Date(date2);
            return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1
                .getMonth(), dt1.getDate())) / (1000 * 60 * 60 * 24));
        }


        function firstFunction() {
            secondFunction()
            start_date = document.getElementById('start_date').value
            return_date = document.getElementById('return_date').value
            let total_number_of_days = 0;
            if (start_date && return_date) {
                total_number_of_days = getAbsDate(start_date, return_date);
            }
            document.getElementById('total_number_of_days').value = total_number_of_days

        }

        function secondFunction() {
            var total_number = document.getElementById('total_number_of_days').value
            var reason = document.getElementById("employer_reason").value;
            let price_cut = 0
            if (total_number && reason == "Absence") {
                price_cut = total_number * 5000
            }
            document.getElementById('total_to_be_cut').value = price_cut
        }

        document.onreadystatechange = function() {
            data = firstFunction()
            secondFunction()
        }
    </script>
@endsection
