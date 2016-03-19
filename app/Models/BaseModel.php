<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	protected $nullable = [];
	
	protected $boolean = [];

	/**
	* Listen for save event
	*/
	public static function boot()
	{
		parent::boot();
	    static::saving(function($model) {
			self::setNullables($model);
	    });
	}

	/**
	* Set empty nullable fields to null
	* @param object $model
	*/
	protected static function setNullables($model)
	{
		foreach($model->nullable as $field) {
			if(empty($model->{$field}))
			{
				$model->{$field} = null;
			}
		}
	}

	/**
	* Set boolean fields
	* @param object $model
	*/
	public function fillBoolean(array $attributes)
	{
        if (count($this->boolean) > 0 && ! static::$unguarded) {
            $attributes = array_intersect_key($attributes, array_flip($this->boolean));
        }

		foreach ($attributes as $key => $value) {
            $key = $this->removeTableFromKey($key);

            // The developers may choose to place some attributes in the "boolean"
        	$this->setAttribute($key, $value ? true : false);
        }
	}
}
