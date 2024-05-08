<aside class="col-md-4">
    <div class="widget widget-recent-posts">
        <h3 class="widget-title">Recent Posts</h3>
        <ul>
            @foreach($latestPosts as $post)
                <li>
                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="widget widget-archives">
        <h3 class="widget-title">Archives</h3>
        <ul>
            <li>
                <a href="#">November 2014</a>
            </li>
            <li>
                <a href="#">September 2014</a>
            </li>
            <li>
                <a href="#">January 2013</a>
            </li>
        </ul>
    </div>

    <div class="widget widget-category">
        <h3 class="widget-title">Category</h3>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('categories.show', $category) }}">{{ $category->label }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
