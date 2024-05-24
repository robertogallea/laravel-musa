@php ($title ??= 'Titolo default')
<div {{ $attributes->filter(fn($value, $key) => in_array($key, ['style', 'class'])) }}>
    <h2>{{ $title }}</h2>
    Hello world<br>
    Type = {{ $type }}<br>
    Value = {{ $value }}<br>
    Number = {{ $number }}
    @foreach(range(1, $numberOfIterations) as $iteration)
        <li>{{ $iteration }}</li>
    @endforeach
    @if ($slot->isEmpty() || !$slot->hasActualContent())
        Contenuto di default
    @else
        {{ $slot }}
    @endif
</div>
