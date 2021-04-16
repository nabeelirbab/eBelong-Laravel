<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper;
use Illuminate\Support\Facades\Schema;
use DB; 
use View;
use Auth;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
		if (Auth::user()){
			$agency_info = Helper::getAgencyList(0,array('user_id'=>Auth::user()->id));
			if(count($agency_info)){
				$agencyinfo = DB::table('agency_user')->select('id')->where('user_id',Auth::user()->id)->first();
				$agency_users = DB::table('users')->select('users.id','users.agency_status','agency_user.agency_name')
								->join('agency_user','agency_user.id','=','users.agency_id')
								->where(
									array(
										"users.agency_id"=>$agencyinfo->id,
										"users.is_agency"=>1										
									)
								)
								->where("users.id",'<>',Auth::user()->id)
								->paginate(10);
				return View::make('back-end.agency.index',compact('agency_users'));
			}else{
				abort(404);
			}
		}
    }

	public function updateStatus($uid){
		DB::table('users')->where('id',$uid)->update(array('agency_status'=>1));
		$json = array();
		$json['type'] = 'success';
        $json['message'] = "Status change successfully";
		echo json_encode($json);
		exit();
	}

	public function getAgencyList(Request $request){
		$name = $request->input('query');
		$result = DB::table('agency_user')->select('id as value','agency_name')->where('agency_name','LIKE','%'.$name.'%');
		$count = $result->count();
		$result = $result->get()->toArray();
		echo json_encode(array("options"=>$result,"count"=>$count));
		exit();
	}
}
