<html>
<head>
    <title>Vite demo</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
<h1>Loaded</h1>
<img src="{{ Vite::image('me.jpg') }}" />
</body>
<script>
{{--    {{ \Illuminate\Support\Facades\Vite::content('resources/js/app.js') }}--}}
</script>
</html>
