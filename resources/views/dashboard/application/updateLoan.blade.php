@extends('dashboard.master')
@section('header')
    <header class="main-header">
        <!-- Logo -->
    @include('dashboard.brand')
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            @include('dashboard.userProfileLink')
        </nav>
    </header>
@endsection

@include('dashboard.navigation')

@section('main-content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:nwire="http://www.w3.org/1999/xhtml">
            <div class="row col-md-10 col-lg-10 flex justify-content-center">
                <div class="box box-primary " style="padding: 10px;">
                    {{--<div class="pull-right" style="width: 100%; display: flex; justify-content: center; align-items: center;">
                        <img src="{{ asset('custom/img') }}/nepza_logo.jpg" width="100" height="90" alt="" />
                        <span style="font-size: 24px; font-weight: bolder; color: #0c5460; line-height: 17px;">
                            NEPZA STAFF MULTIPURPOSE CO-OPERATIVE SOCIETY LIMITED<br />
                            <small style="font-size: 13px; color: #0c5460; align-items: center; ! important;">
                                2, Zambezi Crescent Cadestral Zone A6, Behind Merit House, Off Aguiyi Ironsi Street, Maitama, Abuja<br />
                               &#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160; &#160; &#160; &#160; &#160; &#160; Contact GSM: 08054222750; 08086664932; Email: nepzacoop@yahoo.com<br />
                                &#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;&#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;
                                &#160;&#160;&#160; &#160; &#160; &#160; &#160; &#160; &#160;Motto: Unity & Progress
                            </small>
                        </span>
                    </div>--}}
                    <br />
                    <hr><br />
                    <div role="form">
                        <div id="loan_info" style="display:none; width:50%; text-align:center; margin:auto; font-size:23px; color: white; background-color:#3CB371">
                          Your current loan type is: {{$loan->loan_type}}
                        </div><br />
                        <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                            <label style="color: #ffffff;padding-top:2px; ">LOAN APPLICANT</label>
                        </div><br />
                        <form id="enrollmentForm">
                            @csrf
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Full Name:</label>
                                    <select class="form-control col-md-10 col-lg-12" name="applicant" id="applicant" readonly disabled>
                                        <option selected value="{{\Illuminate\Support\Facades\Auth::user()->name}}">{{\Illuminate\Support\Facades\Auth::user()->name}}</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="loan_id" id="loan_id" value="{{$loan->id}}" />
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">LOAN DETAILS</label>
                            </div>

                            <div style="display: inline-flex;" class="col-md-10 col-lg-12" wire:ignore>
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Loan Type:</label>
                                    <select class="form-control col-md-10 col-lg-12" name="loan_type" id="loan_type">
                                        <option selected>Select loan type</option>
                                        <option value="1">Cash Loan</option>
                                        <option value="2">Household Equipment Loan</option>
                                    </select>
                                    <p id="ErrorMsg" style="color:red"></p>
                                </div>
                            </div>
                            <div style="" class="col-md-10 col-lg-12" id="cash_loan">
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="cash_loan_amount">Current Loan Amount (<del style="text-decoration-style: double">N</del>)</label>
                                        @if($loan->loan_type == 'Cash Loan')
                                            <input input type="text" oninput="setCustomValidity('')" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" style="font-size: 25px; font-weight: bolder;" name="cash_loan_amount" id="cash_loan_amount" class="form-control" value="{{number_format($loan->loan_amount,2)}}" data-type="currency" placeholder="20,000.00">
                                        @else
                                            <input input type="text" oninput="setCustomValidity('')" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" style="font-size: 25px; font-weight: bolder;" name="cash_loan_amount" id="cash_loan_amount" class="form-control" value="" data-type="currency" placeholder="20,000.00">
                                        @endif
                                        <p id="claError" style="color:red"></p>
                                    </div>
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="interest_rate">Interest Rate(%)</label>
                                        <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" id="cash_loan_rate" value="" placeholder="7%" readonly>
                                        <p id="clrError" style="color:red; display: inline-flex"></p>
                                    </div>

                                    <div class="form-group col-md-10 col-lg-10">
                                        <label for="duration">Repayment Duration (Months)</label>
                                        <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" id="cash_loan_tenor" value="" placeholder="24 Months" readonly>
                                        <p id="cltError" style="color:red; display: inline-flex"></p>
                                    </div>
                                </div>
                            </div>
                            @php
                                $items = \App\LoanProduct::all();
                            @endphp
                            <div style="" class="col-md-10 col-lg-12" id="item">
                                <div style="display: inline-flex">
                                    <div class="form-group col-md-10 col-lg-10">
                                        <label>Household Equipment:</label>
                                        <select class="form-control col-md-10 col-lg-10" name="item_name" id="item_name">
                                            @if($loan->item_name)
                                                <option value="" style="color: red">Change item from below:</option>
                                            @else
                                                <option selected>Select item</option>
                                            @endif
                                            @foreach($items as $item)
                                                <option value="{{$item->id}}">{{$item->item_name}}</option>
                                            @endforeach
                                        </select>
                                        <p id="inError" style="color:red"></p>
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for="interest_rate">Item Amount (<del style="text-decoration-style: double">N</del>)</label>
                                          @if($loan->loan_type == 'Household Equipment Loan')
                                            <input  data-type="currency" style="font-size: 25px; font-weight: bolder;" class="form-control"  id="item_loan_amount" value="" readonly>
                                           @else
                                            <input data-type="currency" style="font-size: 25px; font-weight: bolder;" class="form-control" id="item_loan_amount" value="" readonly>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for="interest_rate">Interest Rate(%)</label>
                                        <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" id="item_loan_rate" value="" placeholder="3%" readonly>
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                        <label for="item_loan_tenor">Repayment Duration</label>
                                        <input style="font-size: 25px; font-weight: bolder;" type="text" class="form-control" id="item_loan_tenor" value="" placeholder="6 Months" readonly>
                                    </div>
                                </div>
                            </div>
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">LOAN GUARANTOR NO. 1</label>
                            </div>
                            @php
                                $users = \App\User::all()->where('id', '!=', Auth::id());
                            @endphp
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Full Name:</label>
                                    <select class="form-control col-md-10 col-lg-12" id="guarantor_one" name="guarantor_one">
                                        <option value="">Select first guarantor</option>
                                        @Auth
                                            @foreach($users as $user)
                                                <option value="{{$user->phone_no}}">{{$user->name}}</option>
                                            @endforeach
                                        @endAuth
                                    </select>
                                    <p id="gOneError" style="color:red"></p>
                                </div>
                            </div>
                            <div style="display: inline-flex;background-color: #4e555b;width: 30%; margin-left: 30px;" class="col-md-10 col-lg-12">
                                <label style="color: #ffffff;padding-top:2px; ">LOAN GUARANTOR NO. 2</label>
                            </div>
                            <div style="display: inline-flex;" class="col-md-10 col-lg-12">
                                <div class="form-group col-md-10 col-lg-12">
                                    <label>Full Name:</label>
                                    <select class="form-control col-md-10 col-lg-12" id="guarantor_two">
                                        <option value="">Select second guarantor</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->phone_no}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <p id="gTwoError" style="color:red"></p>
                                </div>
                            </div>
                            <div class="" align="center">
                                <button type="submit" id="updateLoan" data-token="{{ csrf_token() }}" class="btn btn-primary">Update Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $("#cash_loan_amount").prop("disabled",true);
                    $("#item_name").prop("disabled",true);

                    $('#loan_type').on('change', function(){
                        if (this.value === '1'){
                            // $("#cash_loan").show();
                            $("#cash_loan_amount").prop("disabled",false);
                            $("#item_name").val('');
                            $("#item_loan_amount").val('');
                            $("#item_loan_rate").val('');
                            $("#item_loan_tenor").val('');
                            $("#item_name").prop('disabled',true);
                        }
                        else if(this.value === '2'){
                            $("#cash_loan_amount").prop("disabled",true);
                            $("#cash_loan_amount").val('');
                            $("#cash_loan_rate").val('');
                            $("#cash_loan_tenor").val('');
                            $("#item_name").prop('disabled',false);
                            // $("#item").show();
                        }else{
                            $("#cash_loan_amount").val('');
                            $("#cash_loan_amount").prop("disabled",true);
                            $("#item_name").val('');
                            $("#item_name").prop('disabled',true);
                        }
                    });
                });
            </script>
            <script>
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "700",
                };

                $('#loan_info').fadeIn(9000).fadeOut(5000).fadeIn(9000).fadeOut(5000);

                $( "#updateLoan" ).on( "click", function(e) {
                    e.preventDefault();
                        let applicant = $("#applicant").val();
                        let loan_id = $("#loan_id").val();
                        var cash_loan_amount = $("#cash_loan_amount").val();
                        let loan_type = $("#loan_type").val();
                        let cash_loan_rate = $("#cash_loan_rate").val();
                        let cash_loan_tenor = $("#cash_loan_tenor").val();
                        let item_loan_name = $("#item_name").val();
                        let item_loan_amount = $("#item_loan_amount").val();
                        let item_loan_rate = $("#item_loan_rate").val();
                        let item_loan_tenor = $("#item_loan_tenor").val();
                        let guarantor_one = $("#guarantor_one").val();
                        let guarantor_two = $("#guarantor_two").val();

                    if($("#loan_type option:selected").val() === "Select loan type") {
                        $('#loan_type').css('border-color', 'red').focus();
                        $('#ErrorMsg').text('Please select a loan type');
                        $('#ErrorMsg').fadeOut(2000);
                        return false;
                     }

                    if($("#loan_type").val() == 1 && $("#cash_loan_amount").val() === "") {
                        $('#cash_loan_amount').css('border-color', 'red').focus();
                        $('#claError').text('Please enter loan amount');
                        $('#claError').fadeOut(2000);
                    }else if($("#loan_type").val() == 1 && $("#guarantor_one").val() === ""){
                        $('#guarantor_one').css('border-color', 'red').focus();
                        $('#gOneError').text('Please select your first guarantor');
                        $('#gOneError').fadeOut(2000);
                    }else if($("#loan_type").val() == 1 && $("#guarantor_two").val() === "") {
                        $('#guarantor_two').css('border-color', 'red').focus();
                        $('#gTwoError').text('Please select your second guarantor');
                        $('#gTwoError').fadeOut(2000);

                    }else if($("#loan_type").val() == 2 && $("#item_name").val() === "") {
                            $('#item_name').css('border-color', 'red').focus();
                            $('#inError').text('Please enter loan amount');
                            $('#inError').fadeOut(2000);
                    }else if($("#loan_type").val() == 2 && $("#guarantor_one").val() === ""){
                            $('#guarantor_one').css('border-color', 'red').focus();
                            $('#gOneError').text('Please select your first guarantor');
                            $('#gOneError').fadeOut(2000);
                    }else if($("#loan_type").val() == 2 && $("#guarantor_two").val() === ""){
                            $('#guarantor_two').css('border-color', 'red').focus();
                            $('#gTwoError').text('Please select your second guarantor');
                            $('#gTwoError').fadeOut(2000);
                    }else{

                        data = {
                            _token: "{{csrf_token()}}",
                            applicant: applicant,
                            loan_id: loan_id,
                            cash_loan_amount: cash_loan_amount,
                            loan_type: loan_type,
                            cash_loan_rate: cash_loan_rate,
                            cash_loan_tenor: cash_loan_tenor,
                            item_loan_name: item_loan_name,
                            item_loan_amount: item_loan_amount,
                            item_loan_rate: item_loan_rate,
                            item_loan_tenor: item_loan_tenor,
                            guarantor_one: guarantor_one,
                            guarantor_two: guarantor_two
                        };

                        $.ajax({
                            url: '{{URL::to('/handleLoanUpdate')}}',
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if(response.message){
                                    toastr.warning(response.message);
                                }else{
                                    window.location=response.url;
                                }
                            },
                            error: function(response) {
                                $('#claError').text(response.responseJSON.errors.cash_loan_amount);
                                $('#gOneError').text(response.responseJSON.errors.guarantor_one);
                                $('#gTwoError').text(response.responseJSON.errors.guarantor_two);
                                $('#clrError').text(response.responseJSON.errors.cash_loan_rate);
                                $('#cltError').text(response.responseJSON.errors.cash_loan_tenor);
                                //item loan validation
                                //$('#cltError').text(response.responseJSON.errors.cash_loan_tenor);
                            }
                        });
                    }

                });
            </script>
            <script>
                $(function(){
                    $("#item_name").change(function(){
                        var itemId = $(this).val();
                        if(itemId === ""){
                            $('#item_loan_amount').val("");
                        }
                        data = {
                            item_id: itemId,
                            _token: "{{csrf_token()}}",
                            }
                        $.ajax({
                            url: '{{URL::to('/getItemPrice')}}',
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                        }).done(function(response) {
                            $('#item_loan_amount').val(response.item_price);
                        });
                    });
                });
            </script>
            <script>
                // Jquery Dependency
                $("input[data-type='currency']").on({
                    keyup: function() {
                        formatCurrency($(this));
                    },
                    blur: function() {
                        formatCurrency($(this), "blur");
                    }
                });

                function formatNumber(n) {
                    // format number 1000000 to 1,234,567
                    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                }

                function formatCurrency(input, blur) {
                    // appends $ to value, validates decimal side
                    // and puts cursor back in right position.

                    // get input value
                    var input_val = input.val();

                    // don't validate empty input
                    if (input_val === "") { return; }

                    // original length
                    var original_len = input_val.length;

                    // initial caret position
                    var caret_pos = input.prop("selectionStart");

                    // check for decimal
                    if (input_val.indexOf(".") >= 0) {

                        // get position of first decimal
                        // this prevents multiple decimals from
                        // being entered
                        var decimal_pos = input_val.indexOf(".");

                        // split number by decimal point
                        var left_side = input_val.substring(0, decimal_pos);
                        var right_side = input_val.substring(decimal_pos);

                        // add commas to left side of number
                        left_side = formatNumber(left_side);

                        // validate right side
                        right_side = formatNumber(right_side);

                        // On blur make sure 2 numbers after decimal
                        if (blur === "blur") {
                            right_side += "00";
                        }

                        // Limit decimal to only 2 digits
                        right_side = right_side.substring(0, 2);

                        // join number by .
                        input_val = "" + left_side + "." + right_side;

                    } else {
                        // no decimal entered
                        // add commas to number
                        // remove all non-digits
                        input_val = formatNumber(input_val);
                        input_val = "" + input_val;

                        // final formatting
                        if (blur === "blur") {
                            input_val += ".00";
                        }
                    }

                    // send updated string to input
                    input.val(input_val);

                    // put caret back in the right position
                    var updated_len = input_val.length;
                    caret_pos = updated_len - original_len + caret_pos;
                    input[0].setSelectionRange(caret_pos, caret_pos);
                }
            </script>

        </section>
        <livewire:change-password />
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2021 <a href="https://isosystemss.com" target="_blank">ISOSYSTEMS</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-white">

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">

                <!-- /.control-sidebar-menu -->

                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
        </div>
    </aside>
@endsection


