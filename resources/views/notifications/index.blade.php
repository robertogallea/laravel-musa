@extends('layouts.master2')

@section('title', config('app.name') . '- Notifiche')

@section('content')
    <table class="table table-bordered">
        <tr>
            <th>Tipo notifica</th>
            <th>Testo</th>
            <th>URL</th>
        </tr>
        @foreach($notifications as $notification)
            <tr @style([
    'font-weight: bold' => $notification->unread()
])>
                <td>{{ $notification->type }}</td>
                <td>{{ $notification->data['text'] }}</td>
                <td><a href="{{ route('notifications.show', $notification) }}">Apri</a></td>
            </tr>
        @endforeach
    </table>
@endsection
