<form method="post" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}">
    @if ($post->exists)
        @method('put')
    @else
        @method('post')
    @endif
    @csrf
    <table>
        <tr>
            <td>ID</td>
            <td>{{ $post->id }}</td>
        </tr>
        <tr>
            <td>Titolo</td>
            <td><input type="text" name="title" value="{{ $post->title }}"></td>
        </tr>
        <tr>
            <td>Body</td>
            <td>
                <textarea name="body" cols="50" rows="10">
                    {{ $post->body }}
                </textarea>
            </td>
        </tr>
        <tr>
            <td>Categoria</td>
            <td>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option @if ($category->id == $post->category_id) selected @endif value="{{ $category->id }}">{{ $category->label }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Data creazione</td>
            <td>{{ $post->created_at?->format('d/m/Y - H:i') }}</td>
        </tr>
        <tr>
            <td>Data Modifica</td>
            <td>{{ $post->updated_at?->format('d/m/Y - H:i') }}</td>
        </tr>

    </table>
    <button type="submit">@if($post->exists) Aggiorna @else Salva @endif</button>
</form>
