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
            $userExisted = User::where('oauth_id', $user->id)->where('oauth_type', static::DRIVER_TYPE)->first();
            
            if( $userExisted ) {
                
                Auth::login($userExisted);

                return redirect()->route('freelancerDashboard');

            }else {
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
            Session::flash('error', $e);
            return Redirect::back();
        }

    }
}
