<x-admin-page>
    <x-slot:custom-menu>
        <a href="{{ route('admin.posts.index') }}">Torna alla lista dei post</a>
    </x-slot:custom-menu>

    <table>
        <tr>
            <td>ID</td>
            <td>{{ $post->id }}</td>
        </tr>
        <tr>
            <td>Titolo</td>
            <td>{{ $post->title }}</td>
        </tr>
        <tr>
            <td>Slug</td>
            <td>{{ $post->slug }}</td>
        </tr>
        <tr>
            <td>Body</td>
            <td>{{ $post->body }}</td>
        </tr>
        <tr>
            <td>Autore</td>
            <td>{{ $post->user->name }}</td>
        </tr>
        <tr>
            <td>Categoria</td>
            <td>{{ $post->category->label }}</td>
        </tr>
        <tr>
            <td>Data creazione</td>
            <td>{{ $post->created_at->format('d/m/Y - H:i') }}</td>
        </tr>
        <tr>
            <td>Data Modifica</td>
            <td>{{ $post->updated_at->format('d/m/Y - H:i') }}</td>
        </tr>

    </table>
</x-admin-page>
