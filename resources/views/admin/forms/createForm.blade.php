@extends('admin.master')
<link rel="stylesheet" type="text/css"
      href="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
@section('styleSheet')
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}/assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/typeahead/typeahead.css">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
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
                        <a href="{{route('createForm')}}">create Form</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
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
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-horizontal form-row-seperated">
                        <div class="portlet">
                            <div id="app-form">
                                @if(session('message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                                    <div class="m-content">
                                        <div class="m-portlet m-portlet--mobile">
                                            <form id="add_from_group" class="m-form m-form--fit m-form--label-align-right" @submit.prevent="addFormGroup">
                                                <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                        <div class="m-portlet__head-title col-md-12">
                                                            <h3 class="m-portlet__head-text">
                                                                New Form group
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body">
                                                    <div class="m-form__section m-form__section--first">
                                                        <div class="form-group m-form__group row">
                                                            <label class="col-lg-1 col-form-label"  for="name">Name:<span class="required">*</span></label>
                                                            <div class="col-lg-6">
                                                                <input data-vv-as="Name" name="name" v-validate="'required|min:3|max:25'"  v-model="formgroup.name" type="text" class="form-control m-input" placeholder="Name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group m-form__group row" >
                                                            <label class="col-lg-1 col-form-label"  for="status">Status:<span class="required">*</span></label>
                                                            <div class="col-lg-6">
                                                                <select class="form-control m-input" data-vv-as="Status" v-validate="'required'" name="status" v-model="formgroup.status">
                                                                    <option value="">--Please Select--</option>
                                                                    <option value="Y">Active</option>
                                                                    <option value="N">Inactive</option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <table class="table table-striped m-table">
                                                            <thead>
                                                            <tr>
                                                                <th class="table-header" colspan="13">
                                                                    <h5 class="text-center mb-0">Form Field</h5>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Label</th>
                                                                <th>Name</th>
                                                                <th>Id</th>
                                                                <th>Type</th>
                                                                <th>Default Value</th>
                                                                <th>Max char</th>
                                                                <th>Order</th>
                                                                <th>Required</th>
                                                                <th>Class</th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr :id="'formfield_row_'+idx" v-for="(formfield, idx) in formgroup.formfields" :data-key="idx">
                                                                <td>
                                                                    <input data-vv-as="Label" name="flabel" v-model="formfield.label" type="text" class="form-control m-input" placeholder="Label">
                                                                </td>
                                                                <td>
                                                                    <input data-vv-as="Name" name="fname" v-model="formfield.name" type="text" class="form-control m-input" placeholder="Name">
                                                                </td>
                                                                <td>
                                                                    <input data-vv-as="Id" name="fid" v-model="formfield.fid" type="text" class="form-control m-input" placeholder="Id">
                                                                </td>

                                                                <td>
                                                                    <select data-vv-as="Type" name="type" v-model="formfield.type" class="form-control m-input mb-1" placeholder="Type">
                                                                        <option value="">---Select---</option>
                                                                        @foreach($inputTypes as $key=>$inputType)
                                                                            <option value="{{$key}}">{{$inputType}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div v-if="formfield.type == 'FS' || formfield.type == 'FR'" class="choice-option-value">
                                                                        <textarea class="form-control" name="options_value" v-model="formfield.options_value"></textarea>
                                                                        <small class="form-text text-muted form-help-block">value1##label1,value2##label2,value3##label3</small>
                                                                    </div>
                                                                </td>
                                                                <td width="60px">
                                                                    <input data-vv-as="Default Value" name="default_value" v-model="formfield.default_value" type="text" class="form-control m-input">
                                                                </td>
                                                                <td width="90px">
                                                                    <input v-if="formfield.type == 'FT' || formfield.type == 'FE' || formfield.type == 'TA'" data-vv-as="Max Char" name="fmax_char" v-model="formfield.fmax_char" type="number" class="form-control m-input">
                                                                </td>
                                                                <td width="90px">
                                                                    <input data-vv-as="Order" name="forder" v-model="formfield.forder" type="number" class="form-control m-input" placeholder="Order">
                                                                </td>
                                                                <td class="text-center">
                                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--state-success">
                                                                        <input data-vv-as="Required" name="required" v-model="formfield.required" type="checkbox"
                                                                               class="form-control m-input">
                                                                        <span></span>
                                                                    </label>
                                                                </td>
                                                                <td>
                                                                    <input data-vv-as="Class" name="class" v-model="formfield.class" type="text" class="form-control m-input" placeholder="Class">
                                                                </td>
                                                                <td>
                                                                    <a v-if="formfield.remove_button_hide == true" href="javascript:void(0)" class="btn btn-danger remove-row" @click.prevent="removeField(idx)">
                                                                        <i class="fa fa-remove"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <td colspan="13">
                                                                    <a href="javascript:void(0)" class="btn btn-info pull-right" @click.prevent="addMoreField()">
                                                                        <i class="fa fa-plus"></i> Add More
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions m-form__actions text-center">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END EXAMPLE TABLE PORTLET-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT-->
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
    <script src="{{ asset('/') }}/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
            type="text/javascript"></script>
    <script src="{{ asset('/') }}/assets/admin/pages/scripts/components-form-tools.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}/assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
    <script src="{{ asset('/') }}/assets/admin/pages/scripts/components-dropdowns.js"></script>
    <script type="text/javascript"
            src="{{ asset('/') }}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    formgroup: {
                        "name": '',
                        "status": '',
                        "formfields": [{
                            "label":"",
                            "name":"",
                            "fid":"",
                            "type":"",
                            "default_value":"",
                            "fmax_char":"",
                            "forder":"",
                            "required":"",
                            "class":"form-control",
                            "options_value":"",
                            "remove_button_hide": true
                        }]
                    },
                    validationErrors: {},
                    data:{}
                };
            },
            methods: {
                addFormGroup() {
                    // console.log(this.formgroup);
                    axios.post('{{route('addForm')}}', this.formgroup).then((res) => {
                        this.formgroup = {};
                        window.location.href = "{{ route('formList')}}";
                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });
                },
                addMoreField(){
                    this.formgroup.formfields.push({
                        "label":"",
                        "name":"",
                        "fid":"",
                        "type":"",
                        "default_value":"",
                        "fmax_char":"",
                        "forder":"",
                        "required":"",
                        "class":"form-control",
                        "options_value":"",
                        "remove_button_hide": false
                    });
                },
                removeField(idx){
                    this.formgroup.formfields.splice(idx, 1)
                },
            },
        });

        app.mount('#app-form');

    </script>
@endsection
