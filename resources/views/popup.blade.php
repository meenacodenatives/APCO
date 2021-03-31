@extends('layouts.master')
@section('css')
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/css/pickadate.css')}}" rel="stylesheet">
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  MULTI SELECT CSS -->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">

@endsection
@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Modal</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Advanced Elements</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modal</li>
        </ol>
    </div>

</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')


<!-- ROW-2 OPEN -->
<div class="row">

    <div class="clipboard-icon" data-clipboard-target="#modal5"><i class="fa fa-clipboard"></i></div>
</figure>
<!-- End Prism Code-->
</div>

<div class="col-sm-12 col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Input Modal</h3>
        </div>
        <div class="card-body">
            <div class="example text-center">
                <button type="button" class="test btn btn-info" data-toggle="modal" data-target="#exampleModal3">View modal</button>
            </div>
            <!-- MESSAGE MODAL -->
            <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="form-control-label">Date:</label>
                                    <input type="text" class="form-control ron" id="recipient-name">
                                </div>
                                <div class="form-group">
                                    <label>Select Filter</label>
                                    <select multiple="multiple" class="filter-multi">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send message</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MESSAGE MODAL CLOSED -->
        </div></div></div>
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.date.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.time.js')}}"></script>
<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<!-- INTERNAL MULTI SELECT JS -->
<script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>

<script>
$(function () {
    $('.ron').pickadate({
        selectMonths: true,
        selectYears: 10,
        format: 'mm/dd/yyyy',
        today: 'Today'
    });
    $('.test').on('click', function () { //Electronic affidite
        $('#exampleModal3').on('show.bs.modal', function () {
            $('.ron').pickadate({
                selectMonths: true,
                selectYears: 10,
                format: 'mm/dd/yyyy',
                today: 'Today'
            });
        });
    });

});


</script>

@endsection