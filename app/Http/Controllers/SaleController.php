<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\GeneratePDFController;
use App\Services\SaleService;
use Illuminate\Support\Facades\Log;


class SaleController extends Controller
{
    protected $saleService;
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sales = Sale::orderBy('created_at', 'desc')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('client', 'like', '%' . $search . '%');
                }
            })
            ->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Inventory::join('products', 'inventories.product_id', '=', 'products.id')
            ->where('inventories.status', 'active')
            ->orderBy('inventories.id', 'desc')
            ->select(
                'inventories.id',
                'inventories.code_inventory',
                'inventories.stock',
                'inventories.total_value',
                'inventories.description',
                'products.id as product_id',
                'products.name as product_name',
                'products.code as product_code',
                'products.unit_of_measurement as product_unit_of_measurement'
            )->get();
        return view('sales.register', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['saleDetails'] = json_decode($request->saleDetails, true);
        try{
            $data['date_bill'] = now()->format('Y-m-d');
            $information = $this->saleService->createSale($data);
            Session::flash('message', 'Venta registrada correctamente');
            Session::flash('type', 'success');
            $generate = new GeneratePDFController();
            $generate->generatePDF($request, $information["sale"], $information["products"]);
            return redirect()->route('pdf.show', ['id' => $information["sale"]->id]);
        } catch (\Exception $e) {
            Log::error('Error al registrar la venta: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            DB::rollBack();
            Session::flash('message', 'Error al registrar la venta');
            Session::flash('type', 'error');
            return back();
        }
    }

    public function statistics()
    {
        $MAX_DAYS = 30;
        $salesPerDay = Sale::select(
            DB::raw('DATE(date_bill) as day'),
            DB::raw('SUM(total) as total_sales'),
            DB::raw('SUM(profit) as total_profit')
        )
            ->where('date_bill', '>=', Carbon::now()->subDays($MAX_DAYS))
            ->groupBy(DB::raw('DATE(date_bill)'))
            ->orderBy('day', 'asc')
            ->get();

        $prices = [];
        $dates = [];
        $profits = [];

        foreach ($salesPerDay as $sale) {
            $prices[] = number_format((float) $sale->total_sales, 2, '.', '');
            $dates[] = $sale->day;
            $profits[] = number_format((float) $sale->total_profit, 2, '.', '');
        }

        return response()->json([
            [
                'value' => $prices,
                'dates' => $dates,
                'profits' => $profits
            ]
        ]);
    }
}
