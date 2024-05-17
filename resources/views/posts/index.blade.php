@extends('layouts.master2')

@section('title', config('app.name'))

@section('content')
    @include('posts._list', ['posts' => $latestPosts])
    @include('posts._list', ['posts' => $oldestPosts])
@endsection
