
<div class="modal modal-dialog-centered" id="report_filter">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">Exit</span></button>
                <h4 class="modal-title">Report Filter</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div style="display: inline-flex;" class="col-lg-12 col-lg-12">
                        <div class="form-group col-lg-12 col-lg-12">
                            <label>Select type of Report</label>
                            <select id="report_type" class="form-control">
                                <option selected disabled>Report type</option>
                                <option value="account_statement">Account Statement</option>
                                <option value="loan_statement">Loan Statement</option>
                                <option value="trans_statement">Statement of Transaction</option>
                            </select>
                        </div>
                    </div>
                    <div style="display: inline-flex;" class="col-lg-12 col-lg-12">
                        <div class="form-group col-md-10 col-lg-10">
                            <!-- Date and time range -->
                            <label>Date Range:</label>
                            <div class="input-group dp">
                                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                <span>
                                  <i class="fa fa-calendar"></i> Date Range Picker
                                </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-10 col-lg-10">
                            <label>Report Action</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                    <i class="fa fa-download"></i> Generate PDF
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-10 col-lg-10">
                            <label>Report Action</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export to Excel
                                </button>
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="modal-footer">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Page script -->
<script type="text/javascript">
    $(document).ready(function (){
        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();
            function cb(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#daterange-btn').daterangepicker({
                // parentEl:('#dp'),
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        });

    })
</script>
<style>
    .modal-dialog {
        width: 360px;
        height:600px !important;
    }

    .modal-content {
        height: 60%;
        background-color:#BBD6EC;
    }

    .modal-header {
        background-color: #337AB7;
        padding:16px 16px;
        color:#FFF;
        border-bottom:2px dashed #337AB7;
    }
</style>


