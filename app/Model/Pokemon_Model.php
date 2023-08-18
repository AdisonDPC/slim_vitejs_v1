<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Pokemon_Model extends Model {

    /********************** BEGIN PROTECTED **********************/

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $table = 'pokemons';

	protected $primaryKey = 'id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'name', 
        'types'
    ];

	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

	protected $dates = [];

    protected $casts = [];

	/********************** END PROTECTED **********************/

}
