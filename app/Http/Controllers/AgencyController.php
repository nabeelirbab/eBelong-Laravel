<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper;
use App\Skill;
use App\AgencyUser;
use Illuminate\Support\Facades\Schema;
use Session;
use DB; 
use View;
use Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\FreelancerEmailMailable;

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

    public function createNew() {

        $skillsData = Skill::select('title', 'id')->get()->toArray();
        if (!empty($skillsData)) {
            $skills = $skillsData;
        } else {
            $skills = [];
        }

        return View::make('back-end.freelancer.agency.create', compact('skills'));

        
    }
    public function getAgencySkills(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            // $course = $this->cource::where('slug', $request['slug'])->select('id')->first();
            
                // $agency = $this->cource::find($request['id']);
                $agency = AgencyUser::find($request['id']);
                if (!empty($agency)) {
                $skills = $agency->skills->toArray();
                if (!empty($skills)) {
                    $json['type'] = 'success';
                    $json['skills'] = $skills;
                    return $json;
                } else {
                    $json['error'] = 'error';
                    return $json;
                }
            } else {
                $json['error'] = 'error';
                return $json;
            }
      }
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
    public function removeMembers(Request $request){
        if(!empty($request['id'])){
        $delData = DB::table('agency_associated_users')
        ->where('user_id',$request['id'])->delete();
        $json['type'] = 'success';
        $json['message'] = trans('lang.ph_user_delete_message');
        return $json;
    } else {
        $json['type'] = 'error';
        $json['message'] = trans('lang.something_wrong');
        return $json;
    }
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
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $keyword_tokens = explode(' ', $keyword);
                $keyword_tokens = array_diff($keyword_tokens, [""]);
                $count = count($keyword_tokens);
                if($count>1){
                    // $users = User::where('first_name', 'like', '%' . $keyword_tokens[0] . '%')->where('last_name', 'like', '%' . $keyword_tokens[$count-1] . '%')->paginate(7)->setPath('');
                    $users = User::where('first_name', 'like', '%' . $keyword_tokens[0] . '%')->orwhere('last_name', 'like', '%' . $keyword_tokens[$count-1] . '%')
                    ->join('agency_associated_users', 'agency_associated_users.user_id', '=', 'users.id')
                    ->where('agency_associated_users.user_id','!=' ,null)->where('agency_associated_users.agency_id', "=",$agency_id->agency_id)
                    // ->where('agency_associated_users.is_pending',"!=",0)->where('agency_associated_users.is_accepted','!=',0)
                    ->select('agency_associated_users.*')->paginate(10);
                    
                }

                else{
                    // $users = User::where('first_name', 'like', '%' . $keyword . '%')->orWhere('last_name', 'like', '%' . $keyword . '%')
                    $users = $users = User::where('first_name', 'like', '%' . $keyword . '%')->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->join('agency_associated_users', 'agency_associated_users.user_id', '=', 'users.id')
                    ->where('agency_associated_users.user_id','!=' ,null)->where('agency_associated_users.agency_id', "=",$agency_id->agency_id)
                    // ->where('agency_associated_users.is_pending',"!=",0)->where('agency_associated_users.is_accepted','!=',0)
                    ->select('agency_associated_users.*')->paginate(10);
                }
                $pagination = $users->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            }
            else{
                $user_id = Auth::user()->id;
                $agency_id = DB::table('users')->select('agency_id')->where('id',$user_id)->first();
                $users = DB::table('agency_associated_users')
                ->where('agency_id',$agency_id->agency_id)
                // ->where('is_pending',"!=",0)->where('is_accepted','!=',0)
                ->latest()->paginate(10);

            }
        
        return View::make('front-end.agencies.agencyMembers',compact('users'));
        }
        else{
            abort(404);
        }
    }
    public function edit($id){
        $agency = DB::table('agency_user')->where('id',$id)->first();
        // dd($agency);
        $skillsData = Skill::select('title', 'id')->get()->toArray();
        if (!empty($skillsData)) {
            $skills = $skillsData;
        } else {
            $skills = [];
        }

        return View::make('back-end.freelancer.agency.edit', compact('skills','agency'));
    }
    public function destroy(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            $course = DB::table('agency_user')->where('id',$request['id'])->delete();
            DB::table('agency_associated_users')->where('agency_id', $request['id'])->delete();
            DB::table('users')->where('id',Auth::user()->id)->update(array('is_agency'=>0));
            $json['type'] = 'success';
            $json['message'] = trans('lang.agency_delete');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
    public function acceptInvitation($agencyid){
        $user_has_agency = DB::table('agency_associated_users')->where('user_id',Auth::user()->id)->where('is_accepted' , 0)->first();
    //    dd($user_has_agency);
        if(empty($user_has_agency)){
        DB::table('agency_associated_users')->where('agency_id',$agencyid)->where('user_id',Auth::user()->id)->update(array('is_pending'=>0, 'is_accepted'=>1));
        $agency_name = DB::table('agency_user')->select('agency_name')->where('id',$agencyid)->first();
        $creator = DB::table('agency_user')->select('user_id')->where('id',$agencyid)->first();
        $creator_email = DB::table('users')->select('email')->where('id',$creator->user_id)->first();
        if (trim(config('mail.username')) != "" && trim(config('mail.password')) != "") {
            $email_params = array();
            
                //email to creator of agency
                $template_data = Helper::getAgencyInvitationAcceptEmailContent();
                $email_params['agency_creator_name'] = Helper::getUserName($creator->user_id);
                $email_params['agency_member_name'] = Helper::getUserName(Auth::user()->id);
                // $agency_info =  Helper::getAgencyList($data['agency_id']);
                $email_params['agency_name'] = $agency_name->agency_name;
                Mail::to($creator_email->email)
                    ->send(
                        new FreelancerEmailMailable(
                            'accept_agency',
                            $template_data,
                            $email_params
                        )
                    );
            
        }
        Session::flash('message', "Invitation Sucessfully Accepted");
        return Redirect::back();
    }
    else{
        Session::flash('message', "You're Already Associated with an Agency");
        return Redirect::back();

    }
    }
    public function DeclineInvitation($agencyid){

        DB::table('agency_associated_users')->where('agency_id',$agencyid)->where('user_id',Auth::user()->id)->update(array('is_pending'=>0, 'is_accepted'=>0));
        Session::flash('message', "Invitation Sucessfully Declined");
        return Redirect::back();
    }
}
