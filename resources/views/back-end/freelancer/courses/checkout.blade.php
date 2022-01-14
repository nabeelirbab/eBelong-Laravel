@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class=" col-12 col-xl-8" id="packages">
                <div class="preloader-section" v-if="loading" v-cloak>
                    <div class="preloader-holder">
                        <div class="loader"></div>
                    </div>
                </div>
                <div class="wt-dashboardbox">
                    @if (Session::has('message'))
                        <div class="flash_msg">
                            <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                        </div>
                        @php session()->forget('message') @endphp;
                    @elseif (Session::has('error'))
                        <div class="flash_msg">
                            <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ str_replace("'s", " ", Session::get('error')) }}}'" v-cloak></flash_messages>
                        </div>
                        @php session()->forget('error'); @endphp
                    @endif
                    <div class="sj-checkoutjournal">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{{trans('lang.order')}}}</h2>
                        </div>
                        @php
                        session()->put(['product_id' => e($course->id)]);
                        session()->put(['product_title' => e($course->title)]);
                        session()->put(['product_price' => e($course->price)]);
                        session()->put(['type' => 'project']);
                        session()->put(['project_type' => 'course']);
                        session()->put(['course_seller' => $freelancer->id]);
                        @endphp
                        <div class="wt-dashboardboxcontent wt-oderholder">
                            <table class="sj-checkouttable wt-ordertable">
                                <thead>
                                    <tr>
                                        <th>{{ trans('lang.item_title') }}</th>
                                    <th>{{trans('lang.details')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="sj-producttitle">
                                                <div class="sj-checkpaydetails">
                                                    <h4>{{{$title}}}</h4>
                                                    @if (!empty($subtitle))
                                                        <span>{{{$subtitle}}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$cost}}}</td>
                                    </tr>
                                    @if (!empty($options))
                                        <tr>
                                            <td>{{ trans('lang.duration') }}</td>
                                            <td>{{{Helper::getPackageDurationList($options['duration'])}}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>{{ trans('lang.total') }}</td>
                                        <td>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$cost}}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('lang.status') }}</td>
                                        <td>{{ trans('lang.pending') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                                <div class="sj-checkpaymentmethod">
                                    <div class="sj-title">
                                        <h3>{{ trans('lang.select_pay_method') }}</h3>
                                    </div>
                                    <ul class="sj-paymentmethod">
                                            <li>
                                                <a href="{{{url('paypal/ec-checkout')}}}">
                                                    <i class="fa fa-paypal"></i>
                                                    <span><em>{{ trans('lang.pay_amount_via') }}</em> {{ Helper::getPaymentMethodList("paypal")['title']}} {{ trans('lang.pay_gateway') }}</span>
                                                </a>
                                                </li>
                                                <li>
                                                <a href="javascrip:void(0);" v-on:click.prevent="getStriprForm">
                                                    <!--  <i class="fab fa-stripe-s"></i> -->
                                                    {{-- <img src="http://ec2-52-87-199-242.compute-1.amazonaws.com/images/credit-card.png" alt="credit-card" style="width:70px; height:48px"> --}}
                                                    <span><em>{{ trans('lang.pay_amount_via') }}</em> {{ Helper::getPaymentMethodList("stripe")['title']}} {{ trans('lang.pay_gateway') }}</span>
                                                </a>
                                            </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                    <b-modal ref="myModalRef" hide-footer title="Pay by Credit Card" class="la-pay-stripe" :no-close-on-backdrop="true">
                                <div class="d-block text-center">
                                    <form class="wt-formtheme wt-form-paycard" method="POST" id="stripe-payment-form" role="form" action="" @submit.prevent='submitStripeFrom'>
                                        {{ csrf_field() }}
                                        <fieldset>
                                            <div class="form-group wt-inputwithicon {{ $errors->has('card_no') ? ' has-error' : '' }}">
                                                <label>{{ trans('lang.card_no') }}</label>
                                                <img src="{{asset('images/pay-icon.png')}}">
                                                <input id="card_no" type="text" class="form-control" name="card_no" value="{{ old('card_no') }}" autofocus>
                                                @if ($errors->has('card_no'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('card_no') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('ccExpiryMonth') ? ' has-error' : '' }}">
                                                <label>{{ trans('lang.expiry_month') }}</label>
                                                <input id="ccExpiryMonth" type="number" class="form-control" name="ccExpiryMonth" value="{{ old('ccExpiryMonth') }}" min="1" max="12" autofocus>
                                                @if ($errors->has('ccExpiryMonth'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('ccExpiryMonth') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('ccExpiryYear') ? ' has-error' : '' }}">
                                                <label>{{ trans('lang.expiry_year') }}</label>
                                                <input id="ccExpiryYear" type="text" class="form-control" name="ccExpiryYear" value="{{ old('ccExpiryYear') }}" autofocus>
                                                @if ($errors->has('ccExpiryYear'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('ccExpiryYear') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group wt-inputwithicon {{ $errors->has('cvvNumber') ? ' has-error' : '' }}">
                                                <label>{{ trans('lang.cvc_no') }}</label>
                                                <img src="{{asset('images/pay-img.png')}}">
                                                <input id="cvvNumber" type="number" class="form-control" name="cvvNumber" value="{{ old('cvvNumber') }}" autofocus>
                                                @if ($errors->has('cvvNumber'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('cvvNumber') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group wt-btnarea">
                                                <input type="submit" name="button" class="wt-btn" value="Pay {{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{ $cost }}">
                                            </div>
                                        </fieldset>
                                    </form>
                                </b-modal>

                                    
                                
                            </div>
                        </div>
                    </section>
                @endsection