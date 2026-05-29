@foreach($users as $user)
<tr>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->role->name }}</td>
<td>
<a href="{{ route('users.edit', $user) }}">Editar</a>
<form action="{{ route('users.destroy', $user) }}" method="POST">
@csrf @method('DELETE')
<button type="submit">Eliminar</button>
</form>
</td>
</tr>
@endforeach
