@extends('layouts.master')

<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />

<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>

        <h1 class="page-title"> @if($product!='') Edit @else Add @endif Invoices </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='showInvoices')}}">Invoices</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                @if($product!='') Edit @else Create @endif Invoice </li>
            <li>
            </li>
        </ol>


    </div>

    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='showInvoices')}}" class="btn btn-cyan btn-icon text-white">
            <span>
                <i class="fe fe-corner-up-left"></i>
            </span> Back
        </a>

    </div>

</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<!-- ROW-1 OPEN -->
@csrf

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <!-- Address and delivery Information-->
                <div class="row">
                    <div class="col-md-6 text-left">
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Asiatic Pest Control Services Pvt Ltd <br>
                                62/1116 & 1117, <br>
                                "VINAYAKA", M G Road,<br>
                                Cochin - 682016<br>
                                Kerala<br>
                                PH : 0484 406 00 11<br>
                                GSTIN/UIN: 32AASCA1538J1ZL<br>
                                State Name : Kerala, Code : 32<br>
                                CIN: U52609KL2019PTC057543<br>
                                E-Mail : corporate@asiatic-pco.com </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label  text-capitalize">Buyer <br>
                                {!! $address !!} </label>

                        </div>
                        <div class="form-group">
                            <label class="form-label  text-capitalize">Description of services <br>
                                {!! $description !!} </label>

                        </div>
                        <div class="form-group">
                            <label class="form-label  text-capitalize">Remarks </label>
                            <textarea class="form-control" id="Remarks" style="resize:none" placeholder="Remarks"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label  text-capitalize">HSN/SAC </label>
                            <input type="text" value="" name="HSN/SAC" id="HSN/SAC" class="form-control" placeholder="HSN/SAC">
                        </div>
                        <div class="form-group">
                            <label class="form-label  text-capitalize">Terms Of delivery </label>
                            <textarea class="form-control" id="Terms Of Delivery" style="resize:none" placeholder="Terms Of Delivery"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <!-- <div class="col-xs-3">Col 1</div>
                        <div class="col-xs-2">Col 2</div>
                        <div class="col-xs-2 v-divider">Col 2</div>
                        <div class="col-xs-3">Col 3</div>
                        <div class="col-xs-3">Col 4</div> -->

                        <table class="table table-striped table-bordered text-nowrap w-100" id="tbl_pdts">
                            <tbody id="tbl_pdts_body">
                                <tr>
                                    <td class="wd-10p">Invoice No</td>
                                    <td class="wd-20p">Date
                                    </td>
                                </tr>
                                <tr>
                                    <td>{!! $invoiceNo !!}
                                    </td>
                                    <td>
                                        {!! $currentDate !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Delivery Note
                                    </td>
                                    <td>
                                        Mode / Terms Of payment
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <textarea class="form-control" id="delivery_note" style="resize:none" placeholder="Delivery Note"></textarea>
                                    </td>
                                    <td>
                                        <select class="form-control" id="mode" placeholder="Mode">
                                            <option value="">Select</option>
                                            <option value="">Cash</option>
                                            <option value="">Debit Card</option>
                                            <option value="">Credit Card</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supplier's Ref.

                                    </td>
                                    <td>
                                        Other Reference(s)

                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="" name="email" id="su_reference" class="form-control" placeholder="Supplier Ref">

                                    </td>
                                    <td>
                                        <input type="text" value="" name="email" id="ot_reference" class="form-control" placeholder="Other Reference">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Buyer's Order No.

                                    </td>
                                    <td>
                                        Dated
                                    </td>
                                </tr>
                                <tr>
                                    <td>{!! $work_order_no !!}

                                    </td>
                                    <td>
                                        {!! $work_order_date !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Despatch Document No.

                                    </td>
                                    <td>
                                        Delivery Date

                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="" name="email" id="email" class="form-control" placeholder="Despatch Document No">

                                    </td>
                                    <td>
                                        <input type="text" value="" name="delivery_date" id="delivery_date" class="form-control inv_delivery_date" placeholder="Delivery Date">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Despatched through

                                    </td>
                                    <td>
                                        Destination
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" value="" name="email" id="de_through" class="form-control" placeholder="Despatched through">

                                    </td>
                                    <td>
                                        <select class="form-control" id="location">
                                            <option value="">Select</option>
                                            <?php foreach ($location as $loc) : ?>
                                                <option value="<?= $loc->id ?>"><?= $loc->name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Product Information-->
                <div class="row">
                    <div class="col-md-12 text-center">

                        <div class="form-group">

                            {!! $invoiceProductDetails !!}
                        </div>
                    </div>
                </div>
                <!-- Taxable Information-->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <table class="table table-striped table-bordered text-nowrap w-100" id="tbl_pdts">

                            </table>
                        </div>
                    </div>
                </div>
                <!-- Bank Details and Remarks -->
                <div class="row">
                    <div class="col-md-6 text-left">

                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Declartion </label>
                            <span>We declare that this invoice shows the actual price of the goods described and that all particulars are true and
                                correct. </span>
                        </div>

                    </div>
                    <div class="col-md-5 text-left">
                    <label class="form-label lightBlue text-capitalize">Bank Details</label>
                        <table class="table table-striped table-bordered text-nowrap w-100" id="tbl_pdts" text-right>
                            <tbody id="tbl_pdts_body">
                                <tr>
                                    <td class="wd-10p">Bank Name</td>
                                    <td class="wd-20p"><input type="text" value="" name="email" id="email" class="form-control" placeholder="Bank Name">
                                    </td>
                                </tr>
                                <tr>
                                    <td>A/C No
                                    </td>
                                    <td>
                                    <input type="text" value="" name="email" id="email" class="form-control" placeholder="A/C No">
                                    </td>
                                </tr>
                                <tr>
                                    <td>IFSC CODE
                                    </td>
                                    <td>
                                    <input type="text" value="" name="email" id="email" class="form-control" placeholder="IFSC CODE">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        
                        <div class="col-md-12 col-sm-12">
                            <div class="pull-right  ebtn pb-5 pr-2">
                                <a href="javascript:;" onclick="createRFQ()" class="btn btn-primary RFQSave">Save</a>
                                <a href="{{url('/showRFQ')}}" class="btn btn-danger RFQSave">Cancel</a>
                            </div>
                            <span id="load-RFQ" style="padding-top:25px;" class="pull-right pr-2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-6 CLOSED -->
    @endsection
    @section('js')
    <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>
    <!-- INTERNAL SELECT2 JS -->
    <script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/sweet-alert.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

    @endsection