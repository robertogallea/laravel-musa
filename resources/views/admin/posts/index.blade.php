@if (session()->has('message'))
    @php($status = session()->get('status', 'info'))
    <div @style([
    'background-color: green' => $status === 'success',
    'background-color: azure' => $status === 'info',
    'background-color: red' => $status === 'danger',
    'background-color: yellow' => $status === 'warning',
])>{{ session()->get('message') }}</div>
@endif
<a href="{{ route('admin.posts.create') }}">Crea nuovo post</a>
<table>
    <tr>
        <th>ID</th>
        <th>Autore</th>
        <th>Titolo</th>
        <th>Estratto</th>
        <th>Categoria</th>
        <th>Data creazione</th>
        <th>Data modifica</th>
        <th>Azioni</th>
    </tr>
    @forelse($posts as $post)
        <tr @style([
    'background-color: lightgray' => $loop->even,
    'background-color: #EEE' => $loop->odd,
    'background-color: #f66' => $post->trashed(),
])>
            <td>{{ $post->id }}</td>
            <td>{{ $post->user->name }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->summary }}</td>
            <td>{{ $post->category->label }}</td>
            <td>{{ $post->created_at->format('d/m/Y - H:i') }}</td>
            <td>{{ $post->updated_at->format('d/m/Y - H:i') }}</td>
            <td>
                @can('view', $post)
                    <a href="{{ route('admin.posts.show', $post) }}">Visualizza</a>
                @endcan
                @can('update', $post)
                    <a href="{{ route('admin.posts.edit', $post) }}">Modifica</a>
                @endcan
                @can('restore', $post)
                    @if ($post->trashed())
                        <form method="post" action="{{ route('admin.posts.restore', $post) }}"
                              onsubmit="return confirm('Sei sicuro di volere recuperare il post {{ $post->title }}?')">
                            @method('put')
                            @csrf
                            <button type="submit">Recupera</button>
                        </form>
                    @endif
                @endcan
{{--                    Se il post non è cancellato e l'utente può cancellarlo --}}
{{--                    O--}}
{{--                    Se il post è cancellato in modalità soft e l'utente può forzarne la cancellazione--}}
                @if (
                    (! $post->trashed() && \Illuminate\Support\Facades\Auth::user()->can('delete', $post)) ||
                    ($post->trashed() && \Illuminate\Support\Facades\Auth::user()->can('forceDelete', $post))
                )
                    <form method="post" action="{{ route('admin.posts.destroy', $post) }}"
                          onsubmit="return confirm('Sei sicuro di volere cancellare @if($post->trashed()) definitivamente @endif il post {{ $post->title }}?')">
                        @method('delete')
                        @csrf
                        <button type="submit">Cancella @if($post->trashed())
                                definitivamente
                            @endif</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        Nessun post presente
    @endforelse
</table>
