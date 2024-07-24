@extends('layouts.admin')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Main row -->
<div class="row ">
    <!-- Main Info -->
    <div class="col-lg-12 ">

        <!-- Add Document -->
        <div class="card card-default main_card_content" id="generalInfo ">
            
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="table-responsive tableRemove_scroll mt-2">
                            <table class="table table-hover border data-table trspotation_data" id="datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th>Form No</th>
                                        <th>Name</th>
                                        <th>Invoice No</th>
                                        <th>Subscription Duration</th>
                                        {{-- <th>Amt (Monthly)</th> --}}
                                        <th>Amt Paid</th>
                                        <th>Payment Date</th>
                                        <th>Payment Mode</th>
                                        <th>Payment Type</th>
                                        <th>Verify Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </div>

</div>
<!-- /.row (main row) -->
  
<!-- /.content -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remark for reject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="reject_form">
                        @csrf
                        <div class="form-group">
                            <label for="city">Remark<sup class="text-danger">*</sup></label>
                            <input type="text" name="reject_remark" value="" class="form-control" id=""
                                placeholder="Enter remark" required>
                            <input type="hidden" id="fees_id" name="fees_id" value="">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function() {
    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.accounts') }}",
            lengthMenu: [
                [10, 50, 100, -1],
                [10, 50, 100, "All"]
            ],
            columns: [
                
                {
                    data: 'form_no',
                    name: 'form_no',
                    searchable: true
                },
                {
                    data: 'student_name',
                    name: 'student_name'
                },
                 
                {
                    data: 'paymentproof',
                    name: 'paymentproof',
                },
                {
                    data: 'month_plan',
                    name: 'month_plan',
                },
                // {
                //     data: 'monthly_amount',
                //     name: 'monthly_amount',
                // },
            
                {
                    data: 'paid_amount',
                    name: 'paid_amount',
                },
                {
                    data: 'transaction_date',
                    name: 'transaction_date',
                },
               
               
                {
                    data: 'payment_mode',
                    name: 'payment_mode',
                },
                {
                    data: 'payment_type',
                    name: 'payment_type,'
                },
               
                {
                    data: 'verification',
                    name: 'verification',
                }
            ],
                dom: 'lBfrtip',
            buttons: [
                'excel', 'csv', 'pdf', 'copy'
            ]
        });

    });
    $(document).on('change', '#verification', function(event) {
        let status = $(this).val();
        let fee_id = $(this).attr('fees_id');
        if (status == 2) {
            $("#fees_id").val(fee_id);
            $("#rejectModal").modal('show');
            return false;
        }
        console.log($('meta[name="csrf-token"]').attr('content'));

        verifyStatus(status, fee_id, "");
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function verifyStatus(status, fee_id, remark) {
        $.ajax({
            type: "POST",
          
            url: "{{ route('admin.accounts_verification') }}",
           
            data: {
                'status': status,
                'reject_remark': remark,
                'id': fee_id,
                '_method': 'PATCH'
            },
            success: function(data) {
                if (data.success) {
                    toastr.success(data.message);
                    dataTable.ajax.reload();
                } else if (data.error) {
                    toastr.error(data.message);
                }
            }
        });
    }
    // reject verification with remark
    $(document).on('submit', '#reject_form', function(e) {
        e.preventDefault();
        let status = 2;
        let remark = $("input[name='reject_remark']").val();
        let fee_id = $("#fees_id").val();
        console.log(remark + ' == ' + fee_id);
        verifyStatus(status, fee_id, remark);
        $("input[name='reject_remark']").val("");
        $("#fees_id").val("");
        $("#rejectModal").modal('hide');

    });
   
});
</script>


@endsection
