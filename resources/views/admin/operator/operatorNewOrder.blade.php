@extends('admin.operator')
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
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/datatables/media/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <style>
        /* Hide the spinners for all number inputs */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }

        /* Make buttons and input field the same height */
        .input-custom-group .btn {
            height: 36px;
            margin-top: .2vh; /* Same height for input and buttons */
        }

        /* Center the number vertically in the input field */
        .input-group .form-control {
            display: flex;
            align-items: center;
            text-align: center;
            padding: 0; /* Reset padding */
        }

        .input-group .form-control::placeholder {
            text-align: center;
        }

        .modal-custom-css{
            padding: 20px;
        }
        .modal-custom-css label{
            padding: 10px;
            float: left;
        }
        .modal-custom-css textarea{
            border: solid 1px gray;
            width: 84%;
        }
        .modal-custom-css button{
            float: right;
            margin-top: 10px;
        }
    </style>
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
                        <a href="{{route('operatorDashboard')}}">Operator Dashboard @if(Session::has('uotletName')) <b>{{ Session::get('uotletName')}}</b> @endif</a>
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
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box purple ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i> New Order
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                            <a href="" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="col-md-12 form-group" id='errMsg'>
                        </div>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('newOrderItemSave') }}">
                            @csrf
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Bill NO (<span>{{$bill_No}}</span>)</label>
                                    <div class="col-md-2">
                                        <input type="text" name="billNo" class="form-control" placeholder="Bill Number" value="{{$bill_No+1}}" readonly>
                                    </div>
                                    <label class="col-md-1 control-label">Table NO</label>
                                    <div class="col-md-2">
                                        <input id="tableNo" type="text" name="tableNo" class="form-control" placeholder="Table Number" onblur="onTableNo()" >
                                    </div>
                                    <label class="col-md-1 control-label">Room NO</label>
                                    <div class="col-md-2">
                                        <input id="roomNo" type="text" name="room" class="form-control" placeholder="Room Number" onkeypress="onRoomNo()" onclick="onRoomNo()" >
                                    </div>
                                    <label class="col-md-1 control-label">Terminal</label>
                                    <div class="col-md-2">
                                        <select class="form-control" name="terminal">
                                            <option value="Restaurant">Restaurant</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Serve Time</label>
                                    <div class="col-md-2">
                                        <select class="form-control" name="serveTime">
                                            <option value="Breakfast">Breakfast</option>
                                            <option value="Lunch">Lunch</option>
                                            <option value="Dinner">Dinner</option>
                                        </select>
                                    </div>
                                    <label class="col-md-1 control-label">PAX</label>
                                    <div class="col-md-2">
                                        <input id="pax" type="number" name="pax" min="1" class="form-control" placeholder="Number Of Guest" onchange="showItemList()">
                                    </div>
                                    <label class="col-md-1 control-label">Guest Name</label>
                                    <div class="col-md-2">
                                        <input type="text" name="gustName" class="form-control" placeholder="Guest Name">
                                    </div>
                                    <label class="col-md-1 control-label">Contact No</label>
                                    <div class="col-md-2">
                                        <input type="text" name="contactNo" class="form-control" placeholder="Contact Number">
                                    </div>
                                </div>

                            </div>
                            <div id="orderItemList" class="row" style="display: none">
                                <div class="col-sm-6" style="padding-right: 2px">
                                    <!-- Begin: life time stats -->
                                    <div class="portlet box blue-steel">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-thumb-tack"></i>Item List
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse"></a>
{{--                                                <a href="javascript:;" class="reload"></a>--}}
                                                <a href="javascript:;" class="remove"></a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tabbable-line">
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#overview_1" data-toggle="tab">
                                                            All Item</a>
                                                    </li>
                                                @foreach($kitchen as $kitchen_type)
                                                    <li><a href="#{{str_replace(' ', '_', $kitchen_type)}}" data-toggle="tab">{{$kitchen_type}}</a></li>
                                                @endforeach
                                                </ul>
                                                <div class="tab-content">

                                                    <div class="tab-pane active" id="overview_1">
                                                        <div class="table-responsive">
                                                            <table  class="table table-striped table-bordered table-hover display" id="sample_food"  style="width: 100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Price(s)</th>
                                                                    <th>Kitchen</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($tblMenu_data as $tblMenu)
                                                                    <tr>
                                                                        {{--                                  <td>{{$tblMenu->repid}}</td>--}}
                                                                        <td>{{$tblMenu->repname}}</td>
                                                                        <td>{{ number_format((float)($tblMenu->price), 2)}}</td>
                                                                        <td>{{$tblMenu->kitchen}}</td>
                                                                        <td><div id="add-{{$tblMenu->repid}}" class="btn btn-info btn-block add-{{$tblMenu->repid}}" onclick="addItem('{{$tblMenu->repid}}','{{$tblMenu->repname}}','{{number_format((float)($tblMenu->price), 2)}}','{{number_format((float)($tblMenu->itemcost), 2)}}','{{$tblMenu->kitchen}}')" >Add</div></td>

                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    @foreach($kitchen as $kitchen_type)
                                                        <div class="tab-pane" id="{{str_replace(' ', '_', $kitchen_type)}}">
                                                            <div class="table-responsive">
                                                                <table  class="table table-striped table-bordered table-hover display" style="width: 100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Price(s)</th>
                                                                        <th>Kitchen</th>
                                                                        <th></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($tblMenu_data as $tblMenu)
                                                                        @if($tblMenu->kitchen==$kitchen_type)
                                                                            <tr>
                                                                                <td>{{$tblMenu->repname}}</td>
                                                                                <td>{{ number_format((float)($tblMenu->price), 2)}}</td>
                                                                                <td>{{$tblMenu->kitchen}}</td>
                                                                                <td><div id="add-{{$tblMenu->repid}}" class="btn btn-info btn-block add-{{$tblMenu->repid}}" onclick="addItem('{{$tblMenu->repid}}','{{$tblMenu->repname}}','{{number_format((float)($tblMenu->price), 2)}}','{{number_format((float)($tblMenu->itemcost), 2)}}','{{$tblMenu->kitchen}}')" >Add</div></td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End: life time stats -->

                                </div>
                                <div class="col-md-6" style="padding-left: 2px">
                                    <!-- Begin: life time stats -->
                                    <div class="portlet box green-haze">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-thumb-tack"></i>Order Item List
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse">
                                                </a>
                                                <a href="javascript:;" class="remove">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="table-responsive">
                                                <input type="hidden" id="itemCount" name="itemCount" value="0">
                                                <table  class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th width="3%"></th>
                                                        <th>Name</th>
                                                        <th>Price(s)</th>
                                                        <th>Quantity</th>
                                                        <th>Kitchen</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="itemTable"></tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="6">
                                                            <div class="form-group row">
                                                                <label for="total" class="col-sm-2 col-form-label">Totel :</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" readonly class="form-control-plaintext" id="total" value="0" style="border: solid transparent; width: 15%">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                <div id="modalItem"></div>
                                                <div id="formSubmit" class="form-actions right" style="display: none">
                                                    <button type="submit" class="btn green">Send New KOT</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End: life time stats -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
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
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/select2/select2.min.js"></script>

{{--    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>--}}
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/datatables.min.js"></script>
{{--    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>--}}
{{--    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>--}}
{{--    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>--}}
{{--    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>--}}


    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-dropdowns.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="{{ asset('/') }}assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/form-wizard.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-form-tools.js"></script>
    <script>
        function onTableNo(){
            var roomNo = document.getElementById("roomNo")
            roomNo.value="";
            roomNo.required = false;

            var tableNo = document.getElementById("tableNo")
            tableNo.required = true;
        }

        function onRoomNo(){
            var tableNo = document.getElementById("tableNo")
            tableNo.value="";
            tableNo.required = false;


            var roomNo = document.getElementById("roomNo")
            roomNo.required = true;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('keyup','#tableNo',function(e){
            e.preventDefault();
            let tableNo_string = $('#tableNo').val();

            $.ajax({
                url:'{{ route('tableExist') }}',
                method:'GET',
                data:{tableNo:tableNo_string},
                success:function(res){
                    if(res=='true'){
                        $('#tableNo').val('');
                        $('#errMsg').html('<div class="alert alert-danger" role="alert">This Table No already occupied</div>');
                    }else{
                        $('#errMsg').html('');
                    }
                }
            });
        });

        $(document).on('keyup','#roomNo',function(e){
            e.preventDefault();
            let roomNo_string = $('#roomNo').val();

            $.ajax({
                url:'{{ route('roomExist') }}',
                method:'GET',
                data:{roomNo:roomNo_string},
                success:function(res){
                    if(res=='true'){
                        $('#roomNo').val('');
                        $('#errMsg').html('<div class="alert alert-danger" role="alert">This Room No already occupied</div>');
                    }else{
                        $('#errMsg').html('');
                    }
                }
            });
        });

        $(document).on('click','#roomNo',function(e){
            e.preventDefault();
            let roomNo_string = $('#roomNo').val();

            $.ajax({
                url:'{{ route('roomExist') }}',
                method:'GET',
                data:{roomNo:roomNo_string},
                success:function(res){
                    if(res=='true'){
                        $('#errMsg').html('<div class="alert alert-danger" role="alert">This Room No already occupied</div>');
                    }else{
                        $('#errMsg').html('');
                    }
                }
            });
        });

        function increment(countID){
            let qty = document.getElementById("qty"+countID);
            qty.value = parseInt(qty.value) + 1;
            indItem(countID);
        }

        function decrement(countID){
            let qty = document.getElementById("qty"+countID);
            if(parseInt(qty.value) != 1){
                qty.value = parseInt(qty.value) - 1;
            }
            indItem(countID);

        }

        // var item = 0;
        function addItem(repid,repname,price,itemcost,kitchen){
            var itemCount = document.getElementById("itemCount").value;
            var total = document.getElementById("total").value;
            ++itemCount;
            document.getElementById("itemCount").value=itemCount;
            document.getElementById("total").value=parseFloat(total) + parseFloat(price.replace(",", ""),'2');
            // document.getElementById('add-'+repid).style.display = 'none';
            var divsToHide = document.getElementsByClassName('add-'+repid); //divsToHide is an array
            for(var i = 0; i < divsToHide.length; i++){
                divsToHide[i].style.display = "none"; // depending on what you're doing
            }
            let str = '<tr><td><a class="btn default" data-target="#stack'+[itemCount]+'" data-toggle="modal"><i class="fa fa-comments-o"></i></a></td><td>'+repname+'</td>';
            str += '<td><span id="priceT'+[itemCount]+'">'+parseFloat(price.replace(",", ""),'2')+'</span><input type="hidden"  readonly id="price'+[itemCount]+'" name="price'+[itemCount]+'" class="form-control-plaintext" size="7" value="'+parseFloat(price.replace(",", ""),'2')+'"></td>';
            str += '<td><div class="input-group"><div class="spinner-buttons input-group-btn"><div class="btn spinner-down red decrement" onclick="decrement('+[itemCount]+')"><i class="fa fa-minus"></i></div></div> <input type="number" class="spinner-input form-control quantity" style="min-width: 25px" id="qty'+[itemCount]+'" name="qty'+[itemCount]+'" min="1" size="2" value="1" onchange="indItem('+[itemCount]+')"><input type="hidden"  id="priviasQty'+[itemCount]+'" name="priviasQty'+[itemCount]+'" value="1""><div class="spinner-buttons input-group-btn"><div class="btn spinner-up blue increment" onclick="increment('+[itemCount]+')"><i class="fa fa-plus"></i></div></div></div></td>';
            str += '<td>'+kitchen+'</td>';
            str += '<td><div class="btn btn-danger btn-sm remove-table-row"><i class="fa fa-trash-o"></i></div><input type="hidden" id="repid'+[itemCount]+'" name="repid'+[itemCount]+'" value="'+repid+'"><input type="hidden" id="kitchen'+[itemCount]+'" name="kitchen'+[itemCount]+'" value="'+kitchen+'"></td> </tr>';

            let modalStr = '<div id="stack'+[itemCount]+'" class="modal fade modal-custom-css" tabindex="-1" data-focus-on="input:first">';
            modalStr += '<label>Remark </label>';
            modalStr += '<textarea name="remark'+[itemCount]+'" placeholder="Food Remark" autocomplete="off"></textarea>';
            modalStr += '<button type="button" data-dismiss="modal" class="btn btn-sm btn-success">Save</button>';
            modalStr += '</div>';
            $('#itemTable').append(str);
            $('#modalItem').append(modalStr);
            document.getElementById('formSubmit').style.display = 'block';
        }

        function showItemList(){
            if(document.getElementById("pax").value >= 1){
                document.getElementById('orderItemList').style.display = 'block';
            }else {
                document.getElementById('orderItemList').style.display = 'none';
            }
        }

        $(document).on('click','.remove-table-row', function(){

            var price = $(this).closest('tr').find('td:eq(2)').text();
            let productId = $(this).closest('tr').find('td:eq(0)').text();
            var total = document.getElementById("total").value;

            document.getElementById("total").value=parseFloat(total) == parseFloat(price.replace(",", ""),'2') ? 0 : parseFloat(total) - parseFloat(price.replace(",", ""),'2');
            // alert(price);
            // document.getElementById('add-'+productId).style.display = 'block';
            var divsToHide = document.getElementsByClassName('add-'+productId); //divsToHide is an array
            for(var i = 0; i < divsToHide.length; i++){
                divsToHide[i].style.display = "block"; // depending on what you're doing
            }
            $(this).parents('tr').remove();
        });

        function indItem(countID){
            var qty = document.getElementById("qty"+countID).value;
            var priviasQty = document.getElementById("priviasQty"+countID).value;
            console.log('qty = '+qty);
            console.log('priviasQty = '+priviasQty);
            if(qty!=priviasQty){
                var qtPrice = document.getElementById("price"+countID).value;
                var priceT = document.getElementById("priceT"+countID).value;
                var total = document.getElementById("total").value;
                var totalVal = "";

                var cPrice = parseFloat(qtPrice) - parseFloat(priceT);

                var qtyTotalPrice = (qty*qtPrice);

                if(qty>priviasQty){
                    let incPrice = qty - priviasQty;
                    let incToPrice = parseFloat(incPrice*qtPrice);
                    totalVal = (parseFloat(total)+parseFloat(incToPrice));
                }else{
                    let incPrice = priviasQty - qty;
                    let incToPrice = parseFloat(incPrice*qtPrice);
                    totalVal = (parseFloat(total)-parseFloat(incToPrice));
                }

                document.getElementById("priceT"+countID).innerText=qtyTotalPrice;
                document.getElementById("total").value = totalVal;
                // alert(qtyTotalPrice);
            }
            document.getElementById("priviasQty"+countID).value = qty;

        }
    </script>
@endsection
@section('documentJquery')
    QuickSidebar.init(); // init quick sidebar
    Demo.init(); // init demo features
    FormWizard.init();
    ComponentsFormTools.init();
{{--    TableAdvanced.init();--}}
    document.getElementById("total").value = 0;
    new DataTable('table.display', {
    lengthChange: false
    });
@endsection
