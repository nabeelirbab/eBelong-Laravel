@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<section class="wt-haslayout wt-dbsectionspace">
    <div class="row d-flex justify-content-center">
        <div class=" col-12 col-xl-8" id="packages">
            <div class="preloader-section" v-if="loading" v-cloak>
                <div class="preloader-holder">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="wt-dashboardbox">
                @if (Session::has('message'))
                <div class="flash_msg">
                    <flash_messages :message_class="'success'" :time='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                </div>
                @php session()->forget('message') @endphp;
                @elseif (Session::has('error'))
                <div class="flash_msg">
                    <flash_messages :message_class="'danger'" :time='5' :message="'{{{ str_replace("'s", " ", Session::get('error')) }}}'" v-cloak></flash_messages>
                </div>
                @php session()->forget('error'); @endphp
                @endif
                <div class="sj-checkoutjournal">
                  
                    <div class="wt-dashboardboxcontent wt-oderholder">

                        <div class="sj-checkpaymentmethod">
                           
                            <div class=" p-3 mt-5">
                                <form class="wt-formtheme wt-form-paycard" id="payment-form">
                                    {{ csrf_field() }}
                                    <fieldset>
                                        <div class="form-group sj-checkpaymentmethod ">
                                            <div class="sj-title">
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

    var clientSecret = "{{ $clientSecret }}";


    const stripe = Stripe("pk_test_0zHy4tW3x7acahwgalGNESFq");

    // Passing the clientSecret while creating the elements group
    const elements = stripe.elements({
        clientSecret
    });

    const paymentElementOptions = {
        layout: "tabs",
    };

    const paymentElement = elements.create("payment", paymentElementOptions);
    paymentElement.mount("#payment-element");

    document.querySelector("#payment-form").addEventListener("submit", async (e) => {
        e.preventDefault();

        const {
            error
        } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                client_secret: clientSecret, // This should be the client secret from your payment intent.
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
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // For Laravel CSRF protection
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