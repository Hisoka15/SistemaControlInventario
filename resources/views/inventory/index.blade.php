@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <h2 class="text-xl font-bold">Inventario</h2>
    <div class="w-full h-auto border-t-2 pt-2 border-zinc-200 bg-white rounded text-xs text-center flex justify-between items-center">
        <form method="GET" action="{{ route('inventory.index') }}">
            <div class="flex justify-start items-center py-1 pr-1 bg-zinc-100 text-zinc-600 gap-2 rounded-lg border-[1px] border-zinc-200 pl-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                <input name="search" class="focus:outline-none focus:ring-0 focus:border-none text-black text-xs pl-2 rounded py-1 pr-4 w-96" placeholder="Buscar por codigo o producto" type="text"/>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-md">Buscar</button>
            </div>
        </form>
        <x-modal buttonText="Agregar Inventario" buttonClass="flex justify-start item-center gap-2 text-xs bg-indigo-600 text-white px-2 py-2 rounded-md font-bold" icon="true">
            <x-slot name="title">Ingrese los datos del nuevo inventario</x-slot>
            <form class="flex flex-col gap-2" action="{{route('inventory.store')}}">
                @csrf
                <label>Codigo del inventario:</label>
                <input type="text" name="code_inventory" class="border p-2 w-full" required>
                <label>Producto:</label>
                <select name="product_id" class="border p-2 w-full" required>
                    <option value="">Seleccione un producto</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <label>Descripci&oacute;n:</label>
                <textarea name="description" class="border p-2 w-full" required></textarea>
                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md mt-2">Crear inventario</button>
            </form>
        </x-modal>
    </div>
    @include('components.table', [
        'headers' => ['Codigo', 'Producto', 'Unidad de medida', 'Existencia', 'Total'],
        'rows' => $inventories,
        'columns' => ['code_inventory', 'product_name', 'product_unit_of_measurement', 'stock', 'total_value'],
        'links' => [],
        'childComponent' => '',
        'dataChildComponent' => [],
        'paginate' => true,
        'lastPage' => $inventories->lastPage(),
        'currentPage' => $inventories->currentPage(),
        'data' => $inventories
    ])
@endsection
