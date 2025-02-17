<?php

/**
 * Class PaypalController
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cource;
use App\Invoice;
use App\Item;
use Carbon\Carbon;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\SiteManagement;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Helper;
use Auth;
use DB;
use App\Package;
use Illuminate\Support\Facades\Mail;
use App\Proposal;
use App\EmailTemplate;
use App\Mail\FreelancerEmailMailable;
use App\Mail\EmployerEmailMailable;
use App\Job;
use App\Message;
use App\Service;
use App\Wallet;
use App\WorkDiary;
use App\HourlyJobPayOut;

/**
 * Class PaypalController
 *
 */
class PaypalController extends Controller
{

    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $provider
     */
    protected $provider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    /**
     * Get index.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        if (Auth::user()) {
            $response = [];
            if (session()->has('code')) {
                $response['code'] = session()->get('code');
                session()->forget('code');
            }
            if (session()->has('message')) {
                $response['message'] = session()->get('message');
                session()->forget('message');
            }
            $error_code = session()->get('code');
            Session::flash('payment_message', $response);
            $product_type = session()->get('type');
            $project_type = session()->get('project_type');
            if (Auth::user()->getRoleNames()[0] == "employer") {
                if ($product_type == 'project') {
                    if ($project_type == 'service') {
                        return Redirect::to('employer/services/hired');
                    } else {
                        return Redirect::to('employer/jobs/hired');
                    }
                } else {
                    return Redirect::to('dashboard/packages/employer');
                }
            } else if (Auth::user()->getRoleNames()[0] == "freelancer") {
                if ($product_type == 'project') {
                    if ($project_type == 'course') {
                        return Redirect::to('search-results?type=instructors');
                        session()->forget('type');
                    }
                }
                else{
                session()->forget('type');
                return Redirect::to('dashboard/packages/freelancer');
                }
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get express checkout.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpressCheckout(Request $request)
    {
        $settings = SiteManagement::getMetaValue('payment_settings');
        $payment_mode = !empty($settings) && !empty($settings[0]['enable_sandbox']) ? $settings[0]['enable_sandbox'] : 'false';
        // $payment_mode = true;
        if ($payment_mode == 'true') {
            if (empty(env('PAYPAL_SANDBOX_API_USERNAME'))
                && empty(env('PAYPAL_SANDBOX_API_PASSWORD'))
                && empty(env('PAYPAL_SANDBOX_API_SECRET'))
            ) {
                Session::flash('error', trans('lang.paypal_empty_credentials'));
                return Redirect::back();
            }
            // else{
            //     // dd(env('PAYPAL_SANDBOX_API_USERNAME'));
            // }
        } elseif ($payment_mode == 'false') {
            if (empty(env('PAYPAL_LIVE_API_USERNAME'))
                && empty(env('PAYPAL_LIVE_API_PASSWORD'))
                && empty(env('PAYPAL_LIVE_API_SECRET'))
            ) {
                Session::flash('error', trans('lang.paypal_empty_credentials'));
                return Redirect::back();
            }
        }

        $settings = SiteManagement::getMetaValue('commision');
        $currency = !empty($settings[0]['currency']) ? $settings[0]['currency'] : 'USD';
        // dd($currency);
        // $currency = 'USD';
        if (Auth::user()) {
            $recurring = ($request->get('mode') === 'recurring') ? true : false;
            // $recurring = false;
            $success = true;
            $cart = $this->getCheckoutData($recurring, $success);
            // dd($cart);
            $payment_detail = array();
            try {
                $response = $this->provider->setCurrency($currency)->setExpressCheckout($cart, $recurring);
                // dd($response);
                if ($response['ACK'] == 'Failure') {
                    Session::flash('error', $response['L_LONGMESSAGE0']);
                    return Redirect::back();
                }
                return redirect($response['paypal_link']);
            } catch (\Exception $e) {
                //  dd($e);
                $invoice = $this->createInvoice($cart, 'Invalid', $payment_detail);
                session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get Express Checkout Success.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        if (Auth::user()) {
            $recurring = ($request->get('mode') === 'recurring') ? true : false;
            // $recurring = false;
            $token = $request->get('token');
            $PayerID = $request->get('PayerID');
            $success = true;

            $cart = $this->getCheckoutData($recurring, $success);
            
            // Verify Express Checkout Token
            $response = $this->provider->getExpressCheckoutDetails($token);
            if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

                if ($recurring === true) {
                    $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cart['subscription_desc']);
                    if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                        $status = 'Processed';
                    } else {
                        $status = 'Invalid';
                    }
                } else {
                    // Perform transaction on PayPal
                    $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                    if ($payment_status['ACK'] == 'Failure') {
                        Session::flash('error', $response['L_LONGMESSAGE0']);
                        return Redirect::back();
                    }
                    $status = !empty($payment_status['PAYMENTINFO_0_PAYMENTSTATUS']) ? $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'] : 'Processed';
                }
                $payment_detail = array();
                $payment_detail['payer_name'] = $response['FIRSTNAME'] . " " . $response['LASTNAME'];
                $payment_detail['payer_email'] = $response['EMAIL'];
                $payment_detail['seller_email'] = !empty($response['PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID']) ? $response['PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID'] : '';
                $payment_detail['currency_code'] = $response['CURRENCYCODE'];
                $payment_detail['payer_status'] = $response['PAYERSTATUS'];
                $payment_detail['transaction_id'] = !empty($payment_status['PAYMENTINFO_0_TRANSACTIONID']) ? $payment_status['PAYMENTINFO_0_TRANSACTIONID'] : '';
                $payment_detail['sales_tax'] = $response['TAXAMT'];
                $payment_detail['invoice_id'] = $response['INVNUM'];
                $payment_detail['shipping_amount'] = $response['SHIPPINGAMT'];
                $payment_detail['handling_amount'] = $response['HANDLINGAMT'];
                $payment_detail['insurance_amount'] = $response['INSURANCEAMT'];
                $payment_detail['paypal_fee'] = !empty($payment_status['PAYMENTINFO_0_FEEAMT']) ? $payment_status['PAYMENTINFO_0_FEEAMT'] : '';
                $payment_detail['payment_date'] = $payment_status['TIMESTAMP'];
                $payment_detail['product_qty'] = $cart['items'][0]['qty'];

                $invoice = $this->createInvoice($cart, $status, $payment_detail);
                
                //$project_type = session()->get('project_type');
                //Order Table invoice id update Start
                // 'type' => $invoice->type
                //DB::table('orders')
                  //  ->where('id', $cart['order_id'])
                  //  ->update(['invoice_id' => $invoice->id, 'type' =>  $project_type]);
                //Order Table invoice id update End 
                
                // print_r("here");
                // exit();
                if ($invoice->paid) {
                    session()->put(['code' => 'success', 'message' => "Thank you for your subscription"]);
                } else {
                    session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
                }
                return redirect('paypal/redirect-url');
            } else {
                abort(404);
            }
        }
    }


    /**
     * Get Express Checkout Success.
     *
     * @param mixed $recurring $recurring
     * @param mixed $success   $recurring
     *
     * @return \Illuminate\Http\Response
     */
    protected function getCheckoutData($recurring, $success)
    {
        if (Auth::user()) {
            if (session()->has('product_id')) {
                $data = [];
                $id = session()->get('product_id');
                $title = session()->get('product_title');
                $price = session()->get('product_price');
                
                $user_id = Auth::user()->id;
                $settings = SiteManagement::getMetaValue('commision');
                $currency = !empty($settings[0]['currency']) ? $settings[0]['currency'] : 'USD';
               
                if ($success == true) {
                    DB::table('orders')->insert(
                        ['user_id' => $user_id, 'product_id' => $id, 'invoice_id' => null, 'status' => 'pending', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
                    );
                    $order_id = DB::getPdo()->lastInsertId();
                    session()->put(['custom_order_id' => $order_id]);
                    $data['order_id'] = $order_id;
                }
                $random_number = Helper::generateRandomCode(4);
                $unique_code = strtoupper($random_number);
                
                $order_id = Invoice::all()->count() + 1;
                if ($recurring === true) {
                    $data['items'] = [
                        [
                            'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $order_id,
                            'price' => 0,
                            'qty' => 1,
                        ],
                    ];
                    $data['return_url'] = url('/paypal/ec-checkout-success?mode=recurring');
                    $data['subscription_desc'] = 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $order_id;
                } else {
                    $data['items'] = [
                        [
                            'product_id' => $id,
                            'subscriber_id' => $user_id,
                            'name' => $title,
                            'price' => $price,
                            'qty' => 1,
                            'currency_code' => $currency,
                        ],

                    ];
                    $data['return_url'] = url('/paypal/ec-checkout-success');
                }
                $data['invoice_id'] = config('paypal.invoice_prefix') . '_' . $unique_code . '_' . $order_id;
                $data['invoice_description'] = "Order #$order_id Invoice";
                $data['cancel_url'] = url('/');
                $total = 0;
                foreach ($data['items'] as $item) {
                    $total += $item['price'] * $item['qty'];
                }
                $data['total'] = $total;
                $settings = SiteManagement::getMetaValue('commision');
                if(!empty($settings) && !empty($settings[0]['emp_commision']))
                {
                    $commision_amount = ($settings[0]['emp_commision']/100)*$data['total'];
                    $data['total'] = $data['total'] + $commision_amount;
                    $data['items'][0]['price'] = $data['total'];
                }
                return $data;
            } else {
                abort(404);
            }
        } else {
            Session::flash('message', trans('lang.product_id_not_found'));
            return Redirect::to('/');
        }
    }

    /**
     * Create invoice
     *
     * @param mixed $cart           cart
     * @param mixed $status         status
     * @param mixed $payment_detail payment_detail
     *
     * @return \Illuminate\Http\Response
     */
    protected function createInvoice($cart, $status, $payment_detail)
    {
        //create invoice
        $invoice = new Invoice();
        $invoice->title = filter_var($cart['invoice_description'], FILTER_SANITIZE_STRING);
        $invoice->price = $cart['total'];
        $invoice->payer_name = filter_var($payment_detail['payer_name'], FILTER_SANITIZE_STRING);
        $invoice->payer_email = filter_var($payment_detail['payer_email'], FILTER_SANITIZE_EMAIL);
        $invoice->seller_email = filter_var($payment_detail['seller_email'], FILTER_SANITIZE_EMAIL);
        $invoice->currency_code = filter_var($payment_detail['currency_code'], FILTER_SANITIZE_STRING);
        $invoice->payer_status = filter_var($payment_detail['payer_status'], FILTER_SANITIZE_STRING);
        $invoice->transaction_id = filter_var($payment_detail['transaction_id'], FILTER_SANITIZE_STRING);
        $invoice->invoice_id = filter_var($payment_detail['invoice_id'], FILTER_SANITIZE_STRING);
        $invoice->shipping_amount = $payment_detail['shipping_amount'];
        $invoice->handling_amount = $payment_detail['handling_amount'];
        $invoice->insurance_amount = $payment_detail['insurance_amount'];
        $invoice->sales_tax = 0;
        $invoice->payment_mode = filter_var('paypal', FILTER_SANITIZE_STRING);
        $invoice->paypal_fee = !empty($payment_detail['paypal_fee']) ? $payment_detail['paypal_fee'] : 0;        
        if (!strcasecmp($status, 'completed') || !strcasecmp($status, 'Processed')) {
            $invoice->paid = 1;
        } else {
            $invoice->paid = 0;
        }
        $product_type = session()->get('type');
        $project_type = session()->get('project_type');
        $invoice->type = $product_type;
        $invoice->save();
        $invoice_id = DB::getPdo()->lastInsertId();
        // create item
        collect(
            $cart['items']
        )->each(
            function ($product) use ($invoice) {
                $product_type = session()->get('type');
                $project_type = session()->get('project_type');
                $product_price = $invoice->price - $invoice->sales_tax;
                if ($product_type == 'package') {
                    $item = DB::table('items')->select('id')->where('subscriber', $product['subscriber_id'])->first();
                    if (!empty($item)) {
                        $item = Item::find($item->id);
                    } else {
                        $item = new Item();
                    }
                } else {
                    $item = new Item();
                }
                $item->invoice_id = filter_var($invoice->id, FILTER_SANITIZE_NUMBER_INT);
                $item->product_id = filter_var($product['product_id'], FILTER_SANITIZE_NUMBER_INT);
                $item->subscriber = $product['subscriber_id'];
                $item->item_name = filter_var($product['name'], FILTER_SANITIZE_STRING);
                $item->item_price = $product_price;
                $item->item_qty = filter_var($product['qty'], FILTER_SANITIZE_NUMBER_INT);
                $item->save();
                $last_order_id = session()->get('custom_order_id');
               	

                if ($product_type == 'package'){
                	DB::table('orders')
                     ->where('id', $last_order_id)
                    ->update(['status' => 'completed', 'invoice_id' => $invoice->id, 'type' => $product_type]);

                }elseif ($project_type == 'service') {
                DB::table('orders')
                    ->where('id', $last_order_id)
                    ->update(['status' => 'completed', 'invoice_id' => $invoice->id, 'type' => $project_type]);
                }
                elseif($project_type == "course"){
                    DB::table('orders')
                    ->where('id', $last_order_id)
                    ->update(['status' => 'completed', 'invoice_id' => $invoice->id, 'type' => $project_type]);
                
                }
                else {
                    // dd("djdjjd");

                   DB::table('orders')
                    ->where('id', $last_order_id)
                    ->update(['status' => 'completed', 'invoice_id' => $invoice->id, 'type' => 'job']);

                } 


            }
        );
        if (Auth::user()) {
            if ($product_type == 'package') {
                if (session()->has('product_id')) {
                    $package_item = Item::where('subscriber', Auth::user()->id)->first();
                    $id = session()->get('product_id');
                    $package = Package::find($id);
                    $option = !empty($package->options) ? unserialize($package->options) : '';
                    $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
                    $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
                    $user = User::find(Auth::user()->id);
                    if (!empty($package->badge_id) && $package->badge_id != 0) {
                        $user->badge_id = $package->badge_id;
                    }
                    $user->expiry_date = $expiry_date;
                    $user->save();
                    // send mail
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $role = $user->getRoleNames()->first();
                        $package_options = unserialize($package->options);
                        if (!empty($invoice)) {
                            if ($package_options['duration'] === 'Quarter') {
                                $expiry_date = $invoice->created_at->addDays(4);
                            } elseif ($package_options['duration'] === 'Month') {
                                $expiry_date = $invoice->created_at->addMonths(1);
                            } elseif ($package_options['duration'] === 'Year') {
                                $expiry_date = $invoice->created_at->addYears(1);
                            }
                        }
                        if ($role === 'employer') {
                            if (!empty($user->email)) {
                                $email_params = array();
                                $template = DB::table('email_types')->select('id')->where('email_type', 'employer_email_package_subscribed')->get()->first();
                                if (!empty($template->id)) {
                                    $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                                    $email_params['employer'] = Helper::getUserName(Auth::user()->id);
                                    $email_params['employer_profile'] = url('profile/' . Auth::user()->slug);
                                    $email_params['name'] = $package->title;
                                    $email_params['price'] = $package->cost;
                                    $email_params['expiry_date'] = !empty($expiry_date) ? Carbon::parse($expiry_date)->format('M d, Y') : '';
                                    
                                    Mail::to(Auth::user()->email)
                                        ->send(
                                            new EmployerEmailMailable(
                                                'employer_email_package_subscribed',
                                                $template_data,
                                                $email_params
                                            )
                                        );
                                }
                            }
                        } elseif ($role === 'freelancer') {
                            if (!empty(Auth::user()->email)) {
                                $email_params = array();
                                $template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_package_subscribed')->get()->first();
                                if (!empty($template->id)) {
                                    $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                                    $email_params['freelancer'] = Helper::getUserName(Auth::user()->id);
                                    $email_params['freelancer_profile'] = url('profile/' . Auth::user()->slug);
                                    $email_params['name'] = $package->title;
                                    $email_params['price'] = $package->cost;
                                    $email_params['expiry_date'] = !empty($expiry_date) ? Carbon::parse($expiry_date)->format('M d, Y') : '';

                                    Mail::to(Auth::user()->email)
                                        ->send(
                                            new FreelancerEmailMailable(
                                                'freelancer_email_package_subscribed',
                                                $template_data,
                                                $email_params
                                            )
                                        );
                                }
                            }
                        }
                    }
                }
            } else if ($product_type == 'project') {

                if (session()->has('project_type')) {
                    $project_type = session()->get('project_type');
                   
                    if ($project_type == 'service') {
                        $id = session()->get('product_id');
                        $freelancer = session()->get('service_seller');
                        $service = Service::find($id);
                        $service->users()->attach(Auth::user()->id, ['type' => 'employer', 'status' => 'hired', 'seller_id' => $freelancer, 'paid' => 'pending']);
                        $service->save();
                        // send message to freelancer
                        $message = new Message();
                        $user = User::find(intval(Auth::user()->id));
                        $message->user()->associate($user);
                        $message->receiver_id = intval($freelancer);
                        $message->body = Helper::getUserName(Auth::user()->id) . ' ' . trans('lang.service_purchase') . ' ' . $service->title;
                        $message->status = 0;
                        $message->save();
                        // send mail
                        if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                            $email_params = array();
                            $template_data = Helper::getFreelancerNewOrderEmailContent();
                            $email_params['title'] = $service->title;
                            $email_params['service_link'] = url('service/' . $service->slug);
                            $email_params['amount'] = $service->price;
                            $email_params['freelancer_name'] = Helper::getUserName($freelancer);
                            $email_params['employer_profile'] = url('profile/' . $user->slug);
                            $email_params['employer_name'] = Helper::getUserName($user->id);
                            $freelancer_data = User::find(intval($freelancer));
                            Mail::to($freelancer_data->email)
                                ->send(
                                    new FreelancerEmailMailable(
                                        'freelancer_email_new_order',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                    }
                
                //
                elseif ($project_type == 'course') {
                    $project_type = session()->get('project_type');
                    $id = session()->get('product_id');
                    $freelancer = session()->get('course_seller');
                    // DB::table('orders')->insert(
                    //     ['user_id' => $user_id, 'product_id'=>$id,'type'=>'course','cource_product_id' => $id, 'invoice_id' => $invoice_id, 'status' => 'pending', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
                    // );
                    $course = Cource::find($id);
                    $course->users()->attach(Auth::user()->id, ['type' => 'employer', 'status' => 'waiting', 'seller_id' => $freelancer, 'paid' => 'pending','invoice_id' => $invoice_id,]);
                    $course->save();
                    // send message to freelancer
                    $message = new Message();
                    $user = User::find(intval(Auth::user()->id));
                    $message->user()->associate($user);
                    $message->receiver_id = intval($freelancer);
                    $message->body = Helper::getUserName(Auth::user()->id) . ' ' . trans('lang.course_purchase') . ' ' . $course->title." thorugh Paypal";
                    $message->status = 0;
                    $message->save();
                    // send mail
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $email_params = array();
                        $template_data=(object)array();
                        $template_data->content = Helper::getFreelancerNewCourseOrderEmailContent();
                        $template_data->subject = "Course Order";
                      
                        $email_params['title'] = $course->title;
                        $email_params['course_link'] = url('course/' . $course->slug);
                        $email_params['amount'] = $course->price;
                        $email_params['freelancer_name'] = Helper::getUserName($freelancer);
                        $email_params['employer_profile'] = url('profile/' . $user->slug);
                        $email_params['employer_name'] = Helper::getUserName($user->id);
                        $email_params['payment_mode']="paypal";
                        $freelancer_data = User::find(intval($freelancer));
                        Mail::to($freelancer_data->email)
                            ->send(
                                new FreelancerEmailMailable(
                                    'freelancer_email_new_course_order',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
                //
                else {
                    
                    $id = session()->get('product_id');
                    $proposal = Proposal::find($id);
                    $proposal->hired = 1;
                    $proposal->status = 'hired';
                    $proposal->paid = 'pending';
                    $proposal->save();
                    $job = Job::find($proposal->job->id);
                    $job->status = 'hired';
                    $job->hired_date = date("Y-m-d H:i:s");
                    $job->save();

                    // Wallet Created credit history start
                    if($job->project_type == "hourly")
                    {
                        $wallet_data = array(
                            "type" => "credit",
                            "job_id" => $job->id,
                            "employer_id" => Auth::user()->id,
                            "freelancer_id" => 0,
                            "description" => "Intiallly Employeer First Week Amount",
                            "amount" => $cart['total'],
                            "wallet_type" => "employer"   
                        );
                        Wallet::createentry($wallet_data);
                    } 
                    // Wallet Created credit history end

                    // send message to freelancer
                    $message = new Message();
                    $user = User::find(intval(Auth::user()->id));
                    $message->user()->associate($user);
                    $message->receiver_id = intval($proposal->freelancer_id);
                    $message->body = trans('lang.hire_for') . ' ' . $job->title . ' ' . trans('lang.project');
                    $message->status = 0;
                    $message->save();
                    // send mail
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $freelancer = User::find($proposal->freelancer_id);
                        $employer = User::find($job->user_id);
                        if (!empty($freelancer->email)) {
                            $email_params = array();
                            $template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_hire_freelancer')->get()->first();
                            if (!empty($template->id)) {
                                $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                                $email_params['project_title'] = $job->title;
                                $email_params['hired_project_link'] = url('job/' . $job->slug);
                                $email_params['name'] = Helper::getUserName($freelancer->id);
                                $email_params['link'] = url('profile/' . $freelancer->slug);
                                $email_params['employer_profile'] = url('profile/' . $employer->slug);
                                $email_params['emp_name'] = Helper::getUserName($employer->id);
                                Mail::to($freelancer->email)
                                    ->send(
                                        new FreelancerEmailMailable(
                                            'freelancer_email_hire_freelancer',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                               }
                           }
                        }
                    }
                }
            }
        }


        session()->forget('product_id');
        session()->forget('product_title');
        session()->forget('product_price');
        session()->forget('custom_order_id');
        return $invoice;
    
    }

    //Checkout Start
    public function getHourlyExpressCheckout(Request $request)
    {
        $settings = SiteManagement::getMetaValue('payment_settings');
        $payment_mode = !empty($settings) && !empty($settings[0]['enable_sandbox']) ? $settings[0]['enable_sandbox'] : 'false';
        if ($payment_mode == 'true') {
            if (empty(env('PAYPAL_SANDBOX_API_USERNAME'))
                && empty(env('PAYPAL_SANDBOX_API_PASSWORD'))
                && empty(env('PAYPAL_SANDBOX_API_SECRET'))
            ) {
                Session::flash('error', trans('lang.paypal_empty_credentials'));
                return Redirect::back();
            }
        } elseif ($payment_mode == 'false') {
            if (empty(env('PAYPAL_LIVE_API_USERNAME'))
                && empty(env('PAYPAL_LIVE_API_PASSWORD'))
                && empty(env('PAYPAL_LIVE_API_SECRET'))
            ) {
                Session::flash('error', trans('lang.paypal_empty_credentials'));
                return Redirect::back();
            }
        }

        $settings = SiteManagement::getMetaValue('commision');
        $currency = !empty($settings[0]['currency']) ? $settings[0]['currency'] : 'USD';
        if (Auth::user()) {
            //$recurring = ($request->get('mode') === 'recurring') ? true : false;
            $recurring = false;
            $success = true;
            
            $cart = $this->getHourlyCheckoutData($recurring, $success);
            
            
            $payment_detail = array();
            
            try {
                $response = $this->provider->setCurrency($currency)->setExpressCheckout($cart, $recurring);
                
                if ($response['ACK'] == 'Failure') {
                    Session::flash('error', $response['L_LONGMESSAGE0']);
                    return Redirect::back();
                }
                return redirect($response['paypal_link']);
            } catch (\Exception $e) {
                $invoice = $this->createInvoice($cart, 'Invalid', $payment_detail);

                session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
            }
        } else {
            abort(404);
        }
    }
    protected function getHourlyCheckoutData($recurring, $success)
    {
        if (Auth::user()) {

            if (session()->has('product_id')) {

                $data = [];
                $id = session()->get('product_id');
                $title = session()->get('product_title');
                //$price = session()->get('product_price');
                $price = (float) round(session()->get('amount'));
                $user_id = Auth::user()->id;
                $settings = SiteManagement::getMetaValue('commision');
                $currency = !empty($settings[0]['currency']) ? $settings[0]['currency'] : 'USD';
               
                if ($success == true) {
                    DB::table('orders')->insert(
                        ['user_id' => $user_id, 'product_id' => $id, 'invoice_id' => null, 'status' => 'pending', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
                    );
                    $order_id = DB::getPdo()->lastInsertId();

                    session()->put(['custom_order_id' => $order_id]);
                    
                    $data['order_id'] = $order_id;
                }
                $random_number = Helper::generateRandomCode(4);
                $unique_code = strtoupper($random_number);
                
                $order_id = Invoice::all()->count() + 1;
                if ($recurring === true) {
                    $data['items'] = [
                        [
                            'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $order_id,
                            'price' => 0,
                            'qty' => 1,
                        ],
                    ];
                    $data['return_url'] = url('/paypal/ec-hourly-checkout-success?mode=recurring');
                    $data['subscription_desc'] = 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $order_id;
                } else {
                    $data['items'] = [
                        [
                            'product_id' => $id,
                            'subscriber_id' => $user_id,
                            'name' => $title,
                            'price' => $price,
                            'qty' => 1,
                            'currency_code' => $currency,
                        ],

                    ];
                    $data['return_url'] = url('/paypal/ec-hourly-checkout-success');
                }

                $data['invoice_id'] = config('paypal.invoice_prefix') . '_' . $unique_code . '_' . $order_id;
                $data['invoice_description'] = "Order #$order_id Invoice";
                $data['cancel_url'] = url('/');
                $total = 0;
                // foreach ($data['items'] as $item) {
                //     $total += $item['price'] * $item['qty'];
                // }
                //$data['total'] = $total;
                $data['total'] = (float) round(session()->get('amount'));

                $settings = SiteManagement::getMetaValue('commision');
                if(!empty($settings) && !empty($settings[0]['commision']))
                {
                    $commision_amount = ($settings[0]['commision']/100)*$data['total'];
                    $data['total'] = $data['total'] + $commision_amount;
                    $data['items'][0]['price'] = $data['total'];
                }
                return $data;
            } else {
                abort(404);
            }
        } else {
            Session::flash('message', trans('lang.product_id_not_found'));
            return Redirect::to('/');
        }
    }
    protected function getHourlyExpressCheckoutSuccess(Request $request)
    {
        if (Auth::user()) {
            //$recurring = ($request->get('mode') === 'recurring') ? true : false;
            $recurring = false;
            $token = $request->get('token');
            $PayerID = $request->get('PayerID');
            $success = true;

            $cart = $this->getCheckoutData($recurring, $success);
            
            // Verify Express Checkout Token
            $response = $this->provider->getExpressCheckoutDetails($token);
            if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

                if ($recurring === true) {
                    $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cart['subscription_desc']);
                    if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                        $status = 'Processed';
                    } else {
                        $status = 'Invalid';
                    }
                } else {
                    // Perform transaction on PayPal
                    $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                    if ($payment_status['ACK'] == 'Failure') {
                        Session::flash('error', $response['L_LONGMESSAGE0']);
                        return Redirect::back();
                    }
                    $status = !empty($payment_status['PAYMENTINFO_0_PAYMENTSTATUS']) ? $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'] : 'Processed';
                }
                $payment_detail = array();
                $payment_detail['payer_name'] = $response['FIRSTNAME'] . " " . $response['LASTNAME'];
                $payment_detail['payer_email'] = $response['EMAIL'];
                $payment_detail['seller_email'] = !empty($response['PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID']) ? $response['PAYMENTREQUEST_0_SELLERPAYPALACCOUNTID'] : '';
                $payment_detail['currency_code'] = $response['CURRENCYCODE'];
                $payment_detail['payer_status'] = $response['PAYERSTATUS'];
                $payment_detail['transaction_id'] = !empty($payment_status['PAYMENTINFO_0_TRANSACTIONID']) ? $payment_status['PAYMENTINFO_0_TRANSACTIONID'] : '';
                $payment_detail['sales_tax'] = $response['TAXAMT'];
                $payment_detail['invoice_id'] = $response['INVNUM'];
                $payment_detail['shipping_amount'] = $response['SHIPPINGAMT'];
                $payment_detail['handling_amount'] = $response['HANDLINGAMT'];
                $payment_detail['insurance_amount'] = $response['INSURANCEAMT'];
                $payment_detail['paypal_fee'] = !empty($payment_status['PAYMENTINFO_0_FEEAMT']) ? $payment_status['PAYMENTINFO_0_FEEAMT'] : '';
                $payment_detail['payment_date'] = $payment_status['TIMESTAMP'];
                $payment_detail['product_qty'] = $cart['items'][0]['qty'];

                $invoice = $this->createHourlyInvoice($cart, $status, $payment_detail);
                

                //Order Table invoice id update Start
                DB::table('orders')
                    ->where('id', $cart['order_id'])
                    ->update(['invoice_id' => $invoice->id,'type' => $invoice->type]);
                //Order Table invoice id update End 
                
                // print_r("here");
                // exit();
                if ($invoice->paid) {
                    session()->put(['code' => 'success', 'message' => "Thank you for your subscription"]);
                } else {
                    session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
                }
                return redirect('paypal/redirect-url');
            } else {
                abort(404);
            }
        }
    }
    
    protected function createHourlyInvoice($cart, $status, $payment_detail)
    {
        //create invoice
        $invoice = new Invoice();
        $invoice->title = filter_var($cart['invoice_description'], FILTER_SANITIZE_STRING);
        $invoice->price = $cart['total'];
        $invoice->payer_name = filter_var($payment_detail['payer_name'], FILTER_SANITIZE_STRING);
        $invoice->payer_email = filter_var($payment_detail['payer_email'], FILTER_SANITIZE_EMAIL);
        $invoice->seller_email = filter_var($payment_detail['seller_email'], FILTER_SANITIZE_EMAIL);
        $invoice->currency_code = filter_var($payment_detail['currency_code'], FILTER_SANITIZE_STRING);
        $invoice->payer_status = filter_var($payment_detail['payer_status'], FILTER_SANITIZE_STRING);
        $invoice->transaction_id = filter_var($payment_detail['transaction_id'], FILTER_SANITIZE_STRING);
        $invoice->invoice_id = filter_var($payment_detail['invoice_id'], FILTER_SANITIZE_STRING);
        $invoice->shipping_amount = $payment_detail['shipping_amount'];
        $invoice->handling_amount = $payment_detail['handling_amount'];
        $invoice->insurance_amount = $payment_detail['insurance_amount'];
        $invoice->sales_tax = 0;
        $invoice->payment_mode = filter_var('paypal', FILTER_SANITIZE_STRING);
        $invoice->paypal_fee = !empty($payment_detail['paypal_fee']) ? $payment_detail['paypal_fee'] : 0;        
        if (!strcasecmp($status, 'completed') || !strcasecmp($status, 'Processed')) {
            $invoice->paid = 1;
        } else {
            $invoice->paid = 0;
        }
        $product_type = session()->get('type');
        $invoice->type = $product_type;
        $invoice->save();
        $invoice_id = DB::getPdo()->lastInsertId();
        // create item
        collect(
            $cart['items']
        )->each(
            function ($product) use ($invoice) {
                $product_type = session()->get('type');
                $product_price = $invoice->price - $invoice->sales_tax;
                if ($product_type == 'package') {
                    $item = DB::table('items')->select('id')->where('subscriber', $product['subscriber_id'])->first();
                    if (!empty($item)) {
                        $item = Item::find($item->id);
                    } else {
                        $item = new Item();
                    }
                } else {
                    $item = new Item();
                }
                $item->invoice_id = filter_var($invoice->id, FILTER_SANITIZE_NUMBER_INT);
                $item->product_id = filter_var($product['product_id'], FILTER_SANITIZE_NUMBER_INT);
                $item->subscriber = $product['subscriber_id'];
                $item->item_name = filter_var($product['name'], FILTER_SANITIZE_STRING);
                $item->item_price = $product_price;
                $item->item_qty = filter_var($product['qty'], FILTER_SANITIZE_NUMBER_INT);
                $item->save();
                $last_order_id = session()->get('custom_order_id');
               
                DB::table('orders')
                    ->where('id', $last_order_id)
                    ->update(['status' => 'completed']);
            }
        );
        if (Auth::user()) {
            if ($product_type == 'project') {
                    $id = session()->get('product_id');
                    $proposal = Proposal::find($id);
                    $job = Job::find($proposal->job->id);
                    if(session()->get('is_whole_checkout_amount'))
                    {
                        $total_job_wallet_amount = 0;
                    }
                    else
                    {
                        //Debit Wallet Entry
                        
                        /* Wallet Amount Show Work Start */
                        $user_id = Auth::user()->id;
                        $total_job_wallet_amount =  Wallet::where('job_id', $job->id)->where('employer_id', $user_id)->sum('amount');

                        /* Wallet Amount Show Work End */

                        //Wallet Created credit history start
                        if($job->project_type == "hourly")
                        {
                            $wallet_data = array(
                                "type" => "debit",
                                "job_id" => $job->id,
                                "employer_id" => $user_id,
                                "freelancer_id" => 0,
                                "description" => "Employeer Week Amount",
                                "amount" => -$total_job_wallet_amount,
                                "wallet_type" => "employer"   
                            );
                            Wallet::createentry($wallet_data);
                        } 
                        //Wallet Created credit history end  
                    }
                    //status change Start
                    $start_date = session()->get('start_date');
                    $end_date = session()->get('end_date');
                    $bill_hours = WorkDiary::where('status', 'submitted')->whereBetween('date', [$start_date, $end_date])->where('project_id', $job->id)->orderBy('WeekDay','ASC')->get()->toArray();
                    if(!empty($bill_hours))
                    {
                        foreach ($bill_hours as $key => $bill) 
                        {
                            $stauts_change = WorkDiary::where('id', $bill['id'])->where('status','submitted')->update(array ('status' => 'paid'));
                        }
                    }
                    //status change End

                    //Payout Entry Admin to freelance start
                    $work_diaries_ids = implode(",",array_column($bill_hours, 'id'));
                    
                    $payout_data = array(
                            "job_id" => $job->id,
                            "freelance_id" => $proposal->freelancer_id,
                            "start_date" => $start_date,
                            "end_date" => $end_date,
                            "work_diaries_ids" => $work_diaries_ids,
                            "amount" => session()->get('amount')+ $total_job_wallet_amount  
                    );
                    HourlyJobPayOut::createentry($payout_data);
                     //Payout Entry Admin to freelance end

            }
        }
        session()->forget('product_id');
        session()->forget('product_title');
        session()->forget('product_price');
        session()->forget('custom_order_id');
        session()->forget('start_date');
        session()->forget('end_date');
        session()->forget('is_whole_checkout_amount');
        return $invoice;
    
    }
    //Checkout Stop

    // public function Refund($transaction_id){

    //     $response = $this->provider->RefundTransaction($transaction_id);
    // }
}
