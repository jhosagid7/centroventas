<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo_transactions extends Model
{

    protected $fillabel = [
        'cantidad',
        'precio_costo_unidad',
        'articulo_id',
        'transaction_id',
        'observacion'
    ];


    protected $guarded = [];

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }

    public function articulo(){
        return $this->belongsTo(Articulo::class);
    }
}
