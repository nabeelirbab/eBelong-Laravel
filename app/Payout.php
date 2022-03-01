<?php
/**
 * Class Payout.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */
namespace App;
use DB;
use Auth;
use App\Helper;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payout
 *
 */
class Payout extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount', 'payment_method',
        'currency', 'status','employee_id',
    ];

    /**
     * Get the user that owns the payout.
     *
     * @return relation
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public static function admintofreelancer($payout,$role)
    {
        if($payout->payment_method == 'paypal'){
            $settings = SiteManagement::getMetaValue('payment_settings');
            $payment_mode = !empty($settings) && !empty($settings[0]['enable_sandbox']) ? $settings[0]['enable_sandbox'] : 'false';
            $endPoint = "";
            if ($payment_mode == 'true') {
                if (!empty(env('PAYPAL_SANDBOX_API_USERNAME'))
                    && !empty(env('PAYPAL_SANDBOX_API_PASSWORD'))
                    && !empty(env('PAYPAL_SANDBOX_API_SECRET'))
                ) {
                    $endPoint = 'https://api.sandbox.paypal.com';
                    $client_id = env('PAYPAL_SANDBOX_PAYOUT_API_CLIENT_ID');
                    $secret_id = env('PAYPAL_SANDBOX_PAYOUT_API_SECRET_ID');
                }
            } elseif ($payment_mode == 'false') {
                if (!empty(env('PAYPAL_LIVE_API_USERNAME'))
                    && !empty(env('PAYPAL_LIVE_API_PASSWORD'))
                    && !empty(env('PAYPAL_LIVE_API_SECRET'))
                ) {
                    $endPoint = 'https://api.paypal.com';
                    $client_id = env('PAYPAL_LIVE_PAYOUT_API_CLIENT_ID');
                    $secret_id = env('PAYPAL_LIVE_PAYOUT_API_SECRET_ID');
                }
            }
            $get_token = self::get_access_token($endPoint,$client_id,$secret_id);
            //$freelancer_data = Profile::find($payout['user_id']);
            $freelancer_data = DB::table('profiles')->select('id','payout_id')->where('user_id', $payout['user_id'])->get()->first();
            // print_r("<pre>");
            // var_dump($freelancer_data);
            // var_dump($payout['user_id']);
            // exit();
            if(!empty($freelancer_data))
            {
                
                $payment_transfer = self::payment_transfer_freelancer($endPoint,$get_token,$freelancer_data->payout_id,$payout);
                if($payment_transfer)
                {
                    $admin_to_freelancer = new AdminToFreelancer();
                    $admin_to_freelancer->freelance_user_id = $payout['user_id'];
                    $admin_to_freelancer->payout_batch_id = $payment_transfer;
                    $admin_to_freelancer->payout_id = $payout['id'];
                    $admin_to_freelancer->save();
                    return array("status"=>true, "message"=>trans('lang.status_updated'),"type"=>"paypal");
                }
                else
                    return array("status"=>false, "message"=>'Paypal issue.');
            } 
            else
                return false;
        }elseif($payout->payment_method == "bacs"){
            // for payment with bank transfar option.
			$freelancerInfo = DB::table('profiles')->select('payout_settings')->where('user_id',$payout['user_id']);
			$freelancerCount = $freelancerInfo->count();
			$freelancerInfo = $freelancerInfo->get()->toArray();
			if($freelancerCount > 0 && $freelancerInfo[0]->payout_settings != ""){
				$freelincebankinfo = unserialize($freelancerInfo[0]->payout_settings);
				$freelancerbankfiledlist = array(
					'beneficiary_account_number',
					'beneficiary_account_type',
					'beneficiary_account_number',
					'beneficiary_bank_name',
					'beneficiary_bank_code',
					'beneficiary_identification_type',
					'beneficiary_identification_value',
					'swiftcode',
					'beneficiary_country_code',
					'beneficiary_address',
					'beneficiary_city'
				);
				$fieldCheck = Helper::array_keys_exists($freelancerbankfiledlist,$freelincebankinfo);
				if($fieldCheck == 1){
					$settings = SiteManagement::getMetaValue('banktransfar_settings');
					$adminfield = array(
						'api_endpoint',
						'banktransfar_key',
						'banktransfar_secret',
						'remitter_identification_type',
						'remitter_identification_number',
						'remitter_country_code',
						'remitter_address',
						'remit_purpose_code',
						'remitter_city',
						'remitter_postcode'
					);
					if(!empty($settings) && Helper::array_keys_exists($adminfield,$settings[0]) == 1){
						$bank_transfar = self::bankTranfarToFreelincer($settings,$freelincebankinfo,$payout);
						if(!empty($bank_transfar) && array_key_exists("payment_id",$bank_transfar)){
							$admin_to_freelancer = new AdminToFreelancer();
							$admin_to_freelancer->freelance_user_id = $payout['user_id'];
							$admin_to_freelancer->payout_batch_id = serialize($bank_transfar);
							$admin_to_freelancer->payout_id = $payout['id'];
							$admin_to_freelancer->save();
							return array("status"=> true, "message"=>trans('lang.status_updated'), "data"=>$bank_transfar, "type"=>"bacs");
						}else{
							return array("status"=>false,"message"=>"freelancer fill wrong bank details");
						}
					}else{
						return array("status"=>false,"message"=>"admin not fill proper bank details");
					}
				}else{
					return array("status"=>false,"message"=>"freelancer not fill proper bank details");
				}
			}else{
				return array("status"=>false,"message"=>"freelancer not fill bank details");
			}
        }       
    }

    public static function get_access_token($endPoint,$client_id,$secret_id)
    {
        $url = $endPoint .'/v1/oauth2/token'; 
        $postdata = 'grant_type=client_credentials';        
        $client_id = $client_id;
        $client_secret = $secret_id;
        
        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_POST, true); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $client_id . ":" . $client_secret);
        curl_setopt($curl, CURLOPT_HEADER, false); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
        #curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
        $response = curl_exec( $curl );
        if (empty($response)) {
            // some kind of an error happened
            //die(curl_error($curl));
            $this->_error = json_decode($response,1);
            curl_close($curl); // close cURL handler
            return false;
        } else {
            $info = curl_getinfo($curl);
            //echo "Time took: " . $info['total_time']*1000 . "ms\n";
            curl_close($curl); // close cURL handler
            if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
                //echo "Received error: " . $info['http_code']. "\n";
                //echo "Raw response:".$response."\n";
                $this->_error = json_decode( $response , 1 );
                return false;
            }
        }
        // Convert the result from JSON format to a PHP array 
        $jsonResponse = json_decode( $response);
        return $jsonResponse->access_token;
    }

    public static function payment_transfer_freelancer($endPoint,$get_token,$freelance_email,$payout)
    {
        $url =  $endPoint.'/v1/payments/payouts';
        $creditcard = array(
                'sender_batch_header' => array (
                    "sender_batch_id" =>  "Payouts_".date('y')."_".time(),
                    "email_subject" => "You have a payout!",
                    "email_message" => "You have received a payout! Thanks for using our service!",
                ),
                'items' => array(
                    array(
                        "recipient_type" => "EMAIL",
                        "amount" => array(
                            "value" => $payout['amount'],
                            "currency" => "USD"
                        ),
                        "note" => "Thanks for your patronage!",
                        "sender_item_id" => "201403140001",
                        "receiver" => $freelance_email,
                        "alternate_notification_method" => array(
                            "phone" => array(
                                "country_code" => "91",
                                "national_number" => "9999988888"
                            )
                        ),
                        "notification_language" => "fr-FR"
                    ),
                )
            );
        $json = json_encode($creditcard);

        $json_resp = self::make_call($url,$get_token, $json, 'POST');
        if($json_resp == false) 
                return false;
        return $json_resp['batch_header']['payout_batch_id'];
    }

    public static function make_call($url,$get_token,$postdata,$call_type = 'POST'){
       
        $curl = curl_init($url); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $call_type);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer '.$get_token,
                    'Accept: application/json',
                    'Content-Type: application/json'
                    ));

        if($call_type == 'POST' || $call_type == 'PATCH')
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
        
        #curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
        $response = curl_exec( $curl );
        
        if (empty($response)) {
            // some kind of an error happened
            //die(curl_error($curl));
            $error = json_decode($response,1);

            curl_close($curl); // close cURL handler
            
            return false;
        } else {
            $info = curl_getinfo($curl);
            //echo "Time took: " . $info['total_time']*1000 . "ms\n";
            curl_close($curl); // close cURL handler
            if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
                
                //echo "Received error: " . $info['http_code']. "\n";
                //echo "Raw response:".$response."\n";
               
                $error = json_decode( $response , 1 );
                return false;
            }
        }
        // Convert the result from JSON format to a PHP array 
        $jsonResponse = json_decode($response, TRUE);
        return $jsonResponse;
    }

    public static function bankTranfarToFreelincer($settings,$freelincebankinfo,$payout){
     
        $endPoint = $settings[0]['api_endpoint'];
        $client_id = $settings[0]['banktransfar_key'];
        $secret_id = $settings[0]['banktransfar_secret'];
        $remitter_identification_type = $settings[0]['remitter_identification_type'];
        $remitter_identification_number = $settings[0]['remitter_identification_number'];
        $remitter_country_code = $settings[0]['remitter_country_code'];
        $remitter_address = $settings[0]['remitter_address'];
        $remit_purpose_code = $settings[0]['remit_purpose_code'];
        $remitter_city = $settings[0]['remitter_city'];
        $remitter_postcode = $settings[0]['remitter_postcode'];

        // For get authentication token 
        $ch = curl_init($endPoint.'authentication');
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json', 'client_key:'.$client_id, 'client_secret:'.$secret_id ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $token = json_decode($result);
        $token = $token->token;

        // For get accounts
        $ch = curl_init($endPoint.'account');
        $authorization = "Authorization:Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json',$authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $accounts = json_decode($result);
        $accountno = $accounts[0]->account_number;
        
        // For remitter info
        $userInfo = json_decode(Auth::user(),true);

        // get Freelaincer name
        $fruser = DB::table('users')->select('first_name','last_name')->where('id',$payout->user_id)->first();
        $post = array(
            "request_id"=> 'EBRQ'.time(),
            "account_number"=>$accountno,
            "transaction_number"=>'EBTN'.time(),
            "destination_currency"=>"USD",
            "destination_amount"=>(int) $payout->amount,
            "local_conversion_currency"=>"USD",
            "statement_narrative"=>"Salary",
            "remitter_name"=>$userInfo['first_name'].' '.$userInfo['last_name'],
            "remitter_given_name"=>true,
            "remitter_account_type"=>"Company",
            //"remitter_bank_account_number"=>"10022206393",
            //"remitter_identification_type"=>"Company Registration No",
            //"remitter_identification_number"=>"IN1244654",
            //"remitter_country_code"=>"IN",
            //"remitter_address"=>"Sakinaka Mumbai India",
            //"remit_purpose_code"=>"IR001",
            //"remitter_source_of_income"=>"Cross border remittence",
            //"remitter_beneficiary_relationship"=>"Employee",
            //"remitter_contact_number"=>"1234567890",
            //"remitter_dob"=>"",
            //"remitter_city"=>"Mumbai",
            //"remitter_postcode"=>"4703101",
            //"remitter_state"=>"Maharashtra",
            //"remitter_place_of_birth"=>"IN",
            //"remitter_nationality"=>"IN",
            //"remitter_occupation"=>"EXECUTIVE",
            "beneficiary_name"=>$fruser->first_name.' '.$fruser->last_name,
            //"beneficiary_address"=>"New york city USA",
            //"beneficiary_city"=>"New York",
            "beneficiary_country_code"=>$freelincebankinfo["beneficiary_country_code"],
            //"beneficiary_email"=>"mark@abc.com",
            "beneficiary_account_type"=>$freelincebankinfo["beneficiary_account_type"],
            //"beneficiary_contact_number"=>"1234567891",
            //"beneficiary_state"=>"New York",
            //"beneficiary_postcode"=>"10005",
            "beneficiary_account_number"=>$freelincebankinfo["beneficiary_account_number"],
            //"beneficiary_bank_account_type"=>"",
            "beneficiary_bank_name"=>$freelincebankinfo["beneficiary_bank_name"],
            "beneficiary_bank_code"=>$freelincebankinfo["beneficiary_bank_code"],
            "beneficiary_identification_type"=>"Company Organization Code",
            "beneficiary_identification_value"=>$freelincebankinfo["beneficiary_identification_value"],
            "routing_code_type_1"=>"SWIFT",
            "routing_code_value_1"=>$freelincebankinfo["swiftcode"],
            //"deduct_amount"=>100,
            //"remitter_source_of_funds"=>"",
            //"payout_method"=>"CASH_PAYOUT",
            "beneficiary_address"=>$freelincebankinfo["beneficiary_address"],
            "beneficiary_city"=>$freelincebankinfo["beneficiary_city"],
            "remitter_identification_type"=>$remitter_identification_type,
            "remitter_identification_number"=>$remitter_identification_number,
            "remitter_country_code"=>$remitter_country_code,
            "remitter_address"=> $remitter_address,
            "remit_purpose_code"=>$remit_purpose_code,
            "remitter_city"=>$remitter_city,
            "remitter_postcode"=>$remitter_postcode
        );
      
        $ch = curl_init();
        $post = json_encode($post);
        $authorization = "Authorization:Bearer ".$token;
        curl_setopt($ch, CURLOPT_URL,$endPoint.'payments/create'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json',$authorization));
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result,true);
        if(array_key_exists('payment_id',$result)){
            return $result;
        }else{
            return array();
        }
    }
} 
