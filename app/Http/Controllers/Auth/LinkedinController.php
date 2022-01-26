<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Session;
use Intervention\Image\ImageManagerStatic as Image;
use Helper;
use File;
use App\Profile;

class LinkedinController extends Controller
{
   
    CONST DRIVER_TYPE = 'linkedin';
    protected $User;
    public function __construct(User $User)
    {
        $this->User = $User;
    }


    public function handleLinkedinRedirect()
    {
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function handleLinkedinCallback()
    {
        try {
            
            $user = Socialite::driver(static::DRIVER_TYPE)->stateless()->user();
            // dd($user);
            $request =[
                "first_name" => $user->user["firstName"]["localized"]["en_US"],
                "last_name"=> $user->user["lastName"]["localized"]["en_US"],
                "email"=> $user->email,
                "password" => Hash::make($user->id),
                "role"=> "freelancer",
                "location" => "",
                "oauth_id" => $user->id,
                "oauth_type" => static::DRIVER_TYPE,
                "hidden_avater_image" => $user->avatar,


            ];
            // dd("FF");
            $emailExisted = User::where('email', $user->email)->first();
            $userExisted = User::where('oauth_id', $user->id)->where('oauth_type', static::DRIVER_TYPE)->first();
            if( $userExisted ) {
                
                Auth::login($userExisted);

                return redirect()->route('freelancerDashboard');

            }
            elseif ($emailExisted){
                User::where('email', $user->email)->update(["oauth_id"=>$user->id, "oauth_type"=>static::DRIVER_TYPE]);
                $emailExisted = User::where('email', $user->email)->first();
                $userid = User::select('id')->where('email', $user->email)->first();
                $username = User::select('first_name')->where('email', $user->email)->first();
                $avatar = Profile::select('avater')->where('user_id',$userid->id);
                if(empty($avatar->avatar)){
                    if (!empty($request['hidden_avater_image'])) {
                        $file_original_name = substr($request['hidden_avater_image'], strrpos($request['hidden_avater_image'], '/') + 1);
                        $file_original_name = explode('?',$file_original_name);
                        $file_original_name = $file_original_name[0];
                        $small_img = Image::make($request['hidden_avater_image']);
                        $path = Helper::PublicPath() . '/uploads/users/'.$userid->id.'/';
                        if (!file_exists($path)) {
                            File::makeDirectory($path, 0755, true, true);
                        }
                        // generate small image size
                        $small_img->fit(
                            36,
                            36,
                            function ($constraint) {
                                $constraint->upsize();
                            }
                        );
                        $small_img->save($path . '/small-' . $file_original_name."-".$username->first_name. ".jpg");
                        // generate medium image size
                        $medium_img = Image::make($request['hidden_avater_image']);
                        $medium_img->fit(
                            100,
                            100,
                            function ($constraint) {
                                $constraint->upsize();
                            }
                        );
                        $medium_img->save($path . '/medium-' . $file_original_name."-".$username->first_name. ".jpg");
                        // save original image size
                        $img = Image::make($request['hidden_avater_image']);
                        $img->save($path . '/' . $file_original_name."-".$username->first_name. ".jpg");
                        $_avater = $file_original_name."-".$username->first_name.".jpg";
                        $avatar = Profile::where('user_id',$userid->id)->update(["avater"=> $_avater]);
                    }
                }
                Auth::login($emailExisted);
                return redirect()->route('freelancerDashboard');

            }
            else {
                $verification_code = Session::get('code');
                $newUser = $this->User->storeUser(
                    $request , $verification_code
                );
                session()->put(['user_id' => $newUser]);
                session()->put(['email' => $request['email']]);
                session()->put(['password' => $request['password']]);
                $id = Session::get('user_id');
                $user = User::find($id);
                Auth::login($user);
                return redirect()->route('freelancerDashboard');
            }


        } catch (Exception $e) {
            Session::flash('error', "Account Already Exists");
            dd($e);
            return redirect('/');
        }

    }
}
