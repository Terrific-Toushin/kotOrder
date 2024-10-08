<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>NICE | Login ADMIN</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="cache-control" content="no-store" />
    <meta http-equiv="cache-control" content="must-revalidate" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/') }}assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/') }}assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/') }}assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/') }}assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ asset('/') }}assets/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ asset('/') }}assets/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/') }}assets/global/css/plugins-md.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/') }}assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/') }}assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{ asset('/') }}assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body id="body" class="page-md login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="{{route('login')}}">
        <img src="{{ asset('/') }}assets/admin/layout/img/logo-big.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->

    <form id="form" class="login-form" action="{{ route('login') }}" method="post">
        @csrf
        <h3 class="form-title">Sign In</h3>
        @if ($errors->has('email'))
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span>{{ $errors->first('email') }}</span>
            </div>
        @endif
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" required/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" required/>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success uppercase btn-block">Login</button>
{{--            <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>--}}
        </div>
    </form>
    <!-- END LOGIN FORM -->
</div>
<div class="copyright">
    2024 © NICE. Admin Dashboard Template.
</div>
<script src="{{ asset('/') }}assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('/') }}assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('/') }}assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="{{ asset('/') }}assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    document.getElementById('body').onkeyup = function(e) {
        if (e.keyCode === 13) {
            document.getElementById('form').submit(); // your form has an id="form"
        }
        return true;
    }
    jQuery(document).ready(function() {
        Metronic.init(); // init nice core components
        Layout.init(); // init current layout
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
