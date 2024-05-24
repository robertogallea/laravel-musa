@foreach ($menu as $item)
    <a href="{{ $item['route'] }}">{{ $item['label'] }}</a>
@endforeach
{{ $slot }}
