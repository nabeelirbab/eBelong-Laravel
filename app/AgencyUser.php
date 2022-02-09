<?php

/**
 * Class Cource.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App;

use Auth;
use DB;
use File;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * Class Service
 *
 */
class AgencyUser extends Model
{protected $table = "agency_user";
    public function skills()

    {

        return $this->belongsToMany('App\Skill')->withPivot('skill_rating');

    }
}
?>