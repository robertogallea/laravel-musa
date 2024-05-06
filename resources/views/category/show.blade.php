<div>
    <h1>{{ $category->label }}</h1>
</div>
<div>
    <ul>
        @forelse ($category->posts as $post)
            <li @style([
    'border: 1px dashed gray',
    'color: green' => $post->status,
    'color: red' => !$post->status,
])>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a> - {{ $post->user->name }}
                @if ($post->status)
                    (Pubblicato)
                @else
                    (Non pubblicato)
                @endif
                @switch($post->status)
                    @case(true)
                        PUBBLICATO
                        @break
                    @case(false)
                        NON PUBBLICATO
                        @break
                @endswitch
            </li>
        @empty
            Nessun post in questa categoria
        @endforelse
    </ul>
</div>
