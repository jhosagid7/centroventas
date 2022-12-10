<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Tasa;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // public function get_add_to_message_search(){
    // $term = Input::get( 'term' );
    // $users = array();
    // $search = DB::query("
    //     select *
    //     from users
    //     where id!='" . Auth::user()->id . "'
    //     and status=1
    //     and type='user'
    //     and match(name, email, username)
    //     against('+{$term}*' IN BOOLEAN MODE)
    //     ");

    //     foreach( $search as $results => $user )
    //     {
    //         $users[] = array(
    //             'id' => $user->id,
    //             'value' => $user->name,
    //         );
    //     }
    //     return json_encode( $users );
    // }


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
                'label' => $query->nombre . ' - ' . $query->codigo . ' - ' . $query->stock . ' - ' . $query->vender_al,
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
            // ->where('stock', '>', '0')
            // ->where('precio_costo', '>', '0')
            ->where('nombre', 'like', '%'.$term.'%')
            ->orWhere('codigo', 'like', '%'.$term.'%')
            ->orderBy('id','Desc');
        })->get();

        

        $tasaDolar = Tasa::where('estado', '=', 'Activo')->where('nombre', '=', 'Dolar')->first();

        $data = [];

        foreach ($querys as $query) {
            $data[] = [
                'label' => $query->nombre . ' - stock: ' . $query->stock . ' - Precio: $.' . number_format(($this->redondeado($query->precio_costo,3) * (1+ ($tasaDolar->porcentaje_ganancia/100))), 3, '.', ','),
                'codigo' => $query->codigo,
                'id' => $query->id,
                'stock' => $query->stock,
                'precio_costo' => $this->redondeado($query->precio_costo,3),
                // 'precio_costo' => number_format((float)round( $query->precio_costo, PHP_ROUND_HALF_DOWN),3,'.',','),
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

        $tasaDolar = Tasa::where('estado', '=', 'Activo')->where('nombre', '=', 'Dolar')->first();
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
                'label' => $query->nombre . ' - Precio: $.' . $query->precio_costo * (1+ ($tasaDolar->porcentaje_ganancia/100)) . ' - ' . $query->stock . ' - ' . $query->vender_al,
                'codigo' => $query->codigo,
                'id' => $query->id,
                'stock' => $query->stock,
                // 'precio_costo' => number_format((float)round( $query->precio_costo, PHP_ROUND_HALF_DOWN),3,'.',','),
                'precio_costo' => $query->precio_costo * (1+ ($tasaDolar->porcentaje_ganancia/100)),
                'nombre' => $query->nombre,
                'category' => $query->categoria->nombre,
                'vender_al' => $query->vender_al

            ];
        };

        return $data;


    }

    public function redondeado ($numero, $decimales) {
        $factor = pow(10, $decimales);
        return (round($numero*$factor)/$factor); 
     }
}
