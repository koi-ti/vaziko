<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;
use App\Models\Production\Materialp;
use Validator;

class Productop5 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_productop5';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'productop5_productop' => 'required|integer',
            'productop5_materialp' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getMateriales($productop)
    {
        $query = Productop5::query();
        $query->orderBy('materialp_nombre', 'asc');
        $query->join('koi_materialp', 'productop5_materialp', '=', 'koi_materialp.id');
        $query->where('productop5_productop', $productop);
        return $query->lists('materialp_nombre', 'koi_materialp.id');
    }

    /**
    *  Select materiales dependiendo del productop
    **/
    public static function getPackaging()
    {
        $query = Materialp::query();
        $query->select('koi_materialp.id as id', 'materialp_nombre as empaque_nombre');
        $query->where('materialp_empaque', true);
        $query->orderBy('empaque_nombre', 'asc');

        return $query->lists('empaque_nombre', 'id');
    }
}
