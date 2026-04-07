<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\PurchaseService;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    protected $purchaseService;
    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $purchases = Purchase::orderBy('created_at', 'desc')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('number_bill', 'like', '%' . $search . '%')
                        ->orWhere('provider', 'like', '%' . $search . '%')
                        ->orWhere('observation', 'like', '%' . $search . '%');
                }
            })
            ->paginate(10);
        return view('purchases.index', compact('purchases'));
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
        return view('purchases.register', compact('products'));
    }

    public function store(Request $request){
        $data = $request->all();
        $data['purchaseDetails'] = json_decode($request->purchaseDetails, true);
        try{
            $this->purchaseService->createPurchase($data);
            Session::flash('message', 'Compra registrada correctamente');
            Session::flash('type', 'success');
            return redirect()->route('purchases.index');
        } catch (\Exception $e) {
            Log::error('Error al registrar la compra: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            DB::rollBack();
            Session::flash('message', 'Error al registrar la compra');
            Session::flash('type', 'error');
            return back();
        }
    }

    public function statistics()
    {
        $purchasesPerDay = Purchase::select(
            DB::raw('DATE(date_bill) as day'),
            DB::raw('SUM(total) as total_purchases')
        )
            ->where('date_bill', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(date_bill)'))
            ->orderBy('day', 'asc')
            ->get();

        return response()->json($purchasesPerDay);
    }
}
