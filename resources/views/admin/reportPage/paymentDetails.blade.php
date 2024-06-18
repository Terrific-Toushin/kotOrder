@extends('admin.master')
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

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{route('home')}}">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="{{route('getAuditLogData')}}">Payment Details List</a>
                    </li>
                </ul>
            </div>
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
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Payment Details Info
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th>
                                Date
                            </th>
                            <th>
                                Transaction ID
                            </th>
                            <th>
                                Student ID
                            </th>
                            <th>
                                Program Type
                            </th>
                            <th>
                                Program Name
                            </th>
                            <th>
                                Program Amount
                            </th>
                            <th>
                                Payable Amount
                            </th>
                            <th>
                                Paid Status
                            </th>
                            <th>
                                Remarks
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paymentList as $payment)
                            <tr>
                                <td>
                                    {{$payment->updated_at}}
                                </td>
                                <td>
                                    {{$payment->pay_txid}}
                                </td>
                                <td>
                                    {{$payment->student_id}}
                                </td>
                                <td>
                                    {{$payment->page_type}}
                                </td>
                                <td>
                                    {{$payment->course_name}}
                                </td>
                                <td>
                                    {{$payment->amount}}
                                </td>
                                <td>
                                    {{$payment->custom_amount == "0" ? $payment->amount : $payment->custom_amount}}
                                </td>
                                <td>
                                    {{$paymentStatus[$payment->paid_status]}}
                                </td>
                                <td>
                                    {{$payment->Remarks != "" ? $payment->Remarks : "N/A"}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
{{--            <div class="portlet box yellow">--}}
{{--                <div class="portlet-title">--}}
{{--                    <div class="caption">--}}
{{--                        <i class="fa fa-gift"></i>Payment Info--}}
{{--                    </div>--}}
{{--                    <div class="tools">--}}
{{--                        <a href="javascript:;" class="collapse">--}}
{{--                        </a>--}}
{{--                        <a href="javascript:;" class="reload">--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="portlet-body">--}}
{{--                    <table class="table table-hover table-striped table-bordered" style="border-collapse: collapse;table-layout: fixed;width: 100%;">--}}
{{--                        <thead>--}}
{{--                            <tr role="row" class="heading">--}}
{{--                                <th width="11%">--}}
{{--                                    ID--}}
{{--                                </th>--}}
{{--                                <th width="7%">--}}
{{--                                    Student ID--}}
{{--                                </th>--}}
{{--                                <th width="11%">--}}
{{--                                    Course Type--}}
{{--                                </th>--}}
{{--                                <th width="15%">--}}
{{--                                    Amount--}}
{{--                                </th>--}}
{{--                                <th width="15%">--}}
{{--                                    Custom Payment--}}
{{--                                </th>--}}
{{--                                <th width="15%">--}}
{{--                                    Remarks--}}
{{--                                </th>--}}
{{--                                <th width="30%">--}}
{{--                                    Payment Status--}}
{{--                                </th>--}}
{{--                                <th width="30%">--}}
{{--                                    Details--}}
{{--                                </th>--}}
{{--                            </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @dump($paymentList)--}}
{{--                        @foreach($allAuditLog as $auditLog)--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    {{$auditLog->date_time}}--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    {{$auditLog->ip}}--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    {{$auditLog->name}}--}}
{{--                                </td>--}}
{{--                                <td style="border:solid 1px #ddd; width:100px; word-wrap:break-word;">--}}
{{--                                    {{$auditLog->page_URL}}--}}
{{--                                </td>--}}
{{--                                <td style="border:solid 1px #ddd; width:100px; word-wrap:break-word;">--}}
{{--                                    <span class="text-wrap">{!! $auditLog->log_text !!}</span>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    </table>--}}
                    <!-- responsive -->

{{--                </div>--}}
{{--                @dump($allAuditLog)--}}
{{--                <div style="float: right">{!! $allAuditLog->withQueryString()->links('pagination::bootstrap-4') !!}</div>--}}
{{--                <div style="float: right">{!! $allAuditLog->withQueryString()->links('pagination::bootstrap-5') !!}</div>--}}
{{--                {!! $allAuditLog->appends(['sort' => 'votes'])->links() !!}--}}
{{--            </div>--}}
            <!-- END PORTLET-->
        </div>
    </div>
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
    @if(Session::has('success'))
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript">
            $.bootstrapGrowl('{{ Session::get('success') }}', {
                ele: 'body', // which element to append to
                type: 'info', // (null, 'info', 'danger', 'success', 'warning')
                offset: {
                    from: 'top',
                    amount: 50
                }, // 'top', or 'bottom'
                align: 'right', // ('left', 'right', or 'center')
                width: 'auto', // (integer, or 'auto')
                delay: 10000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                allow_dismiss: 1, // If true then will display a cross to close the popup.
                stackup_spacing: 10 // spacing between consecutively stacked growls.
            });
        </script>
    @endif
@endsection
@section('documentJquery')
    {{--    <script>--}}
    TableAdvanced.init();
    {{--    </script>--}}
@endsection
