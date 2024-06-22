@extends('admin.operator')
<link rel="stylesheet" type="text/css"
      href="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
@section('styleSheet')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/typeahead/typeahead.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <!-- END PAGE LEVEL STYLES -->
@endsection
@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content" style="min-height:224px">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- END STYLE CUSTOMIZER -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{route('operatorDashboard')}}">KOT View</a>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div class="btn-group clearfix pull-right">
                        <a href="{{ route('newOrder') }}" class="btn btn-circle green" style="margin-right: 10px">Take New Order <i class="fa fa-plus"></i></a>
                        <a href="{{route('orderHistry')}}" class="btn btn-circle blue-hoki ml-5">Order History <i class="fa fa-link"></i></a>
                    </div>
                </div>
            </div>
            <!-- END PAGE HEADER-->
            {{--            @dump($studentCounts)--}}
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="portlet box blue-steel">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bell-o"></i>Order details
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="card-body">
                            <table class="table ">
                                <tr>
                                    <td><strong>Bill No :</strong></td><td> {{$billNo}} </td>
                                    <td><strong>Table No. :</strong></td><td> {{$tableNo}} </td>
                                    <td><strong>Room No. :</strong></td><td> {{$roomNo}} </td>
                                </tr>
                                <tr>
                                    <td><strong>Terminal :</strong></td><td> {{$terminal}} </td>
                                    <td><strong>Serve Time :</strong></td><td> {{$serveTime}} </td>
                                    <td><strong>PAX :</strong></td><td> {{$pax}} </td>
                                </tr>
                                <tr>
                                    <td><strong>Water Name :</strong></td><td> {{$waterName}} </td>
                                    <td><strong>Gust Name :</strong></td><td  colspan="3"> {{$gustName}} </td>
                                </tr>
                                <tr>
                                    <td><strong>Company Name :</strong></td><td> {{$companyName}} </td>
                                    <td><strong>E-mail :</strong></td><td> {{$email}} </td>
                                    <td><strong>Contact No. :</strong></td><td> {{$contactNo}} </td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        @php
                            $showVoid = true;
                        @endphp

                        @if(!empty($allMenuItems))
                            <div class="card-header">
                                <h3 class="card-title">Item details</h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th style="width: 40px">Price(s)</th>
                                        <th style="width: 40px">Qty</th>
                                        <th style="width: 40px">Kitchen</th>
                                        <th style="width: 40px">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allMenuItems as $allMenuItem)
                                        <tr>
                                            <td>{{$itencount++}}</td>
                                            <td>{{$allMenuItem['repID']}}</td>
                                            <td>{{$allMenuItem['repname']}}</td>
                                            <td>{{$allMenuItem['price']}}</td>
                                            <td>{{$allMenuItem['qty']}}</td>
                                            <td>{{$allMenuItem['kitchen']}}</td>
                                            <td>{{$allMenuItem['complete'] == 'Y' ? 'Completed' : 'Pending'}}</td>
                                            @php
                                                if ($allMenuItem['complete'] == 'Y' )
                                                $showVoid = false;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        @endif

                        @if(!empty($allMenuItems_new))
                            <div class="card-header">
                                <h3 class="card-title">Add Item</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th style="width: 40px">Price(s)</th>
                                        <th style="width: 40px">Qty</th>
                                        <th style="width: 40px">Kitchen</th>
                                        <th style="width: 40px">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allMenuItems_new as $allMenuItem_new)
                                        <tr>
                                            <td>{{$itencount_new++}}</td>
                                            <td>{{$allMenuItem_new['repID']}}</td>
                                            <td>{{$allMenuItem_new['repname']}}</td>
                                            <td>{{$allMenuItem_new['price']}}</td>
                                            <td>{{$allMenuItem_new['qty']}}</td>
                                            <td>{{$allMenuItem_new['kitchen']}}</td>
                                            <td class="{{$allMenuItem_new['complete'] == 'Y' ? 'btn btn-success' : ''}}">{{$allMenuItem_new['complete'] == 'Y' ? 'Completed' : 'Pending'}}</td>
                                            @php
                                                if ($allMenuItem_new['complete'] == 'Y' )
                                                $showVoid = false;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        @endif


                        @if(!empty($cancel_allMenuItems))
                            <div class="card-header">
                                <h3 class="card-title">Cancelled Item</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th style="width: 40px">Price(s)</th>
                                        <th style="width: 40px">Qty</th>
                                        <th style="width: 40px">Kitchen</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cancel_allMenuItems as $cancel_allMenuItem)
                                        <tr>
                                            <td>{{$cancel_itencount++}}</td>
                                            <td>{{$cancel_allMenuItem['repID']}}</td>
                                            <td>{{$cancel_allMenuItem['repname']}}</td>
                                            <td>{{$cancel_allMenuItem['price']}}</td>
                                            <td>{{$cancel_allMenuItem['qty']}}</td>
                                            <td>{{$cancel_allMenuItem['kitchen']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        @endif

                        <div class="card-body" id="printButton">
                            <div class="row">
                                @if($cancel == 'N' and $status!='2')
                                    <div class="col-md-3">
                                        {{-- <a href="{{ route('operator.qtyPrintPriview', ['billNo' => $billNo]) }}" class="btnprn"> --}}
                                        <button type="button" class=" btn btn-info btn-block" onclick="printContent('printQTY')" >Print</button>
                                        {{-- </a> --}}
                                    </div>
                                    @if($showVoid)
                                        <div class="col-md-3">
                                            <a href="#" onclick="return confirm('Are you sure to cancel KOT?')">
                                                <button type="button" class="btn btn-danger btn-block" >KOT Void</button>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-md-3">
                                        <a href="#">
                                            <button type="submit" class="btn btn-primary btn-block" >Edit</button>
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#" onclick="return confirm('Are you sure to cancel?')">
                                            <button type="button" class="btn btn-danger btn-block" >Exit</button>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.card -->

                <div class="card mx-auto" id="printQTY" style="display: none">
                    <div class="card-header">
                        <center>
                            <h4>Kitchen Order Token</h4>
                            {{$terminal}}
                        </center>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table ">
                            <tr>
                                <td><strong>Date:</strong></td><td> {{$date}} </td>
                                <td><strong>Time:</strong></td><td> {{$time}} </td>
                            </tr>
                            <tr>
                                <td><strong>Bill No:</strong></td><td> {{$billNo}} </td>
                                <td><strong>T/R:</strong></td><td> {{$tableNo}}/{{$roomNo}} </td>
                            </tr>

                            @if(!empty($allMenuItems))
                                @foreach($allMenuItems as $allMenuItem)
                                    <tr>
                                        <td colspan="3"><strong>{{$allMenuItem['repname']}}</strong></td>
                                        <td>{{$allMenuItem['qty']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Remarks:</td>
                                        <td colspan="3"> </td>
                                    </tr>
                                @endforeach
                            @endif

                            @if(!empty($allMenuItems_new))
                                <tr>
                                    <td colspan="4">Add Item</td>
                                </tr>

                                @foreach($allMenuItems_new as $allMenuItem_new)
                                    <tr>
                                        <td colspan="3"><strong>{{$allMenuItem_new['repname']}}</strong></td>
                                        <td>{{$allMenuItem_new['qty']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Remarks:</td>
                                        <td colspan="3"> </td>
                                    </tr>
                                @endforeach
                            @endif

                            @if(!empty($cancel_allMenuItems))
                                <tr>
                                    <td colspan="4">Cancelled Item</td>
                                </tr>

                                @foreach($cancel_allMenuItems as $cancel_allMenuItem)
                                    <tr>
                                        <td colspan="3"><strong>{{$cancel_allMenuItem['repname']}}</strong></td>
                                        <td>{{$cancel_allMenuItem['qty']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Remarks:</td>
                                        <td colspan="3"> </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
    </div>
    <!-- END CONTENT -->

@endsection
@section('customJs')
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/typeahead/typeahead.bundle.min.js"
            type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/global/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/admin/pages/scripts/components-form-tools.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/select2/select2.min.js"></script>

    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script src="{{ asset('/') }}/assets/admin/pages/scripts/components-dropdowns.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="{{ asset('/') }}/assets/admin/pages/scripts/table-advanced.js"></script>
@endsection
@section('documentJquery')
@endsection
