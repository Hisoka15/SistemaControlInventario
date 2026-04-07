<?php

namespace App\Http\Controllers\Exports;

use App\Exports\InventoryExport;
use App\Exports\ProductsExport;
use App\Exports\PurchaseByIdExport;
use App\Exports\PurchasesExport;
use App\Exports\SaleExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\RangeDateRequest;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportsController extends Controller
{
    protected $now;
    public function __construct()
    {
        $this->now = Carbon::now()->format('Y-m-d');
    }
    public function exportUsers(RangeDateRequest $request)
{
    if ($request->has('from') && $request->has('to')) {
        $date_to = Carbon::parse($request->to);
        $date_from = Carbon::parse($request->from);
        if ($date_to->lt($date_from)) {
            return redirect()->back();
        }
        return Excel::download(new UsersExport($request->from, $request->to),'Usuarios - del '.$request->from.' al '.$request->to.'.xlsx');
    }
    return Excel::download(new UsersExport, 'Usuarios - '.$this->now.'.xlsx');
}

    public function exportProducts(RangeDateRequest $request)
    {
        if ($request->has('from') && $request->has('to')) {
            $date_to = Carbon::parse($request->to);
            $date_from = Carbon::parse($request->from);
            if ($date_to->lt($date_from)) {
                return redirect()->back();
            }
            return Excel::download(new ProductsExport($request->from, $request->to),'Productos - del '.$request->from.' al '.$request->to.'.xlsx');
        }
        return Excel::download(new ProductsExport, 'Productos '.$this->now.'.xlsx');
    }

    public function exportInventory(RangeDateRequest $request)
    {
        if ($request->has('from') && $request->has('to')) {
            $date_to = Carbon::parse($request->to);
            $date_from = Carbon::parse($request->from);
            if ($date_to->lt($date_from)) {
                return redirect()->back();
            }
            return Excel::download(new InventoryExport($request->from, $request->to),'Inventario - del '.$request->from.' al '.$request->to.'.xlsx');
        }
        return Excel::download(new InventoryExport, 'Inventario '.$this->now.'.xlsx');
    }

    public function exportPurchases(RangeDateRequest $request)
    {
        if ($request->has('from') && $request->has('to')) {
            $date_to = Carbon::parse($request->to);
            $date_from = Carbon::parse($request->from);
            if ($date_to->lt($date_from)) {
                return redirect()->back();
            }
            return Excel::download(new PurchasesExport($request->from, $request->to),'Compras - del '.$request->from.' al '.$request->to.'.xlsx');
        }
        return Excel::download(new PurchasesExport(), 'Compras '.$this->now.'.xlsx');
    }

    public function exportSales(RangeDateRequest $request)
    {
        if ($request->has('from') && $request->has('to')) {
            $date_to = Carbon::parse($request->to);
            $date_from = Carbon::parse($request->from);
            if ($date_to->lt($date_from)) {
                return redirect()->back();
            }
            return Excel::download(new SaleExport($request->from, $request->to),'Ventas - del '.$request->from.' al '.$request->to.'.xlsx');
        }
        return Excel::download(new SaleExport(), 'Ventas '.$this->now.'.xlsx');
    }

    public function exportPurchaseById(string $id)
    {
        $purchase = Purchase::find($id);
        if($purchase){
            return Excel::download(new PurchaseByIdExport($purchase), 'Compra '.$purchase->number_bill.' - '.$this->now.'.xlsx');
        }
        return redirect()->route('purchases.index')->with('error', 'No se encontro la compra');
    }
}
