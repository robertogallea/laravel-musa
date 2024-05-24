<html>
<head>
    <x-admin-page-scripts/>
</head>
<body onload="listen()">
<x-admin-flash-message/>
<x-admin-menu-dynamic>
    @php($customMenu ??= null)
    {{ $customMenu }}
</x-admin-menu-dynamic>
{{ $slot }}

</body>

</html>
