<div>
    <h1>{{ $category->label }}</h1>
</div>
<div>
    <ul>
        @foreach ($category->posts as $post)
            <li><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a> - {{ $post->user->name }}</li>
        @endforeach
    </ul>
</div>
