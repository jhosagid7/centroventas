<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function articulos(Request $request){
        $term = $request->get('term');

        $querys = Articulo::query()
        ->with('categoria')
        ->when($term ?? false, function($query, $term){
            $query->where('estado', '=', 'Activo')
            ->where('vender_al', 'Detal')
            ->where('nombre', 'like', '%'.$term.'%')
            ->orWhere('codigo', 'like', '%'.$term.'%')
            ->orderBy('created_at','Desc');
        })->get();

        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'label' => $query->nombre,
                'codigo' => $query->codigo,
                'id' => $query->id,
                'stock' => $query->stock,
                'precio_costo' => number_format((float)round( $query->precio_costo, PHP_ROUND_HALF_DOWN),3,'.',','),
                'nombre' => $query->nombre,
                'porEspecial' => $query->porEspecial,
                'isDolar' => $query->isDolar,
                'isPeso' => $query->isPeso,
                'isTransPunto' => $query->isTransPunto,
                'isMixto' => $query->isMixto,
                'isEfectivo' => $query->isEfectivo,
                'isKilo' => $query->isKilo
            ];
        };

        return $data;


    }



    public function articulosVentas(Request $request){
        $term = $request->get('term');

        $querys = Articulo::query()
        ->when($term ?? false, function($query, $term){
            $query->where('estado', '=', 'Activo')
            ->where('vender_al', 'Detal')
            ->where('stock', '>', '0')
            ->where('precio_costo', '>', '0')
            ->where('nombre', 'like', '%'.$term.'%')
            ->orWhere('codigo', 'like', '%'.$term.'%')
            ->orderBy('id','Desc');
        })->get();




        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'label' => $query->nombre,
                'codigo' => $query->codigo,
                'id' => $query->id,
                'stock' => $query->stock,
                'precio_costo' => number_format((float)round( $query->precio_costo, PHP_ROUND_HALF_DOWN),3,'.',','),
                'nombre' => $query->nombre,
                'porEspecial' => $query->porEspecial,
                'isDolar' => $query->isDolar,
                'isPeso' => $query->isPeso,
                'isTransPunto' => $query->isTransPunto,
                'isMixto' => $query->isMixto,
                'isEfectivo' => $query->isEfectivo,
                'isKilo' => $query->isKilo
            ];
        };

        return $data;


    }



    public function articulosCargos(Request $request){
        $term = $request->get('term');

        $querys = Articulo::query()
        ->with('categoria')
        ->when($term ?? false, function($query, $term){
            $query->where('estado', '=', 'Activo')
            ->where('vender_al', 'Detal')
            ->where('nombre', 'like', '%'.$term.'%')
            ->orWhere('codigo', 'like', '%'.$term.'%')
            ->orderBy('created_at','Desc');
        })->get();




        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'label' => $query->nombre . ' - ' . $query->codigo . ' - ' . $query->stock . ' - ' . $query->vender_al,
                'codigo' => $query->codigo,
                'id' => $query->id,
                'stock' => $query->stock,
                'precio_costo' => number_format((float)round( $query->precio_costo, PHP_ROUND_HALF_DOWN),3,'.',','),
                'nombre' => $query->nombre,
                'category' => $query->categoria->nombre,
                'vender_al' => $query->vender_al

            ];
        };

        return $data;


    }
}