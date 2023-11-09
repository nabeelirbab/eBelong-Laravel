@extends('back-end.master') // Adjusted for simplification
@section('content')
<div class="coupons-listing" id="coupon-list">
    @if (Session::has('message'))
        <div class="flash_msg">
            <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
        </div>
    @elseif (Session::has('error'))
        <div class="flash_msg">
            <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
        </div>
    @endif
        <section class="wt-haslayout wt-dbsectionspace la-editcoupon">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>Edit Coupon</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            {{-- Update the action URL to use resource route --}}
                            {!! Form::model($coupon, ['route' => ['coupons.update', $coupon->id], 'method' => 'put', 'class' =>'wt-formtheme wt-formprojectinfo wt-formcoupon']) !!}
                                <fieldset>
                                    {{-- Coupon Fields --}}
                                    <div class="form-group">
                                        {!! Form::text('code', null, ['class' =>'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::select('type', ['fixed' => 'Fixed', 'percentage' => 'Percentage'], null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::number('value', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::date('expires_at', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group wt-btnarea">
                                        {!! Form::submit('Update Coupon', ['class' => 'wt-btn']) !!}
                                    </div>
                                </fieldset>
                            {!! Form::close(); !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
