
@extends('admin.master')

@section('title', 'Product')

@section('body')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Entry Product Form</h3><br/>

                    <h5 class="text-success">{{ Session::get('message') }}</h5>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Entry Product</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form action="#" method="post" enctype="multipart/form-data" name="editJournalVoucher">

                                @csrf
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Product Name</label>
                                        <input class="form-control" name="name" type="text" id="dates">
                                        <small class="text-danger">{{ $errors->has('name') ? $errors->first('name') : ' ' }}</small>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Category Name</label>
                                        <select id="company_name_id" class="form-control js-example-basic-single" name="category_id">
                                            <option>-- Select Category Name --</option>

                                        </select>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Sub Category Name</label>
                                        <select id="company_name_id" class="form-control js-example-basic-single" name="sub_category_id">
                                            <option>-- Select Sub Product Name --</option>

                                        </select>
                                        <small class="text-danger">{{ $errors->has('sub_category_id') ? $errors->first('sub_category_id') : ' ' }}</small>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Product Type</label>
                                        <select id="company_name_id" class="form-control js-example-basic-single" name="product_status_id">
                                            <option>-- Select Sub Product Type --</option>
                                        </select>
                                        <small class="text-danger">{{ $errors->has('product_status_id') ? $errors->first('product_status_id') : ' ' }}</small>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Product Ratings</label>
                                        <input class="form-control" name="Product_code" type="number" id="Product_code" placeholder="Product_code">
                                        <small class="text-danger">{{ $errors->has('Product_code') ? $errors->first('Product_code') : ' ' }}</small>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Product Unit Price</label>
                                        <input class="form-control" name="price" type="number" id="price" placeholder="Product Unit Price">
                                        <small class="text-danger">{{ $errors->has('price') ? $errors->first('price') : ' ' }}</small>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Product new Price</label>
                                        <input class="form-control" name="newprice" type="number" id="price" placeholder="Product new Price">
                                        <small class="text-danger">{{ $errors->has('newprice') ? $errors->first('newprice') : ' ' }}</small>
                                    </div>

                                    <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                        <label style="font-size: 14px;">Product Quantity</label>
                                        <input class="form-control" name="quantity" type="number" id="quantity" value="">
                                        <small class="text-danger">{{ $errors->has('quantity') ? $errors->first('quantity') : ' ' }}</small>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                            <label style="font-size: 14px;">Skin</label>
                                            <input class="form-control" name="newprice" type="text" id="price" placeholder="Product new Price">
                                            <small class="text-danger">{{ $errors->has('newprice') ? $errors->first('newprice') : ' ' }}</small>
                                        </div>

                                        <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                            <label style="font-size: 14px;">size(LxWxH)</label>
                                            <input class="form-control" name="quantity" type="text" id="quantity" value="">
                                            <small class="text-danger">{{ $errors->has('quantity') ? $errors->first('quantity') : ' ' }}</small>
                                        </div>

                                        <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                            <label style="font-size: 14px;">Weight</label>
                                            <input class="form-control" name="quantity" type="text" id="quantity" value="">
                                            <small class="text-danger">{{ $errors->has('quantity') ? $errors->first('quantity') : ' ' }}</small>
                                        </div>

                                        <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                            <label style="font-size: 14px;">Other's Specification</label>
                                            <input class="form-control" name="quantity" type="text" id="quantity" value="">
                                            <small class="text-danger">{{ $errors->has('quantity') ? $errors->first('quantity') : ' ' }}</small>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-12 col-xs-12" style="padding-left: 20px;">
                                                <label style="font-size: 14px;">Description</label>
                                                <textarea class="form-control" id="editor" name="description" placeholder="Type Detail About Product...."></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3 col-sm-12 col-xs-12"  style="margin-top: 10px">
                                                <label for="logo">product_image</label>
                                                <input type="file" name="image" accept="image/*"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"  style="margin-top: 10px" for="name">Status</label>
                                            <div class="">
                                                <label><input type="radio" name="publication_status" value="1"/> Published </label>
                                                <label><input type="radio" name="publication_status" value="0"/> Unpublished </label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                            <label style="font-size: 14px;">Item Promotion</label>
                                            <select id="company_name_id" class="form-control js-example-basic-single" name="product_status_id">
                                                <option>-- Select Product Promotion --</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->has('product_status_id') ? $errors->first('product_status_id') : ' ' }}</small>
                                        </div>

                                        <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                            <div class="control-group">
                                                <label class="control-label">Input Tags</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12">
                                                    <input id="tags_1" type="text" class="tags form-control" value="social, adverts, sales" />
                                                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-lg-3 col-xs-12" style="margin-top: 10px">
                                            <label style="font-size: 14px;">Colors</label>
                                            <input class="form-control" name="quantity" type="text" id="quantity" value="">
                                            <small class="text-danger">{{ $errors->has('quantity') ? $errors->first('quantity') : ' ' }}</small>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-3 col-sm-12 col-xs-12"  style="margin-top: 10px">
                                                <label for="logo">product sub image</label>
                                                <input type="file" name="product_sub_image[]" accept="image/*"/>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Input Tags</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="tags_1" type="text" class="tags form-control" value="social, adverts, sales" />
                                                <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="col-md-12 mx-auto">
                                        <input type="submit" class="btn btn-block btn-info" value="Submit"/>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Manage Product <small>Information's...</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <table id="datatable" class="text-center table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">SL No</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Category Name</th>
                            <th class="text-center">Sub Category Name</th>
                            <th class="text-center">Product Code</th>
                            <th class="text-center">Product Price</th>
                            <th class="text-center">Product Image</th>
                            <th class="text-center">Product Status</th>
                            <th class="text-center">Product Quantity</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop