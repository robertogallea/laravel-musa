<div>
    <h1>{{ $post->title }}</h1>
    <h2>in {{ $post->category->label }}</h2>
</div>
<div>
    {{ $post->body }}
</div>
