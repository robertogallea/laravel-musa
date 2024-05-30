@extends('tasks::layout')

@section('title', 'Lista dei task')

@section('content')
    <form method="post" action="{{ $task->exists ? route('tasks.update', $task) : route('tasks.store') }}">
        @csrf
        @method($task->exists ? 'PUT' : 'POST')
    <div>
        <label for="title">Titolo</label>
        <input type="text" name="title" id="title" value="{{ $task->title }}">
    </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="20" rows="5">
                {{ $task->description }}
            </textarea>
        </div>
        <button type="submit">
            Salva
        </button>
    </form>
@endsection
