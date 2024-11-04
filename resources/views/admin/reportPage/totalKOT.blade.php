@extends('admin.master')
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
            @include('admin.includes.adminBar')
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
            <div class="row">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box green ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i> Search
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="col-md-12 form-group" id='errMsg'>
                        </div>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('newOrderItemSave') }}">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-1">Date</label>
                                    <div class="col-md-4">
                                        <div class="input-group input-large date-picker input-daterange">
                                            <input id="start_time" type="date" class="form-control" data-date-format="dd/mm/yyyy" name="start_time" autocomplete="off" required>
                                            <span class="input-group-addon">
												to </span>
                                            <input id="end_time" type="date" class="form-control" data-date-format="dd/mm/yyyy" name="end_time"  autocomplete="off" required>
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <label class="col-md-1 control-label">Outlet</label>
                                    <div class="col-md-2">
                                        <select id="outlet_id" class="select2_category form-control" data-placeholder="Choose a Outlet" tabindex="1" name="outlet_id" autocomplete="off">
                                            <option value="">Choose a Outlet</option>
                                            @foreach($outletList as $outlet)
                                                <option value="{{$outlet->ResSL}}">{{$outlet->ResName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-md-1 control-label">Operator</label>
                                    <div class="col-md-2">
                                        <select id="user_id" class="select2_category form-control" data-placeholder="Choose a Operator" tabindex="1" name="user_id" autocomplete="off">
                                            <option value="">Choose a Operator</option>
                                            @foreach($userList as $user)
                                                <option value="{{$user->username}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="formSubmit" style="text-align: right;margin-right: 15px;margin-top: 50px;">
                                        <button type="button" class="btn green" onclick="filterData()">Search</button>
                                    </div>
                                </div>
                                <div class="form-group">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
            <!-- BEGIN PORTLET-->
            <div class="row">
                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Total Kot History
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-hover table-striped table-bordered" id="sample_pending">
                            <thead>
                            <tr role="row" class="heading">
                                <th>Date</th>
                                <th>Bill No.</th>
                                <th>T/R</th>
                                <th>Terminal</th>
                                <th>Serve Time</th>
                                <th>PAX</th>
                                <th>Water Name</th>
                                <th>Gust Name</th>
                                <th>Contact No</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($total_kots as $kots)
                                <tr>
                                    <td>{{date('d-m-Y',strtotime($kots->date))}}</td>
                                    <td>{{$kots->billNo}}</td>
                                    <td>{{$kots->tableNo}}{{$kots->roomNo}}</td>
                                    <td>{{$kots->terminal}}</td>
                                    <td>{{$kots->serveTime}}</td>
                                    <td>{{$kots->pax}}</td>
                                    <td>{{$kots->waterName}}</td>
                                    <td>{{$kots->gustName}}</td>
                                    <td>{{$kots->contactNo}}</td>
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
    {{--<script src="{{ asset('/') }}assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>--}}
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
    {{--    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-pickers.js"></script>--}}

@endsection
@section('documentJquery')
{{--    <script>--}}
{{--        TableAdvanced.init();--}}
        FormSamples.init();
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var table = $('#sample_pending').DataTable({
            lengthChange: false,
            responsive: true,
            scrollX:true,
            buttons: ['csv', 'excel', 'pdf', 'print'],
            layout: {
                topStart: 'buttons'
            }
        });
        window.filterData = function() {
            const start_time = document.getElementById('start_time').value;
            const end_time = document.getElementById('end_time').value;
            const outlet_id = document.getElementById('outlet_id').value;
            const user_id = document.getElementById('user_id').value;

            axios.post('{{ route('filterTotalKot') }}', {
                start_time: start_time,
                end_time: end_time,
                outlet_id: outlet_id,
                user_id: user_id
            })
                .then(function (response) {
                    // Handle success
                    const data = response.data;
                    const tableBody = document.querySelector('#sample_pending tbody');
                    tableBody.innerHTML = ''; // Clear existing rows

                    // Clear the table
                    table.clear();
                    if (data.length > 0) {
                        // Add rows to the table
                        data.forEach((kots, index) => {
                            const formattedDate = new Date(kots.date).toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });

                            table.row.add([
                                formattedDate,
                                kots.billNo,
                                (kots.tableNo ? kots.tableNo : '') + (kots.roomNo ? kots.roomNo : ''),
                                kots.terminal,
                                kots.serveTime,
                                kots.pax + 'Person',
                                kots.waterName,
                                kots.gustName,
                                kots.contactNo,
                                `<a href="/admin-kotView/${kots.billNo}" class="btnprn">
                                            <button type="button" class="btn btn-info">Details</button>
                                        </a>`
                            ]);
                        });
                    }

                    // Redraw the table to update pagination
                    table.draw();

                })
                .catch(function (error) {
                    // Handle error
                    console.log(error);
                });
        }
{{--    </script>--}}
@endsection
