<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Palabra</th>
      <th scope="col">Fecha</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($nombrePalabras as $palabra)
    <tr>
      <th scope="row">1</th>
      <td>{{ $palabra->speechToText }}</td>
      <td>{{ $palabra->created_at }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
