<x-modal buttonText="EDITAR">
    <x-slot name="title">Ajuste de permisos</x-slot>
    <form action="{{route('roles.update', ['role' => $selected->id])}}">
        <label>Nombre:</label>
        <input type="text" value="{{$selected->name}}" name="name" class="border p-2 w-full">
        <label>Descripci&oacute;n:</label>
        <textarea name="description" class="border p-2 w-full" required>{{$selected->description}}</textarea>
        <label for="permission">Seleccione los permisos:</label>
        @foreach($permissions as $permission)
            <div>
                <input
                    type="checkbox"
                    id="permission{{ $permission->id }}"
                    name="permissions[]"
                    value="{{ $permission->id }}"
                    @if($selected->hasPermission($permission->id)) checked @endif
                >
                <label for="permission{{ $permission->id }}">{{ $permission->name }}</label>
            </div>
        @endforeach
        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Actualizar rol</button>
    </form>
</x-modal>
