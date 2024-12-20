@extends('admin.operator')
<link rel="stylesheet" type="text/css"
      href="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
@section('styleSheet')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>

    {{--<link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>--}}

    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/typeahead/typeahead.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/select2/select2.css"/>
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/media/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/media/css/buttons.dataTables.css"/>
    {{--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/css/components.css" id="style_components"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content" style="min-height:224px">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- END STYLE CUSTOMIZER -->
            @include('admin.includes.kitchenBar')
            <!-- END PAGE HEADER-->
            @if(session('message'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    {{session('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class = "alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- BEGIN PORTLET-->
            <div class="row">
                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Kitchen Pending KOT History
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-hover table-striped table-bordered" id="sample_user">
                            <thead>
                            <tr role="row" class="heading">
                                <th>SL</th>
                                <th>Date</th>
                                <th>Bill NO</th>
                                <th>Outlet</th>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $tr1='active';
                                $tr2='success';
                                $tr3='warning';
                                $billState = 1;
                                $pevBillNo = 0;
                            @endphp
                            @foreach($pending_kots as $kots)
                                @if($loop->iteration == 1)
                                    @php
                                        $pevBillNo = $kots->billNo;
                                    @endphp
                                @endif
                                @if($pevBillNo != $kots->billNo)
                                    @php
                                        $pevBillNo = $kots->billNo;
                                        $billState++;
                                    @endphp
                                @endif
                                <tr class="{{$billState == 1 ? 'active' : ($billState == 2 ? 'success' : 'warning')}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$kots->date}}</td>
                                    <td>{{$kots->billNo}}</td>
                                    <td>{{$kots->outlet}}</td>
                                    <td>{{$kots->repID}}</td>
                                    <td>{{isset($itemName[$kots->repID]) ? $itemName[$kots->repID] : $kots->repID}}</td>
                                    <td>{{$kots->qty}}</td>
                                    <td>{{$kots->remark}}</td>
                                    <td>
                                        @if($kots->complete == 'N')
                                            <a href="{{ route('kitchenCompleteKOT', ['id' => $kots->id]) }}" class="btnprn">
                                                <button type="button" class=" btn btn-info" >Complete Order</button>
                                            </a>
                                        @elseif($kots->complete == 'Y')
                                            <a href="#" class="btnprn">
                                                <button type="button" class=" btn btn-success" >Completed</button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @if($billState == 3)
                                    @php
                                        $billState = 1;
                                    @endphp
                                @endif
                            @endforeach
                        </table>
                        <!-- responsive -->

                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
@endsection
@section('customJs')
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/fuelux/js/spinner.min.js"></script>

    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/typeahead/typeahead.bundle.min.js"
            type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('/') }}assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-form-tools.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/select2/select2.min.js"></script>

    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/dataTables.buttons.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/buttons.dataTables.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/jszip.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/pdfmake.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/buttons.html5.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/buttons.print.min.js"></script>


    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-dropdowns.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/table-advanced.js"></script>
    <script src="{{ asset('/') }}assets/global/scripts/axios.min.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/form-samples.js"></script>
@endsection
@section('documentJquery')
{{--    <script>--}}
        $('#sample_user').DataTable({
            lengthChange: false,
            responsive: true,
            scrollX:true,
            autoWidth: false,
            buttons: ['csv', 'excel', 'pdf', 'print'],
            layout: {
                topStart: 'buttons'
            }
        });

        // TableAdvanced.init();
{{--    </script>--}}
@endsection
