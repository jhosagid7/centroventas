<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialCreditoCaja extends Model
{
    protected $fillable = [
        'hist_creditos_vigentes',
        'hist_creditos_vencidos',
        'hist_creditos_pagados',
        'hist_creditos_nuevos',
        'hist_total_creditos',
        'user_id',
        'caja_id'
    ];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
