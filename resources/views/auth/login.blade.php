<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admincast bootstrap 4 &amp; angular 5 admin template | Login</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?= URL::to('vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= URL::to('vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" />
    <link href="<?= URL::to('vendors/themify-icons/css/themify-icons.css') ?>" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?= URL::to('css/main.css') ?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="<?= URL::to('css/pages/auth-light.css') ?>" rel="stylesheet" />
    <style type="text/css">
    #login-form{
        background: linear-gradient(rgba(0,0,0,.26), rgba(0,0,0,.26)), url('<?= URL::to('img/bg.jpg') ?>') no-repeat center center/cover;
        box-shadow: 1px 1px 2px rgba(169,169,169,.44);
        color: #fff;
    }
    </style>
</head>

<body class="bg-white">
    <div class="content">
        <div class="brand mt-5">
            <img src="<?= URL::to('img/main-logo.png') ?>" alt="">
        </div>
        <form id="login-form" action="{{ route('signin') }}" method="post">
            @csrf
            <h5 class="login-title">LOGIN WITH YOUR ACCOUNT</h5>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group d-flex justify-content-between">
                <label class="ui-checkbox ui-checkbox-info">
                    <input type="checkbox">
                    <span class="input-span"></span>Remember me
                </label>
                <a href="forgot_password.html" class="color-silver">Forgot password?</a>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit">Login</button>
            </div>
        </form>
    </div>
    <!-- CORE PLUGINS -->
    <script src="<?= URL::to('vendors/jquery/dist/jquery.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/popper.js/dist/umd/popper.min.js') ?>" type="text/javascript"></script>
    <script src="<?= URL::to('vendors/bootstrap/dist/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="<?= URL::to('vendors/jquery-validation/dist/jquery.validate.min.js') ?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
</body>
  
</html>