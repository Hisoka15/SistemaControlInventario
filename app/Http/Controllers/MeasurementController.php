<?php

namespace App\Http\Controllers;

use App\Models\Measurement\UnitsOfMeasurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function getUnits($type)
    {
        if (!array_key_exists($type, UnitsOfMeasurement::$UnitMeasurements)) {
            return response()->json(['message' => 'Tipo de medida no encontrado'], 404);
        }
        $unitsOfMeasurement = UnitsOfMeasurement::$UnitMeasurements[$type];
        return response()->json($unitsOfMeasurement, 200);
    }
}
