<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Inventory;
use App\Models\InventoryMovement;
use App\Models\Measurement\UnitsOfMeasurement;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Products::where('status', true)
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('name', 'asc')
            ->paginate(10);
        $type_of_measurements = array_keys(UnitsOfMeasurement::$UnitMeasurements);
        $units_of_measurements = UnitsOfMeasurement::$UnitMeasurements;

        return view('products.index', compact('products', 'type_of_measurements', 'units_of_measurements'));
    }

    public function store(Request $request)
    {
        try{
            app(StoreRequest::class)->validateResolved();
            Products::create($request->all());
            Session::flash('message', 'Producto registrado correctamente');
            Session::flash('type', 'success');
            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            $errors = $exception->validator->errors()->all();
            Session::flash('message', 'Error al registrar el producto: ' . implode(', ', $errors));
            Session::flash('type', 'error');

            return redirect()->route('products.index');
        }

    }

    public function update(Request $request, Products $product)
    {
        try {
            app(UpdateRequest::class)->validateResolved();
            $product->update($request->all());
            Session::flash('message', 'Producto actualizado correctamente');
            Session::flash('type', 'success');
            return redirect()->route('products.index');
        } catch (\Exception $exception) {
            $errors = $exception->validator->errors()->all();
            Session::flash('message', 'Error al actualizar el producto: ' . implode(', ', $errors));
            Session::flash('type', 'error');

            return redirect()->route('products.index');
        }

    }

    public function destroy(Products $product)
    {
        if ($product->inventories()->exists()) {
            Session::flash('message', 'No se puede eliminar el producto porque tiene inventarios asociados');
            Session::flash('type', 'error');
            return redirect()->route('products.index');
        }
        $product->update(['status' => false]);

        Session::flash('message', 'Producto eliminado correctamente');
        Session::flash('type', 'success');

        return redirect()->route('products.index');
    }

    public function getProductByIdOrCode(Request $request)
    {
        $info_product = Products::where('status', true)
            ->where(function ($query) use ($request) {
                $query->where('id', $request->product)
                    ->orWhere('code', $request->product);
            })->first();
        if (!$info_product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        return response()->json($info_product);
    }

    public function statistics()
    {
        $MAX_DAYS = 30;
        $MAX_PRODUCTS = 10;
        $products = InventoryMovement::select(
            DB::raw('inventory_id as inventory'),
            DB::raw('SUM(total_sale_cost) as sale_cost'),
        )->where('date', '>=', Carbon::now()->subDays($MAX_DAYS))
            ->where('type', 'out')
            ->groupBy('inventory_id')
            ->orderBy('sale_cost', 'desc')
            ->get();

        $productName = [];
        $sale = [];

        foreach ($products as $product) {
            if (count($productName) >= $MAX_PRODUCTS) {
                break;
            }
            $productId = Inventory::find($product->inventory)->product_id;
            $productName[] = Products::find($productId)->name;
            $sale[] = number_format((float) $product->sale_cost, 2, '.', '');
        }

        return response()->json([
            [
                'value' => $sale,
                'product' => $productName
            ]
        ]);
    }

    public function getPrice(Request $request)
    {
        $name = $request->input('name');
        $product = Products::where('name', $name)->first();
        $stock = Inventory::where('product_id', $product->id)
            ->select('stock')
            ->first();
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        return response()->json(['price' => $product->price, 'stock' => $stock->stock]);
    }
}
