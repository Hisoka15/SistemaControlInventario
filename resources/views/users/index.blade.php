@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <h2 class="text-xl font-bold">Usuarios</h2>
    <div class="w-full h-auto border-t-2 pt-2 border-zinc-200 bg-white rounded text-xs text-center flex justify-between items-center">
        <form method="GET" action="{{ route('users.index') }}">
            <div class="flex justify-start items-center py-1 pr-1 bg-zinc-100 text-zinc-600 gap-2 rounded-lg border-[1px] border-zinc-200 pl-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                <input name="search" class="focus:outline-none focus:ring-0 focus:border-none text-black text-xs pl-2 rounded py-1 pr-4 w-96" placeholder="Buscar por nombre o correo" type="text"/>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-md">Buscar</button>
            </div>
        </form>
        <x-modal buttonText="Agregar Usuario" buttonClass="flex justify-start item-center gap-2 text-xs bg-indigo-600 text-white px-2 py-2 rounded-md font-bold" icon="true">
            <x-slot name="title">Ingrese los datos del nuevo usuario</x-slot>
            <form class="flex flex-col gap-2" action="{{route('users.store')}}">
                @csrf
                <label for="role">Nombre:</label>
                <input type="text" name="name" class="border p-2 w-full" required>
                <label for="role">Correo:</label>
                <input type="email" name="email" class="border p-2 w-full" required>
                <div>
                    <label for="role">Contrase&ntilde;a:</label>
                    <div class="w-full grid grid-cols-12 gap-2">
                        <input id="passwordNewUser" type="text" name="password" class="border p-2 col-span-10" required>
                        <button type="button" class="bg-zinc-800 col-span-2 flex justify-center items-center text-white rounded-md" onclick="copyToClipboard('passwordNewUser')">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg>
                        </button>
                    </div>
                    <button onclick="generateRandomPassword(14)" type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-2 w-full">Generar contrase&ntilde;a</button>
                </div>
                <select id="role" name="role_id" class="border p-2 w-full" required>
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md mt-2">Crear usuario</button>
            </form>
        </x-modal>
    </div>
    @include('components.table', [
        'headers' => ['Nombre', 'Correo', 'Estado', 'Role'],
        'rows' => $users,
        'columns' => ['name', 'email', 'status', 'role_name'],
        'links' => [['route_name'=>'users.changeStatus', 'name'=>'Cambiar estado', 'name_params'=>'user']],
        'childComponent' => 'users.buttonChangeRole',
        'dataChildComponent' => ['roles' => $roles],
        'paginate' => true,
        'lastPage' => $users->lastPage(),
        'currentPage' => $users->currentPage(),
        'data' => $users
    ])
@endsection
