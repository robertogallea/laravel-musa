<html>
<head>
    <title>{{ config('app.name') }} - @yield('title')</title>
    @stack('scripts')
</head>
<body>
<div id="header">
    @section('header')
        <h1>{{ config('app.name') }}</h1>
    @show
</div>
<div id="content">
    @yield('content')
</div>
<div id="footer">
    @include('layouts.footer')
</div>
</body>
</html>
