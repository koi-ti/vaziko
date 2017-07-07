<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Cotizacion2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_cotizacion2';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cotizacion2_productoc', 'cotizacion2_medida', 'cotizacion2_cantidad', 'cotizacion2_valor'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['cotizacion3_materialp', 'cotizacion2_productoc'];

    public function isValid($data)
    {
        $rules = [
            'cotizacion2_medida' => 'required',
            'cotizacion2_cantidad' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public function whenMaterial(){
        if(empty(trim($this->cotizacion2_valor)) || is_null(trim($this->cotizacion2_valor))){
            return 'El campo valor es obligatorio cuando es material.';
        }

        // Validar ingresar con producto existente
        $father = Cotizacion2::where('cotizacion2_productoc', $this->cotizacion2_productoc)->whereNull('cotizacion2_materialp')->first();
        if(!$father instanceof Cotizacion2){
            return 'Para insertar un material primero debe crear un producto.';
        }

        // Update father
        $father->cotizacion2_valor = $father->cotizacion2_valor + $this->cotizacion2_valor;
        $father->save();

        return 'OK';
    }

    public function whenProducto() {
        // Validar ingresar con producto existente
        $father = Cotizacion2::where('cotizacion2_productoc', $this->cotizacion2_productoc)->whereNull('cotizacion2_materialp')->first();
        if($father instanceof Cotizacion2){
            if( ( $this->cotizacion2_productoc == $father->cotizacion2_productoc ) && empty( $this->cotizacion2_materialp ) ){
                return "El producto {$this->cotizacion2_productoc} ya se encuentra registrado.";
            }
        }

        return 'OK';
    }

    public function whenDelete() {
        // Father
        $father = Cotizacion2::where('cotizacion2_productoc', $this->cotizacion2_productoc)->whereNull('cotizacion2_materialp')->first();
        if(!$father instanceof Cotizacion2){
            return 'No es posible recuperar el producto padre.';
        }

        // Child
        $child = Cotizacion2::where('cotizacion2_productoc', $father->cotizacion2_productoc)->whereNotNull('cotizacion2_materialp')->get();

        // update valor padre
        $father->cotizacion2_valor = $father->cotizacion2_valor - $this->cotizacion2_valor;
        $father->save();

        if($this->id == $father->id){
            if( count($child) > 0 ){
                return 'No puede eliminar el producto, porque este ya tiene materiales en el carrito.';
            }
        }

        return 'OK';
    }
}
