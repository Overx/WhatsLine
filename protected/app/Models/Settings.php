<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table 	= 'settings';
	protected $guarded 	= array();
	public $timestamps 	= true;


	public static function ReadSettingsSingle()
	{
		$settings = self::where('user_id', \Auth::user()->id)
                       ->where('set_status', 'active')
                       ->first();

        if(!empty($settings)):
            return $settings;
        else:
            return '';
        endif;
	}

}
