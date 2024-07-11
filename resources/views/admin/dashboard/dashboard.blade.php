@extends('admin.master')
<link rel="stylesheet" type="text/css"
      href="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
@section('styleSheet')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/typeahead/typeahead.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- END STYLE CUSTOMIZER -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{route('adminDashboard')}}">Dashboard</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
{{--            @dump($studentCounts)--}}
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue-madison">
                        <div class="visual">
                            <i class="fa fa-briefcase fa-icon-medium"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                {{$users->total}}
                            </div>
                            <div class="desc">
                                Total User
                            </div>
                        </div>
                        <a class="more" href="{{route('userList')}}">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat red-intense">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                {{$users->admins_count}}
                            </div>
                            <div class="desc">
                                Total Admin
                            </div>
                        </div>
                        <a class="more" href="{{route('userList')}}">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat blue-madison">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                {{$users->operator_count}}
                            </div>
                            <div class="desc">
                                Total Operator
                            </div>
                        </div>
                        <a class="more" href="{{route('userList')}}">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat green-haze">
                        <div class="visual">
                            <i class="fa fa-group fa-icon-medium"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                {{$users->kitchen_count}}
                            </div>
                            <div class="desc">
                                Total Kitchen
                            </div>
                        </div>
                        <a class="more" href="{{route('userList')}}">
                            View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="portlet-body">
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#overview_a" data-toggle="tab">All</a></li>
                            @foreach($outlets_count as $key=>$outlets)
                                <li><a href="#overview_{{$key}}" data-toggle="tab">{{$outlets->outlet}}</a></li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="overview_a">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="dashboard-stat yellow-crusta">
                                            <div class="visual">
                                                <i class="fa fa-briefcase fa-icon-medium"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    {{$panding_kots_count}}
                                                </div>
                                                <div class="desc">
                                                    Pending KOT
                                                </div>
                                            </div>
                                            <a class="more" href="{{ route('pendingKOTAll') }}">
                                                View more <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="dashboard-stat grey-salsa">
                                            <div class="visual">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    {{$kitchen_complete_kot_count}}
                                                </div>
                                                <div class="desc">
                                                    Kitchen Complete KOT
                                                </div>
                                            </div>
                                            <a class="more" href="{{ route('operatorCompleteKOTHistoryAll') }}">
                                                View more <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="dashboard-stat purple-intense">
                                            <div class="visual">
                                                <i class="fa fa-comments"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    {{$total_kots_count}}
                                                </div>
                                                <div class="desc">
                                                    Total KOT
                                                </div>
                                            </div>
                                            <a class="more" href="{{ route('totalKOT') }}">
                                                View more <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="dashboard-stat green-haze">
                                            <div class="visual">
                                                <i class="fa fa-group fa-icon-medium"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    {{$cash_print_count}}
                                                </div>
                                                <div class="desc">
                                                    Cash Print
                                                </div>
                                            </div>
                                            <a class="more" href="{{ route('cashPrint') }}">
                                                View more <i class="m-icon-swapright m-icon-white"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach($outlets_count as $key=>$outlets)
                                <div class="tab-pane" id="overview_{{$key}}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="dashboard-stat yellow-crusta">
                                                <div class="visual">
                                                    <i class="fa fa-briefcase fa-icon-medium"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        {{$outlets->panding_kots_count}}
                                                    </div>
                                                    <div class="desc">
                                                        Pending KOT
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="dashboard-stat grey-salsa">
                                                <div class="visual">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        {{$outlets->kitchen_complete_kot_count}}
                                                    </div>
                                                    <div class="desc">
                                                        Kitchen Complete KOT
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="dashboard-stat purple-intense">
                                                <div class="visual">
                                                    <i class="fa fa-comments"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        {{$outlets->total_kots_count}}
                                                    </div>
                                                    <div class="desc">
                                                        Total KOT
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="dashboard-stat green-haze">
                                                <div class="visual">
                                                    <i class="fa fa-group fa-icon-medium"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        {{$outlets->cash_print_count}}
                                                    </div>
                                                    <div class="desc">
                                                        Cash Print
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="tab-pane" id="overview_2">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="display: none">
                    <!-- Begin: life time stats -->
                    <div class="portlet box red-sunglo">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bar-chart-o"></i>Register last 30 days
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="reload">
                                </a>
                            </div>
                            <ul class="nav nav-tabs" style="margin-right: 10px">
                                <li>
                                    <a href="#portlet_tab2" data-toggle="tab" id="statistics_amounts_tab">
                                        Students </a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="portlet_tab1">
                                    <div id="statistics_1" class="chart">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End: life time stats -->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
    <!-- END CONTENT -->
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

    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-dropdowns.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/table-advanced.js"></script>
@endsection
@section('documentJquery')
    EcommerceIndex.init();
    TableAdvanced.init();
@endsection
