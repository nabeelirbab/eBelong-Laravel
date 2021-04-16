<?php
/**
 * Class WorkDiary 
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
use Auth;
use Illuminate\Support\Facades\App;
use Cookie;

/**
 * Class WorkDiary 
 *
 */
class WorkDiary extends Model
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
    protected $fillable = array('start_time', 'end_time','project_id','date','description','user_id','status','WeekDay','hours');

    public function saveWorkDiary($request)
    {
        if (!empty($request)) {
            $description = strip_tags($request['description']);
            $user_id = Auth::user()->id;
            $seconds = strtotime($request['end_time']) - strtotime($request['start_time']);
            $this->start_time = filter_var($request['start_time'], FILTER_SANITIZE_STRING);
            $this->end_time = filter_var($request['end_time'], FILTER_SANITIZE_STRING);
            $this->project_id = filter_var($request['project_id'], FILTER_SANITIZE_STRING);
            $this->date = filter_var($request['date'], FILTER_SANITIZE_STRING);
            $this->user_id = filter_var($user_id, FILTER_SANITIZE_STRING);
            $this->description = filter_var($description, FILTER_SANITIZE_STRING);
            $this->status = filter_var('pending', FILTER_SANITIZE_STRING);
            $this->hours = filter_var($seconds/3600, FILTER_SANITIZE_STRING);
            $this->WeekDay = filter_var(date("l", strtotime($request['date'])), FILTER_SANITIZE_STRING);
            return $this->save();
        }
    }
    public static function submitFreelancerBill()
    {
        $pending_work_diary = self::where('status','pending')->update(array ( 'status' => 'submitted') );
        return true;
    }
   
}
