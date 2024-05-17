@forelse($posts as $post)
    <article class="post post-{{ $post->id }}">
        <header class="entry-header">
            <h1 class="entry-title">
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </h1>
            <div class="entry-meta">
                <span class="post-category"><a href="#">{{ $post->category->label }}</a></span>

                <span class="post-date"><a href="#"><time class="entry-date" datetime="{{ $post->created_at }}">{{ $post->created_at->format('d/m/y - H:i') }}</time></a></span>

                <span class="post-author"><a href="#">{{ $post->user->name }}</a></span>

                <span class="comments-link"><a href="#">4 Comments</a></span>
                <span class="comments-link"><a href="#">{{ $post->likes()->count() }} Likes</a></span>
            </div>
        </header>
        <div class="entry-content clearfix">
            <p>{{ $post->summary }}</p>
            <div class="read-more cl-effect-14">
                <a href="{{ route('posts.show', $post) }}" class="more-link">Continue reading <span class="meta-nav">→</span></a>
            </div>
        </div>
    </article>
@empty
    Nessun post presente
@endforelse
{{ method_exists($posts, 'links') ? $posts->links() : ''  }}
