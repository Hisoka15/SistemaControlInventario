<x-modal buttonText="Restaurar">
    <x-slot name="title">Restaurar copia de seguridad</x-slot>
    <form class="flex flex-col gap-2" action="{{route('backups.restore', ['backup' => $selected->id])}}">
        @csrf
        <label>
            Al hacer click en el botón "Restaurar copia de seguridad" se restaurara la copia de seguridad "{{$selected->name}}" y debera de volver a iniciar sesi&oacute;n. ¿Está seguro de continuar?
        </label>
        <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md mt-2">Restaurar copia de seguridad</button>
    </form>
</x-modal>
