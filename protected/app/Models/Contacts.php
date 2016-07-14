<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table 	= 'contacts';
	protected $guarded 	= array();
	public $timestamps 	= true;
}
