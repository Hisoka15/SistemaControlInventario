@extends('templates.HomeTemplate')
@section('HomeTemplateContent')
    <h2 class="text-xl font-bold">Reportes</h2>
    @include('components.table', [
        'headers' => ['Reporte', 'Tabla'],
        'rows' => [
            ['Reporte' => 'Listado de Inventarios','Tabla' => 'inventories', 'Route' => 'export.inventory', 'Type' => 'Inventario'],
            ['Reporte' => 'Listado de Usuarios','Tabla' => 'users', 'Route' => 'export.users', 'Type' => 'Usuarios'],
            ['Reporte' => 'Registro de Compras','Tabla' => 'purchases', 'Route' => 'export.purchases', 'Type' => 'Compras'],
            ['Reporte' => 'Catalogo de Productos','Tabla' => 'products', 'Route' => 'export.products', 'Type' => 'Productos'],
            ['Reporte' => 'Registro de Ventas','Tabla' => 'sales', 'Route' => 'export.sales', 'Type' => 'Ventas'],
        ],
        'columns' => ['Reporte', 'Tabla'],
        'links' => [],
        'childComponent' => 'export.exportCollection',
        'dataChildComponent' => [],
        'paginate' => false,
        'lastPage' => [],
        'currentPage' => [],
        'data' => []
    ])
@endsection
