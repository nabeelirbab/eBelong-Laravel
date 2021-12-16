<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper;
use App\Skill;
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
        echo "test";
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

    public function createNew() {

        $skillsData = Skill::select('title', 'id')->get()->toArray();
        if (!empty($skillsData)) {
            $skills = $skillsData;
        } else {
            $skills = [];
        }

        return View::make('back-end.freelancer.agency.create', compact('skills'));

    }

    public function viewInvites() {

        $requested_agency = [];
        $getInvites = 0;
        $getInvitesData = DB::table('agency_associated_users')->select('agency_id')
            ->where('user_id',Auth::user()->id)
            ->where('is_pending',1)
            ->where('is_accepted',0)
            ->get();

        if(!empty($getInvitesData) && isset($getInvitesData[0])) {
            $getInvites = @json_decode(json_encode($getInvitesData), true);
        }

        if (!empty($getInvites) && isset($getInvites[0])) {
            foreach ($getInvites as $invites) {
                $requested_agency[] = DB::table('agency_user')
                    ->where('id',$invites['agency_id'])
                    ->get();

                $requested_agency = @json_decode(json_encode($requested_agency[0]), true);
            }
        }


//        $skillsData = Skill::select('title', 'id')->get()->toArray();
//        if (!empty($skillsData)) {
//            $skills = $skillsData;
//        } else {
//            $skills = [];
//        }

        return View::make('back-end.freelancer.agency.invitations', compact('requested_agency','getInvites'));

    }

    public function updateAgencyDetails() {

        $skillsData = Skill::select('title', 'id')->get()->toArray();
        if (!empty($skillsData)) {
            $skills = $skillsData;
        } else {
            $skills = [];
        }

//        DB::table('users')->where('id',$uid)->update(array('agency_status'=>1));

        return View::make('back-end.freelancer.agency.create');

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

    /**
     * Upload Image to temporary folder.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request)
    {
        $path = Helper::PublicPath() . '/uploads/agency/temp/';
        if (!empty($request['hidden_logo'])) {
            $agency_image = $request['hidden_logo'];
            $image_size = array(
                'small' => array(
                    'width' => 36,
                    'height' => 36,
                ),
                'medium-small' => array(
                    'width' => 60,
                    'height' => 60,
                ),
                'medium' => array(
                    'width' => 100,
                    'height' => 100,
                ),
                'listing' => array(
                    'width' => 255,
                    'height' => 255,
                ),
            );
            // return Helper::uploadTempImage($path, $agency_image);
            return Helper::uploadTempImageWithSize($path, $agency_image, '', $image_size);
        } elseif (!empty($request['hidden_banner_image'])) {
            $agency_image = $request['hidden_banner_image'];
            return Helper::uploadTempImage($path, $agency_image);
        } elseif (!empty($request['project_img'])) {
            $agency_image = $request['project_img'];
            return Helper::uploadTempImage($path, $agency_image);
        } elseif (!empty($request['award_img'])) {
            $agency_image = $request['award_img'];
            return Helper::uploadTempImage($path, $agency_image);
        }
    }
    public function viewMembers(){
        if(Auth::user()){
        $user_id = Auth::user()->id;
        $agency_id = DB::table('users')->select('agency_id')->where('id',$user_id)->first();
        $users = DB::table('agency_associated_users')
        ->where('agency_id',$agency_id->agency_id)
        ->get();
        return View::make('front-end.agencies.agencyMembers',compact('users'));
        }
        else{
            abort(404);
        }
    }
}
