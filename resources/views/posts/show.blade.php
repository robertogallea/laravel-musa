@extends('layouts.master2')

@section('content')
    <article class="post post-1">
        <header class="entry-header">
            <h1 class="entry-title">{{ $post->title }}</h1>
            <div class="entry-meta">
                <span class="post-category"><a
                        href="{{ route('categories.show', $post->category) }}">{{ $post->category->label }}</a></span>

                <span class="post-date"><a href="#"><time class="entry-date"
                                                          datetime="{{ $post->created_at }}">{{ $post->created_at->format('d/m/Y - H:i') }}</time></a></span>

                <span class="post-author"><a href="#">{{ $post->user->name }}</a></span>

                <span class="comments-link"><a href="#">4 Comments</a></span>
            </div>
        </header>
        <div class="entry-content clearfix">
            {{ $post->body }}
        </div>
    </article>
@endsection
