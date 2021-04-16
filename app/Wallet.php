<?php
/**
 * Class AdminToFreelancer
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Validator;
use File;
use Storage;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\App;
use Cookie;

/**
 * Class Wallet
 *
 */
class Wallet extends Model
{
    /**
     * Add Fillables
     *
     * @access protected
     *
     * @var array $fillable
     *
     * @return mixed
     */
    protected $fillable = array('type', 'job_id','employer_id','freelancer_id','description','amount','wallet_type');
   
    public static function createentry($data)
    {
        $add = self::create($data);
        if($add)
            return $add;
        return false; 
    }
}
