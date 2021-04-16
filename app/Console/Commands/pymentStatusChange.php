<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Proposal;
use App\SiteManagement;
use App\AdminToFreelancer;

class pymentStatusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:statuschange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Bank transfar payment status change from in process to complete';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */ 
    public function handle(){
        $check = 0;
        $InProgressPayment = DB::table('payouts')->select('paypal_id','id','projects_ids','type')->where(array('payment_method'=>'bacs','status'=>'IN_PROCESS'));

        if($InProgressPayment->count() > 0){ 
            $InProgressPayment = $InProgressPayment->get()->toArray();

            // Get bank transfar data.
            $settings = SiteManagement::getMetaValue('banktransfar_settings');
            $endPoint = $settings[0]['api_endpoint'];
            $client_id = $settings[0]['banktransfar_key'];
            $secret_id = $settings[0]['banktransfar_secret'];

            // For get authentication token 
            $ch = curl_init($endPoint.'authentication');
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('client_key:'.$client_id, 'client_secret:'.$secret_id ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            $token = curl_exec($ch); 
            curl_close($ch); 
            $token = json_decode($token,true);
            if(array_key_exists('token',$token)){
                $token = $token['token'];
                foreach($InProgressPayment as $ipp){
                    $paymentInfo = DB::table('admin_to_freelancers')->select('id','payout_batch_id','freelance_user_id')->where('payout_id',$ipp->id);
                    if($paymentInfo->count() > 0){
                        $paymentInfo = $paymentInfo->get();
                        if($paymentInfo[0]->payout_batch_id != ""){
                            $bankInfo =  unserialize($paymentInfo[0]->payout_batch_id);
                            // For get accounts
                            $ch = curl_init($endPoint.'payments/id/'.$bankInfo['payment_id']);
                            $authorization = "Authorization:Bearer ".$token;
                            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json',$authorization));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_HTTPGET, 1);
                            $transectionInfo = curl_exec($ch);
                            curl_close($ch);
                            $transectionInfo = json_decode($transectionInfo,true);
                            if(array_key_exists('status',$transectionInfo) && $transectionInfo['status'] == "COMPLIANCE_VERIFICATION"){
                                // If payment status completed.
                                AdminToFreelancer::where('payout_id', $ipp->id)->update(['payout_batch_id'=>serialize($transectionInfo)]);

                                // set payment status completed.
                                DB::table('payouts')->where(array('id'=>$ipp->id))->update(array('status'=>'complete')); 
                                $check++;
                                if($ipp->projects_ids != "") {
                                    $projects_ids = explode(",",$ipp->projects_ids);
                                    foreach ($projects_ids as $key => $id) { 
                                        if ($ipp->type == 'job') {
                                            $proposal = Proposal::find($id);
                                            $proposal->paid_progress = 'completed';
                                            $proposal->save();
                                        } elseif ($ipp->type  == 'service') {
                                            DB::table('service_user')
                                                ->where('id', $id)
                                                ->update(['paid_progress' => 'completed']);
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        echo "Admin to freelancer table in record not available";
                        \Log::info("Admin to freelancer table in record not available");
                    }
                } 
            }else{
                echo "Token not found";
                \Log::info("Token not found");
            } 
        }else{
            echo "No any record for change status from in progress to completed";
            \Log::info("No any record for change status from in progress to completed"); 
        }
        if($check > 0){
            echo "\n Bank transfar status change successfully. Total :".$check. " payment status change successfully";
            \Log::info("Bank transfar status change successfully. Total :".$check. " payment status change successfully");
        }
    }
}
