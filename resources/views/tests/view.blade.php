
<!-- Commento -->

{{ "Con {{ } } i tag vengono codificati come caratteri speciali: <script>alert('ciao');</script>" }}
{{--{!! "Con {!! !! } i tag vengono lasciati immutati: <script>alert('ciao');</script>" !!}--}}

@verbatim
    {{--
    Con verbatim, tutto ciò che è all'interno del blocco viene riportato esattamente per come è scritto, ignroando
    eventuali comandi blade
    --}}
    {{ ciao }}
@endverbatim

@if (1==1)
    <h1>Condizione verficata</h1>
@endif

@if (1==2)
    <h1>Condizione verficata</h1>
@else
    <h1>Condizione non verificata (else)</h1>
@endif

@auth
    Utente loggato {{ auth()->user()->name }}
@endauth

@guest
    Utente ospite
@endguest

@production
    In ambiente di produzione
@endproduction

@env('local')
    Ambiente locale
@endenv


@env('production')
    Ambiente production
@endenv

@session('variable')
    Visualizzato se esiste in sessione la variabile <i>variable</i> con valore {{ $value }}
@endsession

@switch(rand(0,2))
    @case(0)
        Valore estratto 0
        @break
    @case(1)
        Valore estratto 1
        @break
    @case(2)
        Valore estratto 2
        @break
@endswitch

<ul>
@for ($i=0;$i<10;$i++)
    <li>{{ $i }}</li>
@endfor
</ul>

@php
    $colors = ['red', 'green', 'blue'];
@endphp

<ol>
@foreach($colors as $i => $color)
    <li>{{ $i }} - {{ $color }}</li>
@endforeach
</ol>

@php($colors = [])
<ol>
    @forelse($colors as $i => $color)
        <li>{{ $i }} - {{ $color }}</li>
    @empty
        Nessun colore presente
    @endforelse
</ol>

@php($data = [
    'a' => 3,
    'b' => 10,
    'c' => 16,
])

<table style="width: 50%; border: 1pt solid black">
    <tr>
        <th>Index</th>
        <th>Iteration</th>
        <th>Remaining</th>
        <th>Count</th>
        <th>First</th>
        <th>Last</th>
        <th>Even</th>
        <th>Odd</th>
        <th>Depth</th>
        <th>Key</th>
        <th>Value</th>
    </tr>
    @foreach($data as $key => $item)
        <tr>
            <td>{{ $loop->index }}</td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $loop->remaining }}</td>
            <td>{{ $loop->count }}</td>
            <td>{{ $loop->first }}</td>
            <td>{{ $loop->last }}</td>
            <td>{{ $loop->even }}</td>
            <td>{{ $loop->odd }}</td>
            <td>{{ $loop->depth }}</td>
            <td>{{ $key }}</td>
            <td>{{ $item }}</td>
        </tr>
    @endforeach
</table>


@php(
$data = [
    ['id' => 1, 'name' => 'AAA'],
    ['id' => 2, 'name' => 'BBB'],
])


@foreach($data as $item)
    <ul>
        XXX {{ $loop->depth }}
        @foreach($item as $field)
            <li>{{ $field }} ({{ $loop->parent->iteration }}) - YYY {{ $loop->depth }} - {{ $loop->parent->depth }}</li>
        @endforeach
    </ul>
@endforeach

@php($status = false)

<div @class([
    'p-4',
    'border-green' => $status,
    'bg-red' => !$status,
])>TESTO DEL DIV</div>

<div @style([
    'p-4',
    'background-color: green' => $status,
    'background-color: red' => !$status,
])>TESTO DEL DIV</div>
