<x-modal buttonText="EDITAR">
    <x-slot name="title">Editar producto</x-slot>
    <form class="flex flex-col gap-2" action="{{route('products.update', ['product' => $selected->id])}}">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="name" class="border p-2 w-full" value="{{$selected->name}}" required>
        <label>Codigo:</label>
        <input type="text" name="code" class="border p-2 w-full" value="{{$selected->code}}" required>
        <label>Descripci&oacute;n:</label>
        <textarea name="description" class="border p-2 w-full" required>{{$selected->description}}</textarea>
        @if($selected->inventories == "[]")
            <select onchange="showUnitsOfMeasurement(true)" id="type_of_measurement_edit" name="type_of_measurement" class="border p-2 w-full" required>
                <option value="">Seleccione un tipo de unidad</option>
                @foreach($type_of_measurements as $type_of_measurement)
                    <option value="{{ $type_of_measurement }}" @if($selected->type_of_measurement == $type_of_measurement) selected @endif>{{ $type_of_measurement }}</option>
                @endforeach
            </select>
            <select name="unit_of_measurement" class="border p-2 w-full unit_of_measurement_edit" required>
                <option value="">Seleccione una unidad de medida</option>
                @foreach($units_of_measurements[$selected->type_of_measurement] as $key => $unit_of_measurement)
                    <option value="{{ $key }}" @if($selected->unit_of_measurement == $key) selected @endif>
                        {{ $unit_of_measurement }}
                    </option>
                @endforeach
            </select>
        @endif
        <label>Precio:</label>
        <input type="number" name="price" class="border p-2 w-full" min="1" value="{{$selected->price}}" required>
        @if($selected->inventories != "[]")
            <input type="hidden" name="type_of_measurement" value="{{$selected->type_of_measurement}}">
            <input type="hidden" name="unit_of_measurement" value="{{$selected->unit_of_measurement}}">
            <hr>
            <p class="text-xs text-zinc-500"><b>Codigo de inventario:</b> {{$selected->inventories->first()->code_inventory ?? 'N/A'}}</p>
            <p class="text-xs text-zinc-500"><b>Tipo de unidad:</b> {{$selected->type_of_measurement}}</p>
            <p class="text-xs text-zinc-500"><b>Unidad de medida:</b> {{$selected->unit_of_measurement}}</p>
        @endif
        <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-md mt-2">Actualizar producto</button>
    </form>
</x-modal>
