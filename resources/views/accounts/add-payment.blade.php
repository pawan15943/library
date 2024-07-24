@extends('layouts.admin')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<!-- Content Header (Page header) -->


<!-- /.content-header -->

<!-- Main content -->
<div class="row">

    <!-- Page Main Content -->
    <div class="col-lg-6">
        <!-- Genral Information -->
        <form method="GET">
            <div class="d-flex">
                <input type="text" class="form-control my-0 digit-only" name="form_number" placeholder="Search form number" value="{{ request()->get('form_number') }}" required>
                <button class="btn btn-primary ml-2"> Search Student</button>
            </div>
        </form>

    </div>

    <div class="col-lg-12">
        @if (session('error'))
        <p class="text text-danger err-msg"> {{ session('error') }}</p>
        @endif
    </div>
</div>

@if (request()->get('form_number'))
<div class="row mt-4">
    <!-- Page Main Content -->
    <div class="col-lg-12">
        <!-- Genral Information -->
        <div class="card card-default" id="generalInfo">
            <div class="card-body">
                <form action="{{ route('admin.account.save_payment') }}" method="POST" enctype="multipart/form-data" id="main_payment_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Name<sup class="text-danger">*</sup></label>
                                <input type="hidden" name="student_id" value="{{ $student_details ? $student_details->id : '' }}">
                                <input type="text" class="form-control" placeholder="Name" id="name" name="name" value="{{ old('name', $student_details ? $student_details->name : '') }}" readonly>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Father Name <sup class="text-danger">*</sup></label>
                                <input type="text" name="father_name" class="form-control" placeholder="Father Name" value="{{ old('father_name', $student_details ? $student_details->father_name : '') }}" readonly>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Study Center<sup class="text-danger">*</sup></label>
                                <input type="text" name="center_name" class="form-control" placeholder="Course" value="{{ old('center_name', $student_details ? $student_details->study_centers : '') }}" readonly>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Course<sup class="text-danger">*</sup></label>
                                <input type="text" name="course_name" class="form-control" placeholder="Course" value="{{ old('course_name', $student_details ? $student_details->coursecategories : '') }}" readonly>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Class<sup class="text-danger">*</sup></label>
                                <input type="text" name="class_name" class="form-control" placeholder="Course" value="{{ old('class_name', $student_details ? $student_details->classes : '') }}" readonly>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="border-bottom pb-3">Transportation Details</h6>
                        </div>
                        <div class="w-100"></div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Route<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('route_name') is-invalid @enderror" value="{{ old('route_name', isset($subscription) ? $subscription->route_name : '') }}" readonly>

                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">

                                <label>Landmark<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('landmark') is-invalid @enderror" value="{{ old('landmark', isset($subscription) ? $subscription->landmark : '') }}" readonly>

                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Amount(per month)<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', isset($subscription) ? $subscription->amount : '') }}" id="amount" readonly>
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Remark</label>
                                <textarea class="form-control @error('remark') is-invalid @enderror" readonly name="remark">{{ old('remark', isset($subscription) ? $subscription->remark : '') }} </textarea>

                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror" value="@if($subscription && $subscription->start_date) {{ date('d-M-Y', strtotime($subscription->start_date)) }} @else NA @endif" readonly>


                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="text" class="form-control @error('amount') is-invalid @enderror" value="@if($subscription && $subscription->end_date) {{ date('d-M-Y', strtotime($subscription->end_date)) }} @else NA @endif" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-3">Add Payment Details </h6>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-lg-12">
                            <div class="row">

                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="payment_plan_amount form-group" id="showForm">
                                <label>Subscription Amount Paid For<sup class="text-danger">*</sup></label>
                                <select name="payType" id="payType" class="form-control @error('payType') is-invalid @enderror">
                                    <option value="">Select Month</option>
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Months</option>
                                    <option value="3">3 Months</option>
                                    <option value="4">4 Months</option>
                                    <option value="5">5 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="7">7 Months</option>
                                    <option value="8">8 Months</option>
                                    <option value="9">9 Months</option>
                                    <option value="10">10 Months</option>
                                    <option value="11">11 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                            @error('payType')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-6 ">
                            <div class="form-group">
                                <label class="amt">Total Amount <span></span></label>
                                <input type="text" class="intallment__numberVal form-control" name="total_amount" value="" readonly placeholder="Amount">
                            </div>
                        </div>
                    </div>




                    <div class="offline-payment d-none">
                        <div class="col-lg-12 text-center">
                            <h2 class="py-3">Select a payment method <span id="amountToPay"></span></h2>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <div class="d-flex flex-wrap justify-content-center mt-2">
                                <label class="form-check form-check-inline ps-0 ">
                                    <input type="radio" class="transaction-type" name="payment_type" {{ old('payment_type') == '1' ? 'checked' : 'checked' }} value="1">&nbsp;Bank
                                    Transfer</label><label class="form-check form-check-inline ps-0">
                                    <input type="radio" class="transaction-type" name="payment_type" {{ old('payment_type') == '2' ? 'checked' : '' }} value="2">&nbsp;Cheque</label><label class="form-check form-check-inline ps-0"><input type="radio" class="transaction-type" name="payment_type" {{ old('payment_type') == '3' ? 'checked' : '' }} value="3">&nbsp;Post dated
                                    cheque</label>

                                <label class="form-check form-check-inline ps-0"><input type="radio" class="transaction-type" name="payment_type" {{ old('payment_type') == '4' ? 'checked' : '' }} value="4">&nbsp;POS</label>


                                @error('payment_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Bank Form --}}
                        <div class="col-lg-12">
                            <div class="row mb-4">
                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label for="floatingInput">Transaction Number/ Reference Number <sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control digit-only @error('pay_transaction_id') is-invalid @enderror" placeholder="Enter Transaction Number" name="pay_transaction_id" value="" />
                                        @error('pay_transaction_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label>Transaction Date <sup class="text-danger">*</sup></label>
                                        <input type="text" id="transaction_date" name="transaction_date" class="form-control datepicker3 @error('transaction_date') is-invalid @enderror" placeholder="Enter Transaction Date" value="{{ old('transaction_date') }}" autocomplete="off">
                                        @error('transaction_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label class="optional">IBAN Number (Optional)</label>
                                        <input type="text" class="form-control digit-only" placeholder="Enter IBAN Number" name="iban_num" value="" />
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label class="optional">Swift Code (Optional)</label>
                                        <input type="text" class="form-control digit-only" placeholder="Enter Swift Code" name="swift_code" value="" />
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label for="floatingInput">Account Number<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control digit-only @error('account_num') is-invalid @enderror" placeholder="Enter Account Number" name="account_num" value="" />
                                        @error('account_num')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label for="floatingInput">Account Holder Name<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control char-only @error('account_holder_name') is-invalid @enderror" placeholder="Enter Account holder name" name="account_holder_name" value="" />
                                        @error('account_holder_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control char-only @error('bank_name') is-invalid @enderror" placeholder="Enter Bank Name" name="bank_name" value="" />
                                        @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 bt">
                                    <div class="form-floating">
                                        <label for="floatingInput">Bank Branch Name</label>
                                        <input type="text" class="form-control char-only @error('bank_branch') is-invalid @enderror" placeholder="Bank Branch Name" name="bank_branch" value="" />
                                        @error('bank_branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Cheque --}}
                                <div class="col-lg-6 mb-3 cheq">
                                    <div class="form-floating diff_disable ">
                                        <label for="floatingInput">Cheque Number</label>
                                        <input type="number" class="form-control digit-only @error('cheque_number') is-invalid @enderror" placeholder="Enter Cheque Number" name="cheque_number" value="" />
                                        @error('cheque_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 cheq">
                                    <div class="form-floating">
                                        <label for="floatingInput">Cheque Date</label>
                                        <input type="text" class="form-control datepicker3 @error('cheque_date') is-invalid @enderror" placeholder="Enter" name="cheque_date" value="" />
                                        @error('cheque_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- PDC Block --}}
                                <div class="col-lg-6 mb-3 pdc">
                                    <div class="form-floating diff_disable ">
                                        <label for="floatingInput">Cheque Number</label>
                                        <input type="number" class="form-control digit-only @error('pdc_cheque_number') is-invalid @enderror" placeholder="Enter Cheque Number" name="pdc_cheque_number" value="" />
                                        @error('pdc_cheque_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 pdc">
                                    <div class="form-floating">
                                        <label for="floatingInput">Cheque Date</label>
                                        <input type="text" class="form-control datepicker3 @error('pdc_cheque_date') is-invalid @enderror" placeholder="Cheque Date" name="pdc_cheque_date" value="" />
                                        @error('pdc_cheque_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 pdc">
                                    <div class="form-floating">
                                        <label>Encashment Date</label>
                                        <input type="text" class="form-control datepicker3  @error('encashment_date') is-invalid @enderror" placeholder="Encashment Date" name="encashment_date" value="">
                                        @error('encashment_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 pos">
                                    <div class="form-floating">
                                        <label for="floatingInput">Transaction Id</label>
                                        <input type="text" class="form-control digit-only @error('pos_trxn_no') is-invalid @enderror" placeholder="Enter Transaction Id" name="pos_trxn_no" value="" />
                                        @error('pos_trxn_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3 pos">
                                    <div class="form-floating">
                                        <label>Transaction Date</label>
                                        <input type="text" class="form-control datepicker3 @error('pos_trxn_date') is-invalid @enderror" placeholder="Enter Transaction Date" name="pos_trxn_date" value="" />
                                        @error('pos_trxn_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-floating diff_fileUpload">
                                        <label class="form-label">Customer payment proof <sup class="text-danger">*</sup></label>
                                        <input class="form-control @error('transaction_receipt') is-invalid @enderror" type="file" name="transaction_receipt" accept="image/png, image/gif, image/jpeg, docx, doc, pdf" />
                                        @error('transaction_receipt')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-12">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="nothing-found">
            @if (session('error'))
            No Record Found!
            @else
            No Data Available!
            @endif
        </div>
    </div>
</div>
@endif



<!-- /.content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {


        $('.payment_plan_amount').off('click').on('click', function() {
            $('.offline-payment').addClass('d-block');


            $('#payType').change(function() {
                var selectedPlanVal = $(this).val();
                var amount = $('#amount').val();
                if (selectedPlanVal && amount) {
                    var total_amount = selectedPlanVal * amount;
                    $('.intallment__numberVal').val(total_amount);
                }
            });


        });

        $("#main_payment_form_button").click(function() {
            if (confirm("Entry already exist, Do you want to overwrite?")) {
                $('form#main_payment_form').submit();
            }
        });
        // Mesc Charges property  check
        if ($('#exampleCheck1').is(':checked')) {
            $(".offline-payment").hide();
        } else {
            $(".offline-payment").show();
        }

        // check transaction type on load
        if ($('.transaction-type').is(':checked')) {
            let checked_type = $('.transaction-type:checked').val();
            if (checked_type == 1) {
                $(".bt").show();
                $(".pos,.pdc,.cheq,.pay").hide();
            } else if (checked_type == 2) {
                $(".cheq").show();
                $(".bt,.pos,.pdc,.pay").hide();
            } else if (checked_type == 3) {
                $(".pdc").show();
                $(".cheq,.bt,.pos,.pay").hide();
            } else if (checked_type == 4) {
                $(".pos").show();
                $(".pdc,.cheq,.bt,.pay").hide();
            } else if (checked_type == 5) {
                $(".pay").show();
                $(".pdc,.cheq,.bt,.pos").hide();
            }
        }
    });
    $(document).on('click', '#exampleCheck1', function() {
        if ($(this).is(':checked')) {
            $(".offline-payment").hide();
        } else {
            $(".offline-payment").show();
        }
    });

    $(document).on("click", ".transaction-type", function() {
        let transaction_type = $(this).val();
        if (transaction_type == 1) {
            $(".bt").show();
            $(".pos,.pdc,.cheq,.pay").hide();
        } else if (transaction_type == 2) {
            $(".cheq").show();
            $(".bt,.pos,.pdc,.pay").hide();
        } else if (transaction_type == 3) {
            $(".pdc").show();
            $(".cheq,.bt,.pos,.pay").hide();
        } else if (transaction_type == 4) {
            $(".pos").show();
            $(".pdc,.cheq,.bt,.pay").hide();
        } else if (transaction_type == 5) {
            $(".pay").show();
            $(".pdc,.cheq,.bt,.pos").hide();
        }
        
    });

    $(document).ready(function() {
        $('#payType').change(function() {
            var selectedValue = $(this).val();
            var val = $(this).val();
            var amount = $('#amount').val();

            var selectedValue = "(Paid for " + selectedValue + " Months)";
            var paymentMsg = "for a " + val + "-Month Subscription of ₹" + val * amount + ".";
            $('.amt span').text(selectedValue ? selectedValue : 'No value selected').css('color', 'red');
            $('.py-3 span').text(paymentMsg ? paymentMsg : 'No value selected').css('color', 'red');
        });
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker3", {
            dateFormat: "d-m-Y"
        });
    });
</script>

@endsection
