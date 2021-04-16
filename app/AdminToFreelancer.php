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
 * Class AdminToFreelancer
 *
 */
class AdminToFreelancer extends Model
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
    protected $fillable = array('freelance_user_id', 'payout_batch_id','payout_id');
   
}
