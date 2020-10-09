<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>500 - Server is busy</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
<body class="hold-transition sidebar-mini layout-fixed">
    <section class="content">
        <div class="error-page mt-5 pt-5">
            <h2 class="headline text-warning"> 419</h2>

            <div class="error-content">
                <h3>
                    <i class="fas fa-exclamation-triangle text-warning"></i> Oops! Session Lost.
                </h3>

                <p>
                    Login Again to Regain session.<br>
                    <a href="{{ url('/login') }}" class="btn btn-primary"> Login </a>
                </p>
            </div>
        </div>
    </section>
</body>
