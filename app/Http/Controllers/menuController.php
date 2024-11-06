<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMenuRequest;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Menu;
use App\Models\Marca;
use App\Models\Presentacione;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class menuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $menus = Menu::with(['comprobante','cliente.persona','user'])
        ->where('estado',1)
        ->latest()
        ->get();

        $subquery = DB::table('compra_producto')
            ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
            ->groupBy('producto_id');

        $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery) {
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', function ($query) use ($subquery) {
                    $query->select('max_created_at')
                        ->fromSub($subquery, 'subquery')
                        ->whereRaw('subquery.producto_id = cpr.producto_id');
                });
        })
            ->select('productos.nombre', 'productos.id', 'productos.stock', 'cpr.precio_venta')
            ->where('productos.estado', 1)
            ->where('productos.stock', '>', 0)
            ->get();

        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        $comprobantes = Comprobante::all();

        return view('menu.index', compact('menus','productos', 'clientes', 'comprobantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        try{
            DB::beginTransaction();

            //Llenar mi tabla venta
            $menu = Menu::index($request->validated());

            //Llenar mi tabla venta_producto
            //1. Recuperar los arrays
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arrayDescuento = $request->get('arraydescuento');

            //2.Realizar el llenado
            $siseArray = count($arrayProducto_id);
            $cont = 0;

            while($cont < $siseArray){
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                        'descuento' => $arrayDescuento[$cont]
                    ]
                ]);

                //Actualizar stock
                $producto = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $producto->stock;
                $cantidad = intval($arrayCantidad[$cont]);

                DB::table('productos')
                ->where('id',$producto->id)
                ->update([
                    'stock' => $stockActual - $cantidad
                ]);

                $cont++;
            }

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('menus.index')->with('success','Orden exitosa');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('menu.show',compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Menu::where('id',$id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('menus.index')->with('success','Orden eliminada');
    }
}
