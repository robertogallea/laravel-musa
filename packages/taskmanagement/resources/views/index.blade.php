@extends('tasks::layout')

@section('title', 'Lista dei task')

@section('content')
    @forelse($tasks as $task)
        <li @style([
                'font-weight: bold' => !$task->completed,
            ])>
            <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>: {{ $task->description }}
        </li>
    @empty
        Nessun task presente
    @endforelse
@endsection
