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
            @include('admin.includes.operatorBar')
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
                            <i class="fa fa-gift"></i>KOT Kitchen Complete History
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
                                <th>Bill No.</th>
                                <th>T/R</th>
                                <th>Terminal</th>
                                <th>Serve Time</th>
                                <th>PAX</th>
                                <th>Water Name</th>
                                <th>Gust Name</th>
                                <th>Company Name</th>
                                <th>E-mail</th>
                                <th>Contact No</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($kitchen_complete_kots as $kots)
                                <tr>
                                    <td>{{$kots->billNo}}</td>
                                    <td>{{$kots->tableNo}}{{$kots->roomNo}}</td>
                                    <td>{{$kots->terminal}}</td>
                                    <td>{{$kots->serveTime}}</td>
                                    <td>{{$kots->pax}}</td>
                                    <td>{{$kots->waterName}}</td>
                                    <td>{{$kots->gustName}}</td>
                                    <td>{{$kots->companyName}}</td>
                                    <td>{{$kots->email}}</td>
                                    <td>{{$kots->contactNo}}</td>
                                    <td>
                                        <a href="{{ route('sendToKOT', ['billNo' => $kots->billNo]) }}" class="btnprn">
                                            <button type="button" class=" btn btn-info" >Send To Cash</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('kotView', ['billNo' => $kots->billNo]) }}" class="btnprn">
                                            <button type="button" class=" btn btn-info" >Details</button>
                                        </a>
                                    </td>
                                </tr>
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
            buttons: ['csv', 'excel', 'pdf', 'print'],
            scrollX:true,
autoWidth: false,
            layout: {
                topStart: 'buttons'
            }
        });

        // TableAdvanced.init();
{{--    </script>--}}
@endsection
