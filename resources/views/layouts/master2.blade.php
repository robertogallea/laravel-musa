<!DOCTYPE html>
<html>
<head>
    <title>Black &amp; White</title>

    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- css -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/ionicons.min.css">
    <link rel="stylesheet" href="/css/pace.css">
    <link rel="stylesheet" href="/css/custom.css">

    <!-- js -->
    <script src="/js/jquery-2.1.3.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/pace.min.js"></script>
    <script src="/js/modernizr.custom.js"></script>
</head>

<body>
<div class="container">
    @include('layouts.header')
</div>

<div class="content-body">
    <div class="container">
        <div class="row">
            <main class="col-md-8">
                @yield('content')
            </main>
            @include('layouts.aside')
        </div>
    </div>
</div>
@include('layouts.footer2')

@include('layouts.mobile-menu')

<script src="/js/script.js"></script>

</body>
</html>
