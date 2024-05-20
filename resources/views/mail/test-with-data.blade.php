Testo della mail

@foreach($data as $key => $item)
    <li>{{ $key }} : {{ $item }}</li>
@endforeach
<br>
L'ultimo post è <b>{{ $post->title }}</b>
