<?php

/**
 * Class StripeController
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @version <PHP: 1.0.0>
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\User;
use App\Cource;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
use App\Proposal;
use App\Job;
use Auth;
use App\Invoice;
use DB;
use App\Package;
use Illuminate\Support\Facades\Mail;
use App\EmailTemplate;
use App\Mail\FreelancerEmailMailable;
use App\Mail\EmployerEmailMailable;
use App\Helper;
use App\Item;
use Carbon\Carbon;
use App\Message;
use App\Service;
use App\SiteManagement;
use App\Wallet;

/**
 * Class StripeController
 *
 */
class StripeController extends Controller
{
    /**
     * Show the application paywith stripe.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithStripe()
    {
        if (file_exists(resource_path('views/extend/back-end/paymentstripe.blade.php'))) {
            return view('extend.back-end.paymentstripe');
        } else {
            return view('back-end.paymentstripe');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithStripe(Request $request)
    {
        Stripe::setApiKey('sk_test_ws2GR8HLb9gMtA9dAyvnclCL');
        $settings = SiteManagement::getMetaValue('commision');
        $stripe_settings = SiteManagement::getMetaValue('stripe_settings');
        $currency = !empty($settings[0]['currency']) ? $settings[0]['currency'] : 'USD';
        $payment_intent_id = $request->input('payment_intent');
        $current_year = Carbon::now()->format('Y');
        if (empty($payment_intent_id)) {
            return response()->json(['type' => 'error', 'message' => 'Payment intent ID is missing.']);
        }

        $product_id = Session::has('product_id') ? session()->get('product_id') : '';
        $product_title = Session::has('product_title') ? session()->get('product_title') : '';
        $product_price = Session::has('product_price') ? session()->get('product_price') : 0;
        $type = Session::has('type') ? session()->get('type') : '';
        $user_id = Auth::user() ? Auth::user()->id : '';

        try {
            $intent = Stripe::paymentIntents()->find($payment_intent_id);
            $payment_detail = $intent['charges']['data'][0];

            $customer = Stripe::customers()->create([
                'email' => Auth::user()->email,
            ]);


            if ($intent['status'] == 'succeeded') {
                $fee = !empty($payment_detail['application_fee_amount']) ? $payment_detail['application_fee_amount'] : 0;
                $invoice = new Invoice();
                $invoice->title = 'Invoice';
                $invoice->price = $product_price;
                $invoice->payer_name = filter_var($customer['name'], FILTER_SANITIZE_STRING);
                $invoice->payer_email = filter_var($customer['email'], FILTER_SANITIZE_EMAIL);
                $invoice->seller_email = 'test@email.com';
                $invoice->currency_code = filter_var($payment_detail['currency'], FILTER_SANITIZE_STRING);
                $invoice->payer_status = '';
                $invoice->transaction_id = filter_var($payment_detail['id'], FILTER_SANITIZE_STRING);
                $invoice->invoice_id = filter_var($payment_detail['source']['id'], FILTER_SANITIZE_STRING);
                $invoice->customer_id = filter_var($customer['id'], FILTER_SANITIZE_STRING);
                $invoice->shipping_amount = 0;
                $invoice->handling_amount = 0;
                $invoice->insurance_amount = 0;
                $invoice->sales_tax = 0;
                $invoice->payment_mode = filter_var('stripe', FILTER_SANITIZE_STRING);
                $invoice->paypal_fee = $fee;
                $invoice->paid = $payment_detail['paid'];
                $product_type = $type;
                $invoice->type = $product_type;
                $invoice->save();
                $invoice_id = DB::getPdo()->lastInsertId();
                if ($type == 'package') {
                    $item = DB::table('items')->select('id')->where('subscriber', $user_id)->first();
                    if (!empty($item)) {
                        $item = Item::find($item->id);
                    } else {
                        $item = new Item();
                    }
                } else {
                    $item = new Item();
                }
                $item->invoice_id = filter_var($invoice_id, FILTER_SANITIZE_NUMBER_INT);
                $item->product_id = filter_var($product_id, FILTER_SANITIZE_NUMBER_INT);
                $item->subscriber = $user_id;
                $item->item_name = filter_var($product_title, FILTER_SANITIZE_STRING);
                $item->item_price = $product_price;
                $item->item_qty = filter_var(1, FILTER_SANITIZE_NUMBER_INT);
                $item->save();

                if (Auth::user()) {
                    if ($product_type == 'package') {

                        $last_order_id = session()->get('custom_order_id');
                        // DB::table('orders')
                        //     ->where('id', $last_order_id)
                        //     ->update(['status' => 'completed']);
                        if ($product_id) {
                            // dd('ddd');
                            $package_item = \App\Item::where('subscriber', Auth::user()->id)->first();
                            $id = session()->get('product_id');
                            $package = \App\Package::find($id);
                            $option = !empty($package->options) ? unserialize($package->options) : '';
                            $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
                            $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
                            $user = \App\User::find(Auth::user()->id);
                            if (!empty($package->badge_id) && $package->badge_id != 0) {
                                $user->badge_id = $package->badge_id;
                            }
                            $user->expiry_date = $expiry_date;
                            $user->save();
                            // send mail
                            if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                                $item = DB::table('items')->where('product_id', $id)->get()->toArray();
                                $package =  Package::where('id', $item[0]->product_id)->first();
                                $user = User::find($item[0]->subscriber);
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
                            $id = session()->get('product_id');
                            $freelancer = session()->get('course_seller');
                            if ($project_type == 'course') {
                                DB::table('orders')->insert(
                                    ['user_id' => $user_id, 'product_id' => $id, 'type' => 'course', 'cource_product_id' => $id, 'invoice_id' => $invoice_id, 'status' => 'pending', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
                                );
                                $course = Cource::find($id);
                                $course->users()->attach(Auth::user()->id, ['type' => 'employer', 'status' => 'waiting', 'seller_id' => $freelancer, 'paid' => 'pending', 'invoice_id' => $invoice_id,]);
                                $course->save();
                                // send message to freelancer
                                $message = new Message();
                                $user = User::find(intval(Auth::user()->id));
                                $message->user()->associate($user);
                                $message->receiver_id = intval($freelancer);
                                $message->body = Helper::getUserName(Auth::user()->id) . ' ' . trans('lang.course_purchase') . ' ' . $course->title . " thorugh Stripe";
                                $message->status = 0;
                                $message->save();
                                // send mail
                                if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                                    $email_params = array();
                                    $template_data = (object)array();
                                    $template_data->content = Helper::getFreelancerNewCourseOrderEmailContent();
                                    $template_data->subject = "Course Order";
                                    $email_params['title'] = $course->title;
                                    $email_params['course_link'] = url('course/' . $course->slug);
                                    $email_params['amount'] = $course->price;
                                    $email_params['freelancer_name'] = Helper::getUserName($freelancer);
                                    $email_params['employer_profile'] = url('profile/' . $user->slug);
                                    $email_params['employer_name'] = Helper::getUserName($user->id);
                                    $email_params['payment_mode'] = "stripe";
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
                            } elseif ($project_type == 'service') {
                                $last_order_id = session()->get('custom_order_id');
                                DB::table('orders')
                                    ->where('id', $last_order_id)
                                    ->update(['status' => 'completed']);
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
                            } else {
                                $id = session()->get('product_id');
                                $user_id = Auth::user()->id;
                                DB::table('orders')->insert(
                                    ['user_id' => $user_id, 'product_id' => $id, 'invoice_id' => $invoice_id, 'type' => 'job', 'status' => 'completed', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
                                );
                                $order_id = DB::getPdo()->lastInsertId();
                                $last_order_id = session()->get('custom_order_id');
                                // DB::table('orders')
                                //     ->where('id', $last_order_id)
                                //     ->update(['status' => 'completed']);
                                $id = session()->get('product_id');
                                $proposal = Proposal::find($id);
                                $proposal->hired = 1;
                                $proposal->status = 'hired';
                                $proposal->paid = 'pending';
                                $proposal->save();
                                $job = Job::find($proposal->job->id);
                                $job->status = 'hired';
                                $job->save();
                                if ($job->project_type == "hourly") {
                                    $wallet_data = array(
                                        "type" => "credit",
                                        "job_id" => $job->id,
                                        "employer_id" => Auth::user()->id,
                                        "freelancer_id" => 0,
                                        "description" => "Intiallly Employeer First Week Amount",
                                        "amount" => $product_price,
                                        "wallet_type" => "employer"
                                    );
                                    Wallet::createentry($wallet_data);
                                }
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
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.money_not_add');
                return $json;
            }
        } catch (Exception $e) {
            $json['type'] = 'error';
            $json['message'] = $e->getMessage();
            return $json;
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            $json['type'] = 'error';
            $json['message'] = $e->getMessage();
            return $json;
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            $json['type'] = 'error';
            $json['message'] = $e->getMessage();
            return $json;
        }

        session()->forget('product_id');
        session()->forget('product_title');
        session()->forget('product_price');
        session()->forget('custom_order_id');
        $project_type = session()->get('project_type');
        if (Auth::user()->getRoleNames()[0] == "employer") {
            if ($type == 'project') {
                if ($project_type == 'service') {
                    $json['url'] = url('employer/services/hired');
                } elseif ($project_type == 'course') {
                    $json['url'] = url('freelancer/course/bought');
                } else {
                    $json['url'] = url('employer/jobs/hired');
                }
                $json['type'] = 'success';
                $json['message'] = trans('lang.freelancer_successfully_hired');
                session()->forget('type');
                return $json;
            } else {
                $json['type'] = 'success';
                $json['message'] = trans('lang.thanks_subscription');
                $json['url'] = url('dashboard/packages/employer');
                session()->forget('type');
                return $json;
            }
        } else if (Auth::user()->getRoleNames()[0] == "freelancer") {
            if ($type == 'project') {
                if ($project_type == 'course') {
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.course_payment_msg');
                    $json['url'] = url('/courses');
                    session()->forget('type');
                    // $response = [];
                    // $response['code'] = 200;
                    // $response['message'] =  trans('lang.course_payment_msg');
                    // Session::flash('payment_message', $response);
                    return redirect('/courses')->with('success', trans('lang.course_payment_msg'));
                } else if ($project_type == 'service') {
                    return redirect('/services');
                } else {

                    $json['type'] = 'success';
                    $json['message'] = trans('lang.thanks_subscription');
                    $json['url'] = url('dashboard/packages/freelancer');
                    session()->forget('type');
                    return $json;
                }
            }
        }
    }
}
