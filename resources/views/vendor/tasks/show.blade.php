@extends('tasks::layout')

@section('title', 'Lista dei task')

@section('content')
    <div>
        <h2>{{ $task->title }} - {{ $task->completed ? 'Completed' : 'Pending' }}</h2>
        <p>{{ $task->description }}</p>
    </div>
@endsection
