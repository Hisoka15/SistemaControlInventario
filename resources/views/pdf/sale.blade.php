<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura de Venta</title>
    <style>
        body { font-family: Courier, sans-serif; font-size: 12px; }
        td, th { border: 1px solid #000; padding: 5px; }
        section { display: flex; justify-content: space-between; margin: 20px 0; width: 100%; }
    </style>
</head>
<body>
<table style="border: none; width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 50%; border: none; line-height: 0.2rem; color: #27272a;">
            <h1>Comercial Coronado</h1>
            <p style="color: #71717b;">Frente donde fue el hotel glomar</p>
            <p style="color: #71717b;">+505 2341-3587</p>
            <p style="color: #71717b;">example@comercialcoronado.store</p>
        </td>
        <td style="width: 50%; text-align: right; border: none;">
            <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" style="width: 150px; height: 80px;">
        </td>
    </tr>
</table>
<table style="border: none; width: 100%; margin-bottom: 20px;">
    <tr>
        <td style="width: 100%; border: none; line-height: 0.3rem; color: #27272a;">
            <h1 style="text-align: center;">FACTURA</h1>
            <h2>Factura No.</h2>
            <h3 style="color: #71717b;">{{$venta->id}}</h3>
            <p></p>
            <p><b>Cliente:</b> {{$venta->cliente}}</p>
            <p><b>Cajero:</b> {{$venta->cajero}}</p>
            <p><b>Fecha:</b> {{$venta->fecha}}</p>
            <p><b>Hora:</b> {{$venta->hora}}</p>
            <p><b>Tipo de pago:</b> Contado</p>
            <p><b>Forma de pago:</b> Efectivo</p>
        </td>
    </tr>
</table>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th>No.</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>UM</th>
        <th>P/U</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($venta->productos as $producto)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td>{{ $producto['nombre'] }}</td>
            <td style="text-align: center">{{ $producto['cantidad'] }}</td>
            <td style="text-align: center">{{ $producto['unidad'] }}</td>
            <td style="text-align: center">{{ $producto['precio'] }}</td>
            <td style="text-align: center">{{ $producto['precio'] * $producto['cantidad'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table style="border: none; width: auto; margin-bottom: 20px; float: right;">
    <tr>
        <td style="width: 50%; border: none; line-height: 0.3rem;">
            <h2><b>Total</b></h2>
        </td>
        <td style="width: 20%; border: none; line-height: 0.3rem;">
            <h2><b>C$</b></h2>
        </td>
        <td style="width: 30%; text-align: right; border: none; line-height: 0.3rem;">
            <h2><b>{{$venta->total}}</b></h2>
        </td>
    </tr>
</table>
<div style="margin-top: 5rem;">
    @if($venta->observaciones == null)
        <p>No hay observaciones</p>
    @else
        <p><b>Observaciones:</b></p>
        <p>{{$venta->observaciones}}</p>
    @endif
</div>
</body>
</html>
