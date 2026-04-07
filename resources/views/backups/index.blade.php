@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <h2 class="text-xl font-bold">Copias de seguridad</h2>
    <x-modal buttonText="GENERAR COPIA DE SEGURIDAD">
        <x-slot name="title">Generar copia de seguridad</x-slot>
        <form class="flex flex-col gap-2" action="{{route('backups.store')}}">
            @csrf
            <label>
                Al hacer click en el botón "Generar copia de seguridad" se creará una copia de seguridad de la base de datos. ¿Está seguro de continuar?
            </label>
            <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md mt-2">Generar copia de seguridad</button>
        </form>
    </x-modal>
    @include('components.table', [
        'headers' => ['Nombre', 'Disco', 'Peso', 'Fecha de creación'],
        'rows' => $backups,
        'columns' => ['name', 'disk', 'size', 'created_at'],
        'links' => [],
        'childComponent' => 'backups.restore',
        'dataChildComponent' => [],
        'paginate' => true,
        'lastPage' => $backups->lastPage(),
        'currentPage' => $backups->currentPage(),
        'data' => $backups
    ])
@endsection
