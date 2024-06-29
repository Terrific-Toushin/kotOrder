@extends('admin.master')
@section('styleSheet')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/typeahead/typeahead.css">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
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
                        <a href="{{route('userList')}}">User List</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">User Info</a>
                    </li>
                </ul>
            </div>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>User Info
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                        <a href="javascript:;" class="reload">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form  class="form-horizontal form-row-seperated" method="POST" action="{{ route('storeUser') }}" enctype="multipart/form-data" name="UserInfo">
                                @csrf
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Profile Image:</label>
                                    <div class="col-md-3">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">

                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>

                                            <div>
                                                                    <span class="btn default btn-file">
                                                                        <span class="fileinput-new">Select image </span>
                                                                        <span class="fileinput-exists">Change </span>
                                                                        <input type="file" class="form-control" name="photo" placeholder="" accept="image/*">
                                                                    </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">Remove </a>
                                            </div>
                                        </div>



                                    </div>
                                    @if(!empty($userInfo->photo))
                                        <div class="col-md-6">
                                            <label class="col-md-2 control-label">Current Image</label>
                                            <img src="{{asset($userInfo->photo)}}" style="width: 200px; height: 150px;">
                                        </div>
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Name: <span class="required">
                                                                * </span>
                                    </label>
                                    <div class="col-md-10">
                                        @if(!empty($userInfo))
                                            <input type="hidden" class="form-control" name="id" value="{{$userInfo->id}}" autocomplete="off">
                                        @endif
                                        <input type="text" class="form-control" name="name" value="{{!empty($userInfo) ? $userInfo->name : ''}}" placeholder="Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">User Name: <span class="required">
                                                                * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="username" value="{{!empty($userInfo) ? $userInfo->username : ''}}" placeholder="User Name" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email: <span class="required"> * </span></label>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control" name="email" value="{{!empty($userInfo) ? $userInfo->email : ''}}" placeholder="Email Address" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Contact: <span class="required"> * </span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="phone" value="{{!empty($userInfo) ? $userInfo->phone : ''}}" placeholder="Contact Number" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Address: <span class="required"> * </span></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="address" value="{{!empty($userInfo) ? $userInfo->address : ''}}" placeholder="Mail Address" autocomplete="off">
                                    </div>
                                </div>
                                @if(empty($userInfo) || $userInfo->role == 'admin')
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">User Role: <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-2">
                                            <select id="role" class="form-control input-medium select2me"
                                                    data-placeholder="Role Type..." name="role" onchange="showOutlets()">
                                                <option value=""></option>
                                                @foreach($userType as $key => $type)
                                                    <option value="{{$key}}" {{!empty($userInfo->role) && $userInfo->role == $key ? 'selected' : ''}}>
                                                        {{$type}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block help-block-error" style="color: red;">@if($errors->has('role')) {{$errors->first('role')}} @endif</span>
                                        </div>
                                    </div>
                                    <div id="form-outlet" class="form-group">
                                        <input data-vv-as="Form Group" name="privileges[]" type="hidden" class="form-control m-input" value="*">
                                        <label  id="outletsLabel" class="col-md-2 control-label" style="display: {{!empty($userInfo) && $userInfo->role == 'operator' ? 'block' : 'none'}}">Outlets: <span class="required"> * </span></label>
                                        <div id="outletsDiv" class="col-md-10" style="display: {{!empty($userInfo) && $userInfo->role == 'operator' ? 'block' : 'none'}}">
                                            <ul class="list-inline">
                                                @foreach($outlets as $outlet)
                                                    <li class="list-inline-item">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--state-success">
                                                            <input data-vv-as="Form Group" name="outlets[]" type="checkbox" class="form-control m-input" id="outlet-{{ $outlet->ResSL }}" value="{{ $outlet->ResSL }}" {{!empty($userInfo->outlets) && ($userInfo->outlets != "null") && array_search($outlet->ResSL, json_decode($userInfo->outlets,true)) !== false ? 'checked' : ''}}>
                                                            <span></span> {{$outlet->ResName}}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="form-kitchen" class="form-group">
                                        <label  id="kitchenLabel" class="col-md-2 control-label" style="display: {{!empty($userInfo) && $userInfo->role == 'kitchen' ? 'block' : 'none'}}">Kitchen: <span class="required"> * </span></label>
                                        <div id="kitchenDiv" class="col-md-10" style="display: {{!empty($userInfo) && $userInfo->role == 'kitchen' ? 'block' : 'none'}}">
                                            <ul class="list-inline">
                                                @foreach($kitchen as $kitchenOutlet)
                                                    <li class="list-inline-item">
                                                        <label class="m-checkbox m-checkbox--solid m-checkbox--state-success">
                                                            <input data-vv-as="Form Group" name="kitchens[]" id="outlet-{{ $kitchenOutlet }}" type="checkbox" class="form-control m-input" value="{{ $kitchenOutlet }}" {{!empty($userInfo->outlets) && ($userInfo->outlets != "null") && array_search($kitchenOutlet, json_decode($userInfo->outlets,true)) !== false ? 'checked' : ''}}>
                                                            <span></span> {{$kitchenOutlet}}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                @if(empty($userInfo))
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Password</label>
                                        <div class="col-md-10">
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Re-type Password</label>
                                        <div class="col-md-10">
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                @endif
                                @if(empty($userInfo) || $userInfo->role == 'admin')
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Status: <span class="required">
                                                                    * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control input-medium select2me"
                                                    data-placeholder="Status..." name="status">
                                                <option value=""></option>
                                                <option value="Y" {{!empty($userInfo->status) && $userInfo->status == 'Y' ? 'selected' : ''}}>Active</option>
                                                <option value="N" {{!empty($userInfo->status) && $userInfo->status == 'N' ? 'selected' : ''}}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success" style="float: right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
{{--            @if(!empty($userInfo) && Auth::user()->id == $userInfo->id)--}}
            @if(!empty($userInfo))
                <div class="portlet box red">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Change Password
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form  class="form-horizontal form-row-seperated" method="POST" action="{{ route('changePasswordUser') }}" enctype="multipart/form-data" name="userInfo">
                                    @csrf
                                    <input type="hidden" class="form-control" name="id" value="{{$userInfo->id}}" autocomplete="off">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Password</label>
                                        <div class="col-md-10">
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Re-type Password</label>
                                        <div class="col-md-10">
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success" style="float: right">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
    <script src="{{ asset('/') }}assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-form-tools.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script src="{{ asset('/') }}assets/admin/pages/scripts/components-dropdowns.js"></script>
    <script>
        function showOutlets(){
            let roleType = document.getElementById("role").value;
            // console.log(roleType);
            if(roleType == 'operator'){
                document.getElementById('outletsDiv').style.display = 'block';
                document.getElementById('outletsLabel').style.display = 'block';
                document.getElementById('kitchenDiv').style.display = 'none';
                document.getElementById('kitchenLabel').style.display = 'none';
            }else if(roleType == 'kitchen'){
                document.getElementById('kitchenDiv').style.display = 'block';
                document.getElementById('kitchenLabel').style.display = 'block';
                document.getElementById('outletsDiv').style.display = 'none';
                document.getElementById('outletsLabel').style.display = 'none';
            }else {
                document.getElementById('outletsDiv').style.display = 'none';
                document.getElementById('outletsLabel').style.display = 'none';
                document.getElementById('kitchenDiv').style.display = 'none';
                document.getElementById('kitchenLabel').style.display = 'none';
            }
        }
    </script>
@endsection

@section('documentJquery')
    ComponentsFormTools.init();
{{--    <script>--}}

{{--    </script>--}}
@endsection
