@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
@php
    $defaultAmount = $course->price; // Set your default amount here
    $encryptedAmount = Crypt::encrypt($defaultAmount);
    $stripePaymentUrl = "stripe-order?amount=$encryptedAmount"; // Adjust with your actual Stripe URL
@endphp
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
                                        <td><span id="total_amount">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$cost}}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Discount:</td>
                                        <td><span id="discount_amount">$0</span></td>
                                    </tr>
                                    <tr>
                                        <td>Sub Total:</td>
                                        <td><span id="final_amount">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$cost}}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('lang.status') }}</td>
                                        <td>{{ trans('lang.pending') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                              {{-- Coupon Application Section --}}
                                   
                                <div class="row mt-5">
                                    <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Enter coupon code">
                                    </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group wt-btnarea">
                                        <button type="button" class="wt-btn" id="apply_coupon">Apply coupon</button>
                                    </div>
                                    </div>
                                </div>
                                <div class="sj-checkpaymentmethod">
                                    <div class="sj-title">
                                        <h3>{{ trans('lang.select_pay_method') }}</h3>
                                    </div>
                                    <ul class="sj-paymentmethod">
                                       @foreach ($payment_methods as $key => $payment_method)
                                       @if($payment_method == 'paypal')
                                        <li>
                                        <a href="{{url('paypal/ec-checkout')}}">
                                        <i class="fa fa-paypal"></i>
                                        <span><em>{{ trans('lang.pay_amount_via') }}</em> {{ Helper::getPaymentMethodList($payment_method)['title']}} {{ trans('lang.pay_gateway') }}</span>
                                        </a>
                                        </li>
                                        @endif
                                        @if($payment_method == 'stripe')
                                            <li>
                                                <a id="stripe_payment_link" href="{{ $stripePaymentUrl }}">
                                                     <i class="fab fa-stripe-s"></i>
                                                    {{-- <img src="http://ec2-52-87-199-242.compute-1.amazonaws.com/images/credit-card.png" alt="credit-card" style="width:70px; height:48px"> --}}
                                                    <span><em>{{ trans('lang.pay_amount_via') }}</em> {{ Helper::getPaymentMethodList("stripe")['title']}} {{ trans('lang.pay_gateway') }}</span>
                                                </a>
                                            </li>
                                            @endif
                                           @if($payment_method == 'banktransfar')
                                            <li>
                                                <a href="javascrip:void(0);" v-on:click.prevent="submitBankOrder">
                                                    <i class="fas fa-university"></i>
                                                    <span><em>{{ trans('lang.pay_amount_via') }}</em> {{ Helper::getPaymentMethodList("banktransfar")['title']}}</span>
                                                </a>
                                            </li>
                                             @endif
                                           @endforeach
                                         
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endsection
            @push('stripe')
            <script>
                document.getElementById('apply_coupon').addEventListener('click', function() {
                    var couponCode = document.getElementById('coupon_code').value;
                    var originalAmount = document.getElementById('total_amount').textContent; // Assuming this is the element with the original amount
            
                    fetch('{{ url('apply-coupon') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            coupon_code: couponCode,
                            original_amount: originalAmount 
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('coupon_code').value = "";
                            document.getElementById('discount_amount').textContent = '$'+data.discount;
                            document.getElementById('final_amount').textContent = '$'+ data.newAmount;
            
                            // Update the Stripe payment link with the new amount and coupon code
                            var stripeUrl = `stripe-order?amount=${data.encryptedAmount}`;
                            document.getElementById('stripe_payment_link').href = stripeUrl;
                        } else {
                            // Handle error or invalid coupon
                            alert(data.error);
                        }
                    });
                });
            </script>
            
            @endpush                
                