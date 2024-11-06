<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comprobante(){
        return $this->belongsTo(Comprobante::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function presentacione()
    {
        return $this->belongsTo(Presentacione::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class)->withTimestamps()
        ->withPivot('cantidad','precio_venta','descuento');
    }
}
