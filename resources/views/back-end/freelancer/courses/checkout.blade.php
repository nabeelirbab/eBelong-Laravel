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
                                                <a href="javascrip:void(0);" onclick="getStripe()">
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
                                           <div class="d-none p-3 mt-5" id="stripForm">
                                            <form class="wt-formtheme wt-form-paycard" id="payment-form">
                                                {{ csrf_field() }}
                                                <fieldset>
                                                    <div class="form-group sj-checkpaymentmethod ">
                                                        <div  class="sj-title">
                                                            <h3>Payment Details</h3>
                                                        </div>
                                                        
                                                        <div id="payment-element"></div>
                                                    </div>
                                                    <div class="form-group wt-btnarea">
                                                        <button id="submit" class="wt-btn">
                                                            <span id="button-text">Pay {{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{ $cost }}</span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endsection
                @push('stripe')
                <script src="https://js.stripe.com/v3/"></script>
                <script>
                    function getStripe() {
                        $('#stripForm').toggleClass('d-none d-block');
                    }
                
                    var clientSecret = "{{ $clientSecret }}";
                
                    
                    const stripe = Stripe("pk_test_0zHy4tW3x7acahwgalGNESFq");

                        // Passing the clientSecret while creating the elements group
                        const elements = stripe.elements({ clientSecret });

                        const paymentElementOptions = {
                            layout: "tabs",
                        };

                        const paymentElement = elements.create("payment", paymentElementOptions);
                        paymentElement.mount("#payment-element");
                
                    document.querySelector("#payment-form").addEventListener("submit", async (e) => {
                        e.preventDefault();
                
                        const { error } = await stripe.confirmPayment({
                            elements,
                            confirmParams: {
                                client_secret: clientSecret,  // This should be the client secret from your payment intent.
                                receipt_email: 'peeknabeel@gmail.com',
                                return_url: "{{ url('addmoney/stripe')}}"
                            },
                        });
                                    
                        if (error) {
                            alert(error.message);
                        } else {
                            alert('dsds');
                            postPaymentWithStripe();
                        }
                    });
                
                    function postPaymentWithStripe() {
                        fetch("/addmoney/stripe", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"  // For Laravel CSRF protection
                            },
                            body: JSON.stringify({
                                clientSecret: clientSecret
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Payment successful!");
                            } else {
                                alert(data.message || "Payment failed.");
                            }
                        })
                        .catch(error => {
                            alert("There was an error processing the payment.");
                        });
                    }
                </script>
                @endpush
                
                