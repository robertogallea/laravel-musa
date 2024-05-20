Testo della mail

@foreach($data as $key => $item)
- {{ $key }} : {{ $item }}
@endforeach

L'ultimo post è "{{ $post->title }}"
