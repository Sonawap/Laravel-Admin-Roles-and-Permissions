<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>404 - Not found</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
<body class="hold-transition sidebar-mini layout-fixed">
    <section class="content">
        <div class="error-page mt-5 pt-5">
            <h2 class="headline text-warning"> 404</h2>

            <div class="error-content">
                <h3>
                    <i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.
                </h3>

                <p>
                    We could not find the page you were looking for.<br>
                    @if(auth()->user())
                        <a href="{{ url('/home') }}" class="btn btn-primary"> Go to Dashboard </a>
                    @else
                        <a href="{{ url('/') }}" class="btn btn-primary"> Go to Home Page </a>
                    @endif
                </p>
            </div>
        </div>
    </section>
</body>
