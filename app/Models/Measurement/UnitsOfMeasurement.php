<?php

namespace App\Models\Measurement;

class UnitsOfMeasurement
{
    public static $UnitMeasurements = [
        'Masa' => [
            'kg' => 'Kilogramos',
            'g' => 'Gramos',
            'mg' => 'Miligramos',
            't' => 'Toneladas',
            'lb' => 'Libras',
            'oz' => 'Onzas',
        ],
        'Volumen' => [
            'm3' => 'Metros cúbicos',
            'cm3' => 'Centímetros cúbicos',
            'mm3' => 'Milímetros cúbicos',
            'l' => 'Litros',
            'ml' => 'Mililitros',
            'gal' => 'Galones',
        ],
        'Unidades' => [
            'und' => 'Unidades',
            'doz' => 'Docenas',
            'dz' => 'Decenas',
            'gr' => 'Grupos',
            'bl' => 'Bolsa',
            'set' => 'Sets',
            'kit' => 'Kits',
            'box' => 'Cajas',
        ],
        'Longitud' => [
            'm2' => 'Metros cuadrados',
            'cm' => 'Centímetros',
            'mm' => 'Milímetros',
            'in' => 'Pulgadas',
            'ft' => 'Pies',
            'yd' => 'Yardas',
        ],
    ];
}
