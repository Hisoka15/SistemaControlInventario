<x-modal buttonText="Cambiar rol">
    <x-slot name="title">Cambio de rol</x-slot>
    <form action="{{route('users.changeRole', ['user' => $selected->id])}}">
        @csrf
        <label for="role">Rol:</label>
        <select id="role" name="role_id" class="border p-2 w-full">
            <option value="">Seleccione un rol</option>
            @foreach($roles as $role)
                <option class="{{$selected->role_id}}" value="{{ $role->id }}" @if($selected->role_id == $role->id) selected @endif>{{ $role->name }}</option>
            @endforeach
        </select>
        <button class="w-full bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Actualizar rol</button>
    </form>
</x-modal>
