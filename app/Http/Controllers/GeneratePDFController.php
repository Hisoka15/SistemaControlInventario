<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sale;
use Illuminate\Support\Facades\Storage;

class GeneratePDFController extends Controller
{
    public function generatePDF(Request $request, Sale $sale, array $products)
    {
        $venta = (object) [
            'id' => $sale->id,
            'cliente' => $request->client,
            'fecha' => now()->setTimezone('America/Managua')->format('Y-m-d'),
            'hora' => now()->setTimezone('America/Managua')->format('h:i A'),
            'productos' => $products,
            'total' => $request->total,
            'cajero' => auth()->user()->name,
            'observaciones' => $request->bill_observation
        ];
        $pdf = Pdf::loadView('pdf.sale', compact('venta'));
        $pdfPath = 'pdfs/FAC_000' . $venta->id . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());
        return $pdf;
    }

    public function show(Request $request)
    {
        $exists = Storage::disk('public')->exists('pdfs/FAC_000'.$request->id.'.pdf');
        return view('pdf.show', [
            'id' => $request->id,
            'exists' => $exists
        ]);
    }
}
