<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Validator, Cache;

class SubtipoProductop extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'koi_subtipoproductop';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_subtypeproduct_production';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subtipoproductop_nombre'
    ];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = [
        'subtipoproductop_activo'
    ];

    public function isValid($data) {
        $rules = [
            'subtipoproductop_nombre' => 'required|max:25',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
