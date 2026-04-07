<div class="flex justify-start items-center gap-2 mb-4 [&>button]:uppercase">
    <x-modal buttonText="AGREGAR ROL">
        <x-slot name="title">Agregar nuevo rol</x-slot>
        <form action="{{route('roles.store')}}">
            @csrf
            <label>Nombre:</label>
            <input type="text" name="name" class="border p-2 w-full">
            <label>Descripci&oacute;n:</label>
            <textarea name="description" class="border p-2 w-full" required></textarea>
            <label for="permission">Seleccione los permisos:</label>
            @foreach($permissions as $permission)
                <div>
                    <input
                        type="checkbox"
                        id="permission{{ $permission->id }}"
                        name="permissions[]"
                        value="{{ $permission->id }}"
                    >
                    <label for="permission{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
            @endforeach
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Agregar rol</button>
        </form>
    </x-modal>
</div>
@include('components.table', [
        'headers' => ['Rol', 'Descripcion'],
        'rows' => $roles,
        'columns' => ['name', 'description'],
        'links' => [],
        'childComponent' => 'configuration.roles.edit',
        'dataChildComponent' => ['permissions' => $permissions],
        'paginate' => false,
        'lastPage' => [],
        'currentPage' => [],
        'data' => []
    ])
