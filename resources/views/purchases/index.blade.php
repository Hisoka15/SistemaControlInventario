@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <h2 class="text-xl font-bold">Compras</h2>
    <div class="w-full h-auto border-t-2 pt-2 border-zinc-200 bg-white rounded text-xs text-center flex justify-between items-center">
        <form method="GET" action="{{ route('purchases.index') }}">
            <div class="flex justify-start items-center py-1 pr-1 bg-zinc-100 text-zinc-600 gap-2 rounded-lg border-[1px] border-zinc-200 pl-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                <input name="search" class="focus:outline-none focus:ring-0 focus:border-none text-black text-xs pl-2 rounded py-1 pr-4 w-96" placeholder="Buscar por factura o proveedor" type="text"/>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-md">Buscar</button>
            </div>
        </form>
        <a href="{{ route('purchases.register') }}" class="flex justify-start item-center gap-2 bg-indigo-600 text-white text-xs border-[1px] px-2 py-2 rounded-md font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt-text-icon lucide-receipt-text"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></svg>
            Registrar Compra
        </a>
    </div>
    @include('components.table', [
        'headers' => ['Numero de factura', 'Proveedor', 'Fecha', 'Total'],
        'rows' => $purchases,
        'columns' => ['number_bill', 'provider', 'date_bill', 'total'],
        'links' => [['route_name'=>'export.purchase', 'name'=>'Exportar compra', 'name_params'=>'id']],
        'childComponent' => '',
        'dataChildComponent' => [],
        'paginate' => true,
        'lastPage' => $purchases->lastPage(),
        'currentPage' => $purchases->currentPage(),
        'data' => $purchases
    ])
@endsection
