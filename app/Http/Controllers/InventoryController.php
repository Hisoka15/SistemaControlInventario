<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Inventory\StoreRequest;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $inventories = Inventory::join('products', 'inventories.product_id', '=', 'products.id')
            ->where('inventories.status', 'active')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('inventories.code_inventory', 'like', '%' . $search . '%')
                        ->orWhere('products.name', 'like', '%' . $search . '%')
                        ->orWhere('products.code', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('inventories.id', 'asc')
            ->select(
                'inventories.id',
                'inventories.code_inventory',
                'inventories.stock',
                'inventories.total_value',
                'inventories.description',
                'products.name as product_name',
                'products.code as product_code',
                'products.unit_of_measurement as product_unit_of_measurement'
            )
            ->paginate(10);
        $products = Products::leftJoin('inventories', 'products.id', '=', 'inventories.product_id')
            ->whereNull('inventories.product_id')
            ->where('products.status', true)
            ->select('products.id', 'products.name', 'products.code')
            ->get();
        return view('inventory.index', compact('inventories', 'products'));
    }

    public function store(Request $request)
    {
        try
        {
            app(StoreRequest::class)->validateResolved();
            $inventory = Inventory::create([
                'code_inventory' => $request->code_inventory,
                'product_id' => $request->product_id,
                'stock' => 0,
                'total_value' => 0,
                'description' => $request->description,
                'status' => 'active',
            ]);
            return redirect()->route('inventory.index');
        } catch (\Exception $th) {
            $errors = $th->validator->errors()->all();
            Session::flash('message', 'Error al registrar el inventario: ' . implode(', ', $errors));
            Session::flash('type', 'error');
            return redirect()->route('inventory.index');
        }

    }

    public function statistics()
    {
        $PRODUCTS_LIMIT = 5;
        $highestValueProducts = Inventory::select(
            'product_id',
            DB::raw('SUM(total_value) as total_value')
        )
            ->with('product:name,id')
            ->groupBy('product_id')
            ->orderBy('total_value', 'desc')
            ->get();

        $topProducts = $highestValueProducts->take($PRODUCTS_LIMIT);
        $otherProducts = $highestValueProducts->slice($PRODUCTS_LIMIT);

        $totalOthers = $otherProducts->sum('total_value');

        $finalResult = $topProducts->map(function ($inventory) {
            return [
                'product_name' => optional($inventory->product)->name,
                'total_value' => $inventory->total_value,
            ];
        });

        if($totalOthers > 0) {
            $finalResult->push([
                'product_name' => 'Otros',
                'total_value' => $totalOthers,
            ]);
        }


        return response()->json($finalResult);
    }
}
