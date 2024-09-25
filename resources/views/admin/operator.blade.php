<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>NICE | Admin - Dashboard</title>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="cache-control" content="no-store" />
    <meta http-equiv="cache-control" content="must-revalidate" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.includes.stylesheet')
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    @include('admin.includes.operatorMenu')
<div class="clearfix">
</div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
{{--        @include('admin.includes.sidebar')--}}
        @yield('content')
    </div>
    <!-- END CONTAINER -->
    @include('admin.includes.scripts')
</body>
<!-- END BODY -->
</html>
