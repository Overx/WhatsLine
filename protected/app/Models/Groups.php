<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table 	= 'groups';
	protected $guarded 	= array();
	public $timestamps 	= true;


	public static function getListGroups()
	{
		$groups = self::where('user_id', \Auth::user()->id)
				->leftJoin('group_participants', 'groups.gp_id', '=', 'group_participants.gpp_group_id')->get();
				
		return ( count($groups) > 0 ? $groups : []);
	}
}


