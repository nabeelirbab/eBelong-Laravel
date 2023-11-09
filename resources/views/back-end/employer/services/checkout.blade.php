@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class=" col-sm-12 col-md-12 col-lg-10 push-lg-1 col-xl-8 push-xl-2" id="packages">
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
                        <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ str_replace("'s", " ",Session::get('error')) }}}'" v-cloak></flash_messages>
                    </div>
                    @php session()->forget('error') @endphp;
                @endif
                <div class="sj-checkoutjournal">
                    <div class="sj-title">
                        <h3>{{{trans('lang.checkout')}}}</h3>
                    </div>
                    @php
                        session()->put(['product_id' => e($service->id)]);
                        session()->put(['product_title' => e($service->title)]);
                        session()->put(['product_price' => e($service->price)]);
                        session()->put(['type' => 'project']);
                        session()->put(['project_type' => 'service']);
                        session()->put(['service_seller' => $freelancer->id]);
                    @endphp
                    <table class="sj-checkouttable">
                        <thead>
                            <tr>
                                <th>{{trans('lang.item_title')}}</th>
                                <th>{{trans('lang.details')}}</th>
                            </tr>
                        </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="sj-producttitle">
                                            <div class="sj-checkpaydetails">
                                                @if (!empty($service->title))
                                                    <h4>{{{$service->title}}}</h4>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$service->price}}} </td>
                                </tr>
                                <tr>
                                    <td>Commission</td>
                                     <td>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }} {{{$commision_amount }}} </td>
                                </tr>
                                <tr>
                                    <td>{{ trans('lang.freelancer') }}</td>
                                    <td>{{{ $freelancer_name }}}</td>
                                </tr>
                                <!--<tr>
                                    <td>{{ trans('lang.total') }}</td>
                                    <td>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$service->price}}}</td>
                                </tr> -->
                                <tr>
                                    <td>{{ trans('lang.total') }}</td>
                                    <td>{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }} {{{ $total_amount }}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if (!empty($payment_gateway))
                        <div class="sj-checkpaymentmethod">
                            <div class="sj-title">
                                <h3>{{ trans('lang.select_pay_method') }}</h3>
                            </div>
                            <ul class="sj-paymentmethod">
                                @foreach ($payment_gateway as $gatway)
                                    <li>
                                        @if ($gatway == "paypal")
                                            <a href="{{{url('paypal/ec-checkout')}}}">
                                                <i class="fa fa-paypal"></i>
                                                <span><em>{{ trans('lang.pay_amount_via') }}</em> {{ Helper::getPaymentMethodList($gatway)['title']}} {{ trans('lang.pay_gateway') }}</span>
                                            </a>
                                        @elseif ($gatway == "stripe")
                                            <a href="javascrip:void(0);" onclick="getStripe()">
                                                <i class="fab fa-stripe-s"></i>
                                                <span><em>{{ trans('lang.pay_amount_via') }}</em> {{ Helper::getPaymentMethodList($gatway)['title']}} {{ trans('lang.pay_gateway') }}</span>
                                            </a>
                                        @endif
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    @endif
                </div>
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
                                    <span id="button-text">Pay {{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{ $service->price }}</span>
                                </button>
                            </div>
                        </fieldset>
                    </form>
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
