@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <form class="text-xs flex flex-col gap-2 w-full max-w-[60rem] mx-auto" action="{{route('purchases.store')}}">
        <h1 class="text-2xl font-bold py-4">Registro de compra</h1>
        @csrf
        <div class="flex w-full grid grid-cols-12 [&>input]:col-span-4 [&>label]:col-span-2 justify-center items-center gap-2">
            <label>Numero de factura:</label>
            <input type="text" name="number_bill" class="border p-2 w-full" required>
            <label>Fecha de compra:</label>
            <input type="date" name="date_bill" class="border p-2 w-full" required>
        </div>
        <div class="flex w-full grid grid-cols-12 [&>input]:col-span-4 [&>label]:col-span-2 justify-center items-center gap-2">
            <label>Proveedor:</label>
            <input type="text" name="provider" class="border p-2 w-full" required>
            <label>Total:</label>
            <h3 id="purchase_total" class="border p-2 w-full col-span-4">0.00</h3>
            <input type="hidden" id="totalInput" name="total">
        </div>
        <div class="flex justify-end">
            <x-modal buttonText="AGREGAR PRODUCTO">
                <x-slot name="title">Ingrese los datos del nuevo inventario</x-slot>
                <div class="flex flex-col gap-2">
                    <label for="product">Producto:</label>
                    <input type="text" list="products" id="purchase_product_id" name="getProductId" class="border p-2 w-full" required>
                    <datalist id="products">
                        @foreach($products as $product)
                            <option value="{{ $product->product_code }}">{{ $product->product_name }}</option>
                        @endforeach
                    </datalist>
                    <input type="hidden" name="selected_product_code" id="selected_product_code">
                    <div id="selectedProduct" class="mt-2 font-semibold text-green-600"></div>
                    <button id="changeProductButton" class="hidden hover:bg-red-500 border-2 mb-4 border-red-500 text-red-500 transition-all hover:text-white py-2 px-4 rounded">Cambiar producto</button>
                    <label>Cantidad:</label>
                    <input type="number" id="purchase_quantity" min="0" name="getQuantity" class="border p-2 w-full" required>
                    <label>Precio unitario:</label>
                    <input type="number" id="purchase_unit_price" name="getUnitPrice" class="border p-2 w-full" required>
                    <label>Observaciones:</label>
                    <textarea id="purchase_observations" name="getObservation" class="border p-2 w-full" required></textarea>
                    <button type="button" id="purchase_btn" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md mt-2">Agregar producto</button>
                </div>
            </x-modal>
            <input type="hidden" name="purchaseDetails" id="purchaseDetailsInput">
        </div>
        @php($headers = ['Codigo', 'Producto', 'Cant.', 'Unidad de medida', 'P/U', 'Total', 'Acciones'])
        <table id="purchase_details_table" class="w-full h-auto bg-white rounded text-left">
            <thead class="rounded bg-zinc-50 text-zinc-400">
                <tr class="">
                    @foreach ($headers as $header)
                        <th class="p-2">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div>
            <label>Observaciones:</label>
            <textarea name="bill_observation" class="border p-2 w-full" required></textarea>
        </div>
        <button type="button" id="btnSendPurchase" class="w-full bg-green-500 text-white px-4 py-2 rounded-md mt-2">Registrar compra</button>
    </form>
    <script src="{{asset('js/sales.js')}}"></script>
    <script>
        loadPurchaseDetails();
    </script>
@endsection
