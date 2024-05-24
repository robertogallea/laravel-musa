@if (session()->has('message'))
    @php($status = session()->get('status', 'info'))
    <div @style([
    'background-color: green' => $status === 'success',
    'background-color: azure' => $status === 'info',
    'background-color: red' => $status === 'danger',
    'background-color: yellow' => $status === 'warning',
])>{{ session()->get('message') }}</div>
@endif
