<x-modal buttonText="EXPORTAR">
    <x-slot name="title">EXPORTAR {{strtoupper($selected["Type"])}}</x-slot>
    <form action="{{route($selected['Route'])}}" class="w-full grid grid-cols-12 gap-2 [&>label]:col-span-6 [&>input]:rounded [&>input]:col-span-6">
        <h3 class="col-span-12 text-md font-semibold text-center">Por rango de fechas</h3>
        <label>Desde: </label>
        <label>Hasta: </label>
        <input type="date" name="from" class="border p-2 w-full" required>
        <input type="date" name="to" class="border p-2 w-full" required>
        <button type="submit" class="col-span-full bg-green-500 text-white px-4 py-2 rounded-md mt-2">Exportar por rango de fechas</button>
    </form>
    <div class="w-full grid grid-cols-12">
        <a href="{{route($selected['Route'])}}" class="col-span-12 bg-blue-500 text-center text-white px-4 py-2 rounded-md mt-2">Exportar todo el historial</a>
    </div>
</x-modal>
