<form method="POST" action="/comunicado/guardar">
    @csrf
    <textarea name="contenido" rows="10">{{ $contenido }}</textarea>
    <input type="file" name="imagen">
    <button type="submit">Guardar</button>
</form>
