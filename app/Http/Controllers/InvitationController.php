<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Mail\InvitationMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\EmailTemplate;
use App\Helper;

class InvitationController extends Controller {

    public function index() {
        if (file_exists(resource_path('views/extend/back-end/admin/invite-people/index.blade.php'))) {
            return view('extend.back-end.admin.invite-people.index');
        } else {
            return view('back-end.admin.invite-people.index');
        }
    }

    public function sendInvitation(Request $request) {
        
        $this->validate(
                $request, [
            'user_type' => 'required'
                ]
        );
        $toEmails = array();
        // File upload ----------------------------
        $fileName = '';
        $usersArr = array();
        $emptyEmails=0;
        $wrongMails=0;
        if ($request->hasFile('email_address_csv')) {
            $this->validate($request, [
                'email_address_csv' => 'mimes:csv,txt'
            ]);
            $files = $request['email_address_csv'];
            $fileName = $this->fileUpload($files);
            // open file 
            $filename = storage_path($fileName);
            $file = fopen($filename, "r");
            $data = array();
            // $pattern = '/[a-z]+@uni\.com/i';
            // $wrongMails=0;

            // fgetcsv($file); //Adding this line will skip the reading of the first line
            $row = 1;
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                if ($row == 1) {
                    $row++;
                    continue;
                } //Adding this line will skip the reading of the first line
                if ($data[2] == '') {
                    $emptyEmails++;
                    continue;
                }
                if(!(filter_var($data[2], FILTER_VALIDATE_EMAIL) ))
                {
                    $wrongMails++;
                    continue;
                }
                $i = 2; // record start from row 2
                $userData = array(
                    'first_name' => $data[0],
                    'last_name' => $data[1],
                    'email' => $data[2],
                    'city' => $data[3],
                    'state' => $data[4],
                    'country' => $data[5],
                );
                array_push($usersArr, $userData);
            }
            fclose($file);
            unlink($filename); // delete file after imported.
        } else {
            $this->validate($request, [
                'email_address' => 'required|email'
            ]);
        
        $toEmails = explode(",", $request['email_address']);
        foreach ($toEmails as $toEmail) {
            $userData = array(
                'first_name' => "",
                'last_name' => "",
                'email' => $toEmail,
                'city' => "",
                'state' => "",
                'country' => "",
            );
            array_push($usersArr, $userData);
        }
    }
        // dd($usersArr);
        $sendGridUserName = env('MAIL_USERNAME','default_val');
        $sendGridPass = env('MAIL_PASSWORD','default_pass');
        // dd($)
        // $url = file_get_contents("https://api.sendgrid.com/api/unsubscribes.get.json?api_user=$sendGridUserName&api_key=$sendGridPass");
        /*
        $url = "https://api.sendgrid.com/api/unsubscribes.get.json?api_user=$sendGridUserName&api_key=$sendGridPass";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);   
        $output = curl_exec($ch);
        curl_close($ch);
        */        
        // $output = json_decode($url, true);
        // $unsubscribeList = array(); 
        // for($i=0;$i<count($output);$i++){
        //    array_push($unsubscribeList, $output[$i]['email']);
        // }
        $unsubscribeEmailNum = 0;
        $sentEmailNum = 0;
        $duplicateEmailNum =0;
        
        $totalEmailNum = 0;
        for ($i = 0; $i < count($usersArr); $i++) {
            $toEmail = $usersArr[$i]['email'];
            if (!empty($toEmail)) {
                $totalEmailNum++;
                $firstName = $usersArr[$i]['first_name'];
                $lastName = $usersArr[$i]['last_name'];
                $country = $usersArr[$i]['country'];
                $city = $usersArr[$i]['city'];
                $state = $usersArr[$i]['state'];
                $fullName = $firstName . " " . $lastName;
                $address = $country . ',' . $city . ',' . $state;
                $userPassword = $this->generatePassword(6);
                // Create User ------
                $userExist = DB::table('users')->select('id')->where('email', filter_var($toEmail, FILTER_SANITIZE_STRING))->get()->first();

                if (!$userExist) {
                   // echo "NOT Exist" . $toEmail;
                    $user = new User();
                    $user->first_name = filter_var($firstName, FILTER_SANITIZE_STRING);
                    $user->last_name = filter_var($lastName, FILTER_SANITIZE_STRING);
                    $user->slug = filter_var($firstName, FILTER_SANITIZE_STRING) . '-' .
                            filter_var($lastName, FILTER_SANITIZE_STRING);
                    $user->email = filter_var($toEmail, FILTER_VALIDATE_EMAIL);
                    $user->password = Hash::make($userPassword);
                    $user->user_verified = 1;
                    $user->badge_id = null;
                    $user->expiry_date = null;
                    $user->invited_at = date('Y-m-d H:i:s');
                    $user->invitation_status = 1;
                    $user->save();
                    $user_id = $user->id;
                    $profile = new Profile();
                    $profile->user_id = $user_id;
                    $profile->address = $address;
                    $profile->save();
                    $hasRoleData = array(
                        'role_id' => $request['user_type'],
                        'model_type' => 'App\User',
                        'model_id' => $user_id
                    ); 
                    DB::table('model_has_roles')->insert($hasRoleData);
                    if($request['user_type']== 3 ){
                    $admin_template = DB::table('email_types')->select('id')->where('email_type', 'invite_freelancer')->first();
                    $template_data = EmailTemplate::getEmailTemplateByID($admin_template['id']);
                    }
                    if($request['user_type']== 2 ){
                        $admin_template = DB::table('email_types')->select('id')->where('email_type', 'invite_employer')->first();
                        $template_data = EmailTemplate::getEmailTemplateByID($admin_template['id']);
                    }
                    if($request['user_type']== 4 ){
                        
                        $admin_template = DB::table('email_types')->select('id')->where('email_type', 'invite_editor')->first();
                        $template_data = EmailTemplate::getEmailTemplateByID($admin_template->id);
                        
                    }
                    // dd($admin_template);
                    
                   
                    $email_params['name'] = Helper::getUserName($user_id);
                    $email_params['email'] = $toEmail;
                    $email_params['password'] = $userPassword;
                    $email_params['link'] = url('/');

                    Mail::to($toEmail)->send(new InvitationMailable( 'invite_people',$template_data, $email_params,$request['user_type']));
                    $sentEmailNum++;
                    } else {
                        $duplicateEmailNum++;
                   
                    }
                
                   }
            
        }
        Session::flash('unsubscribe_email_num', $unsubscribeEmailNum." emails unsubscribed Out of ".$totalEmailNum);
        Session::flash('duplicate_email_num', $duplicateEmailNum." emails duplicate out of ".$totalEmailNum);
        Session::flash('sent_email_num', $sentEmailNum." emails sent out of ".$totalEmailNum);
        Session::flash('empty_email_num', $emptyEmails." empty emails ");
        Session::flash('wrong_email_num', $wrongMails." emails with Wrong Pattern ");
       // Session::flash('total_email_num', $totalEmailNum." emails");
        // $unsubscribeEmailNum = 0;
        // $sentEmailNum = 0;
        // $duplicateEmailNum =0;
        // $totalEmailNum = 0;

        if($sentEmailNum>0){
        // Session::flash('message', trans('invite.invitation_message'));
        return Redirect::back()->with('success', 'Invitation Sent');}
        else{
            // Session::flash('', "Email Sent");
            return Redirect::back()->with('error', "Email Not Sent");
        }
        // return Redirect::to('admin/invite-people');
    }

    private function fileUpload($file) {
        $fileName = $file->getClientOriginalName();
        $uniqueFileName = date('His') . "_" . $fileName; // add datetime for unique file name
        $directory = '../storage/';
        $file->move($directory, $uniqueFileName);
        $fileUrl = $directory . $uniqueFileName;
        return $uniqueFileName;
    }

    public function generatePassword($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }

}
