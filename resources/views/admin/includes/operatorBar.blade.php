<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{route('home')}}">Dashboard @if(Session::has('uotletName')) <b>{{ Session::get('uotletName')}}</b> @endif</a>
        </li>
        <li style="margin-left: 30vw">Current Date: {{$dbDate}}</li>
    </ul>
    @if(Session::has('uotletName'))
    <div class="page-toolbar">
        <div class="btn-group clearfix pull-right">
            <a href="{{ route('newOrder') }}" class="btn btn-circle green" style="margin-right: 10px">Take New Order <i class="fa fa-plus"></i></a>
            <a href="{{route('orderHistry')}}" class="btn btn-circle blue-hoki ml-5">Order History <i class="fa fa-link"></i></a>
        </div>
    </div>
    @endif
</div>
