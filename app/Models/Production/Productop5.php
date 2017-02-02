<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Model;

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
}
