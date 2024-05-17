@extends('layouts.master2')

@section('title', $category->label)

@section('content')
    @include('posts._list', ['posts' => $category->posts])
@endsection
