<form method="post" enctype="multipart/form-data" action="/example/upload">
    @csrf
    <input type="file" name="uploadedFile">
    <button type="submit">Carica file</button>
</form>
