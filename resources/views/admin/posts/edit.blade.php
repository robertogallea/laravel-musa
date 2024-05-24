<x-admin-page>
    <x-slot:custom-menu>
        <a href="{{ route('admin.posts.index') }}">Torna alla lista dei post</a>
    </x-slot:custom-menu>
    @include('admin.posts._form', ['post' => $post])
</x-admin-page>
